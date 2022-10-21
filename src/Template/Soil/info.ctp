<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Water Balance Module</h2>
        </div>

        <div class="table-responsive text-left">

            <h5>On the Analysis Tab the user must provide the following:</h5>                

            <table class="table table-bordered text-center my-3">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">STARTING VALUES</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['SWCinit'] ?>">SWCinit</span></td>
                        <td>Soil water content (SWC) (%)</td>
                        <td>SWC, as percentage of PORe on the first day of the analysis. SWCinit cannot be higher than the effective porosity of the layer (<span data-toggle="tooltip" title="<?= $tooltips['PORe'] ?>">PORe</span>)</td>
                        <td>1 to 100</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['SRinit'] ?>">SRinit</span></td>
                        <td>Surface runoff (mm)</td>
                        <td>Amount of surface runoff on the first day of the analysis</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>     
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['NGinit'] ?>">NGinit</span></td>
                        <td>Net SWC gain (mm)</td>
                        <td>Net gain in SWC on the first day of the analysis</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>     
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['NLinit'] ?>">NLinit</span></td>
                        <td>Net SWC loss (mm)</td>
                        <td>Net loss in SWC on the first day of the analysis</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>                                
                </thead>
                <tbody>        
                </tbody>
            </table>

            <table class="table table-bordered text-center my-3 mt-1">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">LAYER PROPERTIES</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THKN'] ?>">THKN</span></td>
                        <td>Layer or root zone thickness (mm)</td>
                        <td>The thickness of the modelled layer. The layer can be the root zone, a soil horizon or the entire soil profile</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['PORe'] ?>">PORe</span></td>
                        <td>Layer effective porosity (%)</td>
                        <td>Effective porosity of the layer. This is used for defining the maximum soil water content (SWC)</td>
                        <td>1 to 100</td>                                                                         
                    </tr>                                  
                </thead>
                <tbody>        
                </tbody>
            </table>

            <table class="table table-bordered text-center my-3 mt-1">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">INFILTRATION COEFFICIENTS</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRinfLH'] ?>">THRinfLH</span></td>
                        <td>SWC threshold for switching between low and high infiltration rate (%)</td>
                        <td>Infiltration rate is high when soil water content (SWC) is below this threshold and low when SWC is above this threshold</td>
                        <td>0 to 1</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['INFlr'] ?>">INFlr</span></td>
                        <td>Infiltration rate at low SWC (mm/hr)</td>
                        <td>Infiltration rate when SWC is lower than THRinfLH (i.e., high infiltration rate)</td>
                        <td>&ge; 0</td>                                                                         
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['INFhr'] ?>">INFhr</span></td>
                        <td>Infiltration rate at high SWC (mm/hr)</td>
                        <td>Infiltration rate when SWC is higher than THRinfLH (i.e., low infiltration rate)</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>                                
                </thead>
                <tbody>        
                </tbody>
            </table>

            <table class="table table-bordered text-center my-3 mt-1">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">DRAINAGE COEFFICIENTS</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRdraHL'] ?>">THRdraHL</span></td>
                        <td>SWC threshold for switching drainage from high to low rate (%)</td>
                        <td>Drainage rate is high when soil water content (SWC) is above this threshold and low when SWC is below this threshold</td>
                        <td>1 to 100</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['DRAlr'] ?>">DRAlr</span></td>
                        <td>Drainage rate at low SWC (mm/hr)</td>
                        <td>Drainage rate when SWC is lower than THRdraHL (i.e., low drainage rate)</td>
                        <td>&ge; 0</td>                                                                         
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['DRAhr'] ?>">DRAhr</span></td>
                        <td>Drainage rate at high SWC (mm/hr)</td>
                        <td>Drainage rate when SWC is higher than THRdraHL (i.e., high drainage rate)</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRswstd'] ?>">THRswstd</span></td>
                        <td>SWC threshold for stopping drainage (%)</td>
                        <td>Drainage stops when the SWC is below this threshold. This corresponds to dry soil conditions when drainage is expected to cease</td>
                        <td>1 to 100</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRtstd'] ?>">THRtstd</span></td>
                        <td>Air temperature threshold for stopping drainage (&deg; C)</td>
                        <td>Drainage stops when the air temperature is below this threshold. This is considered to be a reasonable proxy for simulating frozen soil conditions. THRtstd is generally lower than the actual soil temperature</td>
                        <td>-20 to 10</td>                                                                         
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFeidr'] ?>">CFeidr</span></td>
                        <td>Drainage boost correction factor - excess infiltration</td>
                        <td>Forces a proportion of water from excess infiltration to be re-routed to drainage instead of surface runoff. Use of non-zero CFeidr forces the model to bypass SWC calculation. Hence, CFeidr starting values should be zero, and should be adjusted only if model calibration using other coefficients is not satisfactory</td>
                        <td>0 to 1</td>                                                                      
                    </tr>
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFosdr'] ?>">CFosdr</span></td>
                        <td>Drainage boost correction factor - oversaturation</td>
                        <td>Forces a proportion of water from oversaturation (i.e., when SWC > PORe) to be re-routed to drainage instead of surface runoff. Use of CFosdr does not impact SWC (i.e., SWC is bypassed). CFosdr starting values should be zero, and should be adjusted only if model calibration using other coefficients is not satisfactory</td>
                        <td>0 to 1</td>                                                                      
                    </tr>
                </thead>
                <tbody>        
                </tbody>
            </table>

            <table class="table table-bordered text-center my-3 mt-1">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">OTHER COEFFICIENTS</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFets'] ?>">CFets</span></td>
                        <td>Correction factor - portion of evapotranspiration occurring in the soil</td>
                        <td>Factor for estimating the portion of actual evapotranspiration (ET) that occurs in the soil. The remainder of ET is considered to occur before water enters the soil (e.g., canopy interception; water ponding at the soil surface, etc.)</td>
                        <td>0 to 1</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRets'] ?>">THRets</span></td>
                        <td>SWC threshold for stopping soil evapotranspiration (%)</td>
                        <td>Forces evapotranspiration to stop when SWC is below this value</td>
                        <td>1 to 100</td>                                                                         
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRlw'] ?>">THRlw</span></td>
                        <td>Threshold for low SWC state (%)</td>
                        <td>Threshold for considering the soil to be in a low SWC state. This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days that require irrigation or number of days with water deficit</td>
                        <td>1 to 100</td>                                                                         
                    </tr>
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRhw'] ?>">THRhw</span></td>
                        <td>Threshold for high SWC state (%)</td>
                        <td>Threshold for considering the soil to be in a high SWC state. This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days with excess water present in the soil</td>
                        <td>1 to 100</td>                                                                      
                    </tr>                                
                </thead>
                <tbody>        
                </tbody>
            </table>

            <br/>
            <h5>Once the values for Starting values and Coefficients are set and the user selects the pairs to be used during the calibration (i.e. Calibration mapping menu), coefficient values are set the user can click on the Run Water Balance Analysis button and the Calibration overlay window will be displayed. Both the Starting values and the Coefficients can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the model fitness is observed (see section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6.</a> for details regarding the calibration procedure). Upon completion of the calibration procedure the view switches to Graphical View. See section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6.</a> for instructions regarding the calibration of the model and section <a href="<?= $this->Url->build('/main/index#chapter_4.6');?>">4.6.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>   
            
            <br/>
            <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.3');?>">3.3.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.5');?>">3.5.</a> for more details.</h5>            
        </div> 
    </div>
   
</div>