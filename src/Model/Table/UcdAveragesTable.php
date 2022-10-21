<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UcdAveragesTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('ucd_averages');
        $this->setEntityClass('App\Model\Entity\UcdAverages');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
