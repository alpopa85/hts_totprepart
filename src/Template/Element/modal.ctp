<?php $this->start('ucd_modal'); ?>
<!-- UCD AVG MODAL -->
<div class="modal fade" id="ucdModal" tabindex="-1" role="dialog" aria-labelledby="ucdModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ucdModalTitle" style="text-align:center">Select the UCD averaging method</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div id="ucd-present" style="display:none">
          <h6>In order to perform averaging for the various intervals, the tool calculates the monthly average using two methods:</h6>
          <ul>
            <li>
              <h6>Daily Average - the monthly average is the average of daily values (e.g. method used for Temperature)</h6>
            </li>
            <li>
              <h6>Daily Sum - the monthly average is the sum of daily values (e.g. method used for Precipitation)</h6>
            </li>
          </ul>
        </div>        

        <div class="row my-2 mt-4" id="ucd1" style="display:none">
          <div class="col-4 my-auto text-center"><strong>UCD1</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd1_select" placeholder="Averaging Method">
              <option value="1" selected>Daily Average</option>
              <option value="2">Daily Sum</option>
            </select>
          </div>
        </div>

        <div class="row my-2" id="ucd2" style="display:none">
          <div class="col-4 my-auto text-center"><strong>UCD2</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd2_select" placeholder="Averaging Method">
              <option value="1" selected>Daily Average</option>
              <option value="2">Daily Sum</option>
            </select>
          </div>
        </div>

        <div class="row my-2" id="ucd3" style="display:none">
          <div class="col-4 my-auto text-center"><strong>UCD3</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd3_select" placeholder="Averaging Method">
              <option value="1" selected>Daily Average</option>
              <option value="2">Daily Sum</option>
            </select>
          </div>
        </div>

        <div class="row my-2" id="ucd4" style="display:none">
          <div class="col-4 my-auto text-center"><strong>UCD4</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd4_select" placeholder="Averaging Method">
              <option value="1" selected>Daily Average</option>
              <option value="2">Daily Sum</option>
            </select>
          </div>
        </div>

        <div class="row my-2 mb-4" id="ucd5" style="display:none">
          <div class="col-4 my-auto text-center"><strong>UCD5</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd5_select" placeholder="Averaging Method">
              <option value="1" selected>Daily Average</option>
              <option value="2">Daily Sum</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">        
        <div id="ucd-present-footer" style="display:none">                
          <button type="button" class="btn btn-success confirm-ucd-avg">Confirm</button>
          <button class="btn btn-success confirm-ucd-avg-loading" type="button" disabled style="display:none">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Processing...
          </button>
        </div>

        <div id="ucd-not-present-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Return</button>
          <button type="button" class="btn btn-success confirm-ucd-avg">Proceed</button>
          <button class="btn btn-success confirm-ucd-avg-loading" type="button" disabled style="display:none">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Processing...
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>; 

    var actionUrl = "<?= $this->Url->build([
                          'controller' => 'input',
                          'action' => 'run-averages'
                        ], true); ?>";

    function runAveraging() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _csrfToken: csrfToken,
                    ucd1: $("#ucd1_select").val(),
                    ucd2: $("#ucd2_select").val(),
                    ucd3: $("#ucd3_select").val(),
                    ucd4: $("#ucd4_select").val(),
                    ucd5: $("#ucd5_select").val()
                },
                success: function(response) {
                    resolve(response)
                },
                error: function(error) {
                    reject(error)
                },
            })
        });
    }

    $(".confirm-ucd-avg").click(function() {      
      $('.confirm-ucd-avg').hide();
      $('.confirm-ucd-avg-loading').show();

      var redirectUrlError = "<?= $this->Url->build([
                                'controller' => 'input',
                                'action' => 'load-data'
                              ], true); ?>";

      var redirectUrlSuccess = "<?= $this->Url->build([
                                  'controller' => 'input',
                                  'action' => 'graph'
                                ], true); ?>";     

      runAveraging().then(function(data) {
        if (data.success) {
          window.location.href = redirectUrlSuccess;
        } else {
          // alert('Error ' + JSON.stringify(data));
          window.location.href = redirectUrlError;
        }
      }).catch(function() {
        // alert('Error');
        window.location.href = redirectUrlError;
      });
    })
  });
</script>
<?php $this->end(); ?>

