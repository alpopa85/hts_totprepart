<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataMonthlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data_monthly');
        $this->setEntityClass('App\Model\Entity\SoilWaterDataMonthly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
