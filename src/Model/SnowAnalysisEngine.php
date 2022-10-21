<?php

namespace App\Model;

use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class SnowAnalysisEngine
{    
    private $dataset;
    private $params;
    private $requiredInputFields;
    private $requiredInputData;

    private $outputDataTable;

    public function __construct()
    {
        $this->dataset = Utils::getCurrentDataset();            
        $this->params = $this->getRequiredParams();
        
        $this->outputDataTable = TableRegistry::getTableLocator()->get('SnowData');        
    }

    private function setRequiredInputFieldNames()
    {
        $requiredFields = [ // need these fields from input ALWAYS
            'time_index',
            'time_name',
            'time_date',
            'time_day',
            'time_month',
            'time_year',
            'temp',
            'precip',
            'rain',
            'et',
            'ucd1',
            'ucd2',
            'ucd3',
            'ucd4',
            'ucd5'
        ];                 

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
        Utils::removeSnowDataset();    
        Utils::removeSoilWaterDataset(); 
        
        // get calibration mappings
        // $calibration = Utils::getSnowCalibrationFields();

        // foreach inputData row
        $firstRow = true;
        $lastOutputDataRow = null;
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
            
            $outputDataRow = array_merge($outputDataRow,
                $this->calculateSnow($inputDataRow, $lastOutputDataRow, $firstRow)
            );
            
            $firstRow = false;
            $lastOutputDataRow = $outputDataRow;

            // transform output data row for DB writing
            $outputDataRow = $this->formatOutputDataRow($outputDataRow);
            
            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outputDataTable);  
            
            // check for analysis stop every 50 data points
            if ($outputDataRow['time_index'] % 50 == 0) {  
                if (Utils::getStopAnalysisFlag()) {
                    // Log::debug('stopping snow analysis...');
                    return -1;
                }
            }

            // clone data for overlay each 188 points 
            if ($outputDataRow['time_index'] % 188 == 0) {              

                // also store data for Overlay scripts
                Utils::cloneTable('snow_data', 'snow_data_overlay');

                usleep(500 * 1000);
            }
        }    
        
        // clone data for overlay at script end
        Utils::cloneTable('snow_data', 'snow_data_overlay');
    }             

    private function writeOutputToDb($outputDataRow, $table)
    {        
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function updateOutputRow($keyValue, $table, $time_index)
    {
        $outputEntity = $table->find()
            ->where([
                'time_index' => $time_index,
                'dataset' => $this->dataset
            ])
            ->first();   

        $keys = array_keys($keyValue);
        foreach ($keys as $key){
            $outputEntity->$key = $keyValue[$key];
        }
        $table->save($outputEntity);
    }
      
    private function calculateSnow($inputData, $lastOutputDataRow, $isFirstRow)
    {        
        $outputArray = [];

        // get cols from input
        $outputArray['temp'] = $inputData['temp'];
        $outputArray['precip'] = $inputData['precip'];
        $outputArray['rain'] = $inputData['rain'];
        $outputArray['ucd1'] = $inputData['ucd1'];
        $outputArray['ucd2'] = $inputData['ucd2'];
        $outputArray['ucd3'] = $inputData['ucd3'];
        $outputArray['ucd4'] = $inputData['ucd4'];
        $outputArray['ucd5'] = $inputData['ucd5'];

        // col E
        $outputArray['e'] = $inputData['precip'] - $inputData['rain'];

        // col F
        if ($inputData['temp'] > $this->params['thr_rs']) {
            $outputArray['f'] = 0;
        } else {
            $outputArray['f'] = $inputData['rain'];
        }

        // col G
        $outputArray['g'] = $inputData['rain'] - $outputArray['f'];
        
        // col H
        if ($inputData['temp'] < $this->params['thr_sm']) {
            $outputArray['h'] = $outputArray['e'];
        } else {
            $outputArray['h'] = 0;
        }

        // col I
        $outputArray['i'] = $outputArray['e'] - $outputArray['h'];

        // col J
        $outputArray['j'] = $outputArray['f'] + $outputArray['h'];

        // col K
        $outputArray['k'] = $outputArray['g'] + $outputArray['i'];        

        // col L - Temperature Dependent Snow Melt
        if ($isFirstRow) {
            $outputArray['l'] = 0;
        } else {
            if (($inputData['temp'] > $this->params['thr_sm']) && $lastOutputDataRow['n'] > 0) {
                $outputArray['l'] = $this->params['cft_sm'] * (sqrt(pow($inputData['temp'], 2)) - sqrt(pow($this->params['thr_sm'], 2)));
            } else {
                $outputArray['l'] = 0;
            } 
        }    
        
        // col M - Rain Dependent Snow Melt
        if (($inputData['rain'] > 0) && ($lastOutputDataRow['n'] > 0)) {            
            $outputArray['m'] = $inputData['rain'] * $this->params['cfp_sm'];
        } else {
            $outputArray['m'] = 0;
        } 

        // col N - Snow Pack Accumulation after temp and rain corr
        if ($isFirstRow) {
            $outputArray['n'] = $this->params['snwt_init'] * (1 / $this->params['cfs_mc']);
        } else {
            $outputArray['n'] = $lastOutputDataRow['n'] + $outputArray['j'] - $outputArray['l'] - $outputArray['m'];

            if ($outputArray['n'] < 0) {
                $outputArray['n'] = 0;
            }
        }
        
        // col O - Melted Snow
        if ($isFirstRow) {
            $outputArray['o'] = $this->params['snwm_init'];
        } else {
            if (($outputArray['l'] + $outputArray['m']) > $outputArray['n']) {
                $outputArray['o'] = $lastOutputDataRow['n'] - $outputArray['n'];
            } else {
                $outputArray['o'] = $outputArray['l'] + $outputArray['m'];
            }            
        }

        // col P - Snowmelt after temp and rain effects
        $outputArray['p'] = $outputArray['o'] < 0 ? 0 : $outputArray['o'];

        $outputArray['q'] = $inputData['et'];

        // col R - Above soil ET
        $outputArray['r'] = $inputData['et'] - $inputData['et'] * $this->params['cf_ets'];     
        
        // col S
        $outputArray['s'] = 0; 
        // !!!! to be recalculated in soil moisture module
        // $inputData['et'] * $this->params['cf_ets'] - $soil['p']; 

        // col T
        $outputArray['t'] = $outputArray['s'] + $outputArray['r'];

        // col U
        $outputArray['u'] = $outputArray['p'] + $outputArray['k'];

        // col V
        $outputArray['v'] = $outputArray['u'] - $outputArray['t'];
        $outputArray['v'] = $outputArray['v'] < 0 ? 0 : $outputArray['v'];

        // col W
        if ($isFirstRow) {
            $outputArray['w'] = $this->params['snwt_init'];
        } else {
            $outputArray['w'] = $outputArray['n'] * $this->params['cfs_mc'];
        }

        return $outputArray;
    }

    private function formatOutputDataRow($outputDataRow)
    {        
        // rename desired keys
        $dbReadyDataRow = array(
            'dataset' => $outputDataRow['dataset'],
            'time_index' => $outputDataRow['time_index'],
            'time_name' => $outputDataRow['time_name'],
            'time_date' => $outputDataRow['time_date'],
            'time_day' => $outputDataRow['time_day'],
            'time_month' => $outputDataRow['time_month'],
            'time_year' => $outputDataRow['time_year']
        );

        $dbReadyDataRow['temp'] = $outputDataRow['temp'];
        $dbReadyDataRow['precip'] = $outputDataRow['precip'];
        $dbReadyDataRow['rain'] = $outputDataRow['rain'];

        $dbReadyDataRow['snow_mm'] = $outputDataRow['e'];
        $dbReadyDataRow['rains'] = $outputDataRow['f'];
        $dbReadyDataRow['rainns'] = $outputDataRow['g'];
        $dbReadyDataRow['snoa'] = $outputDataRow['h'];
        $dbReadyDataRow['snom'] = $outputDataRow['i'];
        $dbReadyDataRow['rssl'] = $outputDataRow['j'];
        $dbReadyDataRow['rsi'] = $outputDataRow['k'];
        $dbReadyDataRow['tdsm'] = $outputDataRow['l'];
        $dbReadyDataRow['rdsm'] = $outputDataRow['m'];
        $dbReadyDataRow['snow_acc'] = $outputDataRow['n'];
        $dbReadyDataRow['snowmelt'] = $outputDataRow['p'];
        $dbReadyDataRow['et'] = $outputDataRow['q'];
        $dbReadyDataRow['et_above_g'] = $outputDataRow['r'];
        $dbReadyDataRow['etfsas'] = $outputDataRow['s'];
        $dbReadyDataRow['et_above_re'] = $outputDataRow['t'];
        $dbReadyDataRow['watisri'] = $outputDataRow['u'];
        $dbReadyDataRow['water_or_sr'] = $outputDataRow['v'];
        $dbReadyDataRow['snow_calc'] = $outputDataRow['w'];

        $dbReadyDataRow['ucd1'] = $outputDataRow['ucd1'];
        $dbReadyDataRow['ucd2'] = $outputDataRow['ucd2'];
        $dbReadyDataRow['ucd3'] = $outputDataRow['ucd3'];
        $dbReadyDataRow['ucd4'] = $outputDataRow['ucd4'];
        $dbReadyDataRow['ucd5'] = $outputDataRow['ucd5'];

        return $dbReadyDataRow;
    }
    
}