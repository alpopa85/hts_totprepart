<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataGrowingSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_growing');
        $this->setEntityClass('App\Model\Entity\SnowDataGrowingSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
