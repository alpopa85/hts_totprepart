<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SnowDataFallTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('snow_data_fall');
        $this->setEntityClass('App\Model\Entity\SnowDataFall');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
