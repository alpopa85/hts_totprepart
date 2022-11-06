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
            'ucd1',
            'ucd2',
            'ucd3'
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
        // Utils::removeSoilWaterDataset(); 
        
        // get calibration mappings
        // $calibration = Utils::getSnowCalibrationFields();

        // foreach inputData row
        $firstRow = true;
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
                $this->calculateSnow($inputDataRow, $firstRow)
            );
            
            $firstRow = false;

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
      
    private function calculateSnow($inputData, $isFirstRow)
    {        
        $outputArray = [];

        // get cols from input
        $outputArray['temp'] = $inputData['temp'];
        $outputArray['precip'] = $inputData['precip'];
        $outputArray['ucd1'] = $inputData['ucd1'];
        $outputArray['ucd2'] = $inputData['ucd2'];
        $outputArray['ucd3'] = $inputData['ucd3'];

        $outputArray['snow_mm'] = ($this->params['precip_to_snow']*$inputData['precip'])/100;
        $outputArray['snow_cm'] = $outputArray['snow_mm']*$this->params['snow_mm_to_cm'];
        $outputArray['rain_mm'] = $outputArray['precip']-$outputArray['snow_mm'];

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

        $dbReadyDataRow['snow_mm'] = $outputDataRow['snow_mm'];
        $dbReadyDataRow['snow_cm'] = $outputDataRow['snow_cm'];
        $dbReadyDataRow['rain_mm'] = $outputDataRow['rain_mm'];       

        $dbReadyDataRow['ucd1'] = $outputDataRow['ucd1'];
        $dbReadyDataRow['ucd2'] = $outputDataRow['ucd2'];
        $dbReadyDataRow['ucd3'] = $outputDataRow['ucd3'];

        return $dbReadyDataRow;
    }
    
}