<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data');
        $this->setEntityClass('App\Model\Entity\SoilWaterData');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
