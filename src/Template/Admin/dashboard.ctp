<div class="container-lg">
    <div class="row my-5">
              
        <div class="col-4 px-0">                
            <button id="map_btn" class="btn btn-large btn-primary w-100"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> User Map</button>  
        </div>

        <div class="col-4 px-0">
            <button id="stats_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Usage Stats</button>        
        </div>        

        <div class="col-4 px-0">                
            <button id="db_btn" class="btn btn-large btn-secondary w-100"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Database Status</button>  
        </div>

    </div>
</div>

<div id="map_content" class="container-lg">    
    
    <div class="col-4 offset-8 my-2">
        <select class="custom-select" id="map_type">
            <option disabled selected value="0">Select map type:</option>
            <option value="1">Visitors</option>
            <option value="2">Visitors w Data</option>
            <option value="3">Visitors w Sample Data</option>
            <option value="4">Visitors w User Data</option>                
        </select>
    </div>

    <div id="googleMapWrapper">
        <div id="googleMap"></div>
    </div>
</div>

<div id="stats_content" class="container-lg my-5" style="display:none">   
    <div class="row">
        <div class="col-6 offset-6 text-right">
            <?= $this->Html->link('Export Full Usage', [
                    'controller' => 'admin',
                    'action' => 'export-full-usage'], [
                        'type' => 'button',
                        'class' => 'btn btn-secondary']); ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-3 offset-4">
            <input class="coverFullDiv" type="text" id="start_date_filter" placeholder="Start Date (YYYY-MM-DD)" />
        </div>
        <div class="col-3">
            <input class="coverFullDiv" type="text" id="end_date_filter" placeholder="End Date (YYYY-MM-DD)" />
        </div>
        <div class="col-2 text-right">
            <button type="button" class="btn btn-success" id="run-filter">Filter by Date</button>
        </div>        
    </div>

    <div class="row mt-4">        
        <div class="col-12">
            <table class="table display cell-border compact text-center" id="statsDataTable" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Total Visits (User Sessions)</th>  
                        <th scope="col">Unique Visitors (IPs)</th>  
                        <th scope="col">Load Test Data</th>
                        <th scope="col">Load User Data</th>
                        <th scope="col">Run Snow Module</th>
                        <th scope="col">Export Snow Results</th>                        
                        <th scope="col">Run Water Balance Module</th>                                            
                        <th scope="col">Export Water Balance Results</th>
                    </tr>
                </thead>        
            </table>
        </div>
    </div>
</div>

<div id="db_content" class="container-lg my-5" style="display:none">    
    <div class="row">
        <div class="col-12 text-center">
            <?php 
                if ($dbData['count']){
            ?>          
                <div class="alert-danger py-3">      
                    <span>There are <?= $dbData['count'] ?> datasets older than 24h</span>
                </div>
                <br/>
                <br/>
                <?= $this->Html->link('Reset Old Database Data', "#reset-db", [
                'class' => ['btn btn-danger'],
                'id' => 'reset-db',
                'data-toggle' => 'modal',
                'data-target' => '#resetDbModal']); ?>
            <?php } else { ?>
                <div class="alert-success py-3">
                    <span>There are no datasets older than 24h</span>
                </div>
            <?php } ?>        
        </div>
    </div>
</div>

<script type="module">
    $(document).ready( function () {  
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;        

        initDataTable(csrfToken);        
        setCsrfToken(csrfToken);        

        $("#stats_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#map_btn").removeClass("btn-primary");
                $("#db_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#map_btn").addClass("btn-secondary");
                $("#db_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").show();
            $("#map_content").hide();
            $("#db_content").hide();
            
            $('#statsDataTable').DataTable().ajax.reload();
        });

        $("#map_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
                $("#db_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
                $("#db_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#map_content").show();
            $("#db_content").hide();
        });  

        $("#db_btn").click((e)=>{    
            const elem = $(e.target);    

            if (elem.hasClass("btn-secondary")){
                elem.removeClass("btn-secondary");
                $("#stats_btn").removeClass("btn-primary");
                $("#map_btn").removeClass("btn-primary");
            }
            if (!elem.hasClass("btn-primary")){
                elem.addClass("btn-primary");
                $("#stats_btn").addClass("btn-secondary");
                $("#map_btn").addClass("btn-secondary");
            }
            
            $("#stats_content").hide();
            $("#map_content").hide();
            $("#db_content").show();
        });         

        $('#map_type').change(function(){           
            // console.log('Selected ' + $('#map_type').val());
            setGoogleMapParams($('#map_type').val());
            refreshGoogleMap();
        });

        $('#run-filter').click(function() {
            $('#statsDataTable').DataTable().ajax.reload();
        });
    });    

    function initDataTable(csrfToken) {
        $('#statsDataTable').DataTable({
            serverSide: true,
            ajax: {
                url: 'fetch-stats-data',
                type: 'POST',
                data: function(d){
                    d.startDate = getStartDateFilter(),
                    d.endDate = getEndDateFilter() 
                },
                headers: {
                    'X-CSRF-Token': csrfToken 
                },                              
            },
            ordering:  false,
            paging: false,
            info: false, 
            searching: false,
            "columnDefs": [
                { "orderable": false, "targets": '_all' },
                { "orderable": true, "targets": [] },
                {               
                    targets: '_all',                         
                    className: "dt-head-center dt-body-center" // fixed-width-table-row
                },
            ],
            // "search": {
            //     "caseInsensitive": true
            // },
            "lengthMenu": [ 10, 25, 50, 100 ],
            // "language": {
            //     "search": "Data Since (YYYY-MM-DD):"
            // },
            "scrollX": true,       
            dom: 'Blftip',            
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'swib_usageStats_' + now;
                    }                   
                },                            
            ]                        
        });
    }

    function getStartDateFilter(){
        return $('#start_date_filter').val();
    }

    function getEndDateFilter(){
        return $('#end_date_filter').val();
    }
</script>

<script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp6TfmzQcsTwD5-8TY64mfcm16FBzmgps&callback=initMap"></script>