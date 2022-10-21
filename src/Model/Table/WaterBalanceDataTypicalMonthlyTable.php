<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataTypicalMonthlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_typical_monthly');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataTypicalMonthly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
