<div class="container">
    
    <div class="intro-content swib-maintext mt-5">      
        <div class="swib-title text-center py-5">
            <h2>Water Balance Module</h2>
        </div>

        <h5>On the Analysis Tab the user has to provide:</h5>                

        <ul>
            <li>
                <h5><strong>Layer or Root zone thickness (mm)</strong>. This field is simply displaying the thickness of the layer as entered in the Water Stress module (mm). The value can be changed in the Analysis – Water Stress module. If this value is changed the Water Stress Analysis has to be re-run for the change to be carried over into the Water Balance module;</h5>
            </li>

            <li>
                <h5><strong>ET Loss Before Entering the Soil (%)</strong>. Allows calculation of the above ground and soil fractions of evapotranspiration. This parameter can have values between 0 and 100.</h5>
            </li>

            <li>
                <h5><strong>Window width for SR calculation (days)</strong>. The value in this field sets the width of the window for surface runoff calculation. The minimum value is 2 (days).
                </h5>
            </li>
        </ul>

        <br/>
        <h5>Some components of the Water Balance module are still in testing stage (i.e. surface runoff, drainage, infiltration) and hence, this module should be used with caution.</h5>

        <br/>
        <h5>Once the parameters are set the user can click on the Run Water Balance Analysis button and the view will switch to Table View. See section <a href="<?= $this->Url->build('/main/index#chapter_4.7');?>">4.7.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>   

        <br/>
        <h5>The user can click on any of the menu entries at the top of the page to access the various modules available.</h5>   

        <br/>
        <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.1');?>">3.1.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6.</a> for more details.</h5>
     
    </div>
   
</div>