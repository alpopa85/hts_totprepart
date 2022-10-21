<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">   
        <form method="post" id="uploadParamsForm" action="upload-param-file" enctype="multipart/form-data">                            
            <div id="upload_param_input_group" class="input-group mb-3 form-red-border">           
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="filename" name="inputDataFile" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="fileHelp">Upload configuration file</label>
                </div>
            </div>                                      

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name ="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
            <!-- END OF CAKE FORM FIELDS !-->
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Upload Parameter Data</button>                    
            </div>        
        </form>  
    </div>
</div>

<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">
        <form id="analysisForm" method="post" action="perform-analysis">

            <div id="accordion">
                <div class="card active">
                    <div class="card-header myAccordionHeader" id="headingOne">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-flex justify-content-between" type="button">
                                <span>Starting values</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">  <!-- STARTING VALUES -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param13-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['SWCinit'] ?>">SWCinit (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SWCinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="1 to 100" aria-label="Param13" aria-describedby="param13-addon" name="swc_init" value="<?= !empty($paramData['swc_init']) ? $paramData['swc_init'] : 80.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param14-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['SRinit'] ?>">SRinit (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['SRinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param14" aria-describedby="param14-addon" name="sr_init" value="<?= !empty($paramData['sr_init']) ? $paramData['sr_init'] : 0.00; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param15-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['NGinit'] ?>">NGinit (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['NGinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param15" aria-describedby="param15-addon" name="ng_init" value="<?= !empty($paramData['ng_init']) ? $paramData['ng_init'] : 0.00; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param16-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['NLinit'] ?>">NLinit (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['NLinit_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param16" aria-describedby="param16-addon" name="nl_init" value="<?= !empty($paramData['nl_init']) ? $paramData['nl_init'] : 0.00; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingTwo">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-flex justify-content-between collapsed" type="button">
                                <span>Layer properties</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">  <!-- LAYER PROPS -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param0-layer-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THKN'] ?>">THKN (mm)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THKN_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param0-layer" aria-describedby="param0-layer-addon" name="thkn" value="<?= !empty($paramData['thkn']) ? $paramData['thkn'] : 1000; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param1-layer-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['PORe'] ?>">PORe (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['PORe_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param1-layer" aria-describedby="param1-layer-addon" name="por_e" value="<?= !empty($paramData['por_e']) ? $paramData['por_e'] : 31.0; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingThree">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="d-flex justify-content-between collapsed" type="button">
                                <span>Infiltration coefficients</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">  <!-- INFILTRATION -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param0-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRinfLH'] ?>">THRinfLH (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRinfLH_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param0" aria-describedby="param0-addon" name="thr_inf_lh" value="<?= !empty($paramData['thr_inf_lh']) ? $paramData['thr_inf_lh'] : 75.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param1-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['INFlr'] ?>">INFlr (mm/hr)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['INFlr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param1" aria-describedby="param1-addon" name="inf_lr" value="<?= !empty($paramData['inf_lr']) ? $paramData['inf_lr'] : 2.500; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param2-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['INFhr'] ?>">INFhr (mm/hr)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['INFhr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param2" aria-describedby="param2-addon" name="inf_hr" value="<?= !empty($paramData['inf_hr']) ? $paramData['inf_hr'] : 0.900; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingFour">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="d-flex justify-content-between collapsed" type="button">
                                <span>Drainage coefficients</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">  <!-- DRAINAGE -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param3-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRdraHL'] ?>">THRdraHL (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRdraHL_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param3" aria-describedby="param3-addon" name="thr_inf_hl" value="<?= !empty($paramData['thr_inf_hl']) ? $paramData['thr_inf_hl'] : 85.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param4-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['DRAlr'] ?>">DRAlr (mm/hr)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['DRAlr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param4" aria-describedby="param4-addon" name="dra_lr" value="<?= !empty($paramData['dra_lr']) ? $paramData['dra_lr'] : 0.015; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param5-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['DRAhr'] ?>">DRAhr (mm/hr)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['DRAhr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="&ge; 0" aria-label="Param5" aria-describedby="param5-addon" name="dra_hr" value="<?= !empty($paramData['dra_hr']) ? $paramData['dra_hr'] : 0.080; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param6-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRswstd'] ?>">THRswstd (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRswstd_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param6" aria-describedby="param6-addon" name="thr_swsd" value="<?= !empty($paramData['thr_swsd']) ? $paramData['thr_swsd'] : 40.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param7-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRtstd'] ?>">THRtstd (&deg;C)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRtstd_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="-20 to 10" aria-label="Param7" aria-describedby="param7-addon" name="thr_tsd" value="<?= !empty($paramData['thr_tsd']) ? $paramData['thr_tsd'] : -7.00; ?>">
                                </div>
                            </div>      
                            
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param8-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFeidr'] ?>">CFeidr</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFeidr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 1" aria-label="Param8" aria-describedby="param8-addon" name="cf_eidr" value="<?= !empty($paramData['cf_eidr']) ? $paramData['cf_eidr'] : 0.50; ?>">
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param9-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFosdr'] ?>">CFosdr</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['CFosdr_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 1" aria-label="Param9" aria-describedby="param9-addon" name="cf_osdr" value="<?= !empty($paramData['cf_osdr']) ? $paramData['cf_osdr'] : 0.50; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingFive">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" class="d-flex justify-content-between collapsed" type="button">
                                <span>Other coefficients</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">  <!-- OTHER -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param10-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['CFets'] ?>">CFets</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="This parameter was locked in the Snow Module"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param13" aria-describedby="param13-addon" name="cf_ets"                    
                                    value="<?= !empty($paramData['cf_ets']) ? $paramData['cf_ets'] : 0.80; ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param10-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRets'] ?>">THRets (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRets_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param10" aria-describedby="param10-addon" name="thr_ets" value="<?= !empty($paramData['thr_ets']) ? $paramData['thr_ets'] : 65.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param11-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRlw'] ?>">THRlw (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRlw_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param11" aria-describedby="param11-addon" name="thr_lw" value="<?= !empty($paramData['thr_lw']) ? $paramData['thr_lw'] : 65.0; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label-addon text-center limit-txt-width" id="param12-addon">
                                            <span data-toggle="tooltip" title="<?= $tooltips['THRhw'] ?>">THRhw (%)</span>
                                            <div class="accepted-units-tooltip">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['THRhw_val'] ?>"></i>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0 to 100" aria-label="Param12" aria-describedby="param12-addon" name="thr_hw" value="<?= !empty($paramData['thr_hw']) ? $paramData['thr_hw'] : 90.0; ?>">
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

                <?php if ($nValidationColumns) { ?>
                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingUcd">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseUcd" aria-expanded="false" aria-controls="collapseUcd" class="d-flex justify-content-between collapsed" type="button">
                                <span>Calibration mapping</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseUcd" class="collapse" aria-labelledby="headingUcd" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table table-borderless table-sm px-5 graph-params">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Model Output</th>
                                        <th scope="col" class="text-center">Calibration Data</th>
                                    </tr>
                                <tbody>                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output1_select" name="output1_select" placeholder="Model Output...">
                                                <option value="snow_mm" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOF</option>
                                                <option value="water_or_sr" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'water_or_sr') == 0) ? 'selected' : ''?>>WATisrf</option>
                                                <option value="inf_cap_corr" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'inf_cap_corr') == 0) ? 'selected' : ''?>>INFact</option>
                                                <option value="drafre" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'drafre') == 0) ? 'selected' : ''?>>DRAfre</option>
                                                <option value="drain_corr" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'drain_corr') == 0) ? 'selected' : ''?>>DRAfin</option>
                                                <option value="drain_boost_excess" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'drain_boost_excess') == 0) ? 'selected' : ''?>>DRAbinf</option>
                                                <option value="drain_boost_oversat" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'drain_boost_oversat') == 0) ? 'selected' : ''?>>DRAoss</option>
                                                <option value="drain_total" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'drain_total') == 0) ? 'selected' : ''?>>DRAact</option>
                                                <option value="etisi" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'etisi') == 0) ? 'selected' : ''?>>ETisi</option>
                                                <option value="et_corr" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'et_corr') == 0) ? 'selected' : ''?>>ETcds</option>
                                                <option value="etfsas" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'etfsas') == 0) ? 'selected' : ''?>>ETfsas</option>
                                                <option value="swcint" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'swcint') == 0) ? 'selected' : ''?>>SWCint</option>
                                                <option value="swc_corr_sat" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'swc_corr_sat') == 0) ? 'selected' : ''?>>SWCfinmm</option>
                                                <option value="swc_corr_sat_pc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'swc_corr_sat_pc') == 0) ? 'selected' : ''?>>SWCfin</option>
                                                <option value="sr_exc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_exc') == 0) ? 'selected' : ''?>>SReinf</option>
                                                <option value="sr_exc_less_drain" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_exc_less_drain') == 0) ? 'selected' : ''?>>SReinfDB</option>
                                                <option value="sr_sat" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_sat') == 0) ? 'selected' : ''?>>SResas</option>
                                                <option value="sr_sat_less_drain" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_sat_less_drain') == 0) ? 'selected' : ''?>>SResasDB</option>
                                                <option value="sr_total" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_total') == 0) ? 'selected' : ''?>>SRTint</option>
                                                <option value="sr_total_less_drain" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'sr_total_less_drain') == 0) ? 'selected' : ''?>>SRTact</option>
                                                <option value="net_gain" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'net_gain') == 0) ? 'selected' : ''?>>SWCgain</option>
                                                <option value="net_loss" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'net_loss') == 0) ? 'selected' : ''?>>SWCloss</option>
                                                <option value="days_low_swc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'days_low_swc') == 0) ? 'selected' : ''?>>SWClow</option>
                                                <option value="days_high_swc" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'days_high_swc') == 0) ? 'selected' : ''?>>SWChigh</option>
                                            </select>                                                                 
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd1_select" name="ucd1_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd1_field']) && strcmp($calibration['ucd1_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>   
                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output2_select" name="output2_select" placeholder="Model Output...">
                                                <option value="snow_mm" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'snow_mm') == 0) ? 'selected' : ''?>>SNOF</option>
                                                <option value="water_or_sr" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'water_or_sr') == 0) ? 'selected' : ''?>>WATisrf</option>
                                                <option value="inf_cap_corr" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'inf_cap_corr') == 0) ? 'selected' : ''?>>INFact</option>
                                                <option value="drafre" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'drafre') == 0) ? 'selected' : ''?>>DRAfre</option>
                                                <option value="drain_corr" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'drain_corr') == 0) ? 'selected' : ''?>>DRAfin</option>
                                                <option value="drain_boost_excess" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'drain_boost_excess') == 0) ? 'selected' : ''?>>DRAbinf</option>
                                                <option value="drain_boost_oversat" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'drain_boost_oversat') == 0) ? 'selected' : ''?>>DRAoss</option>
                                                <option value="drain_total" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'drain_total') == 0) ? 'selected' : ''?>>DRAact</option>
                                                <option value="etisi" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'etisi') == 0) ? 'selected' : ''?>>ETisi</option>
                                                <option value="et_corr" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'et_corr') == 0) ? 'selected' : ''?>>ETcds</option>
                                                <option value="etfsas" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'etfsas') == 0) ? 'selected' : ''?>>ETfsas</option>
                                                <option value="swcint" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'swcint') == 0) ? 'selected' : ''?>>SWCint</option>
                                                <option value="swc_corr_sat" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'swc_corr_sat') == 0) ? 'selected' : ''?>>SWCfinmm</option>
                                                <option value="swc_corr_sat_pc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'swc_corr_sat_pc') == 0) ? 'selected' : ''?>>SWCfin</option>
                                                <option value="sr_exc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_exc') == 0) ? 'selected' : ''?>>SReinf</option>
                                                <option value="sr_exc_less_drain" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_exc_less_drain') == 0) ? 'selected' : ''?>>SReinfDB</option>
                                                <option value="sr_sat" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_sat') == 0) ? 'selected' : ''?>>SResas</option>
                                                <option value="sr_sat_less_drain" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_sat_less_drain') == 0) ? 'selected' : ''?>>SResasDB</option>
                                                <option value="sr_total" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_total') == 0) ? 'selected' : ''?>>SRTint</option>
                                                <option value="sr_total_less_drain" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'sr_total_less_drain') == 0) ? 'selected' : ''?>>SRTact</option>
                                                <option value="net_gain" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'net_gain') == 0) ? 'selected' : ''?>>SWCgain</option>
                                                <option value="net_loss" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'net_loss') == 0) ? 'selected' : ''?>>SWCloss</option>
                                                <option value="days_low_swc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'days_low_swc') == 0) ? 'selected' : ''?>>SWClow</option>
                                                <option value="days_high_swc" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'days_high_swc') == 0) ? 'selected' : ''?>>SWChigh</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd2_select" name="ucd2_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd2_field']) && strcmp($calibration['ucd2_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>                                            

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-success">Run Water Balance Analysis</button>
            </div>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e"></script>
