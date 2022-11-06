<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Chronos\Date;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Log\Log;

use App\Model\Utils;
use App\Model\AveragingEngine;
use App\Model\ExportEngine;
class InputController extends AppController
{   

    private $exportPrefix;
    private $exportSuffix;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->viewBuilder()->setLayout('project');

        $this->set('title', 'SNOW BUDDY');
        $this->set('activeNavbarId', 'input');    

        $this->set('hasInputData', Utils::hasInputData());
        // $this->set('hasSnowData', Utils::hasSnowData());
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
        
        $this->exportPrefix = 'SNOW BUDDY_';        
        $now = Time::now();
        $this->exportSuffix = '_' . $now->toTimeString() . '.csv';
    }

    /* VIEWS */
    /*********/
    public function getPhpInfo()
    {
        phpinfo();
    }

    public function index()
    {
        $this->redirect('/input/info');
    }

    public function info()
    {
        $this->set('activeMenuNavId', 'info');

        $isSetGrowthSeason = Utils::isSetGrowthSeason();
        $this->set('isSetGrowthSeason', $isSetGrowthSeason);
    }
   
    public function loadData()
    {
        $this->set('activeMenuNavId', 'load-data');  
                
        $isSetGrowthSeason = Utils::isSetGrowthSeason();
        if ($isSetGrowthSeason){
            $params = Utils::getParams();
            $this->set('gsStart', $params['gs_start_month'] . '-' . $params['gs_start_day']);
            $this->set('gsEnd', $params['gs_end_month'] . '-' . $params['gs_end_day']);
        } else {
            $this->set('gsStart', '06-01');
            $this->set('gsEnd', '09-30');
        }        
    }   

    public function table()
    {
        $this->set('activeMenuNavId', 'table');      

        $isSetGrowthSeason = Utils::isSetGrowthSeason();
        $this->set('isSetGrowthSeason', $isSetGrowthSeason);
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);
    } 

    public function graph()
    {
        $this->set('activeMenuNavId', 'graph');      

        $isSetGrowthSeason = Utils::isSetGrowthSeason();
        $this->set('isSetGrowthSeason', $isSetGrowthSeason);
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);
    }

    public function resetData()
    {
        Utils::removeCompleteDataset();
        $this->redirect('/input/load-data');
    }

    /* DATA EXPORT */
    /***************/

    public function exportDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportDaily();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'dailyInput' . $this->exportSuffix);
        return $response;
    } 

    public function exportMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportMonthly();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'monthlyInput' . $this->exportSuffix);
        return $response;
    }

    public function exportYearly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportYearly();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'yearlyInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportSeasons();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'seasonsInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportGrowingSeasons();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'growingSeasonsInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportTypicalDaily()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportTypicalDaily();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalDailyInput' . $this->exportSuffix);        
        return $response;
    } 

    public function exportTypicalMonthly()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportTypicalMonthly();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalMonthlyInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportTypicalYear()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportTypicalYearly();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalYearInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportTypicalSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportTypicalSeasons();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalSeasonsInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportTypicalGrowingSeasons()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportTypicalGrowingSeasons();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalGrowingSeasonsInput' . $this->exportSuffix);        
        return $response;
    }

    public function exportStatistics()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportInputStatistics();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'inputStats' . $this->exportSuffix);        
        return $response;
    }

    public function exportMetadata()
    {
        $response = $this->response;

        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $data = $exportEngine->exportGlobalConfiguration();

        $response = $response->withStringBody($data);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'globalConfig' . $this->exportSuffix);        
        return $response;
    } 

    /* DATA ACTIONS */
    /****************/
    
    public function uploadInputFile()
    {
        set_time_limit(0);

        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');   
               
        $formData = $this->request->getData();  

        try {
            // throw new Exception('test file is ' . $formData['testFileStatus']);

            // remove the previous dataset version
            Utils::removeCompleteDataset();     
            
            // using test file?
            $usingTestFile = $formData['testFileStatus'] ? true : false;

            // save growth season params
            $paramData = $formData;

            // captcha verification
                if (!$paramData['token']) {
                    throw new Exception('No captcha token present!');
                }
                // $this->verifyRecaptcha($paramData['token']);

            // remove all query params so that only useful params remaing
            unset($paramData['inputDataFile']);
            unset($paramData['inputHasHeaders']);
            unset($paramData['testFileStatus']);
            unset($paramData['token']); // this is the captcha token
            // Utils::validateGrowthSeasonParams($paramData);
            Utils::writeParamsToDb($paramData, 'input');

            // die(json_encode($formData['inputDataFile']));

            // upload file
            if (!$usingTestFile){ // user input file
                $uploadedFile = Utils::uploadFile($formData['inputDataFile']);                    
                Utils::writeInputToDb($uploadedFile, (bool)$formData['inputHasHeaders']);
                Utils::removeFile($uploadedFile);        
            } else { // test file
                $uploadedFile = WWW_ROOT . '/project/test_data.csv';
                Utils::writeInputToDb($uploadedFile, (bool)$formData['inputHasHeaders']);
            }

            Utils::setUserDataLoaded(1, $usingTestFile);

            // get number of ucd fields
            $ucdFields = Utils::getValidationColumnsCount();                        

            $this->Flash->success(__('The input data has been succesfully loaded!')); //Uploaded file: ' . $formData['inputDataFile']['name']));
            // return $this->redirect(['action' => 'graph']);             

            $response = array(
                'success' => true,
                'ucdFields' => $ucdFields
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

    public function runAverages()
    {
        set_time_limit(0);

        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');   
               
        $formData = $this->request->getData();  
        // Log::debug('formData: ' . json_encode($formData));

        try {
            // throw new Exception('test');            
                        
            Utils::setUcdAvg($formData);

            // calculate averaging data
            $averagingEngine = new AveragingEngine(AveragingEngine::INPUT_AVERAGING);
            $averagingEngine->run();

            $this->Flash->success(__('The input data has been succesfully loaded!')); //Uploaded file: ' . $formData['inputDataFile']['name']));

            $response = array(
                'success' => true
            ); 
        } catch (Exception $e) {
            $this->Flash->error(__('Error performing the averaging! ' . $e->getMessage()));

            $response = array(
                'success' => false
            );                               
        }        

        $this->set('response', $response);
        $this->set('_serialize', 'response');     
    }

    public function resetUcdAverages()
    {
        set_time_limit(0);

        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');   
               
        $formData = $this->request->getData();  
        // Log::debug('formData: ' . json_encode($formData));
      
        try {
            Utils::setUcdAvg($formData);

            // calculate averaging data       
            Utils::removeInputAveragingDataset();     
            $averagingEngine = new AveragingEngine(AveragingEngine::INPUT_AVERAGING);
            $averagingEngine->run();

            if (Utils::hasSnowData()) {          
                Utils::removeSnowAveragingDataset();      
                $averagingEngine = new AveragingEngine(AveragingEngine::SNOW_AVERAGING);
                $averagingEngine->run();
            }

            if (Utils::hasSoilData()) {              
                Utils::removeSoilWaterAveragingDataset();  
                $averagingEngine = new AveragingEngine(AveragingEngine::SOIL_WATER_AVERAGING);
                $averagingEngine->run();
            }

            $this->Flash->success(__('The UCD averages were successfully calculated!'));

            $response = array(
                'success' => true
            ); 
        } catch (Exception $e) {
            $this->Flash->error(__('Error performing the averaging! ' . $e->getMessage()));

            $response = array(
                'success' => false
            );                               
        }        

        $this->set('response', $response);
        $this->set('_serialize', 'response');     
    }

    public function fetchInputData()
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

        $fetchedData = Utils::fetchInputFromDb($graphSource, $length, $start, $search);        

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $fetchedData['recordsTotal'],
            'recordsFiltered' => $fetchedData['recordsFiltered'],
            'data' => $fetchedData['recordsData']          
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function fetchInputDataStats()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');      
        
        $params = $this->request->getParsedBody();
        $startDate = $params['startDate'] ?: null;
        $endDate = $params['endDate'] ?: null;

        $tempStats = Utils::fetchInputStatsFromDb('temp', $startDate, $endDate)[0];   
        $precipStats = Utils::fetchInputStatsFromDb('precip', $startDate, $endDate)[0];                
        $ucd1Stats = Utils::fetchInputStatsFromDb('ucd1', $startDate, $endDate)[0];   
        $ucd2Stats = Utils::fetchInputStatsFromDb('ucd2', $startDate, $endDate)[0];   
        $ucd3Stats = Utils::fetchInputStatsFromDb('ucd3', $startDate, $endDate)[0];   

        $statsData = [];
        $statsData[] = array(
            'Avg',
            Utils::formatDataDecimals('temp', $tempStats['average']),
            Utils::formatDataDecimals('precip', $precipStats['average']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['average']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['average']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['average']),
        );
        $statsData[] = array(
            'Min',
            Utils::formatDataDecimals('temp', $tempStats['minimum']),
            Utils::formatDataDecimals('precip', $precipStats['minimum']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['minimum']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['minimum']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['minimum']),
        );
        $statsData[] = array(
            'Max',
            Utils::formatDataDecimals('temp', $tempStats['maximum']),
            Utils::formatDataDecimals('precip', $precipStats['maximum']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['maximum']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['maximum']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['maximum']),
        );
        $statsData[] = array(
            'Std Dev',
            Utils::formatDataDecimals('temp', $tempStats['std_dev']),
            Utils::formatDataDecimals('precip', $precipStats['std_dev']),
            Utils::formatDataDecimals('ucd1', $ucd1Stats['std_dev']),         
            Utils::formatDataDecimals('ucd2', $ucd2Stats['std_dev']),
            Utils::formatDataDecimals('ucd3', $ucd3Stats['std_dev']),
        );

        $response = array(       
            'startDate' => $startDate,
            'endDate' => $endDate,     
            'data' => $statsData         
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function getDatasetLength()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');                

        $response = array(          
            'datasetLength' => Utils::getCurrentDatasetLength()        
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