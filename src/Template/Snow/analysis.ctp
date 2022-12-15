<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">   
        <form method="post" id="uploadParamsForm" action="upload-param-file" enctype="multipart/form-data">                            
            <div id="upload_param_input_group" class="input-group mb-3 form-red-border">           
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="filename" name="inputDataFile" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="fileHelp">Choose configuration file</label>
                </div>
            </div>                                      

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name ="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
            <!-- END OF CAKE FORM FIELDS !-->
            
            <div class="row text-center">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary" style="min-width:66%">Import Configuration File</button>                    
                </div>

                <div class="col-6">
                    <?= $this->Html->link('Export Configuration File', [
                    'controller' => 'snow',
                    'action' => 'export-config'], [
                        'class' => 'btn btn-secondary',
                        'style' => 'min-width:66%']); ?>
                </div>                
            </div>        
        </form>  
    </div>
</div>

<div class="my-5 row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <form id="analysisForm" method="post" action="perform-analysis">

            <div id="accordion">
                <div class="card active">
                    <div class="card-header myAccordionHeader" id="headingOne">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-flex justify-content-between" type="button">
                                <span>Precipitation (mm) to Snowfall (mm) conversion factor based on temperature</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group" id="precip-to-snow-group">
                                <div class="row">                                    
                                    <div class="col col-3 offset-2">
                                        <span data-toggle="tooltip" title="<?= $tooltips['PRECIP_TO_SNOW'] ?>">T lower bound</span>
                                    </div>

                                    <div class="col col-3">
                                        <span data-toggle="tooltip" title="<?= $tooltips['PRECIP_TO_SNOW'] ?>">T upper bound</span>
                                    </div>

                                    <div class="col col-4">
                                        <span data-toggle="tooltip" title="<?= $tooltips['PRECIP_TO_SNOW'] ?>">Conversion factor</span>                                        
                                    </div>
                                </div>

                                <?php for($i=0; $i<$paramData['precipToSnow_count']; $i++) { ?>
                                <div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <?php if ($i==0) { ?>
                                        <button type="button" class="btn btn-success add-precip-to-snow-row" data-toggle="tooltip" title="Add interval"><i class="fas fa-plus"></i></button>
                                        <?php } else { ?>
                                        <button type="button" class="btn btn-danger rm-precip-to-snow-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                        <?php } ?>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. -25" name="precipToSnow_lt[]" value="<?= $paramData['precipToSnow_lt_' . $i] ?>">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 5" name="precipToSnow_ht[]" value="<?= $paramData['precipToSnow_ht_' . $i] ?>">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="precipToSnow_factor[]" value="<?= $paramData['precipToSnow_factor_' . $i] ?>">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['PRECIP_TO_SNOW_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>  
                                <?php } ?>                                                      
                            </div>            
                            
                            <div class="row mt-4">
                                <div class="col col-11 offset-1 alert-warning">
                                    <span>* Data points not covered by any interval will have a conversion factor of 0.</span>
                                </div>                                    
                            </div>
                            
                            <div class="row mt-4" id="overlapError1" style="display:none">
                                <div class="col col-11 offset-1 alert-danger text-center">
                                    <h4>Fix the intervals before running the analysis:</h4><br/>
                                    <h5>- the intervals must be numeric<br/>
                                    - the intervals must not overlap<br/>
                                    - the lower bound must be smaller than the higher bound<br/>                                    
                                    - the conversion factor must be between 0 and 100</h5>
                                </div>                                    
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingTwo">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-flex justify-content-between collapsed" type="button">
                                <span>Snowfall conversion factor (mm to cm) based on temperature</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">   
                            <div class="form-group" id="snow-mm-to-cm-group">
                                <div class="row">                                    
                                    <div class="col col-3 offset-2">
                                        <span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM_TO_CM'] ?>">T lower bound</span>
                                    </div>

                                    <div class="col col-3">
                                        <span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM_TO_CM'] ?>">T upper bound</span>
                                    </div>

                                    <div class="col col-4">
                                        <span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM_TO_CM'] ?>">Conversion factor</span>                                        
                                    </div>
                                </div>

                                <?php for($i=0; $i<$paramData['snowMmToCm_count']; $i++) { ?>
                                <div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <?php if ($i==0) { ?>
                                            <button type="button" class="btn btn-success add-snow-mm-to-cm-row" data-toggle="tooltip" title="Add interval"><i class="fas fa-plus"></i></button>
                                        <?php } else { ?>
                                        <button type="button" class="btn btn-danger rm-snow-mm-to-cm-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                        <?php } ?>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. -25" name="snowMmToCm_lt[]" value="<?= $paramData['snowMmToCm_lt_' . $i] ?>">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 5" name="snowMmToCm_ht[]" value="<?= $paramData['snowMmToCm_ht_' . $i] ?>">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="snowMmToCm_factor[]" value="<?= $paramData['snowMmToCm_factor_' . $i] ?>">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SNOW_MM_TO_CM_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>                                   
                                <?php } ?>                                                                  
                            </div>     

                            <div class="row mt-4">
                                <div class="col col-11 offset-1 alert-warning">
                                    <span>* Data points not covered by any interval will have a conversion factor of 0.</span>
                                </div>                                    
                            </div>
                            
                            <div class="row mt-4" id="overlapError2" style="display:none">
                                <div class="col col-11 offset-1 alert-danger text-center">
                                    <h4>Fix the intervals before running the analysis:</h4><br/>
                                    <h5>- the intervals must be numeric<br/>
                                    - the intervals must not overlap<br/>
                                    - the lower bound must be smaller than the higher bound<br/>                                    
                                    - the conversion factor must be between 0 and 10</h5>
                                </div>                                    
                            </div>  
                        </div>                                                                   
                    </div>
                </div>  

                <?php if ($nValidationColumns) { ?>
                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingUcd">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseUcd" aria-expanded="false" aria-controls="collapseUcd" class="d-flex justify-content-between collapsed" type="button">
                                <span>Calibration mapping</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>
                    
                    <div id="collapseUcd" class="collapse" aria-labelledby="headingUcd" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table table-borderless table-sm px-5 graph-params">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Model Output</th>
                                        <th scope="col" class="text-center">Calibration Data</th>
                                    </tr>
                                <tbody>                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output1_select" name="output1_select" placeholder="Model Output...">
                                                <option value="snow_mm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOW_MM</option>
                                                <option value="snow_cm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_cm') == 0) ? 'selected' : ''?>>SNOW_CM</option>
                                                <option value="rain_mm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rain_mm') == 0) ? 'selected' : ''?>>RAIN_MM</option>                                                
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd1_select" name="ucd1_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd1_field']) && strcmp($calibration['ucd1_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>   
                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output2_select" name="output2_select" placeholder="Model Output...">
                                                <option value="snow_mm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOW_MM</option>
                                                <option value="snow_cm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_cm') == 0) ? 'selected' : ''?>>SNOW_CM</option>
                                                <option value="rain_mm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rain_mm') == 0) ? 'selected' : ''?>>RAIN_MM</option>                                                    
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd2_select" name="ucd2_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd2_field']) && strcmp($calibration['ucd2_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>                
                <?php } ?>
            </div>                         
                       
            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="mt-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" id="validateButton" class="btn btn-primary">Validate</button>
                        </div>

                        <div class="col text-left">
                            <button type="submit" class="btn btn-success">Run Analysis</button>            
                        </div>
                    </div>
                </div>                                
            </div>  
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e"></script>
<script type="module">
    //import {getCookie} from "../js/project.js";     
    
    var precipToSnowRowTemplate = `<div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <button type="button" class="btn btn-danger rm-precip-to-snow-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. -25" name="precipToSnow_lt[]">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 5" name="precipToSnow_ht[]">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="precipToSnow_factor[]">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['PRECIP_TO_SNOW_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>`; 

    var snowMmToCmRowTemplate = `<div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <button type="button" class="btn btn-danger rm-snow-mm-to-cm-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. -25" name="snowMmToCm_lt[]">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 5" name="snowMmToCm_ht[]">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="snowMmToCm_factor[]">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SNOW_MM_TO_CM_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>`;

    function validateConfigFileForm() {
        if (!$('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', true);
            $('#uploadParamsForm').find(':input[type=submit]').addClass('disabled');
        } else {
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', false);
            $('#uploadParamsForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    function validateParams() {
        var validPrecipToSnow = true;
        var validSnowMmToCm = true;

        // precipToSnow
        var lowBoundaryPrecipToSnow = [];        
        $('#analysisForm').find(':input[name="precipToSnow_lt[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validPrecipToSnow = false;
            }
            lowBoundaryPrecipToSnow.push(parseFloat(elem.value));
        }); 
        lowBoundaryPrecipToSnow.sort(function(a,b) {
            return(a - b);
        });
        // console.log('lowBoundary', lowBoundary);  

        var highBoundaryPrecipToSnow = [];
        $('#analysisForm').find(':input[name="precipToSnow_ht[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validPrecipToSnow = false;
            }
            highBoundaryPrecipToSnow.push(parseFloat(elem.value));
        });
        highBoundaryPrecipToSnow.sort(function(a,b) {
            return(a - b);
        });         
        // console.log('highBoundary', highBoundary); 

        $('#analysisForm').find(':input[name="precipToSnow_factor[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validPrecipToSnow = false;
            } else {
                if (elem.value < 0) {
                    elem.value = 0;
                }

                if (elem.value > 100) {
                    elem.value = 100;
                }
            }            
        });

        for (var i=0; i<lowBoundaryPrecipToSnow.length; i++) {
            if (lowBoundaryPrecipToSnow[i] >= highBoundaryPrecipToSnow[i]) {
                console.log('incorrect boundary condition precipToSnow', lowBoundaryPrecipToSnow[i] + ' vs ' + highBoundaryPrecipToSnow[i]);
                validPrecipToSnow = false;
            }
            
            if (i>0 && lowBoundaryPrecipToSnow[i] < highBoundaryPrecipToSnow[i-1]) {
                console.log('overlapped interval precipToSnow');
                validPrecipToSnow = false;
            }
        }

        // snowMmToCm
        var lowBoundarySnowMmToCm = [];        
        $('#analysisForm').find(':input[name="snowMmToCm_lt[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validSnowMmToCm = false;
            }
            lowBoundarySnowMmToCm.push(parseFloat(elem.value));
        }); 
        lowBoundarySnowMmToCm.sort(function(a,b) {
            return(a - b);
        });
        // console.log('lowBoundary', lowBoundary);  

        var highBoundarySnowMmToCm = [];
        $('#analysisForm').find(':input[name="snowMmToCm_ht[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validSnowMmToCm = false;
            }
            highBoundarySnowMmToCm.push(parseFloat(elem.value));
        });
        highBoundarySnowMmToCm.sort(function(a,b) {
            return(a - b);
        });         
        // console.log('highBoundary', highBoundary); 

        $('#analysisForm').find(':input[name="snowMmToCm_factor[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                validSnowMmToCm = false;
            } else {
                if (elem.value < 0) {
                    elem.value = 0;
                }

                if (elem.value > 10) {
                    elem.value = 10;
                }
            }            
        });

        for (var i=0; i<lowBoundarySnowMmToCm.length; i++) {
            if (lowBoundarySnowMmToCm[i] >= highBoundarySnowMmToCm[i]) {
                console.log('incorrect boundary condition snowMmToCm', lowBoundarySnowMmToCm[i] + ' vs ' + highBoundarySnowMmToCm[i]);
                validSnowMmToCm = false;
            }
            
            if (i>0 && lowBoundarySnowMmToCm[i] < highBoundarySnowMmToCm[i-1]) {
                console.log('overlapped interval snowMmToCm');
                validSnowMmToCm = false;
            }
        }

        if (validPrecipToSnow) {
            $("#overlapError1").hide();
        } else {
            $("#overlapError1").show();
        }

        if (validSnowMmToCm) {
            $("#overlapError2").hide();
        } else {
            $("#overlapError2").show();
        }

        if (validPrecipToSnow && validSnowMmToCm) {
            $('#validateButton').prop('disabled', true);
            $('#validateButton').addClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
            $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
        } else {
            $("#overlapError").show();

            $('#validateButton').prop('disabled', false);
            $('#validateButton').removeClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
            $('#analysisForm').find(':input[type=submit]').addClass('disabled');
        }
    }

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        validateConfigFileForm();
        validateParams();       

        $('.add-precip-to-snow-row').click(function(e) {
            // console.log(e.currentTarget.parentElement.parentElement);  
            $('#precip-to-snow-group').append(precipToSnowRowTemplate);
            validateParams();
        });

        $('#precip-to-snow-group').on('click', '.rm-precip-to-snow-row', function(e) {
            // console.log(e.currentTarget.parentElement);  
            e.currentTarget.parentElement.parentElement.remove();

            // also remove tooltips
                let tooltips = $('body > .tooltip');
                if (tooltips.length === 0) {
                    // no tooltips
                    return;
                }
                
                // Loop through tooltips
                tooltips.each((i,tooltip) => {
                    // Do tooltip has its initiator?
                    if ($(`[aria-describedby="${tooltip.id}"]`).length === 0) {
                        // No. It is dead tooltip, remove it.
                        tooltip.remove();
                    }
                });

            validateParams();
        });        

        $('.add-snow-mm-to-cm-row').click(function(e) {
            // console.log(e.currentTarget.parentElement.parentElement);  
            $('#snow-mm-to-cm-group').append(snowMmToCmRowTemplate);
            validateParams();
        });

        $('#snow-mm-to-cm-group').on('click', '.rm-snow-mm-to-cm-row', function(e) {
            // console.log(e.currentTarget.parentElement);  
            e.currentTarget.parentElement.parentElement.remove();

            // also remove tooltips
                let tooltips = $('body > .tooltip');
                if (tooltips.length === 0) {
                    // no tooltips
                    return;
                }
                
                // Loop through tooltips
                tooltips.each((i,tooltip) => {
                    // Do tooltip has its initiator?
                    if ($(`[aria-describedby="${tooltip.id}"]`).length === 0) {
                        // No. It is dead tooltip, remove it.
                        tooltip.remove();
                    }
                });

            validateParams();
        });  

        $('#analysisForm').on('change', ':input', function(e) {
            $('#validateButton').prop('disabled', false);
            $('#validateButton').removeClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
            $('#analysisForm').find(':input[type=submit]').addClass('disabled');

            validateParams();
        });        
             
        $('#uploadParamsForm').find(':input[name=inputDataFile]').change(function(){     
            // alert($('#uploadParamsForm').find(':input[name=inputDataFile]').val());
            if ($('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
                $("#upload_param_input_group").removeClass("form-red-border");        
                $("#upload_param_input_group").addClass("form-green-border");        
            } else {
                $("#upload_param_input_group").removeClass("form-green-border");        
                $("#upload_param_input_group").addClass("form-red-border");  
            }
            
            validateConfigFileForm();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });       

        $("#uploadParamsForm").submit(async function(e){
            $("#mySpinnerContainer").show();

            e.preventDefault();   
            var actionUrl = e.target.action;                      
                   
            var redirectUrl = "<?= $this->Url->build([
                'controller' => 'snow',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to function that tells me how many UCD fields
            async function uploadFile(recaptchaToken) {
                let formData = new FormData($("#uploadParamsForm")[0]);
                formData.append('token', recaptchaToken);
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };

            // console.log('pre recaptcha');
            let recaptchaToken = null;
            async function recaptchaRequest() {
                return new Promise((resolve, reject) => {
                        grecaptcha.ready(function() {
                        grecaptcha.execute('6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e', {action: 'submit'}).then(function(token) {
                            // console.log('received token ' + token);
                            recaptchaToken = token;
                            resolve();
                        });
                    });
                });
            };

            await recaptchaRequest();
            // console.log('post recaptcha');
            
            let result = await uploadFile(recaptchaToken).then(function(data){                
                window.location.href = redirectUrl;
            }).catch(function(){                
                window.location.href = redirectUrl;
            });       
        }); 

        $("#analysisForm").submit(async function(e){
            e.preventDefault();   

            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');

            if ($("#output1_select").val() == undefined) { // no validation data
                $(".modal-body").hide();
            }

            $("#snowAnalysisModal").modal({
                backdrop: 'static'
            });
            
            var actionUrl = e.target.action;                      
                    
            var redirectUrlError = "<?= $this->Url->build([
                'controller' => 'snow',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to run analysis
            async function runAnalysis() {
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: new FormData($("#analysisForm")[0]),
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };
            
            let result = await runAnalysis().then(function(response){                
                if (response.success) {
                    // console.log('SUCCESS');
                    $("#cancel-sn-analysis").hide(); // this is found in the analysis modal
                    $("#return-sn-analysis").show(); // this is found in the analysis modal
                    $("#complete-sn-analysis").show(); // this is found in the analysis modal
                    $("#calibTypeMenu").show();
                    $("#analysisCompletionRate").html('COMPLETED');
                } else {
                    // alert('Error ' + JSON.stringify(data));
                    if (response.has_error) {
                        window.location.href = redirectUrlError;
                    }
                    
                    if (response.user_stopped) {
                        console.log('USER STOPPED');
                        $("#cancel-sn-analysis").hide(); // this is found in the analysis modal
                        $("#return-sn-analysis").show(); // this is found in the analysis modal
                    }
                }                
            }).catch(function(){
                // alert('Error');
                window.location.href = redirectUrlError;
            });       
        }); 
    });
</script>