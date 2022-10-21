<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SoilWaterDataGrowingSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('soil_data_growing');
        $this->setEntityClass('App\Model\Entity\SoilWaterDataGrowingSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
