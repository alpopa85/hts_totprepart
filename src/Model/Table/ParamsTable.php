<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ParamsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('params');
        $this->setEntityClass('App\Model\Entity\Params');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
