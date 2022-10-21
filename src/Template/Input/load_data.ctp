<div class="container-lg">
    <div class="row my-5">
                
        <div class="col-6 px-0">
            <button id="test_data_btn" class="btn btn-large btn-primary w-100"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Try the tool using the test dataset</button>        
        </div>

        <div class="col-6 px-0">                
            <button id="upload_data_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Upload user data</button>  
        </div>

    </div>
</div>

<div id="upload_data_content" class="container-lg my-5" style="display:none">    
    <div class="row">
        <div class="col-12">
            <h6>Please provide the input data in a CSV (.csv) file formatted as described below, using commas as column/field separators:</h6>
        </div>
    </div>

    <table class="table table-bordered text-center my-3">
        <thead class="thead-dark">
            <tr class="table-primary">
                <td class="customlegend" colspan=7>
                    <fieldset>
                        <legend>WATBAL Input data file: format, columns, and units for input and user calibration data (UCD)</legend>
                    </fieldset>
                </td>
            </tr>
            <tr class="table-primary">
                <th scope="row">Columns</th>
                <td>DATE</td>
                <td><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></td>
                <td><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></td>
                <td><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></td>
                <td><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span></td>                
                <td class="validation-col"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span> (max. 5 columns)</td>
            </tr>
            <tr class="table-info no-wrap-table-row">
                <th scope="row">Units</th>
                <td>yyyy-mm-dd</td>
                <td>&deg;C</td>
                <td>mm</td>               
                <td>mm</td>
                <td>mm</td>
                <td>user choice</td>    
            </tr> 
            <tr class="table-info no-wrap-table-row">
                <th scope="row">Values</th>
                <td>eg. 2021-12-24</td>
                <td>-90 to 60</td>
                <td>0 to 1800</td>                
                <td>0 to 1800</td>  
                <td>0 to 100</td>  
                <td>user choice</td>    
            </tr> 
        </thead>
        <tbody>        
        </tbody>
    </table>
            
    <h6>Notes:</h6>

    <ul>
        <li>
            columns marked with <span style="color:goldenrod">&#9608;</span> denote optional values that can be used for calibration;
        </li>
    </ul>

    <div class="row d-flex d-flex-row justify-content-center align-items-center mt-5">      
        <div style="margin-right:1rem">
            <h6>Download a pre-formatted sample file here:</h6>         
        </div>
        <a href="<?= $this->Url->build('/project/sample_data.csv'); ?>" class="btn btn-large btn-primary" role="button" download>DOWNLOAD SAMPLE FILE</a>        
    </div>
</div>

