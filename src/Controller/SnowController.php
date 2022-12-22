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
        // $this->set('hasSoilData', Utils::hasSoilData());

        $this->set('tooltips', Utils::getTooltips());

        $this->set('ucdFields', array(
            'total' => Utils::getValidationColumnsCount(),
            'ucd1' => Utils::getUcdAvgMethod('ucd1'),
            'ucd2' => Utils::getUcdAvgMethod('ucd2'),
            'ucd3' => Utils::getUcdAvgMethod('ucd3'),
            // 'ucd4' => Utils::getUcdAvgMethod('ucd4'),
            // 'ucd5' => Utils::getUcdAvgMethod('ucd5'),
        ));

        $this->exportPrefix = 'SBUDDY_';        
        $now = Time::now();
        $this->exportSuffix = '_' . $now->toTimeString() . '.csv';
    }

    public function beforeFilter(Event $event)
    {            
        if (!Utils::isInputDataLoaded()){
            $this->Flash->error(__("Please load data before accessing the 'Analysis' module!"));

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
        // Log::debug($calibFieldNames);

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
        $response = $response->withDownload($this->exportPrefix . 'dailyOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    } 

    public function exportMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'monthlyOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportYearly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'yearlyOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'seasonsOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'growingSeasonsOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportTypicalDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalDaily();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalDailyOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    } 

    public function exportTypicalMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalMonthly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalMonthlyOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportTypicalYear()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalYearly();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalYearOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportTypicalSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalSeasonsOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportTypicalGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportTypicalGrowingSeasons();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalGrowingSeasonsOutput' . $this->exportSuffix);

        Utils::addUsage('export_output');

        return $response;
    }

    public function exportStatistics()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::SNOW_EXPORT);        
        $data = $exportEngine->exportSnowStatistics();

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'outputStats' . $this->exportSuffix);

        return $response;
    }    

    public function exportConfig()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        // $data = $exportEngine->exportSnowConfiguration();
        $data = $exportEngine->exportGlobalConfiguration();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'config' . $this->exportSuffix);        
        return $response;
    } 
    
    /* OTHER ACTIONS */
    /*****************/       
    public function resetParamsToDefault()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');   
               
        $formData = $this->request->getData();  

        try {                        
            // reset params
            Utils::writeDefaultParamsToDb(Utils::getDefaultParams(), 'sbuddy');
            // reset calib            
            Utils::writeSnowCalMapToDb(Utils::getDefaultCalibMap());  

            // also reset output because id doesn't match the params aymore
            Utils::removeSnowDataset();    
            
            $this->Flash->success(__('The analysis parameters have been succesfully reset!')); 
            
            $response = array(
                'success' => true                
            );
        } catch (Exception $e) {
            $this->Flash->error(__('Error resetting params! ' . $e->getMessage()));

            $response = array(
                'success' => false
            ); 
        }   
        
        $this->set('response', $response);
        $this->set('_serialize', 'response');    
    }

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
            Utils::removeParamsDataset();
            Utils::writeParamsToDb($formData, 'sbuddy');           
            
            //perform snow analysis
            $analysis = new SnowAnalysisEngine();   
            $status = $analysis->run();   
            
            if ($status == -1) { // if analysis was stopped
                Utils::setStopAnalysisFlag(false);

                // delete any output
                Utils::removeSnowDataset();                    
                // Utils::removeSoilWaterDataset();                                               
                
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
    
                Utils::setUserOutputReady(1);
                // Utils::setUserSoilWater(0);                        

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
            // Utils::removeSoilWaterDataset(); 
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
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('snow_cm', Utils::fetchSnowStatsFromDb('snow_cm', $startDate, $endDate)[0]['average']),
            Utils::formatDataDecimals('rain_mm', Utils::fetchSnowStatsFromDb('rain_mm', $startDate, $endDate)[0]['average'])            
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
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('snow_cm', Utils::fetchSnowStatsFromDb('snow_cm', $startDate, $endDate)[0]['minimum']),
            Utils::formatDataDecimals('rain_mm', Utils::fetchSnowStatsFromDb('rain_mm', $startDate, $endDate)[0]['minimum'])                       
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
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('snow_cm', Utils::fetchSnowStatsFromDb('snow_cm', $startDate, $endDate)[0]['maximum']),
            Utils::formatDataDecimals('rain_mm', Utils::fetchSnowStatsFromDb('rain_mm', $startDate, $endDate)[0]['maximum'])                                           
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
            Utils::formatDataDecimals('snow_mm', Utils::fetchSnowStatsFromDb('snow_mm', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('snow_cm', Utils::fetchSnowStatsFromDb('snow_cm', $startDate, $endDate)[0]['std_dev']),
            Utils::formatDataDecimals('rain_mm', Utils::fetchSnowStatsFromDb('rain_mm', $startDate, $endDate)[0]['std_dev'])                                           
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