<script type="module">
    //import {getCookie} from "../js/project.js";         
    
    function validateParamsForm() {
        if (!$('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', true);
            $('#uploadParamsForm').find(':input[type=submit]').addClass('disabled');
        } else {
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', false);
            $('#uploadParamsForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    function validateForm() {
        $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
        $('#analysisForm').find(':input[type=submit]').addClass('disabled');

        var field0Value = $('#analysisForm').find(':input[name=thkn]').val();
        var field1Value = $('#analysisForm').find(':input[name=por_e]').val();
        var field2Value = $('#analysisForm').find(':input[name=thr_inf_lh]').val();
        var field3Value = $('#analysisForm').find(':input[name=inf_lr]').val();
        var field4Value = $('#analysisForm').find(':input[name=inf_hr]').val();
        var field5Value = $('#analysisForm').find(':input[name=thr_inf_hl]').val();
        var field6Value = $('#analysisForm').find(':input[name=dra_lr]').val();
        var field7Value = $('#analysisForm').find(':input[name=dra_hr]').val();
        var field8Value = $('#analysisForm').find(':input[name=thr_swsd]').val();
        var field9Value = $('#analysisForm').find(':input[name=thr_tsd]').val();
        var field10Value = $('#analysisForm').find(':input[name=cf_eidr]').val();
        var field11Value = $('#analysisForm').find(':input[name=cf_osdr]').val();
        var field12Value = $('#analysisForm').find(':input[name=thr_ets]').val();
        var field13Value = $('#analysisForm').find(':input[name=thr_lw]').val();
        var field14Value = $('#analysisForm').find(':input[name=thr_hw]').val();
        var field15Value = $('#analysisForm').find(':input[name=swc_init]').val();
        var field16Value = $('#analysisForm').find(':input[name=sr_init]').val();
        var field17Value = $('#analysisForm').find(':input[name=ng_init]').val();
        var field18Value = $('#analysisForm').find(':input[name=nl_init]').val();

        if (field0Value && field1Value && field2Value && field3Value && field4Value && field5Value && field6Value && field7Value &&
        field8Value && field9Value && field10Value && field11Value && field12Value && field13Value && field14Value && field15Value && field16Value &&
        field17Value && field18Value) {
            
            if (field0Value < 0) {
                $('#analysisForm').find(':input[name=thkn]').val(0)
            }

            if (field1Value < 1) {
                $('#analysisForm').find(':input[name=por_e]').val(1);
            }

            if (field1Value > 100) {
                $('#analysisForm').find(':input[name=por_e]').val(100);
            }

            if (field2Value < 0) {
                $('#analysisForm').find(':input[name=thr_inf_lh]').val(0);
            }

            if (field2Value > 100) {
                $('#analysisForm').find(':input[name=thr_inf_lh]').val(100);
            }

            if (field3Value < 0) {
                $('#analysisForm').find(':input[name=inf_lr]').val(0);
            }

            if (field4Value < 0) {
                $('#analysisForm').find(':input[name=inf_hr]').val(0);
            }

            if (field5Value < 0) {
                $('#analysisForm').find(':input[name=thr_inf_hl]').val(0);
            }

            if (field5Value > 100) {
                $('#analysisForm').find(':input[name=thr_inf_hl]').val(100);
            }

            if (field6Value < 0) {
                $('#analysisForm').find(':input[name=dra_lr]').val(0);
            }

            if (field7Value < 0) {
                $('#analysisForm').find(':input[name=dra_hr]').val(0);
            }

            if (field8Value < 0) {
                $('#analysisForm').find(':input[name=thr_swsd]').val(0);
            }

            if (field8Value > 100) {
                $('#analysisForm').find(':input[name=thr_swsd]').val(100);
            }              

            if (field9Value < -20) {
                $('#analysisForm').find(':input[name=thr_tsd]').val(-20);
            }

            if (field9Value > 10) {
                $('#analysisForm').find(':input[name=thr_tsd]').val(10);
            }

            if (field10Value < 0) {
                $('#analysisForm').find(':input[name=cf_eidr]').val(0);
            }

            if (field10Value > 1) {
                $('#analysisForm').find(':input[name=cf_eidr]').val(1);
            }

            if (field11Value < 0) {
                $('#analysisForm').find(':input[name=cf_osdr]').val(0);
            }

            if (field11Value > 1) {
                $('#analysisForm').find(':input[name=cf_osdr]').val(1);
            }

            if (field12Value < 0) {
                $('#analysisForm').find(':input[name=thr_ets]').val(0);
            }

            if (field12Value > 100) {
                $('#analysisForm').find(':input[name=thr_ets]').val(100);
            }             

            if (field13Value < 0) {
                $('#analysisForm').find(':input[name=thr_lw]').val(0);
            }

            if (field13Value > 100) {
                $('#analysisForm').find(':input[name=thr_lw]').val(100);
            }

            if (field14Value < 0) {
                $('#analysisForm').find(':input[name=thr_hw]').val(0);
            }

            if (field14Value > 100) {
                $('#analysisForm').find(':input[name=thr_hw]').val(100);
            }

            if (field15Value < 1) {
                $('#analysisForm').find(':input[name=swc_init]').val(1);
            }

            if (field15Value > 100) {
                $('#analysisForm').find(':input[name=swc_init]').val(100);
            }            

            if (field16Value < 0) {
                $('#analysisForm').find(':input[name=sr_init]').val(0);
            }

            if (field17Value < 0) {
                $('#analysisForm').find(':input[name=ng_init]').val(0);
            }

            if (field18Value < 0) {
                $('#analysisForm').find(':input[name=nl_init]').val(0);
            }

            $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
            $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
        }
    }

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        validateParamsForm();
        validateForm();       
        
        $('#uploadParamsForm').find(':input[name=inputDataFile]').change(function(){     
            // alert($('#uploadParamsForm').find(':input[name=inputDataFile]').val());
            if ($('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
                $("#upload_param_input_group").removeClass("form-red-border");        
                $("#upload_param_input_group").addClass("form-green-border");        
            } else {
                $("#upload_param_input_group").removeClass("form-green-border");        
                $("#upload_param_input_group").addClass("form-red-border");  
            }
            
            validateParamsForm();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#analysisForm').find(':input[name=thkn]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=por_e]').change(function() {
            if ($(this).val() < 1) {
                $(this).val(1);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_inf_lh]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=inf_lr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=inf_hr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_inf_hl]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=dra_lr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=dra_hr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_swsd]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_tsd]').change(function() {
            if ($(this).val() < -20) {
                $(this).val(-20);
            }

            if ($(this).val() > 10) {
                $(this).val(10);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cf_eidr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 1) {
                $(this).val(1);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=cf_osdr]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 1) {
                $(this).val(1);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_ets]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_lw]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=thr_hw]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=swc_init]').change(function() {
            if ($(this).val() < 1) {
                $(this).val(1);
            }

            if ($(this).val() > 100) {
                $(this).val(100);
            }

            // if (($('#analysisForm').find(':input[name=por_e]').val() > 0)) {
            //     var porE = $('#analysisForm').find(':input[name=por_e]').val();                
            //     if ($(this).val() > porE) {
            //         $(this).val(porE);
            //     }
            // }

            validateForm();
        });

        $('#analysisForm').find(':input[name=sr_init]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=ng_init]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        $('#analysisForm').find(':input[name=nl_init]').change(function() {
            if ($(this).val() < 0) {
                $(this).val(0);
            }

            validateForm();
        });

        /*$('#analysisForm').submit(function(e) {
            // $("#mySpinnerContainer").show();
            $("#soilAnalysisModal").modal();

            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');
        });*/

        $("#uploadParamsForm").submit(async function(e){
            $("#mySpinnerContainer").show();

            e.preventDefault();   
            var actionUrl = e.target.action;                      
                   
            var redirectUrl = "<?= $this->Url->build([
                'controller' => 'soil',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to function that tells me how many UCD fields
            async function uploadFile(recaptchaToken) {
                let formData = new FormData($("#uploadParamsForm")[0]);
                formData.append('token', recaptchaToken);
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };

            // console.log('pre recaptcha');
            let recaptchaToken = null;
            async function recaptchaRequest() {
                return new Promise((resolve, reject) => {
                        grecaptcha.ready(function() {
                        grecaptcha.execute('6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e', {action: 'submit'}).then(function(token) {
                            // console.log('received token ' + token);
                            recaptchaToken = token;
                            resolve();
                        });
                    });
                });
            };

            await recaptchaRequest();
            // console.log('post recaptcha');
            
            let result = await uploadFile(recaptchaToken).then(function(data){                
                window.location.href = redirectUrl;
            }).catch(function(){                
                window.location.href = redirectUrl;
            });       
        }); 

        $("#analysisForm").submit(async function(e){
            e.preventDefault();   

            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');

            if ($("#output1_select").val() == undefined) { // no validation data
                $(".modal-body").hide();
            }

            $("#soilAnalysisModal").modal({
                backdrop: 'static'
            });
            
            var actionUrl = e.target.action;                      
                    
            var redirectUrlError = "<?= $this->Url->build([
                'controller' => 'soil',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to run analysis
            async function runAnalysis() {
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: new FormData($("#analysisForm")[0]),
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };
            
            let result = await runAnalysis().then(function(response){                
                if (response.success) {
                    // console.log('SUCCESS');
                    $("#cancel-wb-analysis").hide(); // this is found in the analysis modal
                    $("#return-wb-analysis").show(); // this is found in the analysis modal
                    $("#complete-wb-analysis").show(); // this is found in the analysis modal
                    $("#calibTypeMenu").show();
                    $("#analysisCompletionRate").html('COMPLETED');
                } else {
                    // alert('Error ' + JSON.stringify(data));
                    if (response.has_error) {
                        window.location.href = redirectUrlError;
                    }
                    
                    if (response.user_stopped) {
                        console.log('USER STOPPED');
                        $("#cancel-wb-analysis").hide(); // this is found in the analysis modal
                        $("#return-wb-analysis").show(); // this is found in the analysis modal
                    }
                }                
            }).catch(function(){
                // alert('Error');
                window.location.href = redirectUrlError;
            });       
        });
    });
</script>