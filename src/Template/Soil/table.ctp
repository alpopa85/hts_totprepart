<div class="row mt-3 px-5">
    <div class="col-4">                
        <button id="table_btn" class="btn btn-large btn-primary w-100"><i class="fa fa-table" aria-hidden="true"></i> Table</button>  
    </div>

    <div class="col-4">
        <button id="stats_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-search" aria-hidden="true"></i> Stats</button>        
    </div> 
    
    <div class="col-4">
        <button id="calib_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-calculator" aria-hidden="true"></i> Calibration Stats</button>        
    </div> 
</div>

<div class="row py-1 pt-3 px-5 field-buttons">
    <div class="col-12 d-flex justify-content-left">            
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="2"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="3"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="4"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></a>
    </div>
</div>

<div class="row py-1 px-5 field-buttons">
    <div class="col-12 d-flex justify-content-left">            
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="5"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="6"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span></a>                
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="7"><span data-toggle="tooltip" title="<?= $tooltips['INFact'] ?>">INFact</span></a>                
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="8"><span data-toggle="tooltip" title="<?= $tooltips['DRAfre'] ?>">DRAfre</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="9"><span data-toggle="tooltip" title="<?= $tooltips['DRAfin'] ?>">DRAfin</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="10"><span data-toggle="tooltip" title="<?= $tooltips['DRAbinf'] ?>">DRAbinf</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="11"><span data-toggle="tooltip" title="<?= $tooltips['DRAoss'] ?>">DRAoss</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="12"><span data-toggle="tooltip" title="<?= $tooltips['DRAact'] ?>">DRAact</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="13"><span data-toggle="tooltip" title="<?= $tooltips['ETisi'] ?>">ETisi</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="14"><span data-toggle="tooltip" title="<?= $tooltips['ETcds'] ?>">ETcds</span></a>                
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="15"><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span></a>                
    </div>         
</div>

<div class="row py-1 px-5 field-buttons">
    <div class="col-12 d-flex justify-content-left">            
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="16"><span data-toggle="tooltip" title="<?= $tooltips['SWCint'] ?>">SWCint</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="17"><span data-toggle="tooltip" title="<?= $tooltips['SWCfinmm'] ?>">SWCfinmm</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="18"><span data-toggle="tooltip" title="<?= $tooltips['SWCfin'] ?>">SWCfin</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="19"><span data-toggle="tooltip" title="<?= $tooltips['SReinf'] ?>">SReinf</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="20"><span data-toggle="tooltip" title="<?= $tooltips['SReinfDB'] ?>">SReinfDB</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="21"><span data-toggle="tooltip" title="<?= $tooltips['SResas'] ?>">SResas</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="22"><span data-toggle="tooltip" title="<?= $tooltips['SResasDB'] ?>">SResasDB</span></a>
        <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="23"><span data-toggle="tooltip" title="<?= $tooltips['SRTint'] ?>">SRTint</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="24"><span data-toggle="tooltip" title="<?= $tooltips['SRTact'] ?>">SRTact</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="25"><span data-toggle="tooltip" title="<?= $tooltips['SWCgain'] ?>">SWCgain</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="26"><span data-toggle="tooltip" title="<?= $tooltips['SWCloss'] ?>">SWCloss</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="27"><span data-toggle="tooltip" title="<?= $tooltips['SWClow'] ?>">SWClow</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="28"><span data-toggle="tooltip" title="<?= $tooltips['SWChigh'] ?>">SWChigh</span></a>
    </div>
</div>

<?php if ($nValidationColumns > 0) { ?>
<div class="row py-1 px-5 field-buttons">
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
            <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="<?= 29+$i ?>"><span data-toggle="tooltip" title="<?= $tooltips[$colName] ?>"><?= $colName ?></span></a>
        <?php } ?>            
    </div>
</div>
<?php } ?>

<div id="table_content">
    <div class="row mt-3 px-5">
        <div class="col-6">
            <div class="mb-1 pl-1">Select time step below:</div>
            <select class="custom-select" id="graph_source">
                <option selected value="1">Water Balance - Daily</option>
                <option value="2">Water Balance - Monthly</option>
                <option value="10">Water Balance - Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="11">Water Balance - Growing Season</option>
                <?php } ?>
                <option value="3">Water Balance - Yearly</option>
                <option value="21">Water Balance - Typical Year Daily</option>
                <option value="22">Water Balance - Typical Year Monthly</option>
                <option value="24">Water Balance - Typical Year Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="25">Water Balance - Typical Year Growing Season</option>
                <?php } ?>
                <option value="23">Water Balance - Typical Year Average</option>
            </select>
        </div>
    </div>

    <div class="row borderedSection my-3 mx-5">
        <div class="col-12">     
            <table class="table display cell-border compact text-center" id="mainDataTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Index</th>
                        <th scope="col" class="date-col">Date</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['INFact'] ?>">INFact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAfre'] ?>">DRAfre</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAfin'] ?>">DRAfin</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAbinf'] ?>">DRAbinf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAoss'] ?>">DRAoss</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAact'] ?>">DRAact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETisi'] ?>">ETisi</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETcds'] ?>">ETcds</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCint'] ?>">SWCint</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCfinmm'] ?>">SWCfinmm</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCfin'] ?>">SWCfin</span> (%)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SReinf'] ?>">SReinf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SReinfDB'] ?>">SReinfDB</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SResas'] ?>">SResas</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SResasDB'] ?>">SResasDB</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SRTint'] ?>">SRTint</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SRTact'] ?>">SRTact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCgain'] ?>">SWCgain</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCloss'] ?>">SWCloss</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWClow'] ?>">SWClow</span></th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWChigh'] ?>">SWChigh</span></th>
                        
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

