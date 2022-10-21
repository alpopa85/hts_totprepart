<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class UserLocations extends Entity
{
    protected $_accessible = [
        '*' => true,
        // 'ip' => true
    ];
    
}