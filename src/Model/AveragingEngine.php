<?php

namespace App\Model;

use App\Model\Entity\UcdAverages;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class AveragingEngine
{
    const INPUT_AVERAGING = 1;
    const SOIL_WATER_AVERAGING = 2;
    const SNOW_AVERAGING = 3;           

    const AVERAGE_YEAR = 1;
    const AVERAGE_MONTH = 2;
    const AVERAGE_SPRING = 3;
    const AVERAGE_SUMMER = 4;
    const AVERAGE_FALL = 5;
    const AVERAGE_WINTER = 6;
    const AVERAGE_GROWTH_SEASON_IN = 7;
    const AVERAGE_GROWTH_SEASON_OUT_AFTER = 8;
    const AVERAGE_GROWTH_SEASON_OUT_BEFORE = 9;
    
    const AVERAGE_TYPICAL_DAILY = 10; // averages across all years for each day in year
    const AVERAGE_TYPICAL_WINTER = 11; // averages for the winter months of the typical year

    private $dataset, $type;
    private $params;

    private $ucd1AvgMethod, $ucd2AvgMethod, $ucd3AvgMethod, $ucd4AvgMethod, $ucd5AvgMethod;
        
    // regular tables
    private $sourceDataTable, $monthlyDataTable, $yearlyDataTable;
    private $springDataTable, $summerDataTable, $fallDataTable, $winterDataTable, $seasonsDataTable;
    private $inGsDataTable, $outGsDataTable, $growingDataTable;

    // typical year tables
    private $typicalDailyDataTable, $typicalMonthlyDataTable, $typicalYearlyDataTable;    
    private $typicalSpringDataTable, $typicalSummerDataTable, $typicalFallDataTable, $typicalWinterDataTable, $typicalSeasonsDataTable;
    private $typicalInGsDataTable, $typicalOutGsDataTable, $typicalGrowingDataTable;

    public function __construct($type)
    {
        $this->dataset = Utils::getCurrentDataset();
        $this->type = $type;      
        $this->params = Utils::getParams();
                
        switch ($this->type){
            case self::INPUT_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('InputData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('InputDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('InputDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('InputDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('InputDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('InputDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('InputDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('InputDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonOut');                
                $this->growingDataTable = TableRegistry::getTableLocator()->get('InputDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('InputDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowingSeasons');
                break;            

            case self::SNOW_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('SnowData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('SnowDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('SnowDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('SnowDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('SnowDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonOut');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowingSeasons');
                break;

            case self::SOIL_WATER_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('SoilWaterData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonOut');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowingSeasons');
        }        
    }    

    private function adjustWorkingTablesForTypicalYear()
    {
        $this->sourceDataTable = $this->typicalDailyDataTable;

        $this->monthlyDataTable = $this->typicalMonthlyDataTable;
        $this->yearlyDataTable = $this->typicalYearlyDataTable;

        $this->springDataTable = $this->typicalSpringDataTable;
        $this->summerDataTable = $this->typicalSummerDataTable;
        $this->fallDataTable = $this->typicalFallDataTable;
        $this->winterDataTable = $this->typicalWinterDataTable;
        $this->seasonsDataTable = $this->typicalSeasonsDataTable;

        $this->inGsDataTable = $this->typicalInGsDataTable;
        $this->outGsDataTable = $this->typicalOutGsDataTable;
        $this->growingDataTable = $this->typicalGrowingDataTable;
    }

    //
    public function run()
    {
        // get averaging methods for UCD
        $this->ucd1AvgMethod = Utils::getUcdAvgMethod('ucd1');
        $this->ucd2AvgMethod = Utils::getUcdAvgMethod('ucd2');
        $this->ucd3AvgMethod = Utils::getUcdAvgMethod('ucd3');
        $this->ucd4AvgMethod = Utils::getUcdAvgMethod('ucd4');
        $this->ucd5AvgMethod = Utils::getUcdAvgMethod('ucd5');

        // default averaging
        $this->runMonthly();
        $this->runYearly();
        $this->runSpring();
        $this->runSummer();
        $this->runFall();
        $this->runWinter();
        $this->aggregateSeasons();
        if (Utils::isSetGrowthSeason()){
            $this->runGrowthSeasonIn();
            $this->runGrowthSeasonOut();
            $this->aggregateGrowingSeasons();
        }

        $this->runTypicalDaily();
        $this->adjustWorkingTablesForTypicalYear();
        $this->runTypicalMonthly();
        $this->runTypicalYearly();
        $this->runTypicalSpring();
        $this->runTypicalSummer();
        $this->runTypicalFall();
        $this->runTypicalWinter();
        $this->aggregateSeasons();
        if (Utils::isSetGrowthSeason()){
            $this->runTypicalGrowthSeasonIn();
            $this->runTypicalGrowthSeasonOut();
            $this->aggregateGrowingSeasons();
        }    
    }    

    public function runMonthly()
    {
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_MONTH);
        // Log::write('debug', "MONTHLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){
            $monthAbbrev = Utils::convertMonthToString($item['time_month']);                

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;                    
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;                                       
            }                    

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->monthlyDataTable);        
        }
    }

    public function runYearly()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_YEAR);
        // Log::write('debug', "YEARLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];              
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->yearlyDataTable);
        }        
    }   
    
    public function runSpring()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SPRING);
        // Log::write('debug', "SPRING:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];             
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->springDataTable);
        }        
    }

    public function runSummer()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SUMMER);
        // Log::write('debug', "SUMMER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->summerDataTable);
        }        
    }

    public function runFall()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_FALL);
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->fallDataTable);
        }        
    }

    public function runWinter()
    {                
        // if ($this->type != self::SOIL_WATER_AVERAGING){

        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_WINTER);
        // Log::write('debug', "WINTER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];
                    // Log::write('debug', $item['time_year'] . " DECEMBER: " . json_encode($decemberAverages)); 

                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = ($item['temp'] + $decemberAverages['temp']) / 2;
                    $outputDataRow['precip'] = $item['precip'] + $decemberAverages['precip'];                        
                    $outputDataRow['rain'] = $item['rain'] + $decemberAverages['rain'];
                    $outputDataRow['et'] = $item['et'] + $decemberAverages['et'];                        
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
                    break;                                        

                case self::SNOW_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];
                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                                        
                    $outputDataRow['temp'] = ($item['temp'] + $decemberAverages['temp']) / 2;
                    $outputDataRow['precip'] = $item['precip'] + $decemberAverages['precip'];
                    $outputDataRow['rain'] = $item['rain'] + $decemberAverages['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'] + $decemberAverages['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'] + $decemberAverages['rains'];
                    $outputDataRow['rainns'] = $item['rainns'] + $decemberAverages['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'] + $decemberAverages['snoa'];
                    $outputDataRow['snom'] = $item['snom'] + $decemberAverages['snom'];
                    $outputDataRow['rssl'] = $item['rssl'] + $decemberAverages['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'] + $decemberAverages['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'] + $decemberAverages['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'] + $decemberAverages['rdsm'];
                    $outputDataRow['snow_acc'] = ($item['snow_acc'] + $decemberAverages['snow_acc']) / 2;
                    $outputDataRow['snowmelt'] = $item['snowmelt'] + $decemberAverages['snowmelt'];
                    $outputDataRow['et'] = $item['et'] + $decemberAverages['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'] + $decemberAverages['et_above_g'];
                    $outputDataRow['etfsas'] = $item['etfsas'] + $decemberAverages['etfsas'];
                    $outputDataRow['et_above_re'] = $item['et_above_re'] + $decemberAverages['et_above_re'];
                    $outputDataRow['watisri'] = $item['watisri'] + $decemberAverages['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'] + $decemberAverages['water_or_sr'];
                    $outputDataRow['snow_calc'] = ($item['snow_calc'] + $decemberAverages['snow_calc']) / 2;
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
                    break;   
                    
                case self::SOIL_WATER_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];

                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['temp'] = ($item['temp'] + $decemberAverages['temp']) / 2;
                    $outputDataRow['precip'] = $item['precip'] + $decemberAverages['precip'];
                    $outputDataRow['rain'] = $item['rain'] + $decemberAverages['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'] + $decemberAverages['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'] + $decemberAverages['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'] + $decemberAverages['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'] + $decemberAverages['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'] + $decemberAverages['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'] + $decemberAverages['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'] + $decemberAverages['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'] + $decemberAverages['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'] + $decemberAverages['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'] + $decemberAverages['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'] + $decemberAverages['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'] + $decemberAverages['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'] + $decemberAverages['etfsas'];
                    $outputDataRow['swcint'] = ($item['swcint'] + $decemberAverages['swcint']) / 2;
                    $outputDataRow['swc_corr_sat'] = ($item['swc_corr_sat'] + $decemberAverages['swc_corr_sat']) / 2;
                    $outputDataRow['swc_corr_sat_pc'] = ($item['swc_corr_sat_pc'] + $decemberAverages['swc_corr_sat_pc']) / 2;
                    $outputDataRow['sr_exc'] = $item['sr_exc'] + $decemberAverages['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'] + $decemberAverages['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat'] + $decemberAverages['sr_sat'];
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'] + $decemberAverages['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'] + $decemberAverages['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain'] + $decemberAverages['sr_total_less_drain'];
                    $outputDataRow['net_gain'] = $item['net_gain'] + $decemberAverages['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'] + $decemberAverages['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc'] + $decemberAverages['days_low_swc'];
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'] + $decemberAverages['days_high_swc'];
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->winterDataTable);
        }       
    }    

    public function aggregateSeasons()
    {
        $yearList = $this->getYearList();
        
        $timeIndex = 0;
        foreach($yearList as $yearItem){            
            $seasonsData = $this->getSeasonsData($yearItem[0]);
            // Log::debug('seasons '. json_encode($seasonsData));

            // add to _seasons table       
            $counter = 0;     
            foreach($seasonsData as $item){
                $counter++;
                if (!empty($item[0])){
                    // Log::debug('year ' . $yearItem[0] . ' season ' . json_encode($item[0]));
                    $outputDataRow = $item[0]->toArray();                 
                    unset($outputDataRow['id']);
                    $outputDataRow['time_index'] = ++$timeIndex;

                    // Log::debug('outputDataRow ' . json_encode($outputDataRow));
                    $this->writeOutputToDb($outputDataRow, $this->seasonsDataTable);
                } else {
                    Log::debug('skipping_aggregate_seasons for counter = ' . $counter . ' in seasonsData ' . json_encode($seasonsData));
                }
            }                        
        }
    }

    public function runGrowthSeasonIn()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRows = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_IN, $yearItem[0])[0];
            // Log::write('debug', "runGrowthSeasonIn:" . json_encode($calculatedDataRows)); 

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['et'] = $calculatedDataRows['et'];
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];           
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRows['snow_mm'];
                    $outputDataRow['rains'] = $calculatedDataRows['rains'];
                    $outputDataRow['rainns'] = $calculatedDataRows['rainns'];
                    $outputDataRow['snoa'] = $calculatedDataRows['snoa'];
                    $outputDataRow['snom'] = $calculatedDataRows['snom'];
                    $outputDataRow['rssl'] = $calculatedDataRows['rssl'];
                    $outputDataRow['rsi'] = $calculatedDataRows['rsi'];
                    $outputDataRow['tdsm'] = $calculatedDataRows['tdsm'];
                    $outputDataRow['rdsm'] = $calculatedDataRows['rdsm'];
                    $outputDataRow['snow_acc'] = $calculatedDataRows['snow_acc'];
                    $outputDataRow['snowmelt'] = $calculatedDataRows['snowmelt'];
                    $outputDataRow['et'] = $calculatedDataRows['et'];
                    $outputDataRow['et_above_g'] = $calculatedDataRows['et_above_g'];  
                    $outputDataRow['etfsas'] = $calculatedDataRows['etfsas'];                  
                    $outputDataRow['et_above_re'] = $calculatedDataRows['et_above_re'];                    
                    $outputDataRow['watisri'] = $calculatedDataRows['watisri'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRows['water_or_sr'];
                    $outputDataRow['snow_calc'] = $calculatedDataRows['snow_calc'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];           
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRows['snow_mm'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRows['water_or_sr'];
                    $outputDataRow['infcap'] = $calculatedDataRows['infcap'];
                    $outputDataRow['inf_cap_corr'] = $calculatedDataRows['inf_cap_corr'];
                    $outputDataRow['dracap'] = $calculatedDataRows['dracap'];
                    $outputDataRow['drafre'] = $calculatedDataRows['drafre'];
                    $outputDataRow['drain_corr'] = $calculatedDataRows['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $calculatedDataRows['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $calculatedDataRows['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $calculatedDataRows['drain_total'];
                    $outputDataRow['etisi'] = $calculatedDataRows['etisi'];
                    $outputDataRow['et_corr'] = $calculatedDataRows['et_corr'];
                    $outputDataRow['etfsas'] = $calculatedDataRows['etfsas'];
                    $outputDataRow['swcint'] = $calculatedDataRows['swcint'];
                    $outputDataRow['swc_corr_sat'] = $calculatedDataRows['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $calculatedDataRows['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $calculatedDataRows['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $calculatedDataRows['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $calculatedDataRows['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $calculatedDataRows['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $calculatedDataRows['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $calculatedDataRows['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $calculatedDataRows['net_gain'];
                    $outputDataRow['net_loss'] = $calculatedDataRows['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $calculatedDataRows['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $calculatedDataRows['days_high_swc'];  
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];      
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->inGsDataTable);
        }        
    }

    public function runGrowthSeasonOut()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRowsBefore = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_BEFORE, $yearItem[0])[0];
            // Log::write('debug', "GS_OUT_BEFORE:" . json_encode($calculatedDataRowsBefore));    
            $calculatedDataRowsAfter = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_AFTER, $yearItem[0])[0];             
            // Log::write('debug', "GS_OUT_AFTER:" . json_encode($calculatedDataRowsAfter));

            if (!empty($calculatedDataRowsBefore['time_year'])){
                $timeYear = $calculatedDataRowsBefore['time_year'];
            } else {
                $timeYear = $calculatedDataRowsAfter['time_year'];
            }

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;
                    $outputDataRow['time_year'] = $timeYear;
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['et'] = $calculatedDataRowsBefore['et'] + $calculatedDataRowsAfter['et'];
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;           
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRowsBefore['snow_mm'] + $calculatedDataRowsAfter['snow_mm'];
                    $outputDataRow['rains'] = $calculatedDataRowsBefore['rains'] + $calculatedDataRowsAfter['rains'];
                    $outputDataRow['rainns'] = $calculatedDataRowsBefore['rainns'] + $calculatedDataRowsAfter['rainns'];
                    $outputDataRow['snoa'] = $calculatedDataRowsBefore['snoa'] + $calculatedDataRowsAfter['snoa'];
                    $outputDataRow['snom'] = $calculatedDataRowsBefore['snom'] + $calculatedDataRowsAfter['snom'];
                    $outputDataRow['rssl'] = $calculatedDataRowsBefore['rssl'] + $calculatedDataRowsAfter['rssl'];
                    $outputDataRow['rsi'] = $calculatedDataRowsBefore['rsi'] + $calculatedDataRowsAfter['rsi'];
                    $outputDataRow['tdsm'] = $calculatedDataRowsBefore['tdsm'] + $calculatedDataRowsAfter['tdsm'];
                    $outputDataRow['rdsm'] = $calculatedDataRowsBefore['rdsm'] + $calculatedDataRowsAfter['rdsm'];
                    $outputDataRow['snow_acc'] = ($calculatedDataRowsBefore['snow_acc'] + $calculatedDataRowsAfter['snow_acc']) / 2;
                    $outputDataRow['snowmelt'] = $calculatedDataRowsBefore['snowmelt'] + $calculatedDataRowsAfter['snowmelt'];
                    $outputDataRow['et'] = $calculatedDataRowsBefore['et'] + $calculatedDataRowsAfter['et'];
                    $outputDataRow['et_above_g'] = $calculatedDataRowsBefore['et_above_g'] + $calculatedDataRowsAfter['et_above_g'];
                    $outputDataRow['etfsas'] = $calculatedDataRowsBefore['etfsas'] + $calculatedDataRowsAfter['etfsas'];
                    $outputDataRow['et_above_re'] = $calculatedDataRowsBefore['et_above_re'] + $calculatedDataRowsAfter['et_above_re'];
                    $outputDataRow['watisri'] = $calculatedDataRowsBefore['watisri'] + $calculatedDataRowsAfter['watisri'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRowsBefore['water_or_sr'] + $calculatedDataRowsAfter['water_or_sr'];
                    $outputDataRow['snow_calc'] = ($calculatedDataRowsBefore['snow_calc'] + $calculatedDataRowsAfter['snow_calc']) / 2;
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;           
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRowsBefore['snow_mm'] + $calculatedDataRowsAfter['snow_mm'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRowsBefore['water_or_sr'] + $calculatedDataRowsAfter['water_or_sr'];
                    $outputDataRow['infcap'] = $calculatedDataRowsBefore['infcap'] + $calculatedDataRowsAfter['infcap'];
                    $outputDataRow['inf_cap_corr'] = $calculatedDataRowsBefore['inf_cap_corr'] + $calculatedDataRowsAfter['inf_cap_corr'];
                    $outputDataRow['dracap'] = $calculatedDataRowsBefore['dracap'] + $calculatedDataRowsAfter['dracap'];
                    $outputDataRow['drafre'] = $calculatedDataRowsBefore['drafre'] + $calculatedDataRowsAfter['drafre'];
                    $outputDataRow['drain_corr'] = $calculatedDataRowsBefore['drain_corr'] + $calculatedDataRowsAfter['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $calculatedDataRowsBefore['drain_boost_excess'] + $calculatedDataRowsAfter['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $calculatedDataRowsBefore['drain_boost_oversat'] + $calculatedDataRowsAfter['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $calculatedDataRowsBefore['drain_total'] + $calculatedDataRowsAfter['drain_total'];
                    $outputDataRow['etisi'] = $calculatedDataRowsBefore['etisi'] + $calculatedDataRowsAfter['etisi'];
                    $outputDataRow['et_corr'] = $calculatedDataRowsBefore['et_corr'] + $calculatedDataRowsAfter['et_corr'];
                    $outputDataRow['etfsas'] = $calculatedDataRowsBefore['etfsas'] + $calculatedDataRowsAfter['etfsas'];
                    $outputDataRow['swcint'] = ($calculatedDataRowsBefore['swcint'] + $calculatedDataRowsAfter['swcint']) / 2;
                    $outputDataRow['swc_corr_sat'] = ($calculatedDataRowsBefore['swc_corr_sat'] + $calculatedDataRowsAfter['swc_corr_sat']) / 2;
                    $outputDataRow['swc_corr_sat_pc'] = ($calculatedDataRowsBefore['swc_corr_sat_pc'] + $calculatedDataRowsAfter['swc_corr_sat_pc']) / 2;
                    $outputDataRow['sr_exc'] = $calculatedDataRowsBefore['sr_exc'] + $calculatedDataRowsAfter['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $calculatedDataRowsBefore['sr_exc_less_drain'] + $calculatedDataRowsAfter['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $calculatedDataRowsBefore['sr_sat'] + $calculatedDataRowsAfter['sr_sat'];
                    $outputDataRow['sr_sat_less_drain'] = $calculatedDataRowsBefore['sr_sat_less_drain'] + $calculatedDataRowsAfter['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $calculatedDataRowsBefore['sr_total'] + $calculatedDataRowsAfter['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $calculatedDataRowsBefore['sr_total_less_drain'] + $calculatedDataRowsAfter['sr_total_less_drain'];
                    $outputDataRow['net_gain'] = $calculatedDataRowsBefore['net_gain'] + $calculatedDataRowsAfter['net_gain'];
                    $outputDataRow['net_loss'] = $calculatedDataRowsBefore['net_loss'] + $calculatedDataRowsAfter['net_loss'];
                    $outputDataRow['days_low_swc'] = $calculatedDataRowsBefore['days_low_swc'] + $calculatedDataRowsAfter['days_low_swc'];
                    $outputDataRow['days_high_swc'] = $calculatedDataRowsBefore['days_high_swc'] + $calculatedDataRowsAfter['days_high_swc'];
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;
            }        

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outGsDataTable);
        }        
    }

    public function aggregateGrowingSeasons()
    {        
        $yearList = $this->getYearList();
        
        $timeIndex = 0;
        foreach($yearList as $yearItem){            
            $seasonsData = $this->getGrowingSeasonsData($yearItem[0]);
            // Log::debug('seasons '. json_encode($seasonsData));

            // add to _growing table
            $counter = 0;
            foreach($seasonsData as $item){
                $counter++;
                if (!empty($item[0])){
                    $outputDataRow = $item[0]->toArray(); 
                    unset($outputDataRow['id']);
                    $outputDataRow['time_index'] = ++$timeIndex;

                    // Log::debug('outputDataRow ' . json_encode($outputDataRow));
                    $this->writeOutputToDb($outputDataRow, $this->growingDataTable);
                } else {
                    Log::debug('skipping_aggregate_growing_seasons for counter = ' . $counter . ' in seasonsData ' . json_encode($seasonsData));
                }
                // Log::debug('year ' . $yearItem[0] . ' growing season ' . json_encode($item[0]));                
            }                        
        }
    }

    public function runTypicalDaily()
    {                
        $calculatedDataRows = $this->getTypicalDayAveragedData();
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day']; 
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day']; 
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                 
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day'];    
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;                       
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->typicalDailyDataTable);
        }        
    }

    public function runTypicalMonthly()
    {
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_MONTH);
        // Log::write('debug', "MONTHLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            $monthAbbrev = Utils::convertMonthToString($item['time_month']);    

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];          
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break; 
            }                    

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->monthlyDataTable);        
        }
    }

    public function runTypicalYearly()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_YEAR);
        // Log::write('debug', "YEARLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];                   
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break; 
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->yearlyDataTable);
        }        
    }   

    public function runTypicalSpring()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SPRING);
        // Log::write('debug', "SPRING:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];         
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->springDataTable);
        }        
    }

    public function runTypicalSummer()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SUMMER);
        // Log::write('debug', "SUMMER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                      
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];               
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];     
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->summerDataTable);
        }        
    }

    public function runTypicalFall()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_FALL);
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                         
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];         
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];      
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];   
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->fallDataTable);
        }        
    }

    public function runTypicalWinter()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_TYPICAL_WINTER);
        // Log::write('debug', "WINTER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                                
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];               
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['rains'] = $item['rains'];
                    $outputDataRow['rainns'] = $item['rainns'];
                    $outputDataRow['snoa'] = $item['snoa'];
                    $outputDataRow['snom'] = $item['snom'];
                    $outputDataRow['rssl'] = $item['rssl'];
                    $outputDataRow['rsi'] = $item['rsi'];
                    $outputDataRow['tdsm'] = $item['tdsm'];
                    $outputDataRow['rdsm'] = $item['rdsm'];
                    $outputDataRow['snow_acc'] = $item['snow_acc'];
                    $outputDataRow['snowmelt'] = $item['snowmelt'];
                    $outputDataRow['et'] = $item['et'];
                    $outputDataRow['et_above_g'] = $item['et_above_g'];  
                    $outputDataRow['etfsas'] = $item['etfsas'];                  
                    $outputDataRow['et_above_re'] = $item['et_above_re'];                    
                    $outputDataRow['watisri'] = $item['watisri'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['snow_calc'] = $item['snow_calc'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];           
                    $outputDataRow['temp'] = $item['temp'];
                    $outputDataRow['precip'] = $item['precip'];
                    $outputDataRow['rain'] = $item['rain'];
                    $outputDataRow['snow_mm'] = $item['snow_mm'];
                    $outputDataRow['water_or_sr'] = $item['water_or_sr'];
                    $outputDataRow['infcap'] = $item['infcap'];
                    $outputDataRow['inf_cap_corr'] = $item['inf_cap_corr'];
                    $outputDataRow['dracap'] = $item['dracap'];
                    $outputDataRow['drafre'] = $item['drafre'];
                    $outputDataRow['drain_corr'] = $item['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $item['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $item['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $item['drain_total'];
                    $outputDataRow['etisi'] = $item['etisi'];
                    $outputDataRow['et_corr'] = $item['et_corr'];
                    $outputDataRow['etfsas'] = $item['etfsas'];
                    $outputDataRow['swcint'] = $item['swcint'];
                    $outputDataRow['swc_corr_sat'] = $item['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $item['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $item['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $item['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $item['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $item['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $item['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $item['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $item['net_gain'];
                    $outputDataRow['net_loss'] = $item['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $item['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $item['days_high_swc'];  
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->winterDataTable);
        }        
    }

    public function runTypicalGrowthSeasonIn()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRows = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_IN, $yearItem[0])[0];
            // Log::write('debug', "runGrowthSeasonIn:" . json_encode($calculatedDataRows)); 

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                    
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['et'] = $calculatedDataRows['et'];
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRows['snow_mm'];
                    $outputDataRow['rains'] = $calculatedDataRows['rains'];
                    $outputDataRow['rainns'] = $calculatedDataRows['rainns'];
                    $outputDataRow['snoa'] = $calculatedDataRows['snoa'];
                    $outputDataRow['snom'] = $calculatedDataRows['snom'];
                    $outputDataRow['rssl'] = $calculatedDataRows['rssl'];
                    $outputDataRow['rsi'] = $calculatedDataRows['rsi'];
                    $outputDataRow['tdsm'] = $calculatedDataRows['tdsm'];
                    $outputDataRow['rdsm'] = $calculatedDataRows['rdsm'];
                    $outputDataRow['snow_acc'] = $calculatedDataRows['snow_acc'];
                    $outputDataRow['snowmelt'] = $calculatedDataRows['snowmelt'];
                    $outputDataRow['et'] = $calculatedDataRows['et'];
                    $outputDataRow['et_above_g'] = $calculatedDataRows['et_above_g'];  
                    $outputDataRow['etfsas'] = $calculatedDataRows['etfsas'];                  
                    $outputDataRow['et_above_re'] = $calculatedDataRows['et_above_re'];                    
                    $outputDataRow['watisri'] = $calculatedDataRows['watisri'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRows['water_or_sr'];
                    $outputDataRow['snow_calc'] = $calculatedDataRows['snow_calc'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];  
                    $outputDataRow['temp'] = $calculatedDataRows['temp'];
                    $outputDataRow['precip'] = $calculatedDataRows['precip'];
                    $outputDataRow['rain'] = $calculatedDataRows['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRows['snow_mm'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRows['water_or_sr'];
                    $outputDataRow['infcap'] = $calculatedDataRows['infcap'];
                    $outputDataRow['inf_cap_corr'] = $calculatedDataRows['inf_cap_corr'];
                    $outputDataRow['dracap'] = $calculatedDataRows['dracap'];
                    $outputDataRow['drafre'] = $calculatedDataRows['drafre'];
                    $outputDataRow['drain_corr'] = $calculatedDataRows['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $calculatedDataRows['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $calculatedDataRows['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $calculatedDataRows['drain_total'];
                    $outputDataRow['etisi'] = $calculatedDataRows['etisi'];
                    $outputDataRow['et_corr'] = $calculatedDataRows['et_corr'];
                    $outputDataRow['etfsas'] = $calculatedDataRows['etfsas'];
                    $outputDataRow['swcint'] = $calculatedDataRows['swcint'];
                    $outputDataRow['swc_corr_sat'] = $calculatedDataRows['swc_corr_sat'];
                    $outputDataRow['swc_corr_sat_pc'] = $calculatedDataRows['swc_corr_sat_pc']; 
                    $outputDataRow['sr_exc'] = $calculatedDataRows['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $calculatedDataRows['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $calculatedDataRows['sr_sat']; 
                    $outputDataRow['sr_sat_less_drain'] = $calculatedDataRows['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $calculatedDataRows['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $calculatedDataRows['sr_total_less_drain']; 
                    $outputDataRow['net_gain'] = $calculatedDataRows['net_gain'];
                    $outputDataRow['net_loss'] = $calculatedDataRows['net_loss'];                    
                    $outputDataRow['days_low_swc'] = $calculatedDataRows['days_low_swc']; 
                    $outputDataRow['days_high_swc'] = $calculatedDataRows['days_high_swc'];  
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->inGsDataTable);
        }        
    }

    public function runTypicalGrowthSeasonOut()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRowsBefore = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_BEFORE, $yearItem[0])[0];
            // Log::write('debug', "GS_OUT_BEFORE:" . json_encode($calculatedDataRowsBefore));    
            $calculatedDataRowsAfter = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_AFTER, $yearItem[0])[0];             
            // Log::write('debug', "GS_OUT_AFTER:" . json_encode($calculatedDataRowsAfter));

            if (!empty($calculatedDataRowsBefore['time_year'])){
                $timeYear = $calculatedDataRowsBefore['time_year'];
            } else {
                $timeYear = $calculatedDataRowsAfter['time_year'];
            }

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                    
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['et'] = $calculatedDataRowsBefore['et'] + $calculatedDataRowsAfter['et'];
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);                    
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRowsBefore['snow_mm'] + $calculatedDataRowsAfter['snow_mm'];
                    $outputDataRow['rains'] = $calculatedDataRowsBefore['rains'] + $calculatedDataRowsAfter['rains'];
                    $outputDataRow['rainns'] = $calculatedDataRowsBefore['rainns'] + $calculatedDataRowsAfter['rainns'];
                    $outputDataRow['snoa'] = $calculatedDataRowsBefore['snoa'] + $calculatedDataRowsAfter['snoa'];
                    $outputDataRow['snom'] = $calculatedDataRowsBefore['snom'] + $calculatedDataRowsAfter['snom'];
                    $outputDataRow['rssl'] = $calculatedDataRowsBefore['rssl'] + $calculatedDataRowsAfter['rssl'];
                    $outputDataRow['rsi'] = $calculatedDataRowsBefore['rsi'] + $calculatedDataRowsAfter['rsi'];
                    $outputDataRow['tdsm'] = $calculatedDataRowsBefore['tdsm'] + $calculatedDataRowsAfter['tdsm'];
                    $outputDataRow['rdsm'] = $calculatedDataRowsBefore['rdsm'] + $calculatedDataRowsAfter['rdsm'];
                    $outputDataRow['snow_acc'] = ($calculatedDataRowsBefore['snow_acc'] + $calculatedDataRowsAfter['snow_acc']) / 2;
                    $outputDataRow['snowmelt'] = $calculatedDataRowsBefore['snowmelt'] + $calculatedDataRowsAfter['snowmelt'];
                    $outputDataRow['et'] = $calculatedDataRowsBefore['et'] + $calculatedDataRowsAfter['et'];
                    $outputDataRow['et_above_g'] = $calculatedDataRowsBefore['et_above_g'] + $calculatedDataRowsAfter['et_above_g'];
                    $outputDataRow['etfsas'] = $calculatedDataRowsBefore['etfsas'] + $calculatedDataRowsAfter['etfsas'];
                    $outputDataRow['et_above_re'] = $calculatedDataRowsBefore['et_above_re'] + $calculatedDataRowsAfter['et_above_re'];
                    $outputDataRow['watisri'] = $calculatedDataRowsBefore['watisri'] + $calculatedDataRowsAfter['watisri'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRowsBefore['water_or_sr'] + $calculatedDataRowsAfter['water_or_sr'];
                    $outputDataRow['snow_calc'] = ($calculatedDataRowsBefore['snow_calc'] + $calculatedDataRowsAfter['snow_calc']) / 2;
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;                                                        
                    $outputDataRow['temp'] = ($calculatedDataRowsBefore['temp'] + $calculatedDataRowsAfter['temp']) / 2;
                    $outputDataRow['precip'] = $calculatedDataRowsBefore['precip'] + $calculatedDataRowsAfter['precip'];
                    $outputDataRow['rain'] = $calculatedDataRowsBefore['rain'] + $calculatedDataRowsAfter['rain'];
                    $outputDataRow['snow_mm'] = $calculatedDataRowsBefore['snow_mm'] + $calculatedDataRowsAfter['snow_mm'];
                    $outputDataRow['water_or_sr'] = $calculatedDataRowsBefore['water_or_sr'] + $calculatedDataRowsAfter['water_or_sr'];
                    $outputDataRow['infcap'] = $calculatedDataRowsBefore['infcap'] + $calculatedDataRowsAfter['infcap'];
                    $outputDataRow['inf_cap_corr'] = $calculatedDataRowsBefore['inf_cap_corr'] + $calculatedDataRowsAfter['inf_cap_corr'];
                    $outputDataRow['dracap'] = $calculatedDataRowsBefore['dracap'] + $calculatedDataRowsAfter['dracap'];
                    $outputDataRow['drafre'] = $calculatedDataRowsBefore['drafre'] + $calculatedDataRowsAfter['drafre'];
                    $outputDataRow['drain_corr'] = $calculatedDataRowsBefore['drain_corr'] + $calculatedDataRowsAfter['drain_corr'];
                    $outputDataRow['drain_boost_excess'] = $calculatedDataRowsBefore['drain_boost_excess'] + $calculatedDataRowsAfter['drain_boost_excess'];
                    $outputDataRow['drain_boost_oversat'] = $calculatedDataRowsBefore['drain_boost_oversat'] + $calculatedDataRowsAfter['drain_boost_oversat'];
                    $outputDataRow['drain_total'] = $calculatedDataRowsBefore['drain_total'] + $calculatedDataRowsAfter['drain_total'];
                    $outputDataRow['etisi'] = $calculatedDataRowsBefore['etisi'] + $calculatedDataRowsAfter['etisi'];
                    $outputDataRow['et_corr'] = $calculatedDataRowsBefore['et_corr'] + $calculatedDataRowsAfter['et_corr'];
                    $outputDataRow['etfsas'] = $calculatedDataRowsBefore['etfsas'] + $calculatedDataRowsAfter['etfsas'];
                    $outputDataRow['swcint'] = ($calculatedDataRowsBefore['swcint'] + $calculatedDataRowsAfter['swcint']) / 2;
                    $outputDataRow['swc_corr_sat'] = ($calculatedDataRowsBefore['swc_corr_sat'] + $calculatedDataRowsAfter['swc_corr_sat']) / 2;
                    $outputDataRow['swc_corr_sat_pc'] = ($calculatedDataRowsBefore['swc_corr_sat_pc'] + $calculatedDataRowsAfter['swc_corr_sat_pc']) / 2;
                    $outputDataRow['sr_exc'] = $calculatedDataRowsBefore['sr_exc'] + $calculatedDataRowsAfter['sr_exc'];
                    $outputDataRow['sr_exc_less_drain'] = $calculatedDataRowsBefore['sr_exc_less_drain'] + $calculatedDataRowsAfter['sr_exc_less_drain'];
                    $outputDataRow['sr_sat'] = $calculatedDataRowsBefore['sr_sat'] + $calculatedDataRowsAfter['sr_sat'];
                    $outputDataRow['sr_sat_less_drain'] = $calculatedDataRowsBefore['sr_sat_less_drain'] + $calculatedDataRowsAfter['sr_sat_less_drain'];
                    $outputDataRow['sr_total'] = $calculatedDataRowsBefore['sr_total'] + $calculatedDataRowsAfter['sr_total'];
                    $outputDataRow['sr_total_less_drain'] = $calculatedDataRowsBefore['sr_total_less_drain'] + $calculatedDataRowsAfter['sr_total_less_drain'];
                    $outputDataRow['net_gain'] = $calculatedDataRowsBefore['net_gain'] + $calculatedDataRowsAfter['net_gain'];
                    $outputDataRow['net_loss'] = $calculatedDataRowsBefore['net_loss'] + $calculatedDataRowsAfter['net_loss'];
                    $outputDataRow['days_low_swc'] = $calculatedDataRowsBefore['days_low_swc'] + $calculatedDataRowsAfter['days_low_swc'];
                    $outputDataRow['days_high_swc'] = $calculatedDataRowsBefore['days_high_swc'] + $calculatedDataRowsAfter['days_high_swc'];
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;
            }        

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outGsDataTable);
        }        
    }

    private function getYearList()
    {                
        // Log::write('debug', 'sourceDataTable: ' . json_encode($this->sourceDataTable->getTable()));

        $connection = ConnectionManager::get('default');
        $yearList = $connection
            ->newQuery()
            ->select('year(time_date) as theYear')
            ->from($this->sourceDataTable->getTable())
            ->where([
                'dataset =' => $this->dataset
            ])
            ->group('theYear')
            ->execute()
            ->fetchAll();

        return $yearList;
    }

    private function getSeasonsData($theYear)
    {
        $data = [];

        $query = $this->springDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['spring'] = $query->toArray();               

        $query = $this->summerDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['summer'] = $query->toArray();               

        $query = $this->fallDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['fall'] = $query->toArray();               

        $query = $this->winterDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['winter'] = $query->toArray();               

        return $data;
    }

    private function getGrowingSeasonsData($theYear)
    {
        $data = [];

        $query = $this->inGsDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['gs_in'] = $query->toArray();               

        $query = $this->outGsDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['gs_out'] = $query->toArray();                       

        return $data;
    }

    private function getAveragedData($sortBy, $theYear = null)
    {
        $query = $this->sourceDataTable->find();

        // define ucd averaging
        $ucd1Avg = ($this->ucd1AvgMethod == 1) ? $query->func()->avg('ucd1') : $query->func()->sum('ucd1');
        $ucd2Avg = ($this->ucd2AvgMethod == 1) ? $query->func()->avg('ucd2') : $query->func()->sum('ucd2');
        $ucd3Avg = ($this->ucd3AvgMethod == 1) ? $query->func()->avg('ucd3') : $query->func()->sum('ucd3');
        $ucd4Avg = ($this->ucd4AvgMethod == 1) ? $query->func()->avg('ucd4') : $query->func()->sum('ucd4');
        $ucd5Avg = ($this->ucd5AvgMethod == 1) ? $query->func()->avg('ucd5') : $query->func()->sum('ucd5');        

        switch($this->type){
            case self::INPUT_AVERAGING:
                $select = [                                     
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),
                    'et' => $query->func()->sum('et'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $select = [      
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),
                    'snow_mm' => $query->func()->sum('snow_mm'),                               
                    'rains' => $query->func()->sum('rains'),
                    'rainns' => $query->func()->sum('rainns'),
                    'snoa' => $query->func()->sum('snoa'),
                    'snom' => $query->func()->sum('snom'),                               
                    'rssl' => $query->func()->sum('rssl'),
                    'rsi' => $query->func()->sum('rsi'),                               
                    'tdsm' => $query->func()->sum('tdsm'),
                    'rdsm' => $query->func()->sum('rdsm'),
                    'snow_acc' => $query->func()->avg('snow_acc'),
                    'snowmelt' => $query->func()->sum('snowmelt'),
                    'et' => $query->func()->sum('et'),
                    'et_above_g' => $query->func()->sum('et_above_g'),                    
                    'etfsas' => $query->func()->sum('etfsas'),                    
                    'et_above_re' => $query->func()->sum('et_above_re'),                    
                    'watisri' => $query->func()->sum('watisri'),                    
                    'water_or_sr' => $query->func()->sum('water_or_sr'),                    
                    'snow_calc' => $query->func()->avg('snow_calc'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg  
                ];
                break;             

            case self::SOIL_WATER_AVERAGING:    
                $select = [  
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),                                   
                    'snow_mm' => $query->func()->sum('snow_mm'),                               
                    'water_or_sr' => $query->func()->sum('water_or_sr'),
                    'infcap' => $query->func()->sum('infcap'),                   
                    'inf_cap_corr' => $query->func()->sum('inf_cap_corr'),                   
                    'dracap' => $query->func()->sum('dracap'),
                    'drafre' => $query->func()->sum('drafre'),
                    'drain_corr' => $query->func()->sum('drain_corr'),
                    'drain_boost_excess' => $query->func()->sum('drain_boost_excess'),
                    'drain_boost_oversat' => $query->func()->sum('drain_boost_oversat'),
                    'drain_total' => $query->func()->sum('drain_total'),                
                    'etisi' => $query->func()->sum('etisi'),   
                    'et_corr' => $query->func()->sum('et_corr'),                    
                    'etfsas' => $query->func()->sum('etfsas'),
                    'swcint' => $query->func()->avg('swcint'),
                    'swc_corr_sat' => $query->func()->avg('swc_corr_sat'),                    
                    'swc_corr_sat_pc' => $query->func()->avg('swc_corr_sat_pc'),  
                    'sr_exc' => $query->func()->sum('sr_exc'),                               
                    'sr_exc_less_drain' => $query->func()->sum('sr_exc_less_drain'),
                    'sr_sat' => $query->func()->sum('sr_sat'),
                    'sr_sat_less_drain' => $query->func()->sum('sr_sat_less_drain'),
                    'sr_total' => $query->func()->sum('sr_total'),
                    'sr_total_less_drain' => $query->func()->sum('sr_total_less_drain'),
                    'net_gain' => $query->func()->sum('net_gain'),                    
                    'net_loss' => $query->func()->sum('net_loss'),                                                       
                    'days_low_swc' => $query->func()->sum('days_low_swc'),
                    'days_high_swc' => $query->func()->sum('days_high_swc'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg                                                    
                ];
                break;
        }        

        switch($sortBy){
            case self::AVERAGE_YEAR:
            default:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset
                ];
                break;
            case self::AVERAGE_MONTH:
                $querySelect = array_merge($select, ['time_year', 'time_month']);
                $queryGroup = 'time_year, time_month';
                $queryWhere = [
                    'dataset =' => $this->dataset
                ];
                break;
            case self::AVERAGE_SPRING:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 3,
                    'time_month <' => 6
                ];
                break;
            case self::AVERAGE_SUMMER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 6,
                    'time_month <' => 9
                ];
                break;
            case self::AVERAGE_FALL:
                    $querySelect = array_merge($select, ['time_year']);
                    $queryGroup = 'time_year';
                    $queryWhere = [
                        'dataset =' => $this->dataset,
                        'time_month >=' => 9,
                        'time_month <' => 12    
                    ];
                    break;
            case self::AVERAGE_WINTER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 1,
                    'time_month <' => 3    
                ];
                break;
            case self::AVERAGE_TYPICAL_WINTER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_month IN' => [1,2,12]    
                ];                
                break;
            case self::AVERAGE_GROWTH_SEASON_IN:
                $querySelect = array_merge($select, ['time_year']);                      
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_date >=' => $theYear . '-' . $this->params['gs_start_month'] . '-' . $this->params['gs_start_day'],
                    'time_date <=' => $theYear . '-' . $this->params['gs_end_month'] . '-' . $this->params['gs_end_day']                   
                ];
                break;
            case self::AVERAGE_GROWTH_SEASON_OUT_BEFORE:
                $querySelect = array_merge($select, ['time_year']);   
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_date >' => ($theYear-1) . '-12-31',
                    'time_date <' => $theYear . '-' . $this->params['gs_start_month'] . '-' . $this->params['gs_start_day']                    
                ];
                break;
            case self::AVERAGE_GROWTH_SEASON_OUT_AFTER:
                $querySelect = array_merge($select, ['time_year']);   
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_date >' => $theYear . '-' . $this->params['gs_end_month'] . '-' . $this->params['gs_end_day'],
                    'time_date <' => ($theYear+1) . '-01-01'
                ];
                break;                      
        }
        
        $query->select($querySelect);       
        if (!empty($queryGroup)){
            $query->group($queryGroup);
        }                    
        if (!empty($queryWhere)){
            $query->where($queryWhere);
        }               
        $data = $query->toArray();               

        return $data;
    }

    private function getAveragedDataLastDecember($currentYear)
    {
        $query = $this->sourceDataTable->find();

        // define ucd averaging
        $ucd1Avg = ($this->ucd1AvgMethod == 1) ? $query->func()->avg('ucd1') : $query->func()->sum('ucd1');
        $ucd2Avg = ($this->ucd2AvgMethod == 1) ? $query->func()->avg('ucd2') : $query->func()->sum('ucd2');
        $ucd3Avg = ($this->ucd3AvgMethod == 1) ? $query->func()->avg('ucd3') : $query->func()->sum('ucd3');
        $ucd4Avg = ($this->ucd4AvgMethod == 1) ? $query->func()->avg('ucd4') : $query->func()->sum('ucd4');
        $ucd5Avg = ($this->ucd5AvgMethod == 1) ? $query->func()->avg('ucd5') : $query->func()->sum('ucd5');

        switch($this->type){
            case self::INPUT_AVERAGING:
                $querySelect = [        
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),
                    'et' => $query->func()->sum('et'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $querySelect = [           
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),
                    'snow_mm' => $query->func()->sum('snow_mm'),                               
                    'rains' => $query->func()->sum('rains'),
                    'rainns' => $query->func()->sum('rainns'),
                    'snoa' => $query->func()->sum('snoa'),
                    'snom' => $query->func()->sum('snom'),                               
                    'rssl' => $query->func()->sum('rssl'),
                    'rsi' => $query->func()->sum('rsi'),                               
                    'tdsm' => $query->func()->sum('tdsm'),
                    'rdsm' => $query->func()->sum('rdsm'),
                    'snow_acc' => $query->func()->avg('snow_acc'),
                    'snowmelt' => $query->func()->sum('snowmelt'),
                    'et' => $query->func()->sum('et'),
                    'et_above_g' => $query->func()->sum('et_above_g'),                    
                    'etfsas' => $query->func()->sum('etfsas'),                    
                    'et_above_re' => $query->func()->sum('et_above_re'),                    
                    'watisri' => $query->func()->sum('watisri'),                    
                    'water_or_sr' => $query->func()->sum('water_or_sr'),                    
                    'snow_calc' => $query->func()->avg('snow_calc'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg
                ];
                break;

            case self::SOIL_WATER_AVERAGING:    
                $querySelect = [                                     
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->sum('precip'),
                    'rain' => $query->func()->sum('rain'),                                   
                    'snow_mm' => $query->func()->sum('snow_mm'),                               
                    'water_or_sr' => $query->func()->sum('water_or_sr'),
                    'infcap' => $query->func()->sum('infcap'),                   
                    'inf_cap_corr' => $query->func()->sum('inf_cap_corr'),                   
                    'dracap' => $query->func()->sum('dracap'),
                    'drafre' => $query->func()->sum('drafre'),
                    'drain_corr' => $query->func()->sum('drain_corr'),
                    'drain_boost_excess' => $query->func()->sum('drain_boost_excess'),
                    'drain_boost_oversat' => $query->func()->sum('drain_boost_oversat'),
                    'drain_total' => $query->func()->sum('drain_total'),                
                    'etisi' => $query->func()->sum('etisi'),   
                    'et_corr' => $query->func()->sum('et_corr'),                    
                    'etfsas' => $query->func()->sum('etfsas'),
                    'swcint' => $query->func()->avg('swcint'),
                    'swc_corr_sat' => $query->func()->avg('swc_corr_sat'),                    
                    'swc_corr_sat_pc' => $query->func()->avg('swc_corr_sat_pc'),  
                    'sr_exc' => $query->func()->sum('sr_exc'),                               
                    'sr_exc_less_drain' => $query->func()->sum('sr_exc_less_drain'),
                    'sr_sat' => $query->func()->sum('sr_sat'),
                    'sr_sat_less_drain' => $query->func()->sum('sr_sat_less_drain'),
                    'sr_total' => $query->func()->sum('sr_total'),
                    'sr_total_less_drain' => $query->func()->sum('sr_total_less_drain'),
                    'net_gain' => $query->func()->sum('net_gain'),                    
                    'net_loss' => $query->func()->sum('net_loss'),                                                       
                    'days_low_swc' => $query->func()->sum('days_low_swc'),
                    'days_high_swc' => $query->func()->sum('days_high_swc'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg         
                ];
                break;
        }        
        
        $query->select($querySelect);                           
        $query->where([
            'dataset =' => $this->dataset,
            'time_month =' => 12,
            'time_year =' => $currentYear-1    
        ]);     
        
        $data = $query->toArray();               

        return $data;
    }    

    private function getTypicalDayAveragedData()
    {
        $query = $this->sourceDataTable->find();

        switch($this->type){
            case self::INPUT_AVERAGING:
                $select = [                                 
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->avg('precip'),
                    'rain' => $query->func()->avg('rain'),
                    'et' => $query->func()->avg('et'),
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')                   
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $select = [     
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->avg('precip'),
                    'rain' => $query->func()->avg('rain'),
                    'snow_mm' => $query->func()->avg('snow_mm'),                               
                    'rains' => $query->func()->avg('rains'),
                    'rainns' => $query->func()->avg('rainns'),
                    'snoa' => $query->func()->avg('snoa'),
                    'snom' => $query->func()->avg('snom'),                               
                    'rssl' => $query->func()->avg('rssl'),
                    'rsi' => $query->func()->avg('rsi'),                               
                    'tdsm' => $query->func()->avg('tdsm'),
                    'rdsm' => $query->func()->avg('rdsm'),
                    'snow_acc' => $query->func()->avg('snow_acc'),
                    'snowmelt' => $query->func()->avg('snowmelt'),
                    'et' => $query->func()->avg('et'),
                    'et_above_g' => $query->func()->avg('et_above_g'),                    
                    'etfsas' => $query->func()->avg('etfsas'),                    
                    'et_above_re' => $query->func()->avg('et_above_re'),                    
                    'watisri' => $query->func()->avg('watisri'),                    
                    'water_or_sr' => $query->func()->avg('water_or_sr'),                    
                    'snow_calc' => $query->func()->avg('snow_calc'),
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')               
                ];
                break;

            case self::SOIL_WATER_AVERAGING:    
                $select = [                                     
                    'temp' => $query->func()->avg('temp'),
                    'precip' => $query->func()->avg('precip'),
                    'rain' => $query->func()->avg('rain'),                                   
                    'snow_mm' => $query->func()->avg('snow_mm'),                               
                    'water_or_sr' => $query->func()->avg('water_or_sr'),
                    'infcap' => $query->func()->avg('infcap'),                   
                    'inf_cap_corr' => $query->func()->avg('inf_cap_corr'),                   
                    'dracap' => $query->func()->avg('dracap'),
                    'drafre' => $query->func()->avg('drafre'),
                    'drain_corr' => $query->func()->avg('drain_corr'),
                    'drain_boost_excess' => $query->func()->avg('drain_boost_excess'),
                    'drain_boost_oversat' => $query->func()->avg('drain_boost_oversat'),
                    'drain_total' => $query->func()->avg('drain_total'),                
                    'etisi' => $query->func()->avg('etisi'),   
                    'et_corr' => $query->func()->avg('et_corr'),                    
                    'etfsas' => $query->func()->avg('etfsas'),
                    'swcint' => $query->func()->avg('swcint'),
                    'swc_corr_sat' => $query->func()->avg('swc_corr_sat'),                    
                    'swc_corr_sat_pc' => $query->func()->avg('swc_corr_sat_pc'),  
                    'sr_exc' => $query->func()->avg('sr_exc'),                               
                    'sr_exc_less_drain' => $query->func()->avg('sr_exc_less_drain'),
                    'sr_sat' => $query->func()->avg('sr_sat'),
                    'sr_sat_less_drain' => $query->func()->avg('sr_sat_less_drain'),
                    'sr_total' => $query->func()->avg('sr_total'),
                    'sr_total_less_drain' => $query->func()->avg('sr_total_less_drain'),
                    'net_gain' => $query->func()->avg('net_gain'),                    
                    'net_loss' => $query->func()->avg('net_loss'),                                                       
                    'days_low_swc' => $query->func()->avg('days_low_swc'),
                    'days_high_swc' => $query->func()->avg('days_high_swc'),
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')                       
                ];
                break;
        }                
        
        $querySelect = array_merge($select, ['time_month', 'time_day']);
        $queryGroup = ['time_month', 'time_day'];
        $queryWhere = [
            'dataset =' => $this->dataset
        ]; 
        
        $query->select($querySelect);       
        if (!empty($queryGroup)){
            $query->group($queryGroup);
        }                    
        if (!empty($queryWhere)){
            $query->where($queryWhere);
        }        
        $data = $query->toArray();               

        return $data;
    }

    private function writeOutputToDb($outputDataRow, $table)
    {        
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function getAverageOfTwo($one, $two, $method)
    {    
        switch ($method) {
            case 2:
                $output = ($one + $two) / 2;
                break;
            case 1:
            default:
                $output = $one + $two;
        }

        return $output;        
    }
    
}