<?php $this->start('ucd_reset_modal'); ?>
<!-- UCD AVG RESET MODAL -->
<div class="modal fade" id="ucdModalReset" tabindex="-1" role="dialog" aria-labelledby="ucdModalResetTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="ucdModalResetTitle" style="text-align:center">Select the UCD averaging method</h5>      
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">        
        <div id="ucd-reset-present">
          <h6>In order to perform averaging for the various intervals, the tool calculates the monthly average using two methods:</h6>
          <ul>
            <li>
              <h6>Daily Average - the monthly average is the average of daily values (e.g. method used for Temperature)</h6>
            </li>
            <li>
              <h6>Daily Sum - the monthly average is the sum of daily values (e.g. method used for Precipitation)</h6>
            </li>
          </ul>
        </div>        

        <?php if (isset($ucdFields['total']) && ($ucdFields['total'] > 0)) { ?>
        <div class="row my-2 mt-4" id="ucd1reset">
          <div class="col-4 my-auto text-center"><strong>UCD1</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd1_reset_select" placeholder="Averaging Method">
              <option value="1" <?= $ucdFields['ucd1'] == 1 ? 'selected' : ''?>>Daily Average</option>
              <option value="2" <?= $ucdFields['ucd1'] == 2 ? 'selected' : ''?>>Daily Sum</option>
            </select>
          </div>
        </div>
        <?php } ?>

        <?php if (isset($ucdFields['total']) && ($ucdFields['total'] > 1)) { ?>
        <div class="row my-2" id="ucd2reset">
          <div class="col-4 my-auto text-center"><strong>UCD2</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd2_reset_select" placeholder="Averaging Method">
              <option value="1" <?= $ucdFields['ucd2'] == 1 ? 'selected' : ''?>>Daily Average</option>
              <option value="2" <?= $ucdFields['ucd2'] == 2 ? 'selected' : ''?>>Daily Sum</option>
            </select>
          </div>
        </div>
        <?php } ?>

        <?php if (isset($ucdFields['total']) && ($ucdFields['total'] > 2)) { ?>
        <div class="row my-2" id="ucd3reset">
          <div class="col-4 my-auto text-center"><strong>UCD3</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd3_reset_select" placeholder="Averaging Method">
              <option value="1" <?= $ucdFields['ucd3'] == 1 ? 'selected' : ''?>>Daily Average</option>
              <option value="2" <?= $ucdFields['ucd3'] == 2 ? 'selected' : ''?>>Daily Sum</option>
            </select>
          </div>
        </div>
        <?php } ?>

        <?php if (isset($ucdFields['total']) && ($ucdFields['total'] > 3)) { ?>
        <div class="row my-2" id="ucd4reset">
          <div class="col-4 my-auto text-center"><strong>UCD4</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd4_reset_select" placeholder="Averaging Method">
              <option value="1" <?= $ucdFields['ucd4'] == 1 ? 'selected' : ''?>>Daily Average</option>
              <option value="2" <?= $ucdFields['ucd4'] == 2 ? 'selected' : ''?>>Daily Sum</option>
            </select>
          </div>
        </div>
        <?php } ?>

        <?php if (isset($ucdFields['total']) && ($ucdFields['total'] > 4)) { ?>
        <div class="row my-2 mb-4" id="ucd5reset">
          <div class="col-4 my-auto text-center"><strong>UCD5</strong></div>
          <div class="col">
            <select class="custom-select" id="ucd5_reset_select" placeholder="Averaging Method">
              <option value="1" <?= $ucdFields['ucd5'] == 1 ? 'selected' : ''?>>Daily Average</option>
              <option value="2" <?= $ucdFields['ucd5'] == 2 ? 'selected' : ''?>>Daily Sum</option>
            </select>
          </div>
        </div>
        <?php } ?>
      </div>
      
      <div class="modal-footer">        
        <div>                
          <button type="button" class="btn btn-success confirm-ucd-reset">Confirm</button>
          <button class="btn btn-success confirm-ucd-reset-loading" type="button" disabled style="display:none">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Processing...
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>; 

    var actionUrl = "<?= $this->Url->build([
                          'controller' => 'input',
                          'action' => 'reset-ucd-averages'
                        ], true); ?>";

    function runAveraging() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _csrfToken: csrfToken,
                    ucd1: $("#ucd1_reset_select").val(),
                    ucd2: $("#ucd2_reset_select").val(),
                    ucd3: $("#ucd3_reset_select").val(),
                    ucd4: $("#ucd4_reset_select").val(),
                    ucd5: $("#ucd5_reset_select").val()
                },
                success: function(response) {
                    resolve(response)
                },
                error: function(error) {
                    reject(error)
                },
            })
        });
    }

    $(".confirm-ucd-reset").click(function() {      
      $('.confirm-ucd-reset').hide();
      $('.confirm-ucd-reset-loading').show();  

      runAveraging().then(function(data) {
        window.location.reload();
      }).catch(function() {
        window.location.reload();
      });
    })
  });
