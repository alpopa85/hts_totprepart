<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Analysis Module</h2>
        </div>

        <div class="table-responsive text-left">

            <h5>On the Analysis Tab the user must first provide the coefficients required by the tool in the "Precipitation (mm) to Snowfall (mm) conversion factor", "Snowfall conversion factor (mm to cm)" and "Calibration mapping" sections of this page. The values of the coefficients can be entered manually using the collapsible menus available under the Analysis Tab or can be uploaded as a set using the "Import configuration file" button. Once specified, the values of the coefficients can be checked using the "Validate" button at the bottom of the page. An error message is displayed if the coefficients include blank, out of range or incorrect format data. "Run Analysis" button replaces the "Validate" button if no errors in coefficient values are found during the validation. The configuration file can be downloaded using the "Export Configuration File" button under the Analysis Tab (including either default values of the coefficients if the first tool run has not been completed or values of the coefficient as set for the last available run of the tool if the analysis has been completed at least once) or by using "Export Configuration" in the "Export Results" menu (available after one successful run of the module). If needed, the users can also reset all the values of the coefficients to default values by using the "Reset to Default" button available at the bottom at the bottom of the page in the Analysis tab.</h5>          
                
            <h5>In the "Precipitation (mm) to Snowfall (mm) conversion factor" section of the page the user have to enter the lower and upper bound air temperature for each air temperature interval as well as the conversion factor of total precipitation (TOTP) to snowfall (SNOF[mm]) associated with each interval. The number of air temperature intervals can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Air temperature values between -70 and 50 oC are allowed. When entering values in the air temperature fields, the user have to check that the intervals do not overlap and the lower bound temperature is smaller than the upper bound temperature for each interval. For the conversion factor (CTMM - air temperature coefficient for conversion of total precipitation to snowfall), the values have to be between 0 and 1.</h5>

            <h5>In the "Snowfall conversion factor (mm to cm)" section of the page the user have to enter the lower and upper bound air temperature for each air temperature interval as well as the conversion factor of the snowfall amount in mm (SNF[mm]) to the snowfall amount in cm (SNF [cm)]) for each temperature interval. The number of air temperature intervals can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Air temperature values between -70 and 50 oC are allowed. When entering values in the air temperature fields, the user have to check that the intervals do not overlap and the lower bound temperature is smaller than the upper bound temperature for each interval. For the conversion factor (CTCM - air temperature coefficient for conversion of total precipitation to snowfall), the values have to be between 0 and 100.</h5>

            <h5>In the "Calibration mapping" section of the page the users have to select the pairs of tool output and user calibration data that will be used during the calibration of the tool. The "Calibration Mapping" fields can be ignored if the UCD data is not available in the Input Data file.</h5>

            <h5>SNOWFALL BUDDY starts the snowfall and rainfall amount calculations once the values of the required coefficients are set and the user clicks on the Run Analysis button at the bottom of the page.</h5>

            <br/>
            <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.4');?>">3.4.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.5');?>">3.5.</a> for more details.</h5>
        </div> 
    </div>       
</div>