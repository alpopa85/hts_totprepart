<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Input Data Module</h2>
        </div>        

        <div class="table-responsive text-left">

            <h5>The Input Data menu entry has five tabs at the top of the page: Info, Load Data, Graphical View, Table View, and Export Data.</h5>

            <h5>The first step in conducting an analysis is to upload the input data file to be used in SNOW BUDDY. The users can run SNOW BUDDY either by using the pre-loaded sample dataset or by uploading a new dataset.</h5>

            <h5>For practicing with SWIB and better understanding how the various components of the tool work, the user can use the test data set provided (two years of daily data), by clicking on “Try the tool using the test dataset” button. The test dataset contains two years of daily weather and calibration data. The calibration data consists of daily water table elevations (VD1) and air temperature (VD2).</h5>

            <h5>For testing SNOW BUDDY and better understanding how the various components of the tool work, the user can upload the test data set provided by clicking on “Try the tool using the test dataset” button. The test dataset contains three years of weather and calibration data. The calibration data consists of snow layer thickness (cm; UCD1; measured at a weather station included in the Meteorological Services of Canada [Environment and Climate Change Canada] monitoring network), soil water content (%; UCD2; measured in a research field), surface runoff (mm; UCD3; obtained from hydrograph separation of stream discharges obtained from a stream gaging station included in the Water Survey of Canada [Environment and Climate Change Canada] monitoring network) and groundwater recharge(mm; UCD4; obtained based on measured changes in water table levels in a research well).</h5>

            <h5>For using SNOW BUDDY the users need to upload time series datasets. The tool accepts source data sets in Comma Separated File (csv) format. The users can use the “Export Input Data - Daily” menu to obtain a correctly formatted input file that can be used as a model for populating the input data file with user data. The user input file can be uploaded to SNOW BUDDY by using the “Upload user data” button. It should be noted that the tool cannot accommodate missing data (i.e., blank rows in required data columns) or erroneous data entries, and hence it is recommended that the integrity of the source data is verified before uploading.</h5>

            <h5>The input data file consists of a tabular file with 1 column dedicated to calendar date, 4 columns dedicated to required input data (TEMP - daily mean daily air temperature; TOTPP - daily total precipitation; RAIN - daily rain; ETA - daily actual (or crop) evapotranspiration) and 5 columns reserved for optional calibration data (UCD1 to UCD5). The required input data columns have to contain values in all rows, while the optional data columns can be left blank if data is not available. The calibration data sets are not restricted to certain parameters and can include time series for any parameter that the user wants to use for comparing with the output from SNOW BUDDY.  Examples of calibration time series datasets include thickness of snow layer, soil water content, groundwater recharge, surface runoff, etc.</h5>

            <div class="table-responsive text-left pt-2">

            <h5>The number of columns, data format and the units of the various weather parameters required for the input file are shown in the table below.</h5>
                
                <table class="table table-bordered text-center my-3">
                    <thead class="thead-dark">
                        <tr class="table-primary">
                            <td class="customlegend" colspan=7>
                                <fieldset>
                                    <legend>WATBAL Input data file: format, columns, and units for input and user calibration data (UCD)</legend>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="table-primary">
                            <th scope="row">Columns</th>
                            <td>DATE</td>
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></td>
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></td>
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></td>
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span></td>                
                            <td class="validation-col"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span> (max. 5 columns)</td>
                        </tr>
                        <tr class="table-info no-wrap-table-row">
                            <th scope="row">Units</th>
                            <td>yyyy-mm-dd</td>
                            <td>&deg;C</td>
                            <td>mm</td>               
                            <td>mm</td>
                            <td>mm</td>
                            <td>user choice</td>    
                        </tr> 
                        <tr class="table-info no-wrap-table-row">
                            <th scope="row">Values</th>
                            <td>eg. 2021-12-24</td>
                            <td>-90 to 60</td>
                            <td>0 to 1800</td>                
                            <td>0 to 1800</td>  
                            <td>0 to 100</td>  
                            <td>user choice</td>    
                        </tr>   
                    </thead>
                    <tbody>        
                    </tbody>
                </table>
            </div>

            <br/>
            <h5>Notes:</h5>

            <ul>
                <li>
                    <h5><span class="underlined">Required data</span>:
                        <br/>DATE - use yyyy-mm-dd format; 
                        <br/>TEMP -  daily mean daily air temperature; 
                        <br/>TOTPP - daily total precipitation;
                        <br/>RAIN - daily rain;
                        <br/>ETA - daily actual (or crop) evapotranspiration;</h5>
                </li>

                <li>
                    <h5><span class="underlined">Optional data</span>:
                        <br/>UCD - user calibration data (up to five columns; leave blank if no data is available)</h5>
                </li>

                <li>
                    <h5>The model requires daily data</h5>
                </li>

                <li>
                    <h5>The user input data file must be uploaded using a file with one column dedicated to calendar date, four columns dedicated to input data (TEMP, TOTPP, RAIN, ETA) and up to five columns dedicated to calibration data (UCD1 to UCD5)</h5>
                </li>

                <li>
                    <h5>Use the first row of the data set for column headings</h5>
                </li>

                <li>
                    <h5>SNOW BUDDY includes limited input data quality check routines and hence, the user must ensure that the input data set is suitable for analysis (e.g., check dataset for missing or erroneous values, etc.)</h5>
                </li>                    
            </ul>

            <br/>
            <h5>On this page the user can specify the beginning and the end of the growing season in the boxes provided. These dates are used for averaging the various parameters during the growing season (GS) and outside of the growing season (OGS). In SNOW BUDDY, it is assumed that these dates are not changing from year to year and hence, the start and end dates use the mm-dd format (the year is ignored as the same dates are applied to all years available in the input data file).</h5>

            <br/>
            <h5>Once the input dataset is loaded to SNOW BUDDY via either the "Try the tool using the test data set" or "Upload user data" button an overlay window appears (i.e. "Select the UCD averaging method") asking the user to specify the method used for calculation of monthly values for each UCD timeseries (i.e. averaging vs. summation). Once this step is completed a new button ("UCD") is added to the right of the Input Data tab at the top of the page and the view switches to Graphical View. The UCD menu available at the top of the page allows the user to change the method for the calculation of monthly values for each UCD at any time. See section <a href="<?= $this->Url->build('/main/index#chapter_4.6');?>">4.6</a>. for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>

            <br/>
            <h5>Once the loading and inspecting of the input data is completed the user can click on the SNOW menu entry at the top of the page to advance to the first calculation module.</h5>

            <br/>
            <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.1');?>">3.1.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.3');?>">3.3.</a> for more details.</h5>    
        </div>               
    </div>

</div>