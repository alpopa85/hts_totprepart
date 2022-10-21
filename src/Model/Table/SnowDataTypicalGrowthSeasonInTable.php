<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataTypicalGrowthSeasonInTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_typical_gs_in');
        $this->setEntityClass('App\Model\Entity\SnowDataTypicalGrowthSeasonIn');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
