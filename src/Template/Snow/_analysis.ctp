<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <form id="analysisForm" method="post" action="perform-analysis">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param0-addon">Layer or Root zone thickness (mm)</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Between 1 and 5000" aria-label="Param0" aria-describedby="param0-addon" name="lt_mm" value="<?= !empty($paramData['lt_mm']) ? $paramData['lt_mm'] : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param1-addon">Field Capacity (m<sup>3</sup>/m<sup>3</sup>)</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Between 0 and 1" aria-label="Param1" aria-describedby="param1-addon" name="fc" value="<?= !empty($paramData['fc']) ? $paramData['fc'] : ''; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param1-mm">Field Capacity (mm)</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Param1mm" aria-describedby="param1-mm" name="fc_mm" value="<?= !empty($paramData['fc']) ? $paramData['fc'] * $paramData['lt_mm'] : ''; ?>" disabled>
                </div>
            </div>

            <p>
            <h6 class="pt-4 pb-2">Please specify thresholds (T1, T2 and T3) as percentage of FC in order to set up water stress intervals for the analysis.</h6>
            </p> 

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param0-addon">T0 %</span>
                    </div>
                    <input type="text" class="form-control threshold" placeholder="Between 0 and 100" aria-label="Param0" aria-describedby="param0-addon" 
                    value="0" disabled>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param2-addon">T1 %</span>
                    </div>
                    <input type="text" class="form-control threshold" placeholder="Between 0 and 100" aria-label="Param2" aria-describedby="param2-addon" 
                    id="t1" name="t1" value="<?= !empty($paramData['t1']) ? $paramData['t1'] : 70; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param3-addon">T2 %</span>
                    </div>
                    <input type="text" class="form-control threshold" placeholder="Between 0 and 100" aria-label="Param3" aria-describedby="param3-addon" 
                    id="t2" name="t2" value="<?= !empty($paramData['t2']) ? $paramData['t2'] : 80; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param4-addon">T3 %</span>
                    </div>
                    <input type="text" class="form-control threshold" placeholder="Between 0 and 100" aria-label="Param4" aria-describedby="param4-addon"
                    id="t3" name="t3" value="<?= !empty($paramData['t3']) ? $paramData['t3'] : 90; ?>">                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-addon text-center" id="param5-addon">T4 %</span>
                    </div>
                    <input type="text" class="form-control threshold" placeholder="Between 0 and 100" aria-label="Param5" aria-describedby="param5-addon" 
                    value="100" disabled>
                </div>
            </div>

            <p>
            <h6 class="pt-4 pb-2">Your selected intervals:</h6>
            </p> 

            <div class="form-group">
                <div class="input-group mt-2 mb-3">                                                          
                    <input id="interval-summary" type="text">
                </div>
            </div>            

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Run Water Stress Analysis</button>
            </div>
        </form>
    </div>
</div>

<script type="module">
    //import {getCookie} from "../js/project.js";   
    
    function refreshIntervals(t1,t2,t3,fc)
    {
        // console.log(t1,t2,t3,fc);        

        if (!fc){
            fc = 1;
        }        
        var t1Display = (t1*fc)/100;
        var t2Display = (t2*fc)/100;
        var t3Display = (t3*fc)/100;    
        var fcDisplay = (100*fc)/100;                  
        
        $("#interval-summary").slider({
            min: 0,
	        max: fcDisplay,    
            value: 0,                  
            enabled: false,                      
            ticks: [0, t1Display, t2Display, t3Display, fcDisplay],            
            ticks_positions: [0, t1, t2, t3, 100],
            ticks_labels: ['0', 'T1', 'T2', 'T3', 'FC'],            
            ticks_tooltip: true      
        });        
    }

    function validateForm()
    {
        $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
        $('#analysisForm').find(':input[type=submit]').addClass('disabled');

        var field0Value = $('#analysisForm').find(':input[name=lt_mm]').val();
        var field1Value = $('#analysisForm').find(':input[name=fc]').val();
        var field2Value = $('#analysisForm').find(':input[name=t1]').val();  
        var field3Value = $('#analysisForm').find(':input[name=t2]').val();  
        var field4Value = $('#analysisForm').find(':input[name=t3]').val();  

        if(field0Value && field1Value && field2Value && field3Value && field4Value){
            $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
            $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    function updateFieldCapacityMM()
    {
        var lt_mm = $('#analysisForm').find(':input[name=lt_mm]').val();
        var fc = $('#analysisForm').find(':input[name=fc]').val();
                
        $('#analysisForm').find(':input[name=fc_mm]').val(lt_mm * fc);
    }

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;               
        
        refreshIntervals($("#t1").val(),$("#t2").val(),$("#t3").val(),$('#analysisForm').find(':input[name=fc]').val());
        validateForm();       

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });

        $('#analysisForm').find(':input[name=lt_mm]').change(function() {
            if ($(this).val() < 0){
                $(this).val(1);
            }
            
            if ($(this).val() > 5000){
                $(this).val(5000);
            }

            updateFieldCapacityMM();
            validateForm();            
        }); 
                           
        $('#analysisForm').find(':input[name=fc]').change(function() {
            if ($(this).val() < 0){
                $(this).val(0);
            }
            
            if ($(this).val() > 1){
                $(this).val(1);
            }

            $("#interval-summary").slider('destroy');
            refreshIntervals($("#t1").val(),$("#t2").val(),$("#t3").val(),$('#analysisForm').find(':input[name=fc]').val());

            updateFieldCapacityMM();
            validateForm();
        });        

        $('#analysisForm').find(':input[name=t1]').change(function() {
            if ($(this).val() < 0){
                $(this).val(0);
            }

            if ($(this).val() >= $("#t2").val()){
                $(this).val(parseInt($("#t2").val()) - 1);
            }

            $("#interval-summary").slider('destroy');
            refreshIntervals($("#t1").val(),$("#t2").val(),$("#t3").val(),$('#analysisForm').find(':input[name=fc]').val());
            
            validateForm();
        });

        $('#analysisForm').find(':input[name=t2]').change(function() {
            if ($(this).val() < 0){
                $(this).val(0);
            }

            if ($(this).val() <= $("#t1").val()){                
                $(this).val(parseInt($("#t1").val()) + 1);
            }
            
            if ($(this).val() >= $("#t3").val()){
                $(this).val(parseInt($("#t3").val()) - 1);
            }

            $("#interval-summary").slider('destroy');
            refreshIntervals($("#t1").val(),$("#t2").val(),$("#t3").val(),$('#analysisForm').find(':input[name=fc]').val());
            
            validateForm();
        });

        $('#analysisForm').find(':input[name=t3]').change(function() {
            if ($(this).val() < 0){
                $(this).val(0);
            }

            if ($(this).val() <= $("#t2").val()){
                $(this).val(parseInt($("#t2").val()) + 1);
            }
            
            if ($(this).val() >= 100){
                $(this).val(99);
            }                        

            $("#interval-summary").slider('destroy');
            refreshIntervals($("#t1").val(),$("#t2").val(),$("#t3").val(),$('#analysisForm').find(':input[name=fc]').val());

            validateForm();
        });
 
        $('#analysisForm').submit(function() {
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');
        });             
    });
</script>