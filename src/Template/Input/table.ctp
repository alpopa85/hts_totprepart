<div class="row mt-3 px-5">
    <div class="col-6">                
        <button id="table_btn" class="btn btn-large btn-primary w-100"><i class="fa fa-table" aria-hidden="true"></i> Table</button>  
    </div>

    <div class="col-6">
        <button id="stats_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-search" aria-hidden="true"></i> Stats</button>        
    </div>            
</div>

<div id="table_content">
    <div class="row mt-3 px-5">
        <div class="col-6">
            <div class="mb-1 pl-1">Select time step below:</div>
            <select class="custom-select" id="graph_source">
                <option selected value="1">Input Data - Daily</option>
                <!-- <option value="2">Input Data - Monthly</option>
                <option value="10">Input Data - Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="11">Input Data - Growing Season</option>
                <?php } ?>
                <option value="3">Input Data - Yearly</option>
                <option value="21">Input Data - Typical Year Daily</option>
                <option value="22">Input Data - Typical Year Monthly</option>
                <option value="24">Input Data - Typical Year Seasons</option>
                <?php if ($this->isSetGrowthSeason->getFlag()) { ?>
                    <option value="25">Input Data - Typical Year Growing Season</option>
                <?php } ?>
                <option value="23">Input Data - Typical Year Average</option> -->
            </select>
        </div>
    </div>

    <div class="row borderedSection my-3 mx-5">
        <div class="col-12">
            <table class="table display cell-border compact text-center borderedSection" id="mainDataTable">
                <thead>
                    <tr>
                        <th scope="col">Index</th>
                        <th scope="col" class="date-col">Date</th>                
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">PRECIP</span> (mm)</th>
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
                    <h5>Input Data Statistics <span id="stats_interval_details"></span></h5>
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

            <table class="table display cell-border compact text-center mt-3" id="statsDataTable">
                <thead>
                    <tr>
                        <th scope="col">Statistic</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span> (&deg;C)</th>
                        <th scope="col"><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">PRECIP</span> (mm)</th>
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

<script type="module">
    //import {getCookie} from "../js/project.js";   
        
    $(document).ready( function () {        
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        //alert(csrfToken);

        var statsTableStart = null;
        var statsTableEnd = null;        
        
        var mainTable = $('#mainDataTable').DataTable({
            serverSide: true,
            // deferLoading: 12,
            ajax: {
                url: "fetch-input-data",
                type: "POST",
                data: function(d){
                    d.graphSource = getGraphSource() 
                },
                headers: {
                    "X-CSRF-Token": csrfToken 
                },                
            },
            "columnDefs": [
                { "orderable": false, "targets": "_all" },
                { "orderable": true, "targets": [] },
                {               
                    targets: "_all",                         
                    className: "dt-head-center dt-body-center" // fixed-width-table-row
                },
            ],
            "lengthMenu": [ 12, 25, 50, 100 ],
            "search": {
                "caseInsensitive": true
            },
            "language": {
                "search": "Type Start Date:"
            },  
            "scrollX": true,          
            dom: 'Blftip',            
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'SNOW BUDDY_inputData_' + now;
                    }                   
                },
                // {
                //     extend: 'excel',
                //     title: 'input_data_xlsx'
                // }                
            ],
            "drawCallback": function() {          
            }                    
        });

        // stats table 
        $("#stats_interval_details").text(' (complete dataset)');

        var statsTable = $('#statsDataTable').DataTable({           
            ajax: {
                url: "fetch-input-data-stats",
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
            ],             
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'SNOW BUDDY_inputStats_' + now;
                    }
                },
                // {
                //     extend: 'excel',
                //     title: 'input_stats_xlsx'
                // }                
            ],
            "drawCallback": function() {                
            }
        });

        $("#stats_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#table_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#table_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").show();
            $("#table_content").hide();
            // statsTable.clear().draw();
            // $('#statsDataTable').DataTable().ajax.reload();             
        });

        $("#table_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#table_content").show();
            // mainTable.clear().draw(); // reloaded automatically since serverside
            // $('#mainDataTable').DataTable().ajax.reload();     
        });

        function getGraphSource(){
            return $('#graph_source').val();
        }

        $('#graph_source').change(function(){            
            mainTable.clear().draw(); // server side set so it does auto reload
            // $('#mainDataTable').DataTable().ajax.reload();
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
    });
</script>