<div class="row my-5 px-5">
    <div class="col-9">        
        <div class="mb-1 pl-1">Select time step below:</div>
        <select class="custom-select" id="graph_source">
            <option selected value="1">Water Balance - Daily</option>
            <option value="2">Water Balance - Monthly</option>
            <option value="10">Water Balance - Seasons</option>
        <?php if ($this->isSetGrowthSeason->getFlag()){ ?>
            <option value="11">Water Balance - Growing Season</option>
        <?php } ?>
            <option value="3">Water Balance - Yearly</option>                                
            <option value="21">Water Balance - Typical Year Daily</option>
            <option value="22">Water Balance - Typical Year Monthly</option>
            <option value="24">Water Balance - Typical Year Seasons</option>
        <?php if ($this->isSetGrowthSeason->getFlag()){ ?>
            <option value="25">Water Balance - Typical Year Growing Season</option>
        <?php } ?>
            <option value="23">Water Balance - Typical Year Average</option> 
        </select>
    </div>
</div>

<div id="graphWrapper" class="row my-5" style="display:none">
    <div class="col-sm-9" id="graphContainer">        
        <div id="myGraph"></div>
    </div>

    <div class="col-sm-3">
        <table class="table table-borderless table-sm px-5 graph-params">
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="precip-check" checked>
                            <label class="custom-control-label" for="precip-check">Precipitation</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="precip-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="sm-check">
                            <label class="custom-control-label" for="sm-check">Soil Water Content</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="sm-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="et-check">
                            <label class="custom-control-label" for="et-check">Evapotr.</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="et-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="rch-check">
                            <label class="custom-control-label" for="rch-check">Groundwater Recharge</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="rch-axis">                            
                        </div>
                    </td>                   
                </tr>
            </tbody>
        </table>

        <hr/>   
        
        <table class="table table-borderless table-sm px-5 graph-params">
            <tbody>
                <!-- <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vwc-check">
                            <label class="custom-control-label" for="vwc-check">Volumetric Water Content</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vwc-axis">                            
                        </div>
                    </td>                   
                </tr> -->

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="h20-check">
                            <label class="custom-control-label" for="h20-check">SWC in Soil</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="h20-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="drain-check">
                            <label class="custom-control-label" for="drain-check">Drainage</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="drain-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="inf-check">
                            <label class="custom-control-label" for="inf-check">Infiltration</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="inf-axis">                            
                        </div>
                    </td>                   
                </tr>

                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="sr-check">
                            <label class="custom-control-label" for="sr-check">Surface Runoff</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="sr-axis">                            
                        </div>
                    </td>                   
                </tr>
            </tbody>
        </table>
    
    <?php if ($nValidationColumns > 0) { ?>
        <hr/>

        <table class="table table-borderless table-sm px-5 graph-params">
            <tbody>                
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vd1-check">
                            <label class="custom-control-label" for="vd1-check">Validation 1</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vd1-axis">                            
                        </div>
                    </td>                   
                </tr>                            

            <?php if ($nValidationColumns > 1) { ?>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vd2-check">
                            <label class="custom-control-label" for="vd2-check">Validation 2</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vd2-axis">                            
                        </div>
                    </td>                   
                </tr>                
            <?php } ?>

            <?php if ($nValidationColumns > 2) { ?>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vd3-check">
                            <label class="custom-control-label" for="vd3-check">Validation 3</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vd3-axis">                            
                        </div>
                    </td>                   
                </tr>                
            <?php } ?>

            <?php if ($nValidationColumns > 3) { ?>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vd4-check">
                            <label class="custom-control-label" for="vd4-check">Validation 4</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vd4-axis">                            
                        </div>
                    </td>                   
                </tr>                
            <?php } ?>

            <?php if ($nValidationColumns > 4) { ?>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox text-left">
                            <input type="checkbox" class="custom-control-input" id="vd5-check">
                            <label class="custom-control-label" for="vd5-check">Validation 5</label>
                        </div>
                    </td>
                    <td>
                        <div class="custom-control custom-switch text-right">
                            <input type="checkbox" class="custom-control-input y-axis" id="vd5-axis">                            
                        </div>
                    </td>                   
                </tr>                
            <?php } ?>

            </tbody>
        </table>      
    <?php } ?>
        
    </div>
</div>

