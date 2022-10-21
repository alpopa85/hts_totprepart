<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <form id="analysisForm" method="post" action="perform-analysis">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param1-addon">Layer or Root zone thickness (mm)</span>
                    </div>
                    <input type="text" class="form-control" placeholder="! Must be entered in the Water Stress Module !" aria-label="Param1" aria-describedby="param1-addon" name="lt_mm" value="<?= !empty($paramData['lt_mm']) ? $paramData['lt_mm'] : ''; ?>" disabled>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param2-addon">% ET Loss Before Entering the Soil</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Between 0 and 100" aria-label="Param2" aria-describedby="param2-addon" name="et_loss" value="<?= !empty($paramData['et_loss']) ? $paramData['et_loss'] : ''; ?>">
                </div>
            </div>  
            
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param3-addon">Window Width for SR Calculation</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Minimum 2 (days)" aria-label="Param3" aria-describedby="param3-addon" name="sr_window" value="<?= !empty($paramData['sr_window']) ? $paramData['sr_window'] : 4; ?>">
                </div>
            </div>

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Run Water Balance Analysis</button>
            </div>
        </form>
    </div>
</div>

<script type="module">
    //import {getCookie} from "../js/project.js";        

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
                   
        // if value is missing, disable the submit button
        var field1Value = $('#analysisForm').find(':input[name=lt_mm]').val();
        var field2Value = $('#analysisForm').find(':input[name=et_loss]').val();        
        var field3Value = $('#analysisForm').find(':input[name=sr_window]').val();    

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });

        if (!field1Value || !field2Value || !field3Value){
            $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
            $('#analysisForm').find(':input[type=submit]').addClass('disabled');
        }

        $('#analysisForm').find(':input[name=lt_mm]').change(function() {
            var field2Val = $('#analysisForm').find(':input[name=et_loss]').val();
            var field3Val = $('#analysisForm').find(':input[name=sr_window]').val();

            if ($(this).val() && field2Val && (field3Val > 0)) {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
                $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
            } else {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
                $('#analysisForm').find(':input[type=submit]').addClass('disabled');
            }
        });

        $('#analysisForm').find(':input[name=et_loss]').change(function() {
            var field1Val = $('#analysisForm').find(':input[name=lt_mm]').val();
            var field3Val = $('#analysisForm').find(':input[name=sr_window]').val();
            
            if ($(this).val() > 100){
                $(this).val(100);
            }

            if ($(this).val() < 0){
                $(this).val(0);
            }

            if ($(this).val() && field1Val && (field3Val > 0)) {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
                $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
            } else {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
                $('#analysisForm').find(':input[type=submit]').addClass('disabled');
            }
        });    
        
        $('#analysisForm').find(':input[name=sr_window]').change(function() {
            var field1Val = $('#analysisForm').find(':input[name=lt_mm]').val();
            var field2Val = $('#analysisForm').find(':input[name=et_loss]').val();

            if ($(this).val() < 2){
                $(this).val(2);
            }

            if ($(this).val() && field1Val && field2Val) {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
                $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
            } else {
                $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
                $('#analysisForm').find(':input[type=submit]').addClass('disabled');
            }
        }); 
 
        $('#analysisForm').submit(function() {
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');
        });             
    });
</script>