</script>
<?php $this->end(); ?>

<?php $this->start('reset_modal'); ?>
<!-- RESET MODAL -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetDataModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetDataModalTitle">Confirm Data Reset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to erase all loaded and processed data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-reset">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-reset">Confirm</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#confirm-reset").click(function() {
      $('#confirm-reset').prop('disabled', true);
      $('#confirm-reset').addClass('disabled');

      $('#cancel-reset').prop('disabled', true);
      $('#cancel-reset').addClass('disabled');

      window.location.href = "<?= $this->Url->build([
                                'controller' => 'input',
                                'action' => 'reset-data'
                              ], true); ?>"
    })
  });
</script>
<?php $this->end(); ?>

<?php $this->start('admin_modal'); ?>
<!-- ADMIN MODAL -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalTitle">Admin Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="loginForm" method="post" action="<?= $this->Url->build([
                                                      'controller' => 'admin',
                                                      'action' => 'login'
                                                    ], true); ?>">
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend" style="max-width:30%">
                <span class="input-group-text label-addon text-center" id="param1">Admin Password</span>
              </div>
              <input type="password" class="form-control" placeholder="" aria-label="Param1" aria-describedby="param1" name="password">
            </div>
          </div>

          <!-- CAKE FORM FIELDS !-->
          <input type="hidden" name="_method" value="POST" />
          <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
          <!-- END OF CAKE FORM FIELDS !-->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-admin">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-admin">Log In</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#confirm-admin").click(function() {
      $('#confirm-admin').prop('disabled', true);
      $('#confirm-admin').addClass('disabled');

      $('#cancel-admin').prop('disabled', true);
      $('#cancel-admin').addClass('disabled');

      $("#loginForm").submit();
    })
  });
</script>
<?php $this->end(); ?>

<?php $this->start('reset_db_modal'); ?>
<!-- RESET DB MODAL -->
<div class="modal fade" id="resetDbModal" tabindex="-1" role="dialog" aria-labelledby="resetDbModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetDbModalTitle">Confirm Database Reset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to erase all datasets that are older than 24h?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-reset-db">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-reset-db">Confirm</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#confirm-reset-db").click(function() {
      $('#confirm-reset-db').prop('disabled', true);
      $('#confirm-reset-db').addClass('disabled');

      $('#cancel-reset-db').prop('disabled', true);
      $('#cancel-reset-db').addClass('disabled');

      var endpoint = '<?= $this->Url->build([
                        "controller" => "admin",
                        "action" => "reset-db-data"
                      ], true); ?>';

      window.location.href = endpoint;
    })
  });
</script>
<?php $this->end(); ?>

<?php $this->start('snow_analysis_modal'); ?>
<!-- SNOW ANALYSIS MODAL -->
<div class="modal fade" id="snowAnalysisModal" tabindex="-1" role="dialog" aria-labelledby="snowAnalysisModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="snowAnalysisModalTitle">Performing Analysis...</h5>
        <div float="right">
          <h5 class="modal-title" id="analysisCompletionRate">0 %</h5>
        </div>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row borderedSection" id="graphWrapper" style="display:none">
            <div class="col-6">  
              <div id="calibGraph1"></div>              
            </div>
            <div class="col-6">  
              <div id="calibGraph2"></div>              
            </div>
          </div>

          <div class="row borderedSection mt-3 mb-1" id="calibTypeMenu" style="display:none">
            <div class="col-6">
                <div class="mb-1 pl-1">Select time step for calibration stats:</div>
                <select class="custom-select" id="calib_type">
                    <option selected value="1">Daily</option>
                    <!-- <option value="2">Monthly</option>                    
                    <option value="10">Seasons</option>
                    <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                        <option value="11">Growing Season</option>
                    <?php } ?>
                    <option value="3">Yearly</option>
                    <option value="21">Typical Year Daily</option>
                    <option value="22">Typical Year Monthly</option>
                    <option value="24">Typical Year Seasons</option> -->
                    <!-- <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                        <option value="25">Typical Year Growing Season</option>
                    <?php } ?> -->
                    <!-- <option value="23">Typical Year Average</option>                 -->
                </select>
            </div>
          </div>

          <div class="row borderedSection mb-3">
            <div class="col">
              <table class="table display cell-border compact text-center" id="rollingCalibDataTable">
                  <thead>
                      <tr>                        
                          <th scope="col">Statistic</th>                        
                          <th scope="col">Calibration Pair 1</th> 
                          <th scope="col">Calibration Pair 2</th>                       
                      </tr>
                  </thead>
              </table>
            </div>            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="cancel-sn-analysis">STOP ANALYSIS</button>
        <button type="button" class="btn btn-secondary" id="return-sn-analysis" style="display:none">RETURN</button>
        <button type="button" class="btn btn-primary" id="complete-sn-analysis" style="display:none">PROCEED TO RESULTS</button>
      </div>
    </div>
  </div>
