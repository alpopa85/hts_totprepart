<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class WaterBalanceDataSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('balance_data_seasons');
        $this->setEntityClass('App\Model\Entity\WaterBalanceDataSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
