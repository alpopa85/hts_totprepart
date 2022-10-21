<?php

namespace App\Model;

use App\Model\Entity\User;
use App\Model\Entity\UcdAverages;

use Cake\Core\Exception\Exception;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Log\Log;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\Http\Session;
use Cake\Http\Client;
use Cake\Utility\Text;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Database\Query;

class Utils
{
    const UPLOAD_PATH = WWW_ROOT . '../uploads/';
    const MAX_DATASET_SIZE = 7500;
    const BULK_ITEMS = 50;
    const DATE_FORMAT = 'Y-m-d';

    private static $currentDataset;

    // USER RELATED STUFF
    /////////////////////
    public static function refreshUser($sessionId)
    {
        // Log::debug('refreshUser sessionId: ' . $sessionId);

        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['session_id' => $sessionId])
            ->first();

        if (!$user instanceof User) {
            $user = $userTable->newEntity(array(
                'session_id' => $sessionId,
                'ip' => self::getUserIp()
            ));
        } else {
            $user->date_updated = Time::now();
        }

        $userTable->save($user);
        self::setCurrentDataset($user->id);
    }

    private static function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private static function resetUserData()
    {
        self::setUserDataLoaded(0);
        self::setUserSnow(0);
        self::setUserSoilWater(0);
        self::setUserWaterBalance(0);
    }

    public static function setUserDataLoaded($status, $isTestFile = false)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->data_loaded = $status;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }

        if ($status == 1) {
            if ($isTestFile) {
                self::addUsage('test_input');
            } else {
                self::addUsage('input');
            }
        }
    }

    public static function getUserDataLoadedFlag()
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            return $user->data_loaded;
        } else {
            throw new Exception('Cannot find User!');
        }
    }

    public static function setUserSnow($status)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->snow = $status;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }

        if ($status == 1) {
            self::addUsage('snow');
        }
    }

    public static function setUserSoilWater($status)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->soil_water = $status;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }

        if ($status == 1) {
            self::addUsage('soil_water');
        }
    }

    public static function setUserWaterBalance($status)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->water_balance = $status;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }

        if ($status == 1) {
            self::addUsage('balance');
        }
    }

    private static function setCurrentDataset($datasetId)
    {
        // Log::debug('Setting dataset to: ' . $datasetId);
        self::$currentDataset = $datasetId;
    }

    public static function getCurrentDataset()
    {
        // Log::debug('CurrentDataset: ' . self::$currentDataset);
        return self::$currentDataset;
    }
    // END OF USER RELATED STUFF
    ////////////////////////////


    // USAGE STUFF
    //////////////
    public static function addUsage($type)
    {
        $usageTable = TableRegistry::getTableLocator()->get('Usages');

        switch ($type) {
            case 'input':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'input' => 1
                );
                break;
            case 'test_input':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'test_input' => 1
                );
                break;
            case 'snow':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'snow' => 1
                );
                break;
            case 'export_snow':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'export_snow' => 1
                );
                break;
            case 'soil_water':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'soil_water' => 1
                );
                break;
            case 'export_soil_water':
                $data = array(
                    'user_id' => self::getCurrentDataset(),
                    'export_soil_water' => 1
                );
                break;            
        }

        $usage = $usageTable->newEntity($data);
        $usageTable->save($usage);
    }

    // END OF STUFF
    ///////////////

    public static function createFolder($folderName)
    {
        $folder = new Folder($folderName, true, 0755);
    }

    public static function uploadFile($file)
    {
        self::createFolder(self::UPLOAD_PATH);

        if (empty($file['name'])) {
            throw new Exception('No upload file specified!');
        }

        $extension = explode('.', $file['name'])[1];
        if ($extension != 'csv') {
            throw new Exception('Please provide a properly formatted CSV file!');
        }

        $destinationFile = self::UPLOAD_PATH . $file['name'];
        move_uploaded_file($file['tmp_name'], $destinationFile);

        return $destinationFile;
    }

    public static function removeFile($file)
    {
        unlink($file);
    }

    public static function writeInputToDb($sourceFile, $hasHeaders = true)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        // throw new Exception('Test error');

        if (($readHandle = fopen($sourceFile, "r")) !== FALSE) {

            $timeSeriesColIndex = 0;
            $tempSeriesColIndex = 1;
            $precipSeriesColIndex = 2;
            $rainSeriesColIndex = 3;
            $etSeriesColIndex = 4;

            // $ucd1SeriesColIndex = 5;
            // $ucd2SeriesColIndex = 6;
            // $ucd3SeriesColIndex = 7;
            // $ucd4SeriesColIndex = 8;
            // $ucd5SeriesColIndex = 9;

            $vdSeriesStartColIndex = 5;
            $vdSeriesColNames = ['ucd1', 'ucd2', 'ucd3', 'ucd4', 'ucd5'];
            $completedVdColumns = 0;

            $data = fgetcsv($readHandle, 1000, ",");
            for ($i = 5; $i <= 9; $i++) {
                if (!empty($data[$i])) {
                    $completedVdColumns += 1;
                }
            }

            $rowCounter = 0;
            rewind($readHandle);

            // should be in a DataLoader utils method      
            $memorizedRows = 0;
            $memorizedData = array();
            while (($data = fgetcsv($readHandle, 1000, ",")) !== FALSE) {
                $rowCounter++;

                // skip header row
                if (($rowCounter == 1) && ($hasHeaders)) {
                    $rowCounter = 0;
                    $hasHeaders = false;
                    continue;
                }

                // input data validation
                if (Utils::validateInput('date', $data[$timeSeriesColIndex]) == false) {
                    Utils::removeCompleteDataset();
                    Log::error('Invalid date format provided! Please use YYYY-MM-DD.');
                    throw new Exception('Invalid date format provided! Please use YYYY-MM-DD [Line ' . ($rowCounter + 1) . ']');
                }

                if (Utils::validateInput('temp', $data[$tempSeriesColIndex]) == false) {
                    Utils::removeCompleteDataset();
                    Log::error('Temperature must be between -90 and 60.');
                    throw new Exception('Temperature must be between -90 and 60 [Line ' . ($rowCounter + 1) . ']');
                }

                if (Utils::validateInput('precip', $data[$precipSeriesColIndex]) == false) {
                    Utils::removeCompleteDataset();
                    Log::error('Precipitation must be between 0 and 1800.');
                    throw new Exception('Precipitation must be between 0 and 1800 [Line ' . ($rowCounter + 1) . ']');
                }

                if (Utils::validateInput('rain', $data[$rainSeriesColIndex]) == false) {
                    Utils::removeCompleteDataset();
                    Log::error('Rain amount must be between 0 and 1800.');
                    throw new Exception('Rain amount must be between 0 and 1800 [Line ' . ($rowCounter + 1) . ']');
                }

                if (Utils::validateInput('et', $data[$etSeriesColIndex]) == false) {
                    Utils::removeCompleteDataset();
                    Log::error('Evapotranspiration must be between 0 and 100.');
                    throw new Exception('Evapotranspiration must be between 0 and 100 [Line ' . ($rowCounter + 1) . ']');
                }

                /* validation fields */
                // if (Utils::validateInput('ucd1', $data[$ucd1SeriesColIndex]) == false) {
                //     Utils::removeCompleteDataset();
                //     Log::error('Soil Moisture must be between 0 and 100.');
                //     throw new Exception('Soil Moisture must be between 0 and 100 [Line ' . ($rowCounter + 1) . ']');
                // }

                // if (Utils::validateInput('ucd2', $data[$ucd2SeriesColIndex]) == false) {
                //     Utils::removeCompleteDataset();
                //     Log::error('Groundwater Recharge must be between 0 and 500.');
                //     throw new Exception('Groundwater Recharge must be between 0 and 500 [Line ' . ($rowCounter + 1) . ']');
                // }

                // if (Utils::validateInput('ucd3', $data[$ucd3SeriesColIndex]) == false) {
                //     Utils::removeCompleteDataset();
                //     Log::error('Groundwater Recharge must be between 0 and 500.');
                //     throw new Exception('Groundwater Recharge must be between 0 and 500 [Line ' . ($rowCounter + 1) . ']');
                // }

                // if (Utils::validateInput('ucd4', $data[$ucd4SeriesColIndex]) == false) {
                //     Utils::removeCompleteDataset();
                //     Log::error('Groundwater Recharge must be between 0 and 500.');
                //     throw new Exception('Groundwater Recharge must be between 0 and 500 [Line ' . ($rowCounter + 1) . ']');
                // }

                // if (Utils::validateInput('ucd5', $data[$ucd5SeriesColIndex]) == false) {
                //     Utils::removeCompleteDataset();
                //     Log::error('Groundwater Recharge must be between 0 and 500.');
                //     throw new Exception('Groundwater Recharge must be between 0 and 500 [Line ' . ($rowCounter + 1) . ']');
                // }

                $dateDetails = Utils::getDateForInputDataFormat($data[$timeSeriesColIndex], self::DATE_FORMAT);

                $newData = array(
                    'dataset' => Utils::getCurrentDataset(),
                    'time_index' => $rowCounter,
                    'time_name' => $dateDetails['day'] . '-' . $dateDetails['monthLong'] . '-' . $dateDetails['year'], //$data[$timeSeriesColIndex],        
                    'time_date' => $dateDetails['date'],
                    'time_day' => $dateDetails['day'],
                    'time_month' => $dateDetails['month'],
                    'time_year' => $dateDetails['year'],
                    'temp' => $data[$tempSeriesColIndex],
                    'precip' => $data[$precipSeriesColIndex],
                    'rain' => $data[$rainSeriesColIndex],
                    'et' => $data[$etSeriesColIndex]
                );

                // read validation data series
                for ($i = 0; $i < $completedVdColumns; $i++) {
                    $keyName = $vdSeriesColNames[$i];
                    $newData[$keyName] = $data[$vdSeriesStartColIndex + $i];
                }

                $memorizedData[] = $newData;
                $memorizedRows++;

                if ($memorizedRows == self::BULK_ITEMS) {
                    // $newInputData = $inputDataTable->newEntity($newData);                    
                    // $inputDataTable->save($newInputData);

                    $newInputData = $inputDataTable->newEntities($memorizedData);
                    $inputDataTable->saveMany($newInputData);

                    $memorizedRows = 0;
                    $memorizedData = array();
                }

                if ($rowCounter > self::MAX_DATASET_SIZE){
                    Utils::removeCompleteDataset();
                    Log::error('Dataset exceeds maximum allowed ' . $rowCounter);
                    throw new Exception('The dataset exceeds the maximum allowed length of ' . self::MAX_DATASET_SIZE . ' datapoints.');                     
                } 
            }
            fclose($readHandle);

            if ($memorizedRows > 0) {
                $newInputData = $inputDataTable->newEntities($memorizedData);
                $inputDataTable->saveMany($newInputData);
            }

            if ($rowCounter < 365) {
                Utils::removeCompleteDataset();
                throw new Exception('Input Data must cover at least 1 calendar year (365 days)!');
            }
        }
    }

    public static function writeMetadataParamsToDb($sourceFile, $type)
    {
        $paramsDataTable = TableRegistry::getTableLocator()->get('Params');

        // throw new Exception('Test error');

        if (($readHandle = fopen($sourceFile, "r")) !== FALSE) {

            $paramsCollection = array();
            
            $fieldTypeIndex = 2;
            $fieldRawNameIndex = 3;
            $fieldValueIndex = 1;                        

            $typeHeaderRow = true;
            $tableHeaderRow = true;
            while (($data = fgetcsv($readHandle, 1000, ",")) !== FALSE) {                

                // skip type header row
                if ($typeHeaderRow) {
                    switch ($type){
                        case 'wb':
                            if (strcmp($data[0], 'WATER_BALANCE_CONFIGURATION') !== 0) {
                                throw new Exception('Wrong configuration file! Please upload a WATER BALANCE configuration file.', 13);
                            }
                            break;
                        case 'snow':
                            if (strcmp($data[0], 'SNOW_CONFIGURATION') !== 0) {
                                throw new Exception('Wrong configuration file! Please upload a SNOW configuration file.', 13);
                            }
                            break;
                    }                    

                    $typeHeaderRow = false;
                    continue;
                }    
                
                // skip table header row
                if ($tableHeaderRow) {
                    $tableHeaderRow = false;
                    continue;
                }      
                
                // skip non param field
                if (strcmp(explode('_', $data[$fieldTypeIndex])[1], 'param') != 0) {
                    continue;
                }

                $newData = array(
                    'dataset' => Utils::getCurrentDataset(),
                    'param_name' => $data[$fieldRawNameIndex],
                    'param_value' => $data[$fieldValueIndex]
                );       
                
                $paramsCollection[] = $newData;               
            }
            fclose($readHandle);

            foreach ($paramsCollection as $item) {
                $item['found'] = true;
                $paramEntity = $paramsDataTable->findOrCreate(
                    [
                        'dataset' => $item['dataset'],
                        'param_name' => $item['param_name']
                    ],
                    function ($entity) use ($item) { // creation callback
                        $entity->param_value = $item['param_value'];
                        $item['found'] = false;
                    }
                );
    
                if ($item['found']) {
                    $paramEntity->param_value = $item['param_value'];
                    $paramsDataTable->save($paramEntity);
                }
            }
        }
    }

    public static function writeMetadataSnowCalibToDb($sourceFile)
    {
        // throw new Exception('Test error');
        
        self::removeCalib('SnowCalibration');
        
        $calibDataTable = TableRegistry::getTableLocator()->get('SnowCalibration');        
        
        if (($readHandle = fopen($sourceFile, "r")) !== FALSE) {

            $calibCollection = array();

            $hasHeaders = true; // metadata file always has headers
            $fieldTypeIndex = 2;
            $fieldRawNameIndex = 3;
            $fieldValueIndex = 1;                        
          
            $onFirstRow = true;
            while (($data = fgetcsv($readHandle, 1000, ",")) !== FALSE) {                

                // skip header row
                if ($onFirstRow && $hasHeaders) {
                    $onFirstRow = false;
                    $hasHeaders = false;
                    continue;
                }           
                
                // skip non calibration field
                if (strcmp($data[$fieldTypeIndex], 'snow_calib_map') != 0) {
                    continue;
                }

                $newData = array(
                    'dataset' => Utils::getCurrentDataset(),
                    'output_field' => $data[$fieldRawNameIndex],
                    'ucd_field' => $data[$fieldValueIndex]
                );       
                
                $calibCollection[] = $newData;               
            }
            fclose($readHandle);

            foreach ($calibCollection as $item) {
                $item['found'] = true;
                $paramEntity = $calibDataTable->findOrCreate(
                    [
                        'dataset' => $item['dataset'],
                        'output_field' => $item['output_field'],
                        'ucd_field' => $item['ucd_field']
                    ],
                    function ($entity) use ($item) { // creation callback
                        $entity->output_field = $item['output_field'];
                        $entity->ucd_field = $item['ucd_field'];
                        $item['found'] = false;
                    }
                );
    
                if ($item['found']) {
                    $paramEntity->output_field = $item['output_field'];
                    $paramEntity->ucd_field = $item['ucd_field'];
                    $calibDataTable->save($paramEntity);
                }
            }
        }
    }

    public static function writeMetadataSoilCalibToDb($sourceFile)
    {
        // throw new Exception('Test error');
        
        self::removeCalib('SoilCalibration');
        
        $calibDataTable = TableRegistry::getTableLocator()->get('SoilCalibration');        
        
        if (($readHandle = fopen($sourceFile, "r")) !== FALSE) {

            $calibCollection = array();

            $hasHeaders = true; // metadata file always has headers
            $fieldTypeIndex = 2;
            $fieldRawNameIndex = 3;
            $fieldValueIndex = 1;                        
          
            $onFirstRow = true;
            while (($data = fgetcsv($readHandle, 1000, ",")) !== FALSE) {                

                // skip header row
                if ($onFirstRow && $hasHeaders) {
                    $onFirstRow = false;
                    $hasHeaders = false;
                    continue;
                }           
                
                // skip non calibration field
                if (strcmp($data[$fieldTypeIndex], 'soil_calib_map') != 0) {
                    continue;
                }

                $newData = array(
                    'dataset' => Utils::getCurrentDataset(),
                    'output_field' => $data[$fieldRawNameIndex],
                    'ucd_field' => $data[$fieldValueIndex]
                );       
                
                $calibCollection[] = $newData;               
            }
            fclose($readHandle);

            foreach ($calibCollection as $item) {
                $item['found'] = true;
                $paramEntity = $calibDataTable->findOrCreate(
                    [
                        'dataset' => $item['dataset'],
                        'output_field' => $item['output_field'],
                        'ucd_field' => $item['ucd_field']
                    ],
                    function ($entity) use ($item) { // creation callback
                        $entity->output_field = $item['output_field'];
                        $entity->ucd_field = $item['ucd_field'];
                        $item['found'] = false;
                    }
                );
    
                if ($item['found']) {
                    $paramEntity->output_field = $item['output_field'];
                    $paramEntity->ucd_field = $item['ucd_field'];
                    $calibDataTable->save($paramEntity);
                }
            }
        }
    }

    public static function getCurrentDatasetLength()
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        $query = $inputDataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        return $total;
    }

    public static function getCurrentDatasetLengthCustomTimestep($targetTable)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get($targetTable);

        $query = $inputDataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        return $total;
    }

    // VALIDATION COLUMNS STUFF
    /*************************/
    public static function getValidationColumnsCount()
    {
        $nValidationColumns = 0;

        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        $query = $inputDataTable->find();
        $query->where(['dataset' => self::getCurrentDataset()]);
        $result = $query->first();

        if ($result) {
            if ($result->ucd1) {
                $nValidationColumns++;
            }

            if ($result->ucd2) {
                $nValidationColumns++;
            }

            if ($result->ucd3) {
                $nValidationColumns++;
            }

            if ($result->ucd4) {
                $nValidationColumns++;
            }

            if ($result->ucd5) {
                $nValidationColumns++;
            }
        }

        return $nValidationColumns;
    }

    public static function setUcdAvg($avgData)
    {
        self::resetUcdAvg();

        $table = TableRegistry::getTableLocator()->get('UcdAverages');

        $data = $avgData;
        $data['dataset'] = self::getCurrentDataset();
        // Log::debug('avgData: ' . json_encode($data));
        
        $newEntity = $table->newEntity($data);
        $table->save($newEntity);

        // $newEntities = $table->newEntities($data);       
        // $table->saveMany($newEntities);        
    }

    public static function resetUcdAvg()
    {
        $table = TableRegistry::getTableLocator()->get('UcdAverages');

        $query = $table->query();
        $query->delete()
            ->where(['dataset' => Utils::getCurrentDataset()])
            ->execute();
    }
   
    public static function getUcdAvgMethod($fieldName)
    {   
        // Log::debug(json_encode($fieldName));

        $table = TableRegistry::getTableLocator()->get('UcdAverages');

        $ucdAvg = $table->find('all', [
            'fields' => [$fieldName]
        ])
            ->where(['dataset' => self::getCurrentDataset()])
            ->first();  

        // Log::debug('class: ' . get_class($ucdAvg));
        // Log::debug('data ' . json_encode($ucdAvg));        
        if ($ucdAvg instanceof UcdAverages) {            
            $avgMethod = $ucdAvg->$fieldName;
        } else {
            $avgMethod = 1;
        }

        // Log::debug('avgData for ' . $fieldName . ' :' . $avgMethod);
        return $avgMethod;
    }

    // CALIBRATION STUFF
    /*******************/
    public static function writeSnowCalMapToDb($formData)
    {
        self::removeCalib('SnowCalibration');
        // self::removeCalib('SoilCalibration');

        $paramsTable = TableRegistry::getTableLocator()->get('SnowCalibration');

        // write new Params
        $paramsData = array();
        foreach ($formData as $pair) {
            $newParam = array(
                'dataset' => self::getCurrentDataset(),
                'output_field' => $pair['output'],
                'ucd_field' => $pair['ucd']            
            );

            $paramsData[] = $newParam;
        }

        foreach ($paramsData as $item) {
            $item['found'] = true;
            $paramEntity = $paramsTable->findOrCreate(
                [
                    'dataset' => $item['dataset'],
                    'output_field' => $item['output_field'],
                    'ucd_field' => $item['ucd_field']
                ],
                function ($entity) use ($item) { // creation callback
                    $entity->output_field = $item['output_field'];
                    $entity->ucd_field = $item['ucd_field'];
                    $item['found'] = false;
                }
            );

            if ($item['found']) {
                $paramEntity->output_field = $item['output_field'];
                $paramEntity->ucd_field = $item['ucd_field'];
                $paramsTable->save($paramEntity);
            }
        }
    }

    public static function writeCalStatsToDb($target, $targetPair, $statsData)
    {
        $paramsTable = TableRegistry::getTableLocator()->get($target);

        $targetEntity = array(
            'dataset' => self::getCurrentDataset(),
            'output_field' => $targetPair['output_field'],
            'ucd_field' => $targetPair['ucd_field']            
        );
        
        $found = true;
        $paramEntity = $paramsTable->findOrCreate(
            $targetEntity,
            function ($entity, $statsData) { // creation callback
                $entity->r_2 = $statsData['r_2'];
                $entity->rmsd = $statsData['rmsd'];
                $entity->nrmsd_minmax = $statsData['nrmsd_minmax'];
                $entity->nrmsd_mean = $statsData['nrmsd_mean'];
                $entity->nrmse_iqr = $statsData['nrmse_iqr'];
                $found = false;
            }
        );

        if ($found) {
            $paramEntity->r_2 = $statsData['r_2'];
            $paramEntity->rmsd = $statsData['rmsd'];
            $paramEntity->nrmsd_minmax = $statsData['nrmsd_minmax'];
            $paramEntity->nrmsd_mean = $statsData['nrmsd_mean'];
            $paramEntity->nrmse_iqr = $statsData['nrmse_iqr'];
            $paramsTable->save($paramEntity);
        }
    }

    public static function writeSoilCalMapToDb($formData)
    {
        self::removeCalib('SoilCalibration');

        $paramsTable = TableRegistry::getTableLocator()->get('SoilCalibration');

        // write new Params
        $paramsData = array();
        foreach ($formData as $pair) {
            $newParam = array(
                'dataset' => self::getCurrentDataset(),
                'output_field' => $pair['output'],
                'ucd_field' => $pair['ucd']            
            );

            $paramsData[] = $newParam;
        }

        foreach ($paramsData as $item) {
            $item['found'] = true;
            $paramEntity = $paramsTable->findOrCreate(
                [
                    'dataset' => $item['dataset'],
                    'output_field' => $item['output_field'],
                    'ucd_field' => $item['ucd_field']
                ],
                function ($entity) use ($item) { // creation callback
                    $entity->output_field = $item['output_field'];
                    $entity->ucd_field = $item['ucd_field'];
                    $item['found'] = false;
                }
            );

            if ($item['found']) {
                $paramEntity->output_field = $item['output_field'];
                $paramEntity->ucd_field = $item['ucd_field'];
                $paramsTable->save($paramEntity);
            }
        }
    }

    public static function getSnowCalibrationFields()
    {
        $params = self::getCalibrationFromDb('SnowCalibration');

        $calibData = array();
        $i = 0;
        foreach ($params as $item) {
            $i++;
            $calibData['output'.$i.'_field'] = $item['output_field'];
            $calibData['ucd'.$i.'_field'] = $item['ucd_field'];
        }

        return $calibData;
    }

    public static function getSoilCalibrationFields()
    {
        $params = self::getCalibrationFromDb('SoilCalibration');

        $calibData = array();
        $i = 0;
        foreach ($params as $item) {
            $i++;
            $calibData['output'.$i.'_field'] = $item['output_field'];
            $calibData['ucd'.$i.'_field'] = $item['ucd_field'];
        }

        return $calibData;
    }

    private static function getCalibrationFromDb($target)
    {
        $paramTable = TableRegistry::getTableLocator()->get($target);
        $query = $paramTable->find('all', [
            'fields' => ['output_field', 'ucd_field']
        ]);
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $data = $query->toArray();

        return $data;
    }

    public static function removeCalibMapDataset()
    {
        // snow
        self::removeCalib('SnowCalibration');
        
        // soil
        self::removeCalib('SoilCalibration');
    }

    public static function removeCalib($target)
    {
        $table = TableRegistry::getTableLocator()->get($target);

        $query = $table->query();
        $query->delete()
            ->where(['dataset' => Utils::getCurrentDataset()])
            ->execute();

    }

    // used by DataTables
    public static function fetchInputFromDb($graphSource, $length, $start, $search)
    {
        switch ($graphSource) {
            case 1:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputData');
                break;
            case 2:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataMonthly');
                break;
            case 3:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataYearly');
                break;
            case 4:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataSpring');
                break;
            case 5:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataSummer');
                break;
            case 6:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataFall');
                break;
            case 7:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataWinter');
                break;
            case 8:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonIn');
                break;
            case 9:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonOut');
                break;
            case 10:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataSeasons');
                break;
            case 11:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataGrowingSeasons');
                break;
            case 21:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataTypical');
                break;
            case 22:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalMonthly');
                break;
            case 23:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalYearly');
                break;
            case 24:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSeasons');
                break;
            case 25:
                $inputDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowingSeasons');
                break;
        }

        // get total count
        $query = $inputDataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        // get filtered count
        if ($search) {
            $query = $inputDataTable->find();
            $query->where([
                'time_name LIKE' => '%' . $search . '%',
                'dataset' => self::getCurrentDataset()
            ]);
            $dateIndex = $query->first()['time_index'];

            $query = $inputDataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            $filteredTotal = $query->first()['count'];

            $query = $inputDataTable->find();
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        } else {
            $query = $inputDataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(['dataset' => self::getCurrentDataset()]);
            $filteredTotal = $query->first()['count'];

            $query = $inputDataTable->find();
            $query->where(['dataset' => self::getCurrentDataset()]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        }

        $data = [];
        foreach ($inputData as $item) {
            $customDateTime = $item->time_name;

            $data[] = array(
                $item->time_index,
                $customDateTime,
                self::formatDataDecimals('temp', $item->temp),
                self::formatDataDecimals('precip', $item->precip),
                self::formatDataDecimals('rain', $item->rain),
                self::formatDataDecimals('et', $item->et),
                self::formatDataDecimals('ucd1', $item->ucd1),
                self::formatDataDecimals('ucd2', $item->ucd2),
                self::formatDataDecimals('ucd3', $item->ucd3),
                self::formatDataDecimals('ucd4', $item->ucd4),
                self::formatDataDecimals('ucd5', $item->ucd5)
            );
        }

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    public static function formatDataDecimals($type, $value)
    {
        // Log::debug($type . ' -> ' . $value);

        switch ($type) {
            // as is
            case 'time_name':
            case 'time_index':            
                return $value;
                break;
            // 3 dec
            case 'inf_lr':
            case 'inf_hr':
            case 'dra_lr':
            case 'dra_hr':
                return number_format($value, 3);
                break;
            case 'r_2':
            case 'rmsd':
            case 'nrmsd_minmax':
            case 'nrmsd_mean':
            case 'nrmse_iqr':
                return number_format($value, 5);
                break;
            // 2 dec            
            case 'temp':
            case 'et':
            case 'et_above_g':          
            case 'etfsas':                                      
            case 'et_above_re':
            case 'etisi':
            case 'et_corr':                        
            case 'ucd':
            case 'ucd1':
            case 'ucd2':
            case 'ucd3':
            case 'ucd4':
            case 'ucd5':
            case 'thr_rs':
            case 'thr_sm':
            case 'cft_sm':
            case 'cfp_sm':
            case 'cfs_mc':
            case 'cf_ets':
            case 'sr_init':
            case 'ng_init':
            case 'nl_init':
            case 'thr_tsd':
            case 'cf_eidr':
            case 'cf_osdr':
                return number_format($value, 2);
                break;
            // 0 dec
            case 'days_low_swc':
            case 'days_high_swc':
            case 'gs_start_day':
            case 'gs_start_month':
            case 'gs_end_day':
            case 'gs_end_month':
            case 'thkn':
                return number_format($value, 0);
                break;                       
            // 1 dec
            default:            
                return number_format($value, 1);
                break;
        }
    }

    // used by DataTables
    public static function fetchInputStatsFromDb($fieldName, $startDate = null, $endDate = null)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startDate, $endDate) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);

            if ($startDate && $endDate) {
                $date = $query->newExpr()->add(["time_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'"]);
                return $exp->add($query->newExpr()->and([$dataset, $date]));
            } else {
                return $exp->add($query->newExpr()->and([$dataset]));
            }
        };

        $query = $inputDataTable->find();

        switch ($fieldName) {
                case in_array($fieldName,array('not_applicable_now')):
                    $query->select([
                        'average' => $query->func()->sum($fieldName), // SUM is the AVERAGE FUNCTION FOR THESE
                        'minimum' => $query->func()->min($fieldName),
                        'maximum' => $query->func()->max($fieldName)
                        ]);   
                    break;
            default:
                $query->select([
                    'average' => $query->func()->avg($fieldName),
                    'minimum' => $query->func()->min($fieldName),
                    'maximum' => $query->func()->max($fieldName)
                ]);
                break;
        }
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('input_data')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    // used by DataTables
    public static function fetchWaterBalanceOutputFromDb($graphSource, $length, $start, $search)
    {
        switch ($graphSource) {
            case 1:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceData');
                break;
            case 2:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataMonthly');
                break;
            case 3:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataYearly');
                break;
            case 4:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataSpring');
                break;
            case 5:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataSummer');
                break;
            case 6:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataFall');
                break;
            case 7:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataWinter');
                break;
            case 8:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataGrowthSeasonIn');
                break;
            case 9:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataGrowthSeasonOut');
                break;
            case 10:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataSeasons');
                break;
            case 11:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataGrowingSeasons');
                break;
            case 21:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypical');
                break;
            case 22:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalMonthly');
                break;
            case 23:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalYearly');
                break;
            case 24:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalSeasons');
                break;
            case 25:
                $dataTable = TableRegistry::getTableLocator()->get('WaterBalanceDataTypicalGrowingSeasons');
                break;
        }

        // get total count
        $query = $dataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        // get filtered count
        if ($search) {
            $query = $dataTable->find();
            $query->where([
                'time_name LIKE' => '%' . $search . '%',
                'dataset' => self::getCurrentDataset()
            ]);
            $dateIndex = $query->first()['time_index'];

            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        } else {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(['dataset' => self::getCurrentDataset()]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where(['dataset' => self::getCurrentDataset()]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        }

        $data = [];
        foreach ($inputData as $item) {
            $customDateTime = $item->time_name;

            $data[] = array(
                $item->time_index,
                $customDateTime,
                self::formatDataDecimals('mm_h20', $item->mm_h20),
                null, // placeholder for precip
                null, // et_total
                self::formatDataDecimals('et', $item->et_lost), // et_above_fround
                self::formatDataDecimals('et', $item->et_soil), // et_from_soil                
                self::formatDataDecimals('wchg', $item->wchg_loss),
                self::formatDataDecimals('wchg', $item->wchg_gain),
                self::formatDataDecimals('drain', $item->drain),
                self::formatDataDecimals('inf', $item->inf),
                self::formatDataDecimals('sr',  $item->sr)
            );
        }

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    public static function fetchWaterBalanceStatsFromDb($fieldName)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('WaterBalanceData');

        $query = $inputDataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = number_format($row['average'], 3);
                $row['minimum'] = number_format($row['minimum'], 3);
                $row['maximum'] = number_format($row['maximum'], 3);
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('balance_data')
            ->where(array('dataset' => self::getCurrentDataset()))
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = number_format($std[0], 3);

        return $inputDataStats;
    }

    public static function fetchSnowOutputFromDb($graphSource, $length, $start, $search)
    {
        switch ($graphSource) {
            case 1:
                $dataTable = TableRegistry::getTableLocator()->get('SnowData');
                break;
            case 2:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataMonthly');
                break;
            case 3:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataYearly');
                break;
            case 4:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataSpring');
                break;
            case 5:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataSummer');
                break;
            case 6:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataFall');
                break;
            case 7:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataWinter');
                break;
            case 8:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonIn');
                break;
            case 9:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonOut');
                break;
            case 10:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataSeasons');
                break;
            case 11:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataGrowingSeasons');
                break;
            case 21:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypical');
                break;
            case 22:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalMonthly');
                break;
            case 23:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalYearly');
                break;
            case 24:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSeasons');
                break;
            case 25:
                $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowingSeasons');
                break;
        }

        // get total count
        $query = $dataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        // get filtered count
        if ($search) {
            $query = $dataTable->find();
            $query->where([
                'time_name LIKE' => '%' . $search . '%',
                'dataset' => self::getCurrentDataset()
            ]);
            $dateIndex = $query->first()['time_index'];

            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        } else {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(['dataset' => self::getCurrentDataset()]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where(['dataset' => self::getCurrentDataset()]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        }

        foreach ($inputData as $item) {
            $newDataLine = array(
                $item->time_index,
                $item->time_name,
                Utils::formatDataDecimals('temp', $item->temp),
                Utils::formatDataDecimals('precip', $item->precip),
                Utils::formatDataDecimals('rain', $item->rain),
                Utils::formatDataDecimals('snow_mm', $item->snow_mm),
                Utils::formatDataDecimals('rains', $item->rains),
                Utils::formatDataDecimals('rainns', $item->rainns),
                Utils::formatDataDecimals('snoa', $item->snoa),
                Utils::formatDataDecimals('snom', $item->snom),
                Utils::formatDataDecimals('rssl', $item->rssl),
                Utils::formatDataDecimals('rsi', $item->rsi),
                Utils::formatDataDecimals('tdsm', $item->tdsm),
                Utils::formatDataDecimals('rdsm', $item->rdsm),
                Utils::formatDataDecimals('snow_acc', $item->snow_acc),
                Utils::formatDataDecimals('snowmelt', $item->snowmelt),
                Utils::formatDataDecimals('et', $item->et),
                Utils::formatDataDecimals('et_above_g', $item->et_above_g),
                Utils::formatDataDecimals('etfsas', $item->etfsas),
                Utils::formatDataDecimals('et_above_re', $item->et_above_re),
                // Utils::formatDataDecimals('watisri', $item->watisri),
                Utils::formatDataDecimals('water_or_sr', $item->water_or_sr),
                Utils::formatDataDecimals('snow_calc', $item->snow_calc)
            );

            // add validation data fields
            for ($i = 0; $i < self::getValidationColumnsCount(); $i++) {
                $fieldName = 'ucd'.($i+1);
                $newDataLine[] = Utils::formatDataDecimals('ucd', $item->$fieldName);
            }

            $data[] = $newDataLine;
        }

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    public static function fetchSnowStatsFromDb($fieldName, $startDate = null, $endDate = null)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('SnowData');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startDate, $endDate) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);

            if ($startDate && $endDate) {
                $date = $query->newExpr()->add(["time_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'"]);
                return $exp->add($query->newExpr()->and([$dataset, $date]));
            } else {
                return $exp->add($query->newExpr()->and([$dataset]));
            }
        };

        $query = $inputDataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchDailySnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowData');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();
        // Log::debug('inputDataStats: ' . json_encode($inputDataStats)); 

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchMonthlySnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataMonthly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_monthly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchSeasonsSnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_seasons')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }
    
    /* Used during Calibration calculations */
    private static function fetchGrowingSeasonsSnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataGrowingSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_growing')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchYearlySnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataYearly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_yearly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalDailySnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypical');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_typical')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalMonthlySnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalMonthly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_typical_monthly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalSeasonsSnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_typical_seasons')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }
    
    /* Used during Calibration calculations */
    private static function fetchTypicalGrowingSeasonsSnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowingSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_typical_growing')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalYearSnowStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalYearly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('snow_data_typical_yearly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    // used by DataTables
    public static function fetchSoilWaterOutputFromDb($graphSource, $length, $start, $search)
    {
        switch ($graphSource) {
            case 1:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterData');
                break;
            case 2:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataMonthly');
                break;
            case 3:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataYearly');
                break;
            case 4:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSpring');
                break;
            case 5:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSummer');
                break;
            case 6:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataFall');
                break;
            case 7:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataWinter');
                break;
            case 8:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonIn');
                break;
            case 9:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonOut');
                break;
            case 10:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSeasons');
                break;
            case 11:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowingSeasons');
                break;
            case 21:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypical');
                break;
            case 22:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalMonthly');
                break;
            case 23:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalYearly');
                break;
            case 24:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSeasons');
                break;
            case 25:
                $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowingSeasons');
                break;
        }

        // get total count
        $query = $dataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        // get filtered count
        if ($search) {
            $query = $dataTable->find();
            $query->where([
                'time_name LIKE' => '%' . $search . '%',
                'dataset' => self::getCurrentDataset()
            ]);
            $dateIndex = $query->first()['time_index'];

            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where([
                'time_index >=' => $dateIndex,
                'dataset' => self::getCurrentDataset()
            ]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        } else {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(['dataset' => self::getCurrentDataset()]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->where(['dataset' => self::getCurrentDataset()]);
            if ($length) {
                $query->limit($length);
            }
            if ($start) {
                $query->offset($start);
            }
            $query->order('time_index ASC');
            $inputData = $query->all();
        }

        $data = [];
        foreach ($inputData as $item) {
            $customDateTime = $item->time_name;

            $newDataLine = array(
                $item->time_index,
                $customDateTime,
                Utils::formatDataDecimals('temp', $item->temp),
                Utils::formatDataDecimals('precip', $item->precip),
                Utils::formatDataDecimals('rain', $item->rain),
                Utils::formatDataDecimals('snow_mm', $item->snow_mm),
                Utils::formatDataDecimals('water_or_sr', $item->water_or_sr),
                // Utils::formatDataDecimals('infcap', $item->infcap),
                Utils::formatDataDecimals('inf_cap_corr', $item->inf_cap_corr),                
                // Utils::formatDataDecimals('dracap', $item->dracap),
                Utils::formatDataDecimals('drafre', $item->drafre),
                Utils::formatDataDecimals('drain_corr', $item->drain_corr),                
                Utils::formatDataDecimals('drain_boost_excess', $item->drain_boost_excess),
                Utils::formatDataDecimals('drain_boost_oversat', $item->drain_boost_oversat),
                Utils::formatDataDecimals('drain_total', $item->drain_total),
                Utils::formatDataDecimals('etisi', $item->etisi),
                Utils::formatDataDecimals('et_corr', $item->et_corr),
                Utils::formatDataDecimals('etfsas', $item->etfsas),
                Utils::formatDataDecimals('swcint', $item->swcint),
                Utils::formatDataDecimals('swc_corr_sat', $item->swc_corr_sat),
                Utils::formatDataDecimals('swc_corr_sat_pc', $item->swc_corr_sat_pc),
                Utils::formatDataDecimals('sr_exc', $item->sr_exc),
                Utils::formatDataDecimals('sr_exc_less_drain', $item->sr_exc_less_drain),
                Utils::formatDataDecimals('sr_sat', $item->sr_sat),
                Utils::formatDataDecimals('sr_sat_less_drain', $item->sr_sat_less_drain),
                Utils::formatDataDecimals('sr_total', $item->sr_total),
                Utils::formatDataDecimals('sr_total_less_drain', $item->sr_total_less_drain),
                Utils::formatDataDecimals('net_gain', $item->net_gain),
                Utils::formatDataDecimals('net_loss', $item->net_loss),
                Utils::formatDataDecimals('days_low_swc', $item->days_low_swc),
                Utils::formatDataDecimals('days_high_swc', $item->days_high_swc)
            );

            // add validation data fields
            for ($i = 0; $i < self::getValidationColumnsCount(); $i++) {
                $fieldName = 'ucd'.($i+1);
                $newDataLine[] = Utils::formatDataDecimals('ucd', $item->$fieldName);
            }

            $data[] = $newDataLine;
        }

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    public static function fetchSoilWaterStatsFromDb($fieldName, $startDate = null, $endDate = null)
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('SoilWaterData');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startDate, $endDate) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);

            if ($startDate && $endDate) {
                $date = $query->newExpr()->add(["time_date BETWEEN '" . $startDate . "' AND '" . $endDate . "'"]);
                return $exp->add($query->newExpr()->and([$dataset, $date]));
            } else {
                return $exp->add($query->newExpr()->and([$dataset]));
            }
        };

        $query = $inputDataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchDailySoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterData');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchMonthlySoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataMonthly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_monthly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchSeasonsSoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_seasons')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }
    
    /* Used during Calibration calculations */
    private static function fetchGrowingSeasonsSoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowingSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_growing')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchYearlySoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataYearly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_yearly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalDailySoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypical');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_typical')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalMonthlySoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalMonthly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_typical_monthly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalSeasonsSoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_typical_seasons')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }
    
    /* Used during Calibration calculations */
    private static function fetchTypicalGrowingSeasonsSoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowingSeasons');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_typical_growing')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    /* Used during Calibration calculations */
    private static function fetchTypicalYearSoilStatsFromDb($fieldName, $startIndex, $endIndex)
    {
        $dataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalYearly');

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $dataTable->find();
        $query->select([
            'average' => $query->func()->avg($fieldName),
            'minimum' => $query->func()->min($fieldName),
            'maximum' => $query->func()->max($fieldName)
        ]);
        $query->where($whereCondition);
        $query->formatResults(function ($results) {
            return $results->map(function ($row) {
                $row['average'] = $row['average'];
                $row['minimum'] = $row['minimum'];
                $row['maximum'] = $row['maximum'];
                return $row;
            });
        });
        $inputDataStats = $query->toArray();

        $connection = ConnectionManager::get('default');
        $std = $connection
            ->newQuery()
            ->select('STD(' . $fieldName . ')')
            ->from('soil_data_typical_yearly')
            ->where($whereCondition)
            ->execute()
            ->fetch();

        $inputDataStats[0]->std_dev = $std[0];

        return $inputDataStats;
    }

    public static function fetchTimeDataFromDb($graphSource)
    {
        switch ($graphSource) {
            case 1:
                $fetchedData = self::fetchFieldFromDb('InputData', 'time_name');
                break;
            case 2:
                $fetchedData = self::fetchFieldFromDb('InputDataMonthly', 'time_name');
                break;
            case 3:
                $fetchedData = self::fetchFieldFromDb('InputDataYearly', 'time_name');
                break;
            case 4:
                $fetchedData = self::fetchFieldFromDb('InputDataSpring', 'time_name');
                break;
            case 5:
                $fetchedData = self::fetchFieldFromDb('InputDataSummer', 'time_name');
                break;
            case 6:
                $fetchedData = self::fetchFieldFromDb('InputDataFall', 'time_name');
                break;
            case 7:
                $fetchedData = self::fetchFieldFromDb('InputDataWinter', 'time_name');
                break;
            case 8:
                $fetchedData = self::fetchFieldFromDb('InputDataGrowthSeasonIn', 'time_name');
                break;
            case 9:
                $fetchedData = self::fetchFieldFromDb('InputDataGrowthSeasonOut', 'time_name');
                break;
            case 10:
                $fetchedData = self::fetchFieldFromDb('InputDataSeasons', 'time_name');
                break;
            case 11:
                $fetchedData = self::fetchFieldFromDb('InputDataGrowingSeasons', 'time_name');
                break;
            case 21:
                $fetchedData = self::fetchFieldFromDb('InputDataTypical', 'time_name');
                // $clearYear = function($inputDate){
                //     $exploded = explode('-',$inputDate);
                //     return '0000-' . $exploded[1] . '-' . $exploded[2];
                // };
                // $fetchedData = array_map($clearYear, $fetchedData);
                break;
            case 22:
                $fetchedData = self::fetchFieldFromDb('InputDataTypicalMonthly', 'time_name');
                break;
            case 23:
                $fetchedData = self::fetchFieldFromDb('InputDataTypicalYearly', 'time_name');
                break;
            case 24:
                $fetchedData = self::fetchFieldFromDb('InputDataTypicalSeasons', 'time_name');
                break;
            case 25:
                $fetchedData = self::fetchFieldFromDb('InputDataTypicalGrowingSeasons', 'time_name');
                break;
            case 30:
                $fetchedData = self::fetchFieldFromDb('InputDataTypicalMonthly', 'time_name');
                break;
        }

        return $fetchedData;
    }

    public static function fetchTimeDataByIndexFromDb($index)
    {
        $table = TableRegistry::getTableLocator()->get('InputData');

        $query = $table->find('all', [
            'fields' => ['time_date']
        ]);
        $query->where([
            'dataset' => Utils::getCurrentDataset(),
            'time_index' => $index
        ]);
        $fetchedData = $query->first();        

        return $fetchedData;
    }

    public static function getIndexForGivenDate($type, $dateString)
    {
        switch ($type) {
            case 1: // DAILY            
                $tableName = 'InputData';

                $table = TableRegistry::getTableLocator()->get($tableName);

                $query = $table->find('all', [
                    'fields' => ['time_index']
                ]);
                $query->where([
                    'dataset' => Utils::getCurrentDataset(),
                    'time_date' => $dateString
                ]);
                $fetchedData = $query->first();        

                return $fetchedData['time_index'];
                break;
            case 2: // MONTHLY
                // find month and year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_month', 'time_year']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $month = $fetchedData['time_month'];
                    $year = $fetchedData['time_year'];

                // get index from monthly
                    $tableName = 'InputDataMonthly';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_month' => $month,
                        'time_year' => $year
                    ]);
                    $fetchedData = $query->first();        

                return $fetchedData['time_index'];
                break;
            case 10: // SEASONS
                // find month and year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_month', 'time_year']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $month = $fetchedData['time_month'];
                    $year = $fetchedData['time_year'];

                // get index from seasons
                    $tableName = 'InputDataSeasons';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_year' => $year
                    ]);
                    $allData = $query->toArray();   
                    
                    if (in_array($month,array(3,4,5))) {
                        $fetchedData = $allData[0]; // spring
                    }

                    if (in_array($month,array(6,7,8))) {
                        $fetchedData = $allData[1]; // summer
                    }

                    if (in_array($month,array(9,10,11))) {
                        $fetchedData = $allData[2]; // fall
                    }

                    if (in_array($month,array(1,2,12))) {
                        $fetchedData = $allData[3]; // winter
                    }

                return $fetchedData['time_index']; 
                break;            
            case 3: // YEARLY
                // find year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_year']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $month = $fetchedData['time_month'];
                    $year = $fetchedData['time_year'];

                // get index from yearly
                    $tableName = 'InputDataYearly';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_year' => $year
                    ]);
                    $fetchedData = $query->first();
                
                return $fetchedData['time_index'];
                break;
            case 11: // GROWING SEASONS
                // find year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_year']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $year = $fetchedData['time_year'];

                // get index from growing
                    $tableName = 'InputDataGrowing';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_year' => $year
                    ]);
                    $fetchedData = $query->first();
                
                return $fetchedData['time_index'];
                break;
            case 21: // TYPICAL DAILY            
                $tableName = 'InputDataTypical';

                $explodedDateString = explode('-', $dateString);
                $table = TableRegistry::getTableLocator()->get($tableName);

                $query = $table->find('all', [
                    'fields' => ['time_index']
                ]);
                $query->where([
                    'dataset' => Utils::getCurrentDataset(),
                    'time_date' => '2000-' . $explodedDateString[1] . '-' . $explodedDateString[2]
                ]);
                $fetchedData = $query->first();        
                
                return $fetchedData['time_index'];
                break;
            case 22: // TYPCIAL MONTHLY
                // find month and year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_month', 'time_year']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $month = $fetchedData['time_month'];                    

                // get index from monthly
                    $tableName = 'InputDataTypicalMonthly';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_month' => $month                        
                    ]);
                    $fetchedData = $query->first();        

                    return $fetchedData['time_index'];
                break;
            case 24: // TYPICAL SEASONS
                // find month and year from daily
                    $tableName = 'InputData';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_month']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                        'time_date' => $dateString
                    ]);
                    $fetchedData = $query->first();        

                    $month = $fetchedData['time_month'];

                // get index from seasons
                    $tableName = 'InputDataTypicalSeasons';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset()                        
                    ]);
                    $allData = $query->toArray();   
                    
                    if (in_array($month,array(3,4,5))) {
                        $fetchedData = $allData[0]; // spring
                    }

                    if (in_array($month,array(6,7,8))) {
                        $fetchedData = $allData[1]; // summer
                    }

                    if (in_array($month,array(9,10,11))) {
                        $fetchedData = $allData[2]; // fall
                    }

                    if (in_array($month,array(1,2,12))) {
                        $fetchedData = $allData[3]; // winter
                    }

                return $fetchedData['time_index']; 
                break;            
            case 23: // TYPICAL YEAR                            
                // get index from yearly
                    $tableName = 'InputDataYearly';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset(),
                    ]);
                    $fetchedData = $query->first();
                
                return $fetchedData['time_index'];
                break;
            case 25: // TYPICAL GROWING SEASONS                
                // get index from growing
                    $tableName = 'InputDataTypicalGrowing';

                    $table = TableRegistry::getTableLocator()->get($tableName);

                    $query = $table->find('all', [
                        'fields' => ['time_index']
                    ]);
                    $query->where([
                        'dataset' => Utils::getCurrentDataset()
                    ]);
                    $fetchedData = $query->first();
                
                return $fetchedData['time_index'];
                break;
        }        
    }    

    public static function fetchFieldFromDb($tableName, $fieldName, $limit = false)
    {
        $table = TableRegistry::getTableLocator()->get($tableName);

        $query = $table->find('all', [
            'fields' => [$fieldName]
        ]);
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        if ($limit) {
            $query->limit($limit);
        }
        $results = $query->all();
        $data = $results->toList();

        $formattedData = array();
        foreach ($data as $row) {
            $formattedData[][$fieldName] = Utils::formatDataDecimals($fieldName, $row[$fieldName]);
        }

        return array_column($formattedData, $fieldName);
    }

    public static function fetchMultipleFieldsFromDb($tableName, array $fieldNames, $limit = false)
    {
        $table = TableRegistry::getTableLocator()->get($tableName);

        $query = $table->find('all', [
            'fields' => $fieldNames
        ]);
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        if ($limit) {
            $query->limit($limit);
        }
        $results = $query->all();
        $data = $results->toList();

        $formattedData = array();
        foreach ($data as $row) {
            foreach ($fieldNames as $fieldName) {
                $formattedData[][$fieldName] = Utils::formatDataDecimals($fieldName, $row[$fieldName]);
            }
        }
        
        return $formattedData;
    }

    public static function fetchFieldFromUsersDb($tableName, $fieldName)
    {
        $table = TableRegistry::getTableLocator()->get($tableName);

        $query = $table->find('all', [
            'fields' => [$fieldName]
        ]);
        $query->where(['id' => Utils::getCurrentDataset()]);
        $result = $query->first();
        
        return $result;
    }

    public static function getParams()
    {
        $params = self::getParamsFromDb();

        $paramData = array();
        foreach ($params as $item) {
            $paramData[$item['param_name']] = $item['param_value'];
        }

        return $paramData;
    }

    private static function getParamsFromDb()
    {
        $paramTable = TableRegistry::getTableLocator()->get('Params');
        $query = $paramTable->find('all', [
            'fields' => ['param_name', 'param_value']
        ]);
        $query->where(['dataset' => Utils::getCurrentDataset()]);
        $data = $query->toArray();

        return $data;
    }    

    public static function writeParamsToDb($formData, $type)
    {
        $paramsTable = TableRegistry::getTableLocator()->get('Params');

        // write new Params
        $paramsData = array();
        foreach ($formData as $formDataKey => $formDataValue) {
            $newParam = array(
                'dataset' => self::getCurrentDataset(),
                'param_name' => $formDataKey,
                'param_value' => $formDataValue,
                'param_type' => $type
            );

            $paramsData[] = $newParam;
        }

        foreach ($paramsData as $item) {
            $item['found'] = true;
            $paramEntity = $paramsTable->findOrCreate(
                [
                    'dataset' => $item['dataset'],
                    'param_name' => $item['param_name']
                ],
                function ($entity) use ($item) { // creation callback
                    $entity->param_value = $item['param_value'];
                    $entity->param_type = $item['param_type'];
                    $item['found'] = false;
                }
            );

            if ($item['found']) {
                $paramEntity->param_value = $item['param_value'];
                $paramEntity->param_type = $item['param_type'];
                $paramsTable->save($paramEntity);
            }
        }
    }

    public static function isSetGrowthSeason()
    {
        $params = self::getParams();
        // Log::debug('PARAMS: ' . json_encode($params));

        if (!empty($params['gs_start_day']) && !empty($params['gs_end_day'])) {
            return true;
        }

        return false;
    }

    public static function removeCompleteDataset()
    {
        self::removeInputDataset();
        self::removeParamsDataset();
        self::removeCalibMapDataset();
        self::resetUcdAvg();

        self::removeSnowDataset();
        self::removeSoilWaterDataset();                

        self::resetUserData();
    }

    public static function removeInputDataset($id = null)
    {
        self::removeDatasetFromTable('InputData', $id);
        self::removeInputAveragingDataset($id);
    }

    public static function removeInputAveragingDataset($id = null)
    {
        self::removeDatasetFromTable('InputDataMonthly', $id);
        self::removeDatasetFromTable('InputDataYearly', $id);
        self::removeDatasetFromTable('InputDataSpring', $id);
        self::removeDatasetFromTable('InputDataSummer', $id);
        self::removeDatasetFromTable('InputDataFall', $id);
        self::removeDatasetFromTable('InputDataWinter', $id);
        self::removeDatasetFromTable('InputDataSeasons', $id);
        self::removeDatasetFromTable('InputDataGrowthSeasonIn', $id);
        self::removeDatasetFromTable('InputDataGrowthSeasonOut', $id);
        self::removeDatasetFromTable('InputDataGrowingSeasons', $id);

        self::removeDatasetFromTable('InputDataTypical', $id);
        self::removeDatasetFromTable('InputDataTypicalMonthly', $id);
        self::removeDatasetFromTable('InputDataTypicalYearly', $id);
        self::removeDatasetFromTable('InputDataTypicalSpring', $id);
        self::removeDatasetFromTable('InputDataTypicalSummer', $id);
        self::removeDatasetFromTable('InputDataTypicalFall', $id);
        self::removeDatasetFromTable('InputDataTypicalWinter', $id);
        self::removeDatasetFromTable('InputDataTypicalSeasons', $id);
        self::removeDatasetFromTable('InputDataTypicalGrowthSeasonIn', $id);
        self::removeDatasetFromTable('InputDataTypicalGrowthSeasonOut', $id);
        self::removeDatasetFromTable('InputDataTypicalGrowingSeasons', $id);
    }

    public static function removeParamsDataset($id = null)
    {
        self::removeDatasetFromTable('Params', $id);
    }
    
    public static function removeSnowDataset($id = null)
    {
        self::removeDatasetFromTable('SnowDataOverlay', $id);

        self::removeDatasetFromTable('SnowData', $id);        

        self::removeSnowAveragingDataset($id);

        self::setUserSnow(0);
    }

    public static function removeSnowAveragingDataset($id = null)
    {
        self::removeDatasetFromTable('SnowDataMonthly', $id);
        self::removeDatasetFromTable('SnowDataYearly', $id);
        self::removeDatasetFromTable('SnowDataSpring', $id);
        self::removeDatasetFromTable('SnowDataSummer', $id);
        self::removeDatasetFromTable('SnowDataFall', $id);
        self::removeDatasetFromTable('SnowDataWinter', $id);
        self::removeDatasetFromTable('SnowDataSeasons', $id);
        self::removeDatasetFromTable('SnowDataGrowthSeasonIn', $id);
        self::removeDatasetFromTable('SnowDataGrowthSeasonOut', $id);
        self::removeDatasetFromTable('SnowDataGrowingSeasons', $id);

        self::removeDatasetFromTable('SnowDataTypical', $id);
        self::removeDatasetFromTable('SnowDataTypicalMonthly', $id);
        self::removeDatasetFromTable('SnowDataTypicalYearly', $id);
        self::removeDatasetFromTable('SnowDataTypicalSpring', $id);
        self::removeDatasetFromTable('SnowDataTypicalSummer', $id);
        self::removeDatasetFromTable('SnowDataTypicalFall', $id);
        self::removeDatasetFromTable('SnowDataTypicalWinter', $id);
        self::removeDatasetFromTable('SnowDataTypicalSeasons', $id);
        self::removeDatasetFromTable('SnowDataTypicalGrowthSeasonIn', $id);
        self::removeDatasetFromTable('SnowDataTypicalGrowthSeasonOut', $id);
        self::removeDatasetFromTable('SnowDataTypicalGrowingSeasons', $id);
    }

    public static function removeSoilWaterDataset($id = null)
    {
        self::removeDatasetFromTable('SoilWaterDataOverlay', $id);

        self::removeDatasetFromTable('SoilWaterData', $id);
        
        self::removeSoilWaterAveragingDataset($id);

        self::setUserSoilWater(0); 
    }

    public static function removeSoilWaterAveragingDataset($id = null)
    {        
        self::removeDatasetFromTable('SoilWaterDataMonthly', $id);
        self::removeDatasetFromTable('SoilWaterDataYearly', $id);
        self::removeDatasetFromTable('SoilWaterDataSpring', $id);
        self::removeDatasetFromTable('SoilWaterDataSummer', $id);
        self::removeDatasetFromTable('SoilWaterDataFall', $id);
        self::removeDatasetFromTable('SoilWaterDataWinter', $id);
        self::removeDatasetFromTable('SoilWaterDataSeasons', $id);
        self::removeDatasetFromTable('SoilWaterDataGrowthSeasonIn', $id);
        self::removeDatasetFromTable('SoilWaterDataGrowthSeasonOut', $id);
        self::removeDatasetFromTable('SoilWaterDataGrowingSeasons', $id);

        self::removeDatasetFromTable('SoilWaterDataTypical', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalMonthly', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalYearly', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalSpring', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalSummer', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalFall', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalWinter', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalSeasons', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalGrowthSeasonIn', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalGrowthSeasonOut', $id);
        self::removeDatasetFromTable('SoilWaterDataTypicalGrowingSeasons', $id);
    }

    private static function removeDatasetFromTable($tableName, $id = null)
    {
        $table = TableRegistry::getTableLocator()->get($tableName);

        if (!$id) {
            $query = $table->query();
            $query->delete()
                ->where(['dataset' => Utils::getCurrentDataset()])
                ->execute();
        } else {
            $query = $table->query();
            $query->delete()
                ->where(['dataset' => $id])
                ->execute();
        }
    }

    public static function getTraceData($graphSource, $graphType)
    {
        if (!$graphType) {
            $graphType = 'temp';
        }

        $graphTypeFieldMapper = [
            // input
            'temp' => 'temp',
            'precip' => 'precip',
            'rain' => 'rain',
            'et' => 'et',
            // validation
            'ucd1' => 'ucd1',
            'ucd2' => 'ucd2',
            'ucd3' => 'ucd3',
            'ucd4' => 'ucd4',
            'ucd5' => 'ucd5',
            // snow
            'snow' => 'snow_mm',
            'rains' => 'rains',
            'rainns' => 'rainns',
            'snoa' => 'snoa',
            'snom' => 'snom',
            'rssl' => 'rssl',
            'rsi' => 'rsi',            
            'tdsm' => 'tdsm',
            'rdsm' => 'rdsm',
            'snow_acc' => 'snow_acc',
            'snowmelt' => 'snowmelt',
            'et_above_g' => 'et_above_g',
            'etfsas' => 'etfsas',
            'et_above_re' => 'et_above_re',
            'water_or_sr' => 'water_or_sr',
            'snow_calc' => 'snow_calc',
            // soil
            'inf_cap_corr' => 'inf_cap_corr',
            'drafre' => 'drafre',
            'drain_corr' => 'drain_corr',
            'drain_boost_excess' => 'drain_boost_excess',
            'drain_boost_oversat' => 'drain_boost_oversat',
            'drain_total' => 'drain_total',
            'etisi' => 'etisi',
            'et_corr' => 'et_corr',
            'etfsas' => 'etfsas',
            'swcint' => 'swcint',
            'swc_corr_sat' => 'swc_corr_sat',
            'swc_corr_sat_pc' => 'swc_corr_sat_pc',
            'sr_exc' => 'sr_exc',
            'sr_exc_less_drain' => 'sr_exc_less_drain',
            'sr_sat' => 'sr_sat',
            'sr_sat_less_drain' => 'sr_sat_less_drain',
            'sr_total' => 'sr_total',
            'sr_total_less_drain' => 'sr_total_less_drain',
            'net_gain' => 'net_gain',
            'net_loss' => 'net_loss',
            'days_low_swc' => 'days_low_swc',
            'days_high_swc' => 'days_high_swc'
        ];

        $graphTypeTableMapper = [
            // input
            'temp' => 'InputData',
            'precip' => 'InputData',
            'rain' => 'InputData',
            'et' => 'InputData',
            // validation
            'ucd1' => 'InputData',
            'ucd2' => 'InputData',
            'ucd3' => 'InputData',
            'ucd4' => 'InputData',
            'ucd5' => 'InputData',        
            // snow
            'snow' => 'SnowData',
            'rains' => 'SnowData',
            'rainns' => 'SnowData',
            'snoa' => 'SnowData',
            'snom' => 'SnowData',
            'rssl' => 'SnowData',
            'rsi' => 'SnowData',            
            'tdsm' => 'SnowData',
            'rdsm' => 'SnowData',
            'snow_acc' => 'SnowData',
            'snowmelt' => 'SnowData',
            'et_above_g' => 'SnowData',
            'etfsas' => 'SnowData',
            'et_above_re' => 'SnowData',
            'water_or_sr' => 'SnowData',
            'snow_calc' => 'SnowData',
            // soil            
            'inf_cap_corr' => 'SoilWaterData',
            'drafre' => 'SoilWaterData',
            'drain_corr' => 'SoilWaterData',
            'drain_boost_excess' => 'SoilWaterData',
            'drain_boost_oversat' => 'SoilWaterData',
            'drain_total' => 'SoilWaterData',
            'etisi' => 'SoilWaterData',
            'et_corr' => 'SoilWaterData',
            'etfsas' => 'SoilWaterData',
            'swcint' => 'SoilWaterData',
            'swc_corr_sat' => 'SoilWaterData',
            'swc_corr_sat_pc' => 'SoilWaterData',
            'sr_exc' => 'SoilWaterData',
            'sr_exc_less_drain' => 'SoilWaterData',
            'sr_sat' => 'SoilWaterData',
            'sr_sat_less_drain' => 'SoilWaterData',
            'sr_total' => 'SoilWaterData',
            'sr_total_less_drain' => 'SoilWaterData',
            'net_gain' => 'SoilWaterData',
            'net_loss' => 'SoilWaterData',
            'days_low_swc' => 'SoilWaterData',
            'days_high_swc' => 'SoilWaterData'
        ];

        $graphSourceTableMapper = [
            1 => '',
            2 => 'Monthly',
            3 => 'Yearly',
            4 => 'Spring',
            5 => 'Summer',
            6 => 'Fall',
            7 => 'Winter',
            8 => 'GrowthSeasonIn',
            9 => 'GrowthSeasonOut',
            10 => 'Seasons',
            11 => 'GrowingSeasons',
            21 => 'Typical',
            22 => 'TypicalMonthly',
            23 => 'TypicalYearly',
            24 => 'TypicalSeasons',
            25 => 'TypicalGrowingSeasons'
        ];

        $fetchedData = self::fetchFieldFromDb(
            $graphTypeTableMapper[$graphType] . $graphSourceTableMapper[$graphSource],
            $graphTypeFieldMapper[$graphType]
        );

        return $fetchedData;
    }

    public static function getDaysBelowThresholdTraceData($threshold)
    {
        $fetchedData = self::fetchFieldFromDb(
            'SnowDataTypicalMonthly',
            'd_' . $threshold
        );

        return $fetchedData;
    }

    public static function getDateForInputDataFormat($dateString, $format)
    {
        $date = Time::createFromFormat($format, $dateString);

        return array(
            'date' => $date->toDateString(),
            'year' => $date->format('Y'),
            'month' => $date->format('m'),
            'monthLong' => $date->format('M'),
            'day' => $date->format('d')
        );
    }

    public static function singleToDoubleDigitDatePart($number)
    {
        if (($number > 0) && ($number < 10)) {
            return '0' . $number;
        }

        return $number;
    }

    public static function isInputDataLoaded()
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        return self::countTableTotals($inputDataTable);
        // Log::debug('PARAMS: ' . json_encode($total));
    }

    public static function isSnowComplete()
    {
        $inputDataTable = TableRegistry::getTableLocator()->get('SnowData');

        return self::countTableTotals($inputDataTable);
        // Log::debug('PARAMS: ' . json_encode($total));
    }    

    private static function countTableTotals($table)
    {
        $query = $table->find();
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['dataset' => self::getCurrentDataset()]);
        $total = $query->first()['count'];

        // Log::debug('PARAMS: ' . json_encode($total));
        return $total > 0;
    }

    public static function convertMonthToString($input)
    {
        switch ($input) {
            case 1:
                $monthAbbrev = 'Jan';
                break;
            case 2:
                $monthAbbrev = 'Feb';
                break;
            case 3:
                $monthAbbrev = 'Mar';
                break;
            case 4:
                $monthAbbrev = 'Apr';
                break;
            case 5:
                $monthAbbrev = 'May';
                break;
            case 6:
                $monthAbbrev = 'Jun';
                break;
            case 7:
                $monthAbbrev = 'Jul';
                break;
            case 8:
                $monthAbbrev = 'Aug';
                break;
            case 9:
                $monthAbbrev = 'Sep';
                break;
            case 10:
                $monthAbbrev = 'Oct';
                break;
            case 11:
                $monthAbbrev = 'Nov';
                break;
            case 12:
                $monthAbbrev = 'Dec';
                break;
        }

        return $monthAbbrev;
    }

    /*** INPUT DATA VALIDATION ***/
    /*****************************/

    public static function validateGrowthSeasonParams($params) 
    {        
        if ($params['gs_start_day'] && $params['gs_start_month'] && $params['gs_end_day'] && $params['gs_end_month']) {
            $growingSeasonStart = FrozenTime::createFromFormat('m-d', $params['gs_start_month'] . '-' . $params['gs_start_day']);
            $growingSeasonEnd = FrozenTime::createFromFormat('m-d', $params['gs_end_month'] . '-' . $params['gs_end_day']);

            if ($growingSeasonStart->gte($growingSeasonEnd)) {
                throw new Exception('Growing Season End Date has to be set after the Growing Season Start Date.', 13);
            }            
        }
    }

    private static function validateInput($type, $data)
    {
        switch ($type) {
            case 'date':
                return Utils::validateInputDate($data);
                break;
            case 'temp':
                return Utils::validateInputTemp($data);
                break;
            case 'precip':
                return Utils::validateInputPrecip($data);
                break;
            case 'rain':
                return Utils::validateInputRain($data);
                break;
            case 'et':
                return Utils::validateInputEt($data);
                break;
            // case 'snow':
            //     return Utils::validateInputSnowpack($data);
            //     break;
            // case 'sm':
            //     return Utils::validateInputSoilMoisture($data);
            //     break;
            // case 'sr':
            //     return Utils::validateInputSurfaceRunoff($data);
            //     break;
            // case 'rch':
            //     return Utils::validateInputGroundwaterRecharge($data);
            //     break;
        }
    }

    private static function validateInputDate($data)
    {
        if ($data != null) {
            if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)) // YYYY-MM-DD
            {
                return true;
            }
        }

        return false;
    }

    private static function validateInputTemp($data)
    {
        if ($data != null) {
            if (($data >= -90) && ($data <= 60)) {
                return true;
            }
        }

        return false;
    }

    private static function validateInputPrecip($data)
    {
        if ($data != null) {
            if ($data >= 0) {
                if ($data <= 1800) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function validateInputRain($data)
    {
        if ($data != null) {
            if ($data >= 0) {
                if ($data <= 1800) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function validateInputEt($data)
    {
        if ($data != null) {
            if ($data >= 0) {
                if ($data <= 100) {
                    return true;
                }
            }
        }

        return false;
    }

    // private static function validateInputSnowpack($data)
    // {
    //     if ($data >= 0) {
    //         return true;
    //     }

    //     return false;
    // }

    // private static function validateInputSoilMoisture($data)
    // {
    //     if (($data >= 0) && ($data <= 100)) {
    //         return true;
    //     }

    //     return false;
    // }

    // private static function validateInputSurfaceRunoff($data)
    // {
    //     if ($data >= 0) {
    //         return true;
    //     }

    //     return false;
    // }

    // private static function validateInputGroundwaterRecharge($data)
    // {
    //     if ($data >= 0) {
    //         return true;
    //     }

    //     return false;
    // }

    // ADMIN STUFF //
    public static function hasAdminAccess()
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            return ($user->admin_access) ? true : false;
        }

        return false;
    }

    public static function giveUserAdminAccess()
    {
        // throw new Exception('test');

        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->admin_access = 1;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }
    }

    public static function getExpiredDatasets()
    {
        // return array(1,2,3);
        // return null;

        $now = Time::now();
        $twoDaysAgo = $now->subDays(2);

        $userTable = TableRegistry::getTableLocator()->get('Users');
        $users = $userTable->find()
            ->where([
                'date_updated <' => $twoDaysAgo->toDateString(),
                'data_loaded =' => 1
            ])
            ->all();
        // Log::debug($users);

        $idList = array();
        if (count($users)) {
            foreach ($users as $user) {
                $idList[] = $user->id;
            }
        }

        // Log::debug($idList);
        return $idList;
    }

    public static function hasInputData()
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');
        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

            if ($user instanceof User) {
                if ($user->data_loaded) {
                    return true;
                } else {
                    return false;
                }                
            } else {
                return false;
            }
    }

    public static function hasSnowData()
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');
        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

            if ($user instanceof User) {
                if ($user->snow) {
                    return true;
                } else {
                    return false;
                }                
            } else {
                return false;
            }
    }

    public static function hasSoilData()
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');
        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

            if ($user instanceof User) {
                if ($user->soil_water) {
                    return true;
                } else {
                    return false;
                }                
            } else {
                return false;
            }
    }

    public static function removeCompleteDatasetById($id)
    {
        self::removeInputDataset($id);
        self::removeParamsDataset($id);
        self::removeSnowDataset($id);
        self::removeSoilWaterDataset($id);

        self::resetUserDataById($id);
    }

    private static function resetUserDataById($id)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => $id])
            ->first();

        if ($user instanceof User) {
            $user->data_loaded = 0;
            $user->snow = 0;
            $user->soil_water = 0;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }
    }

    // used by DataTables
    public static function fetchUsageStatsFromDb($startDate, $endDate)
    {
        $dataTable = TableRegistry::getTableLocator()->get('Usages');

        // get total count
        $query = $dataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $total = $query->first()['count'];

        // get filtered count
        if ($startDate && $endDate) {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where([
                'date_added >=' => $startDate,
                'date_added <=' => $endDate,
            ]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->select([
                'test_input' => $query->func()->sum('test_input'),
                'input' => $query->func()->sum('input'),
                'snow' => $query->func()->sum('snow'),
                'export_snow' => $query->func()->sum('export_snow'),
                'soil_water' => $query->func()->sum('soil_water'),
                'export_soil_water' => $query->func()->sum('export_soil_water')                
            ]);
            $query->where([
                'date_added >=' => $startDate,
                'date_added <=' => $endDate,
            ]);
            $usageStatsData = $query->toArray();
        } else {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->select([
                'test_input' => $query->func()->sum('test_input'),
                'input' => $query->func()->sum('input'),
                'snow' => $query->func()->sum('snow'),
                'export_snow' => $query->func()->sum('export_snow'),
                'soil_water' => $query->func()->sum('soil_water'),
                'export_soil_water' => $query->func()->sum('export_soil_water')  
            ]);
            $usageStatsData = $query->toArray();
        }

        $data = [];
        foreach ($usageStatsData as $item) {
            $data[] = array(
                $item->test_input,
                $item->input,
                $item->snow,
                $item->export_snow,
                $item->soil_water,
                $item->export_soil_water                
            );
        }

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    // used by DataTables
    public static function fetchUserDataFromDb($startDate, $endDate)
    {
        $dataTable = TableRegistry::getTableLocator()->get('Users');

        // get total count
        $query = $dataTable->find();
        $query->select(['count' => $query->func()->count('*')]);
        $total = $query->first()['count'];

        // get filtered count
        if ($startDate && $endDate) {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(function (QueryExpression $exp, Query $query) use ($startDate, $endDate) {
                $from = $query->newExpr()->or(['date_added >=' => $startDate])->add(['date_updated >=' => $startDate]);
                $to = $query->newExpr()->or(['date_added <=' => $endDate])->add(['date_updated <=' => $endDate]);

                return $exp->add($query->newExpr()->and([$from, $to]));
            });
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->select('ip');
            $query->where(function (QueryExpression $exp, Query $query) use ($startDate, $endDate) {
                $from = $query->newExpr()->or(['date_added >=' => $startDate])->add(['date_updated >=' => $startDate]);
                $to = $query->newExpr()->or(['date_added <=' => $endDate])->add(['date_updated <=' => $endDate]);

                return $exp->add($query->newExpr()->and([$from, $to]));
            });
            $query->group('ip');
            $uniqueTotal = $query->all();
        } else {
            $query = $dataTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $filteredTotal = $query->first()['count'];

            $query = $dataTable->find();
            $query->select('ip');
            $query->group('ip');
            $uniqueTotal = $query->all();
        }

        $data = array(
            'total' => $filteredTotal,
            'unique' => count($uniqueTotal)
        );

        return array(
            'recordsTotal' => $total,
            'recordsFiltered' => $filteredTotal,
            'recordsData' => $data
        );
    }

    private static function getIpList()
    {
        $dataTable = TableRegistry::getTableLocator()->get('Users');

        // get total count
        $query = $dataTable->find();
        $query->select(['ip']);
        $query->group('ip');
        $uniqueIpList = $query->toArray();

        return $uniqueIpList;
    }

    public static function updateLocationData()
    {
        $userLocationsTable = TableRegistry::getTableLocator()->get('UserLocations');

        $ipList = self::getIpList();

        foreach ($ipList as $ipItem) {
            // look for ipItem
            $query = $userLocationsTable->find();
            $query->select('id');
            $query->where(['ip =' => $ipItem['ip']]);
            $lookUpResult = $query->first();

            // data loaded flags
            $dataLoadedFlags = self::getDataLoadedFlags($ipItem['ip']);

            // if an item was found => don't add again in list, just update data loaded flags
            if (!empty($lookUpResult)) {
                // Log::debug('Will update data flags for IP ' . $ipItem['ip'] . ' identified w id ' . $lookUpResult['id']);
                $existingEntity = $userLocationsTable->get($lookUpResult['id']);
                $existingEntity->sample_data = $dataLoadedFlags['sample_data'];
                $existingEntity->user_data = $dataLoadedFlags['user_data'];
                $userLocationsTable->save($existingEntity);

                // Log::debug('Will not update location data for IP ' . $ipItem['ip']);
                continue;
            }

            try {
                // if not found => use API to get location info
                $locationData = self::getIpToLocationData($ipItem['ip']);

                // add location info
                $newData = array();
                $newData['ip'] = $ipItem['ip'];
                $newData['country'] = Text::transliterate($locationData['country']);
                $newData['city'] = Text::transliterate($locationData['city']);
                $newData['organization'] = Text::transliterate($locationData['org']);
                $newData['lat'] = $locationData['lat'];
                $newData['lon'] = $locationData['lon'];
                $newData['sample_data'] = $dataLoadedFlags['sample_data'];
                $newData['user_data'] = $dataLoadedFlags['user_data'];

                $newEntity = $userLocationsTable->newEntity($newData);
                $userLocationsTable->save($newEntity);
            } catch (Exception $ex) {
                Log::error('Cannot add location data to DB for ip ' . $ipItem['ip'] . ': ' . $ex->getMessage());
            }
        }
    }

    private static function getDataLoadedFlags($ip)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $query = $usersTable->find();
        $query->select('id');
        $query->where(['ip =' => $ip]);
        $usersResult = $query->toArray();
        $userIdList = array_column($usersResult, 'id');
        // Log::debug('userList for IP ' . $ip . ': ' . json_encode($userIdList));

        $usagesTable = TableRegistry::getTableLocator()->get('Usages');
        $query = $usagesTable->find();
        $query->select([
            'test_input' => $query->func()->sum('test_input'),
            'input' => $query->func()->sum('input')
        ]);
        $query->where(['user_id IN' => $userIdList]);
        $usagesResult = $query->toArray();
        // Log::debug('usagesResult for IP ' . $ip . ': ' . json_encode($usagesResult));

        $flags = array(
            'sample_data' => ($usagesResult[0]['test_input'] > 0) ? 1 : 0,
            'user_data' => ($usagesResult[0]['input'] > 0) ? 1 : 0,
        );
        // Log::debug('flags for IP ' . $ip . ': ' . json_encode($flags));

        return $flags;
    }

    private static function getIpToLocationData($ip)
    {
        // return self::getIpToLocationDataTest();

        $http = new Client();

        $response = $http->post('http://ip-api.com/json/' . $ip);
        $responseDecoded = $response->getJson();

        if (!$responseDecoded || (strcmp($responseDecoded['status'], 'success') != 0)) {
            throw new Exception('Cannot get location via API');
        }

        return $responseDecoded;
    }

    private static function getIpToLocationDataTest()
    {
        return array(
            'country' => 'test',
            'city' => 'test',
            'org' => 'test',
            'lat' => -45,
            'lon' => 0
        );
    }

    public static function getLocationData($type = null)
    {
        $userLocationsTable = TableRegistry::getTableLocator()->get('UserLocations');

        $query = $userLocationsTable->find();
        if ($type) {
            switch ($type) {
                case 2:
                    $query->where([
                        'OR' => ['sample_data >' => 0, 'user_data >' => 0]
                    ]);
                    break;
                case 3:
                    $query->where(['sample_data >' => 0]);
                    break;
                case 4:
                    $query->where(['user_data >' => 0]);
                    break;
                default:
                    break;
            }
        }
        $locationData = $query->toArray();

        return $locationData;
    }      

    public static function getToolTips()
    {
        return array(
            'TEMP' => 'Mean air temperature',
            'TOTPP' => 'Total precipitation',
            'RAIN' => 'Rain amount',
            'ETA' => 'Actual evapotranspiration',
            'UCD' => 'User calibration data',
            'UCD1' => 'User calibration data',
            'UCD2' => 'User calibration data',
            'UCD3' => 'User calibration data',
            'UCD4' => 'User calibration data',
            'UCD5' => 'User calibration data',
            'GS_start_day' => 'Growth Season Start Day',
            'GS_start_month' => 'Growth Season Start Month',
            'GS_end_day' => 'Growth Season End Day',
            'GS_end_month' => 'Growth Season End Month',
            // snow params
            'SNWTinit' => 'Initial snow layer thickness - Thickness of the snow layer on the first day of the analysis. This is converted into mm for subsequent calculations using 1/CFSmc',
            'SNWTinit_val' => 'Required values greater that or equal to 0',
            'SNWMinit' => 'Initial snowmelt - Amount of snow melted on the first day of the analysis',
            'SNWMinit_val' => 'Required values greater that or equal to 0',
            'THRrs' => 'Air temperature threshold for rain to be accumulated as snow - Precipitation falling as rain is treated as snow when air temperature is below this threshold. This results in the respective rain amount to be added to the snow layer instead of infiltrating and/or becoming surface runoff',
            'THRrs_val' => 'Required values between -20 and 10',
            'THRsm' => 'Air temperature threshold for initiating snowmelt - Melting of the snow occurs on days with air temperature above this threshold',
            'THRsm_val' => 'Required values between -20 and 10',
            'CFTsm' => 'Correction factor, snowmelt due to air temperature - The amount of snow that is melted for each degree of air temperature above THRsm',
            'CFTsm_val' => 'Required values greater that or equal to 0',            
            'CFRsm' => 'Correction factor, snowmelt due to rain - The amount of snow that is melted for each mm of rain that is not accumulated in the snow layer',
            'CFRsm_val' => 'Required values greater that or equal to 0',
            'CFSmc' => 'Correction factor, snow as mm water to cm snow - Factor for converting calculated snow layer thickness from mm water (as calculated by the model) to cm of snow',
            'CFSmc_val' => 'Required values greater that or equal to 0',
            'CFets' => 'Correction factor, portion of evapotranspiration occurring in the soil - Factor for estimating the portion of actual evapotranspiration (ET) that occurs in the soil. The remainder of ET is considered to occur before water enters the soil (e.g., canopy interception; water ponding at the soil surface, etc.)',
            'CFets_val' => 'Required values between 0 and 1',
            // snow output
            'SNOF' => 'Snow fall amount',
            'RAINS' => 'Rain added to the snow layer - Amount of rain that is converted to snow (dependent on THRrs)',
            'RAINNS' => 'Rain not added to the snow layer - Amount of rain that is converted to snow (dependent on THRrs)',
            'SNOA' => 'Snowfall added to the snow layer - Amount of snowfall that is added to the snow layer (dependent on THRsm)',
            'SNOM' => 'Snowfall not added to the snow layer - Amount of snowfall that is melting instead of being added to the snow layer',
            'RSSL' => 'Rain and snow fall contributing to snow layer - Amount of water from rain and snowfall that accumulates to the snow layer before temperature and precipitation corrections for the snow layer are applied',
            'RSI' => 'Rain and snow fall contributing to infiltration - Amount of water from rain and snowfall that does not accumulate to the snow and contributes to water available for infiltration',
            'SNMT' => 'Snowmelt due to temperature - The amount of snowmelt is dependent on the air temperature. SNMT is calculated using the degree-day concept and is dependent on THRsm and CFTsm',
            'SNMR' => 'Snowmelt due to rain - Rain that is not converted to snow can produce snowmelt. SNMR represents the amount of snowmelt associated (direct) rain. SNMR is calculated using a concept similar to the degree-day concept used for SNMT and is dependent on CFPsm',
            'SNTFmm' => 'Snow layer thickness - Snow layer thickness (expressed as mm) after temperature and precipitation corrections. SNTF represents the final values of snow layer thickness and is a key output parameter',
            'SNMF' => 'Snowmelt - Snowmelt amount after temperature and precipitation corrections. SNMF represents water originating from the snow layer that becomes available for infiltration and/or surface runoff. The assumption is that all the snow that melts becomes available for infiltration and/or surface runoff instead of being stored above the ground in liquid',
            'ETasi' => 'Above soil ET (mm) before correction for dry soil - Portion of evapotranspiration that occurs above soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of Etasi is controlled by CFets. This is an intermediate result that is adjusted via subsequent calculations',
            'ETfsas' => 'ET from soil transferred to ET above soil when soil is dry - Evapotranspiration from soil ceases under dry soil conditions (controlled by THRets). THRets allows for transferring ET from soil to ET above ground ET (ETAs) if evaporative demand is still present (ETA) when the soil is dry. The full calculations for ETfsas are performed in the Water Balance module. If the Water Balance module has not been run, ETfsas is assumed to be zero. Generally ETfsas is small and hence this limitation is not expected to impact calculations significantly. ETfsas values are adjusted once the Water Balance model calculations are performed. ETfsas is the amount transferred from soil ET to above soil ET',
            'ETasf' => 'Above soil ET after rerouting ET from dry soil - Portion of evapotranspiration that occurs above soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of Etasf (and ETasi) is controlled by CFets. This is the final result representing the portion of evapotranspiration that occurs above soil and includes corrections for dry soil conditions (ETfsas)',
            'WATisri' => 'Water available for infiltration or surface runoff before ET correction - The water amount that is available for either infiltration or surface runoff. WATisri is an intermediate result that does not account for the impact of evapotranspiration',
            'WATisrf' => 'Water available for infiltration or surface runoff after ET correction - The water amount that is available for either infiltration or surface runoff after all corrections, including impact of evapotranspiration. WATisrf is a key parameter calculated in the SNOW module and constitutes starting point for the calculations conducted in the Water Balance module',
            'SNTFcm' => 'Snow layer thickness - Snow layer thickness (expressed as cm) after temperature and precipitation corrections. SNTFcm is obtained by converting SNTFmm to cm of snow by using CFSmc. SNTFcm represents the final values of snow layer thickness and is a key output parameter . SNTFcm can be used for validating the results against snow layer thickness validation data',
            // soil params  
            'SWCinit' => 'SWC, as percentage of PORe on the first day of the analysis. SWCinit cannot be higher than the effective porosity of the layer (PORe)',
            'SWCinit_val' => 'Required values between 1 and 100',
            'SRinit' => 'Surface runoff - Amount of surface runoff on the first day of the analysis',
            'SRinit_val' => 'Required values greater that or equal to 0',
            'NGinit' => 'Net SWC gain - Net gain in SWC on the first day of the analysis',
            'NGinit_val' => 'Required values greater that or equal to 0',
            'NLinit' => 'Net SWC loss - Net loss in SWC on the first day of the analysis',
            'NLinit_val' => 'Required values greater that or equal to 0',
            'THKN' => 'Layer or root zone thickness - The thickness of the modelled layer. The layer can be the root zone, a soil horizon or the entire soil profile',
            'THKN_val' => 'Required values greater that or equal to 0',
            'PORe' => 'Layer effective porosity - Effective porosity of the layer. This is used for defining the maximum soil water content (SWC)',
            'PORe_val' => 'Required values between 1 and 100',
            'THRinfLH' => 'SWC threshold for switching between low and high infiltration rate - Infiltration rate is high when soil water content (SWC) is below this threshold and low when SWC is  above this threshold',
            'THRinfLH_val' => 'Required values between 0 and 100',
            'INFlr' => 'Infiltration rate at low SWC - Infiltration rate when SWC is lower than THRinfLH (i.e. high infiltration rate)',
            'INFlr_val' => 'Required values greater that or equal to 0',
            'INFhr' => 'Infiltration rate at high SWC - Infiltration rate when SWC is higher than THRinfLH (i.e. low infiltration rate)',
            'INFhr_val' => 'Required values greater that or equal to 0',
            'THRdraHL' => 'Threshold for SWC to switch drainage from high to low rate - Drainage rate is high when soil water content (SWC) is above this threshold and low when SWC is below this threshold',
            'THRdraHL_val' => 'Required values between 1 and 100',
            'DRAlr' => 'Drainage rate at low SWC - Drainage rate when SWC is lower than THRdraHL (i.e. low drainage rate)',
            'DRAlr_val' => 'Required values greater that or equal to 0',
            'DRAhr' => 'Drainage rate at high SWC - Drainage rate when SWC is higher than THRdraHL (i.e. high drainage rate)',
            'DRAhr_val' => 'Required values greater that or equal to 0',
            'THRswstd' => 'SWC threshold for stopping drainage - Drainage stops when the SWC is below this threshold. This corresponds to dry soil conditions when drainage is expected to cease',
            'THRswstd_val' => 'Required values between 1 and 100',
            'THRtstd' => 'Air temperature threshold for stopping drainage - Drainage stops when the air temperature is below this threshold. This is considered to be a reasonable proxy for simulating frozen soil conditions. THRtstd is generally lower than the actual soil temperature',
            'THRtstd_val' => 'Required values between -20 and 10',
            'CFeidr' => 'Drainage boost correction factor, excess infiltration - Forces a proportion of water from excess infiltration to be re-routed to drainage instead of surface runoff. Use of non-zero CFeidr forces the model to bypass SWC calculation. Hence, CFeidr starting values should be zero, and should be adjusted only if model calibration using other parameters is not satisfactory',
            'CFeidr_val' => 'Required values between 0 and 1',
            'CFosdr' => 'Drainage boost correction factor, oversaturation - Forces a proportion of water from oversaturation (i.e. when SWC > PORe) to be re-routed to drainage instead of surface runoff. Use of CFosdr forces the model to bypass SWC calculation. CFosdr starting values should be zero, and should be adjusted only if model calibration using other parameters is not satisfactory',
            'CFosdr_val' => 'Required values between 0 and 1',                 
            'THRets' => 'SWC threshold for stopping soil evapotranspiration - Forces evapotranspiration to stop when SWC is below this value',
            'THRets_val' => 'Required values between 1 and 100',
            'THRlw' => 'Threshold for low SWC state - Threshold for considering the soil to be in a low SWC state. This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days that require irrigation or number of days with water deficit',
            'THRlw_val' => 'Required values between 1 and 100',
            'THRhw' => 'Threshold for high SWC state - Threshold for considering the soil to be in a high SWC state. This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days with excess water present in the soil',
            'THRhw_val' => 'Required values between 1 and 100',
            // soil output
            'INFcap' => 'Infiltration capacity - Maximum allowed daily infiltration. INFcap is based on either INFlr (low infiltration rate) or INFhr (high infiltration rate) as triggered by THRinfLH. Excess water is transferred to surface runoff when WATisrf > INFcap',
            'INFact' => 'Actual infiltration - Actual infiltration as constrained by WATisrf and INFcap. WATisrf that is in excess of INFcap is re-routed to surface runoff. INFact incorporates all adjustments relative to the infiltration process and is considered a key output parameter',
            'DRAcap' => 'Drainage capacity - Maximum allowed daily drainage. DRAcap is based on either DRAlr (low infiltration rate) or DRAhr (high infiltration rate) as triggered by THRdraLH',
            'DRAfre' => 'Drainage with frozen soil conditions - DRAcap corrected for frozen soil conditions as triggered by THRtstd. Drainage stops when soil temperature is lower than THRtstd',
            'DRAfin' => 'Drainage with dry soil correction - DRAfre corrected for dry soil conditions as trigerred by THRswstd. Drainage stops when SWC is lower than THRtstd. DRAfin represents the drainage before surface runoff boost (if any) is applied',
            'DRAbinf' => 'Drainage boost from excess infiltration - Excess water is transferred to surface runoff when WATisrf > INFcap. For these cases, drainage can be set to receive a proportion of the water directly from surface runoff, as triggered by CFeidr.  Use of non-zero CFeidr forces the model to bypass SWC calculation. Hence, CFeidr starting values should be zero, and should be adjusted only if model calibration using other parameters is not satisfactory',
            'DRAoss' => 'Drainage boost from oversaturated soil - When soil becomes oversaturated, excess water is transferred to surface runoff. For these cases, drainage can be set to receive a proportion of the water directly from surface runoff, as triggered by CFosdr.  Use of non-zero CFosdr forces the model to bypass SWC calculation. Hence, CFosdr starting values should be zero, and should be adjusted only if model calibration using other parameters is not satisfactory',
            'DRAact' => 'Actual drainage - Actual drainage. DRAact incorporates all adjustments relative to the drainage processes and is considered a key output parameter',
            'ETisi' => 'Soil ET before correction for dry soil correction - Portion of evapotranspiration that occurs in the soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of Etisi is controlled by CFets. This is an intermediate result that is adjusted via subsequent calculations',
            'ETcds' => 'Soil ET corrected for dry soil - Evapotranspiration from soil ceases under dry soil conditions (controlled by THRets). ETcds is equal to ETisi when the soil is not under dry conditions and zero on the days with dry soil conditions',
            'SWCint' => 'Soil water content - intermediate - SWC after integrating infiltration, drainage and evapotranspiration processes. This is an intermediate result that is adjusted via subsequent calculations',
            'SWCfinmm' => 'Soil water content - corrected for saturated soil - SWC after SWCint is corrected for saturated soil conditions as set by PORe. SWCfinmm incorporates all adjustments relative to the SWC and is a key output parameter',
            'SWCfin' => 'Soil water content - corrected for saturated soil - SWC after SWCint is corrected for saturated soil conditions as set by PORe. SWCfin incorporates all adjustments relative to the SWC and is a key output parameter',
            'SReinf' => 'Surface runoff due to excess infiltration - Surface runoff due to excess water available for infiltration. Excess water is transferred to surface runoff when WATisrf > INFcap',
            'SReinfDB' => 'Surface runoff due to excess infiltration after removing drainage boost - Surface runoff due to excess water available for infiltration (WATisrf > INFcap) after a portion (controlled by CFeidr) has been re-routed to drainage (DRAbinf)',
            'SResas' => 'Surface runoff due to saturated soil - Surface runoff due to soil oversaturation (SWC > PORe). When soil becomes oversaturated, excess water is transferred to surface runoff',
            'SResasDB' => 'Surface runoff due to saturated soil after removing drainage boost - Surface runoff due to soil oversaturation (SWC > PORe) after a portion (controlled by CFosdr) has been re-routed to drainage (DRAoss)',
            'SRTint' => 'Total surface runoff before removing drainage boost - Total surface runoff, including all adjustments except for removing drainage boost (DRAbinf and DRAoss). This is an intermediate result that is adjusted via subsequent calculations',
            'SRTact' => 'Total surface runoff after removing drainage boost - SRTact is SRTint after removing drainage boost (DRAbinf and DRAoss). SRTact incorporates all adjustments relative to the surface runoff processes and is considered a key output parameter',
            'SWCgain' => 'Net SWC gain - Soil layer gains water when SWCfinmm on day i+1 is higher than on day i. SWCgain similar to SWCloss over the long-term indicates that the soil water storage is in equilibrium',
            'SWCloss' => 'Net SWC loss - Soil layer losses water when SWCfinmm on day i+1 is lower than on day i. SWCgain similar to SWCloss over the long-term indicates that the soil water storage is in equilibrium',
            'SWClow' => 'Days with low soil water content - Count for days in low SWC state (triggered by THRlw). This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days that require irrigation or number of days with water deficit',
            'SWChigh' => 'Days with high soil water content - Count for days in high SWC state (triggered by THRlw). This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days with excess water present in the soil'
        );
    }

    public static function transformKey($key)
    {
        // general
            if(strcmp($key, 'time_index') == 0){
                return 'Index';
            }         

            if(strcmp($key, 'time_name') == 0){
                return 'Date';
            }

            if(strcmp($key, 'temp') == 0){
                return 'TEMP (deg C)';
            }

            if(strcmp($key, 'precip') == 0){
                return 'TOTPP (mm)';
            }

            if(strcmp($key, 'rain') == 0){
                return 'RAIN (mm)';
            }

            if(strcmp($key, 'et') == 0){
                return 'ETA (mm)';
            }

            if(strcmp($key, 'ucd1') == 0){
                return 'UCD1';
            }

            if(strcmp($key, 'ucd2') == 0){
                return 'UCD2';
            }

            if(strcmp($key, 'ucd3') == 0){
                return 'UCD3';
            }

            if(strcmp($key, 'ucd4') == 0){
                return 'UCD4';
            }        

            if(strcmp($key, 'ucd5') == 0){
                return 'UCD5';
            }        
            
        // snow
            if(strcmp($key, 'snow_mm') == 0){
                return 'SNOF (mm)';
            }

            if(strcmp($key, 'rains') == 0){
                return 'RAINS (mm)';
            }

            if(strcmp($key, 'rainns') == 0){
                return 'RAINNS (mm)';
            }

            if(strcmp($key, 'snoa') == 0){
                return 'SNOA (mm)';
            }

            if(strcmp($key, 'snom') == 0){
                return 'SNOM (mm)';
            }

            if(strcmp($key, 'rssl') == 0){
                return 'RSSL (mm)';
            }

            if(strcmp($key, 'rsi') == 0){
                return 'RSI (mm)';
            }

            if(strcmp($key, 'tdsm') == 0){
                return 'SNMT (mm)';
            }

            if(strcmp($key, 'rdsm') == 0){
                return 'SNMR (mm)';
            }

            if(strcmp($key, 'snow_acc') == 0){
                return 'SNTFmm (mm)';
            }

            if(strcmp($key, 'snowmelt') == 0){
                return 'SNMF (mm)';
            }

            if(strcmp($key, 'et_above_g') == 0){
                return 'ETasi (mm)';
            }

            if(strcmp($key, 'et_above_re') == 0){
                return 'ETasf (mm)';
            }

            if(strcmp($key, 'etfsas') == 0){
                return 'ETfsas (mm)';
            }

            if(strcmp($key, 'watisri') == 0){
                return 'WATisri (mm)';
            }

            if(strcmp($key, 'water_or_sr') == 0){
                return 'WATisrf (mm)';
            }

            if(strcmp($key, 'snow_calc') == 0){
                return 'SNTFcm (cm)';
            }     

        // soil moisture    
            if(strcmp($key, 'infcap') == 0){
                return 'INFcap (mm)';
            }

            if(strcmp($key, 'inf_cap_corr') == 0){
                return 'INFact (mm)';
            }

            if(strcmp($key, 'dracap') == 0){
                return 'DRAcap (mm)';
            }

            if(strcmp($key, 'drafre') == 0){
                return 'DRAfre (mm)';
            }

            if(strcmp($key, 'drain_corr') == 0){
                return 'DRAfin (mm)';
            }

            if(strcmp($key, 'drain_boost_excess') == 0){
                return 'DRAbinf (mm)';
            }

            if(strcmp($key, 'drain_boost_oversat') == 0){
                return 'DRAoss(mm)';
            }

            if(strcmp($key, 'drain_total') == 0){
                return 'DRAact (mm)';
            }

            if(strcmp($key, 'etisi') == 0){
                return 'ETisi (mm)';
            }            

            if(strcmp($key, 'et_corr') == 0){
                return 'ETcds (mm)';
            }

            if(strcmp($key, 'swcint') == 0){
                return 'SWCint (mm)';
            }

            if(strcmp($key, 'swc_corr_sat') == 0){
                return 'SWCfinmm (mm)';
            }   
            
            if(strcmp($key, 'swc_corr_sat_pc') == 0){
                return 'SWCfin (%)';
            }   

            if(strcmp($key, 'sr_exc') == 0){
                return 'SReinf (mm)';
            }   

            if(strcmp($key, 'sr_exc_less_drain') == 0){
                return 'SReinfDB (mm)';
            }   

            if(strcmp($key, 'sr_sat') == 0){
                return 'SResas (mm)';
            }   
            
            if(strcmp($key, 'sr_sat_less_drain') == 0){
                return 'SResasDB (mm)';
            }   

            if(strcmp($key, 'sr_total') == 0){
                return 'SRTint (mm)';
            }   

            if(strcmp($key, 'sr_total_less_drain') == 0){
                return 'SRTact (mm)';
            }

            if(strcmp($key, 'net_gain') == 0){
                return 'SWCgain (mm)';
            }   
            
            if(strcmp($key, 'net_loss') == 0){
                return 'SWCloss (mm)';
            }             

            if(strcmp($key, 'days_low_swc') == 0){
                return 'SWClow';
            }

            if(strcmp($key, 'days_high_swc') == 0){
                return 'SWChigh';
            }

        // metadata
            if(strcmp($key, 'gs_start_day') == 0){
                return 'GS_start_day';
            }

            if(strcmp($key, 'gs_start_month') == 0){
                return 'GS_start_month';
            }

            if(strcmp($key, 'gs_end_day') == 0){
                return 'GS_end_day';
            }

            if(strcmp($key, 'gs_end_month') == 0){
                return 'GS_end_month';
            }

            if(strcmp($key, 'thr_rs') == 0){
                return 'THRrs (deg C)';
            }

            if(strcmp($key, 'thr_sm') == 0){
                return 'THRsm (deg C)';
            }

            if(strcmp($key, 'cft_sm') == 0){
                return 'CFTsm (mm)';
            }

            if(strcmp($key, 'cfp_sm') == 0){
                return 'CFRsm (mm)';
            }

            if(strcmp($key, 'cfs_mc') == 0){
                return 'CFSmc (mm)';
            }

            if(strcmp($key, 'cf_ets') == 0){
                return 'CFets (mm)';
            }

            if(strcmp($key, 'snwt_init') == 0){
                return 'SNWTinit (cm)';
            }

            if(strcmp($key, 'snwm_init') == 0){
                return 'SNWMinit (mm)';
            }            

            if(strcmp($key, 'thkn') == 0){
                return 'THKN (mm)';
            }

            if(strcmp($key, 'por_e') == 0){
                return 'PORe (%)';
            }

            if(strcmp($key, 'thr_inf_lh') == 0){
                return 'THRinfLH (%)';
            }

            if(strcmp($key, 'inf_lr') == 0){
                return 'INFlr (mm/hr)';
            }

            if(strcmp($key, 'inf_hr') == 0){
                return 'INFhr (mm/hr)';
            }

            if(strcmp($key, 'thr_inf_hl') == 0){
                return 'THRdraHL (%)';
            }

            if(strcmp($key, 'dra_lr') == 0){
                return 'DRAlr (mm/hr)';
            }

            if(strcmp($key, 'dra_hr') == 0){
                return 'DRAhr (mm/hr)';
            }  
            
            if(strcmp($key, 'thr_swsd') == 0){
                return 'THRswstd (%)';
            }

            if(strcmp($key, 'thr_tsd') == 0){
                return 'THRtstd (deg C)';
            } 

            if(strcmp($key, 'cf_eidr') == 0){
                return 'CFeidr';
            }

            if(strcmp($key, 'cf_osdr') == 0){
                return 'CFosdr';
            } 

            if(strcmp($key, 'thr_ets') == 0){
                return 'THRets (%)';
            }

            if(strcmp($key, 'thr_lw') == 0){
                return 'THRlw (%)';
            } 

            if(strcmp($key, 'thr_hw') == 0){
                return 'THRhw (%)';
            }

            if(strcmp($key, 'swc_init') == 0){
                return 'SWCinit (mm)';
            }

            if(strcmp($key, 'sr_init') == 0){
                return 'SRinit (mm)';
            }

            if(strcmp($key, 'ng_init') == 0){
                return 'NGinit (mm)';
            }

            if(strcmp($key, 'nl_init') == 0){
                return 'NLinit (mm)';
            }

        return $key;
    }    

    public static function setStopAnalysisFlag($status)
    {
        $userTable = TableRegistry::getTableLocator()->get('Users');

        $user = $userTable->find()
            ->where(['id' => self::getCurrentDataset()])
            ->first();

        if ($user instanceof User) {
            $user->stop_analysis_flag = $status ? 1 : 0;
            $userTable->save($user);
        } else {
            throw new Exception('Cannot find User!');
        }        
    }

    public static function getStopAnalysisFlag()
    {
        $result = self::fetchFieldFromUsersDb('Users', 'stop_analysis_flag');
        
        return $result['stop_analysis_flag'] ? true : false;
    }

    public static function cloneTable($sourceTable, $targetTable)
    {
        $connection = ConnectionManager::get('default');
        $truncateResults = $connection->execute('DELETE FROM ' . $targetTable . ' WHERE dataset = ' . self::getCurrentDataset());
        $insertResults = $connection->execute('INSERT INTO ' . $targetTable . ' SELECT * FROM ' . $sourceTable . ' WHERE dataset = ' . self::getCurrentDataset());
    }    

    // BIVARIABLE STATS CALCULATION //
    //////////////////////////////////    

    /**
     * Calculates bivariable stats for a given pair (used POST analysis)
     *
     * @param string $type 'SnowCalibration' or 'SoilCalibration'
     *
     * @param int $timeStep 1 = Daily, etc.
     * 
     * @param int $startIndex
     * 
     * @param int $endIndex
     * 
     * @return array
     */
    public static function calculateBivariableStats($type, $timeStep, $startIndex = null, $endIndex = null)
    {                                        
        // Log::debug('*** ' . $type . ' bivariableStatsCalc ' . $timeStep . ' from ' . $startIndex . ' to ' . $endIndex);   

        switch ($type) {
            case 'SnowCalibration':
                $calibration = self::getSnowCalibrationFields();

                $statsData = array(
                    'r_2' => [],
                    'rmsd' => [],
                    'nrmsd_minmax' => [],
                    'nrmsd_mean' => [],
                    'nrmse_iqr' => []
                );                  
                
                // pair 1
                if (!empty($calibration['output1_field']) && !empty($calibration['ucd1_field'])) {
                    $targetPair = array(
                        'output_field' => $calibration['output1_field'],
                        'ucd_field' => $calibration['ucd1_field']
                    );
                    // Log::debug('pair1: ' . json_encode($targetPair));
                    
                    $bivariableStats = self::calculateBivariableStatsForGivenPair($type, $timeStep, $targetPair, $startIndex, $endIndex);                 
                                
                    $statsData['r_2'][0] = $bivariableStats['r_2'];
                    $statsData['rmsd'][0] = $bivariableStats['rmsd'];
                    $statsData['nrmsd_minmax'][0] = $bivariableStats['nrmsd_minmax'];
                    $statsData['nrmsd_mean'][0] = $bivariableStats['nrmsd_mean'];
                    $statsData['nrmse_iqr'][0] = $bivariableStats['nrmse_iqr'];               
                }

                // pair 2
                if (!empty($calibration['output2_field']) && !empty($calibration['ucd2_field'])) {
                    $targetPair = array(
                        'output_field' => $calibration['output2_field'],
                        'ucd_field' => $calibration['ucd2_field']
                    );
                    // Log::debug('pair2: ' . json_encode($targetPair));
                    
                    $bivariableStats = self::calculateBivariableStatsForGivenPair($type, $timeStep, $targetPair, $startIndex, $endIndex);                 
                                
                    $statsData['r_2'][1] = $bivariableStats['r_2'];
                    $statsData['rmsd'][1] = $bivariableStats['rmsd'];
                    $statsData['nrmsd_minmax'][1] = $bivariableStats['nrmsd_minmax'];
                    $statsData['nrmsd_mean'][1] = $bivariableStats['nrmsd_mean'];
                    $statsData['nrmse_iqr'][1] = $bivariableStats['nrmse_iqr'];
                }
                break;                
            case 'SoilCalibration':
                $calibration = self::getSoilCalibrationFields();

                $statsData = array(
                    'r_2' => [],
                    'rmsd' => [],
                    'nrmsd_minmax' => [],
                    'nrmsd_mean' => [],
                    'nrmse_iqr' => []
                );                  
                
                // pair 1
                if (!empty($calibration['output1_field']) && !empty($calibration['ucd1_field'])) {
                    $targetPair = array(
                        'output_field' => $calibration['output1_field'],
                        'ucd_field' => $calibration['ucd1_field']
                    );
                    // Log::debug('pair1: ' . json_encode($targetPair));
                    
                    $bivariableStats = self::calculateBivariableStatsForGivenPair($type, $timeStep, $targetPair, $startIndex, $endIndex);                  
                                
                    $statsData['r_2'][0] = $bivariableStats['r_2'];
                    $statsData['rmsd'][0] = $bivariableStats['rmsd'];
                    $statsData['nrmsd_minmax'][0] = $bivariableStats['nrmsd_minmax'];
                    $statsData['nrmsd_mean'][0] = $bivariableStats['nrmsd_mean'];
                    $statsData['nrmse_iqr'][0] = $bivariableStats['nrmse_iqr'];               
                }

                // pair 2
                if (!empty($calibration['output2_field']) && !empty($calibration['ucd2_field'])) {
                    $targetPair = array(
                        'output_field' => $calibration['output2_field'],
                        'ucd_field' => $calibration['ucd2_field']
                    );
                    // Log::debug('pair2: ' . json_encode($targetPair));
                    
                    $bivariableStats = self::calculateBivariableStatsForGivenPair($type, $timeStep, $targetPair, $startIndex, $endIndex);                 
                                
                    $statsData['r_2'][1] = $bivariableStats['r_2'];
                    $statsData['rmsd'][1] = $bivariableStats['rmsd'];
                    $statsData['nrmsd_minmax'][1] = $bivariableStats['nrmsd_minmax'];
                    $statsData['nrmsd_mean'][1] = $bivariableStats['nrmsd_mean'];
                    $statsData['nrmse_iqr'][1] = $bivariableStats['nrmse_iqr'];
                }
                break;
        }  
        
        return $statsData;
    }
    
    /**
     * Calculate bivariable stats for a given pair
     *
     * @param string $type 'SnowCalibration' or 'SoilCalibration'
     * 
     * @param int $timeStep 1 = Daily, etc.
     *
     * @param array $pair defines the mapping pairs
     * 
     * @param int $index the current index - equal to the number of datapoints analysed
     * 
     * @return array
     */
    private static function calculateBivariableStatsForGivenPair($type, $timeStep, $pair, $startIndex = null, $endIndex = null)
    {                                
        $statsData = array(
            'r_2' => 0,
            'rmsd' => 0,
            'nrmsd_minmax' => 0,
            'nrmsd_mean' => 0,
            'nrmse_iqr' => 0
        );

        $outputField = $pair['output_field'];
        $ucdField = $pair['ucd_field'];
         
        switch ($type) {
            case 'SnowCalibration':
                switch ($timeStep) {
                    case 1:
                        $dataTable = 'SnowData';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);            
                        }        

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchDailySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchDailySnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats for ' . $ucdField . ': ' . json_encode($ucdStats)); 
                        break;                    
                    case 2:
                        $dataTable = 'SnowDataMonthly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchMonthlySnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 10:
                        $dataTable = 'SnowDataSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchSeasonsSnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 11:
                        $dataTable = 'SnowDataGrowingSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchGrowingSeasonsSnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 3:
                        $dataTable = 'SnowDataYearly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchYearlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchYearlySnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats));
                        break;  
                    case 21:
                        $dataTable = 'SnowDataTypical';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);            
                        }        

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchDailySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalDailySnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;                    
                    case 22:
                        $dataTable = 'SnowDataTypicalMonthly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalMonthlySnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 24:
                        $dataTable = 'SnowDataTypicalSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalSeasonsSnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 25:
                        $dataTable = 'SnowDataTypicalGrowingSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalGrowingSeasonsSnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 23:
                        $dataTable = 'SnowDataTypicalYearly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchYearlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalYearSnowStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats));
                        break;
                }    
                // Log::debug('*** ' . $type . ' bivariableStatsCalc for ' . $dataTable . ' from ' . $startIndex . ' to ' . $endIndex);   
                $datasetLen = $endIndex - $startIndex + 1;
                break;
            case 'SoilCalibration':
                switch ($timeStep) {
                    case 1:
                        $dataTable = 'SoilWaterData';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);            
                        }        

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchDailySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchDailySoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;                    
                    case 2:
                        $dataTable = 'SoilWaterDataMonthly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchMonthlySoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 10:
                        $dataTable = 'SoilWaterDataSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchSeasonsSoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 11:
                        $dataTable = 'SoilWaterDataGrowingSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchGrowingSeasonsSoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 3:
                        $dataTable = 'SoilWaterDataYearly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchYearlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchYearlySoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats));
                        break;  
                    case 21:
                        $dataTable = 'SoilWaterDataTypical';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);            
                        }        

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchDailySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalDailySoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;                    
                    case 22:
                        $dataTable = 'SoilWaterDataTypicalMonthly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalMonthlySoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 24:
                        $dataTable = 'SoilWaterDataTypicalSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalSeasonsSoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 25:
                        $dataTable = 'SoilWaterDataTypicalGrowingSeasons';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchMonthlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalGrowingSeasonsSoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats)); 
                        break;
                    case 23:
                        $dataTable = 'SoilWaterDataTypicalYearly';
                        if (!$startIndex && !$endIndex) {
                            $startIndex = 1;
                            $endIndex = self::getCurrentDatasetLengthCustomTimestep($dataTable);
                        }   

                        // calculate mean + max + min for observed data
                        // $outputStats = Utils::fetchYearlySnowStatsFromDb($outputField, $startIndex, $endIndex);
                        // Log::debug('outputStats: ' . json_encode($outputStats));

                        // calculate mean + max + min for ucd data
                        $ucdStats = Utils::fetchTypicalYearSoilStatsFromDb($ucdField, $startIndex, $endIndex);
                        // Log::debug('ucdStats: ' . json_encode($ucdStats));
                        break;
                }   
                // Log::debug('*** ' . $type . ' bivariableStatsCalc for ' . $dataTable . ' from ' . $startIndex . ' to ' . $endIndex);   
                $datasetLen = $endIndex - $startIndex + 1;                
        }       
        // Log::debug('*** ' . $type . ' bivariableStatsCalc for ' . $dataTable . '[' . $outputField . ' vs ' . $ucdField . '] from ' . $startIndex . ' to ' . $endIndex);   
        // Log::debug('datasetLen: ' . $datasetLen);

        // calculate r_2 ***VERIFIED*** 
        $r_2 = pow(Utils::calculatePearsonCoefficient($dataTable, $outputField, $ucdField, $startIndex, $endIndex),2);
        $statsData['r_2'] = is_numeric($r_2) && !is_infinite($r_2) ? $r_2 : null;
        // Log::debug('r_2: ' . $statsData['r_2']);
        
        // calculateSumOfErrors SUM((y-y_estimate)^2) ***VERIFIED***
        $sumE = Utils::calculateSumOfErrors($dataTable, $outputField, $ucdField, $startIndex, $endIndex);
        $sumOfErrors = is_numeric($sumE) && !is_infinite($sumE) ? $sumE : 0;
        // Log::debug('sumOfErrors: ' . $sumOfErrors);                        

        // calculate rmsd ***VERIFIED*** 
        $rmse = sqrt($sumOfErrors/$datasetLen);
        $statsData['rmsd'] = is_numeric($rmse) && !is_infinite($rmse) ? $rmse : NAN;
        // Log::debug('rmsd: ' . $statsData['rmsd']);

        // calculate nrmsd_mean = RMSD / average(UCD) ***VERIFIED***
        if ($ucdStats[0]['average'] != 0) {
            $nrmseMean = $statsData['rmsd']/$ucdStats[0]['average'];
        } else {
            $nrmseMean = INF;
        }
        $statsData['nrmsd_mean'] = is_numeric($nrmseMean) && !is_infinite($nrmseMean) ? $nrmseMean : NAN;
        // Log::debug('nrmsd_mean: ' . $statsData['nrmsd_mean']);

        // calculate nrmsd_minmax = RMSD / (UCDmax - UCDmin) ***VERIFIED***

        if (($ucdStats[0]['maximum'] - $ucdStats[0]['minimum']) != 0) {
            $nrsmeMinMax = $statsData['rmsd']/($ucdStats[0]['maximum'] - $ucdStats[0]['minimum']);
        } else {
            $nrsmeMinMax = INF;
        }
        $statsData['nrmsd_minmax'] = is_numeric($nrsmeMinMax) && !is_infinite($nrsmeMinMax) ? $nrsmeMinMax : NAN;
        // Log::debug('nrmsd_minmax: ' . $statsData['nrmsd_minmax']);

        // calculate nrmse_irq = RMSD / (Quartile3 - Quartile1) ***VERIFIED***
        if ($datasetLen >= 3) {
            $q1OffsetFloor = round(0.25*$datasetLen);  
            if ($q1OffsetFloor > 0) { // offset of the first element in results is 0, not 1
                $q1OffsetFloor -= 1;
            }      
            $q1OffsetCeil = $q1OffsetFloor + 1;
            // Log::debug('q1OffsetFloor: ' . $q1OffsetFloor);
            // Log::debug('q1OffsetCeil: ' . $q1OffsetCeil);
            $q1 = self::getQuartileValue($dataTable, $ucdField, $startIndex, $endIndex, $q1OffsetFloor, $q1OffsetCeil);
            // Log::debug('q1: ' . $q1);
    
            $q3OffsetFloor = round(0.75*$datasetLen);   
            if ($q3OffsetFloor > 0) { // offset of the first element in results is 0, not 1
                $q3OffsetFloor -= 1;
            }     
            $q3OffsetCeil = $q3OffsetFloor + 1;
            // Log::debug('q3OffsetFloor: ' . $q3OffsetFloor);
            // Log::debug('q3OffsetCeil: ' . $q3OffsetCeil);
            $q3 = self::getQuartileValue($dataTable, $ucdField, $startIndex, $endIndex, $q3OffsetFloor, $q3OffsetCeil);
            // Log::debug('q3: ' . $q3);
    
            if ($q3 - $q1 != 0) {
                $nrmseIqr = $statsData['rmsd'] / ($q3 - $q1);
            } else {
                $nrmseIqr = INF;
            }
        } else if ($datasetLen == 2) {
            $quartiles = self::getQuartileValueForExceptionDataset($dataTable, $ucdField, $startIndex, $endIndex);
            $q1 = $quartiles['q1'];
            // Log::debug('q1: ' . $q1);
            $q3 = $quartiles['q3'];
            // Log::debug('q3: ' . $q3);
            if ($q3 - $q1 != 0) {
                $nrmseIqr = $statsData['rmsd'] / ($q3 - $q1);
            } else {
                $nrmseIqr = INF;
            }
        } else {
            $nrmseIqr = NAN;
        }
        $statsData['nrmse_iqr'] = is_numeric($nrmseIqr) && !is_infinite($nrmseIqr) ? $nrmseIqr : NAN;
        // Log::debug('nrmse_iqr: ' . $statsData['nrmse_iqr']);

        return $statsData;
    }    

    private static function getQuartileValue($targetTable, $fieldName, $startIndex, $endIndex, $quartileOffsetFloor, $quartileOffsetCeil)
    {
        $table = TableRegistry::getTableLocator()->get($targetTable);    

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };

        $query = $table->find();
        $query->select($fieldName);        
        $query->where($whereCondition);        
        $query->order('' . $fieldName . ' ASC');
        $query->offset($quartileOffsetFloor);
        $query->limit(1);
        $resultFloor = $query->first(); 

        $query = $table->find();
        $query->select($fieldName);        
        $query->where($whereCondition);        
        $query->order('' . $fieldName . ' ASC');
        $query->offset($quartileOffsetCeil);
        $query->limit(1);
        $resultCeil = $query->first(); 

        return ($resultFloor[$fieldName] + $resultCeil[$fieldName])/2;
    }

    private static function getQuartileValueForExceptionDataset($targetTable, $fieldName, $startIndex, $endIndex)
    {
        $table = TableRegistry::getTableLocator()->get($targetTable);    

        $whereCondition1 = function (QueryExpression $exp, Query $query) use ($startIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index = '" . $startIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start]));            
        };

        $whereCondition2 = function (QueryExpression $exp, Query $query) use ($endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $end = $query->newExpr()->add(["time_index = '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $end]));            
        };

        $query = $table->find();
        $query->select($fieldName);        
        $query->where($whereCondition1);        
        $resultFloor = $query->first(); 
        // Log::debug($resultFloor[$fieldName]);

        $query = $table->find();
        $query->select($fieldName);        
        $query->where($whereCondition2);        
        $resultCeil = $query->first(); 
        // Log::debug($resultCeil[$fieldName]);

        $sum = $resultFloor[$fieldName] + $resultCeil[$fieldName];
        // Log::debug($sum);
        $dif = abs($resultFloor[$fieldName] - $resultCeil[$fieldName]);
        // Log::debug($dif);
        
        return array(
            'q1' => $sum/2 - $dif/4,
            'q3' => $sum/2 + $dif/4
        );
    }

    public static function calculateSumOfErrors($targetTable, $y, $y_estimate, $startIndex, $endIndex)
    {
        $table = TableRegistry::getTableLocator()->get($targetTable);   
        
        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };  

        $query = $table->find();
        $query->select([           
            'sumOfErrors' => $query->func()->sum(
                $query->newExpr()
                ->add(
                    $query->newExpr()
                    ->add(new IdentifierExpression($y_estimate))
                    ->add(new IdentifierExpression($y))
                    ->setConjunction('-'))
                ->add(
                    $query->newExpr()
                    ->add(new IdentifierExpression($y_estimate))
                    ->add(new IdentifierExpression($y))
                    ->setConjunction('-'))                
                ->setConjunction('*'))
        ]);
        $query->where($whereCondition);      
        $result = $query->first();
        
        return $result['sumOfErrors'];
    }  

    public static function calculatePearsonCoefficient($targetTable, $y, $y_estimate, $startIndex, $endIndex)
    {
        $table = TableRegistry::getTableLocator()->get($targetTable);    

        $whereCondition = function (QueryExpression $exp, Query $query) use ($startIndex, $endIndex) {
            $dataset = $query->newExpr()->add(['dataset =' => self::getCurrentDataset()]);            
            $start = $query->newExpr()->add(["time_index >= '" . $startIndex . "'"]);
            $end = $query->newExpr()->add(["time_index <= '" . $endIndex . "'"]);
               
            return $exp->add($query->newExpr()->and([$dataset, $start, $end]));            
        };        

        $query = $table->find();
        $query->select([ 
            'y' => $query->func()->sum($y),         
            'yEstimate' => $query->func()->sum($y_estimate),
            'y_mul_yEstimate' => $query->func()->sum(
                $query->newExpr()
                    ->add(new IdentifierExpression($y))
                    ->add(new IdentifierExpression($y_estimate))
                    ->setConjunction('*')),
            'y_mul_y' => $query->func()->sum(
                $query->newExpr()
                    ->add(new IdentifierExpression($y))
                    ->add(new IdentifierExpression($y))
                    ->setConjunction('*')),
            'yEstimate_mul_yEstimate' => $query->func()->sum(
                $query->newExpr()
                    ->add(new IdentifierExpression($y_estimate))
                    ->add(new IdentifierExpression($y_estimate))
                    ->setConjunction('*')),
        ]);
        $query->where($whereCondition);  
        $result = $query->first();

        $n = $endIndex - $startIndex + 1;
        // Log::debug('n: ' . $n);

        $r_sup = $n * $result['y_mul_yEstimate'] - $result['y'] * $result['yEstimate'];
        $r_sub = sqrt($n * $result['y_mul_y'] - pow($result['y'], 2)) * sqrt($n * $result['yEstimate_mul_yEstimate'] - pow($result['yEstimate'], 2));
        if ($r_sub != 0) {
            $r = $r_sup / $r_sub;
        } else {
            $r = INF;
        }
        
        // Log::debug('r: ' . $r);
        return $r;
    } 
       
}