</div>

<script>
  var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>; 

  var calibGraph1 = document.getElementById('calibGraph1');     
  var calibGraph2 = document.getElementById('calibGraph2');    

  function getCalibStatsType() {
    return $('#calib_type').val();
  }
  
  var graphObjTemplate = {   
      nticks: 6,     
      layout: null,
      fig: null,

      defaultTrace: {
          type: 'scatter',
          mode: 'lines',
          line: {
              width: 1,
          }            
      },

      initTraces: function(){
        // input traces
        this.trace1 = {
            name: 'Model Output',
            yaxis: 'y'
        };

        this.trace2 = {
            name: 'UCD',
            yaxis: 'y'
        };                       
      },   

      setTracePair1: function(response){        
        this.nticks = 6;        

        if (response.timeData && response.timeData.length < this.nticks) {
          this.nticks = response.timeData.length;
        }
        
        $.extend(this.trace1, {
            x: response.timeData,
            y: response.pair1.trace1Data,            
        });
        // console.log(this.trace1);
                
        $.extend(this.trace2, {
            x: response.timeData,
            y: response.pair1.trace2Data,            
        });                      
        // console.log(this.trace2);
      },

      setTracePair2: function(response){        
        this.nticks = 6;        

        if (response.timeData && response.timeData.length < this.nticks) {
          this.nticks = response.timeData.length;
        }
        
        $.extend(this.trace1, {
            x: response.timeData,
            y: response.pair2.trace1Data,            
        });
        // console.log(this.trace1);
                
        $.extend(this.trace2, {
            x: response.timeData,
            y: response.pair2.trace2Data,            
        });                      
        // console.log(this.trace2);
      },

      setLayout: function($type){
        var myTickFormat = '%d-%b-%Y';
        if ($type > 2) {
          myTickFormat = null;
        }
      
        // var titleVal = providedTitle;
        var yAxisVal = null;

        this.layout = {
            // title: {
            //     text: providedTitle,
            //     font: "Times New Roman"                    
            // },
            autosize: true,
            xaxis: {                  
                nticks: this.nticks,
                tickformat: myTickFormat,
                // visible: false
            },
            yaxis: {                                  
                // title: yAxisVal,
                // visible: false
            },
            margin: {
                b: 80,
                l: 40,
                r: 40,
                t: 10
            },
            showlegend: true,
            legend: {
                x: 0,
                y: 1.2,                    
            },
            displayModeBar: false
        };
      },

      setFig: function (){
        var traces = [];

        traces.push($.extend({},this.defaultTrace,this.trace1));
        traces.push($.extend({},this.defaultTrace,this.trace2));                   

        this.fig = {
          data: traces,
          layout: this.layout          
        };        
      }
  }

  var calibGraph1Object = $.extend({}, graphObjTemplate);
  var calibGraph2Object = $.extend({}, graphObjTemplate);

  var getCalibTracePairsUrl = "<?= $this->Url->build([
                          'controller' => 'snow',
                          'action' => 'get-calib-trace-pairs'
                        ], true); ?>";

  var getDatasetLengthUrl = "<?= $this->Url->build([
                          'controller' => 'input',
                          'action' => 'get-dataset-length'
                        ], true); ?>";

  function getDatasetLength(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getDatasetLengthUrl,
            type: 'POST',
            data: {
                _csrfToken: csrfToken
            },
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        })
    });
  }

  function getCalibTraceData(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getCalibTracePairsUrl,
            type: 'POST',
            headers: {
                "X-CSRF-Token": csrfToken 
            },                 
            data: {
                type: getCalibStatsType()
            },            
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        })
    });
  }

  var stopActionUrl = "<?= $this->Url->build([
                          'controller' => 'snow',
                          'action' => 'stop-analysis'
                        ], true); ?>";

  var resetActionUrl = "<?= $this->Url->build([
                          'controller' => 'snow',
                          'action' => 'reset-analysis'
                        ], true); ?>";

  var calibStatsUrl = "<?= $this->Url->build([
                        'controller' => 'snow',
                        'action' => 'fetch-calib-stats'
                      ], true); ?>";

  
