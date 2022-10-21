<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Chronos\Date;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Log\Log;

use App\Model\Utils;
use App\Model\SnowAnalysisEngine;
use App\Model\AveragingEngine;
use App\Model\Entity\SnowCalibration;
use App\Model\ExportEngine;
class SnowController extends AppController
{

    private $exportPrefix;
    private $exportSuffix;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->viewBuilder()->setLayout('project');
        
        $this->set('title', 'SNOW BUDDY');
        $this->set('activeNavbarId', 'snow');

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

        $this->exportPrefix = 'SNOW BUDDY_';        
        $now = Time::now();
        $this->exportSuffix = '_' . $now->toTimeString() . '.csv';
    }

    public function beforeFilter(Event $event)
    {            
        if (!Utils::isInputDataLoaded()){
            $this->Flash->error(__("Please load data before accessing the 'Snow' module!"));

            $this->response = $this->redirect('/input/load-data'); 
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

        $calibration = Utils::getSnowCalibrationFields();
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
        foreach(Utils::getSnowCalibrationFields() as $key => $value) {            
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
        foreach(Utils::getSnowCalibrationFields() as $key => $value) {            
            $calibFieldNames[$key] = explode(' ', Utils::transformKey($value))[0];
        }
        $this->set('calibration', $calibFieldNames);

        $analysisParams = Utils::getParams();
        $this->set('analysisParams', $analysisParams);
    }      
    
    public function exportDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportDaily();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');        
        $response = $response->withDownload($this->exportPrefix . 'dailySnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    } 

    public function exportMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'monthlySnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportYearly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'yearlySnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'seasonsSnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'growingSeasonsSnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportTypicalDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalDaily();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalDailySnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    } 

    public function exportTypicalMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalMonthlySnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportTypicalYear()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalYearSnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportTypicalSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalSeasonsSnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportTypicalGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalGrowingSeasonsSnow' . $this->exportSuffix);

        Utils::addUsage('export_snow');

        return $response;
    }

    public function exportStatistics()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportSnowStatistics();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'SnowStats' . $this->exportSuffix);

        return $response;
    }    

    public function exportConfig()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportSnowConfiguration();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'snowConfig' . $this->exportSuffix);        
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
            Utils::writeMetadataParamsToDb($uploadedFile, 'snow');
            // import calib pairs to db
            Utils::writeMetadataSnowCalibToDb($uploadedFile);
            
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
            // throw new Exception('test error');

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
                Utils::writeSnowCalMapToDb($calibrationData);           
                unset($formData['output1_select']);
                unset($formData['output2_select']);
                unset($formData['ucd1_select']);
                unset($formData['ucd2_select']);
            }

            // save new analysis params
            // Log::debug('params: ' . json_encode($formData));   
            Utils::writeParamsToDb($formData, 'snow');           
            
            //perform snow analysis
            $analysis = new SnowAnalysisEngine();   
            $status = $analysis->run();   
            
            if ($status == -1) { // if analysis was stopped
                Utils::setStopAnalysisFlag(false);

                // delete any output
                Utils::removeSnowDataset();                    
                Utils::removeSoilWaterDataset();                                               
                
                // return $this->redirect(['action' => 'analysis']);
                $response = array(
                    'success' => false,
                    'has_error' => false,
                    'user_stopped' => true
                );
            } else { 
                // calculate averaging data
                $averagingEngine = new AveragingEngine(AveragingEngine::SNOW_AVERAGING);
                $averagingEngine->run();            
    
                Utils::setUserSnow(1);
                Utils::setUserSoilWater(0);                        

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
            Utils::removeSnowDataset();                    
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
        
        $fetchedData = Utils::fetchSnowOutputFromDb($graphSource, $length, $start, $search);        

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
        // Log::debug('from ' . $startDate . ' [' . $startIndex . '] to ' . $endDate . ' [' . $endIndex . ']');        
        
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
        return Utils::calculateBivariableStats('SnowCalibration', $type, $startIndex, $endIndex);
    }

    public function getCalibTracePairs()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');    
        
        $params = $this->request->getParsedBody();
        $type = !empty($params['type']) ? $params['type'] : 1;   

        $calibFields = Utils::getSnowCalibrationFields();
        $preparedFieldsArray = array();
        foreach ($calibFields as $item) {
            $preparedFieldsArray[] = $item;
        }
        if (count($preparedFieldsArray) == 2) {
            $preparedFieldsArray[2] = $preparedFieldsArray[0];
            $preparedFieldsArray[3] = $preparedFieldsArray[1];
        }
        // Log::debug(json_encode($preparedFieldsArray))
        $uniquePreparedFieldsArray = array_unique($preparedFieldsArray);;

        switch ($type) {
            case 1: 
                $timeData = Utils::fetchFieldFromDb('SnowDataOverlay', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataOverlay', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 2:
                $timeData = Utils::fetchFieldFromDb('SnowDataMonthly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataMonthly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 10:
                $timeData = Utils::fetchFieldFromDb('SnowDataSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 11:
                $timeData = Utils::fetchFieldFromDb('SnowDataGrowingSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataGrowingSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 3:
                $timeData = Utils::fetchFieldFromDb('SnowDataYearly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataYearly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 21: 
                $timeData = Utils::fetchFieldFromDb('SnowDataTypical', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataTypical', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 22:
                $timeData = Utils::fetchFieldFromDb('SnowDataTypicalMonthly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataTypicalMonthly', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 24:
                $timeData = Utils::fetchFieldFromDb('SnowDataTypicalSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataTypicalSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 25:
                $timeData = Utils::fetchFieldFromDb('SnowDataTypicalGrowingSeasons', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataTypicalGrowingSeasons', $uniquePreparedFieldsArray, count($timeData));
                break;
            case 23:
                $timeData = Utils::fetchFieldFromDb('SnowDataTypicalYearly', 'time_name');        
                $tracesData = Utils::fetchMultipleFieldsFromDb('SnowDataTypicalYearly', $uniquePreparedFieldsArray, count($timeData));
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