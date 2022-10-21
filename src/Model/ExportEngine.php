<?php

namespace App\Model;

use Cake\Core\Exception\Exception;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

use Cake\I18n\Time;
use stdClass;

class ExportEngine
{
    const INPUT_EXPORT = 1;    
    const SOILWATER_EXPORT = 2;   
    const SNOW_EXPORT = 3; 
    const WATER_BALANCE_EXPORT = 4; // not used for now    

    private $dailyDataTable, $monthlyDataTable, $yearlyDataTable;
    private $seasonsDataTable;
    private $growingDataTable;
    private $paramsTable;

    public function __construct($type = null)
    {
        $this->dataset = Utils::getCurrentDataset();
        $this->type = $type;              
        $this->paramsTable = TableRegistry::getTableLocator()->get('Params');
        $this->snowCalibMap = TableRegistry::getTableLocator()->get('SnowCalibration');
        $this->soilCalibMap = TableRegistry::getTableLocator()->get('SoilCalibration');
                
        switch ($this->type){
            case self::INPUT_EXPORT:
                $this->dailyDataTable = TableRegistry::getTableLocator()->get('InputData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('InputDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('InputDataYearly');                
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('InputDataSeasons');                
                $this->growingDataTable = TableRegistry::getTableLocator()->get('InputDataGrowingSeasons');

                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('InputDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalYearly');                
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSeasons');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowingSeasons');
                break;            

            case self::SNOW_EXPORT:
                $this->dailyDataTable = TableRegistry::getTableLocator()->get('SnowData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataYearly');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataSeasons');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowingSeasons');

                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalYearly');                
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSeasons');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowingSeasons');
                break;

