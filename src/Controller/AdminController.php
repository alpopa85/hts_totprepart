<?php

namespace App\Controller;

use Cake\Core\Exception\Exception;
use Cake\I18n\Time;
use Cake\Log\Log;
use App\Model\Utils;
use Cake\ORM\TableRegistry;
use App\Model\ExportEngine;
use stdClass;
class AdminController extends AppController
{
    const ADMIN_PASSWORD_BASE = "baseflow";
    private $adminPassword;
  
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
      
        $this->viewBuilder()->setLayout('project');

        $this->set('title', 'SNOW BUDDY');
        $this->set('activeNavbarId', 'admin');  
                
        $now = Time::now();     
        $nowString = $now->toDateString();
        $nowStringExploded = explode('-',$nowString);
        $this->adminPassword = self::ADMIN_PASSWORD_BASE . $nowStringExploded[2] . $nowStringExploded[1] . $nowStringExploded[0];
    }        

    /* VIEWS */
    /*********/

    public function index()
    {
        $this->setAction('login');
    }

    public function login()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');

        if (Utils::hasAdminAccess()){
            $this->response = $this->redirect(['action' => 'dashboard']); 
            return $this->response;
        }

        // form params
        $formData = $this->request->getData();
        $loginResponse = $this->performLogin($formData['password']);

        try {
            if ($loginResponse){
                Utils::giveUserAdminAccess();

                $this->Flash->success(__('Log In Success!'));
                return $this->redirect(['action' => 'dashboard']);            
            } else {
                $this->Flash->error(__('Incorrect credentials!'));
                return $this->redirect(['controller' => 'main', 'action' => 'index']);
            }            
        } catch (Exception $ex) {
            $this->Flash->error(__('Login Error!'));
            return $this->redirect(['controller' => 'main', 'action' => 'index']);
        }
    }

    public function dashboard()
    {
        if (!Utils::hasAdminAccess()){
            return $this->redirect(['controller' => 'main', 'action' => 'index']);
            return $this->response;
        }

        $viewData = array(     
            'statsData' => null,       
            'mapData' => null,
            'dbData' => array(
                'count' => count(Utils::getExpiredDatasets())      
            )          
        );
        $this->set($viewData);
    }


    /* ACTIONS */
    /***********/
    public function resetDbData()
    {
        $this->viewBuilder()->setClassName('Json');

        if (!Utils::hasAdminAccess()){
            return $this->redirect(['controller' => 'main', 'action' => 'index']);
            return $this->response;
        }

        try{
            $expiredDatasetIds = Utils::getExpiredDatasets();            
            foreach ($expiredDatasetIds as $expiredDataset){
                Utils::removeCompleteDatasetById($expiredDataset);
            }            

            $this->Flash->success(__('Operation Success!'));
            return $this->redirect(['action' => 'dashboard']);
        } catch (Exception $ex) {
            $this->Flash->error(__('Operation Error!'));
            return $this->redirect(['action' => 'dashboard']);
        }        
    }

    private function performLogin($password)
    {
        if (strcmp($password, $this->adminPassword) == 0){
            return true;
        }

        return false;
    }

    public function fetchStatsData()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');         

        // query params
        $params = $this->request->getParsedBody();        
        $draw = (int)$params['draw'];        
        $start = (int)$params['start'];      
        $search = $params['search']['value'];
        $search = null;

        { // validate start and end fields
            // Log::debug('Search values: ' . $params['startDate'] . ' -> ' . $params['endDate']);
            $start = null;
            $end = null;

            if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $params['startDate'])) {
                $start = $params['startDate'];
            };

            if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $params['endDate'])) {
                $end = $params['endDate'];
            };
        }        

        $usageStatsData = Utils::fetchUsageStatsFromDb($start, $end);        
        $userData = Utils::fetchUserDataFromDb($start, $end);        

        $finalData = array(
            'recordsData'
        );
        $finalData['recordsData'][0][] = $userData['recordsData']['total'];
        $finalData['recordsData'][0][] = $userData['recordsData']['unique'];
        foreach ($usageStatsData['recordsData'][0] as $item) {
            array_push($finalData['recordsData'][0], $item);
        }

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $usageStatsData['recordsTotal'],
            'recordsFiltered' => $usageStatsData['recordsFiltered'],
            'data' => $finalData['recordsData']
        );

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
    
    public function fetchIpList()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');      
        
        // query params
        $params = $this->request->getParsedBody();    
        $mapType = $params['mapType'];
        // Log::debug('Backend mapType is ' . $mapType);
                 
        Utils::updateLocationData();                    
        $locationData = Utils::getLocationData($mapType);

        $this->set('response', $locationData);
        $this->set('_serialize', 'response');
    }

    public function exportFullUsage()
    {
        $response = $this->response;

        $usagesTable = TableRegistry::getTableLocator()->get('Usages');
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $locationsTable = TableRegistry::getTableLocator()->get('UserLocations');

        $query = $usagesTable->find();                
        $dataCollection = $query->all();                

        // header
        $csvData = implode(',', [
            'id',
            'date',
            'ip',
            'lat',
            'lon',
            'city',
            'country',
            'organization',
            'sample_data',
            'user_data',
            'run_output',
            'export_output'           
        ]);
        $csvData .= PHP_EOL;

        // data
        $counter = 0;
        foreach ($dataCollection as $dataRow) {
            $counter++;
            if ($dataRow instanceof stdClass){
                $row = json_decode(json_encode($dataRow), true);
            } else {
                $row = $dataRow->toArray();
            }  
            unset($row['id']);

            $row['date_added'] = $row['date_added']->i18nFormat('yyyy-MM-dd HH:mm:ss');
            // Log::debug($row);

            // get user IP
            if ($row['user_id']) {
                $query = $usersTable->find();        
                $query->select(['ip']);
                $query->where([
                    'id' => $row['user_id']
                ]);
                $userData = $query->first();   
            }

            if ($userData['ip']) {
                $query = $locationsTable->find();        
                $query->select(['lat', 'lon', 'country', 'city', 'organization']);
                $query->where([
                    'ip' => $userData['ip']
                ]);
                $locationData = $query->first(); 
            }

            $parsedData = [
                'id' => $counter,
                'date' => $row['date_added'],
                'ip' => $userData['ip'],
                'lat' => $locationData['lat'],
                'lon' => $locationData['lon'],
                'city' => $locationData['city'],
                'country' => $locationData['country'],
                'organization' => $locationData['organization'],
                'sample_data' => $row['test_input'],
                'user_data' => $row['input'],
                'run_output' => $row['output'],
                'export_output' => $row['export_output']
            ];
            $csvData .= implode(',', $parsedData) . PHP_EOL;
        }
        // Log::debug($csvData);

        $response = $response->withStringBody($csvData);

        $response = $response->withType('csv');
        $response = $response->withDownload('sbuddy_fullusage_stats.csv');
        return $response;
    }
}