function stopAnalysisRequest() {
      return new Promise((resolve, reject) => {
          $.ajax({
              url: stopActionUrl,
              type: 'POST',
              data: {
                  _csrfToken: csrfToken                   
              },
              success: function(response) {
                  resolve(response)
              },
              error: function(error) {
                  reject(error)
              },
          })
      });
  }

  function resetAnalysisRequest() {
      return new Promise((resolve, reject) => {
          $.ajax({
              url: resetActionUrl,
              type: 'POST',
              data: {
                  _csrfToken: csrfToken                   
              },
              success: function(response) {
                  resolve(response)
              },
              error: function(error) {
                  reject(error)
              },
          })
      });
  }
</script>

<script>
  $(document).ready(function() {      
    var calibTable;
    var datasetLength;
    var analysisStoppedByUser = false;

    $("#cancel-sn-analysis").click(function() {
      $('#cancel-sn-analysis').prop('disabled', true);
      $('#cancel-sn-analysis').addClass('disabled');

      analysisStoppedByUser = true;
      stopAnalysisRequest(); // not interested in a return from this
    }); 

    $("#return-sn-analysis").click(function() {
      $('#return-sn-analysis').prop('disabled', true);
      $('#return-sn-analysis').addClass('disabled');

      resetAnalysisRequest().finally(function(){
        window.location.href = '<?= $this->Url->build([
                        "controller" => "snow",
                        "action" => "analysis"
                      ], true); ?>'; 
      });
    }); 

    $("#complete-sn-analysis").click(function() {
      $('#complete-sn-analysis').prop('disabled', true);
      $('#complete-sn-analysis').addClass('disabled');

      window.location.href = '<?= $this->Url->build([
                        "controller" => "snow",
                        "action" => "graph"
                      ], true); ?>';
    });

    calibGraph1Object.initTraces();
    calibGraph1Object.setLayout();

    calibGraph2Object.initTraces();
    calibGraph2Object.setLayout();    

    $('#snowAnalysisModal').on('show.bs.modal', function (event) {   
      Plotly.newPlot(calibGraph1, [], null, {displayModeBar: false, responsive:true});         
      Plotly.newPlot(calibGraph2, [], null, {displayModeBar: false, responsive:true});      
      
      getDatasetLength().then(function(response){
        datasetLength = response.datasetLength;

        calibTable = $('#rollingCalibDataTable').DataTable({            
            ajax: {
                url: calibStatsUrl,
                type: "POST",                
                headers: {
                    "X-CSRF-Token": csrfToken 
                },                 
                data: function(d) {
                    d.type = getCalibStatsType()
                }            
            },
            serverSide: true,
            deferLoading: 5,
            searching: false,
            ordering:  false,
            paging: false,
            info: false, 
            processing: true,
            'language':{ 
                "loadingRecords": "&nbsp;",
                "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            },            
            "columnDefs": [
                {               
                    targets: "_all",                         
                    className: "dt-head-center dt-body-center"
                }
            ],
            "scrollX": false,
            dom: 'Bfrtip',
            buttons: [                  
            ],
            "drawCallback": function() {                
            }
        });

        var refreshActive = true;
        var refreshTimer = setInterval(function(){
          // console.log('interval');
          if (!analysisStoppedByUser && refreshActive) {
            refreshActive = false;

            var completionRate = 0;
            getCalibTraceData().then(async function(response) {          
              // console.log('triggered api call');      
              if (response.timeData) {                
                if (response.pair1.trace1Data && response.pair1.trace2Data && response.pair2.trace1Data && response.pair2.trace2Data) {                  
                  function waitForCalibData() {
                    return new Promise((resolve,reject) => {
                      // console.log('reloading calibtable...');
                      $('#rollingCalibDataTable').DataTable().ajax.reload(function(){
                        // console.log('done reloading calibtable...');                
                        resolve();
                      });                                 
                    });                    
                  }

                  completionRate = Math.round(100*(response.timeData.length/datasetLength));
                  completionRate = completionRate <= 99 ? completionRate : 99;                               

                  await waitForCalibData();
                  // console.log('will draw graph now...');
                  if ($("#analysisCompletionRate").html() !== 'COMPLETED') {
                    $("#analysisCompletionRate").html(completionRate + ' %');
                  }                  
                  $("#graphWrapper").show();

                  calibGraph1Object.setTracePair1(response);
                  calibGraph1Object.setLayout();
                  calibGraph1Object.setFig();
                  Plotly.react(calibGraph1, calibGraph1Object.fig);                    

                  calibGraph2Object.setTracePair2(response);
                  calibGraph2Object.setLayout();
                  calibGraph2Object.setFig();
                  Plotly.react(calibGraph2, calibGraph2Object.fig);

                  // do another refresh only if not dataset was completely analysed
                  if (response.timeData && (response.timeData.length == datasetLength)) {
                    refreshActive = false;
                  } else {
                    refreshActive = true;
                  }
                }
                else { // if invalid traces do another refresh 
                  refreshActive = true;
                }
              } else { // if response.timeData invalid do another refresh
                refreshActive = true;
              }              
            });                                                     
          }
        }, 1500);
      });      
      
      $('#calib_type').change(function() {
        getCalibTraceData().then(async function(response) {          
          function waitForCalibData() {
            return new Promise((resolve,reject) => {
              $('#rollingCalibDataTable').DataTable().ajax.reload(function(){
                resolve();
              });                                 
            });                    
          }

          await waitForCalibData();
          
          calibGraph1Object.setTracePair1(response);
          calibGraph1Object.setLayout(getCalibStatsType());
          calibGraph1Object.setFig();
          Plotly.react(calibGraph1, calibGraph1Object.fig);                    

          calibGraph2Object.setTracePair2(response);
          calibGraph2Object.setLayout(getCalibStatsType());
          calibGraph2Object.setFig();
          Plotly.react(calibGraph2, calibGraph2Object.fig);
        });
      });
    });          
  });
