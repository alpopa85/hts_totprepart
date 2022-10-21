<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataSummerTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data_summer');
        $this->setEntityClass('App\Model\Entity\SoilWaterDataSummer');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
