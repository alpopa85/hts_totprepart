<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SNOW BUDDY">
    <title>        
        <?= $title ? $title : $this->fetch('title') ?>
    </title>

    <!-- ICONS -->
    <?= $this->Html->meta(
        'favicon.ico',
        '/favicon.ico',
        ['type' => 'icon']
    ); ?>
    <?= $this->Html->meta(
        'apple-touch-icon',
        '/apple-touch-icon.png',
        ['type' => 'icon']
    ); ?>
    <?= $this->Html->meta(
        'icon',
        '/favicon-32x32.png',
        ['type' => 'image/png', 'sizes' => '32x32']
    ); ?>
    <?= $this->Html->meta(
        'icon',
        '/favicon-16x16.png',
        ['type' => 'image/png', 'sizes' => '16x16']
    ); ?> 
    <?= $this->Html->meta([
        'link' => '/site.webmanifest',
        'rel' => 'manifest'
    ]); ?>
        
    <?php /*echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', [
        'integrity' => 'sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l',
        'crossorigin' => 'anonymous'
    ]); */?>
    <?= $this->Html->css('../external/bootstrap_4.6.0/bootstrap.min.css') ?>

    <?php /*echo $this->Html->css('https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-html5-1.6.5/datatables.min.css');*/?>
    <?= $this->Html->css('../external/datatables_1.6.5/datatables.min.css') ?>

    <?php /*echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css');*/?>
    <?= $this->Html->css('../external/bootstrap_datepicker_3/bootstrap-datepicker3.css') ?>

    <?php /*echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.css')*/?>
    <?= $this->Html->css('../external/bootstrap_switch/bootstrap-switch.css') ?>

    <?= $this->Html->css('bootstrap-slider.min.css') ?>
    <?= $this->Html->css('project.css') ?>
    <?= $this->Html->css('/font-awesome-4.7.0/css/font-awesome.min.css') ?>

    <?php /*echo $this->Html->script('https://code.jquery.com/jquery-3.5.1.min.js');*/?>
    <?= $this->Html->script('jquery-3.5.1.min.js');?>

    <?php /*echo $this->Html->script('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [
        'integrity' => 'sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN',
        'crossorigin' => 'anonymous'
    ]);*/?>
    <?= $this->Html->script('popper.min.js', ['defer', 'crossorigin' => 'anonymous']);?>

    <?php /*echo $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js', [
        'integrity' => 'sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF',
        'crossorigin' => 'anonymous'
    ]);*/?>
    <?= $this->Html->script('bootstrap.min.js', ['defer', 'crossorigin' => 'anonymous']);?>

    <?php /*echo $this->Html->script('https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js');*/?>
    <?= $this->Html->script('bs-custom-file-input.min.js', ['defer']);?>

    <?php /*echo $this->Html->script('https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-html5-1.6.5/datatables.min.js');*/?>
    <?= $this->Html->script('datatables.min.js', ['defer']);?>

    <?php /* <?= $this->Html->script('dataTables.fixedHeader.min.js', ['defer']);?> */ ?>

    <?php /*echo $this->Html->script('https://kit.fontawesome.com/ff0983eaec.js', [
        'crossorigin' => 'anonymous'
    ]);*/?>
    <?= $this->Html->script('ff0983eaec.js', ['defer', 'crossorigin' => 'anonymous']);?>

    <?php /*echo $this->Html->script('https://cdn.plot.ly/plotly-latest.min.js', ['defer', 'block' => 'graphScript']);*/?>
    <?php echo $this->Html->script('plotly-latest.min.js', ['defer', 'block' => 'graphScript']); ?>

    <?php /*echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js');*/?>
    <?= $this->Html->script('bootstrap-datepicker.min.js', ['defer']);?>

    <?php /*echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js');*/?>
    <?= $this->Html->script('bootstrap-switch.min.js', ['defer']);?>

    <?php echo $this->Html->script('bootstrap-slider.min.js', ['defer']); ?>    
    <?php echo $this->Html->script('googleMap.js', [
        'crossorigin' => 'anonymous',
        'block' => 'googleMapScript'
    ]); ?>  

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>   
    
    <?= $this->element('menu') ?>
    <?= $this->element('modal') ?>

    <!-- POSITIVE SSL STUFF -->
    <script type="text/javascript"> //<![CDATA[
    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
    document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
    //]]></script>
    <!-- END OF POSITIVE SSL STUFF -->  
