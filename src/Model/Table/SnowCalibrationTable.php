<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowCalibrationTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_calibration');
        $this->setEntityClass('App\Model\Entity\SnowCalibration');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
