<?php

namespace App\Controller;

use App\Model\Utils;
class MainController extends AppController  
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->viewBuilder()->setLayout('project');

        $this->set('tooltips', Utils::getTooltips());
        
        $this->set('title', 'TotPrePart');
        $this->set('activeNavbarId', 'main');       
    }

    public function index()
    {      
        
    }    

    public function mySession()
    {
        $session = $this->getRequest()->getSession();

        $sessionData = array(
            'time' => $session->read('time')
        );    
        $this->set('sessionData', $sessionData);
    }
    
}