<div class="row my-5 px-5" id="statisticsWrapper">
    <div class="col-12">                
        <div class="row pt-5">
            <div class="col text-left subsectionTitle">
                <h5>Water Balance Statistics (full dataset)</h5>
            </div>
        </div>

        <table class="table display cell-border compact text-center mt-3" id="statsDataTable" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Statistic</th>                       
                    <th scope="col">SWC in Soil (mm)</th>
                    <th scope="col">Precip (mm)</th>
                    <th scope="col">ET Total (mm)</th>
                    <th scope="col">ET Above Ground (mm)</th>
                    <th scope="col">ET From Soil (mm)</th>
                    <th scope="col">Net Loss (mm)</th>
                    <th scope="col">Net Gain (mm)</th>
                    <th scope="col">Drainage (mm)</th>
                    <th scope="col">Infiltr. (mm)</th>
                    <th scope="col">Surf. Runoff (mm)</th>               
                </tr>
            </thead>        
        </table>    
    </div>
</div>

<script>
    var myGraph = document.getElementById('myGraph');     

    var inputGraphObj = {   
        nticks: 12,     
        layout: null,
        fig: null,
        graphTypeCode: null,
        graphType: null,
        graphSource: null, 

        defaultTrace: {
            type: 'scatter',
            mode: 'lines',
            line: {
                width: 1,
            }
        },

        setLayout: function(source){
            var myTickFormat = null;
            switch(parseInt(source)){
                case 1:
                    myTickFormat = '%d-%b-%Y';
                    break;                
                case 21:
                    myTickFormat = '%d-%b';
                    break;                
                default:
                    myTickFormat = null;                   
            }  
          
            var titleVal = 'Water Balance';
            var yAxisVal = null;
            var yAxis2Val = null;             

            this.layout = {
                title: {
                    text: titleVal,
                    font: "Times New Roman"                    
                },
                autosize: true,
                // width: window.innerWidth*0.66,
                // width: $("#graphContainer").width()/2,
                xaxis: {                  
                    // title: 'Date',
                    nticks: this.nticks,
                    tickformat: myTickFormat     
                },
                yaxis: {                                  
                    title: yAxisVal        
                },
                yaxis2: {
                    title: yAxis2Val,
                    overlaying: 'y',
                    side: 'right'
                },
                margin: {
                    pad: 10
                },
                showlegend: true,
                legend: {
                    x: 0,
                    y: 1.5,                    
                }
            };
        },

        setFig: function (){
            var traces = [];

            if (this.graphTypeCode & 1){                
                traces.push($.extend({},this.defaultTrace,this.trace4));
            }

            if (this.graphTypeCode & 2){                
                traces.push($.extend({},this.defaultTrace,this.trace3));
            }

            if (this.graphTypeCode & 4){                
                traces.push($.extend({},this.defaultTrace,this.trace2));
            }

            if (this.graphTypeCode & 8){
                traces.push($.extend({},this.defaultTrace,this.trace1));
            }                       
            
            if (this.graphTypeCode & 16){
                traces.push($.extend({},this.defaultTrace,this.trace5));                
            }

            if (this.graphTypeCode & 32){                
                traces.push($.extend({},this.defaultTrace,this.trace6));
            }

            if (this.graphTypeCode & 64){
                traces.push($.extend({},this.defaultTrace,this.trace7));                
            }

            if (this.graphTypeCode & 128){                
                traces.push($.extend({},this.defaultTrace,this.trace8));
            } 

            if (this.graphTypeCode & 256){                
                traces.push($.extend({},this.defaultTrace,this.trace9));
            } 

            if (this.graphTypeCode & 512){                
                traces.push($.extend({},this.defaultTrace,this.vd1));
            }

            if (this.graphTypeCode & 1024){
                traces.push($.extend({},this.defaultTrace,this.vd2));
            }

            if (this.graphTypeCode & 2048){
                traces.push($.extend({},this.defaultTrace,this.vd3));
            }

            if (this.graphTypeCode & 4096){
                traces.push($.extend({},this.defaultTrace,this.vd4));
            }

            if (this.graphTypeCode & 8192){
                traces.push($.extend({},this.defaultTrace,this.vd5));
            }
            // console.log('fig updated w traces', traces);           

            this.fig = {
                data: traces,
                layout: this.layout
            };
        },   
        
        initTraces: function(){
            this.trace1 = {            
                name: 'Precipitation (mm)',
                yaxis: 'y'
            };
            
            this.trace2 = {            
                name: 'Soil Water Content (m<sup>3</sup>/m<sup>3</sup>)',
                yaxis: 'y'
            };

            this.trace3 = {            
                name: 'Evapotr. (mm)',
                yaxis: 'y'
            };

            this.trace4 = {            
                name: 'Groundwater Recharge (mm)',
                yaxis: 'y'
            };

            this.trace5 = {            
                name: 'Volumetric Water Content (%)',
                yaxis: 'y'
            };
            
            this.trace6 = {            
                name: 'SWC in Soil (mm)',
                yaxis: 'y'
            };

            this.trace7 = {            
                name: 'Drainage (mm)',
                yaxis: 'y'
            };

            this.trace8 = {            
                name: 'Infiltration (mm)',
                yaxis: 'y'
            };

            this.trace9 = {            
                name: 'Surface Runoff (mm)',
                yaxis: 'y'
            };

            this.vd1 = {           
                name: 'Validation 1',
                yaxis: 'y'
            };

            this.vd2 = {           
                name: 'Validation 2',
                yaxis: 'y'
            };

            this.vd3 = {           
                name: 'Validation 3',
                yaxis: 'y'
            };

            this.vd4 = {           
                name: 'Validation 4',
                yaxis: 'y'
            };

            this.vd5 = {           
                name: 'Validation 5',
                yaxis: 'y'
            };
        },        

        setTrace: function(elem, response){
            var newTrace = {
                y: response.data
            };

            // console.log('set trace for elem ' + elem);

            switch(elem){
                case 'precip-check':                    
                    // this.trace1 = $.extend({}, {...newTrace,...this.trace1};
                    $.extend(this.trace1, newTrace);
                    break;
                case 'sm-check':                    
                    $.extend(this.trace2, newTrace);
                    break;
                case 'et-check':
                    $.extend(this.trace3, newTrace);
                    break;
                case 'rch-check':
                    $.extend(this.trace4, newTrace);
                    break;
                case 'vwc-check':                    
                    $.extend(this.trace5, newTrace);
                    break;
                case 'h20-check':
                    $.extend(this.trace6, newTrace);
                    break;
                case 'drain-check':
                    $.extend(this.trace7, newTrace);
                    break;
                case 'inf-check':
                    $.extend(this.trace8, newTrace);
                    break;
                case 'sr-check':
                    $.extend(this.trace9, newTrace);
                    break;
                case 'vd1-check':
                    $.extend(this.vd1, newTrace);
                    break;
                case 'vd2-check':
                    $.extend(this.vd2, newTrace);
                    break;
                case 'vd3-check':
                    $.extend(this.vd3, newTrace);
                    break;
                case 'vd4-check':
                    $.extend(this.vd4, newTrace);
                    break;
                case 'vd5-check':
                    $.extend(this.vd5, newTrace);
                    break;
            }
        },

        setTimeData: function(response){
            var newTrace = {
                x: response.data
            };
            
            this.nticks = 12;
            // refresh the number of ticks if needed
            if (response.data.length < this.nticks){
                this.nticks = response.data.length;
            }

            $.extend(this.defaultTrace, newTrace);                        
            // console.log('setting time data', this.defaultTrace);
        },

        setGraphSource: function(sourceId){
            this.graphSource = sourceId;
        },

        resetGraphCode: function(){
            this.graphTypeCode = 0;
        },

        toggleGraphAxis: function(elem){           
            // console.log('changing axis for ' + elem);

            switch(elem){
                case 'precip-axis':                    
                    if (!this.trace1.yaxis.localeCompare('y2')){
                        this.trace1.yaxis = 'y';
                    } else {
                        this.trace1.yaxis = 'y2';
                    }
                    // console.log(this.trace1);
                    break;
                case 'sm-axis':                    
                    if (!this.trace2.yaxis.localeCompare('y2')){
                        this.trace2.yaxis = 'y';
                    } else {
                        this.trace2.yaxis = 'y2';
                    }
                    // console.log(this.trace2);
                    break;
                case 'et-axis':
                    if (!this.trace3.yaxis.localeCompare('y2')){
                        this.trace3.yaxis = 'y';
                    } else {
                        this.trace3.yaxis = 'y2';
                    }
                    // console.log(this.trace3);
                    break;
                case 'rch-axis':
                    if (!this.trace4.yaxis.localeCompare('y2')){
                        this.trace4.yaxis = 'y';
                    } else {
                        this.trace4.yaxis = 'y2';
                    }
                    // console.log(this.trace4);
                    break;  
                case 'vwc-axis':                    
                    if (!this.trace5.yaxis.localeCompare('y2')){
                        this.trace5.yaxis = 'y';
                    } else {
                        this.trace5.yaxis = 'y2';
                    }
                    // console.log(this.trace5);                    
                    break;
                case 'h20-axis':
                    if (!this.trace6.yaxis.localeCompare('y2')){
                        this.trace6.yaxis = 'y';
                    } else {
                        this.trace6.yaxis = 'y2';
                    }
                    // console.log(this.trace6);
                    break;
                case 'drain-axis':
                    if (!this.trace7.yaxis.localeCompare('y2')){
                        this.trace7.yaxis = 'y';
                    } else {
                        this.trace7.yaxis = 'y2';
                    }
                    // console.log(this.trace7);
                    break;
                case 'inf-axis':
                    if (!this.trace8.yaxis.localeCompare('y2')){
                        this.trace8.yaxis = 'y';
                    } else {
                        this.trace8.yaxis = 'y2';
                    }
                    // console.log(this.trace8);
                    break;
                case 'sr-axis':
                    if (!this.trace9.yaxis.localeCompare('y2')){
                        this.trace9.yaxis = 'y';
                    } else {
                        this.trace9.yaxis = 'y2';
                    }
                    // console.log(this.trace9);
                    break;
                case 'vd1-axis':
                    if (!this.vd1.yaxis.localeCompare('y2')){
                        this.vd1.yaxis = 'y';
                    } else {
                        this.vd1.yaxis = 'y2';
                    }
                    // console.log(this.vd1);
                    break;
                case 'vd2-axis':
                    if (!this.vd2.yaxis.localeCompare('y2')){
                        this.vd2.yaxis = 'y';
                    } else {
                        this.vd2.yaxis = 'y2';
                    }
                    // console.log(this.vd2);
                    break;
                case 'vd3-axis':
                    if (!this.vd3.yaxis.localeCompare('y2')){
                        this.vd3.yaxis = 'y';
                    } else {
                        this.vd3.yaxis = 'y2';
                    }
                    // console.log(this.vd3);
                    break;
                case 'vd4-axis':
                    if (!this.vd4.yaxis.localeCompare('y2')){
                        this.vd4.yaxis = 'y';
                    } else {
                        this.vd4.yaxis = 'y2';
                    }
                    // console.log(this.vd4);
                    break;
                case 'vd5-axis':
                    if (!this.vd5.yaxis.localeCompare('y2')){
                        this.vd5.yaxis = 'y';
                    } else {
                        this.vd5.yaxis = 'y2';
                    }
                    // console.log(this.vd5);
                    break;
            }
        },

        toggleGraphType: function(elem){
            var enabled = false;

            this.graphType = elem;
            switch(elem){
                case 'precip-check':
                    this.graphTypeCode = this.graphTypeCode ^ 8;      
                    enabled = $("#precip-check").prop('checked');          
                    break;
                case 'sm-check':
                    this.graphTypeCode = this.graphTypeCode ^ 4; 
                    enabled = $("#sm-check").prop('checked');                   
                    break;
                case 'et-check':
                    this.graphTypeCode = this.graphTypeCode ^ 2; 
                    enabled = $("#et-check").prop('checked');                   
                    break;
                case 'rch-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 1; 
                    enabled = $("#rch-check").prop('checked');                   
                    break;
                case 'vwc-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 16;
                    enabled = $("#vwc-check").prop('checked');                    
                    break;
                case 'h20-check':
                    this.graphTypeCode = this.graphTypeCode ^ 32;
                    enabled = $("#h20-check").prop('checked');                    
                    break;
                case 'drain-check':
                    this.graphTypeCode = this.graphTypeCode ^ 64;
                    enabled = $("#drain-check").prop('checked');                    
                    break;
                case 'inf-check':
                    this.graphTypeCode = this.graphTypeCode ^ 128
                    enabled = $("#inf-check").prop('checked');;                    
                    break;
                case 'sr-check':
                    this.graphTypeCode = this.graphTypeCode ^ 256
                    enabled = $("#sr-check").prop('checked');;                    
                    break;
                case 'vd1-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 512; 
                    enabled = $("#vd1-check").prop('checked');                   
                    break;
                case 'vd2-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 1024; 
                    enabled = $("#vd2-check").prop('checked');                   
                    break;
                case 'vd3-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 2048; 
                    enabled = $("#vd3-check").prop('checked');                   
                    break;
                case 'vd4-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 4096; 
                    enabled = $("#vd4-check").prop('checked');                   
                    break;
                case 'vd5-check':                    
                    this.graphTypeCode = this.graphTypeCode ^ 8192; 
                    enabled = $("#vd5-check").prop('checked');                   
                    break;
            }           

            return enabled;
        },

        refreshGraph: function(enabled){
            var that = this;
            // console.log('refreshing graph type ' + that.graphType);

            if (enabled){ // only request trace data from server if trace is added
                getTraceData(that.graphSource, that.graphType).then(function(response){
                    $('#graphWrapper').show();
                    inputGraphObj.setTrace(that.graphType, response);
                    inputGraphObj.setLayout(that.graphSource);
                    inputGraphObj.setFig();
                    Plotly.newPlot(myGraph, inputGraphObj.fig);                    
                }).catch(function(error){
                    // console.log(error);
                });            
            } else {                              
                inputGraphObj.setLayout(that.graphSource);
                inputGraphObj.setFig();
                Plotly.newPlot(myGraph, inputGraphObj.fig);
            }
        }
    }                    

    function getTraceData(source, elem){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'get-trace-data',
                type: 'POST',
                data: {
                    _csrfToken: <?= json_encode($this->request->getParam('_csrfToken')) ?>,
                    graphSource: source,
                    graphType: elem
                },
                success: function (response) {
                    resolve(response)
                },
                error: function (error) {
                    reject(error)
                },
            })
        });
    }

    function getTimeData(graphSource){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'get-time-data',
                type: 'POST',
                data: {
                    _csrfToken: <?= json_encode($this->request->getParam('_csrfToken')) ?>,
                    graphSource: graphSource                 
                },
                success: function (response) {
                    resolve(response)
                },
                error: function (error) {
                    reject(error)
                },
            })
        });
    }                  
