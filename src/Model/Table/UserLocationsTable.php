<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserLocationsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('user_locations');
        $this->setPrimaryKey('id');
        $this->setEntityClass('App\Model\Entity\UserLocations');
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