            case self::SOILWATER_EXPORT:
                $this->dailyDataTable = TableRegistry::getTableLocator()->get('SoilWaterData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataYearly');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSeasons');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowingSeasons');        
                
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalYearly');                
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSeasons');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowingSeasons');
                break;

            case self::WATER_BALANCE_EXPORT:
                $this->dailyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataYearly');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataSeasons');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataGrowingSeasons');

                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalYearly');                
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalSeasons');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalGrowingSeasons');
                break;

            default:
                break;
        }        
    }    

    public function exportDaily($fields = null, $returnCollection = false)
    {                
        if ($fields) {
            $query = $this->dailyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->dailyDataTable->find('all');        
        }        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
                
        return $this->formatCsv($dataCollection);
    } 

    public function exportMonthly($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->monthlyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->monthlyDataTable->find('all');    
        }             
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportYearly($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->yearlyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->yearlyDataTable->find('all');      
        }            
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportSeasons($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->seasonsDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->seasonsDataTable->find('all');     
        }              
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportGrowingSeasons($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->growingDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->growingDataTable->find('all');      
        }            
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportTypicalDaily($fields = null, $returnCollection = false)
    {        
        if ($fields) {
            $query = $this->typicalDailyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->typicalDailyDataTable->find('all');       
        }                   
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }        
        
        return $this->formatCsv($dataCollection);
    } 

    public function exportTypicalMonthly($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->typicalMonthlyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->typicalMonthlyDataTable->find('all');        
        }          
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportTypicalYearly($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->typicalYearlyDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->typicalYearlyDataTable->find('all');     
        }             
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportTypicalSeasons($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->typicalSeasonsDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->typicalSeasonsDataTable->find('all');        
        }        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportTypicalGrowingSeasons($fields = null, $returnCollection = false)
    {
        if ($fields) {
            $query = $this->typicalGrowingDataTable->find('all',[
                'fields' => $fields
            ]);
        } else {
            $query = $this->typicalGrowingDataTable->find('all'); 
        }               
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $dataCollection = $query->toArray();

        if ($returnCollection){
            return $dataCollection;
        }
        
        return $this->formatCsv($dataCollection);
    }

    public function exportInputStatistics($returnCollection = false)
    {
        $tempStats = Utils::fetchInputStatsFromDb('temp')[0];   
        $precipStats = Utils::fetchInputStatsFromDb('precip')[0];                
        $rainStats = Utils::fetchInputStatsFromDb('rain')[0];   
        $etStats = Utils::fetchInputStatsFromDb('et')[0];   
        $ucd1Stats = Utils::fetchInputStatsFromDb('ucd1')[0];   
        $ucd2Stats = Utils::fetchInputStatsFromDb('ucd2')[0];   
        $ucd3Stats = Utils::fetchInputStatsFromDb('ucd3')[0];   
        $ucd4Stats = Utils::fetchInputStatsFromDb('ucd4')[0];   
        $ucd5Stats = Utils::fetchInputStatsFromDb('ucd5')[0]; 

        $statsData = [];
        $statsData[] = array(
            'Statistic',
            'TEMP (C)',
            'TOTPP (mm)',
            'RAIN (mm)',
            'ETA (mm)',
            'UCD1',
            'UCD2',
            'UCD3',
            'UCD4',
            'UCD5'
        );        
        $statsData[] = array(
            'Avg',
            Utils::formatDataDecimals('temp', $tempStats['average']),
            Utils::formatDataDecimals('precip', $precipStats['average']),
            Utils::formatDataDecimals('rain', $rainStats['average']),
            Utils::formatDataDecimals('et', $etStats['average']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['average']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['average']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['average']),
            Utils::formatDataDecimals('ucd4', $ucd4Stats['average']),
            Utils::formatDataDecimals('ucd5', $ucd5Stats['average'])         
        );
        $statsData[] = array(
            'Min',
            Utils::formatDataDecimals('temp', $tempStats['minimum']),
            Utils::formatDataDecimals('precip', $precipStats['minimum']),
            Utils::formatDataDecimals('rain', $rainStats['minimum']),
            Utils::formatDataDecimals('et', $etStats['minimum']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['minimum']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['minimum']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['minimum']),
            Utils::formatDataDecimals('ucd4', $ucd4Stats['minimum']),
            Utils::formatDataDecimals('ucd5', $ucd5Stats['minimum'])  
        );
        $statsData[] = array(
            'Max',
            Utils::formatDataDecimals('temp', $tempStats['maximum']),
            Utils::formatDataDecimals('precip', $precipStats['maximum']),
            Utils::formatDataDecimals('rain', $rainStats['maximum']),
            Utils::formatDataDecimals('et', $etStats['maximum']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['maximum']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['maximum']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['maximum']),
            Utils::formatDataDecimals('ucd4', $ucd4Stats['maximum']),
            Utils::formatDataDecimals('ucd5', $ucd5Stats['maximum'])
        );
        $statsData[] = array(
            'Std Dev',
            Utils::formatDataDecimals('temp', $tempStats['std_dev']),
            Utils::formatDataDecimals('precip', $precipStats['std_dev']),
            Utils::formatDataDecimals('rain', $rainStats['std_dev']),
            Utils::formatDataDecimals('et', $etStats['std_dev']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['std_dev']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['std_dev']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['std_dev']),
            Utils::formatDataDecimals('ucd4', $ucd4Stats['std_dev']),
            Utils::formatDataDecimals('ucd5', $ucd5Stats['std_dev'])
        );  
        
        if ($returnCollection){
            return $statsData;
        }
        
        $csvRowCollection = [];
        foreach($statsData as $dataRow){  
            $csvRow = [];
                                    
            // only values after first row
            foreach($dataRow as $value){                    
                $csvRow[] = $value;                                                        
            }
            $csvRowCollection[] = implode(',', $csvRow);
        }        

        return implode(PHP_EOL, $csvRowCollection);
    }

    public function exportSnowStatistics()
    {
        $statsData = [];
        $startDate = null;
        $endDate = null;

        // header
        $newDataLine = array(
            'Statistic',
            'TEMP (C)',
            'TOTPP (mm)',
            'RAIN (mm)',                                   
            'SNOF (mm)',                                   
            'RAINS (mm)',                                   
            'RAINNS (mm)',                                   
            'SNOA (mm)',                                   
            'SNOM (mm)',                                   
            'RSSL (mm)',                                   
            'RSI (mm)',                                   
            'SNMT (mm)',                                   
            'SNMR (mm)',                                   
            'SNTFmm (mm)',                                   
            'SNMF (mm)',
            'ETA (mm)',                                   
            'ETasi (mm)',                                   
            'ETfsas (mm)',                                   
            'ETasf (mm)',                                   
            // 'WATisri (mm)',                                   
            'WATisrf (mm)',                                   
            'SNTFcm (cm)'                                    
        );        
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = 'UCD'.($i+1);
        }
        $statsData[] = $newDataLine;    
        
        // avg
        $newDataLine = array(
            'Avg',
            Utils::formatDataDecimals('temp', Utils::fetchSnowStatsFromDb('temp', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('precip', Utils::fetchSnowStatsFromDb('precip', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rain', Utils::fetchSnowStatsFromDb('rain', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rains', Utils::fetchSnowStatsFromDb('rains', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rainns', Utils::fetchSnowStatsFromDb('rainns', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snoa', Utils::fetchSnowStatsFromDb('snoa', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snom', Utils::fetchSnowStatsFromDb('snom', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rssl', Utils::fetchSnowStatsFromDb('rssl', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rsi', Utils::fetchSnowStatsFromDb('rsi', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('tdsm', Utils::fetchSnowStatsFromDb('tdsm', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rdsm', Utils::fetchSnowStatsFromDb('rdsm', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snow_acc', Utils::fetchSnowStatsFromDb('snow_acc', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snowmelt', Utils::fetchSnowStatsFromDb('snowmelt', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('et', Utils::fetchSnowStatsFromDb('et', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('et_above_g', Utils::fetchSnowStatsFromDb('et_above_g', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('etfsas', Utils::fetchSnowStatsFromDb('etfsas', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('et_above_re', Utils::fetchSnowStatsFromDb('et_above_re', $startDate, $endDate)[0]['average']),
            // Utils::formatDataDecimals('watisri', Utils::fetchSnowStatsFromDb('watisri', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('water_or_sr', Utils::fetchSnowStatsFromDb('water_or_sr', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snow_calc', Utils::fetchSnowStatsFromDb('snow_calc', $startDate, $endDate)[0]['average'])
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['average']);
        }
        $statsData[] = $newDataLine;

        // min
        $newDataLine = array(
            'Min',
            Utils::formatDataDecimals('temp', Utils::fetchSnowStatsFromDb('temp', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('precip', Utils::fetchSnowStatsFromDb('precip', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rain', Utils::fetchSnowStatsFromDb('rain', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rains', Utils::fetchSnowStatsFromDb('rains', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rainns', Utils::fetchSnowStatsFromDb('rainns', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snoa', Utils::fetchSnowStatsFromDb('snoa', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snom', Utils::fetchSnowStatsFromDb('snom', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rssl', Utils::fetchSnowStatsFromDb('rssl', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rsi', Utils::fetchSnowStatsFromDb('rsi', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('tdsm', Utils::fetchSnowStatsFromDb('tdsm', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rdsm', Utils::fetchSnowStatsFromDb('rdsm', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snow_acc', Utils::fetchSnowStatsFromDb('snow_acc', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snowmelt', Utils::fetchSnowStatsFromDb('snowmelt', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('et', Utils::fetchSnowStatsFromDb('et', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('et_above_g', Utils::fetchSnowStatsFromDb('et_above_g', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('etfsas', Utils::fetchSnowStatsFromDb('etfsas', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('et_above_re', Utils::fetchSnowStatsFromDb('et_above_re', $startDate, $endDate)[0]['minimum']),
            // Utils::formatDataDecimals('watisri', Utils::fetchSnowStatsFromDb('watisri', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('water_or_sr', Utils::fetchSnowStatsFromDb('water_or_sr', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snow_calc', Utils::fetchSnowStatsFromDb('snow_calc', $startDate, $endDate)[0]['minimum'])                 
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['minimum']);
        }
        $statsData[] = $newDataLine;

        // max
        $newDataLine = array(
            'Max',
            Utils::formatDataDecimals('temp', Utils::fetchSnowStatsFromDb('temp', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('precip', Utils::fetchSnowStatsFromDb('precip', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rain', Utils::fetchSnowStatsFromDb('rain', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rains', Utils::fetchSnowStatsFromDb('rains', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rainns', Utils::fetchSnowStatsFromDb('rainns', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snoa', Utils::fetchSnowStatsFromDb('snoa', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snom', Utils::fetchSnowStatsFromDb('snom', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rssl', Utils::fetchSnowStatsFromDb('rssl', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rsi', Utils::fetchSnowStatsFromDb('rsi', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('tdsm', Utils::fetchSnowStatsFromDb('tdsm', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rdsm', Utils::fetchSnowStatsFromDb('rdsm', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snow_acc', Utils::fetchSnowStatsFromDb('snow_acc', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snowmelt', Utils::fetchSnowStatsFromDb('snowmelt', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('et', Utils::fetchSnowStatsFromDb('et', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('et_above_g', Utils::fetchSnowStatsFromDb('et_above_g', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('etfsas', Utils::fetchSnowStatsFromDb('etfsas', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('et_above_re', Utils::fetchSnowStatsFromDb('et_above_re', $startDate, $endDate)[0]['maximum']),
            // Utils::formatDataDecimals('watisri', Utils::fetchSnowStatsFromDb('watisri', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('water_or_sr', Utils::fetchSnowStatsFromDb('water_or_sr', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snow_calc', Utils::fetchSnowStatsFromDb('snow_calc', $startDate, $endDate)[0]['maximum'])                               
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['maximum']);
        }
        $statsData[] = $newDataLine;

        // std dev
        $newDataLine = array(
            'Std Dev',      
            Utils::formatDataDecimals('temp', Utils::fetchSnowStatsFromDb('temp', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('precip', Utils::fetchSnowStatsFromDb('precip', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rain', Utils::fetchSnowStatsFromDb('rain', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rains', Utils::fetchSnowStatsFromDb('rains', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rainns', Utils::fetchSnowStatsFromDb('rainns', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snoa', Utils::fetchSnowStatsFromDb('snoa', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snom', Utils::fetchSnowStatsFromDb('snom', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rssl', Utils::fetchSnowStatsFromDb('rssl', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rsi', Utils::fetchSnowStatsFromDb('rsi', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('tdsm', Utils::fetchSnowStatsFromDb('tdsm', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rdsm', Utils::fetchSnowStatsFromDb('rdsm', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snow_acc', Utils::fetchSnowStatsFromDb('snow_acc', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snowmelt', Utils::fetchSnowStatsFromDb('snowmelt', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('et', Utils::fetchSnowStatsFromDb('et', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('et_above_g', Utils::fetchSnowStatsFromDb('et_above_g', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('etfsas', Utils::fetchSnowStatsFromDb('etfsas', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('et_above_re', Utils::fetchSnowStatsFromDb('et_above_re', $startDate, $endDate)[0]['std_dev']),
            // Utils::formatDataDecimals('watisri', Utils::fetchSnowStatsFromDb('watisri', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('water_or_sr', Utils::fetchSnowStatsFromDb('water_or_sr', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snow_calc', Utils::fetchSnowStatsFromDb('snow_calc', $startDate, $endDate)[0]['std_dev'])                                
        );    
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['std_dev']);
        }
        $statsData[] = $newDataLine;                          
        
        $csvRowCollection = [];
        foreach($statsData as $dataRow){  
            $csvRow = [];
                                    
            // only values after first row
            foreach($dataRow as $value){                    
                $csvRow[] = $value;                                                        
            }
            $csvRowCollection[] = implode(',', $csvRow);
        }        

        return implode(PHP_EOL, $csvRowCollection);
    }    

    public function exportSoilWaterStatistics()
    {        
        $statsData = [];
        $startDate = null;
        $endDate = null;

        // header
        $newDataLine = array(
            'Statistic',
            'TEMP (C)',
            'TOTPP (mm)',
            'RAIN (mm)',                                   
            'SNOF (mm)',                                   
            'WATisrf (mm)',                                   
            'INFact (mm)',                                   
            'DRAfre (mm)',                                   
            'DRAfin (mm)',                                   
            'DRAbinf (mm)',                                   
            'DRAoss (mm)',                                   
            'DRAact (mm)',                                   
            'ETisi (mm)',
            'ETcds (mm)',                                   
            'ETfsas (mm)',                                   
            'SWCint (mm)',                                   
            'SWCfinmm (mm)',                                   
            'SWCfin (%)',                                   
            'SReinf (mm)',                                   
            'SReinfDB (mm)',                                   
            'SResas (mm)',                                   
            'SResasDB (mm)',                                   
            'SRTint (mm)',                                   
            'SRTact (mm)',           
            'SWCgain (mm)',           
            'SWCloss (mm)',           
            'SWClow',
            'SWChigh'
        );        
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = 'UCD'.($i+1);
        }
        $statsData[] = $newDataLine;    

        $temp = Utils::fetchSoilWaterStatsFromDb('temp', $startDate, $endDate)[0];      
        $precip = Utils::fetchSoilWaterStatsFromDb('precip', $startDate, $endDate)[0];      
        $rain = Utils::fetchSoilWaterStatsFromDb('rain', $startDate, $endDate)[0];      
        $snow_mm = Utils::fetchSoilWaterStatsFromDb('snow_mm', $startDate, $endDate)[0];                    
        $water_or_sr = Utils::fetchSoilWaterStatsFromDb('water_or_sr', $startDate, $endDate)[0];  
        $inf_cap_corr = Utils::fetchSoilWaterStatsFromDb('inf_cap_corr', $startDate, $endDate)[0];  
        $drafre = Utils::fetchSoilWaterStatsFromDb('drafre', $startDate, $endDate)[0];  
        $drain_corr = Utils::fetchSoilWaterStatsFromDb('drain_corr', $startDate, $endDate)[0];  
        $drain_boost_excess = Utils::fetchSoilWaterStatsFromDb('drain_boost_excess', $startDate, $endDate)[0];  
        $drain_boost_oversat = Utils::fetchSoilWaterStatsFromDb('drain_boost_oversat', $startDate, $endDate)[0];  
        $drain_total = Utils::fetchSoilWaterStatsFromDb('drain_total', $startDate, $endDate)[0];  
        $etisi = Utils::fetchSoilWaterStatsFromDb('etisi', $startDate, $endDate)[0];  
        $et_corr = Utils::fetchSoilWaterStatsFromDb('et_corr', $startDate, $endDate)[0];  
        $etfsas = Utils::fetchSoilWaterStatsFromDb('etfsas', $startDate, $endDate)[0];  
        $swcint = Utils::fetchSoilWaterStatsFromDb('swcint', $startDate, $endDate)[0];  
        $swc_corr_sat = Utils::fetchSoilWaterStatsFromDb('swc_corr_sat', $startDate, $endDate)[0];  
        $swc_corr_sat_pc = Utils::fetchSoilWaterStatsFromDb('swc_corr_sat_pc', $startDate, $endDate)[0];  
        $sr_exc = Utils::fetchSoilWaterStatsFromDb('sr_exc', $startDate, $endDate)[0];  
        $sr_exc_less_drain = Utils::fetchSoilWaterStatsFromDb('sr_exc_less_drain', $startDate, $endDate)[0];  
        $sr_sat = Utils::fetchSoilWaterStatsFromDb('sr_sat', $startDate, $endDate)[0];  
        $sr_sat_less_drain = Utils::fetchSoilWaterStatsFromDb('sr_sat_less_drain', $startDate, $endDate)[0];  
        $sr_total = Utils::fetchSoilWaterStatsFromDb('sr_total', $startDate, $endDate)[0];  
        $sr_total_less_drain = Utils::fetchSoilWaterStatsFromDb('sr_total_less_drain', $startDate, $endDate)[0];  
        $net_gain = Utils::fetchSoilWaterStatsFromDb('net_gain', $startDate, $endDate)[0];  
        $net_loss = Utils::fetchSoilWaterStatsFromDb('net_loss', $startDate, $endDate)[0];  
        $days_low_swc = Utils::fetchSoilWaterStatsFromDb('days_low_swc', $startDate, $endDate)[0];  
        $days_high_swc = Utils::fetchSoilWaterStatsFromDb('days_high_swc', $startDate, $endDate)[0];           

        $newDataLine = array(
            'Avg',
            Utils::formatDataDecimals('temp', $temp['average']),
            Utils::formatDataDecimals('precip', $precip['average']),
            Utils::formatDataDecimals('rain', $rain['average']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['average']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['average']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['average']),
            Utils::formatDataDecimals('drafre', $drafre['average']),
            Utils::formatDataDecimals('drain_corr', $drain_corr['average']),
            Utils::formatDataDecimals('drain_boost_excess', $drain_boost_excess['average']),
            Utils::formatDataDecimals('drain_boost_oversat', $drain_boost_oversat['average']),
            Utils::formatDataDecimals('drain_total', $drain_total['average']),
            Utils::formatDataDecimals('etisi', $etisi['average']),
            Utils::formatDataDecimals('et_corr', $et_corr['average']),
            Utils::formatDataDecimals('etfsas', $etfsas['average']),
            Utils::formatDataDecimals('swcint', $swcint['average']),
            Utils::formatDataDecimals('swc_corr_sat', $swc_corr_sat['average']),
            Utils::formatDataDecimals('swc_corr_sat_pc', $swc_corr_sat_pc['average']),
            Utils::formatDataDecimals('sr_exc', $sr_exc['average']),
            Utils::formatDataDecimals('sr_exc_less_drain', $sr_exc_less_drain['average']),
            Utils::formatDataDecimals('sr_sat', $sr_sat['average']),
            Utils::formatDataDecimals('sr_sat_less_drain', $sr_sat_less_drain['average']),
            Utils::formatDataDecimals('sr_total', $sr_total['average']),
            Utils::formatDataDecimals('sr_total_less_drain', $sr_total_less_drain['average']),
            Utils::formatDataDecimals('net_gain', $net_gain['average']),
            Utils::formatDataDecimals('net_loss', $net_loss['average']),            
            Utils::formatDataDecimals('days_low_swc', $days_low_swc['average']),
            Utils::formatDataDecimals('days_high_swc', $days_high_swc['average'])
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['average']);
        }
        $statsData[] = $newDataLine;

        $newDataLine = array(
            'Min',
            Utils::formatDataDecimals('temp', $temp['minimum']),
            Utils::formatDataDecimals('precip', $precip['minimum']),
            Utils::formatDataDecimals('rain', $rain['minimum']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['minimum']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['minimum']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['minimum']),
            Utils::formatDataDecimals('drafre', $drafre['minimum']),
            Utils::formatDataDecimals('drain_corr', $drain_corr['minimum']),
            Utils::formatDataDecimals('drain_boost_excess', $drain_boost_excess['minimum']),
            Utils::formatDataDecimals('drain_boost_oversat', $drain_boost_oversat['minimum']),
            Utils::formatDataDecimals('drain_total', $drain_total['minimum']),
            Utils::formatDataDecimals('etisi', $etisi['minimum']),
            Utils::formatDataDecimals('et_corr', $et_corr['minimum']),
            Utils::formatDataDecimals('etfsas', $etfsas['minimum']),
            Utils::formatDataDecimals('swcint', $swcint['minimum']),
            Utils::formatDataDecimals('swc_corr_sat', $swc_corr_sat['minimum']),
            Utils::formatDataDecimals('swc_corr_sat_pc', $swc_corr_sat_pc['minimum']),
            Utils::formatDataDecimals('sr_exc', $sr_exc['minimum']),
            Utils::formatDataDecimals('sr_exc_less_drain', $sr_exc_less_drain['minimum']),
            Utils::formatDataDecimals('sr_sat', $sr_sat['minimum']),
            Utils::formatDataDecimals('sr_sat_less_drain', $sr_sat_less_drain['minimum']),
            Utils::formatDataDecimals('sr_total', $sr_total['minimum']),
            Utils::formatDataDecimals('sr_total_less_drain', $sr_total_less_drain['minimum']),
            Utils::formatDataDecimals('net_gain', $net_gain['minimum']),
            Utils::formatDataDecimals('net_loss', $net_loss['minimum']),            
            Utils::formatDataDecimals('days_low_swc', $days_low_swc['minimum']),
            Utils::formatDataDecimals('days_high_swc', $days_high_swc['minimum'])     
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['average']);
        }
        $statsData[] = $newDataLine;

        $newDataLine = array(
            'Max',
            Utils::formatDataDecimals('temp', $temp['maximum']),
            Utils::formatDataDecimals('precip', $precip['maximum']),
            Utils::formatDataDecimals('rain', $rain['maximum']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['maximum']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['maximum']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['maximum']),
            Utils::formatDataDecimals('drafre', $drafre['maximum']),
            Utils::formatDataDecimals('drain_corr', $drain_corr['maximum']),
            Utils::formatDataDecimals('drain_boost_excess', $drain_boost_excess['maximum']),
            Utils::formatDataDecimals('drain_boost_oversat', $drain_boost_oversat['maximum']),
            Utils::formatDataDecimals('drain_total', $drain_total['maximum']),
            Utils::formatDataDecimals('etisi', $etisi['maximum']),
            Utils::formatDataDecimals('et_corr', $et_corr['maximum']),
            Utils::formatDataDecimals('etfsas', $etfsas['maximum']),
            Utils::formatDataDecimals('swcint', $swcint['maximum']),
            Utils::formatDataDecimals('swc_corr_sat', $swc_corr_sat['maximum']),
            Utils::formatDataDecimals('swc_corr_sat_pc', $swc_corr_sat_pc['maximum']),
            Utils::formatDataDecimals('sr_exc', $sr_exc['maximum']),
            Utils::formatDataDecimals('sr_exc_less_drain', $sr_exc_less_drain['maximum']),
            Utils::formatDataDecimals('sr_sat', $sr_sat['maximum']),
            Utils::formatDataDecimals('sr_sat_less_drain', $sr_sat_less_drain['maximum']),
            Utils::formatDataDecimals('sr_total', $sr_total['maximum']),
            Utils::formatDataDecimals('sr_total_less_drain', $sr_total_less_drain['maximum']),
            Utils::formatDataDecimals('net_gain', $net_gain['maximum']),
            Utils::formatDataDecimals('net_loss', $net_loss['maximum']),            
            Utils::formatDataDecimals('days_low_swc', $days_low_swc['maximum']),
            Utils::formatDataDecimals('days_high_swc', $days_high_swc['maximum']) 
        );
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['average']);
        }
        $statsData[] = $newDataLine;

        $newDataLine = array(
            'Std Dev',            
            Utils::formatDataDecimals('temp', $temp['std_dev']),
            Utils::formatDataDecimals('precip', $precip['std_dev']),
            Utils::formatDataDecimals('rain', $rain['std_dev']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['std_dev']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['std_dev']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['std_dev']),
            Utils::formatDataDecimals('drafre', $drafre['std_dev']),
            Utils::formatDataDecimals('drain_corr', $drain_corr['std_dev']),
            Utils::formatDataDecimals('drain_boost_excess', $drain_boost_excess['std_dev']),
            Utils::formatDataDecimals('drain_boost_oversat', $drain_boost_oversat['std_dev']),
            Utils::formatDataDecimals('drain_total', $drain_total['std_dev']),
            Utils::formatDataDecimals('etisi', $etisi['std_dev']),
            Utils::formatDataDecimals('et_corr', $et_corr['std_dev']),
            Utils::formatDataDecimals('etfsas', $etfsas['std_dev']),
            Utils::formatDataDecimals('swcint', $swcint['std_dev']),
            Utils::formatDataDecimals('swc_corr_sat', $swc_corr_sat['std_dev']),
            Utils::formatDataDecimals('swc_corr_sat_pc', $swc_corr_sat_pc['std_dev']),
            Utils::formatDataDecimals('sr_exc', $sr_exc['std_dev']),
            Utils::formatDataDecimals('sr_exc_less_drain', $sr_exc_less_drain['std_dev']),
            Utils::formatDataDecimals('sr_sat', $sr_sat['std_dev']),
            Utils::formatDataDecimals('sr_sat_less_drain', $sr_sat_less_drain['std_dev']),
            Utils::formatDataDecimals('sr_total', $sr_total['std_dev']),
            Utils::formatDataDecimals('sr_total_less_drain', $sr_total_less_drain['std_dev']),
            Utils::formatDataDecimals('net_gain', $net_gain['std_dev']),
            Utils::formatDataDecimals('net_loss', $net_loss['std_dev']),            
            Utils::formatDataDecimals('days_low_swc', $days_low_swc['std_dev']),
            Utils::formatDataDecimals('days_high_swc', $days_high_swc['std_dev']) 
        );        
        // add validation data fields
        for ($i = 0; $i < Utils::getValidationColumnsCount(); $i++) {
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['average']);
        }
        $statsData[] = $newDataLine;   
        
        $csvRowCollection = [];
        foreach($statsData as $dataRow){  
            $csvRow = [];
                                    
            // only values after first row
            foreach($dataRow as $value){                    
                $csvRow[] = $value;                                                        
            }
            $csvRowCollection[] = implode(',', $csvRow);
        }        

        return implode(PHP_EOL, $csvRowCollection);
    }

    public function exportGlobalConfiguration()
    {                
        $dataCollection = [];

        $header = new stdClass();
        $header->header = 'GLOBAL_CONFIGURATION';
        $dataCollection[] = $header;

        $query = $this->paramsTable->find('all');        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $paramsCollection = $query->toArray();
        $paramsCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type.= '_param';            
            $row->raw_name = $row->param_name;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $paramsCollection);

        $query = $this->snowCalibMap->find('all', ['fields' => ['output_field', 'ucd_field']]);        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $snowCalibCollection = $query->toArray();
        $snowCalibCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type = 'snow_calib_map';            
            $row->raw_name = $row->output_field;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $snowCalibCollection);

        $query = $this->soilCalibMap->find('all', ['fields' => ['output_field', 'ucd_field']]);        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $soilCalibCollection = $query->toArray();
        $soilCalibCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type = 'soil_calib_map';            
            $row->raw_name = $row->output_field;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $soilCalibCollection);

        $dataCollection = array_merge($dataCollection, $paramsCollection, $snowCalibCollection, $soilCalibCollection);
        
        return $this->formatCsvMetadata($dataCollection);
    }

    public function exportSnowConfiguration()
    {                
        $dataCollection = [];

        $header = new stdClass();
        $header->header = 'SNOW_CONFIGURATION';
        $dataCollection[] = $header;

        $query = $this->paramsTable->find('all');        
        $query->where([
            'dataset' => Utils::getCurrentDataset(),
            'param_type' => 'snow'
        ]);
        $paramsCollection = $query->toArray();
        $paramsCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type.= '_param';            
            $row->raw_name = $row->param_name;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $paramsCollection);

        $query = $this->snowCalibMap->find('all', ['fields' => ['output_field', 'ucd_field']]);        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $snowCalibCollection = $query->toArray();
        $snowCalibCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type = 'snow_calib_map';            
            $row->raw_name = $row->output_field;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $snowCalibCollection);      

        $dataCollection = array_merge($dataCollection, $paramsCollection, $snowCalibCollection);
        
        return $this->formatCsvMetadata($dataCollection);
    }

    public function exportSoilConfiguration()
    {                
        $dataCollection = [];

        $header = new stdClass();
        $header->header = 'WATER_BALANCE_CONFIGURATION';
        $dataCollection[] = $header;

        $query = $this->paramsTable->find('all');        
        $query->where(['dataset' => Utils::getCurrentDataset(),
            'param_type' => 'wb'
        ]);
        $paramsCollection = $query->toArray();
        $paramsCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type.= '_param';            
            $row->raw_name = $row->param_name;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $paramsCollection);    

        $query = $this->soilCalibMap->find('all', ['fields' => ['output_field', 'ucd_field']]);        
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $soilCalibCollection = $query->toArray();
        $soilCalibCollection = array_map(function($row) {
            // Log::debug(get_class($row));
            $row->param_type = 'wb_calib_map';            
            $row->raw_name = $row->output_field;
            $row->param_fullname = '';
            $row->param_range = '';
            // Log::debug(json_encode($row)); 
            return $row;
        }, $soilCalibCollection);

        $dataCollection = array_merge($dataCollection, $paramsCollection, $soilCalibCollection);
        
        return $this->formatCsvMetadata($dataCollection);
    }

    public function formatCsv($dataCollection)
    {
        $firstRow = true;
        $csvRowCollection = [];
        foreach($dataCollection as $dataRow){  
            // Log::debug(json_encode($dataRow));          
            $csvRow = [];
            
            // Log::debug('class is ' . get_class($dataRow));
            if ($dataRow instanceof stdClass){
                $row = json_decode(json_encode($dataRow), true);
            } else {
                $row = $dataRow->toArray();
            }            
            if(isset($row['id'])){
                unset($row['id']);
            }
            if(isset($row['dataset'])){
                unset($row['dataset']);
            }
            if(isset($row['time_date'])){
                unset($row['time_date']);
            }
            if(isset($row['time_day'])){
                unset($row['time_day']);
            }
            if(isset($row['time_month'])){
                unset($row['time_month']);
            }
            if(isset($row['time_year'])){
                unset($row['time_year']);
            }

            // also take out watisri from snow
            if(isset($row['watisri'])){
                unset($row['watisri']);
            }

            if ($firstRow){
                // keys
                foreach($row as $key => $value){  
                    $key = $this->transformKey($key);
                    $csvRow[] = '"' . $key . '"';                                        
                }
                $csvRowCollection[] = implode(',', $csvRow);

                $csvRow = [];

                // values
                foreach($row as $key => $value){   
                    if (is_numeric($value)){                 
                        $csvRow[] = ($value !== null) ? '"' . Utils::formatDataDecimals($key, $value) . '"' : 'N/A';
                    } else {
                        $csvRow[] = $this->transformKey($value);
                    }
                }
                $csvRowCollection[] = implode(',', $csvRow);

                $firstRow = false;            
            } else {
                // only values after first row
                foreach($row as $key => $value){                    
                    if (is_numeric($value)){                 
                        $csvRow[] = ($value !== null) ? '"' . Utils::formatDataDecimals($key, $value) . '"' : 'N/A';
                    } else {                        
                        $csvRow[] = $this->transformKey($value);
                    }
                }
                $csvRowCollection[] = implode(',', $csvRow);
            }
            // Log::debug(json_encode($csvRow));                                    
        }        

        return implode(PHP_EOL, $csvRowCollection);
    }   

    public function formatCsvMetadata($dataCollection)
    {        
        $rowIndex = 0; // first row is config type header, second row is table header
        $csvRowCollection = [];
        foreach($dataCollection as $dataRow){                                      
            if ($dataRow instanceof stdClass){
                $row = json_decode(json_encode($dataRow), true);
            } else if (is_object($dataRow)) {
                $row = $dataRow->toArray();
            } else {
                $row = $dataRow;
            }

            if(isset($row['id'])){
                unset($row['id']);
            }
            if(isset($row['dataset'])){
                unset($row['dataset']);
            }
            Log::debug($rowIndex . ' ' . json_encode($row));    
            
            if ($rowIndex == 0){
                $csvRow = [];
                
                // config type header
                foreach($row as $key => $value){                      
                    $csvRow[] = '"' . $value . '"';                                        
                }

                $rowIndex++;            
            } else {                              
                if ($rowIndex == 1) {
                    $csvRow = [];
                    
                    // table head
                    foreach($row as $key => $value){  
                        $key = $this->transformKey($key);
                        $csvRow[] = '"' . $key . '"';                                        
                    }   
                    $csvRowCollection[] = implode(',', $csvRow);                                        
                    $rowIndex++;
                }                

                $csvRow = [];
                $colName = null;    

                foreach($row as $key => $value){                        
                    switch ($key) {
                        case 'param_name':                        
                        case 'output_field':                        
                            $colName = $value;
                            $value = $this->transformKey($value);
                            $csvRow[] = '"' . $value . '"';                                                                    
                            break;
                        case 'param_fullname':
                            $fullnameKey = explode(' ', $this->transformKey($colName))[0];
                            $value = explode(' -', Utils::getToolTips()[$fullnameKey])[0];
                            $csvRow[] = '"' . $value . '"';
                            break;
                        case 'param_range':
                            $fullnameKey = explode(' ', $this->transformKey($colName))[0] . '_val';
                            $value = !empty(Utils::getToolTips()[$fullnameKey]) ? Utils::getToolTips()[$fullnameKey] : 'any';
                            $csvRow[] = '"' . $value . '"';
                            break;
                        case 'param_value':
                        case 'ucd_field':
                            $csvRow[] = ($value !== null) ? ((is_numeric($value)) ? '"' . Utils::formatDataDecimals($colName, $value) . '"' : $value) : 'N/A';
                            break;
                        case 'raw_name':                            
                            $csvRow[] = '"' . $colName . '"';
                            break;
                        case 'param_type':
                        case 'header':
                            $csvRow[] = '"' . $value . '"';
                            break;
                    }                    
                }                         
            }                                 
            $csvRowCollection[] = implode(',', $csvRow);                        
        }        

        return implode(PHP_EOL, $csvRowCollection);
    }

    private function transformKey($key)
    {       
        return Utils::transformKey($key);         
    }
}