</script>
<?php $this->end(); ?>

<?php $this->start('soil_analysis_modal'); ?>
<!-- SOIL ANALYSIS MODAL -->
<div class="modal fade" id="soilAnalysisModal" tabindex="-1" role="dialog" aria-labelledby="soilAnalysisModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="soilAnalysisModalTitle">Performing Water Balance Analysis...</h5>
        <div float="right">
          <h5 class="modal-title" id="analysisCompletionRate">0 %</h5>
        </div>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row borderedSection" id="graphWrapper" style="display:none">
            <div class="col-6">  
              <div id="calibGraph1"></div>              
            </div>
            <div class="col-6">  
              <div id="calibGraph2"></div>              
            </div>
          </div>

          <div class="row borderedSection mt-3 mb-1" id="calibTypeMenu" style="display:none">
            <div class="col-6">
                <div class="mb-1 pl-1">Select time step for calibration stats:</div>
                <select class="custom-select" id="calib_type">
                    <option selected value="1">Daily</option>
                    <option value="2">Monthly</option>                    
                    <option value="10">Seasons</option>
                    <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                        <option value="11">Growing Season</option>
                    <?php } ?>
                    <option value="3">Yearly</option>
                    <option value="21">Typical Year Daily</option>
                    <option value="22">Typical Year Monthly</option>
                    <option value="24">Typical Year Seasons</option>
                    <!-- <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                        <option value="25">Typical Year Growing Season</option>
                    <?php } ?>
                    <option value="23">Typical Year Average</option>                   -->
                </select>
            </div>
          </div>

          <div class="row borderedSection mb-3">
            <div class="col">
              <table class="table display cell-border compact text-center" id="rollingCalibDataTable">
                  <thead>
                      <tr>                        
                          <th scope="col">Statistic</th>                        
                          <th scope="col">Calibration Pair 1</th> 
                          <th scope="col">Calibration Pair 2</th>                       
                      </tr>
                  </thead>
              </table>
            </div>            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="cancel-wb-analysis">STOP ANALYSIS</button>
        <button type="button" class="btn btn-secondary" id="return-wb-analysis" style="display:none">RETURN</button>
        <button type="button" class="btn btn-primary" id="complete-wb-analysis" style="display:none">PROCEED TO RESULTS</button>
      </div>
    </div>
  </div>
</div>

