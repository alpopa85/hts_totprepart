<?php
namespace App\View\Helper;

use Cake\View\Helper;

use App\Model\Utils;

class isSetGrowthSeasonHelper extends Helper
{
    public function getFlag()
    {        
        return Utils::isSetGrowthSeason();        
    }
}