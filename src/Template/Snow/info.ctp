<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Snow Module</h2>
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
                        <td><span data-toggle="tooltip" title="<?= $tooltips['SNWTinit'] ?>">SNWTinit</span></td>
                        <td>Initial snow layer thickness (cm)</td>
                        <td>Thickness of the snow layer on the first day of the analysis. This is converted into mm for subsequent calculations using 1/CFSmc</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['SNWMinit'] ?>">SNWMinit</span></td>
                        <td>Initial snowmelt (mm)</td>
                        <td>Amount of snow melted on the first day of the analysis</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>                                
                </thead>
                <tbody>        
                </tbody>
            </table>

            <table class="table table-bordered text-center my-3 mt-1">
                <thead class="thead-dark">
                    <tr class="table-primary" style="font-style:italic">
                        <th colspan="4" scope="row">COEFFICIENTS</th>                                    
                    </tr>
                    <tr class="table-primary" style="font-style:italic">
                        <td>NAME</td>
                        <td>LONG NAME</td>
                        <td>DEFINITION</td>
                        <td>VALUES</td>                                    
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRrs'] ?>">THRrs</span></td>
                        <td>Air temperature threshold for rain to be accumulated as snow (&deg; C)</td>
                        <td>Precipitation falling as rain is treated as snow when air temperature is below this threshold. This results in the respective rain amount to be added to the snow layer instead of infiltrating and/or becoming surface runoff</td>
                        <td>-20 to 10</td>                                                                      
                    </tr>                                
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['THRsm'] ?>">THRsm</span></td>
                        <td>Air temperature threshold for initiating snowmelt (&deg; C)</td>
                        <td>Melting of the snow occurs on days with air temperature above this threshold</td>
                        <td>-20 to 10</td>                                                                         
                    </tr>  
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFTsm'] ?>">CFTsm</span></td>
                        <td>Correction factor - snowmelt due to air temperature (mm)</td>
                        <td>The amount of snow that is melted for each degree of air temperature above THRsm</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFRsm'] ?>">CFRsm</span></td>
                        <td>Correction factor - snowmelt due to rain (mm)</td>
                        <td>The amount of snow that is melted for each mm of rain that is not accumulated in the snow layer</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFSmc'] ?>">CFSmc</span></td>
                        <td>Correction factor - snow as mm water to cm snow</td>
                        <td>Factor for converting calculated snow layer thickness from mm water (as calculated by the model) to cm of snow</td>
                        <td>&ge; 0</td>                                                                      
                    </tr>
                    <tr class="table-info">
                        <td><span data-toggle="tooltip" title="<?= $tooltips['CFets'] ?>">CFets</span></td>
                        <td>Correction factor - portion of evapotranspiration occurring in the soil</td>
                        <td>Factor for estimating the portion of actual evapotranspiration (ET) that occurs in the soil. The remainder of ET is considered to occur before water enters the soil (e.g., canopy interception; water ponding at the soil surface, etc.)</td>
                        <td>0 to 1</td>                                                                      
                    </tr>
                </thead>
                <tbody>        
                </tbody>
            </table>

            <br/>
            <h5>Once the values for Starting values and Coefficients are set and the user selects the pairs to be used during the calibration (i.e. Calibration mapping menu), the user can click on the Run Snow Analysis button and the Calibration overlay window will be displayed. Both the Starting values and the Coefficients can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the model fitness is observed (see section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6.</a> for details regarding the calibration procedure). Upon completion of the calibration procedure the view switches to Graphical View. See section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6.</a> for instructions regarding the calibration of the model and section <a href="<?= $this->Url->build('/main/index#chapter_4.6');?>">4.6.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>                                                    

            <br/>
            <h5>The user can click on the Water Balance menu entry at the top of the page to advance to the next calculation module.</h5>

            <br/>
            <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.3');?>">3.3.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.4');?>">3.4.</a> for more details.</h5>
        </div> 
    </div>
   
</div>