</script>

<script type="module">
    $(document).ready( function () {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;

        // stats table
        $('#statsDataTable').DataTable({            
            ajax: {
                url: "fetch-output-data-stats",
                type: "POST",
                headers: {
                    "X-CSRF-Token": csrfToken 
                },                
            },
            searching: false,
            ordering:  false,
            paging: false,
            info: false,            
            "columnDefs": [
                {               
                    targets: "_all",                         
                    className: "dt-head-center dt-body-center"
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'swib_balanceStats_' + now;
                    }
                },
                // {
                //     extend: 'excel',
                //     title: 'water_balance_stats_xlsx'
                // }                
            ]
        });

        // switches
        $(".y-axis").bootstrapSwitch('size', 'small');
        $(".y-axis").bootstrapSwitch('onText', 'Left');
        $(".y-axis").bootstrapSwitch('offText', 'Right');
        $(".y-axis").bootstrapSwitch('labelText', 'Axis');
        $(".y-axis").bootstrapSwitch('offColor', 'success');
        $(".y-axis").bootstrapSwitch('state', true);  

        // graph stuff - initialized for source 1 (input daily) and type precip-check
        getTimeData(1).then(function(response){
            inputGraphObj.initTraces();
            inputGraphObj.setTimeData(response);                        
            inputGraphObj.setGraphSource(1);
            inputGraphObj.resetGraphCode();            
            inputGraphObj.toggleGraphType('precip-check');            
            inputGraphObj.refreshGraph(true);
        }).catch(function(error){
            // console.log(error);
        });                            

        // toggle Graph Source
        $('#graph_source').change(function(){
            var graphSource = $(this).val();
            // console.log('new source ' + graphSource);

            if (graphSource > 1){
                $("#statisticsWrapper").hide();
            } else {
                $("#statisticsWrapper").show();
            }
            
            $(':checkbox').prop('checked', false);
            $("#precip-check").prop('checked', true);

            getTimeData(graphSource).then(function(response){                        
                inputGraphObj.setTimeData(response);            
                inputGraphObj.setGraphSource(graphSource);   
                inputGraphObj.resetGraphCode();
                inputGraphObj.toggleGraphType('precip-check');            
                inputGraphObj.refreshGraph(true);
            }).catch(function(error){
                // console.log(error);
            }); 
        });

        // toggle Graph Type
        $(':checkbox').change(function(){
            // console.log('new trace ' + $(this).attr('id'));

            var enabledTrace = inputGraphObj.toggleGraphType($(this).attr('id'));    
            inputGraphObj.refreshGraph(enabledTrace);      
        });

        // toggle Axis
        $(".y-axis").on('switchChange.bootstrapSwitch', function(e, data) { 
            // console.log($(this).attr('id') + ' state :' + $(this).bootstrapSwitch('state'));

            inputGraphObj.toggleGraphAxis($(this).attr('id'));
            inputGraphObj.refreshGraph(true);    
        }); 
    });
</script>