<div class="container">  

    <div class="swib-title my-4">
        <div class="text-center">
            <h1>TotPrePart</h1>    
            <h2>Total Precipitation Partitioning Tool</h2>                    
            <h3>Online Tool</h3>
        </div>        
    </div>

    <div class="intro-content swib-maintext">
    
        <table class="table table-sm table-hover table-borderless text-center pb-5" id="contents">
            <thead class="thead-dark">
                <tr>
                    <th scope="row" colspan="3">Table of Contents</th>                        
                </tr>                    
            </thead>
            <tbody>  
                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_1">&rarr;  1.</a></td>
                    <td class="text-left" colspan="2"><a href="#chapter_1">About TotPrePart</a></td>                        
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_2">&rarr; 2.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_2">Background</a></td>                        
                </tr>                                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_4">&rarr; 3.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_3">User Guide</a></td>    
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.1">&rarr; 3.1.</td>      
                    <td class="text-left"><a href="#chapter_3.1">Quick start</a></td>   
                </tr>  
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.2">&rarr; 3.2.</td>      
                    <td class="text-left"><a href="#chapter_3.2">Home Module</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.3">&rarr; 3.3.</td>      
                    <td class="text-left"><a href="#chapter_3.3">Input Data Module</a></td>   
                </tr>    
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.4">&rarr; 3.4.</td>      
                    <td class="text-left"><a href="#chapter_3.4">Analysis Module</a></td>   
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.5">&rarr; 3.5.</td>      
                    <td class="text-left"><a href="#chapter_3.5">Output Timeseries</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.6">&rarr; 3.6.</td>      
                    <td class="text-left"><a href="#chapter_3.6">Calibration Procedure</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.7">&rarr; 3.7.</td>      
                    <td class="text-left"><a href="#chapter_3.7">Data inspection, visualisation and export</a></td>   
                </tr>                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_4">&rarr; 4.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_4">Limitations</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_6">&rarr; 5.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_5">Terms of Use</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_6">&rarr; 6.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_6">Contact</a></td>    
                </tr> 
            </tbody>
        </table>        

        <ul class="main-ul">
            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_1">1. About TotPrePart</h3> 

                <h5>TotPrePart is an online tool that allows for partitioning of total precipitation into snowfall and rainfall amounts based on user-provided daily timeseries of air temperature and total precipitation. Within the tool, snowfall expressed as millimeters (mm) of water is obtained from total precipitation using customizable temperature-dependent conversion factors. The rainfall amount is calculated as the difference between total precipitation and snowfall expressed in mm. The amount of snowfall obtained in mm is then converted to centimeters (cm) of snow by using additional customizable temperature-dependent conversion factors. The tool is free to use and does not require user registration.</h5>

                <h5>TotPrePart has been developed through a collaborative research effort between Canadian Rivers Institute (CRI), University of New Brunswick (UNB), Agriculture and Agri-Food Canada (AAFC) and Environment and Climate Change Canada (ECCC). TotPrePart is the result of a larger research effort aimed at evaluating the effects of agricultural production systems on groundwater and surface water quantity and quality. TotPrePart is part of Hydrology Tool Set (HTS; <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>). HTS includes additional applications, such as SepHydro (daily baseflow / hydrograph separation; 11 methods), ETCalc (daily potential, reference and actual evapotranspiration estimation; 8 methods), SWIB (daily estimation of soil water stress, crop water deficit, irrigation requirement and its impact on aquifer storage, water budget components), SNOSWAB (daily estimation of water balance terms, including snowfall, snowmelt, snowpack, soil water content, evapotranspiration, drainage, infiltration, surface runoff) and GWRech (daily estimation of groundwater recharge and groundwater discharge).</h5>

                <br/>
                <h5>If you used TotPrePart, please include the following citation(s) in your publication(s):<br/>

                <h5><span style="font-style:italic">Danielescu S (2022) TotPrePart - An online tool for partitioning of total precipitation into snowfall and rainfall. Reference Manual.</span>
                <br/>Available at <a href="https://totprepart.hydrotools.tech">https://totprepart.hydrotools.tech</a>.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>            

            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_2">2. Background</h3> 

                <h5>In many areas of the world snowfall and rainfall are the two main phases of precipitation. Snowfall, and by extension the snow cover, snowpack and snowmelt processes can for example play a significant role in replenishing water supplies (i.e., groundwater recharge; surface runoff), provide a reflective cover for the ground surface (and thus helps regulating the Earth's surface temperature) and provide critical habitat elements for many species of plants and animals. Similarly, rainfall, the dominant form of precipitation at global scale, is a key hydrological process, vital for sustaining life and socio-economic systems.</h5>

                <h5>Knowledge of snowfall and precipitation amounts are important for studies involving for example surface and subsurface hydrology, water resource planning, water (surface water and groundwater) quantity and contaminant transport modelling, irrigation, climate change, etc. Snowfall amount can be obtained from in situ measurements or from various public databases (e.g., weather stations). However, in many cases direct measurement of snowfall can be challenging or, in the case of weather stations, might be subject to errors. In many other cases, snowfall and rainfall amounts required for subsequent analyses are simply not available (e.g., not measured). For cases when snowfall and rainfall amounts are not available, TotPrePart provides a methodology for using air temperature and total precipitation to estimate the proportion of snowfall and rainfall associated with total precipitation timeseries (i.e., precipitation partitioning).</h5>

                <h5>Depending on the ambient air temperature, precipitation can fall as rain, snow or as a mix of rain and snow. Hence, for cases when the snowfall data is not directly available, the snowfall portion of the total precipitation is estimated using the following formula:</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq1_v2.png', [
                        'class' => ['img','set-h-20'],
                        'alt' => 'Snowfall estimation'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 1. - Snowfall estimation</h5>
                        <h6>SNF (mm) - snowfall amount (mm of water)<br/>
                        TOTP - total precipitation amount (mm of water)<br/>
                        C<sub>TMM</sub> - air temperature coefficient for conversion of total precipitation to snowfall;  temperature-dependent.</h6>
                    </div>
                </div>                                               

                <br/>
                <h5>Consequently, the rainfall amount is estimated as the difference between TOTP and SNF (mm) using the following formula:</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq2.png', [
                        'class' => ['img','set-h-20'],
                        'alt' => 'Rainfall estimation'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 2. - Rainfall estimation</h5>
                        <h6>RNF (mm) - rainfall amount (mm of water)<br/>
                        TOTP - total precipitation amount (mm of water)<br/>                        
                        SNF (mm) - snowfall amount (mm of water)</h6>
                    </div>
                </div>                

                <br/>
                <h5>The amount of snowfall expressed as centimeters of snow layer, that corresponds to the amount of snowfall expressed as millimeters of water is also depending on the ambient air temperature and can be estimated using the following formula:</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq3.png', [
                        'class' => ['img', 'set-h-20'],
                        'alt' => 'Snowfall conversion from mm of water to cm of snow'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 3. - Snowfall conversion from mm of water to cm of snow</h5>
                        <h6>SNF (cm) - snowfall amount (cm of snow)<br/>
                        SNF (mm) - snowfall amount (mm of water)<br/>
                        C<sub>TCM</sub> - air temperature coefficient for conversion of snowfall from mm of water to cm of snow; temperature-dependent.</h6>
                    </div>
                </div>

                <br/>
                <h5>TotPrePart integrates a simple and easy to use method that can be applied to any location for which input data is available. The tool includes routines for validating the output when user-provided calibration data is available. The web-based tool provides various data visualization, analysis and output (i.e., export) options through a streamlined process and a user-friendly interface. The Test Data set allows users to test the various routines and familiarize themselves with the tool.</h5>

                <h5>TotPrePart has a broad range of applicability and can be used for standalone analyses of snow and rainfall related processes, for generation of critical data for external models that allow for uploading of user-provided snowfall and rainfall timeseries; or for educational purposes to demonstrate the significance and the dynamics of rainfall, snowfall or rainfall and snowfall dependent processes.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>        

            <li class="pt-5 pb-3 no-marker">
                <h3 class="top-section" id="chapter_3">3. User Guide</h3> 

                <h5>At the top, a contextual menu provides access to the various modules of the tool. The modules can be accessed progressively, in the following order: 1) Home (Information module); 2) Input Data (Data entry module); and 3) Analysis (Calculation module). Once the calculations of a module are completed, the user can advance to the next module and can also return to the respective module at any time during the session. Menu tabs are available for both the data entry (i.e., Info, Load Data, Graphical View, Table View and Export Input Data for the Input Data module) and calculation (i.e., Info, Analysis, Graphical View, Table View and Export) modules.  Additional buttons (i.e., UCD and Reset Data) appear in the contextual menu once the Input Data is loaded to the tool.</h5>

                <h5>TotPrePart uses a daily timestep for both input and output data and includes a series of averaging options for displaying and exporting data (i.e., monthly, seasonal, yearly).  TotPrePart also calculates and allows for displaying of input and output data using as a "typical year daily" timeseries (i.e., daily multi-year averages for each day of the year available in the input and output files) when the analysis is carried out for a period longer than one year. The daily values for the typical year can also be averaged by the tool over monthly, seasonal, and yearly periods. Daily typical and monthly averaging intervals are recommended for inspecting and analyzing "average" conditions when the datasets cover longer periods of time (several years).</h5>

                <h5>In the following sections the options available under the various modules of the tool, together with details about the output data, calibration procedure and data inspection, visualization and export are presented in separate subsections.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.1">3.1. Quick start</h4><br/>

                <h5>In order to run TotPrePart the user has to complete the following steps:</h5>

                <ol class="large-list">
                    <li>
                        <h5>Load Data: provide required data or use the provided test data [Input Data module];</h5>
                    </li>

                    <li>
                        <h5>Perform snowfall and rainfall amount calculations: enter required coefficients and select Run Analysis [ANALYSIS module - Analysis tab]. The calibration of the tool is conducted by adjusting the coefficients available on this page (i.e., precipitation [mm] to snowfall [mm] conversion factors; snowfall conversion factors [mm to cm]); and the lower and upper bounds for the temperature intervals associated with each conversion factor. The Analysis is performed in conjunction with the information displayed in the Calibration overlay window launched by using the Run Analysis button;</h5>
                    </li>                  

                    <li>
                        <h5>Investigate Results and Export Data: review TotPrePart output from each module [Table View and/or Graphical View] and export results [Export Data button available under each data entry and calculation modules or the CSV button available under the Stats and Calibration Stats of the Graphical View or under the Table, Stats and Calibration Stats of the Table View].</h5>
                    </li>
                </ol>

                <h5>The steps required for using this tool are described in more detail below.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.2">3.2. Home Module</h4><br/>

                <h5>This module contains information related to the development, methodology and use of TotPrePart. Under each of the input and calculation modules an Info tab is available, where general information relevant to the respective module is provided.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.3">3.3. Input Data Module</h4><br/>

                <!-- <h5>The Input Data menu entry has five tabs at the top of the page: Info, Load Data, Graphical View, Table View and Export Input Data.</h5> -->

                <h5>The first step in conducting an analysis is to upload the input data file to be used by TotPrePart. The users can run TotPrePart either by using the test dataset or by uploading a new dataset.</h5>
             
                <h5>For testing TotPrePart and better understanding how the various components of the tool operate, the user can upload the test data set provided by clicking on "Try the tool using the test dataset" button. The test dataset contains three years of weather and user calibration data (UCD). Test dataset UCD data consists of snowfall (mm; UCD1; corresponding to TotPrePart SNF (mm) output parameter; UCD1 estimated as the difference between total precipitation and rainfall measured at the Environment and Climate Change Canada (ECCC) weather station located at the Charlottetown Airport, Prince Edward Island, Canada), snowfall (cm; UCD2; corresponding to TotPrePart SNF (cm) output parameter; UCD2 measured at the ECCC weather station located at the Charlottetown Airport, Prince Edward Island, Canada), and rainfall (mm; UCD3; UCD3 measured at the ECCC weather station located at the Charlottetown Airport, Prince Edward Island, Canada).</h5>

                <h5>For using TotPrePart, the users need to upload daily timeseries. The tool accepts source data sets in Comma Separated File (csv) format. The users can use the "Download Sample File" button located on the Upload User Data Page (Load Data) or the "Export Input Data - Daily" menu to obtain a correctly formatted input file that can be used as a model for populating the input data file with user data. The "Export Input Data - Daily" menu becomes available after the test or a user dataset is loaded. The user input file can be uploaded to TotPrePart by using the "Upload user data" button. TotPrePart allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods. It should be noted that the tool cannot accommodate missing data (i.e., blank rows in required data columns) or erroneous data entries, and hence it is recommended that the integrity of the source data is verified before uploading. An error message will be displayed, and the user will be redirected to the Load Data page if inconsistencies are detected in the user file.</h5>

                <h5>The input data file consists of a tabular file, with the first row dedicated to the parameter names, 1 column dedicated to calendar date, 2 columns dedicated to required input data (TEMP – average daily air temperature [&deg;C] and TOTP – daily total precipitation [mm]) and 3 columns reserved for optional user calibration data (UCD1 to UCD3). The required input data columns have to contain values in all rows, while the optional data columns (i.e., UCD) can be left blank if data is not available. If UCD data is provided, then all the rows in the respective column(s), except for the column headings, must contain numeric values. UCD data sets are not restricted to certain parameters and can include time series for any parameter that the user intends to use for comparing with the output from TotPrePart. Although UCD data is optional, it provides critical information for adjusting the various coefficients of the tool during the calibration procedure. Examples of calibration time series datasets include snowfall amount (as mm or cm) and thickness of the snow layer.</h5>

                <div class="table-responsive text-left pt-2">

                <h5>The number of columns, data format and the units of the various timeseries required for the input file are shown in the table below.</h5>
                    
                    <table class="table table-bordered text-center my-3">
                        <thead class="thead-dark">
                            <tr class="table-primary">
                                <td class="customlegend" colspan=7>
                                    <fieldset>
                                        <legend>TotPrePart Input data file: format, columns, and units for input and user calibration data (UCD)</legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th scope="row">Columns</th>
                                <td>DATE</td>
                                <td><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></td>   
                                <td><span data-toggle="tooltip" title="<?= $tooltips['PRECIP'] ?>">TOTP</span></td>                                                             
                                <td class="validation-col"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span> (max. 3 columns)</td>
                            </tr>
                            <tr class="table-info no-wrap-table-row">
                                <th scope="row">Units</th>
                                <td>yyyy-mm-dd</td>                                
                                <td>&deg;C</td>
                                <td>mm</td>               
                                <td>user choice</td>    
                            </tr> 
                            <tr class="table-info no-wrap-table-row">
                                <th scope="row">Values</th>
                                <td>eg. 2021-12-24</td>                                
                                <td>-70 to 50</td>     
                                <td>0 to 1800</td>                                           
                                <td>user choice</td>    
                            </tr>   
                        </thead>
                        <tbody>        
                        </tbody>
                    </table>
                </div>

                <br/>
                <h5>Notations:</h5>

                <ul>
                    <li>
                        <h5><span class="underlined">Required data</span>:
                            <br/>DATE - use yyyy-mm-dd format;                             
                            <br/>TEMP -  average daily air temperature [&deg;C];                                                         
                            <br/>TOTP - daily total precipitation [mm];
                    </li>

                    <li>
                        <h5><span class="underlined">Optional data</span>:
                            <br/>UCD - user calibration data (up to three columns; leave blank if no data is available)</h5>
                    </li>
                </ul>

                <br/>
                <h5>Notes:</h5>
                <ul>

                    <li>
                        <h5>The tool requires daily data</h5>
                    </li>

                    <li>
                        <h5>The user input data file has to be uploaded using a file with 1 column dedicated to calendar date, 2 columns dedicated to required input data (TEMP, TOTP) and 3 columns reserved for optional user calibration data (UCD1 to UCD3)</h5>
                    </li>

                    <li>
                        <h5>Use the first row of the data set for column headings</h5>
                    </li>

                    <li>
                        <h5>TotPrePart includes several input data integrity and quality check routines; however, the user is advised to thoroughly check the input dataset before uploading it to the tool to minimize the risk for erroneous output</h5>
                    </li>                    
                </ul>

                <br/>
                <h5>Once the input dataset is loaded via either the "Try the tool using the test data set" or "Upload user data" button an overlay window appears (i.e., "Select the UCD averaging method") asking the user to specify the method used for calculation of monthly values for each UCD timeseries (i.e., averaging vs. summation). Once this step is completed a new button ("UCD") is added to the right of the Input Data tab at the top of the page and the view switches to Graphical View. The UCD menu available at the top of the page allows the user to change the method for the calculation of monthly values for each UCD at any time. See section <a href="#chapter_3.7">3.7</a>. for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>

                <br/>
                <h5>Once the loading and inspecting of the input data is completed the user can click on the ANALYSIS menu entry at the top of the page to advance to the calculation module.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.4">3.4. Analysis Module</h4><br/>

                <h5>On the Analysis Tab the user must first provide the coefficients required by the tool in the "Precipitation (mm) to Snowfall (mm) conversion factor", "Snowfall conversion factor (mm to cm)" and "Calibration mapping" sections of this page. The values of the coefficients can be entered manually using the collapsible menus available under the Analysis Tab or can be uploaded as a set using the "Import configuration file" button. Once specified, the values of the coefficients can be checked using the "Validate" button at the bottom of the page. An error message is displayed if the coefficients include blank, out of range or incorrect format data. "Run Analysis" button replaces the "Validate" button if no errors in coefficient values are found during the validation. The configuration file can be downloaded using the "Export Configuration File" button under the Analysis Tab (including either default values of the coefficients if the first tool run has not been completed or values of the coefficient as set for the last available run of the tool if the analysis has been completed at least once) or by using "Export Configuration" in the "Export Results" menu (available after one successful run of the module). If needed, the users can also reset all the values of the coefficients to default values by using the "Reset to Default" button available at the bottom at the bottom of the page in the Analysis tab.</h5>          
                
                <h5>In the "Precipitation (mm) to Snowfall (mm) conversion factor" section of the page the user have to enter the lower and upper bound air temperature for each air temperature interval as well as the conversion factor of total precipitation (TOTP) to snowfall (SNOF[mm]) associated with each interval. The number of air temperature intervals can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Air temperature values between -70 and 50 oC are allowed. When entering values in the air temperature fields, the user have to check that the intervals do not overlap and the lower bound temperature is smaller than the upper bound temperature for each interval. For the conversion factor (CTMM - air temperature coefficient for conversion of total precipitation to snowfall), the values have to be between 0 and 1.</h5>

                <h5>In the "Snowfall conversion factor (mm to cm)" section of the page the user have to enter the lower and upper bound air temperature for each air temperature interval as well as the conversion factor of the snowfall amount in mm (SNF[mm]) to the snowfall amount in cm (SNF [cm)]) for each temperature interval. The number of air temperature intervals can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Air temperature values between -70 and 50 oC are allowed. When entering values in the air temperature fields, the user have to check that the intervals do not overlap and the lower bound temperature is smaller than the upper bound temperature for each interval. For the conversion factor (CTCM - air temperature coefficient for conversion of total precipitation to snowfall), the values have to be between 0 and 100.</h5>

                <h5>In the "Calibration mapping" section of the page the users have to select the pairs of tool output and user calibration data that will be used during the calibration of the tool. The "Calibration Mapping" fields can be ignored if the UCD data is not available in the Input Data file.</h5>

                <h5>TotPrePart starts the calculations once the values of the required coefficients are set and the user clicks on the Run Analysis button at the bottom of the page.</h5>

                <h5>All values entered on this page can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the output fitness is observed. See section <a href="#chapter_3.6">3.6</a> for instructions regarding the calibration of the tool and section <a href="#chapter_3.7">3.7</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data. </h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.5">3.5. Output Timeseries</h4><br/>

                <h5>The output from TotPrePart is shown in the table below.</h5>

                <table class="table table-bordered text-center my-3">
                    <thead class="thead-dark">                        
                        <tr class="table-primary" style="font-style:italic">
                            <td>NAME</td>
                            <td>DESCRIPTION</td>
                        </tr>          
                        <tr class="table-info">
                            <td>Index</td>
                            <td>Indicates the position of a specific record (line) in the timeseries.</td>                                                                      
                        </tr>                      
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNOW_MM'] ?>">SNOW_MM (mm)</span></td>
                            <td>Amount of snowfall expressed as millimeters of water. SONW_MM is obtained using TOTP (total precipitation) and CTMM (air temperature coefficient for conversion of total precipitation to snowfall). </td>                                                                      
                        </tr>                                
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNOW_CM'] ?>">SNOW_CM (cm)</span></td>
                            <td>Amount of snowfall expressed as centimeters of snow. SONW_CM is obtained using SNOW_MM (snowfall expressed as millimeters of water) and CTCM (air temperature coefficient for conversion of snowfall from mm of water to cm of snow). </td>                                                                      
                        </tr>  
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAIN_MM'] ?>">RAIN_MM (mm)</span></td>
                            <td>Amount of rainfall. RAIN_MM is calculated as the difference between TOTP and SNOW_MM.</td>                                                                      
                        </tr>                              
                    </thead>
                    <tbody>        
                    </tbody>
                </table>                           
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.6">3.6. Calibration Procedure</h4><br/>

                <h5>Calibration of the tool is performed via the Analysis tab of ANALYSIS module and is available only when UCD data is included in the Input data file. Calibration is conducted by first pairing the datasets from the output of the tool with the user calibration data (UCD) using the “Calibration mapping” menu available under the “Analysis” tab. Once the pairing is completed, the user can proceed to adjust coefficients, validate the data (“Validate” button at the bottom of the Analysis page) and run the tool (i.e., “Run Analysis” button at the bottom of the Analysis tab page) and inspect the tool output in the subsequent Calibration overlay window. The fitness of the output for various timesteps and averaging intervals can be inspected in the Calibration overlay window via graphs as well as bivariate statistics. If the calibration is considered unsatisfactory the user can return to the Analysis menu (i.e., “Return” button), adjust the various coefficients of the tool and rerun the analysis. If the calibration is considered satisfactory the user can complete the calculations by proceeding to the next step (i.e., “Proceed to results” in the Calibration Overlay window). </h5>                

                <h5>To aid with data inspection and assessment of the fitness of the output data, TotPrePart includes several univariate and bivariate statistics. Univariate statistics, including, average, minimum, maximum and standard deviation are calculated separately for the input (i.e., user provided calibration data) and tool output time series. The graphs and the univariate statistics can be used for example for comparing the general trends, the range of values and the amplitude of variations in both data sets. The bivariate statistics include the coefficient of determination (R2), root mean square error (RMSE) and the normalized root mean square error (NRMSE). NRMSE is calculated by using the average, the interquartile range or the differences between maximum and minimum (see definitions below). The bivariate statistics are used for evaluating the fitness of the output, by providing a measure of the differences between the values calculated by the tool and the user provided calibration data (i.e., UCD). The equations used for calculating each bivariate statistic are shown below.</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_r_square.png', [
                        'class' => ['img','set-h-60'],
                        'alt' => 'Conceptual model for the Model Calibration'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 4. - Coefficient of determination</h5>
                        <h6>R<sup>2</sup> - coefficient of determination<br/>
                        x<sub>i</sub> - value for observed data on day i<br/>
                        y<sub>i</sub> - value for modelled data on day i<br/>
                        x<sub>mean</sub> - mean of observed data</h6>
                    </div>
                </div>                   
                
                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_rmse_2.png', [
                        'class' => ['img','set-h-60'],
                        'alt' => 'Conceptual model for the Model Calibration'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 5. - Root mean square error</h5>
                        <h6>RMSE - Root mean square error<br/>
                        <h6>N - number non-missing data points<br/>
                        x<sub>i</sub> - value for observed data on day i<br/>
                        y<sub>i</sub> - value for modelled data on day i</h6>
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_ave.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error average'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 6. - Normalized root mean square error average</h5>
                        <h6>NRMSE<sub>ave</sub> - normalized root mean square error calculated using the average value of measured data<br/>
                        RMSE - root mean square error<br/>
                        x<sub>a</sub> - average value of observed data</h6>
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_iqr.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error IQR'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 7. - Normalized root mean square error IQR</h5>
                        <h6>NRMSE<sub>IQR</sub> - normalized root mean square error calculated using minimum and maximum values of measured data<br/>
                        RMSE - root mean square error<br/>
                        IQR  - interquartile range of the observed data; IQR = Q3-Q1,<br/>with Q3 = CDF<sup>-1</sup>(0.25), Q1 = CDF<sup>-1</sup>(0.75),<br/>where CDF is the quantile function 
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_minmax.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error min/max'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 8. - Normalized root mean square error min/max</h5>
                        <h6>NRMSE<sub>min/max</sub> - normalized root mean square error calculated using minimum and maximum values of measured data<br/>
                        RMSE - root mean square error<br/>
                        x<sub>max</sub> - maximum value for observed data<br/>
                        x<sub>min</sub> - minimum value for observed data</h6>
                    </div>
                </div>

                <br/>
                <h5>It is recommended that the calibration is conducted by changing one coefficient at a time over a selected range of values. When no further improvement is observed in the fitness of TotPrePart output the user can advance to adjusting the values of the next coefficient. The values of the various coefficients can be considered final once no further improvement in the fitness TotPrePart output is observed. Currently, only calibration by trial and error is available, however the integration of an autocalibration routine is in planning stages.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>                               
                
                <br/>
                <br/><h4 class="l2-section" id="chapter_3.7">3.7. Data inspection, visualisation and export</h4><br/>
            
                <h5>Inspection of data via graphical and tabular views can be conducted via the Graphical View, Table View and Export Data menu entries that become available in the Input Data module once the input dataset is loaded to TotPrePart. These menu entries are also available under each ANALYSIS module and allow the user to evaluate the output for each of these modules.</h5>

                <br/>
                <h5><strong>Graphical View</strong> allows for plotting of input or output data using various time steps and intervals available via a drop-down menu. The parameters that can be displayed are available in the selection pane located to the right of the plot. Each parameter can be displayed on the primary (left) Y axis or on the secondary (right) Y axis by clicking on the toggle placed at the right of the selection pane. Additional options for customizing the plot become visible in the top right corner when the mouse pointer is placed above the plot. These options include zoom, auto scale, reset axes, show data point labels, download plot, etc. Univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the tool output are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset ("Show Complete Dataset Stats" button) or for a selected subset ("Show stats by Interval" button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page.</h5>

                <br/>
                <h5><strong>Table View</strong> allows the user to display data in tabular format using various time steps and intervals. The user can also change the number of lines, filter data based on date or adjust the starting date of the data that is displayed. In the initial Table View, the columns displayed by default are limited to "key" parameters, however the user can change the selection of the parameters to be displayed by selecting the parameters listed above the table. In the respective list, the parameters that are displayed in the table are shown in filled boxes, while the ones that are omitted are included in clear boxes. The "key" parameters are shown in red font when not selected to be displayed. Similar to the Graphical View, univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the output are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset ("Show Complete Dataset Stats" button) or for a selected subset ("Show stats by Interval" button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page.</h5>

                <br/>
                <h5>The <strong>Export Data</strong> tab offers additional options for exporting the entire dataset using various time steps and intervals. The Export Data tab also provides options for exporting statistics and the tool configuration (i.e., values of parameters and coefficients used by the user in the each of the tool modules) The data is currently exported in csv format. The CSV button located at the top right of each table in Table View or in Graphical View can be used if the intent is to export only the data shown in the current window.</h5>
                                
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_4">4. Limitations</h3>
                
                <h5>TotPrePart allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods.</h5>

                <br/>
                <h5>Although TotPrePart includes several input data integrity and quality check routines, the user is advised to thoroughly check the input dataset before uploading it to the tool to minimize the risk for erroneous output.</h5>

                <br/>
                <h5>Considering the variability of environmental conditions at small scales (e.g., shading, wind sheltering, etc.) the results obtained with TotPrePart are considered to be representative of the "average" environmental conditions for the area from where the source data has been obtained.</h5>

                <br/>
                <h5>TotPrePart considers only precipitation as snowfall and rainfall, while other forms of precipitation such as hail, drizzle, ice pellets, etc. are ignored. Typically, these other forms of precipitations represent only a small portion of the annual total precipitation; however, they can be the dominant form of precipitation during certain precipitation events.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_5">5. Terms of Use</h3> 

                <h5>TotPrePart can be used freely.</h5>

                <h5>The authors do not assume any responsibility for the tool's operation, output, interpretation, or use of results.</h5>               
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>         
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_6">6. Contact</h3> 

                <h5>
                    Serban Danielescu, Ph.D.<br/>
                    Research Scientist | Chercheur scientifique<br/>
                    Environment and Climate Change Canada | Environnement et Changements Climatiques Canada<br/>
                    Agriculture and Agri-Food Canada | Agriculture et Agroalimentaire Canada<br/>
                    Fredericton Research and Development Centre | Centre de recherche et développement de Fredericton<br/>
                    95 Innovation Rd., Fredericton, NB, E3B 4Z7<br/>
                    Telephone/Téléphone: 506-460-4468<br/>
                    Facsimile/Télécopieur: 506-460-4377<br/>
                    <!-- <a href="mailto:serban.danielescu@ec.gc.ca">serban.danielescu@ec.gc.ca</a><br/>
                    <a href="mailto:serban.danielescu2@agr.gc.ca">serban.danielescu2@agr.gc.ca</a><br/>                -->
                    <?= $this->Html->image('email_addresses.png', ['class' => ['img','max-h-300']]); ?>
                </h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>
               
        </ul>                
    </div>    
    
</div>