<div id="stats_content" style="display:none">
    <div class="row borderedSection my-3 mx-5" id="statisticsWrapper">
        <div class="col-12">
            <div class="row pt-2">
                <div class="col text-left">
                    <h5>Water Balance Statistics <span class="stats_interval_details"></span></h5>
                </div>
            </div>

            <div class="row py-2">
                <div class="col-3 text-left">
                    <button type="button" class="btn btn-danger reset-filter">Show Complete Dataset Stats</button>
                </div>

                <div class="col-3 text-right">
                    <button type="button" class="btn btn-primary run-filter" disabled>Show Stats by Interval</button>
                </div>

                <div class="col-3 col-xl-2">
                    <input type="text" class="coverFullDiv start_date_filter" placeholder="Start Date (YYYY-MM-DD)" />
                </div>

                <div class="col-3 col-xl-2">
                    <input type="text" class="coverFullDiv end_date_filter" placeholder="End Date (YYYY-MM-DD)" />
                </div>
            </div>                           

            <table class="table display cell-border compact text-center mt-3" id="statsDataTable">
                <thead>
                    <tr>
                    <th scope="col">Statistic<br /><span id="stat_type"></th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['INFact'] ?>">INFact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAfre'] ?>">DRAfre</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAfin'] ?>">DRAfin</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAbinf'] ?>">DRAbinf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAoss'] ?>">DRAoss</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['DRAact'] ?>">DRAact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETisi'] ?>">ETisi</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETcds'] ?>">ETcds</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCint'] ?>">SWCint</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCfinmm'] ?>">SWCfinmm</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCfin'] ?>">SWCfin</span> (%)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SReinf'] ?>">SReinf</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SReinfDB'] ?>">SReinfDB</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SResas'] ?>">SResas</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SResasDB'] ?>">SResasDB</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SRTint'] ?>">SRTint</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SRTact'] ?>">SRTact</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCgain'] ?>">SWCgain</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWCloss'] ?>">SWCloss</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWClow'] ?>">SWClow</span></th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SWChigh'] ?>">SWChigh</span></th>
                        
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
    <div class="row borderedSection mt-3 mb-1 mx-5">
        <div class="col text-left">
            <h5>Showing for <span class="stats_interval_details"></span></h5>
        </div>
    </div>

    <div class="row borderedSection my-1 mx-5">
        <div class="col-3 text-left">
            <button type="button" class="btn btn-danger reset-filter" class="">Show Complete Dataset Stats</button>
        </div>

        <div class="col-3 text-right">
            <button type="button" class="btn btn-primary run-filter" class="" disabled>Show Stats by Interval</button>
        </div>

        <div class="col-3 col-xl-2">
            <input type="text" class="coverFullDiv start_date_filter" placeholder="Start Date (YYYY-MM-DD)" />
        </div>

        <div class="col-3 col-xl-2">
            <input type="text" class="coverFullDiv end_date_filter" placeholder="End Date (YYYY-MM-DD)" />
        </div>
    </div>

    <div class="row borderedSection my-1 mx-5" id="calibTypeMenu">        
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
                <option value="23">Typical Year Average</option>                      -->
            </select>
        </div>
    </div>

    <div class="row borderedSection mx-5" id="calibrationWrapper">
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

