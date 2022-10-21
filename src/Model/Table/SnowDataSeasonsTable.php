<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_seasons');
        $this->setEntityClass('App\Model\Entity\SnowDataSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
