<?php $this->start('input_menu'); ?>
<!-- INPUT MENU -->
<ul class="nav nav-pills nav-justified flex-column flex-sm-row nav-gray project-menu" id="local-menu">       
        <li class="nav-item">
            <?= $this->Html->link('Info', [                
                'controller' => 'input',
                'action' => 'info'], [
                    'class' => 'nav-link',
                    'id' => 'info']); ?>            
        </li>        
        <li class="nav-item">
            <?= $this->Html->link('Load Data', [                
                'controller' => 'input',
                'action' => 'load-data'], [
                    'class' => 'nav-link',
                    'id' => 'load-data']); ?>            
        </li>        
        <?php if (isset($hasInputData) && $hasInputData) { ?>
        <li class="nav-item">
            <?= $this->Html->link('Graphical View', [
                'controller' => 'input',
                'action' => 'graph'], [
                    'class' => 'nav-link',
                    'id' => 'graph']); ?>            
        </li>
        <li class="nav-item">
            <?= $this->Html->link('Table View', [  
                'controller' => 'input',              
                'action' => 'table'], [
                    'class' => 'nav-link',
                    'id' => 'table']); ?>            
        </li>        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Export Input Data</a>
            <div class="dropdown-menu">   
                <?= $this->Html->link('Daily', [
                'controller' => 'input',
                'action' => 'export-daily'], [
                    'class' => 'dropdown-item']); ?>     
                    
                <?= $this->Html->link('Monthly', [
                'controller' => 'input',
                'action' => 'export-monthly'], [
                    'class' => 'dropdown-item']); ?> 

                <?= $this->Html->link('Seasons', [
                'controller' => 'input',
                'action' => 'export-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Growing Season', [
                'controller' => 'input',
                'action' => 'export-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
            }   
            ?> 

                 <?= $this->Html->link('Yearly', [
                'controller' => 'input',
                'action' => 'export-yearly'], [
                    'class' => 'dropdown-item']); ?>
                
                <hr/>        
                <?= $this->Html->link('Typical Year Daily', [
                'controller' => 'input',
                'action' => 'export-typical-daily'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Monthly', [
                'controller' => 'input',
                'action' => 'export-typical-monthly'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Seasons', [
                'controller' => 'input',
                'action' => 'export-typical-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Typical Year Growing Season', [
                'controller' => 'input',
                'action' => 'export-typical-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
            }   
            ?>               
                <?= $this->Html->link('Typical Year Average', [
                'controller' => 'input',
                'action' => 'export-typical-year'], [
                    'class' => 'dropdown-item']); ?>              
                <hr/>
                <?= $this->Html->link('Export Statistics', [
                'controller' => 'input',
                'action' => 'export-statistics'], [
                    'class' => 'dropdown-item']); ?>     
                <hr/>
                <?= $this->Html->link('Export Global Configuration', [
                'controller' => 'input',
                'action' => 'export-metadata'], [
                    'class' => 'dropdown-item']); ?>  
            </div>
        </li>  
        <?php } ?>
             
        <!-- <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>                   -->
    </ul>
<?php $this->end(); ?>

<?php $this->start('snow_menu'); ?>
<!-- SNOW MENU -->
<ul class="nav nav-pills nav-justified flex-column flex-sm-row nav-gray project-menu" id="local-menu">       
        <li class="nav-item">
            <?= $this->Html->link('Info', [                
                'controller' => 'snow',
                'action' => 'info'], [
                    'class' => 'nav-link',
                    'id' => 'info']); ?>            
        </li>        
        <li class="nav-item">
            <?= $this->Html->link('Analysis', [                
                'controller' => 'snow',
                'action' => 'analysis'], [
                    'class' => 'nav-link',
                    'id' => 'analysis']); ?>            
        </li>        
        <?php if (isset($hasSnowData) && $hasSnowData) { ?>
        <li class="nav-item">
            <?= $this->Html->link('Graphical View', [
                'controller' => 'snow',
                'action' => 'graph'], [
                    'class' => 'nav-link',
                    'id' => 'graph']); ?>            
        </li>
        <li class="nav-item">
            <?= $this->Html->link('Table View', [  
                'controller' => 'snow',              
                'action' => 'table'], [
                    'class' => 'nav-link',
                    'id' => 'table']); ?>            
        </li>                
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Export Snow Data</a>
            <div class="dropdown-menu">   
                <?= $this->Html->link('Daily', [
                'controller' => 'snow',
                'action' => 'export-daily'], [
                    'class' => 'dropdown-item']); ?>     
                    
                <?= $this->Html->link('Monthly', [
                'controller' => 'snow',
                'action' => 'export-monthly'], [
                    'class' => 'dropdown-item']); ?> 

                <?= $this->Html->link('Seasons', [
                'controller' => 'snow',
                'action' => 'export-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Growing Season', [
                'controller' => 'snow',
                'action' => 'export-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
            }   
            ?> 

                 <?= $this->Html->link('Yearly', [
                'controller' => 'snow',
                'action' => 'export-yearly'], [
                    'class' => 'dropdown-item']); ?>
                
                <hr/>        
                <?= $this->Html->link('Typical Year Daily', [
                'controller' => 'snow',
                'action' => 'export-typical-daily'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Monthly', [
                'controller' => 'snow',
                'action' => 'export-typical-monthly'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Seasons', [
                'controller' => 'snow',
                'action' => 'export-typical-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Typical Year Growing Season', [
                'controller' => 'snow',
                'action' => 'export-typical-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
            }   
            ?>               
                <?= $this->Html->link('Typical Year Average', [
                'controller' => 'snow',
                'action' => 'export-typical-year'], [
                    'class' => 'dropdown-item']); ?>              
                <hr/>
                <?= $this->Html->link('Export Statistics', [
                'controller' => 'snow',
                'action' => 'export-statistics'], [
                    'class' => 'dropdown-item']); ?>   
                <hr/>
                <?= $this->Html->link('Export Snow Configuration', [
                'controller' => 'snow',
                'action' => 'export-config'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Export Global Configuration', [
                'controller' => 'input',
                'action' => 'export-metadata'], [
                    'class' => 'dropdown-item']); ?>                           
            </div>
        </li> 
        <?php } ?>  
           
        <!-- <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>                   -->
    </ul>
<?php $this->end(); ?>

<?php $this->start('soil_menu'); ?>
<!-- SOIL WATER MENU -->
<ul class="nav nav-pills nav-justified flex-column flex-sm-row nav-gray project-menu" id="local-menu">
        <li class="nav-item">
            <?= $this->Html->link('Info', [
                'controller' => 'soil',
                'action' => 'info'], [
                    'class' => 'nav-link',
                    'id' => 'info']); ?>            
        </li>                
        <li class="nav-item">
            <?= $this->Html->link('Analysis', [  
                'controller' => 'soil',              
                'action' => 'analysis'], [
                    'class' => 'nav-link',
                    'id' => 'analysis']); ?>            
        </li>        
        <?php if (isset($hasSoilData) && $hasSoilData) { ?>
        <li class="nav-item">
            <?= $this->Html->link('Graphical View', [
                'controller' => 'soil',
                'action' => 'graph'], [
                    'class' => 'nav-link',
                    'id' => 'graph']); ?>            
        </li>
        <li class="nav-item">
            <?= $this->Html->link('Table View', [
                'controller' => 'soil',
                'action' => 'table'], [
                    'class' => 'nav-link',
                    'id' => 'table']); ?>            
        </li>                
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Export Water Balance Data</a>
            <div class="dropdown-menu">   
                <?= $this->Html->link('Daily', [
                'controller' => 'soil',
                'action' => 'export-daily'], [
                    'class' => 'dropdown-item']); ?>     
                    
                <?= $this->Html->link('Monthly', [
                'controller' => 'soil',
                'action' => 'export-monthly'], [
                    'class' => 'dropdown-item']); ?> 

                <?= $this->Html->link('Seasons', [
                'controller' => 'soil',
                'action' => 'export-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Growing Season', [
                'controller' => 'soil',
                'action' => 'export-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                
            <?php
            }   
            ?> 

                 <?= $this->Html->link('Yearly', [
                'controller' => 'soil',
                'action' => 'export-yearly'], [
                    'class' => 'dropdown-item']); ?>
                
                <hr/>        
                <?= $this->Html->link('Typical Year Daily', [
                'controller' => 'soil',
                'action' => 'export-typical-daily'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Monthly', [
                'controller' => 'soil',
                'action' => 'export-typical-monthly'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Typical Year Seasons', [
                'controller' => 'soil',
                'action' => 'export-typical-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
                if ($this->isSetGrowthSeason->getFlag()){        
            ?>
                <?= $this->Html->link('Typical Year Growing Season', [
                'controller' => 'soil',
                'action' => 'export-typical-growing-seasons'], [
                    'class' => 'dropdown-item']); ?>                 
            <?php
            }   
            ?>               
                <?= $this->Html->link('Typical Year Average', [
                'controller' => 'soil',
                'action' => 'export-typical-year'], [
                    'class' => 'dropdown-item']); ?>              
                <hr/>
                <?= $this->Html->link('Export Statistics', [
                'controller' => 'soil',
                'action' => 'export-statistics'], [
                    'class' => 'dropdown-item']); ?>      
                <hr/>                
                <?= $this->Html->link('Export Water Balance Configuration', [
                'controller' => 'soil',
                'action' => 'export-config'], [
                    'class' => 'dropdown-item']); ?>
                <?= $this->Html->link('Export Global Configuration', [
                'controller' => 'input',
                'action' => 'export-metadata'], [
                    'class' => 'dropdown-item']); ?>
            </div>
        </li>     
        <?php } ?>
          
        <!-- <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>                   -->
    </ul>
<?php $this->end(); ?>