<script>
  var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>; 

  var calibGraph1 = document.getElementById('calibGraph1');     
  var calibGraph2 = document.getElementById('calibGraph2');   
  
  function getCalibStatsType() {
    return $('#calib_type').val();
  }
  
  var graphObjTemplate = {   
      nticks: 6,     
      layout: null,
      fig: null,

      defaultTrace: {
          type: 'scatter',
          mode: 'lines',
          line: {
              width: 1,
          }            
      },

      initTraces: function(){
        // input traces
        this.trace1 = {
            name: 'Model Output',
            yaxis: 'y'
        };

        this.trace2 = {
            name: 'UCD',
            yaxis: 'y'
        };                       
      },        

      setTracePair1: function(response){        
        this.nticks = 6;        

        if (response.timeData && response.timeData.length < this.nticks) {
          this.nticks = response.timeData.length;
        }
        
        $.extend(this.trace1, {
            x: response.timeData,
            y: response.pair1.trace1Data,            
        });
        // console.log(this.trace1);
                
        $.extend(this.trace2, {
            x: response.timeData,
            y: response.pair1.trace2Data,            
        });                      
        // console.log(this.trace2);
      },

      setTracePair2: function(response){        
        this.nticks = 6;       
        
        if (response.timeData && response.timeData.length < this.nticks) {
          this.nticks = response.timeData.length;
        }
        
        $.extend(this.trace1, {
            x: response.timeData,
            y: response.pair2.trace1Data,            
        });
        // console.log(this.trace1);
                
        $.extend(this.trace2, {
            x: response.timeData,
            y: response.pair2.trace2Data,            
        });                      
        // console.log(this.trace2);
      },

      setLayout: function($type){
        var myTickFormat = '%d-%b-%Y';
        if ($type > 2) {
          myTickFormat = null;
        }
      
        // var titleVal = providedTitle;
        var yAxisVal = null;

        this.layout = {
            // title: {
            //     text: providedTitle,
            //     font: "Times New Roman"                    
            // },
            autosize: true,
            xaxis: {                  
                nticks: this.nticks,
                tickformat: myTickFormat,
                // visible: false
            },
            yaxis: {                                  
                // title: yAxisVal,
                // visible: false
            },
            margin: {
                b: 80,
                l: 40,
                r: 40,
                t: 10
            },
            showlegend: true,
            legend: {
                x: 0,
                y: 1.2,                    
            },
            displayModeBar: false
        };
      },

      setFig: function (){
        var traces = [];

        traces.push($.extend({},this.defaultTrace,this.trace1));
        traces.push($.extend({},this.defaultTrace,this.trace2));                   

        this.fig = {
          data: traces,
          layout: this.layout          
        };        
      }
  }

  var calibGraph1Object = $.extend({}, graphObjTemplate);
  var calibGraph2Object = $.extend({}, graphObjTemplate);

  var getCalibTracePairsUrl = "<?= $this->Url->build([
                          'controller' => 'soil',
                          'action' => 'get-calib-trace-pairs'
                        ], true); ?>";

  var getDatasetLengthUrl = "<?= $this->Url->build([
                          'controller' => 'input',
                          'action' => 'get-dataset-length'
                        ], true); ?>";

  function getDatasetLength(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getDatasetLengthUrl,
            type: 'POST',
            data: {
                _csrfToken: csrfToken
            },
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        })
    });
  }

  function getCalibTraceData(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getCalibTracePairsUrl,
            type: 'POST',
            headers: {
                "X-CSRF-Token": csrfToken 
            },                 
            data: {
                type: getCalibStatsType()
            },            
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            },
        })
    });
  }

  var stopActionUrl = "<?= $this->Url->build([
                          'controller' => 'soil',
                          'action' => 'stop-analysis'
                        ], true); ?>";

  var resetActionUrl = "<?= $this->Url->build([
                          'controller' => 'soil',
                          'action' => 'reset-analysis'
                        ], true); ?>";                        

  var calibStatsUrl = "<?= $this->Url->build([
                        'controller' => 'soil',
                        'action' => 'fetch-calib-stats'
                      ], true); ?>";

  function stopAnalysisRequest() {
      return new Promise((resolve, reject) => {
          $.ajax({
              url: stopActionUrl,
              type: 'POST',
              data: {
                  _csrfToken: csrfToken                   
              },
              success: function(response) {
                  resolve(response)
              },
              error: function(error) {
                  reject(error)
              },
          })
      });
  }

  function resetAnalysisRequest() {
      return new Promise((resolve, reject) => {
          $.ajax({
              url: resetActionUrl,
              type: 'POST',
              data: {
                  _csrfToken: csrfToken                   
              },
              success: function(response) {
                  resolve(response)
              },
              error: function(error) {
                  reject(error)
              },
          })
      });
  }
</script>

