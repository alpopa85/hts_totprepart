<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataGrowthSeasonOutTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data_gs_out');
        $this->setEntityClass('App\Model\Entity\SoilWaterDataGrowthSeasonOut');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
