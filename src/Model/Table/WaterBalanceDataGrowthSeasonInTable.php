<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataGrowthSeasonInTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_gs_in');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataGrowthSeasonIn');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