<div class="container-lg">
    <div class="my-5 row">      
        <div class="col-12 col-lg-6 offset-lg-3">   
            <form method="post" id="uploadFileForm" action="upload-input-file" enctype="multipart/form-data" class="mt-3">                            
                <div id="upload_data_input_group" class="input-group mb-5 form-red-border" style="display:none">           
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="filename" name="inputDataFile" aria-describedby="fileHelp">
                        <label class="custom-file-label" for="fileHelp">Upload a Source Data File</label>
                    </div>
                </div>                  

                <div class="text-center">
                    <p>
                        <h6>The tool calculates all parameters on a daily, monthly, meteorological season, growing season and annual basis.</h6>
                    </p>
                </div>

                <div class="form-check mb-3 text-center">
                    <input class="form-check-input" type="checkbox" value="1" id="growth_season_checkbox" checked>
                    <label class="form-check-label" for="growth_season_checkbox">
                        Require Growth Season Calculations
                    </label>
                </div>

                <div id="growth_season_dates">
                    <p>
                        <h6>Please specify the start and end dates for the growing season:</h6>
                    </p>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label-addon text-center" id="param3-addon">Growth Season Start (mm-dd)</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Choose Date" aria-label="Param3" aria-describedby="param3-addon" id="growth_season_start" value="">
                        </div>
                    </div>
                    <input type="hidden" name="gs_start_day" id="gs_start_day" value="" />
                    <input type="hidden" name="gs_start_month" id="gs_start_month" value="" />

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label-addon text-center" id="param4-addon">Growth Season End (mm-dd)</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Choose Date" aria-label="Param4" aria-describedby="param4-addon" id="growth_season_end" value="">
                        </div>
                    </div>
                    <input type="hidden" name="gs_end_day" id="gs_end_day" value="" />
                    <input type="hidden" name="gs_end_month" id="gs_end_month" value="" />

                    <p>
                        <h6>The selected interval will be applied to each year in the input data.</h6>
                    </p>

                </div>

                <input type="hidden" name="inputHasHeaders" value="1" />
                <input type="hidden" name="testFileStatus" value="1" />
                <!-- CAKE FORM FIELDS !-->
                <input type="hidden" name ="_method" value="POST" />
                <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
                <!-- END OF CAKE FORM FIELDS !-->
                
                <div class="mt-5 text-center">
                    <button type="submit" class="btn btn-success">Load Data</button>                    
                </div>        
            </form>  
        </div>  
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e"></script>
<script type="module">
    //import {getCookie} from "../js/project.js"; 
    var testFile = true;

    var defaultGsStart = "<?= $gsStart; ?>";
    var defaultGsEnd = "<?= $gsEnd; ?>";

    var currentGsStart = defaultGsStart;
    var currentGsEnd = defaultGsEnd;    
    
    function enableTestFile(){
        testFile = true;
        $('#uploadFileForm').find(':input[name=testFileStatus]').val(1);
    }

    function disableTestFile(){
        testFile = false;
        $('#uploadFileForm').find(':input[name=testFileStatus]').val(0);
    }

    function validateForm(){
        // console.log('validating form');

        if (!testFile){
            if (!$('#uploadFileForm').find(':input[name=inputDataFile]').val()){
                $('#uploadFileForm').find(':input[type=submit]').prop('disabled', true);
                $('#uploadFileForm').find(':input[type=submit]').addClass('disabled');

                return;
            }        
        }

        if ($('#uploadFileForm').find(':input[id=growth_season_checkbox]').prop('checked')){
            // console.log('checked: ' + $("#growth_season_start").val());
            if (!$("#growth_season_start").val()){
                $('#uploadFileForm').find(':input[type=submit]').prop('disabled', true);
                $('#uploadFileForm').find(':input[type=submit]').addClass('disabled');

                return;
            }

            // console.log('checked: ' + $("#growth_season_end").val());
            if (!$("#growth_season_end").val()){
                $('#uploadFileForm').find(':input[type=submit]').prop('disabled', true);
                $('#uploadFileForm').find(':input[type=submit]').addClass('disabled');

                return;
            }
        }        

        $('#uploadFileForm').find(':input[type=submit]').prop('disabled', false);
        $('#uploadFileForm').find(':input[type=submit]').removeClass('disabled');
    }
   
    function initGrowthSeasonValues(){
        $("#growth_season_start").val(currentGsStart);
        $("#growth_season_end").val(currentGsEnd);
        // console.log($("#growth_season_start").val(), $("#growth_season_end").val());

        refreshGrowthSeasonValues();
    }
    
    function refreshGrowthSeasonValues(){           
        var parts;
        
        if ($("#growth_season_start").val()){
            parts = $("#growth_season_start").val().split("-");
            $("#gs_start_day").val(parts[1]);
            $("#gs_start_month").val(parts[0]);      
            currentGsStart = $("#gs_start_month").val() + '-' + $("#gs_start_day").val();              
        } else {
            $("#gs_start_day").val(null);
            $("#gs_start_month").val(null);             
        }
        // console.log($("#gs_start_day").val(), $("#gs_start_month").val());
        
        if ($("#growth_season_end").val()){
            parts = $("#growth_season_end").val().split("-");
            $("#gs_end_day").val(parts[1]);
            $("#gs_end_month").val(parts[0]);                   
            currentGsEnd = $("#gs_end_month").val() + '-' + $("#gs_end_day").val();
        } else {
            $("#gs_end_day").val(null);
            $("#gs_end_month").val(null);
        }
        // console.log($("#gs_end_day").val(), $("#gs_end_month").val());             
    }

    $(document).ready( function () {  
        // var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;  
        
        bsCustomFileInput.init();
        initGrowthSeasonValues(); 
        validateForm();

        $("#test_data_btn").click((e)=>{            
            const elem = $(e.target);  

            enableTestFile();

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#upload_data_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#upload_data_btn").addClass("btn-secondary");
            }

            $("#upload_data_input_group").hide();
            $("#upload_data_content").hide();
            validateForm();
        });

        $("#upload_data_btn").click((e)=>{    
            const elem = $(e.target);    

            disableTestFile();

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#test_data_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#test_data_btn").addClass("btn-secondary");
            }
            
            $("#upload_data_content").show();
            $("#upload_data_input_group").show();
            validateForm();
        });                
        
        // DATEPICKER STUFF //
        /********************/           
        var from = $("#growth_season_start").datepicker({
            format: "mm-dd",            
        });          
        var to = $("#growth_season_end").datepicker({
            format: "mm-dd"
        });

        // FORM STUFF //
        /**************/        

        $('#uploadFileForm').find(':input[id=growth_season_checkbox]').change(function(){
            if ($(this).prop('checked')){
                $("#growth_season_dates").show();   
                initGrowthSeasonValues();   
                validateForm();          
            } else {
                $("#growth_season_dates").hide();
                $("#growth_season_start").val(null);
                $("#growth_season_end").val(null);
                refreshGrowthSeasonValues();                
                validateForm();
            }                        
        });

        $('#uploadFileForm').find(':input[name=inputDataFile]').change(function(){     
            if ($('#uploadFileForm').find(':input[name=inputDataFile]').val()){
                $("#upload_data_input_group").removeClass("form-red-border");        
                $("#upload_data_input_group").addClass("form-green-border");        
            } else {
                $("#upload_data_input_group").removeClass("form-green-border");        
                $("#upload_data_input_group").addClass("form-red-border");  
            }
            
            validateForm();
        });

        $("#growth_season_start").change(function(){
            refreshGrowthSeasonValues();
            validateForm();
        });

        $("#growth_season_end").change(function(){
            refreshGrowthSeasonValues();           
            validateForm();
        });          

        $("#uploadFileForm").submit(async function(e){
            $("#mySpinnerContainer").show();

            e.preventDefault();   
            var actionUrl = e.target.action;                      
                   
            var redirectUrlError = "<?= $this->Url->build([
                'controller' => 'input',
                'action' => 'load-data'
            ], true); ?>";            

            // ajax call to function that tells me how many UCD fields
            async function uploadFile(recaptchaToken) {
                let formData = new FormData($("#uploadFileForm")[0]);
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
                $("#mySpinnerContainer").hide();

                if (data.success) {
                    // console.log('there are these many UCD fields: ' + data.ucdFields);

                    // show modal for the given number of fields
                    switch (data.ucdFields) {
                        case 5:
                            $("#ucd-present").show();
                            $("#ucd5").show();
                            $("#ucd-present-footer").show();
                            $("#ucd-not-present-footer").hide();
                        case 4:
                            $("#ucd-present").show();
                            $("#ucd4").show();
                            $("#ucd-present-footer").show();
                            $("#ucd-not-present-footer").hide();
                        case 3:
                            $("#ucd-present").show();
                            $("#ucd3").show();
                            $("#ucd-present-footer").show();
                            $("#ucd-not-present-footer").hide();
                        case 2:
                            $("#ucd-present").show();
                            $("#ucd2").show();
                            $("#ucd-present-footer").show();
                            $("#ucd-not-present-footer").hide();
                        case 1:
                            $("#ucd-present").show();
                            $("#ucd1").show();
                            $("#ucd-present-footer").show();
                            $("#ucd-not-present-footer").hide();
                            break;
                        default:
                            $("#ucdModalTitle").text("Attention! Input data set does not contain calibration data (UCD)!");
                    }
                    $("#ucdModal").modal({
                        backdrop: 'static'
                    });
                } else {
                    // alert('Error ' + JSON.stringify(data));
                    window.location.href = redirectUrlError;
                }                
            }).catch(function(){
                // alert('Error');
                window.location.href = redirectUrlError;
            });       
        });               
    });
</script>