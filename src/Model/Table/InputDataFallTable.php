<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataFallTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_fall');
        $this->setEntityClass('App\Model\Entity\InputDataFall');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
