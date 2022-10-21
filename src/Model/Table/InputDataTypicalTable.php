<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataTypicalTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_typical');
        $this->setEntityClass('App\Model\Entity\InputDataTypical');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
