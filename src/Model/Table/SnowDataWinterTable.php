<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataWinterTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_winter');
        $this->setEntityClass('App\Model\Entity\SnowDataWinter');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
