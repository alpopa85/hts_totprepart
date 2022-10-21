<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataTypicalGrowingSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_typical_growing');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataTypicalGrowingSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
