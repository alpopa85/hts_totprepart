<div class="row mt-3 px-5">
    <div class="col-4">                
        <button id="graph_btn" class="btn btn-large btn-primary w-100"><i class="fa fa-area-chart" aria-hidden="true"></i> Graph</button>  
    </div>

    <div class="col-4">
        <button id="stats_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-search" aria-hidden="true"></i> Stats</button>        
    </div> 
    
    <div class="col-4">
        <button id="calib_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-calculator" aria-hidden="true"></i> Calibration Stats</button>        
    </div> 
</div>

<div id="graph_content">
    <div class="row mt-3 px-5">
        <div class="col-6">
            <div class="mb-1 pl-1">Select time step below:</div>
            <select class="custom-select" id="graph_source">
                <option selected value="1">Snow - Daily</option>
                <option value="2">Snow - Monthly</option>
                <option value="10">Snow - Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()){ ?>
                <option value="11">Snow - Growing Season</option>
            <?php } ?>
                <option value="3">Snow - Yearly</option>                                
                <option value="21">Snow - Typical Year Daily</option>
                <option value="22">Snow - Typical Year Monthly</option>
                <option value="24">Snow - Typical Year Seasons</option>
            <?php if ($this->isSetGrowthSeason->getFlag()){ ?>
                <option value="25">Snow - Typical Year Growing Season</option>
            <?php } ?>
                <option value="23">Snow - Typical Year Average</option>
        </select>
        </div>
    </div>
    
    <div id="graphWrapper" class="row borderedSection my-3 mx-5" style="display:none">
        <div class="col-sm-3 offset-1">
            <table class="table table-borderless table-sm px-5 graph-params">
                <caption style="text-align:left; caption-side:top">Input Data</caption>
                <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="temp-check" checked>
                                <label class="custom-control-label" for="temp-check"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="temp-axis">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="precip-check">
                                <label class="custom-control-label" for="precip-check"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></label>
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
                                <input type="checkbox" class="custom-control-input" id="rain-check">
                                <label class="custom-control-label" for="rain-check"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="rain-axis">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="et-check">
                                <label class="custom-control-label" for="et-check"><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="et-axis">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php if ($nValidationColumns > 0) { ?>
        <div class="col-sm-2 offset-1">            
            <table class="table table-borderless table-sm px-5 graph-params">
                <caption style="text-align:left; caption-side:top">Validation Data</caption>
                <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="ucd1-check">
                                <label class="custom-control-label" for="ucd1-check"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD1</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="ucd1-axis">
                            </div>
                        </td>
                    </tr>

                    <?php if ($nValidationColumns > 1) { ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-left">
                                    <input type="checkbox" class="custom-control-input" id="ucd2-check">
                                    <label class="custom-control-label" for="ucd2-check"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD2</span></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch text-right">
                                    <input type="checkbox" class="custom-control-input y-axis" id="ucd2-axis">
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if ($nValidationColumns > 2) { ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-left">
                                    <input type="checkbox" class="custom-control-input" id="ucd3-check">
                                    <label class="custom-control-label" for="ucd3-check"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD3</span></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch text-right">
                                    <input type="checkbox" class="custom-control-input y-axis" id="ucd3-axis">
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if ($nValidationColumns > 3) { ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-left">
                                    <input type="checkbox" class="custom-control-input" id="ucd4-check">
                                    <label class="custom-control-label" for="ucd4-check"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD4</span></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch text-right">
                                    <input type="checkbox" class="custom-control-input y-axis" id="ucd4-axis">
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if ($nValidationColumns > 4) { ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox text-left">
                                    <input type="checkbox" class="custom-control-input" id="ucd5-check">
                                    <label class="custom-control-label" for="ucd5-check"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD5</span></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch text-right">
                                    <input type="checkbox" class="custom-control-input y-axis" id="ucd5-axis">
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
        <?php } ?>

        <div class="col-sm-3 offset-1" id="graph_type_wrapper">            
            <table class="table table-borderless table-sm px-5 graph-params">
                <caption style="text-align:left; caption-side:top">Output Data</caption>
                <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="snow-check">
                                <label class="custom-control-label" for="snow-check"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="snow-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="rssl-check">
                                <label class="custom-control-label" for="rssl-check"><span data-toggle="tooltip" title="<?= $tooltips['RSSL'] ?>">RSSL</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="rssl-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="tdsm-check">
                                <label class="custom-control-label" for="tdsm-check"><span data-toggle="tooltip" title="<?= $tooltips['SNMT'] ?>">SNMT</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="tdsm-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="rdsm-check">
                                <label class="custom-control-label" for="rdsm-check"><span data-toggle="tooltip" title="<?= $tooltips['SNMR'] ?>">SNMR</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="rdsm-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="snow_acc-check">
                                <label class="custom-control-label" for="snow_acc-check"><span data-toggle="tooltip" title="<?= $tooltips['SNTFmm'] ?>">SNTFmm</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="snow_acc-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="snowmelt-check">
                                <label class="custom-control-label" for="snowmelt-check"><span data-toggle="tooltip" title="<?= $tooltips['SNMF'] ?>">SNMF</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="snowmelt-axis">                            
                            </div>
                        </td>                   
                    </tr>                
                    
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="water_or_sr-check">
                                <label class="custom-control-label" for="water_or_sr-check"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="water_or_sr-axis">                            
                            </div>
                        </td>                   
                    </tr>

                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox text-left">
                                <input type="checkbox" class="custom-control-input" id="snow_calc-check">
                                <label class="custom-control-label" for="snow_calc-check"><span data-toggle="tooltip" title="<?= $tooltips['SNTFcm'] ?>">SNTFcm</span></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch text-right">
                                <input type="checkbox" class="custom-control-input y-axis" id="snow_calc-axis">                            
                            </div>
                        </td>                   
                    </tr>
                </tbody>
            </table>                
        </div>

        <div class="col px-3" id="graphContainer">
            <div id="myGraph"></div>
        </div>
    </div>
</div>

<div id="stats_content" style="display:none">
    <div class="row borderedSection my-3 mx-5" id="statisticsWrapper">
        <div class="col-12">
            <div class="row pt-2">
                <div class="col text-left">
                    <h5>Snow Statistics <span id="stats_interval_details"></span></h5>
                </div>
            </div>

            <div class="row py-2">
                <div class="col-3 text-left">
                    <button type="button" class="btn btn-danger" id="reset-filter">Show Complete Dataset Stats</button>
                </div>

                <div class="col-3 text-right">
                    <button type="button" class="btn btn-primary" id="run-filter" disabled>Show Stats by Interval</button>
                </div>

                <div class="col-3 col-xl-2">
                    <input class="coverFullDiv" type="text" id="start_date_filter" placeholder="Start Date (YYYY-MM-DD)" />
                </div>

                <div class="col-3 col-xl-2">
                    <input class="coverFullDiv" type="text" id="end_date_filter" placeholder="End Date (YYYY-MM-DD)" />
                </div>
            </div>
    
            <div class="row py-1 pt-3">
                <div class="col-12 d-flex justify-content-left">            
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="2"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="3"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="4"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></a>
                </div>
            </div>

            <div class="row py-1">
                <div class="col-12 d-flex justify-content-left">            
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="5"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="6"><span data-toggle="tooltip" title="<?= $tooltips['RAINS'] ?>">RAINS</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="7"><span data-toggle="tooltip" title="<?= $tooltips['RAINNS'] ?>">RAINNS</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="8"><span data-toggle="tooltip" title="<?= $tooltips['SNOA'] ?>">SNOA</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="9"><span data-toggle="tooltip" title="<?= $tooltips['SNOM'] ?>">SNOM</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="10"><span data-toggle="tooltip" title="<?= $tooltips['RSSL'] ?>">RSSL</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="11"><span data-toggle="tooltip" title="<?= $tooltips['RSI'] ?>">RSI</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="12"><span data-toggle="tooltip" title="<?= $tooltips['SNMT'] ?>">SNMT</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="13"><span data-toggle="tooltip" title="<?= $tooltips['SNMR'] ?>">SNMR</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="14"><span data-toggle="tooltip" title="<?= $tooltips['SNTFmm'] ?>">SNTFmm</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="15"><span data-toggle="tooltip" title="<?= $tooltips['SNMF'] ?>">SNMF</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="16"><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="17"><span data-toggle="tooltip" title="<?= $tooltips['ETasi'] ?>">ETasi</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="18"><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="19"><span data-toggle="tooltip" title="<?= $tooltips['ETasf'] ?>">ETasf</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="20"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span></a>
                    <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="21"><span data-toggle="tooltip" title="<?= $tooltips['SNTFcm'] ?>">SNTFcm</span></a>
                </div>        
            </div>

            <?php if ($nValidationColumns > 0) { ?>
            <div class="row py-1">
                <div class="col-12 d-flex justify-content-left">
                    <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                        switch ($i) {
                            case 0:
                                $colName = 'UCD1';
                                break;
                            case 1:
                                $colName = 'UCD2';
                                break;
                            case 2:
                                $colName = 'UCD3';
                                break;
                            case 3:
                                $colName = 'UCD4';
                                break;
                            case 4:
                                $colName = 'UCD5';
                                break;
                        }
                    ?>
                        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="<?= 22+$i ?>"><span data-toggle="tooltip" title="<?= $tooltips[$colName] ?>"><?= $colName ?></span></a>
                    <?php } ?>            
                </div>
            </div>
            <?php } ?>    

            <div>&nbsp;</div>

            <table class="table display cell-border compact text-center" id="statsDataTable">
                <thead>
                    <tr>
                        <th scope="col">Statistic<br /><span id="stat_type"></th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAINS'] ?>">RAINS</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAINNS'] ?>">RAINNS</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOA'] ?>">SNOA</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOM'] ?>">SNOM</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RSSL'] ?>">RSSL</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RSI'] ?>">RSI</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNMT'] ?>">SNMT</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNMR'] ?>">SNMR</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNTFmm'] ?>">SNTFmm</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNMF'] ?>">SNMF</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETasi'] ?>">ETasi</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETasf'] ?>">ETasf</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNTFcm'] ?>">SNTFcm</span> (cm)</th>

                        <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                            switch ($i) {
                                case 0:
                                    $colName = 'UCD1';
                                    break;
                                case 1:
                                    $colName = 'UCD2';
                                    break;
                                case 2:
                                    $colName = 'UCD3';
                                    break;
                                case 3:
                                    $colName = 'UCD4';
                                    break;
                                case 4:
                                    $colName = 'UCD5';
                                    break;
                            }
                        ?>
                            <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips[$colName] ?>"><?= $colName ?></span></th>
                        <?php } ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="calib_content" style="display:none">
    <div class="row borderedSection my-3 mx-5" id="calibrationWrapper">
        <div class="col-12">            
            <table class="table display cell-border compact text-center" id="calibDataTable">
                <thead>
                    <tr>                        
                        <th scope="col">Statistic</th>                        
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips[$calibration['output1_field']] ?>"><?= $calibration['output1_field']?></span> vs <span data-toggle="tooltip" title="<?= $tooltips[$calibration['ucd1_field']] ?>"><?= $calibration['ucd1_field']?></span></th> 
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips[$calibration['output2_field']] ?>"><?= $calibration['output2_field']?></span> vs <span data-toggle="tooltip" title="<?= $tooltips[$calibration['ucd2_field']] ?>"><?= $calibration['ucd2_field']?></span></th>                       
                    </tr>
                </thead>
            </table>
        </div>
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

        defaultLineTrace: {
            type: 'scatter',
            mode: 'lines',
            line: {
                width: 1,
            }
        },

        defaultBarTrace: {
            type: 'bar'
        },

        getDefaultTrace: function(source) {
            switch (parseInt(source)){                
                case 1:
                case 21:                              
                default:
                    return this.defaultLineTrace;
                    break;
                // default:  
                //     return this.defaultBarTrace;
                //     break;                
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
          
            var titleVal = 'Snow';
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

            if (this.graphTypeCode & Math.pow(2,0)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace4));
            }

            if (this.graphTypeCode & Math.pow(2,1)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace3));
            }

            if (this.graphTypeCode & Math.pow(2,2)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace2));
            }

            if (this.graphTypeCode & Math.pow(2,3)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace1));
            }                       
            
            if (this.graphTypeCode & Math.pow(2,4)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace5));                
            }

            if (this.graphTypeCode & Math.pow(2,5)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace6));
            }

            if (this.graphTypeCode & Math.pow(2,6)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace7));                
            }

            if (this.graphTypeCode & Math.pow(2,7)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace8));
            } 

            if (this.graphTypeCode & Math.pow(2,8)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace9));
            } 

            if (this.graphTypeCode & Math.pow(2,9)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace10));
            }

            if (this.graphTypeCode & Math.pow(2,10)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace11));                
            }

            if (this.graphTypeCode & Math.pow(2,11)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace12));
            } 

            if (this.graphTypeCode & Math.pow(2,12)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.trace13));
            }

            if (this.graphTypeCode & Math.pow(2,13)){                
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.vd1));
            }

            if (this.graphTypeCode & Math.pow(2,14)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.vd2));
            }

            if (this.graphTypeCode & Math.pow(2,15)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.vd3));
            }

            if (this.graphTypeCode & Math.pow(2,16)){
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource),this.vd4));
            }           

            if (this.graphTypeCode & Math.pow(2,17)) {
                traces.push($.extend({},inputGraphObj.getDefaultTrace(this.graphSource), this.vd5));
            }

            this.fig = {
                data: traces,
                layout: this.layout
            };
        },   
        
        initTraces: function(){
            // input traces
            this.trace1 = {
                name: 'TEMP (&deg;C)',
                yaxis: 'y'
            };

            this.trace2 = {
                name: 'TOTPP (mm)',
                yaxis: 'y'
            };

            this.trace3 = {
                name: 'RAIN (mm)',
                yaxis: 'y'
            };

            this.trace4 = {
                name: 'ETA (mm)',
                yaxis: 'y'
            };

            // validation traces
            this.vd1 = {
                name: 'UCD1',
                yaxis: 'y'
            };

            this.vd2 = {
                name: 'UCD2',
                yaxis: 'y'
            };

            this.vd3 = {
                name: 'UCD3',
                yaxis: 'y'
            };

            this.vd4 = {
                name: 'UCD4',
                yaxis: 'y'
            };

            this.vd5 = {
                name: 'UCD5',
                yaxis: 'y'
            };

            // snow traces
            this.trace5 = {
                name: 'SNOF (mm)',
                yaxis: 'y'
            };

            this.trace6 = {
                name: 'SNMT (mm)',
                yaxis: 'y'
            };

            this.trace7 = {
                name: 'SNMR (mm)',
                yaxis: 'y'
            };

            this.trace8 = {
                name: 'SNTFmm (mm)',
                yaxis: 'y'
            };

            this.trace9 = {
                name: 'SNMF (mm)',
                yaxis: 'y'
            };

            this.trace10 = {
                name: 'RSSL (mm)',
                yaxis: 'y'
            };            

            this.trace12 = {
                name: 'WATisrf (mm)',
                yaxis: 'y'
            };

            this.trace13 = {
                name: 'SNTFcm (cm)',
                yaxis: 'y'
            };           
        },        

        setTrace: function(elem, response){
            var newTrace = {
                y: response.data
            };

            // console.log('set trace for elem ' + elem);

            switch(elem){
                // input traces
                case 'temp-check':
                    $.extend(this.trace1, newTrace);
                    break;
                case 'precip-check':
                    $.extend(this.trace2, newTrace);
                    break;
                case 'rain-check':
                    $.extend(this.trace3, newTrace);
                    break;
                case 'et-check':
                    $.extend(this.trace4, newTrace);
                    break;
                // validation traces
                case 'ucd1-check':
                    $.extend(this.vd1, newTrace);
                    break;
                case 'ucd2-check':
                    $.extend(this.vd2, newTrace);
                    break;
                case 'ucd3-check':
                    $.extend(this.vd3, newTrace);
                    break;
                case 'ucd4-check':
                    $.extend(this.vd4, newTrace);
                    break;
                case 'ucd5-check':
                    $.extend(this.vd5, newTrace);
                    break;
                // snow traces
                case 'snow-check':
                    $.extend(this.trace5, newTrace);
                    break;
                case 'tdsm-check':
                    $.extend(this.trace6, newTrace);
                    break;
                case 'rdsm-check':
                    $.extend(this.trace7, newTrace);
                    break;
                case 'snow_acc-check':
                    $.extend(this.trace8, newTrace);
                    break;
                case 'snowmelt-check':
                    $.extend(this.trace9, newTrace);
                    break;
                case 'rssl-check':
                    $.extend(this.trace10, newTrace);
                    break;                
                case 'water_or_sr-check':
                    $.extend(this.trace12, newTrace);
                    break;
                case 'snow_calc-check':
                    $.extend(this.trace13, newTrace);
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

            $.extend(inputGraphObj.getDefaultTrace(this.graphSource), newTrace);                        
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

            switch (elem) {
                case 'temp-axis':
                    if (!this.trace1.yaxis.localeCompare('y2')) {
                        this.trace1.yaxis = 'y';
                    } else {
                        this.trace1.yaxis = 'y2';
                    }
                    // console.log(this.trace1);
                    break;
                case 'precip-axis':
                    if (!this.trace2.yaxis.localeCompare('y2')) {
                        this.trace2.yaxis = 'y';
                    } else {
                        this.trace2.yaxis = 'y2';
                    }
                    // console.log(this.trace2);
                    break;
                case 'rain-axis':
                    if (!this.trace3.yaxis.localeCompare('y2')) {
                        this.trace3.yaxis = 'y';
                    } else {
                        this.trace3.yaxis = 'y2';
                    }
                    // console.log(this.trace3);
                    break;
                case 'et-axis':
                    if (!this.trace4.yaxis.localeCompare('y2')) {
                        this.trace4.yaxis = 'y';
                    } else {
                        this.trace4.yaxis = 'y2';
                    }
                    // console.log(this.trace4);
                    break;
                    case 'ucd1-axis':
                    if (!this.vd1.yaxis.localeCompare('y2')) {
                        this.vd1.yaxis = 'y';
                    } else {
                        this.vd1.yaxis = 'y2';
                    }
                    // console.log(this.vd1);
                    break;
                case 'ucd2-axis':
                    if (!this.vd2.yaxis.localeCompare('y2')) {
                        this.vd2.yaxis = 'y';
                    } else {
                        this.vd2.yaxis = 'y2';
                    }
                    // console.log(this.vd2);
                    break;
                case 'ucd3-axis':
                    if (!this.vd3.yaxis.localeCompare('y2')) {
                        this.vd3.yaxis = 'y';
                    } else {
                        this.vd3.yaxis = 'y2';
                    }
                    // console.log(this.vd3);
                    break;
                case 'ucd4-axis':
                    if (!this.vd4.yaxis.localeCompare('y2')) {
                        this.vd4.yaxis = 'y';
                    } else {
                        this.vd4.yaxis = 'y2';
                    }
                    // console.log(this.vd4);
                    break;
                case 'ucd5-axis':
                    if (!this.vd5.yaxis.localeCompare('y2')) {
                        this.vd5.yaxis = 'y';
                    } else {
                        this.vd5.yaxis = 'y2';
                    }
                    // console.log(this.vd5);
                    break;
                case 'snow-axis':
                    if (!this.trace5.yaxis.localeCompare('y2')) {
                        this.trace5.yaxis = 'y';
                    } else {
                        this.trace5.yaxis = 'y2';
                    }
                    break;
                case 'tdsm-axis':
                    if (!this.trace6.yaxis.localeCompare('y2')) {
                        this.trace6.yaxis = 'y';
                    } else {
                        this.trace6.yaxis = 'y2';
                    }
                    break;
                case 'rdsm-axis':
                    if (!this.trace7.yaxis.localeCompare('y2')) {
                        this.trace7.yaxis = 'y';
                    } else {
                        this.trace7.yaxis = 'y2';
                    }
                    break;
                case 'snow_acc-axis':
                    if (!this.trace8.yaxis.localeCompare('y2')) {
                        this.trace8.yaxis = 'y';
                    } else {
                        this.trace8.yaxis = 'y2';
                    }
                    break;
                case 'snowmelt-axis':
                    if (!this.trace9.yaxis.localeCompare('y2')) {
                        this.trace9.yaxis = 'y';
                    } else {
                        this.trace9.yaxis = 'y2';
                    }
                    break;
                case 'rssl-axis':
                    if (!this.trace10.yaxis.localeCompare('y2')) {
                        this.trace10.yaxis = 'y';
                    } else {
                        this.trace10.yaxis = 'y2';
                    }
                    break;                
                case 'water_or_sr-axis':
                    if (!this.trace12.yaxis.localeCompare('y2')) {
                        this.trace12.yaxis = 'y';
                    } else {
                        this.trace12.yaxis = 'y2';
                    }
                    break;
                case 'snow_calc-axis':
                    if (!this.trace13.yaxis.localeCompare('y2')) {
                        this.trace13.yaxis = 'y';
                    } else {
                        this.trace13.yaxis = 'y2';
                    }
                    break;
            }
        },

        toggleGraphType: function(elem){
            var enabled = false;

            this.graphType = elem;
            switch(elem){
                // inpu
                case 'temp-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,3);
                    enabled = $("#temp-check").prop('checked');
                    break;
                case 'precip-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,2);
                    enabled = $("#precip-check").prop('checked');
                    break;
                case 'rain-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,1);
                    enabled = $("#rain-check").prop('checked');
                    break;
                case 'et-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,0);
                    enabled = $("#et-check").prop('checked');
                    break;
                // validation                
                case 'ucd1-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,13);
                    enabled = $("#ucd1-check").prop('checked');
                    break;
                case 'ucd2-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,14);
                    enabled = $("#ucd2-check").prop('checked');
                    break;
                case 'ucd3-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,15);
                    enabled = $("#ucd3-check").prop('checked');
                    break;
                case 'ucd4-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,16);
                    enabled = $("#ucd4-check").prop('checked');
                    break;
                case 'ucd5-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,17);
                    enabled = $("#ucd5-check").prop('checked');
                    break;
                // snow
                case 'snow-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,4);
                    enabled = $("#snow-check").prop('checked');
                    break;
                case 'tdsm-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,5);
                    enabled = $("#tdsm-check").prop('checked');
                    break;
                case 'rdsm-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,6);
                    enabled = $("#rdsm-check").prop('checked');
                    break;
                case 'snow_acc-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,7);
                    enabled = $("#snow_acc-check").prop('checked');
                    break;
                case 'snowmelt-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,8);
                    enabled = $("#snowmelt-check").prop('checked');
                    break;
                case 'rssl-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,9);
                    enabled = $("#rssl-check").prop('checked');
                    break;                
                case 'water_or_sr-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,11);
                    enabled = $("#water_or_sr-check").prop('checked');
                    break;
                case 'snow_calc-check':
                    this.graphTypeCode = this.graphTypeCode ^ Math.pow(2,12);
                    enabled = $("#snow_calc-check").prop('checked');
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
                    Plotly.react(myGraph, inputGraphObj.fig);                    
                }).catch(function(error){
                    // console.log(error);
                });            
            } else {                              
                inputGraphObj.setLayout(that.graphSource);
                inputGraphObj.setFig();
                Plotly.react(myGraph, inputGraphObj.fig);
            }
        }        
    }                    

    function getTraceData(source, elem){
        // disable checkboxes
        $(':checkbox').attr("disabled", true);  

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
                    // enable checkboxes
                    $(':checkbox').removeAttr("disabled"); 
                    
                    resolve(response);
                },
                error: function (error) {
                    // enable checkboxes
                    $(':checkbox').removeAttr("disabled"); 
                    
                    reject(error);
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

    async function getTimeIndexValue(index) {         
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'get-time-index-value',
                type: 'POST',
                data: {
                    _csrfToken: <?= json_encode($this->request->getParam('_csrfToken')) ?>,
                    index: index
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

<script type="module">    
    $(document).ready( function () {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;

        var statsTableStart = null;
        var statsTableEnd = null;

        $("#calib_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
                $("#graph_btn").removeClass("btn-primary");                
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
                $("#graph_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#calib_content").show();            
            $("#graph_content").hide();
            calibTable.draw();
        });

        $("#stats_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#calib_btn").removeClass("btn-primary");
                $("#graph_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#calib_btn").addClass("btn-secondary");
                $("#graph_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").show();
            $("#calib_content").hide();
            $("#graph_content").hide();
            statsTable.draw();
        });

        $("#graph_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#calib_btn").removeClass("btn-primary");
                $("#stats_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#calib_btn").addClass("btn-secondary");
                $("#stats_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#calib_content").hide();
            $("#graph_content").show();
        }); 

        Plotly.newPlot(myGraph, []);

        // graph relayout callback
        myGraph.on('plotly_relayout',
            async function(eventdata) {
                if (!isNaN(eventdata['xaxis.range[0]']) && !isNaN(eventdata['xaxis.range[1]'])) {
                    statsTable.clear().draw();

                    var startResponse = await getTimeIndexValue(Math.floor(eventdata['xaxis.range[0]']));
                    // console.log('start returned ' + JSON.stringify(startResponse));
                    var endResponse = await getTimeIndexValue(Math.ceil(eventdata['xaxis.range[1]']));           
                    // console.log('end returned ' + JSON.stringify(endResponse));

                    statsTableStart = startResponse.data;
                    statsTableEnd = endResponse.data;
                    // console.log(statsTableStart);
                    // console.log(statsTableEnd);
                    $("#start_date_filter").val(statsTableStart);
                    $("#end_date_filter").val(statsTableEnd);
                    
                    validateStatsFilter();    
                    
                    $("#stats_interval_details").text(' (selected interval)');                    
                    $('#statsDataTable').DataTable().ajax.reload();
                }            
            }
        );

        $("#stats_interval_details").text(' (complete dataset)');                

        // stats table
        var statsTable = $('#statsDataTable').DataTable({            
            ajax: {
                url: "fetch-output-data-stats",
                type: "POST",
                data: function(d) {
                    d.startDate = statsTableStart;
                    d.endDate = statsTableEnd;
                },
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
                {
                    targets: [1, 2, 5, 6, 7, 8, 10, 13, 15, 16, 17, 18],
                    visible: false
                }
            ],
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'SNOW BUDDY_snowStats_' + now;
                    }
                },
                // {
                //     extend: 'excel',
                //     title: 'water_balance_stats_xlsx'
                // }                
            ],
            "drawCallback": function() {                
            }
        });

        // calib table
        var calibTable = $('#calibDataTable').DataTable({            
            ajax: {
                url: "fetch-calib-stats",
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
                }
            ],
            "scrollX": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'SNOW BUDDY_snowCalib_' + now;
                    }
                }             
            ],
            "drawCallback": function() {                
            }
        });
        
        // switches
        $(".y-axis").bootstrapSwitch('size', 'small');
        $(".y-axis").bootstrapSwitch('onText', 'Left');
        $(".y-axis").bootstrapSwitch('offText', 'Right');
        $(".y-axis").bootstrapSwitch('labelText', 'Axis');
        $(".y-axis").bootstrapSwitch('offColor', 'success');
        $(".y-axis").bootstrapSwitch('state', true);  

        // graph stuff - initialized for source 1 (input daily) and type temp-check
        getTimeData(1).then(function(response) {
            inputGraphObj.initTraces();
            inputGraphObj.setGraphSource(1);
            inputGraphObj.setTimeData(response);
            // inputGraphObj.setGraphSource(1);
            inputGraphObj.resetGraphCode();
            inputGraphObj.toggleGraphType('temp-check');
            inputGraphObj.refreshGraph(true);
        }).catch(function(error) {
            // console.log(error);
        });

        // toggle Graph Source
        $('#graph_source').change(function() {
            var graphSource = $(this).val();
            // console.log('new source ' + graphSource);

            // if (graphSource > 1){
            //     $("#statisticsWrapper").hide();
            // } else {
            //     $("#statisticsWrapper").show();
            // }

            $(':checkbox').prop('checked', false);
            $("#temp-check").prop('checked', true);

            getTimeData(graphSource).then(function(response) {
                inputGraphObj.setGraphSource(graphSource);
                inputGraphObj.setTimeData(response);
                // inputGraphObj.setGraphSource(graphSource);
                inputGraphObj.resetGraphCode();
                inputGraphObj.toggleGraphType('temp-check');
                inputGraphObj.refreshGraph(true);
            }).catch(function(error) {
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

        // stats filter stuff
        $("#start_date_filter").change(function() {
            statsTableStart = $(this).val();

            validateStatsFilter();
        });

        $("#end_date_filter").change(function() {
            statsTableEnd = $(this).val();

            validateStatsFilter();
        });

        function validateStatsFilter() {
            $("#run-filter").prop('disabled', true);

            if (statsTableStart && statsTableEnd) {
                $("#run-filter").prop('disabled', false);
            }
        }

        $("#run-filter").click(function() {
            $("#stats_interval_details").text(' (selected interval)');
            statsTable.clear().draw();
            $('#statsDataTable').DataTable().ajax.reload();
        });

        $("#reset-filter").click(function() {
            $("#start_date_filter").val(null);
            statsTableStart = null;

            $("#end_date_filter").val(null);
            statsTableEnd = null;

            validateStatsFilter();
            $("#stats_interval_details").text(' (complete dataset)');
            statsTable.clear().draw();
            $('#statsDataTable').DataTable().ajax.reload();
        });

        $('a.toggle-vis').on('click', function (e) {
            e.preventDefault();
    
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active');
            }

            // Get the column API object
            // var mainColumn = mainTable.column($(this).attr('data-column'));
            var statsColumn = statsTable.column($(this).attr('data-column') - 1);
    
            // Toggle the visibility
            // mainColumn.visible(!mainColumn.visible());
            statsColumn.visible(!statsColumn.visible());
        });
    });
</script>