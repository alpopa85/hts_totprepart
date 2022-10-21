<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">   
        <form method="post" id="uploadParamsForm" action="upload-param-file" enctype="multipart/form-data">                            
            <div id="upload_param_input_group" class="input-group mb-3 form-red-border">           
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="filename" name="inputDataFile" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="fileHelp">Upload configuration file</label>
                </div>
            </div>                                      

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name ="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
            <!-- END OF CAKE FORM FIELDS !-->
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Upload Parameter Data</button>                    
            </div>        
        </form>  
    </div>
</div>

<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <form id="analysisForm" method="post" action="perform-analysis">

            <div id="accordion">
                <div class="card active">
                    <div class="card-header myAccordionHeader" id="headingOne">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-flex justify-content-between" type="button">
                                <span>Starting values</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param6-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['SNWTinit'] ?>">SNWTinit (cm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SNWTinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param6" aria-describedby="param6-addon" name="snwt_init" value="<?= !empty($paramData['snwt_init']) ? $paramData['snwt_init'] : 25.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param7-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['SNWMinit'] ?>">SNWMinit (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SNWMinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param7" aria-describedby="param7-addon" name="snwm_init" value="<?= !empty($paramData['snwm_init']) ? $paramData['snwm_init'] : 0.0; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingTwo">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-flex justify-content-between collapsed" type="button">
                                <span>Coefficients</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param0-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRrs'] ?>">THRrs (&deg;C)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRrs_val'] ?>"></i>
                                            </div>                            
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="-20 to 10" aria-label="Param0" aria-describedby="param0-addon" name="thr_rs" value="<?= !empty($paramData['thr_rs']) ? $paramData['thr_rs'] : -2.50; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param1-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRsm'] ?>">THRsm (&deg;C)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRsm_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="-20 to 10" aria-label="Param1" aria-describedby="param1-addon" name="thr_sm" value="<?= !empty($paramData['thr_sm']) ? $paramData['thr_sm'] : 0.50; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param2-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFTsm'] ?>">CFTsm (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFTsm_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param2" aria-describedby="param2-addon" name="cft_sm" value="<?= !empty($paramData['cft_sm']) ? $paramData['cft_sm'] : 3.20; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param3-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFRsm'] ?>">CFRsm (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFRsm_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param3" aria-describedby="param3-addon" name="cfp_sm" value="<?= !empty($paramData['cfp_sm']) ? $paramData['cfp_sm'] : 1.50; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param4-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFSmc'] ?>">CFSmc</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFSmc_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param4" aria-describedby="param4-addon" name="cfs_mc" value="<?= !empty($paramData['cfs_mc']) ? $paramData['cfs_mc'] : 0.72; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param5-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFets'] ?>">CFets</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFets_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param5" aria-describedby="param5-addon" name="cf_ets" value="<?= !empty($paramData['cf_ets']) ? $paramData['cf_ets'] : 0.80; ?>">
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
                                                <option value="snow_mm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOF</option>
                                                <option value="rains" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rains') == 0) ? 'selected' : ''?>>RAINS</option>
                                                <option value="rainns" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rainns') == 0) ? 'selected' : ''?>>RAINNS</option>
                                                <option value="snoa" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snoa') == 0) ? 'selected' : ''?>>SNOA</option>
                                                <option value="snom" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snom') == 0) ? 'selected' : ''?>>SNOM</option>
                                                <option value="rssl" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rssl') == 0) ? 'selected' : ''?>>RSSL</option>
                                                <option value="rsi" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rsi') == 0) ? 'selected' : ''?>>RSI</option>
                                                <option value="tdsm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'tdsm') == 0) ? 'selected' : ''?>>SNMT</option>
                                                <option value="rdsm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'rdsm') == 0) ? 'selected' : ''?>>SNMR</option>
                                                <option value="snow_acc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_acc') == 0) ? 'selected' : ''?>>SNTFmm</option>
                                                <option value="snowmelt" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snowmelt') == 0) ? 'selected' : ''?>>SNMF</option>
                                                <option value="et" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'et') == 0) ? 'selected' : ''?>>ETA</option>
                                                <option value="et_above_g" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'et_above_g') == 0) ? 'selected' : ''?>>ETasi</option>
                                                <option value="etfsas" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'etfsas') == 0) ? 'selected' : ''?>>ETfsas</option>
                                                <option value="et_above_re" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'et_above_re') == 0) ? 'selected' : ''?>>ETasf</option>
                                                <option value="water_or_sr" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'water_or_sr') == 0) ? 'selected' : ''?>>WATisrf</option>
                                                <option value="snow_calc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_calc') == 0) ? 'selected' : ''?>>SNTFcm</option>
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
                                                <option value="snow_mm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOF</option>
                                                <option value="rains" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rains') == 0) ? 'selected' : ''?>>RAINS</option>
                                                <option value="rainns" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rainns') == 0) ? 'selected' : ''?>>RAINNS</option>
                                                <option value="snoa" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snoa') == 0) ? 'selected' : ''?>>SNOA</option>
                                                <option value="snom" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snom') == 0) ? 'selected' : ''?>>SNOM</option>
                                                <option value="rssl" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rssl') == 0) ? 'selected' : ''?>>RSSL</option>
                                                <option value="rsi" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rsi') == 0) ? 'selected' : ''?>>RSI</option>
                                                <option value="tdsm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'tdsm') == 0) ? 'selected' : ''?>>SNMT</option>
                                                <option value="rdsm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'rdsm') == 0) ? 'selected' : ''?>>SNMR</option>
                                                <option value="snow_acc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_acc') == 0) ? 'selected' : ''?>>SNTFmm</option>
                                                <option value="snowmelt" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snowmelt') == 0) ? 'selected' : ''?>>SNMF</option>
                                                <option value="et" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'et') == 0) ? 'selected' : ''?>>ETA</option>
                                                <option value="et_above_g" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'et_above_g') == 0) ? 'selected' : ''?>>ETasi</option>
                                                <option value="etfsas" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'etfsas') == 0) ? 'selected' : ''?>>ETfsas</option>
                                                <option value="et_above_re" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'et_above_re') == 0) ? 'selected' : ''?>>ETasf</option>
                                                <option value="water_or_sr" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'water_or_sr') == 0) ? 'selected' : ''?>>WATisrf</option>
                                                <option value="snow_calc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_calc') == 0) ? 'selected' : ''?>>SNTFcm</option>
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
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Run Snow Analysis</button>
            </div>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e"></script>
