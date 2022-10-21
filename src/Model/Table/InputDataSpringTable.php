<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataSpringTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_spring');
        $this->setEntityClass('App\Model\Entity\InputDataSpring');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
