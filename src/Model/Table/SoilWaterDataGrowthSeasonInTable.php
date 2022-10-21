<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataGrowthSeasonInTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data_gs_in');
        $this->setEntityClass('App\Model\Entity\SoilWaterDataGrowthSeasonIn');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