<script type="module">
    //import {getCookie} from "../js/project.js";           

    function validateParamsForm() {
        if (!$('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', true);
            $('#uploadParamsForm').find(':input[type=submit]').addClass('disabled');
        } else {
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', false);
            $('#uploadParamsForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    function validateForm() {
        $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
        $('#analysisForm').find(':input[type=submit]').addClass('disabled');

        var field0Value = $('#analysisForm').find(':input[name=thr_rs]').val();
        var field1Value = $('#analysisForm').find(':input[name=thr_sm]').val();
        var field2Value = $('#analysisForm').find(':input[name=cft_sm]').val();
        var field3Value = $('#analysisForm').find(':input[name=cfp_sm]').val();
        var field4Value = $('#analysisForm').find(':input[name=cfs_mc]').val();
        var field5Value = $('#analysisForm').find(':input[name=cf_ets]').val();
        var field6Value = $('#analysisForm').find(':input[name=snwt_init]').val();
        var field7Value = $('#analysisForm').find(':input[name=snwm_init]').val();

        if (field0Value && field1Value && field2Value && field3Value && field4Value && field5Value && field6Value && field7Value) {

            if (field0Value < -20) {
                $('#analysisForm').find(':input[name=thr_rs]').val(-20);
            }

            if (field0Value > 10) {
                $('#analysisForm').find(':input[name=thr_rs]').val(10);
            }

            if (field1Value < -20) {
                $('#analysisForm').find(':input[name=thr_sm]').val(-20);
            }

            if (field1Value > 10) {
                $('#analysisForm').find(':input[name=thr_sm]').val(10);
            }

            if (field2Value < 0) {
                $('#analysisForm').find(':input[name=cft_sm]').val(0);
            }

            if (field3Value < 0) {
                $('#analysisForm').find(':input[name=cfp_sm]').val(0);
            }

            if (field4Value < 0) {
                $('#analysisForm').find(':input[name=cfs_mc]').val(0);
            }           

            if (field5Value < 0) {
                $('#analysisForm').find(':input[name=cf_ets]').val(0);
            }

            if (field5Value > 1) {
                $('#analysisForm').find(':input[name=cf_ets]').val(1);
            }

            if (field6Value < 0) {
                $('#analysisForm').find(':input[name=snwt_init]').val(0);
            }

            if (field7Value < 0) {
                $('#analysisForm').find(':input[name=snwm_init]').val(0);
            }
            
            $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
            $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        validateParamsForm();
        validateForm();       
        
        $('#uploadParamsForm').find(':input[name=inputDataFile]').change(function(){     
            // alert($('#uploadParamsForm').find(':input[name=inputDataFile]').val());
            if ($('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
                $("#upload_param_input_group").removeClass("form-red-border");        
                $("#upload_param_input_group").addClass("form-green-border");        
            } else {
                $("#upload_param_input_group").removeClass("form-green-border");        
                $("#upload_param_input_group").addClass("form-red-border");  
            }
            
            validateParamsForm();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#analysisForm').find(':input[name=thr_rs]').change(function() {
            if ($(this).val() < -20) {
                $(this).val(-20);
            }

            if ($(this).val() > 10) {
                $(this).val(10);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_sm]').change(function() {
            if ($(this).val() < -20) {
                $(this).val(-20);
            }

            if ($(this).val() > 10) {
                $(this).val(10);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cft_sm]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cfp_sm]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cfs_mc]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cf_ets]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 1) {
                $(this).val(1);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=snwt_init]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=snwm_init]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
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