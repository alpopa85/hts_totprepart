<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Usage extends Entity
{
    protected $_accessible = [
        '*' => true,
        // 'ip' => true
    ];
    
}