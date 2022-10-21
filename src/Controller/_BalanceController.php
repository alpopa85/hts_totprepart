<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Exception\Exception;
use Cake\Chronos\Date;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Log\Log;

use App\Model\Utils;
use App\Model\AnalysisEngine;
use App\Model\AveragingEngine;
use App\Model\ExportEngine;
use stdClass;

class BalanceController extends AppController
{

    private $exportPrefix;
    private $exportSuffix;
    private $requiredBalanceFieldsForExport;
    private $requiredInputFieldsForExport;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
      
        $this->viewBuilder()->setLayout('project');

        $this->set('title', 'WATBAL');
        $this->set('activeNavbarId', 'balance');  
        
        $this->exportPrefix = 'swib_';        
        $now = Time::now();
        $this->exportSuffix = '_' . $now->toTimeString() . '.csv';

        $this->requiredBalanceFieldsForExport = array(
            'time_index',
            'time_name',
            'mm_h20',
            'et_lost',
            'et_soil',
            'wchg_loss',
            'wchg_gain',
            'drain',
            'inf',
            'sr'           
        );
        $this->requiredInputFieldsForExport = array(
            'precip',
            'et'
        );
    }

    public function beforeFilter(Event $event)
    {            
        if (!Utils::isInputDataLoaded()){
            $this->response = $this->redirect('/input/load-data'); 
            return $this->response;
        }

        if (!Utils::isSnowComplete()){
            $this->response = $this->redirect('/deficit/analysis'); 
            return $this->response;
        }

        // if (!Utils::isIrrigationComplete()){
        //     $this->response = $this->redirect('/irrigation/analysis'); 
        //     return $this->response;
        // }
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

        $params = Utils::getParams();                

        $viewData = array(
            'paramData' => $params            
        );
        $this->set($viewData);
    }    

    public function table()
    {
        $this->set('activeMenuNavId', 'table');        
    } 

    public function graph()
    {
        $this->set('activeMenuNavId', 'graph');       
        
        $nValidationColumns = Utils::getValidationColumnsCount();
        $this->set('nValidationColumns', $nValidationColumns);
    }        

    public function exportDaily()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportDaily($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportDaily($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');        
        $response = $response->withDownload($this->exportPrefix . 'dailyBalance' . $this->exportSuffix);
        
        Utils::addUsage('export_balance');
        
        return $response;
    } 

    public function exportMonthly()
    {
        $response = $this->response;        

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportMonthly($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportMonthly($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'monthlyBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportYearly()
    {
        $response = $this->response;
        
        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportYearly($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportYearly($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'yearlyBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportSeasons()
    {
        $response = $this->response;
        
        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportSeasons($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportSeasons($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'seasonsBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportGrowingSeasons()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportGrowingSeasons($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportGrowingSeasons($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'growingSeasonsBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportTypicalDaily()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportTypicalDaily($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportTypicalDaily($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalDailyBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    } 

    public function exportTypicalMonthly()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportTypicalMonthly($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportTypicalMonthly($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalMonthlyBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportTypicalYear()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportTypicalYearly($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportTypicalYearly($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalYearBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportTypicalSeasons()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportTypicalSeasons($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportTypicalSeasons($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalSeasonsBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportTypicalGrowingSeasons()
    {
        $response = $this->response;        

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportTypicalGrowingSeasons($this->requiredBalanceFieldsForExport, true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportTypicalGrowingSeasons($this->requiredInputFieldsForExport, true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        // merge the two collections
        $currentIndex = 0;
        $finalData = array();
        foreach ($dataBalance as $rowBalance) {
            $newData = new stdClass;
            $newData->time_index = $rowBalance->time_index;
            $newData->time_name = $rowBalance->time_name;
            $newData->mm_h20 = $rowBalance->mm_h20;
            $newData->precip = $dataInput[$currentIndex]->precip;
            $newData->et_total = $dataInput[$currentIndex]->et;
            $newData->et_lost = $rowBalance->et_lost;
            $newData->et_soil = $rowBalance->et_soil;
            $newData->wchg_loss = $rowBalance->wchg_loss;
            $newData->wchg_gain = $rowBalance->wchg_gain;
            $newData->drain = $rowBalance->drain;
            $newData->inf = $rowBalance->inf;
            $newData->sr = $rowBalance->sr;
            $finalData[] = $newData;                

            $currentIndex++;
        }
        // Log::debug('finalData' . ' | ' . json_encode($finalData));

        $data = $exportEngine->formatCsv($finalData);

        $response = $response->withStringBody($data);
        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'typicalGrowingSeasonsBalance' . $this->exportSuffix);

        Utils::addUsage('export_balance');

        return $response;
    }

    public function exportStatistics()
    {
        $response = $this->response;

        // get balance data
        $exportEngine = new ExportEngine(ExportEngine::WATER_BALANCE_EXPORT);        
        $dataBalance = $exportEngine->exportWaterBalanceStatistics(true);
        // Log::debug('dataBalance' . ' | ' . json_encode($dataBalance));

        // get input data
        $exportEngine = new ExportEngine(ExportEngine::INPUT_EXPORT);        
        $dataInput = $exportEngine->exportInputStatistics(true);        
        // Log::debug('dataInput' . ' | ' . json_encode($dataInput));

        $csvRowCollection = [];
        $currentIndex = 0;
        foreach($dataBalance as $dataRow){  
            $csvRow = [];
                                    
            // only values after first row
            foreach($dataRow as $value){                    
                $csvRow[] = $value;                                                        
            }
            $csvRow[2] = $dataInput[$currentIndex][1]; // precip
            $csvRow[3] = $dataInput[$currentIndex][3]; // et total
            $csvRowCollection[] = implode(',', $csvRow);

            $currentIndex++;
        }        

        $finalData = implode(PHP_EOL, $csvRowCollection);                

        $response = $response->withStringBody($finalData);

        $response = $response->withType('csv');
        $response = $response->withDownload($this->exportPrefix . 'balanceStats' . $this->exportSuffix);
        return $response;
    }
    
    /* OTHER ACTIONS */
    /*****************/

    public function performAnalysis()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');  

        // form params
        $formData = $this->request->getData();

        try {                                

            // save new params
            Utils::writeParamsToDb($formData);           
            
            // perform analysis
            $analysis = new AnalysisEngine([
                AnalysisEngine::VWC,
                AnalysisEngine::MM_H20,
                AnalysisEngine::WCHG,
                AnalysisEngine::WB
            ]);   
            $analysis->run();     
            
            Utils::setUserWaterBalance(1);
            
            // calculate averaging data
            $averagingEngine = new AveragingEngine(AveragingEngine::WATER_BALANCE_AVERAGING);
            $averagingEngine->run();
            
            $this->Flash->success(__('Analysis complete!'));
            return $this->redirect(['action' => 'table']);            
        } catch (Exception $e){
            $this->Flash->error(__('Error performing analysis! Error: ' . $e->getMessage()));
            return $this->redirect(['action' => 'analysis']);
        } 
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

        $inputData = Utils::fetchInputFromDb($graphSource, $length, $start, $search);
        $fetchedData = Utils::fetchWaterBalanceOutputFromDb($graphSource, $length, $start, $search);        

        $finalData = array();
        $currentIndex = 0;
        foreach ($fetchedData['recordsData'] as $balanceData){
            $balanceData[3] = $inputData['recordsData'][$currentIndex][2]; // precip
            $balanceData[4] = $inputData['recordsData'][$currentIndex][4]; // et_total            
            $finalData[] = $balanceData;            
            $currentIndex++;
        }

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $fetchedData['recordsTotal'],
            'recordsFiltered' => $fetchedData['recordsFiltered'],
            'data' => $finalData
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }    

    public function fetchOutputDataStats()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');                 

        $mm_h20 = Utils::fetchWaterBalanceStatsFromDb('mm_h20')[0];   
        $wchg_loss = Utils::fetchWaterBalanceStatsFromDb('wchg_loss')[0];   
        $wchg_gain = Utils::fetchWaterBalanceStatsFromDb('wchg_gain')[0];           
        $drain = Utils::fetchWaterBalanceStatsFromDb('drain')[0]; 
        $inf = Utils::fetchWaterBalanceStatsFromDb('inf')[0];           
        $sr = Utils::fetchWaterBalanceStatsFromDb('sr')[0];     
        $et_lost = Utils::fetchWaterBalanceStatsFromDb('et_lost')[0]; 
        $et_soil = Utils::fetchWaterBalanceStatsFromDb('et_soil')[0];       

        // from Input
        $precip = Utils::fetchInputStatsFromDb('precip')[0];        
        $et_total = Utils::fetchInputStatsFromDb('et')[0];   

        $statsData = [];
        $statsData[] = array(
            'Average',
            Utils::formatDataDecimals('h20', $mm_h20['average']),
            Utils::formatDataDecimals('precip', $precip['average']),
            Utils::formatDataDecimals('et', $et_total['average']),
            Utils::formatDataDecimals('et', $et_lost['average']),
            Utils::formatDataDecimals('et', $et_soil['average']),           
            Utils::formatDataDecimals('wchg', $wchg_loss['average']),
            Utils::formatDataDecimals('wchg', $wchg_gain['average']),
            Utils::formatDataDecimals('drain', $drain['average']),
            Utils::formatDataDecimals('inf', $inf['average']),
            Utils::formatDataDecimals('sr', $sr['average']) 
        );
        $statsData[] = array(
            'Minimum',            
            Utils::formatDataDecimals('h20', $mm_h20['minimum']),
            Utils::formatDataDecimals('precip', $precip['minimum']),
            Utils::formatDataDecimals('et', $et_total['minimum']),
            Utils::formatDataDecimals('et', $et_lost['minimum']),
            Utils::formatDataDecimals('et', $et_soil['minimum']),
            Utils::formatDataDecimals('wchg', $wchg_loss['minimum']),
            Utils::formatDataDecimals('wchg', $wchg_gain['minimum']),
            Utils::formatDataDecimals('drain', $drain['minimum']),
            Utils::formatDataDecimals('inf', $inf['minimum']),
            Utils::formatDataDecimals('sr', $sr['minimum'])        
        );
        $statsData[] = array(
            'Maximum',            
            Utils::formatDataDecimals('h20', $mm_h20['maximum']),
            Utils::formatDataDecimals('precip', $precip['maximum']),
            Utils::formatDataDecimals('et', $et_total['maximum']),
            Utils::formatDataDecimals('et', $et_lost['maximum']),
            Utils::formatDataDecimals('et', $et_soil['maximum']),
            Utils::formatDataDecimals('wchg', $wchg_loss['maximum']),
            Utils::formatDataDecimals('wchg', $wchg_gain['maximum']),
            Utils::formatDataDecimals('drain', $drain['maximum']),
            Utils::formatDataDecimals('inf', $inf['maximum']),
            Utils::formatDataDecimals('sr', $sr['maximum'])      
        );
        $statsData[] = array(
            'Std Dev',                        
            Utils::formatDataDecimals('h20', $mm_h20['std_dev']),
            Utils::formatDataDecimals('precip', $precip['std_dev']),
            Utils::formatDataDecimals('et', $et_total['std_dev']),
            Utils::formatDataDecimals('et', $et_lost['std_dev']),
            Utils::formatDataDecimals('et', $et_soil['std_dev']),
            Utils::formatDataDecimals('wchg', $wchg_loss['std_dev']),
            Utils::formatDataDecimals('wchg', $wchg_gain['std_dev']),
            Utils::formatDataDecimals('drain', $drain['std_dev']),
            Utils::formatDataDecimals('inf', $inf['std_dev']),
            Utils::formatDataDecimals('sr', $sr['std_dev'])       
        );        

        $response = array(            
            'data' => $statsData         
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
    
}