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

    <div id="graphWrapper" class="borderedSection my-3 mx-5" style="display:none">
    <div class="row no-gutters py-2 px-3">      
            <div class="mb-1">Select data series to display:</div>
        </div>

        <div class="row no-gutters py-2">  
            <div class="col-2">
                <select class="custom-select trace-select" id="graph_trace_1">
                    <option value="none"><span>None</span></option>

                    <optgroup label="Input Data">
                        <option selected value="temp">TEMP</option>
                        <option value="precip">TOTPP</option>
                        <option value="rain">RAIN</option>
                        <option value="et">ETA</option>
                    </optgroup>                                        

                    <optgroup label="Output Data">          
                        <option value="snow">SNOF</option>
                        <option value="water_or_sr">WATisrf</option>
                        <option value="inf_cap_corr">INFact</option>
                        <option value="drafre">DRAfre</option>
                        <option value="drain_corr">DRAfin</option>
                        <option value="drain_boost_excess">DRAbinf</option>
                        <option value="drain_boost_oversat">DRAoss</option>
                        <option value="drain_total">DRAact</option>
                        <option value="etisi">ETisi</option>
                        <option value="et_corr">ETcds</option>
                        <option value="etfsas">ETfsas</option>
                        <option value="swcint">SWCint</option>
                        <option value="swc_corr_sat">SWCfinmm</option>
                        <option value="swc_corr_sat_pc">SWCfin</option> 
                        <option value="sr_exc">SReinf</option>
                        <option value="sr_exc_less_drain">SReinfDB</option>
                        <option value="sr_sat">SResas</option>
                        <option value="sr_sat_less_drain">SResasDB</option>
                        <option value="sr_total">SRTint</option>
                        <option value="sr_total_less_drain">SRTact</option>
                        <option value="net_gain">SWCgain</option>
                        <option value="net_loss">SWCloss</option>
                        <option value="days_low_swc">SWClow</option>
                        <option value="days_high_swc">SWChigh</option>
                    </optgroup>

                    <?php if ($nValidationColumns > 0) { ?>
                    <optgroup label="Calibration Data">
                        <?php if ($nValidationColumns > 0) { ?>
                            <option value="ucd1"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD1</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 1) { ?>
                            <option value="ucd2"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD2</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 2) { ?>
                            <option value="ucd3"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD3</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 3) { ?>
                            <option value="ucd4"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD4</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 4) { ?>
                            <option value="ucd5"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD5</span></option>
                        <?php } ?>
                    </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="col-1 axis-wrapper">
                <div class="custom-control axis-control">
                    <input type="checkbox" class="custom-control-input y-axis" id="trace1-axis">
                </div>
            </div>

            <div class="col-2">
                <select class="custom-select trace-select" id="graph_trace_2">
                    <option selected value="none"><span>None</span></option>
                    
                    <optgroup label="Input Data">
                        <option value="temp">TEMP</option>
                        <option value="precip">TOTPP</option>
                        <option value="rain">RAIN</option>
                        <option value="et">ETA</option>
                    </optgroup>
                    
                    <optgroup label="Output Data">          
                        <option value="snow">SNOF</option>
                        <option value="water_or_sr">WATisrf</option>
                        <option value="inf_cap_corr">INFact</option>
                        <option value="drafre">DRAfre</option>
                        <option value="drain_corr">DRAfin</option>
                        <option value="drain_boost_excess">DRAbinf</option>
                        <option value="drain_boost_oversat">DRAoss</option>
                        <option value="drain_total">DRAact</option>
                        <option value="etisi">ETisi</option>
                        <option value="et_corr">ETcds</option>
                        <option value="etfsas">ETfsas</option>
                        <option value="swcint">SWCint</option>
                        <option value="swc_corr_sat">SWCfinmm</option>
                        <option value="swc_corr_sat_pc">SWCfin</option> 
                        <option value="sr_exc">SReinf</option>
                        <option value="sr_exc_less_drain">SReinfDB</option>
                        <option value="sr_sat">SResas</option>
                        <option value="sr_sat_less_drain">SResasDB</option>
                        <option value="sr_total">SRTint</option>
                        <option value="sr_total_less_drain">SRTact</option>
                        <option value="net_gain">SWCgain</option>
                        <option value="net_loss">SWCloss</option>
                        <option value="days_low_swc">SWClow</option>
                        <option value="days_high_swc">SWChigh</option>
                    </optgroup>

                    <?php if ($nValidationColumns > 0) { ?>
                    <optgroup label="Calibration Data">
                        <?php if ($nValidationColumns > 0) { ?>
                            <option value="ucd1"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD1</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 1) { ?>
                            <option value="ucd2"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD2</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 2) { ?>
                            <option value="ucd3"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD3</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 3) { ?>
                            <option value="ucd4"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD4</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 4) { ?>
                            <option value="ucd5"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD5</span></option>
                        <?php } ?>
                    </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="col-1 axis-wrapper">
                <div class="custom-control axis-control">
                    <input type="checkbox" class="custom-control-input y-axis" id="trace2-axis">
                </div>
            </div>

            <div class="col-2">
                <select class="custom-select trace-select" id="graph_trace_3">
                    <option selected value="none"><span>None</span></option>
                    
                    <optgroup label="Input Data">
                        <option value="temp">TEMP</option>
                        <option value="precip">TOTPP</option>
                        <option value="rain">RAIN</option>
                        <option value="et">ETA</option>
                    </optgroup>
                    
                    <optgroup label="Output Data">          
                        <option value="snow">SNOF</option>
                        <option value="water_or_sr">WATisrf</option>
                        <option value="inf_cap_corr">INFact</option>
                        <option value="drafre">DRAfre</option>
                        <option value="drain_corr">DRAfin</option>
                        <option value="drain_boost_excess">DRAbinf</option>
                        <option value="drain_boost_oversat">DRAoss</option>
                        <option value="drain_total">DRAact</option>
                        <option value="etisi">ETisi</option>
                        <option value="et_corr">ETcds</option>
                        <option value="etfsas">ETfsas</option>
                        <option value="swcint">SWCint</option>
                        <option value="swc_corr_sat">SWCfinmm</option>
                        <option value="swc_corr_sat_pc">SWCfin</option> 
                        <option value="sr_exc">SReinf</option>
                        <option value="sr_exc_less_drain">SReinfDB</option>
                        <option value="sr_sat">SResas</option>
                        <option value="sr_sat_less_drain">SResasDB</option>
                        <option value="sr_total">SRTint</option>
                        <option value="sr_total_less_drain">SRTact</option>
                        <option value="net_gain">SWCgain</option>
                        <option value="net_loss">SWCloss</option>
                        <option value="days_low_swc">SWClow</option>
                        <option value="days_high_swc">SWChigh</option>
                    </optgroup>

                    <?php if ($nValidationColumns > 0) { ?>
                    <optgroup label="Calibration Data">
                        <?php if ($nValidationColumns > 0) { ?>
                            <option value="ucd1"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD1</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 1) { ?>
                            <option value="ucd2"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD2</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 2) { ?>
                            <option value="ucd3"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD3</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 3) { ?>
                            <option value="ucd4"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD4</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 4) { ?>
                            <option value="ucd5"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD5</span></option>
                        <?php } ?>
                    </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="col-1 axis-wrapper">
                <div class="custom-control axis-control">
                    <input type="checkbox" class="custom-control-input y-axis" id="trace3-axis">
                </div>
            </div>

            <div class="col-2">
                <select class="custom-select trace-select" id="graph_trace_4">
                    <option selected value="none"><span>None</span></option>
                    
                    <optgroup label="Input Data">
                        <option value="temp">TEMP</option>
                        <option value="precip">TOTPP</option>
                        <option value="rain">RAIN</option>
                        <option value="et">ETA</option>
                    </optgroup>
                    
                    <optgroup label="Output Data">          
                        <option value="snow">SNOF</option>
                        <option value="water_or_sr">WATisrf</option>
                        <option value="inf_cap_corr">INFact</option>
                        <option value="drafre">DRAfre</option>
                        <option value="drain_corr">DRAfin</option>
                        <option value="drain_boost_excess">DRAbinf</option>
                        <option value="drain_boost_oversat">DRAoss</option>
                        <option value="drain_total">DRAact</option>
                        <option value="etisi">ETisi</option>
                        <option value="et_corr">ETcds</option>
                        <option value="etfsas">ETfsas</option>
                        <option value="swcint">SWCint</option>
                        <option value="swc_corr_sat">SWCfinmm</option>
                        <option value="swc_corr_sat_pc">SWCfin</option> 
                        <option value="sr_exc">SReinf</option>
                        <option value="sr_exc_less_drain">SReinfDB</option>
                        <option value="sr_sat">SResas</option>
                        <option value="sr_sat_less_drain">SResasDB</option>
                        <option value="sr_total">SRTint</option>
                        <option value="sr_total_less_drain">SRTact</option>
                        <option value="net_gain">SWCgain</option>
                        <option value="net_loss">SWCloss</option>
                        <option value="days_low_swc">SWClow</option>
                        <option value="days_high_swc">SWChigh</option>
                    </optgroup>

                    <?php if ($nValidationColumns > 0) { ?>
                    <optgroup label="Calibration Data">
                        <?php if ($nValidationColumns > 0) { ?>
                            <option value="ucd1"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD1</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 1) { ?>
                            <option value="ucd2"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD2</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 2) { ?>
                            <option value="ucd3"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD3</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 3) { ?>
                            <option value="ucd4"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD4</span></option>
                        <?php } ?>
                        <?php if ($nValidationColumns > 4) { ?>
                            <option value="ucd5"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD5</span></option>
                        <?php } ?>
                    </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="col-1 axis-wrapper">
                <div class="custom-control axis-control">
                    <input type="checkbox" class="custom-control-input y-axis" id="trace4-axis">
                </div>
            </div>
        </div>        

        <div class="row no-gutters">
            <div class="col px-3" id="graphContainer">
                <div id="myGraph"></div>
            </div>    
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

            <div class="row py-1 pt-3">
                <div class="col-12 d-flex justify-content-left">            
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="2"><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="3"><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></a>
                    <a class="btn btn-outline-dark btn-sm col-hide-button toggle-vis" data-column="4"><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></a>
                </div>
            </div>

            <div class="row py-1">
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

            <div class="row py-1">
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
                        <a class="btn btn-outline-danger btn-sm active col-hide-button toggle-vis" data-column="<?= 29+$i ?>"><span data-toggle="tooltip" title="<?= $tooltips[$colName] ?>"><?= $colName ?></span></a>
                    <?php } ?>            
                </div>
            </div>
            <?php } ?>
        
            <div>&nbsp;</div>

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
                <option value="23">Typical Year Average</option>                        -->
            </select>
        </div>
    </div>

    <div class="row borderedSection my-1 mx-5" id="calibrationWrapper">
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

<script>
    var myGraph = document.getElementById('myGraph');     

    var inputGraphObj = {
        nticks: 12,
        layout: null,
        fig: null,        
        graphSource: null,
        trace1: null,
        trace2: null,
        trace3: null,
        trace4: null,

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

        setGraphSource: function(sourceId) {
            this.graphSource = sourceId;
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

        initTraces: function() {
            this.trace1 = {
                name: 'trace1',
                type: '',
                index: 1,
                yaxis: 'y'                
            };

            this.trace2 = {
                name: 'trace2',
                type: '',
                index: 2,
                yaxis: 'y',
            };

            this.trace3 = {
                name: 'trace3',
                type: '',
                index: 3,
                yaxis: 'y'                
            };

            this.trace4 = {
                name: 'trace4',
                type: '',
                index: 4,
                yaxis: 'y'
            };
        },

        setTraceType: function(trace, elem) {
            // console.log('trace ' + trace + ' should be ' + elem);  
            switch(trace) {
                case 1:                              
                    this.trace1.type = elem;
                    this.trace1.name = this.getTraceName(elem);
                    break;
                case 2:
                    this.trace2.type = elem;
                    this.trace2.name = this.getTraceName(elem);
                    break;
                case 3: 
                    this.trace3.type = elem;
                    this.trace3.name = this.getTraceName(elem);
                    break;
                case 4: 
                    this.trace4.type = elem;
                    this.trace4.name = this.getTraceName(elem);
                    break;
            }
        },

        setTraceValues: function(trace, response) {
            var newTrace = {
            y: response.data
            };

            switch (trace) {
                case 1:                              
                    $.extend(this.trace1, newTrace);
                    // console.log(this.trace1);
                    break;
                case 2:
                    $.extend(this.trace2, newTrace);
                    // console.log(this.trace2);
                    break;
                case 3: 
                    $.extend(this.trace3, newTrace);
                    // console.log(this.trace3);
                    break;
                case 4: 
                    $.extend(this.trace4, newTrace);
                    // console.log(this.trace4);
                    break;
            }            
        },

        getTraceName: function(elem) {
            switch (elem) {        
                case 'temp':
                    return 'TEMP (&deg;C)';                
                case 'precip':
                    return 'TOTPP (mm)';
                case 'rain':
                    return 'RAIN (mm)';
                case 'et':
                    return 'ETA (mm)';
                case 'ucd1': 
                    return 'UCD1';
                case 'ucd2': 
                    return 'UCD2';
                case 'ucd3': 
                    return 'UCD3';
                case 'ucd4': 
                    return 'UCD4';
                case 'ucd5': 
                    return 'UCD5';
                case 'snow':
                    return 'SNOF (mm)';
                case 'water_or_sr': 
                    return 'WATisrf (mm)';
                case 'inf_cap_corr': 
                    return 'INFact (mm)';
                case 'drafre': 
                    return 'DRAfre (mm)';
                case 'drain_corr': 
                    return 'DRAfin (mm)';
                case 'drain_boost_excess': 
                    return 'DRAbinf (mm)';
                case 'drain_boost_oversat':
                    return 'DRAoss (mm)';
                case 'drain_total':
                    return 'DRAact (mm)';
                case 'etisi':
                    return 'ETisi (mm)';
                case 'et_corr':
                    return 'ETcds (mm)';
                case 'etfsas':
                    return 'ETfsas (mm)';
                case 'swcint':
                    return 'SWCint (mm)';
                case 'swc_corr_sat':
                    return 'SWCfinmm (mm)';
                case 'swc_corr_sat_pc':
                    return 'SWCfin (%)';
                case 'sr_exc':
                    return 'SReinf (mm)';
                case 'sr_exc_less_drain':
                    return 'SReinfDB (mm)';
                case 'sr_sat':
                    return 'SResas (mm)';
                case 'sr_sat_less_drain':
                    return 'SResasDB (mm)';
                case 'sr_total':
                    return 'SRTint (mm)';
                case 'sr_total_less_drain':
                    return 'SRTact (mm)';
                case 'net_gain':
                    return 'SWCgain (mm)';
                case 'net_loss':
                    return 'SWCloss (mm)';
                case 'days_low_swc':
                    return 'SWClow (days)';
                case 'days_high_swc':
                    return 'SWChigh (days)';
            }        
        },
                
        setTimeData: function(response) {
            var newTrace = {
                x: response.data
            };

            this.nticks = 12;
            // refresh the number of ticks if needed
            if (response.data.length < this.nticks) {
                this.nticks = response.data.length;
            }

            $.extend(inputGraphObj.getDefaultTrace(this.graphSource), newTrace);
            // console.log('setting time data', this.defaultTrace);
        },

        setLayout: function(source) {
            var myTickFormat = null;
            switch (parseInt(source)) {
                case 1:
                    myTickFormat = '%d-%b-%Y';
                    break;
                case 21:
                    myTickFormat = '%d-%b';
                    break;
                default:
                    myTickFormat = null;
            }

            var titleVal = 'Soil Water Data';
            var yAxisVal = null;
            var yAxis2Val = null;

            this.layout = {
                title: {
                    text: titleVal,
                    font: "Times New Roman"
                },
                autosize: true,
                xaxis: {
                    nticks: this.nticks,  
                    tickformat: myTickFormat,
                    tickangle: 30,
                    ticks: 'outside',
                    showgrid: true,
                    gridcolor: '#bdbdbd',
                    gridwidth: 1
                },
                yaxis: {
                    title: yAxisVal,
                    showgrid: true,
                    gridcolor: '#bdbdbd',
                    gridwidth: 1
                },
                yaxis2: {
                    title: yAxis2Val,
                    overlaying: 'y',
                    side: 'right',
                    showgrid: true,
                    gridcolor: '#bdbdbd',
                    gridwidth: 1
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

        setFig: function() {
            var traces = [];

            if (this.trace1.type.indexOf('none') == -1) {
                traces.push($.extend({}, inputGraphObj.getDefaultTrace(this.graphSource), this.trace1));
            } else {
                traces = traces.filter(function(item) {
                    return item.index != 1;
                });
            }

            if (this.trace2.type.indexOf('none') == -1) {
                traces.push($.extend({}, inputGraphObj.getDefaultTrace(this.graphSource), this.trace2));            
            } else {
                traces = traces.filter(function(item) {
                    return item.index != 2;
                });
            }

            if (this.trace3.type.indexOf('none') == -1) {
                traces.push($.extend({}, inputGraphObj.getDefaultTrace(this.graphSource), this.trace3));
            } else {
                traces = traces.filter(function(item) {
                    return item.index != 3;
                });
            }

            if (this.trace4.type.indexOf('none') == -1) {
                traces.push($.extend({}, inputGraphObj.getDefaultTrace(this.graphSource), this.trace4));                            
            } else {
                traces = traces.filter(function(item) {
                    return item.index != 4;
                });
            }

            this.fig = {
                data: traces,
                layout: this.layout
            };

            // console.log(this.fig);
        },              

        toggleGraphAxis: function(trace) {
            // console.log('changing axis for ' + trace);

            switch (trace) {
                case 1:
                    if (!this.trace1.yaxis.localeCompare('y2')) {
                        this.trace1.yaxis = 'y';
                    } else {
                        this.trace1.yaxis = 'y2';
                    }
                    break;
                case 2:
                    if (!this.trace2.yaxis.localeCompare('y2')) {
                        this.trace2.yaxis = 'y';
                    } else {
                        this.trace2.yaxis = 'y2';
                    }
                    break;
                case 3:
                    if (!this.trace3.yaxis.localeCompare('y2')) {
                        this.trace3.yaxis = 'y';
                    } else {
                        this.trace3.yaxis = 'y2';
                    }
                    break;
                case 4:
                    if (!this.trace4.yaxis.localeCompare('y2')) {
                        this.trace4.yaxis = 'y';
                    } else {
                        this.trace4.yaxis = 'y2';
                    }
                    break;                
            }
        },       

        refreshGraph: function(trace, holdRefresh = false) {
            var that = this;
            // console.log('refreshing trace ' + trace);                
            
            return new Promise((resolve, reject) => {
                switch(trace) {
                    case 1:
                        // console.log('trace type is ' + that.trace1.type);
                        if (that.trace1.type.indexOf('none') == -1) {
                            getTraceData(that.graphSource, that.trace1.type).then(function(response) {
                                $('#graphWrapper').show();
                                inputGraphObj.setTraceValues(1, response);                        
                                inputGraphObj.setLayout(that.graphSource);
                                inputGraphObj.setFig();
                                if (!holdRefresh) {
                                    Plotly.react(myGraph, inputGraphObj.fig);  
                                }
                                resolve(); 
                            }).catch(function(error) {
                                // console.log(error);
                            });
                        } else {
                            inputGraphObj.setLayout(that.graphSource);
                            inputGraphObj.setFig();
                            if (!holdRefresh) {
                                Plotly.react(myGraph, inputGraphObj.fig);  
                            }
                            resolve();
                        }
                        break;
                    case 2:
                        // console.log('trace type is ' + that.trace2.type);
                        if (that.trace2.type.indexOf('none') == -1) {
                            getTraceData(that.graphSource, that.trace2.type).then(function(response) {
                                $('#graphWrapper').show();
                                inputGraphObj.setTraceValues(2, response);                        
                                inputGraphObj.setLayout(that.graphSource);
                                inputGraphObj.setFig();
                                if (!holdRefresh) {
                                    Plotly.react(myGraph, inputGraphObj.fig);  
                                }
                                resolve();
                            }).catch(function(error) {
                                // console.log(error);
                            });
                        } else {
                            inputGraphObj.setLayout(that.graphSource);
                            inputGraphObj.setFig();
                            if (!holdRefresh) {
                                Plotly.react(myGraph, inputGraphObj.fig);  
                            }
                            resolve();
                        }
                        break;
                    case 3:
                        // console.log('trace type is ' + that.trace3.type);
                        if (that.trace3.type.indexOf('none') == -1) {                            
                            getTraceData(that.graphSource, that.trace3.type).then(function(response) {
                                $('#graphWrapper').show();
                                inputGraphObj.setTraceValues(3, response);   
                                inputGraphObj.setLayout(that.graphSource);
                                inputGraphObj.setFig();
                                if (!holdRefresh) {
                                    Plotly.react(myGraph, inputGraphObj.fig);  
                                }                       
                                resolve();
                            }).catch(function(error) {
                                // console.log(error);
                            });
                        } else {
                            inputGraphObj.setLayout(that.graphSource);
                            inputGraphObj.setFig();
                            if (!holdRefresh) {
                                Plotly.react(myGraph, inputGraphObj.fig);  
                            }
                            resolve();
                        }
                        break;
                    case 4:
                        // console.log('trace type is ' + that.trace4.type);
                        if (that.trace4.type.indexOf('none') == -1) {
                            getTraceData(that.graphSource, that.trace4.type).then(function(response) {
                                $('#graphWrapper').show();
                                inputGraphObj.setTraceValues(4, response);  
                                inputGraphObj.setLayout(that.graphSource);
                                inputGraphObj.setFig();
                                if (!holdRefresh) {
                                    Plotly.react(myGraph, inputGraphObj.fig);  
                                }                         
                                resolve();
                            }).catch(function(error) {
                                // console.log(error);
                            });
                        } else {
                            inputGraphObj.setLayout(that.graphSource);
                            inputGraphObj.setFig();
                            if (!holdRefresh) {
                                Plotly.react(myGraph, inputGraphObj.fig);  
                            }
                            resolve();
                        }
                        break;
                }
            });                           
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
                    // statsTable.clear().draw();

                    var startResponse = await getTimeIndexValue(Math.floor(eventdata['xaxis.range[0]']));
                    // console.log('start returned ' + JSON.stringify(startResponse));
                    var endResponse = await getTimeIndexValue(Math.ceil(eventdata['xaxis.range[1]']));           
                    // console.log('end returned ' + JSON.stringify(endResponse));

                    statsTableStart = startResponse.data;
                    statsTableEnd = endResponse.data;
                    // console.log(statsTableStart);
                    // console.log(statsTableEnd);
                    $(".start_date_filter").val(statsTableStart);
                    $(".end_date_filter").val(statsTableEnd);
                    
                    validateStatsFilter();    
                    
                    $(".stats_interval_details").text(' (selected interval)');                    
                    // $('#statsDataTable').DataTable().ajax.reload();
                }            
            }
        );

        $(".stats_interval_details").text(' (complete dataset)');                

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
            serverSide: true,
            deferLoading: 4,
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
                },
                {
                    targets: [1, 2, 3, 4, 7, 8, 9, 10, 12, 13, 14, 15, 16, 18, 19, 20, 21, 22],
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
                        return 'SNOW BUDDY_soilStats_' + now;
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
                        return 'SNOW BUDDY_soilCalib_' + now;
                    }
                }             
            ],
            "drawCallback": function() {                
            }
        });

        $('#calib_type').change(function() {
            $('#calibDataTable').DataTable().ajax.reload();
        });
        
        // switches
        $(".y-axis").bootstrapSwitch('size', 'small');
        $(".y-axis").bootstrapSwitch('onText', 'Left');
        $(".y-axis").bootstrapSwitch('offText', 'Right');
        $(".y-axis").bootstrapSwitch('labelText', 'Axis');
        $(".y-axis").bootstrapSwitch('offColor', 'success');
        $(".y-axis").bootstrapSwitch('state', true);  

        // graph stuff - initialized for source 1 (input daily) and type temp
        getTimeData(1).then(function(response) {
            inputGraphObj.initTraces();
            inputGraphObj.setGraphSource(1);
            inputGraphObj.setTimeData(response);
            inputGraphObj.setTraceType(1, 'temp');
            inputGraphObj.setTraceType(2, 'none');
            inputGraphObj.setTraceType(3, 'none');
            inputGraphObj.setTraceType(4, 'none');
            inputGraphObj.refreshGraph(1);
        }).catch(function(error) {
            // console.log(error);
        });

        // toggle Graph Type
        $('#graph_trace_1').change(async function () {
            // console.log('trace1 should be ' + $(this).val());
            $(".custom-select").attr("disabled", "disabled");
            inputGraphObj.setTraceType(1, $(this).val());
            await inputGraphObj.refreshGraph(1);
            $(".custom-select").attr("disabled", false);
        });
        $('#graph_trace_2').change(async function () {
            // console.log('trace2 should be ' + $(this).val());
            $(".custom-select").attr("disabled", "disabled");
            inputGraphObj.setTraceType(2, $(this).val());
            await inputGraphObj.refreshGraph(2);
            $(".custom-select").attr("disabled", false);
        });
        $('#graph_trace_3').change(async function () {
            // console.log('trace3 should be ' + $(this).val());
            $(".custom-select").attr("disabled", "disabled");
            inputGraphObj.setTraceType(3, $(this).val());
            await inputGraphObj.refreshGraph(3);
            $(".custom-select").attr("disabled", false);
        });
        $('#graph_trace_4').change(async function () {
            // console.log('trace4 should be ' + $(this).val());
            $(".custom-select").attr("disabled", "disabled");
            inputGraphObj.setTraceType(4, $(this).val());
            await inputGraphObj.refreshGraph(4);
            $(".custom-select").attr("disabled", false);
        }); 

        // toggle axis left/right
        $(".y-axis").on('switchChange.bootstrapSwitch', function(e, data) {
            switch ($(this).attr('id')) {
                case 'trace1-axis':
                    inputGraphObj.toggleGraphAxis(1);
                    inputGraphObj.refreshGraph(1); 
                    break;
                case 'trace2-axis': 
                    inputGraphObj.toggleGraphAxis(2);
                    inputGraphObj.refreshGraph(2);
                    break;
                case 'trace3-axis': 
                    inputGraphObj.toggleGraphAxis(3);
                    inputGraphObj.refreshGraph(3);
                    break;
                case 'trace4-axis': 
                    inputGraphObj.toggleGraphAxis(4);
                    inputGraphObj.refreshGraph(4);
                    break;
            }           
        });

        // toggle Graph Source
        $('#graph_source').change(function() {
            var graphSource = $(this).val();     
            $(".custom-select").attr("disabled", "disabled");            

            getTimeData(graphSource).then(async function(response) {
                inputGraphObj.setGraphSource(graphSource);
                inputGraphObj.setTimeData(response);                
                await inputGraphObj.refreshGraph(1, true);
                await inputGraphObj.refreshGraph(2, true);
                await inputGraphObj.refreshGraph(3, true);
                await inputGraphObj.refreshGraph(4), true;
                $(".custom-select").attr("disabled", false);
                Plotly.react(myGraph, inputGraphObj.fig); 
            }).catch(function(error) {
                // console.log(error);
            });            
        });

        // stats filter stuff
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
            // var mainColumn = mainTable.column($(this).attr('data-column'));
            var statsColumn = statsTable.column($(this).attr('data-column') - 1);
    
            // Toggle the visibility
            // mainColumn.visible(!mainColumn.visible());
            statsColumn.visible(!statsColumn.visible());
        });
    });
</script>