<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsagesTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        // $this->setTable('users');
        // $this->setPrimaryKey('id');
        // $this->setEntityClass('App\Model\Entity\User');
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
