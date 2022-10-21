<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataGrowthSeasonInTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_gs_in');
        $this->setEntityClass('App\Model\Entity\InputDataGrowthSeasonIn');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
