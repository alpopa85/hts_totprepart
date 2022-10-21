<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataMonthlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_monthly');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataMonthly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
