<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Chronos\Date;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Log\Log;

use App\Model\Utils;
use App\Model\SoilwaterAnalysisEngine;
use App\Model\AveragingEngine;
use App\Model\ExportEngine;

class SoilController extends AppController
{

    private $exportPrefix;
    private $exportSuffix;
    // private $requiredFieldsForExport;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');        

        $this->viewBuilder()->setLayout('project');

        $this->set('title', 'SNOW BUDDY');
        $this->set('activeNavbarId', 'soil_water');      

        $this->set('hasInputData', Utils::hasInputData());
        $this->set('hasSnowData', Utils::hasSnowData());
        $this->set('hasSoilData', Utils::hasSoilData());

        $this->set('tooltips', Utils::getTooltips());

        $this->set('ucdFields', array(
            'total' => Utils::getValidationColumnsCount(),
            'ucd1' => Utils::getUcdAvgMethod('ucd1'),
            'ucd2' => Utils::getUcdAvgMethod('ucd2'),
            'ucd3' => Utils::getUcdAvgMethod('ucd3'),
            'ucd4' => Utils::getUcdAvgMethod('ucd4'),
            'ucd5' => Utils::getUcdAvgMethod('ucd5'),
        ));
        
        $this->exportPrefix = 'SBUDDY_';        
        $now = Time::now();
        $this->exportSuffix = '_' . $now->toTimeString() . '.csv';

