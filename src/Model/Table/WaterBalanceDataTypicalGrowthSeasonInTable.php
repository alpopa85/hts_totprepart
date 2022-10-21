<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataTypicalGrowthSeasonInTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_typical_gs_in');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataTypicalGrowthSeasonIn');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
