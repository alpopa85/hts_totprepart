<div class="my-5">        
    <div class="row pb-5">
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

    <table class="table display cell-border compact text-center" id="mainDataTable" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Index</th>
                <th scope="col" class="date-col">Date</th>                                                                   
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

<div class="my-5" id="statisticsWrapper">
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

<script type="module">
    //import {getCookie} from "../js/project.js";         

    $(document).ready( function () {        
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        //alert(csrfToken);

        //var token = getCookie('csrfToken');
        // alert(token);

        $('#mainDataTable').DataTable({
            serverSide: true,
            ajax: {
                url: 'fetch-output-data',
                type: 'POST',
                data: function(d){
                    d.graphSource = getGraphSource() 
                },
                headers: {
                    'X-CSRF-Token': csrfToken 
                },                              
            },
            "columnDefs": [
                { "orderable": false, "targets": '_all' },
                { "orderable": true, "targets": [] },
                {               
                    targets: '_all',                         
                    className: "dt-head-center dt-body-center" // fixed-width-table-row
                },
            ],
            "search": {
                "caseInsensitive": true
            },
            "lengthMenu": [ 12, 25, 50, 100 ],
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
                        return 'swib_balanceData_' + now;
                    }                   
                },                            
            ]                        
        });

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
            "scrollX": true,       
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    filename: () => {         
                        var now = Date.now();               
                        return 'swib_balanceStats_' + now;
                    }
                },                       
            ]
        });

        function getGraphSource(){
            return $('#graph_source').val();
        }            

        $('#graph_source').change(function(){
            // console.log($(this).val());

            if ($(this).val() > 1){
                $("#statisticsWrapper").hide();
            } else {
                $("#statisticsWrapper").show();
            }
            $('#mainDataTable').DataTable().ajax.reload();
        });
    });
</script>