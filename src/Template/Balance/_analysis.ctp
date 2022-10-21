<div class="my-5 row">
    <div class="col-sm-6 offset-3">
        <form method="post" action="perform-analysis">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="param1-addon">Param 1</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Between 0 and 100" aria-label="Param1" aria-describedby="param1-addon"
                        name="param_1" value="<?= !empty($paramData['param_1']) ? $paramData['param_1'] : '';?>">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="param2-addon">Param 2</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Between 0 and 10" aria-label="Param2" aria-describedby="param2-addon"
                    name="param_2" value="<?= !empty($paramData['param_2']) ? $paramData['param_2'] : '';?>">
                </div>
            </div>
            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name ="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Run Water Balance Analysis</button>
            </div>
        </form>    
    </div>   
</div>

<script type="module">
    //import {getCookie} from "../js/project.js";        

    $(document).ready( function () {        
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        //alert(csrfToken);

        //var token = getCookie('csrfToken');
        // alert(token);        
    });
</script>