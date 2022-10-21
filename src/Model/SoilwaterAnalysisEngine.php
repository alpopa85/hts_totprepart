<?php

namespace App\Model;

use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\I18n\Date;
use Cake\ORM\TableRegistry;

class SoilwaterAnalysisEngine
{    
    private $dataset;
    private $params;

    private $requiredInputFields;
    private $requiredInputData;

    private $requiredSnowFields;
    private $requiredSnowData;    

    private $outputDataTable;    

    public function __construct()
    {
        $this->dataset = Utils::getCurrentDataset(); 
        $this->params = $this->getRequiredParams();
        
        $this->outputDataTable = TableRegistry::getTableLocator()->get('SoilWaterData');        
    }

    private function setRequiredInputFieldNames()
    {
        $requiredFields = [ // need these fields from input
            'time_index',
            'time_name',
            'time_day',
            'time_month',
            'time_year',
            'time_date',
            'temp',
            'et'            
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

    private function setRequiredSnowFieldNames()
    {
        $requiredFields = [ // need these fields from water deficit / stress table
            'snow_mm',
            'water_or_sr',
            'temp',
            'precip',
            'rain',
            'ucd1',
            'ucd2',
            'ucd3',
            'ucd4',
            'ucd5'
        ];                 

        return $requiredFields;
    }

    private function getRequiredSnowData()
    {
        // get inputs
        $inputDataTable = TableRegistry::getTableLocator()->get('SnowData');

        $query = $inputDataTable->find('all',[
            'fields' => $this->requiredSnowFields
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
        $this->requiredInputData = $this->getRequiredInputData()->toArray();

        $this->requiredSnowFields = $this->setRequiredSnowFieldNames();
        $this->requiredSnowData = $this->getRequiredSnowData()->toArray();
        
        // delete previous output        
        Utils::removeSoilWaterDataset();      
        
        // get calibration mappings
        // $calibration = Utils::getSoilCalibrationFields();

        // foreach inputData row
        $firstRow = true;
        $rowIndex = -1;
        $lastOutputDataRow = null;        
        foreach ($this->requiredInputData as $inputDataRow){
            $rowIndex++;
            $outputDataRow = [
                'dataset' => $this->dataset,
                'time_index' => $inputDataRow['time_index'],
                'time_name' => $inputDataRow['time_name'],
                'time_date' => $inputDataRow['time_date'],
                'time_day' => $inputDataRow['time_day'],
                'time_month' => $inputDataRow['time_month'],
                'time_year' => $inputDataRow['time_year']
            ];      

            $snowDataRow = $this->requiredSnowData[$rowIndex];
            
            $outputDataRow = array_merge($outputDataRow,
                $this->calculateSoilWater($inputDataRow, $snowDataRow, $lastOutputDataRow, $firstRow)
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
                    // Log::debug('stopping soil analysis...');
                    return -1;
                }
            }
            
            // clone data for overlay each 188 points 
            if ($outputDataRow['time_index'] % 188 == 0) {  

                // also store data for Overlay scripts
                Utils::cloneTable('soil_data', 'soil_data_overlay');

                usleep(500 * 1000);
            }
        }
        
        // clone data for overlay at script end
        Utils::cloneTable('soil_data', 'soil_data_overlay');
    }  

    private function writeOutputToDb($outputDataRow, $table)
    {        
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function calculateSoilWater($inputData, $snowData, $lastOutputDataRow, $isFirstRow)
    {        
        $outputArray = [];

        // get cols from snow
        $outputArray['temp'] = $snowData['temp'];
        $outputArray['precip'] = $snowData['precip'];
        $outputArray['rain'] = $snowData['rain'];
        $outputArray['ucd1'] = $snowData['ucd1'];
        $outputArray['ucd2'] = $snowData['ucd2'];
        $outputArray['ucd3'] = $snowData['ucd3'];
        $outputArray['ucd4'] = $snowData['ucd4'];
        $outputArray['ucd5'] = $snowData['ucd5'];

        // col E
        $outputArray['e'] = $snowData['snow_mm'];

        // col F        
        $outputArray['f'] = $snowData['water_or_sr'];        

        // col G        
        $c_53 = ($this->params['thr_inf_lh']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['g'] = $this->params['inf_lr']*24;
        } else {
            if ($lastOutputDataRow['s'] < $c_53) {
                $outputArray['g'] = $this->params['inf_lr']*24;
            } else {
                $outputArray['g'] = $this->params['inf_hr']*24;
            } 
        }            
        
        // col H
        if ($outputArray['f'] == 0) {
            $outputArray['h'] = 0;
        } else {
            $outputArray['h'] = min($outputArray['f'], $outputArray['g']);            
        }

        // col I
        $c_59 = ($this->params['thr_inf_hl']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['i'] = $this->params['dra_lr']*24;
        } else {
            if ($lastOutputDataRow['s'] < $c_59) {
                $outputArray['i'] = $this->params['dra_lr']*24;
            } else {
                $outputArray['i'] = $this->params['dra_hr']*24;
            } 
        }

        // col J
        if ($isFirstRow) {
            $outputArray['j'] = $outputArray['i'];
        } else {
            if ($inputData['temp'] < $this->params['thr_tsd']) {
                $outputArray['j'] = 0;
            } else {
                $outputArray['j'] = $outputArray['i'];
            } 
        }

        // col K
        $c_64 = ($this->params['thr_swsd']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['k'] = $outputArray['j'];
        } else {
            if ($lastOutputDataRow['s'] < $c_64) {
                $outputArray['k'] = 0;
            } else {
                $outputArray['k'] = $outputArray['j'];
            } 
        }  
        
        // col U
        $outputArray['u'] = $outputArray['f'] - $outputArray['h'];

        // col L
        $outputArray['l'] = $outputArray['u']*$this->params['cf_eidr'];

        // col O
        $outputArray['o'] = $inputData['et']*$this->params['cf_ets'];

        // col P
        $c_73 = ($this->params['thr_ets']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['p'] = $outputArray['o'];
        } else {
            if ($lastOutputDataRow['s'] < $c_73) {
                $outputArray['p'] = 0;
            } else {
                $outputArray['p'] = $outputArray['o'];
            } 
        } 

        // col Q
        $outputArray['q'] = $outputArray['o'] - $outputArray['p'];

        // col R
        $c_96 = ($this->params['swc_init']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['r'] = $c_96;
        } else {
            $outputArray['r'] = $lastOutputDataRow['r'] + $outputArray['h'] - $outputArray['p'] - $outputArray['k'];
        } 

        // col S
        $c_47 = ($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['s'] = $outputArray['r'];
        } else {
            if (($lastOutputDataRow['s'] + $outputArray['r'] - $lastOutputDataRow['r']) > $c_47) {
                $outputArray['s'] =  $c_47;
            } else {
                $outputArray['s'] = $lastOutputDataRow['s'] + $outputArray['r'] - $lastOutputDataRow['r'];
            }
        } 

        // col T
        $outputArray['t'] = $outputArray['s']/$this->params['thkn']*100;

        // col V
        $outputArray['v'] = $outputArray['u']*(1-$this->params['cf_eidr']);

        // col W
        $c_47 = ($this->params['por_e']/100)*$this->params['thkn'];
        if ($isFirstRow) {
            $outputArray['w'] = $this->params['sr_init'];
        } else {
            if ($outputArray['s'] < $c_47) {
                $outputArray['w'] = 0;
            } else {
                $outputArray['w'] = $outputArray['r'] - $lastOutputDataRow['r'] - $outputArray['s'] + $lastOutputDataRow['s'];
            } 
        } 

        // col M
        $outputArray['m'] = $outputArray['w']*$this->params['cf_osdr'];

        // col N
        $outputArray['n'] = $outputArray['k'] + $outputArray['l'] + $outputArray['m'];

        // col X
        $outputArray['x'] = $outputArray['w']*(1-$this->params['cf_osdr']);

        // col Y
        $outputArray['y'] = $outputArray['u'] + $outputArray['w'];

        // col Z
        $outputArray['z'] = $outputArray['v'] + $outputArray['x'];

        // col AA
        if ($isFirstRow) {
            $outputArray['aa'] = $this->params['ng_init'];
        } else {
            $outputArray['aa'] = max(0, $outputArray['s'] - $lastOutputDataRow['s']);
        } 

        // col AB
        if ($isFirstRow) {
            $outputArray['ab'] = $this->params['nl_init'];
        } else { 
            $outputArray['ab'] = (($outputArray['s'] - $lastOutputDataRow['s']) < 0) ? -1*($outputArray['s'] - $lastOutputDataRow['s']) : 0;
        } 

        // col AC
        $outputArray['ac'] = $outputArray['h'] - $outputArray['p'];

        // col AD
        $outputArray['ad'] = max(0, $outputArray['ac']);

        // col AF
        $outputArray['af'] = $outputArray['t']/$this->params['por_e']*100;

        // col AI
        $c_76 = ($this->params['thr_lw']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($outputArray['s'] < $c_76) {
            $outputArray['ai'] = 1;
        } else {
            $outputArray['ai'] = 0;
        } 

        // col AJ
        $c_79 = ($this->params['thr_hw']/100)*($this->params['por_e']/100)*$this->params['thkn'];
        if ($outputArray['s'] > $c_79) {
            $outputArray['aj'] = 1;
        } else {
            $outputArray['aj'] = 0;
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
        $dbReadyDataRow['water_or_sr'] = $outputDataRow['f'];        
        $dbReadyDataRow['infcap'] = $outputDataRow['g']; // INFcap
        $dbReadyDataRow['inf_cap_corr'] = $outputDataRow['h'];
        $dbReadyDataRow['dracap'] = $outputDataRow['i']; // DRAcap
        $dbReadyDataRow['drafre'] = $outputDataRow['j']; // DRAfre
        $dbReadyDataRow['drain_corr'] = $outputDataRow['k'];   
        $dbReadyDataRow['drain_boost_excess'] = $outputDataRow['l'];   
        $dbReadyDataRow['drain_boost_oversat'] = $outputDataRow['m'];           
        $dbReadyDataRow['drain_total'] = $outputDataRow['n'];   
        $dbReadyDataRow['etisi'] = $outputDataRow['o']; // ETisi
        $dbReadyDataRow['et_corr'] = $outputDataRow['p'];
        $dbReadyDataRow['etfsas'] = $outputDataRow['q']; // ETfsas
        $dbReadyDataRow['swcint'] = $outputDataRow['r']; // SWCint
        $dbReadyDataRow['swc_corr_sat'] = $outputDataRow['s'];   
        $dbReadyDataRow['swc_corr_sat_pc'] = $outputDataRow['t'];           
        $dbReadyDataRow['sr_exc'] = $outputDataRow['u'];   
        $dbReadyDataRow['sr_exc_less_drain'] = $outputDataRow['v']; 
        $dbReadyDataRow['sr_sat'] = $outputDataRow['w']; 
        $dbReadyDataRow['sr_sat_less_drain'] = $outputDataRow['x']; 
        $dbReadyDataRow['sr_total'] = $outputDataRow['y']; 
        $dbReadyDataRow['sr_total_less_drain'] = $outputDataRow['z'];
        $dbReadyDataRow['net_gain'] = $outputDataRow['aa']; 
        $dbReadyDataRow['net_loss'] = $outputDataRow['ab'];
        // $dbReadyDataRow['net_inf'] = $outputDataRow['ac'];
        // $dbReadyDataRow['net_inf_corr'] = $outputDataRow['ad'];
        // $dbReadyDataRow['poro_fill'] = $outputDataRow['af'];
        $dbReadyDataRow['days_low_swc'] = $outputDataRow['ai'];
        $dbReadyDataRow['days_high_swc'] = $outputDataRow['aj'];

        $dbReadyDataRow['ucd1'] = $outputDataRow['ucd1'];
        $dbReadyDataRow['ucd2'] = $outputDataRow['ucd2'];
        $dbReadyDataRow['ucd3'] = $outputDataRow['ucd3'];
        $dbReadyDataRow['ucd4'] = $outputDataRow['ucd4'];
        $dbReadyDataRow['ucd5'] = $outputDataRow['ucd5'];

        return $dbReadyDataRow;
    }

}