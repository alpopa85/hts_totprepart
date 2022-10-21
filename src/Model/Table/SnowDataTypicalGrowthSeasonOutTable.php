<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataTypicalGrowthSeasonOutTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_typical_gs_out');
        $this->setEntityClass('App\Model\Entity\SnowDataTypicalGrowthSeasonOut');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
