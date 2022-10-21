<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class InputDataTypicalSeasonsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('input_data_typical_seasons');
        $this->setEntityClass('App\Model\Entity\InputDataTypicalSeasons');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');        
        
        return $query;
    }
}
