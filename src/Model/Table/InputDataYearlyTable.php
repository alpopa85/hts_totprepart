<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataYearlyTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_yearly');
        $this->setEntityClass('App\Model\Entity\InputDataYearly');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