<script type="module">
    //import {getCookie} from "../js/project.js"; 

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        //alert(csrfToken);    

        var statsTableStart = null;
        var statsTableEnd = null;

        $(".stats_interval_details").text(' (complete dataset)');

        var mainTable = $('#mainDataTable').DataTable({
            serverSide: true,
            ajax: {
                url: 'fetch-output-data',
                type: 'POST',
                data: function(d) {
                    d.graphSource = getGraphSource()
                },
                headers: {
                    'X-CSRF-Token': csrfToken
                },
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": '_all'
                },
                {
                    "orderable": true,
                    "targets": []
                },
                {
                    targets: '_all',
                    className: "dt-head-center dt-body-center" // fixed-width-table-row
                },
                {
                    targets: [2, 3, 4, 5, 8, 9, 10, 11, 13, 14, 15, 16, 17, 19, 20, 21, 22, 23],
                    visible: false
                }
            ],
            "search": {
                "caseInsensitive": true
            },
            "lengthMenu": [12, 25, 50, 100],
            "language": {
                "search": "Type Start Date:"
            },
            "scrollX": true,
            dom: 'Blftip',
            buttons: [{
                    extend: 'csv',
                    filename: () => {
                        var now = Date.now();
                        return 'totprepart_swData_' + now;
                    }
                },
                // {
                //     extend: 'excel',
                //     title: 'water_balance_xlsx'
                // }                
            ]
        });

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
            serverSide: true,
            deferLoading: 5,
            searching: false,
            ordering: false,
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
                },
                {
                    targets: [1, 2, 3, 4, 7, 8, 9, 10, 12, 13, 14, 15, 16, 18, 19, 20, 21, 22],
                    visible: false
                }
            ],
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csv',
                    filename: () => {
                        var now = Date.now();
                        return 'totprepart_swStats_' + now;
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
        function getCalibStatsType() {
            return $('#calib_type').val();
        }

        var calibTable = $('#calibDataTable').DataTable({            
            ajax: {
                url: "fetch-calib-stats",
                type: "POST",                
                headers: {
                    "X-CSRF-Token": csrfToken 
                },    
                data: function(d) {
                    d.type = getCalibStatsType();
                    d.startDate = statsTableStart;
                    d.endDate = statsTableEnd;
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
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'totprepart_soilCalib_' + now;
                    }
                }             
            ],
            "drawCallback": function() {                
            }
        });

        $("#calib_btn").click((e)=>{    
            const elem = $(e.target); 
            
            $(".field-buttons").hide();

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
                $("#table_btn").removeClass("btn-primary");                
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
                $("#table_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#calib_content").show();            
            $("#table_content").hide();
            calibTable.draw();
        });

        $("#stats_btn").click((e)=>{    
            const elem = $(e.target);    

            $(".field-buttons").show();

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#calib_btn").removeClass("btn-primary");
                $("#table_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#calib_btn").addClass("btn-secondary");
                $("#table_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").show();
            $("#calib_content").hide();        
            $("#table_content").hide();
            statsTable.draw();
            // $('#statsDataTable').DataTable().ajax.reload();             
        });

        $("#table_btn").click((e)=>{    
            const elem = $(e.target);    

            $(".field-buttons").show();

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
                $("#calib_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
                $("#calib_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#calib_content").hide();
            $("#table_content").show();
            mainTable.draw();
            // mainTable.clear().draw(); // reloaded automatically since serverside
            // $('#mainDataTable').DataTable().ajax.reload();     
        });

        function getGraphSource() {
            return $('#graph_source').val();
        }

        $('#graph_source').change(function() {
            // console.log($(this).val());            

            // if ($(this).val() > 1) {
            //     $("#statisticsWrapper").hide();
            // } else {
            //     $("#statisticsWrapper").show();
            // }
            mainTable.clear().draw();
            $('#mainDataTable').DataTable().ajax.reload();
        });

        // stats filter stuff
        $('#calib_type').change(function() {
            $('#calibDataTable').DataTable().ajax.reload();
        });

        $(".start_date_filter").change(function() {
            statsTableStart = $(this).val();

            $(".start_date_filter").not(this).val($(this).val());

            validateStatsFilter();
        });

        $(".end_date_filter").change(function() {
            statsTableEnd = $(this).val();

            $(".end_date_filter").not(this).val($(this).val());

            validateStatsFilter();
        });

        function validateStatsFilter() {
            $(".run-filter").prop('disabled', true);

            if (statsTableStart && statsTableEnd) {
                $(".run-filter").prop('disabled', false);
            }        
        }

        $(".run-filter").click(function() {
            $(".stats_interval_details").text(' (selected interval)');            
            if ($('#stats_content').css('display') !== 'none') {
                // statsTable.clear().draw();
                $('#statsDataTable').DataTable().ajax.reload();
            } else if ($('#calib_content').css('display') !== 'none') {
                // calibTable.clear().draw();
                $('#calibDataTable').DataTable().ajax.reload();
            }
        });

        $(".reset-filter").click(function() {
            $(".start_date_filter").val(null);
            statsTableStart = null;

            $(".end_date_filter").val(null);
            statsTableEnd = null;

            validateStatsFilter();
            $(".stats_interval_details").text(' (complete dataset)');
            if ($('#stats_content').css('display') !== 'none') {
                // statsTable.clear().draw();
                $('#statsDataTable').DataTable().ajax.reload();
            } else if ($('#calib_content').css('display') !== 'none') {
                // calibTable.clear().draw();
                $('#calibDataTable').DataTable().ajax.reload();
            }
        });

        $('a.toggle-vis').on('click', function (e) {
            e.preventDefault();
    
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active');
            }

            // Get the column API object
            var mainColumn = mainTable.column($(this).attr('data-column'));
            var statsColumn = statsTable.column($(this).attr('data-column') - 1);
    
            // Toggle the visibility
            mainColumn.visible(!mainColumn.visible());
            statsColumn.visible(!statsColumn.visible());
        });
    });
</script>