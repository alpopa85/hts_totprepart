<?php

namespace App\Model;

use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class AnalysisEngine
{
    const VWC = "VOLUMETRIC_WATER_CONTENT";
    const VWC_REQ_FIELDS = ['sm'];
    const VWC_OUTPUT_FIELD = 'vwc';

    const MM_H20 = "TOTAL WATER VOLUME IN SOIL";
    const MM_H20_REQ_FIELDS = ['sm'];
    const MM_H20_OUTPUT_FIELD = 'mm_h20';

    const WCHG = "CHANGE IN TOTAL VOLUME OF WATER";
    const WCHG_REQ_FIELDS = [];    
    const WCHG_OUTPUT_FIELD_GAIN = 'wchg_gain';
    const WCHG_OUTPUT_FIELD_LOSS = 'wchg_loss';

    const WB = "WATER BALANCE";
    const WB_REQ_FIELDS = ['precip', 'et'];
    const WB_OUTPUT_FIELD_ET_LOST = 'et_lost';
    const WB_OUTPUT_FIELD_ET_SOIL = 'et_soil';
    const WB_OUTPUT_FIELD_DRAIN = 'drain';
    const WB_OUTPUT_FIELD_INFILTRATION = 'inf';
    const WB_OUTPUT_FIELD_SR = 'sr';
    const WB_DEFAULT_SR_WINDOW_SIZE = 4;    

    private $dataset;
    private $chain;
    private $params;
    private $requiredInputFields;
    private $requiredInputData;

    private $outputDataTable;

    public function __construct($chain)
    {
        $this->dataset = Utils::getCurrentDataset();
        $this->chain = $chain;      
        $this->params = $this->getRequiredParams();
        
        $this->outputDataTable = TableRegistry::getTableLocator()->get('WaterBalanceData');        
    }

    private function setRequiredInputFieldNames()
    {
        $requiredFields = [ // need these fields from input ALWAYS
            'time_index',
            'time_name',
            'time_date',
            'time_day',
            'time_month',
            'time_year'
        ];         

        foreach ($this->chain as $method){
            switch($method){
                case self::VWC:
                    $requiredFields = array_merge($requiredFields, self::VWC_REQ_FIELDS);
                    break;
                case self::MM_H20:
                    $requiredFields = array_merge($requiredFields, self::MM_H20_REQ_FIELDS);
                    break;
                case self::WCHG:
                    $requiredFields = array_merge($requiredFields, self::WCHG_REQ_FIELDS);
                    break;
                case self::WB:
                    $requiredFields = array_merge($requiredFields, self::WB_REQ_FIELDS);
                    break;
            }
        }

        return $requiredFields;
    }

    private function getRequiredInputData()
    {
        // get inputs
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        $query = $inputDataTable->find('all',[
            'fields' => $this->requiredInputFields
        ]);
        $query->where(['dataset' => $this->dataset]);        
        $query->order('time_index ASC');             
        $inputData = $query->all();

        return $inputData;
    }

    private function getOutputTableData($index)
    {
        $query = $this->outputDataTable->find();
        $query->where(['dataset' => $this->dataset,
            'time_index' => $index]);                
        $row = $query->toArray();
        // Log::debug('Row is ' . json_encode($row));

        return $row[0];
    }

    private function getRequiredParams()
    {        
        $params = Utils::getParams();

        return $params;
    }

    public function run()
    {
        $this->requiredInputFields = $this->setRequiredInputFieldNames();
        $this->requiredInputData = $this->getRequiredInputData();
        
        // delete previous output
        Utils::removeWaterBalanceDataset();
        // Utils::removeSoilWaterDataset();   

        // aux parameters (avoid reading in DB when not needed)
        $previous_MM_H20 = 0;
        $firstRow = true;

        // sr aux parameters
        $mm_h20_window_data = [];
        $precip_window_data = [];
        $wcgh_gain_window_data = [];
        $et_window_data = [];

        // foreach inputData row
        foreach ($this->requiredInputData as $inputDataRow){
            $outputDataRow = [
                'dataset' => $this->dataset,
                'time_index' => $inputDataRow['time_index'],
                'time_name' => $inputDataRow['time_name'],
                'time_date' => $inputDataRow['time_date'],
                'time_day' => $inputDataRow['time_day'],
                'time_month' => $inputDataRow['time_month'],
                'time_year' => $inputDataRow['time_year']
            ];                       

            // calculate output fields required by chain
            foreach ($this->chain as $method){
                switch($method){
                    case self::VWC:
                        $outputDataRow = array_merge($outputDataRow,
                            $this->calculateVwContent($inputDataRow)
                        );
                        break;
                    case self::MM_H20:
                        $outputDataRow = array_merge($outputDataRow,
                            $this->calculateWaterVolumeInSoil($inputDataRow)
                        );
                        break;
                    case self::WCHG:
                        $outputDataRow = array_merge($outputDataRow,
                            $this->calculateWaterChange(array(
                                'previous_mm_h20' => $previous_MM_H20,
                                'current_mm_h20' => $outputDataRow[self::MM_H20_OUTPUT_FIELD],
                            ), $firstRow)
                        );
                        break;
                    case self::WB:
                        $outputDataRow = array_merge($outputDataRow,
                            $this->calculateWaterBalance(array(
                                'net_loss' => $outputDataRow[self::WCHG_OUTPUT_FIELD_LOSS],
                                'net_gain' => $outputDataRow[self::WCHG_OUTPUT_FIELD_GAIN],
                                'et' => $inputDataRow['et'],
                                'precip' => $inputDataRow['precip']
                            ))
                        );    
                        // Log::debug('balanceOutputRow: ' . json_encode($outputDataRow)); 
                        
                        // SR initialization
                        $outputDataRow[self::WB_OUTPUT_FIELD_SR] = 0; // default value                        
                        break; // END OF case self::WB
                }
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outputDataTable);                        
            
            // store aux params
            $previous_MM_H20 = $outputDataRow[self::MM_H20_OUTPUT_FIELD];
            $firstRow = false;
        } 
        

        // SR Calculation
        $this->calculateSurfaceRunoff();
    }            

    private function writeOutputToDb($outputDataRow, $table)
    {        
        // Log::debug('outputDataRow: ' . json_encode($outputDataRow)); 
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function updateOutputRow($keyValue, $table, $time_index)
    {
        $outputEntity = $table->find()
            ->where([
                'dataset' => $this->dataset,
                'time_index' => $time_index])
            ->first();   

        // Log::debug('Updating ' . json_encode($outputEntity));
        $keys = array_keys($keyValue);
        foreach ($keys as $key){            
            $outputEntity->$key = $keyValue[$key];
        }
        // Log::debug('Updated ' . json_encode($outputEntity));
        $table->save($outputEntity);
    }
      
    private function calculateVwContent($inputData)
    {        
        return array(
            self::VWC_OUTPUT_FIELD => $inputData['sm']*100
        );
    }

    private function calculateWaterVolumeInSoil($inputData)
    {
        /*
        $a = $inputData['sm']*100;
        $b = $this->params['lt_mm'];
        $result = $a*$b/100;

        $result = $inputData['sm']*100*$this->params['lt_mm']/100;
        */

        return array(
            self::MM_H20_OUTPUT_FIELD => $inputData['sm']*$this->params['lt_mm']
        );
    }

    private function calculateWaterChange($params, $firstRow)
    {
        /*        
        $a = $outputDataRow[self::MM_H20_OUTPUT_FIELD]
        $b = $previousOutputDataRow[self::MM_H20_OUTPUT_FIELD]
        $result = $a-$b;
        */

        if ($firstRow) {
            $gain = 0;
            $loss = 0;
        } else {
            $change = $params['current_mm_h20'] - $params['previous_mm_h20'];
            if ($change >= 0){
                $gain = $change;
                $loss = 0;
            } else {
                $gain = 0;
                $loss = -1*$change;
            }
        }        

        return array(
            self::WCHG_OUTPUT_FIELD_GAIN => $gain,
            self::WCHG_OUTPUT_FIELD_LOSS => $loss
        );
    }

    private function calculateWaterBalance($params)
    {
        // evapotranspiration after substracting what's lost before entering the soil
        $et_fromSoil = $params['et'] * ((100 - $this->params['et_loss']) / 100); 
        $et_lostAboveGround = $params['et'] - $et_fromSoil;
        
        $inf = $params['net_gain'] + $et_fromSoil;                

        // Drainage = Net Loss-ET from soil daca Net Loss-ET from soil>0, sau zero daca diferenta este <0
        $drain = $params['net_loss'] - $et_fromSoil;
        if ($drain < 0){
            $drain = 0;
        }

        return array(
            self::WB_OUTPUT_FIELD_DRAIN => $drain,
            self::WB_OUTPUT_FIELD_INFILTRATION => $inf,
            self::WB_OUTPUT_FIELD_ET_LOST => $et_lostAboveGround,
            self::WB_OUTPUT_FIELD_ET_SOIL => $et_fromSoil
        );
    }

    private function calculateSurfaceRunoff()
    {        
        // sr aux parameters
        $mm_h20_window_data = [];
        $precip_window_data = [];
        $wcgh_gain_window_data = [];
        $et_window_data = [];

        $windowSize = $this->params['sr_window'] ? $this->params['sr_window'] : self::WB_DEFAULT_SR_WINDOW_SIZE;
        if ($windowSize%2 == 0){
            $firstHalfEnd = $windowSize/2;
            $secondHalfStart = $firstHalfEnd+1;
        } else {
            $firstHalfEnd = floor($windowSize/2)+1;
            $secondHalfStart = $firstHalfEnd;
        }
        
        // Log::debug('********');
        // Log::debug('SR Window size: '  . $windowSize);
        // Log::debug('SR Window 1st half: 1 -> ' . $firstHalfEnd);
        // Log::debug('SR Window 2nd half: ' . $secondHalfStart . ' -> ' . $windowSize);

        // foreach inputData row
        foreach ($this->requiredInputData as $inputDataRow){
            $outputDataRow = [
                'dataset' => $this->dataset,
                'time_index' => $inputDataRow['time_index'],
                // 'time_name' => $inputDataRow['time_name'],
                // 'time_date' => $inputDataRow['time_date'],
                // 'time_day' => $inputDataRow['time_day'],
                // 'time_month' => $inputDataRow['time_month'],
                // 'time_year' => $inputDataRow['time_year']
            ];    

            // get neeed values from prevously calculated output (from DB)
            $currentDbOutputRow = $this->getOutputTableData($inputDataRow['time_index']);        
            $outputDataRow[self::MM_H20_OUTPUT_FIELD] = $currentDbOutputRow[self::MM_H20_OUTPUT_FIELD];
            $outputDataRow[self::WCHG_OUTPUT_FIELD_GAIN] = $currentDbOutputRow[self::WCHG_OUTPUT_FIELD_GAIN];

            $positionInWindow = $outputDataRow['time_index'] % $windowSize;
            if ($positionInWindow == 0){
                $positionInWindow = $windowSize;
            }

            // initialize values
            $mm_h20_window_data[$positionInWindow-1] = $outputDataRow[self::MM_H20_OUTPUT_FIELD];
            $precip_window_data[$positionInWindow-1] = $inputDataRow['precip'];
            $wcgh_gain_window_data[$positionInWindow-1] = $outputDataRow[self::WCHG_OUTPUT_FIELD_GAIN];
            $et_window_data[$positionInWindow-1] = $inputDataRow['et'];
            $outputDataRow[self::WB_OUTPUT_FIELD_SR] = 0;
                
            if ($positionInWindow == $windowSize) { // calculate SR values only if reached last slot in window            
                    
                // Log::debug('********');
                // Log::debug('TimeIndex: ' . $outputDataRow['time_index']);
                // Log::debug('Position ' . $positionInWindow);
                // Log::debug('mm_h20_window_data :' . json_encode($mm_h20_window_data));
                // Log::debug('precip_window_data :' . json_encode($precip_window_data));
                // Log::debug('wcgh_gain_window_data :' . json_encode($wcgh_gain_window_data));
                // Log::debug('et_window_data :' . json_encode($et_window_data));

                // condition 1
                    // calculate first half averages
                        $sum = 0;
                        $items = 0;
                        for ($i=1; $i<=$firstHalfEnd; $i++) {
                            $sum+= $mm_h20_window_data[$i-1]; 
                            $items++;
                        }
                        $firstHalfAverage = $sum/$items;
                        // Log::debug('firstHalfAverage: '. $firstHalfAverage);
                        
                    // calculate second half averages
                        $sum = 0;
                        $items = 0;
                        for ($i=$secondHalfStart; $i<=$windowSize; $i++) {
                            $sum+= $mm_h20_window_data[$i-1]; 
                            $items++;
                        }
                        $secondHalfAverage = $sum/$items;
                        // Log::debug('secondHalfAverage: '. $secondHalfAverage);
                    
                        if ($secondHalfAverage <= $firstHalfAverage){ // NO SR in this case
                            // Log::debug('Condition 1 not met! ' . $firstHalfAverage . ' >= ' . $secondHalfAverage);
                            // $mm_h20_window_data = [];
                            // $precip_window_data = [];
                            // $wcgh_gain_window_data = [];
                            // $et_window_data = [];

                            // $outputDataRow[self::WB_OUTPUT_FIELD_SR] = 0;
                            // break; 
                            continue;
                        }

                // condition 2
                    // calculate averages for pp & et
                        $ppAverage = array_sum($precip_window_data)/$windowSize;
                        $etAverage = array_sum($et_window_data)/$windowSize;

                    // calculate first half averages
                        $sum = 0;
                        $items = 0;
                        for ($i=1; $i<=$firstHalfEnd; $i++) {
                            $sum+= $wcgh_gain_window_data[$i-1]; 
                            $items++;
                        }
                        $firstHalfGainAverage = $sum/$items;
                        // Log::debug('firstHalfGainAverage :' . $firstHalfGainAverage);

                    // calculate second half averages
                        $sum = 0;
                        $items = 0;
                        for ($i=$secondHalfStart; $i<=$windowSize; $i++) {
                            $sum+= $wcgh_gain_window_data[$i-1]; 
                            $items++;
                        }
                        $secondHalfGainAverage = $sum/$items;                                          
                        // Log::debug('secondHalfGainAverage :' . $secondHalfGainAverage);

                    $sr = $ppAverage - $secondHalfGainAverage - $firstHalfGainAverage - $etAverage;
                    // Log::debug('sr :' . $sr);
                    if ($sr < 0){ // NO SR in this case
                        // Log::debug('Condition 2 not met! SR = ' . $sr);
                        $sr = 0;
                    }                                        
                    
                // update value in DB
                    $outputDataRow[self::WB_OUTPUT_FIELD_SR] = $sr;

                    // write SR value to the whole window
                    if ($outputDataRow[self::WB_OUTPUT_FIELD_SR]){ // if non-zero                
                        $updateKeyValues = [
                            self::WB_OUTPUT_FIELD_SR => $outputDataRow[self::WB_OUTPUT_FIELD_SR]
                        ];
                        for ($i=1; $i<=$windowSize; $i++) {
                            $this->updateOutputRow($updateKeyValues, $this->outputDataTable, ($outputDataRow['time_index']-($i-1)));
                        }                    
                    }                               
            }        
            
        }
    }

    // unused below
    /*
    private function findOrCreate($outputDataRow)
    {                
        $aux = $outputDataRow;
        $aux['dataset'] = $this->dataset;        
        $aux['found'] = true;

        $wbEntity = $this->outputDataTable->findOrCreate([
                'dataset' => $this->dataset,
                'time_index' => $aux['time_index']
            ], 
            function ($entity) use ($aux) { // perform creation
                foreach($aux as $key => $value){
                    if (strcmp($key,'found') == 0){
                        continue;
                    }
                    $entity->$key = $value;
                }                
                $aux['found'] = false;
            }
        );       
            
        if ($aux['found']){ // perform update
            foreach($aux as $key => $value){
                if (strcmp($key,'found') == 0){
                    continue;
                }
                $wbEntity->$key = $value;
            } 
            $this->outputDataTable->save($wbEntity);
        }        
    }
    */
}