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
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="3"><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">PRECIP</span></a>
    </div>
</div>

<div class="row py-1 px-5 field-buttons">
    <div class="col-12 d-flex justify-content-left">            
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="4"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM'] ?>">SNOW_MM</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="5"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_CM'] ?>">SNOW_CM</span></a>
        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="6"><span data-toggle="tooltip" title="<?= $tooltips['RAIN_MM'] ?>">RAIN_MM</span></a>        
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
            }
        ?>
            <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="<?= 7+$i ?>"><span data-toggle="tooltip" title="<?= $tooltips[$colName] ?>"><?= $colName ?></span></a>
        <?php } ?>            
    </div>
</div>
<?php } ?>

<div id="table_content">
    <div class="row mt-3 px-5">
        <div class="col-6">
            <div class="mb-1 pl-1">Select time step below:</div>
            <select class="custom-select" id="graph_source">
                <option selected value="1">Snow - Daily</option>
                <!-- <option value="2">Snow - Monthly</option>
                <option value="10">Snow - Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="11">Snow - Growing Season</option>
                <?php } ?>
                <option value="3">Snow - Yearly</option>
                <option value="21">Snow - Typical Year Daily</option>
                <option value="22">Snow - Typical Year Monthly</option>
                <option value="24">Snow - Typical Year Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="25">Snow - Typical Year Growing Season</option>
                <?php } ?>
                <option value="23">Snow - Typical Year Average</option> -->
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
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">PRECIP</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM'] ?>">SNOW_MM</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_CM'] ?>">SNOW_CM</span> (cm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAIN_MM'] ?>">RAIN_MM</span> (mm)</th>                        
                        
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
                    <h5>Snow Statistics <span class="stats_interval_details"></span></h5>
                </div>
            </div>

            <div class="row py-2">
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

            <table class="table display cell-border compact text-center" id="statsDataTable">
                <thead>
                    <tr>
                        <th scope="col">Statistic<br /><span id="stat_type"></th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">PRECIP</span> (mm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM'] ?>">SNOW_MM</span> (mm)</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['SNOW_CM'] ?>">SNOW_CM</span> (cm)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['RAIN_MM'] ?>">RAIN_MM</span> (mm)</th>  

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
                <?php } ?>
                <option value="23">Typical Year Average</option>                        -->
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
                        <?php if (!empty($calibration['output2_field']) && !empty($calibration['ucd2_field'])) { ?>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips[$calibration['output2_field']] ?>"><?= $calibration['output2_field']?></span> vs <span data-toggle="tooltip" title="<?= $tooltips[$calibration['ucd2_field']] ?>"><?= $calibration['ucd2_field']?></span></th>                       
                        <?php } ?>
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
                    targets: [2, 7, 8, 9],
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
                        return 'SBUDDY_snowData_' + now;
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
                    targets: [1, 6, 7, 8],
                    visible: false
                }
            ],
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csv',
                    filename: () => {
                        var now = Date.now();
                        return 'SBUDDY_snowStats_' + now;
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
                        return 'SBUDDY_snowCalib_' + now;
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
            mainTable.clear().draw(); // server side set so it does auto reload
            // $('#mainDataTable').DataTable().ajax.reload();
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