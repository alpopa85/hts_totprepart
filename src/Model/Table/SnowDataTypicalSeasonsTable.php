<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataTypicalSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_typical_seasons');
        $this->setEntityClass('App\Model\Entity\SnowDataTypicalSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
