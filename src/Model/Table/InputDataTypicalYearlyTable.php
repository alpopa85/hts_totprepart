<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataTypicalYearlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_typical_yearly');
        $this->setEntityClass('App\Model\Entity\InputDataTypicalYearly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
