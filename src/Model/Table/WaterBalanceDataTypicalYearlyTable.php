<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataTypicalYearlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_typical_yearly');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataTypicalYearly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