<script>
  $(document).ready(function() {      
    var calibTable;
    var datasetLength;
    var analysisStoppedByUser = false;

    $("#cancel-wb-analysis").click(function() {
      $('#cancel-wb-analysis').prop('disabled', true);
      $('#cancel-wb-analysis').addClass('disabled');

      analysisStoppedByUser = true;
      stopAnalysisRequest(); // not interested in a return from this
    }); 

    $("#return-wb-analysis").click(function() {
      $('#return-wb-analysis').prop('disabled', true);
      $('#return-wb-analysis').addClass('disabled');

      resetAnalysisRequest().finally(function(){
        window.location.href = '<?= $this->Url->build([
                        "controller" => "soil",
                        "action" => "analysis"
                      ], true); ?>'; 
      });      
    }); 

    $("#complete-wb-analysis").click(function() {
      $('#complete-wb-analysis').prop('disabled', true);
      $('#complete-wb-analysis').addClass('disabled');

      window.location.href = '<?= $this->Url->build([
                        "controller" => "soil",
                        "action" => "graph"
                      ], true); ?>';
    });

    calibGraph1Object.initTraces();
    calibGraph1Object.setLayout();

    calibGraph2Object.initTraces();
    calibGraph2Object.setLayout();    

    $('#soilAnalysisModal').on('show.bs.modal', function (event) {   
      Plotly.newPlot(calibGraph1, [], null, {displayModeBar: false, responsive:true});         
      Plotly.newPlot(calibGraph2, [], null, {displayModeBar: false, responsive:true});      

      getDatasetLength().then(function(response){
        datasetLength = response.datasetLength;

        calibTable = $('#rollingCalibDataTable').DataTable({            
            ajax: {
                url: calibStatsUrl,
                type: "POST",                
                headers: {
                    "X-CSRF-Token": csrfToken 
                }, 
                data: function(d) {
                    d.type = getCalibStatsType()
                }
            },
            serverSide: true,
            deferLoading: 5,
            searching: false,
            ordering:  false,
            paging: false,
            info: false, 
            processing: true,
            'language':{ 
                "loadingRecords": "&nbsp;",
                "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            },            
            "columnDefs": [
                {               
                    targets: "_all",                         
                    className: "dt-head-center dt-body-center"
                }
            ],
            "scrollX": false,
            dom: 'Bfrtip',
            buttons: [                  
            ],
            "drawCallback": function() {                
            }
        });

        var refreshActive = true;
        var refreshTimer = setInterval(function(){
          // console.log('interval');
          if (!analysisStoppedByUser && refreshActive) {
            refreshActive = false;

            var completionRate = 0;
            getCalibTraceData().then(async function(response) {          
              // console.log('triggered api call');      
              if (response.timeData) {                
                if (response.pair1.trace1Data && response.pair1.trace2Data && response.pair2.trace1Data && response.pair2.trace2Data) {                  
                  function waitForCalibData() {
                    return new Promise((resolve,reject) => {
                      // console.log('reloading calibtable...');
                      $('#rollingCalibDataTable').DataTable().ajax.reload(function(){
                        // console.log('done reloading calibtable...');                
                        resolve();
                      });                                 
                    });                    
                  }

                  completionRate = Math.round(100*(response.timeData.length/datasetLength));
                  completionRate = completionRate <= 99 ? completionRate : 99;                               

                  await waitForCalibData();
                  // console.log('will draw graph now...');
                  if ($("#analysisCompletionRate").html() !== 'COMPLETED') {
                    $("#analysisCompletionRate").html(completionRate + ' %');
                  }
                  $("#graphWrapper").show();

                  calibGraph1Object.setTracePair1(response);
                  calibGraph1Object.setLayout();
                  calibGraph1Object.setFig();
                  Plotly.react(calibGraph1, calibGraph1Object.fig);                    

                  calibGraph2Object.setTracePair2(response);
                  calibGraph2Object.setLayout();
                  calibGraph2Object.setFig();
                  Plotly.react(calibGraph2, calibGraph2Object.fig);

                  // do another refresh only if not dataset was completely analysed
                  if (response.timeData && (response.timeData.length == datasetLength)) {
                    refreshActive = false;
                  } else {
                    refreshActive = true;
                  }
                }
                else { // if invalid traces do another refresh 
                  refreshActive = true;
                }
              } else { // if response.timeData invalid do another refresh
                refreshActive = true;
              }              
            });                                                     
          }
        }, 1500);
      });        

      $('#calib_type').change(function() {
        getCalibTraceData().then(async function(response) {          
          function waitForCalibData() {
            return new Promise((resolve,reject) => {
              $('#rollingCalibDataTable').DataTable().ajax.reload(function(){
                resolve();
              });                                 
            });                    
          }

          await waitForCalibData();
          
          calibGraph1Object.setTracePair1(response);
          calibGraph1Object.setLayout(getCalibStatsType());
          calibGraph1Object.setFig();
          Plotly.react(calibGraph1, calibGraph1Object.fig);                    

          calibGraph2Object.setTracePair2(response);
          calibGraph2Object.setLayout(getCalibStatsType());
          calibGraph2Object.setFig();
          Plotly.react(calibGraph2, calibGraph2Object.fig);
        });
      });
    });          
  });
</script>
<?php $this->end(); ?>