</head>
<body>    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <?= $this->Html->link(
            $this->Html->image('hts_logo_2.png', array('height' => '45', 'width' => 'auto', 'alt' => 'HTS')), 
            'https://portal.hydrotools.tech', [
            'class' => 'navbar-brand',
            'target' => '_blank',
            'title' => 'Go to HTS Portal',
            'escape' => false]); ?>                        

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav">                                
                <?= $this->Html->link('Home', [
                    'controller' => 'main',
                    'action' => 'index'], [
                        'class' => 'nav-link',
                        'id' => 'main']); ?>  
                <?= $this->Html->link('Input Data', [
                    'controller' => 'input',
                    'action' => 'index'], [
                        'class' => 'nav-link disabled',
                        'id' => 'input']); ?>  
                <!-- <?= (isset($ucdFields) && $ucdFields['total']) ? $this->Html->link('UCD', "#ucd", [
                    'class' => ['nav-link', 'orange-ucd'],
                    'id' => 'reset-ucd',
                    'data-toggle' => 'modal',
                    'data-target' => '#ucdModalReset']) : ''; ?>     
                <?= $this->Html->link('Snow', [
                    'controller' => 'snow',
                    'action' => 'index'], [
                        'class' => 'nav-link',
                        'id' => 'snow']);?>                           
                <?= $this->Html->link('Water Balance', [
                    'controller' => 'soil',
                    'action' => 'index'], [
                        'class' => 'nav-link',
                        'id' => 'soil_water']); ?>                              -->
                <?= $inputDataFlag ? $this->Html->link('Reset Data', "#reset", [
                    'class' => ['nav-link', 'red-reset'],
                    'id' => 'reset-data',
                    'data-toggle' => 'modal',
                    'data-target' => '#resetModal']) : ''; ?> 
                <div class="float-right" style="margin-left:20px">
                    <?= $this->Html->link('<i class="fa fa-lock" style="font-size:10px" aria-hidden="true"></i>', '#admin', [
                        'class' => 'nav-link',
                        'id' => 'open-admin',
                        'data-toggle' => 'modal',
                        'data-target' => '#adminModal',
                        'escape' => false]); ?>
                </div>
            </div>
        </div>

        <?= $this->Html->link(
            $this->Html->image('hts_logo_2.png', array('height' => '45', 'width' => 'auto', 'alt' => 'SNOW BUDDY')),
            ['controller' => 'main', 
            'action' => 'index'], [
            'class' => 'navbar-brand',
            'title' => ($version ? 'v' . $version : ''),
            'escape' => false]); ?>       
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>                
    
    <?php 
        switch (strtoupper($this->request->getParam('controller'))){
            case 'INPUT':
                echo $this->fetch('input_menu');
                break;
            case 'SNOW':
                echo $this->fetch('snow_menu');
                break;
            case 'SOIL':
                echo $this->fetch('soil_menu');
                break;
            // case 'BALANCE':
            //     echo $this->fetch('balance_menu');
            //     break;                           
        }
    ?>    

    <div class="container-fluid pb-5 px-5">
        <?= $this->fetch('content') ?>
    </div>    

    <div id="mySpinnerContainer" class="spinner-container" style="display:none">
        <div class="d-flex justify-content-center align-items-center" style="height:100%">
            <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                <span class="sr-only">Processing...</span>
            </div>
            <span class="pl-3"><h4>Processing...</h4></span>
        </div>
    </div>

    <div id="notification-message">
        <?= $this->Flash->render() ?>
    </div>

    <?= $this->fetch('reset_modal'); ?>
    <?= $this->fetch('admin_modal'); ?>
    <?= $this->fetch('reset_db_modal'); ?>  
    <?= $this->fetch('ucd_reset_modal'); ?>  

    <?php
        // // only load ucd_modal for load-data
        if (strcmp(strtoupper($this->request->getParam('action')), 'LOADDATA') == 0) { 
            echo $this->fetch('ucd_modal');
        }

        // only load analysis modals for analysis
        if (strcmp(strtoupper($this->request->getParam('action')), 'ANALYSIS') == 0) {            
            if (strcmp(strtoupper($this->request->getParam('controller')), 'SNOW') == 0) {
                echo $this->fetch('snow_analysis_modal');
            }

            if (strcmp(strtoupper($this->request->getParam('controller')), 'SOIL') == 0) {
                echo $this->fetch('soil_analysis_modal');
            }
        }                  

        // only load plotly for graph & analysis scripts
        switch (strtoupper($this->request->getParam('action'))){
            case 'GRAPH':
            case 'ANALYSIS':
                echo $this->fetch('graphScript');
                break;
        }

        // only load googlemap.js for admin
        switch (strtoupper($this->request->getParam('controller'))){
            case 'ADMIN':
                echo $this->fetch('googleMapScript');
                break;
        }
    ?>

    <footer class="fixed-bottom">        
        <div class="positive-ssl-logo">
            <script language="JavaScript" type="text/javascript">
            TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_sm_124x32.png", "POSDV", "none");
            </script>
        </div>
    </footer>

    <script>
        $(document).ready(function(){    
            // navbar stuff
            var activeNavbarId = '<?= isset($activeNavbarId) ? $activeNavbarId : "" ?>';
            $(".navbar > .nav-link").removeClass("active");
            if (activeNavbarId){
                $("#" + activeNavbarId).addClass("active");
            }            

            // module menu stuff
            var activeMenuNavId = '<?= isset($activeMenuNavId) ? $activeMenuNavId : "" ?>';
            $("#local-menu > .nav-link").removeClass("active");
            if (activeMenuNavId){                
                $("#" + activeMenuNavId).addClass("active");
            }    

            // tooltips stuff
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>            

</body>
</html>