        /*$this->requiredFieldsForExport = array(
            'time_index',
            'time_name',
            'in_season',
            'mm_h20',
            'wchg',
            'below_mt',
            'actual_sm',
            'irr_added_sm',
            'irr_req',
            'gw_rchg',
            'gw_substracted',            
            'irr_return',
            'acquif_change',
            'et_adj',
            'pp_et_deficit'
        );*/
    }

    public function beforeFilter(Event $event)
    {            
        if (!Utils::isInputDataLoaded()){
            $this->Flash->error(__("Please load data before accessing the 'Water Balance' module!"));

            $this->response = $this->redirect('/input/load-data'); 
            return $this->response;
        }

        if (!Utils::isSnowComplete()){
            $this->Flash->error(__("Please complete the 'Snow' module analysis before accessing the 'Water Balance' module!"));

            $this->response = $this->redirect('/snow/analysis'); 
            return $this->response;
        }
    }

    /* VIEWS */
    /*********/

    public function index()
    {
        $this->setAction('info');
    }

    public function info()
    {
        $this->set('activeMenuNavId', 'info');
    }    

    public function analysis()
    {
        $this->set('activeMenuNavId', 'analysis');    
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);

        $calibration = Utils::getSoilCalibrationFields();
        $this->set('calibration', $calibration);

        $params = Utils::getParams();                
        $viewData = array(
            'paramData' => $params            
        );
        $this->set($viewData);
    }    

    public function table()
    {
        $this->set('activeMenuNavId', 'table');     
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);

        $calibFieldNames = [];
        foreach(Utils::getSoilCalibrationFields() as $key => $value) {            
            $calibFieldNames[$key] = explode(' ', Utils::transformKey($value))[0];
        }
        $this->set('calibration', $calibFieldNames);

        $analysisParams = Utils::getParams();
        $this->set('analysisParams', $analysisParams);
    } 

    public function graph()
    {
        $this->set('activeMenuNavId', 'graph');       
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);

        $calibFieldNames = [];
        foreach(Utils::getSoilCalibrationFields() as $key => $value) {            
            $calibFieldNames[$key] = explode(' ', Utils::transformKey($value))[0];
        }
        $this->set('calibration', $calibFieldNames);

        $analysisParams = Utils::getParams();
        $this->set('analysisParams', $analysisParams);
    }        

    public function exportDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportDaily();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');        
        $response = $response->withDownload($this->exportPrefix . 'dailySoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    } 

    public function exportMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'monthlySoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportYearly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'yearlySoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'seasonsSoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'growingSeasonsSoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportTypicalDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportTypicalDaily();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalDailySoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    } 

    public function exportTypicalMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportTypicalMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalMonthlySoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportTypicalYear()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportTypicalYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalYearSoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportTypicalSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportTypicalSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalSeasonsSoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportTypicalGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportTypicalGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalGrowingSeasonsSoilWater' . $this->exportSuffix);

        Utils::addUsage('export_soil_water');

        return $response;
    }

    public function exportStatistics()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SOILWATER_EXPORT);        
        $data = $exportEngine->exportSoilWaterStatistics();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'waterBalanceStats' . $this->exportSuffix);
        
        return $response;
    }

    public function exportConfig()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportSoilConfiguration();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'watbalConfig' . $this->exportSuffix);        
        return $response;
    } 
    
    /* OTHER ACTIONS */
    /*****************/
    public function uploadParamFile()
    {
        set_time_limit(0);

        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');   
               
        $formData = $this->request->getData();  

        try {
            $paramData = $formData;

            // captcha verification
                if (!$paramData['token']) {
                    throw new Exception('No captcha token present!');
                }
                // $this->verifyRecaptcha($paramData['token']);

            $uploadedFile = Utils::uploadFile($formData['inputDataFile']);            
            
            // import params to db
            Utils::writeMetadataParamsToDb($uploadedFile, 'wb');
            // import calib pairs to db
            Utils::writeMetadataSoilCalibToDb($uploadedFile);
            
            Utils::removeFile($uploadedFile);                       
            
            $this->Flash->success(__('The analysis parameters data has been succesfully loaded!')); //Uploaded file: ' . $formData['inputDataFile']['name']));
            
            $response = array(
                'success' => true                
            );
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 13:                    
                    $this->Flash->error(__($e->getMessage()));
                    break;
                default:
                    $this->Flash->error(__('Error uploading file! ' . $e->getMessage()));
                    break;
            }             
            // return $this->redirect(['action' => 'load-data']);

            $response = array(
                'success' => false
            ); 
        }   
        
        $this->set('response', $response);
        $this->set('_serialize', 'response');    
        // return $this->redirect(['action' => 'analysis']);             
    }

    private function verifyRecaptcha($token)
    {
        $apiUrl = "https://www.google.com/recaptcha/api/siteverify";
        $data = array(        
            "secret" => "6Lf-FlYgAAAAALUAd4l54zRb8HBxybnySez25YbH",
            "response" => $token        
        );

        // Log::debug('pre curl');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        Log::debug($json);
        $info = json_decode($json);            

        if (!$info->success) {
            throw new Exception('Captcha Verification Failed!');
        }
    }

    public function performAnalysis()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');  

        // form params
        $formData = $this->request->getData();
        // Log::debug('form: ' . json_encode($formData));                

        try {                 
            // save calibration mappings if they exist
            if (!empty($formData['output1_select']) && !empty($formData['ucd1_select']) && !empty($formData['output2_select']) && !empty($formData['ucd2_select'])) {  
                $calibrationData = [
                    [ // pair 1
                        'output' => $formData['output1_select'],
                        'ucd' => $formData['ucd1_select']
                    ],
                    [ // pair 2
                        'output' => $formData['output2_select'],                
                        'ucd' => $formData['ucd2_select']
                    ]
                ];
                // Log::debug('calib: ' . json_encode($calibrationData));   
                Utils::writeSoilCalMapToDb($calibrationData);           
                unset($formData['output1_select']);
                unset($formData['output2_select']);
                unset($formData['ucd1_select']);
                unset($formData['ucd2_select']);
            }

            // save new analysis params
            // Log::debug('params: ' . json_encode($formData));   
            Utils::writeParamsToDb($formData, 'wb');                           
            
            // perform analysis
            $analysis = new SoilwaterAnalysisEngine();   
            $status = $analysis->run();     
            
            if ($status == -1) { // if analysis was stopped
                Utils::setStopAnalysisFlag(false);

                // delete any output                                                                              
                Utils::removeSoilWaterDataset();

                // return $this->redirect(['action' => 'analysis']);
                $response = array(
                    'success' => false,
                    'has_error' => false,
                    'user_stopped' => true
                );
            } else { 
                // calculate averaging data
                $averagingEngine = new AveragingEngine(AveragingEngine::SOIL_WATER_AVERAGING);
                $averagingEngine->run();            
    
                Utils::setUserSoilWater(1);                        

                // $this->Flash->success(__('Analysis complete!'));            
                // return $this->redirect(['action' => 'graph']);     
            
                $response = array(
                    'success' => true
                );            
            }                         
        } catch (Exception $e){
            $this->Flash->error(__('Error performing analysis! Error: ' . $e->getMessage()));
            // return $this->redirect(['action' => 'analysis']);

            $response = array(
                'success' => false,
                'has_error' => true
            );
        } 

        $this->set('response', $response);
        $this->set('_serialize', 'response'); 
    }

    public function stopAnalysis()
    {             
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');                          

        try {
            Utils::setStopAnalysisFlag(true);
        } catch (Exception $e) {
                                         
        }    
        
        $response = array(
            'success' => true
        );
        $this->set('response', $response);
        $this->set('_serialize', 'response');        
    }

    public function resetAnalysis()
    {             
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');                          

        try {
            Utils::removeSoilWaterDataset(); 
        } catch (Exception $e) {
                                         
        }    
        
        $response = array(
            'success' => true
        );
        $this->set('response', $response);
        $this->set('_serialize', 'response');        
    }

    public function fetchOutputData()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');         

        // query params
        $params = $this->request->getParsedBody();
        $graphSource = $params['graphSource'];
        $draw = (int)$params['draw'];
        $length = (int)$params['length'];
        $start = (int)$params['start'];      
        $search = $params['search']['value'];

        $fetchedData = Utils::fetchSoilWaterOutputFromDb($graphSource, $length, $start, $search);        

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $fetchedData['recordsTotal'],
            'recordsFiltered' => $fetchedData['recordsFiltered'],
            'data' => $fetchedData['recordsData']          
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }    

    public function fetchOutputDataStats()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');  
        
        $params = $this->request->getParsedBody();
        $startDate = $params['startDate'] ?: null;
        $endDate = $params['endDate'] ?: null;
        $statsData = [];

        $temp = Utils::fetchSoilWaterStatsFromDb('temp', $startDate, $endDate)[0];      
        $precip = Utils::fetchSoilWaterStatsFromDb('precip', $startDate, $endDate)[0];      
        $rain = Utils::fetchSoilWaterStatsFromDb('rain', $startDate, $endDate)[0];      
        $snow_mm = Utils::fetchSoilWaterStatsFromDb('snow_mm', $startDate, $endDate)[0];                    
        $water_or_sr = Utils::fetchSoilWaterStatsFromDb('water_or_sr', $startDate, $endDate)[0];  
        // $infcap = Utils::fetchSoilWaterStatsFromDb('infcap', $startDate, $endDate)[0];  
        $inf_cap_corr = Utils::fetchSoilWaterStatsFromDb('inf_cap_corr', $startDate, $endDate)[0];  
        // $dracap = Utils::fetchSoilWaterStatsFromDb('dracap', $startDate, $endDate)[0];  
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
            // Utils::formatDataDecimals('infcap', $infcap['average']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['average']),
            // Utils::formatDataDecimals('dracap', $dracap['average']),
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
            // Utils::formatDataDecimals('infcap', $infcap['minimum']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['minimum']),
            // Utils::formatDataDecimals('dracap', $dracap['minimum']),
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
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['minimum']);
        }
        $statsData[] = $newDataLine;

        $newDataLine = array(
            'Max',
            Utils::formatDataDecimals('temp', $temp['maximum']),
            Utils::formatDataDecimals('precip', $precip['maximum']),
            Utils::formatDataDecimals('rain', $rain['maximum']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['maximum']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['maximum']),
            // Utils::formatDataDecimals('infcap', $infcap['maximum']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['maximum']),
            // Utils::formatDataDecimals('dracap', $dracap['maximum']),
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
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['maximum']);
        }
        $statsData[] = $newDataLine;

        $newDataLine = array(
            'Std Dev',            
            Utils::formatDataDecimals('temp', $temp['std_dev']),
            Utils::formatDataDecimals('precip', $precip['std_dev']),
            Utils::formatDataDecimals('rain', $rain['std_dev']),
            Utils::formatDataDecimals('snow_mm', $snow_mm['std_dev']),
            Utils::formatDataDecimals('water_or_sr', $water_or_sr['std_dev']),
            // Utils::formatDataDecimals('infcap', $infcap['std_dev']),
            Utils::formatDataDecimals('inf_cap_corr', $inf_cap_corr['std_dev']),
            // Utils::formatDataDecimals('dracap', $dracap['std_dev']),
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
            $newDataLine[] = Utils::formatDataDecimals('ucd', Utils::fetchSnowStatsFromDb('ucd'.($i+1), $startDate, $endDate)[0]['std_dev']);
        }
        $statsData[] = $newDataLine;

        $response = array(            
            'startDate' => $startDate,
            'endDate' => $endDate,
            'data' => $statsData     
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function fetchCalibStats()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');    

        // parse params to find out the type of calib stats requested
        $params = $this->request->getParsedBody();
        // Log::debug('Snow fetchCalibStats for type: ' . $params['type']);

        $type = !empty($params['type']) ? $params['type'] : 1;              

        $startDate = !empty($params['startDate']) ? $params['startDate'] : null;               
        $endDate = !empty($params['endDate']) ? $params['endDate'] : null;       

        $startIndex = null;
        $endIndex = null;
        if ($startDate && $endDate) {
            $startIndex = Utils::getIndexForGivenDate($type, $startDate);
            $endIndex = Utils::getIndexForGivenDate($type, $endDate);
        }
        // Log::debug('start ' . $startDate . ' ' . $startIndex);
        // Log::debug('end ' . $endDate . ' ' . $endIndex);
        
        if ($startIndex <= $endIndex) {
            $statsData = $this->formatCalibStatsData($type, $startIndex, $endIndex);        
        } else {
            $statsData = $this->formatCalibStatsData($type, $endIndex, $startIndex);        
        }      
                         
        $response = array(                 
            'data' => $statsData         
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    private function formatCalibStatsData($type, $startIndex, $endIndex)
    {
        $statsData = $this->calculateCalibStats($type, $startIndex, $endIndex);

        return array(
            array(
                'R<sup>2</sup>',
                number_format($statsData['r_2'][0],3),
                !empty($statsData['r_2'][1]) ? number_format($statsData['r_2'][1],3) : number_format($statsData['r_2'][0],3)
            ),
            array(
                'RMSE',
                number_format($statsData['rmsd'][0],3),
                !empty($statsData['rmsd'][1]) ? number_format($statsData['rmsd'][1],3) : number_format($statsData['rmsd'][0],3)                  
            ),
            array(
                'NRMSE<sub>ave</sub>',
                number_format($statsData['nrmsd_mean'][0],3),
                !empty($statsData['nrmsd_mean'][1]) ? number_format($statsData['nrmsd_mean'][1],3) : number_format($statsData['nrmsd_mean'][0],3)                                            
            ),
            array(
                'NRMSE<sub>IQR</sub>',
                number_format($statsData['nrmse_iqr'][0],3),
                !empty($statsData['nrmse_iqr'][1]) ? number_format($statsData['nrmse_iqr'][1],3) : number_format($statsData['nrmse_iqr'][0],3)                             
            ),
            array(
                'NRMSE<sub>min_max</sub>',
                number_format($statsData['nrmsd_minmax'][0],3),
                !empty($statsData['nrmsd_minmax'][1]) ? number_format($statsData['nrmsd_minmax'][1],3) : number_format($statsData['nrmsd_minmax'][0],3)                             
            )
        );
    }    

    private function calculateCalibStats($type, $startIndex, $endIndex)
    {                            
        return Utils::calculateBivariableStats('SoilCalibration', $type, $startIndex, $endIndex);
    }

    public function getCalibTracePairs()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json'); 
        
        $params = $this->request->getParsedBody();
        $type = !empty($params['type']) ? $params['type'] : 1;

        $calibFields = Utils::getSoilCalibrationFields();
        $preparedFieldsArray = array();
        foreach ($calibFields as $item) {
            $preparedFieldsArray[] = $item;
        }
        if (count($preparedFieldsArray) == 2) {
            $preparedFieldsArray[2] = $preparedFieldsArray[0];
            $preparedFieldsArray[3] = $preparedFieldsArray[1];
        }
        // Log::debug(json_encode($preparedFieldsArray));
        $uniquePreparedFieldsArray = array_unique($preparedFieldsArray);
        // Log::debug(json_encode($uniquePreparedFieldsArray));
        
        switch ($type) {
            case 1: 
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataOverlay', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataOverlay', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 2:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataMonthly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataMonthly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 10:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 11:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataGrowingSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataGrowingSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 3:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataYearly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataYearly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 21: 
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataTypical', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataTypical', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 22:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataTypicalMonthly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataTypicalMonthly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 24:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataTypicalSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataTypicalSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 25:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataTypicalGrowingSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataTypicalGrowingSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 23:
                $timeData = Utils::fetchFieldFromDb('SoilWaterDataTypicalYearly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SoilWaterDataTypicalYearly', $uniquePreparedFieldsArray, count($timeData));
                break;
        }
        // Log::debug(json_encode($tracesData));

        $response = array(          
            'timeData' => $timeData,        
            'pair1' => array(
                'trace1Data' => array_column($tracesData, $preparedFieldsArray[0]),        
                'trace2Data' => array_column($tracesData, $preparedFieldsArray[1]) 
            ),
            'pair2' => array(
                'trace1Data' => array_column($tracesData, $preparedFieldsArray[2]), 
                'trace2Data' => array_column($tracesData, $preparedFieldsArray[3])
            )            
        );        

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }    

    public function getTraceData()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');

        // query params
        $params = $this->request->getParsedBody();
        $graphSource = $params['graphSource'];
        $graphType = $params['graphType'];

        $fetchedData = Utils::getTraceData($graphSource, $graphType);    

        $response = array(          
            'data' => $fetchedData          
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function getTimeData()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');

        // query params
        $params = $this->request->getParsedBody();
        $graphSource = $params['graphSource'];
       
        $fetchedData = Utils::fetchTimeDataFromDb($graphSource);        
        
        $response = array(          
            'data' => $fetchedData          
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function getTimeIndexValue()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');

        // query params
        $params = $this->request->getParsedBody();
        $index = $params['index'];

        $fetchedData = Utils::fetchTimeDataByIndexFromDb($index);           
        $filteredDateOnly = explode('T', $fetchedData['time_date'])[0];     
        $date = Time::parse($filteredDateOnly);
        
        $response = array(          
            'data' => $date->i18nFormat('YYYY-MM-dd')
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    } 
    
}