<div class="container">  

    <div class="swib-title my-4">
        <div class="text-center">
            <h1>Snow Buddy</h1>        
            <h2>...</h2>
            <h3>Online Tool</h3>
        </div>        
    </div>
<?php /*
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
                    <td class="text-left" colspan="2"><a href="#chapter_1">About SNOW BUDDY</a></td>                        
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_2">&rarr; 2.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_2">Background</a></td>                        
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_3">&rarr; 3.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_3">Methodology</a></td>    
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.1">&rarr; 3.1.</a></td>      
                    <td class="text-left"><a href="#chapter_3.1">Input Data File</a></td>   
                </tr>  
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.2">&rarr; 3.2.</a></td>      
                    <td class="text-left"><a href="#chapter_3.2">Time steps and averaging</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.3">&rarr; 3.3.</a></td>      
                    <td class="text-left"><a href="#chapter_3.3">Required Coefficients</a></td>   
                </tr>    
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.4">&rarr; 3.4.</a></td>      
                    <td class="text-left"><a href="#chapter_3.4">SNOW Module</a></td>   
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.5">&rarr; 3.5.</a></td>      
                    <td class="text-left"><a href="#chapter_3.5">WATER BALANCE Module</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.6">&rarr; 3.6.</a></td>      
                    <td class="text-left"><a href="#chapter_3.6">Model Calibration</a></td>   
                </tr>                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_4">&rarr; 4.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_4">User Guide</a></td>    
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.1">&rarr; 4.1.</td>      
                    <td class="text-left"><a href="#chapter_4.1">Quick start</a></td>   
                </tr>  
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.2">&rarr; 4.2.</td>      
                    <td class="text-left"><a href="#chapter_4.2">Home Module</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.3">&rarr; 4.3.</td>      
                    <td class="text-left"><a href="#chapter_4.3">Load Data (Input Data Module)</a></td>   
                </tr>    
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.4">&rarr; 4.4.</td>      
                    <td class="text-left"><a href="#chapter_4.4">Analysis - SNOW Module</a></td>   
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.5">&rarr; 4.5.</td>      
                    <td class="text-left"><a href="#chapter_4.5">Analysis - WATER BALANCE Module</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_4.6">&rarr; 4.6.</td>      
                    <td class="text-left"><a href="#chapter_4.6">Data inspection, visualisation and export (all modules)</a></td>   
                </tr>                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_5">&rarr; 5.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_5">Limitations</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_6">&rarr; 6.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_6">Terms of Use</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_7">&rarr; 7.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_7">Contact</a></td>    
                </tr> 
            </tbody>
        </table>

        <ul class="main-ul">
            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_1">1. About SNOW BUDDY</h3> 

                <h5>SNOW BUDDY (Snow, Soil Water and Water Balance Model) is an online tool for obtaining daily estimates of snow related processes (e.g., snowfall, snowmelt, snow layer thickness), soil water content and a series of soil water budget components (e.g., infiltration, drainage, surface runoff) based on user provided daily meteorological (i.e., mean air temperature, total precipitation, rainfall), evapotranspiration and calibration data. SNOW BUDDY has been developed through a collaborative research effort between Canadian Rivers Institute (CRI), University of New Brunswick (UNB), Agriculture and Agri-Food Canada (AAFC) and Environment and Climate Change Canada (ECCC). SNOW BUDDY is a result of a larger research effort aimed at evaluating the effects of agricultural production systems on groundwater and surface water quantity and quality. SNOW BUDDY is part of Hydrology Tool Set (HTS; <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>). In addition to SNOW BUDDY, HTS includes SepHydro (daily baseflow / hydrograph separation; 11 methods), ETCalc (daily potential, reference and actual evapotranspiration estimation; 8 methods) and SWIB (daily estimation of soil water stress, crop water deficit, irrigation requirement and its impact on aquifer storage, water balance components).</h5>

                <br/>
                <h5>Citation:<br/>

                <h5><span style="font-style:italic">Danielescu S (2022) SNOW BUDDY (Snow, Soil Water and Water Balance Model) - A web-based model. Reference Manual.</span>
                <br/>Available at <a href="https://SNOW BUDDY.hydrotools.tech">https://SNOW BUDDY.hydrotools.tech</a>.</h5>

                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>            

            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_2">2. Background</h3> 

                <h5>The water balance is an important hydrological tool that allows for quantification of the flow of water in and out of a system as well as of the amount of water available in the system. Understanding of the water balance provides the basis for advancing our understanding relative to hydrological cycle, ecosystem health or agroecosystem productivity and can be an important tool for water-resource management and environmental planning. Examples of application of water balance include evaluation of the impacts of climate variability and severe weather (e.g., droughts) on water availability; impact of human activities on water resources; the impact of water stress (water deficit and excess) on natural vegetation and agricultural crops; movement of water and solutes (e.g., contaminants) through soil; irrigation requirements for agricultural production, etc.</h5>

                <h5>SNOW BUDDY (Snow, Soil Water and Water Balance tool) integrates several components that allow for estimation of daily dynamics and magnitude of various water balance components. SNOW BUDDY provides powerful routines for estimation of snow related processes and soil water content. SNOW BUDDY can be applied to any location for which input data is available and can be used for evaluating various scenarios relevant for the above processes. The model includes extensive calibration routines when user-provided calibration data is available. The web-based model provides various data visualization, analysis and output options through a streamlined process and a user-friendly interface.</h5>

                <h5>SNOW BUDDY integrates four modules: 1) HOME; 2) INPUT DATA; 3) SNOW; and 4) WATER BALANCE.</h5>

                <h5>The HOME module contains information regarding the context of model development, a presentation of the various concepts used and the user guide.</h5>

                <h5>The INPUT DATA module provides an interface for uploading user time series data or for loading the provided test data to the model. The Test Data set allows users to test the various routines and familiarize themselves with the model.</h5>

                <h5>The SNOW module allows for estimation of a series of snow related processes (e.g., snowfall, snowmelt, snow layer thickness) and produces the amount of water available (i.e., water available for infiltration and surface runoff) for calculations carried out in the next module.</h5>

                <h5>The WATER BALANCE module allows for daily estimation of soil water content and of a series of water budget components (e.g., infiltration, drainage, surface runoff).</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('SNOW BUDDY_scheme_v2.png', [
                        'class' => ['img','max-h-600'], 
                        'alt' => 'Simplified workflow diagram for SNOW BUDDY model'
                    ]); ?>
                </div>  
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Fig 1. Simplified workflow diagram for SNOW BUDDY model</h5>
                        <h6>TEMP - daily mean daily air temperature; TOTPP - daily total precipitation; RAIN - daily rain; ETA - daily actual (or crop) evapotranspiration; UCD - user calibration data</h6>
                    </div>
                </div>  

                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_3">3. Methodology</h3> 

                <h5>Details regarding data management as well as the methodology used for each SNOW BUDDY module are included below.</h5>

                <br/><h4 class="l2-section" id="chapter_3.1">3.1. Input Data File</h4><br/>

                <h5>The Input Data file consists of a collection of daily time series including both required and optional data. SNOW BUDDY allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods. This data is used in conjunction with the adjustable coefficients available to the user in the Analysis page of each SNOW BUDDY module.</h5>

                <h5>The <span class="underlined">REQUIRED INPUT TIME SERIES</span> is a daily dataset required for conducting analyses using SNOW BUDDY. The required input time series data includes:</h5>

                <ul>
                    <li>
                        <h5>Air temperature (TEMP). This is a parameter used by the SNOW module. TEMP is required for calculation of a series of snow and drainage related processes. TEMP represents the daily mean air temperature and is typically available from in situ measurements or from other sources (e.g., weather stations, online databases, etc.). In the input data file, the units for TEMP are &deg; C;</h5>
                    </li>

                    <li>
                        <h5>Total precipitation (TOTPP). This is a parameter used by the SNOW module. TOTPP is required for calculation of a series of snow and infiltration related processes. TOTPP represents the daily total precipitation and includes all forms of precipitation (e.g., snow, rain, freezing rain, etc.). TOTPP is available from in situ measurements or from other sources (e.g., weather stations, online databases, etc.). The units for TOTPP are mm;</h5>
                    </li>

                    <li>
                        <h5>Rain (RAIN). This is a parameter used by the SNOW module. RAIN is required for calculation of a series of snow and infiltration related processes. RAIN represents the daily rainfall. RAIN is available from in situ measurements or from other sources (e.g., weather stations, online databases, etc.). The units for RAIN are mm;</h5>
                    </li>

                    <li>
                        <h5>Evapotranspiration (ETA). This is a parameter used by the SNOW and WATER BALANCE modules. ETA is required for calculation of a series of snow and infiltration related processes. ETA represents the daily actual (or crop) evapotranspiration. ETA is generally not readily available from weather stations; however it can be obtained from in situ measurements or from other sources (e.g., weather stations, online databases, etc.). If not directly available to the user, evapotranspiration can be calculated on a daily basis using ETCalc, a tool included in the Hydrology Tool Set (HTS) available at <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>. The units for ETA are mm;</h5>
                    </li>
                </ul>

                <br/>
                <h5>The <span class="underlined">OPTIONAL INPUT TIME SERIES</span> (i.e., UCD - User Calibration Data) is a daily dataset used for calibrating SNOW BUDDY output. While this is not a required data set, the user calibration data (UCD) is critical for adjusting the various coefficients of the model. In the absence of the UCD data, the SNOW BUDDY model cannot be calibrated. The users can upload (up to) 5 columns of daily input datasets for model calibration. The format of the optional input time series is restricted to numerical values and the user is provided the option of pairing these time series with parameters calculated by SNOW BUDDY during the calibration process. Examples of calibration time series datasets include thickness of snow layer, soil water content, groundwater recharge, surface runoff, etc.</h5>
                
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
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>            

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.2">3.2. Time steps and averaging</h4><br/>

                <h5>SNOW BUDDY uses daily data for both input and output data. SNOW BUDDY includes a series of averaging options (i.e., monthly, seasonal [meteorological and growing season], yearly), which are explained in more detail below. SNOW BUDDY can also calculate all the output parameters using a "typical year daily" (i.e., daily multi-year averages for each day of the year available in the input and output files) for the cases when the analysis is carried out for a period longer than one year. The monthly as well as the typical daily year (see below for details) are recommended for inspecting and analyzing results when multiple years of data are available. The daily values for the typical year can also be averaged over monthly, seasonal [meteorological and growing season], and yearly periods. The following time intervals are available in tables, graphs and export files for displaying SNOW BUDDY results:</h5>

                <ul>
                    <li>
                        <h5><strong>Daily</strong>: this is the operating time step for SWIB;</h5>
                    </li>

                    <li>
                        <h5><strong>Monthly</strong>;</h5>
                    </li>

                    <li>
                        <h5><strong>Yearly</strong>;</h5>
                    </li>

                    <li>
                        <h5><strong>Meteorological seasons</strong>, with the following distribution: <strong>Spring</strong>: March 1 - May 31st; <strong>Summer</strong>: June 1st - August 31st; <strong>Fall</strong>: September 1st - November 30th; <strong>Winter</strong>: December 1st - February 28th of the following year;</h5>
                    </li>

                    <li>
                        <h5><strong>Growing season</strong> [GS] and <strong>outside of growing season</strong> [OGS], based on the starting and ending dates specified by the user. OGS spans between the first day after the end of the growing season and the day before the start of the following year’s growing season;</h5>
                    </li>

                    <li>
                        <h5><strong>Typical year daily</strong>: one year of daily data based on the averages of the output data for each day in multiple years (i.e., 365 values) (e.g. for a 5-year daily data set, the value for Jan 1 will be the average for the values on Jan 1 in Year 1,2, 3, 4, and 5). This could be interpreted as the "representative daily year" or "average daily year";</h5>
                    </li>

                    <li>
                        <h5><strong>Typical year monthly</strong>: one year of monthly averages (i.e., 12 values). The monthly averages are calculated using the typical year daily values;</h5>
                    </li>

                    <li>
                        <h5><strong>Typical year meteorological season</strong>: meteorological season averages (i.e., four values). The meteorological season averages are calculated using the typical year daily values;</h5>
                    </li>

                    <li>
                        <h5><strong>Typical Year growing season</strong>: growing season (GS) and outside of growing season (OGS) averages (i.e., two values). The growing season averages are calculated using the typical year daily values;</h5>
                    </li>

                    <li>
                        <h5><strong>Yearly</strong>: the average for all days in the typical year daily (i.e., one value).</h5>
                    </li>
                </ul>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.3">3.3. Required Coefficients</h4><br/>

                <ul>
                    <li>
                        <h4>Input Data Module</h4>

                        <h5><span class="underlined">Start and end date for the growing season</span>. Used for allowing SNOW BUDDY to calculate all the parameters for the growing season (GS) and outside of the growing season (OGS). The start and end dates use <strong>mm-dd</strong> format (the year is ignored as the same dates are applied to all years available in the input data file).</h5>
                    </li>
                            
                    <br/>
                    <li>
                        <h4>SNOW Module</h4>

                        <h5>The coefficients used by the SNOW module are used during the calibration of the model.</h5>

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
                    </li>

                    <br/>
                    <li>
                        <h4>WATER BALANCE Module</h4>

                        <h5>The coefficients used by the WATER BALANCE module are used during the calibration of the model.</h5>

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
                    </li>                   
                </ul>            
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>                                            

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.4">3.4. SNOW Module</h4><br/>

                <h5>The SNOW module allows for estimation of a series of snow related processes (e.g., snowfall, snowmelt, snow layer thickness) and produces the amount of water available (i.e., water available for infiltration and surface runoff) for calculations carried out in the WATER BALANCE module. The input data for the SNOW module consists of daily time series of mean air temperature, total precipitation, rainfall amount and evapotranspiration. Air temperature, total precipitation and rainfall amount are readily available from weather monitoring stations. If not directly available to the user, evapotranspiration can be calculated on a daily basis using ETCalc, a tool included in the Hydrology Tool Set (HTS) available at <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>. The user is also required to provide a series of coefficients that control the snow related processes as well as a calibration time series (e.g., thickness of the soil layer) which allows for the calibration of the model.</h5>

                <h5>All the calculations for this module are performed using millimeters of water (mm) units. In addition, the snow layer thickness is available both as mm (<span data-toggle="tooltip" title="<?= $tooltips['SNTFmm'] ?>">SNTFmm</span>) and cm (<span data-toggle="tooltip" title="<?= $tooltips['SNTFcm'] ?>">SNTFcm</span>).</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('SNOW BUDDY_snow_v1.png', [
                        'class' => ['img','max-h-400'], 
                        'alt' => 'Simplified workflow diagram for the SNOW module'
                    ]); ?>
                </div>  
                <div class="row mt-2 my-5">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Fig 2. Simplified workflow diagram for the SNOW module</h5>
                        <h6>TOTPP - daily total precipitation (input data); RAIN - daily rain (input data); ETA - daily actual (or crop) evapotranspiration (input data); SNOF - Snowfall amount; SNTF - Snow layer thickness; Etas - Above soil ET; Etis - Soil ET; WATisrf - Water available for infiltration or surface runoff; THRrs - Air temperature threshold for rain to be accumulated as snow; THRsm - Air temperature threshold for initiating snowmelt; CFTsm - Correction factor (snowmelt due to air temperature); CFRsm - Correction factor (snowmelt due to rain); SNMT - Snowmelt due to temperature; SNMR - Snowmelt due to temperature; CFets - Correction factor (portion of evapotranspiration occurring in the soil); THRets - Soil water content threshold for stopping soil evapotranspiration when the soil is dry. Dashed lines indicate output parameters from the SNOW module used for subsequent calculations in the WATER Balance module.</h6>
                    </div>
                </div> 

                <h5>The input parameters as well as the parameters calculated in the SNOW module are listed in the table below. The parameters in bold are considered to be key output parameters and are the parameters that are shown by default in Table View, while most of the other parameters are shown only if selected by user.</h5>

                <table class="table table-bordered text-center my-3 mt-1">
                    <thead class="thead-dark">                        
                        <tr class="table-primary" style="font-style:italic">
                            <td>NAME</td>
                            <td>LONG NAME</td>
                            <td>DEFINITION</td>                                                             
                        </tr>                                
                        <tr class="table-info">
                            <td>DATE</td>
                            <td>Day (yyyy-mm-dd)</td>
                            <td>Date for analyzed data</td>                                                                      
                        </tr>                                
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></td>
                            <td>Temperature (&deg; C)</td>
                            <td>Mean air temperature (input data)</td>                                                                         
                        </tr>            
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></td>
                            <td>Total precipitation (mm)</td>
                            <td>Total precipitation amount (input data)</td>                                                                         
                        </tr>     
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></td>
                            <td>Rain (mm)</td>
                            <td>Rain amount (input data)</td>                                                                         
                        </tr>  
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span></td>
                            <td>Snowfall (mm)</td>
                            <td>Snowfall amount (difference between TOTPP and RAIN)</td>                                                                         
                        </tr>   
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAINS'] ?>">RAINS</span></td>
                            <td>Rain added to the snow layer (mm)</td>
                            <td>Amount of rain that is converted to snow (dependent on THRrs)</td>                                                                         
                        </tr>            
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAINNS'] ?>">RAINNS</span></td>
                            <td>Rain not added to the snow layer (mm)</td>
                            <td>Amount of rain that is converted to snow (dependent on THRrs)</td>                                                                         
                        </tr>     
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNOA'] ?>">SNOA</span></td>
                            <td>Snowfall added to the snow layer (mm)</td>
                            <td>Amount of snowfall that is added to the snow layer (dependent on THRsm)</td>                                                                         
                        </tr>  
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNOM'] ?>">SNOM</span></td>
                            <td>Snowfall not added to the snow layer (mm)</td>
                            <td>Amount of snowfall that is melting instead of being added to the snow layer</td>                                                                         
                        </tr>   
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['RSSL'] ?>">RSSL</span></td>
                            <td>Rain and snowfall contributing to snow layer (mm)</td>
                            <td>Amount of water from rain and snowfall that accumulates to the snow layer before temperature and precipitation corrections for the snow layer are applied</td>                                                                         
                        </tr>            
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RSI'] ?>">RSI</span></td>
                            <td>Rain and snowfall contributing to infiltration (mm) (mm)</td>
                            <td>Amount of water from rain and snowfall that does not accumulate to the snow and contributes to water available for infiltration</td>                                                                         
                        </tr>     
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SNMT'] ?>">SNMT</span></td>
                            <td>Snowmelt due to temperature (mm)</td>
                            <td>The amount of snowmelt is dependent on the air temperature. SNMT is calculated using the degree-day concept and is dependent on THRsm and CFTsm</td>                                                                         
                        </tr>  
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SNMR'] ?>">SNMR</span></td>
                            <td>Snowmelt due to rain (mm)</td>
                            <td>Rain that is not converted to snow can produce snowmelt. SNMR represents the amount of snowmelt associated (direct) rain. SNMR is calculated using a concept similar to the degree-day concept used for SNMT and is dependent on CFRsm</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNTFmm'] ?>">SNTFmm</span></td>
                            <td>Snow layer thickness (mm) </td>
                            <td>Snow layer thickness (expressed as mm) after temperature and precipitation corrections. SNTF represents the final values of snow layer thickness and is a key output parameter</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SNMF'] ?>">SNMF</span></td>
                            <td>Snowmelt (mm)</td>
                            <td>Snowmelt amount after temperature and precipitation corrections. SNMF represents water originating from the snow layer that becomes available for infiltration and/or surface runoff. The assumption is that all the snow that melts become available for infiltration and/or surface runoff instead of being stored above the ground in liquid</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETA'] ?>">ETA</span></td>
                            <td>Evapotranspiration (ET) (mm)</td>
                            <td>Actual evapotranspiration (input data)</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETasi'] ?>">ETasi</span></td>
                            <td>Above soil ET (mm) before correction for dry soil (mm)</td>
                            <td>Portion of evapotranspiration that occurs above soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of Etasi is controlled by CFets. This is an intermediate result that is adjusted via subsequent calculations</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span></td>
                            <td>ET from soil transferred to ET above soil when soil is dry (mm) </td>
                            <td>Evapotranspiration from soil ceases under dry soil conditions (controlled by THRets). THRets allows for transferring ET from soil to ET above ground ET (ETAs) if evaporative demand is still present (ETA) when the soil is dry. The full calculations for ETfsas are performed in the SOIL WATER module. If the SOIL WATER module has not been run, ETfsas is assumed to be zero. Generally, ETfsas is small and hence this limitation is not expected to impact calculations significantly. ETfsas values are adjusted once the SOIL WATER module calculations are performed. ETfsas is the amount transferred from soil ET to above soil ET.</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETasf'] ?>">ETasf</span></td>
                            <td>Above soil ET after rerouting ET from dry soil (mm)</td>
                            <td>Portion of evapotranspiration that occurs above soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of Etasf (and ETasi) is controlled by CFets. This is the final result representing the portion of evapotranspiration that occurs above soil and includes corrections for dry soil conditions (ETfsas)</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span></td>
                            <td>Water available for infiltration or surface runoff after ET correction (mm)</td>
                            <td>The water amount that is available for either infiltration or surface runoff after all corrections, including impact of evapotranspiration. WATisrf is a key parameter calculated in the SNOW module and constitutes the starting point for the calculations conducted in the SOIL WATER module</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SNTFcm'] ?>">SNTFcm</span></td>
                            <td>Snow layer thickness (cm)</td>
                            <td>Snow layer thickness (expressed as cm) after temperature and precipitation corrections. SNTFcm is obtained by converting SNTFmm to cm of snow by using CFSmc. SNTFcm represents the final values of snow layer thickness and is a key output parameter.</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span></td>
                            <td>User-provided calibration data</td>
                            <td>If provided, UCD data allows for pairing of SNOW BUDDY calculated parameters with data from other sources during the calibration of the model</td>                                                                         
                        </tr> 
                    </thead>
                    <tbody>        
                    </tbody>
                </table>

                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.5">3.5. WATER BALANCE Module</h4><br/>

                <h5>The WATER BALANCE module allows for daily estimation of soil water content and of a series of water budget components (e.g., infiltration, drainage, surface runoff). This module does not require additional meteorological time series and all the calculations are based on the output from the SNOW module and the additional coefficients that the user needs to provide for this module. These coefficients are used for describing soil properties and for controlling infiltration, drainage, and surface runoff routines. This module also offers the option for setting up thresholds for dry and wet soil state, which are useful in studies related to soil or crop water deficiency and/or excess. For a more in-depth evaluation of water deficit and/or excess, together with testing of irrigation scenarios and impacts on aquifer storage the users are encouraged to use SWIB (Soil Water Stress, Irrigation Requirement and Water Balance), another tool included in HTS, and available at <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>. SWIB requires daily time series of soil water content (SWC), which can be estimated using SNOW BUDDY or obtained from other sources (e.g., databases of soil moisture measurements, other models, etc.). Similar to the SNOW module, the WATER BALANCE module requires the user to provide one or more calibration time series (e.g., soil water content, groundwater recharge, surface runoff) obtained from other sources that can be used for calibration of the output from this module. Although based on different underlying assumptions, SepHydro hydrograph separation tool available in HTS can be used for estimating surface runoff and groundwater discharge components of streamflow, which can be used for example for calibrating the calculations integrated in The WATER BALANCE module.</h5>                            
                
                <h5>All the calculations for this module are performed using millimeters of water (mm) units. When needed, soil water content units (i.e., SWC), are converted from % to millimeters and vice versa using the thickness of the soil specified by the user.</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('SNOW BUDDY_waterbal_v1.png', [
                        'class' => ['img','max-h-600'], 
                        'alt' => 'Simplified workflow diagram for the WATER BALANCE module'
                    ]); ?>
                </div>  
                <div class="row mt-2 my-5">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Fig 2. Simplified workflow diagram for the WATER BALANCE module</h5>
                        <h6>WATisrf - Water available for infiltration or surface runoff; Etas - Above soil ET; Etis - Soil ET; INFcap - Infiltration capacity; SRact - Total surface runoff after removing drainage boost; THRinfLH - Soil water content threshold for switching between low and high infiltration rate; CFeidr - Drainage boost correction factor (from excess infiltration); INFact - Actual infiltration; SWCfin - Soil water content; DRact - Actual drainage; CFosdr - Drainage boost correction factor (from soil oversaturation); DRAfre - Drainage with frozen soil conditions; THRtstd - Air temperature threshold for stopping drainage; THRdraHL - Soil water content threshold for switching drainage from high to low rate (%); THRswstd - Soil water content threshold for stopping drainage; DRAcap - Drainage capacity.</h6>
                    </div>
                </div> 

                <h5>The input parameters as well as the parameters calculated in the SNOW module are listed in the table below. The parameters in bold are considered to be key output parameters and are the parameters that are shown by default in Table View.</h5>

                <table class="table table-bordered text-center my-3 mt-1">
                    <thead class="thead-dark">                        
                        <tr class="table-primary" style="font-style:italic">
                            <td>NAME</td>
                            <td>LONG NAME</td>
                            <td>DEFINITION</td>                                                             
                        </tr>                                
                        <tr class="table-info">
                            <td>DATE</td>
                            <td>Day (yyyy-mm-dd)</td>
                            <td>Date for analyzed data</td>                                                                      
                        </tr>                                
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TEMP'] ?>">TEMP</span></td>
                            <td>Temperature (&deg; C)</td>
                            <td>Mean air temperature (input data)</td>                                                                         
                        </tr>            
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['TOTPP'] ?>">TOTPP</span></td>
                            <td>Total precipitation (mm)</td>
                            <td>Total precipitation amount (input data)</td>                                                                         
                        </tr>     
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['RAIN'] ?>">RAIN</span></td>
                            <td>Rain (mm)</td>
                            <td>Rain amount (input data)</td>                                                                         
                        </tr>  
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SNOF'] ?>">SNOF</span></td>
                            <td>Snowfall (mm)</td>
                            <td>Snowfall amount (difference between TOTPP and RAIN)</td>                                                                         
                        </tr>                           
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['WATisrf'] ?>">WATisrf</span></td>
                            <td>Water available for infiltration or surface runoff after ET correction (mm)</td>
                            <td>The water amount that is available for either infiltration or surface runoff after all corrections, including impact of evapotranspiration. WATisrf is a key parameter calculated in the SNOW module and constitutes the starting point for the calculations conducted in the SOIL WATER module</td>                                                                         
                        </tr>                         
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['INFact'] ?>">INFact</span></td>
                            <td>Actual infiltration (mm)</td>
                            <td>Actual infiltration as constrained by WATisrf and INFcap. WATisrf that is in excess of INFcap is re-routed to surface runoff. INFact incorporates all adjustments relative to the infiltration process and is considered a key output parameter</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['DRAcap'] ?>">DRAcap</span></td>
                            <td>Drainage capacity (mm)</td>
                            <td>Maximum allowed daily drainage. DRAcap is based on either DRAlr (low infiltration rate) or DRAhr (high infiltration rate) as triggered by THRdraLH</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['DRAcap'] ?>">DRAfre</span></td>
                            <td>Drainage with frozen soil conditions (mm)</td>
                            <td>DRAcap corrected for frozen soil conditions as triggered by THRtstd. Drainage stops when soil temperature is lower than THRtstd</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['DRAfin'] ?>">DRAfin</span></td>
                            <td>Drainage with dry soil correction (mm)</td>
                            <td>DRAfre corrected for dry soil conditions as triggered by THRswstd. Drainage stops when SWC is lower than THRtstd. DRAfin represents the drainage before surface runoff boost (if any) is applied.</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['DRAbinf'] ?>">DRAbinf</span></td>
                            <td>Drainage boost from excess infiltration (mm)</td>
                            <td>Excess water is transferred to surface runoff when WATisrf > INFcap. For these cases, drainage can be set to receive a proportion of the water directly from surface runoff, as triggered by CFeidr.  Use of non-zero CFeidr forces the model to bypass SWC calculation. Hence, CFeidr starting values should be zero, and should be adjusted only if model calibration using other coefficients is not satisfactory</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['DRAoss'] ?>">DRAoss</span></td>
                            <td>Drainage boost from oversaturated soil (mm)</td>
                            <td>When soil becomes oversaturated, excess water is transferred to surface runoff. For these cases, drainage can be set to receive a proportion of the water directly from surface runoff, as triggered by CFosdr.  Use of non-zero CFosdr forces the model to bypass SWC calculation. Hence, CFosdr starting values should be zero, and should be adjusted only if model calibration using other coefficients is not satisfactory</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['DRAact'] ?>">DRAact</span></td>
                            <td>Actual drainage (mm)</td>
                            <td>Actual drainage. DRAact incorporates all adjustments relative to the drainage processes and is considered a key output parameter</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETisi'] ?>">ETisi</span></td>
                            <td>Soil ET (mm) before correction for dry soil</td>
                            <td>Portion of evapotranspiration that occurs in the soil. The assumption is that a portion of evapotranspiration occurs in the soil and the reminder occurs above the soil via processes such as canopy interception and/or water ponding at the soil surface. The proportion of ETisi is controlled by CFets. This is an intermediate result that is adjusted via subsequent calculations</td>                                                                         
                        </tr> 
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETcds'] ?>">ETcds</span></td>
                            <td>Soil ET corrected for dry soil (mm)</td>
                            <td>Evapotranspiration from soil ceases under dry soil conditions (controlled by THRets). ETcds is equal to ETisi when the soil is not under dry conditions and zero on the days with dry soil conditions</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ETfsas'] ?>">ETfsas</span></td>
                            <td>ET from soil transferred to ET above soil when soil is dry (mm)</td>
                            <td>Evapotranspiration from soil ceases under dry soil conditions (controlled by THRets). THRets allows for transferring ET from soil to ET above ground ET (ETAs) if evaporative demand is still present (ETA) when the soil is dry. ETfsas is the amount transferred from soil ET to above soil ET</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SWCint'] ?>">SWCint</span></td>
                            <td>Soil water content (mm) - intermediate</td>
                            <td>SWC (soil water content) after integrating infiltration, drainage and evapotranspiration processes. This is an intermediate result that is adjusted via subsequent calculations</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SWCfinmm'] ?>">SWCfinmm</span></td>
                            <td>Soil water content - corrected for saturated soil (mm)</td>
                            <td>SWC (soil water content) after SWCint is corrected for saturated soil conditions as set by PORe. SWCfinmm incorporates all adjustments relative to the SWC and is a key output parameter</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SWCfin'] ?>">SWCfin</span></td>
                            <td>Soil water content - corrected for saturated soil (%)</td>
                            <td>SWC (soil water content) after SWCint is corrected for saturated soil conditions as set by PORe. SWCfin incorporates all adjustments relative to the SWC and is a key output parameter</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SReinf'] ?>">SReinf</span></td>
                            <td>Surface runoff due to excess infiltration (mm)</td>
                            <td>Surface runoff due to excess water available for infiltration. Excess water is transferred to surface runoff when WATisrf > INFcap.</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SReinfDB'] ?>">SReinfDB</span></td>
                            <td>Surface runoff due to excess infiltration after removing drainage boost (mm)</td>
                            <td>Surface runoff due to excess water available for infiltration (WATisrf > INFcap) after a portion (controlled by CFeidr) has been re-routed to drainage (DRAbinf)</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SResas'] ?>">SResas</span></td>
                            <td>Surface runoff due to saturated soil (mm)</td>
                            <td>Surface runoff due to soil oversaturation (SWC > PORe). When soil becomes oversaturated, excess water is transferred to surface runoff</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SResasDB'] ?>">SResasDB</span></td>
                            <td>Surface runoff due to saturated soil after removing drainage boost (mm)</td>
                            <td>Surface runoff due to soil oversaturation (SWC > PORe) after a portion (controlled by CFosdr) has been re-routed to drainage (DRAoss)</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['SRTint'] ?>">SRTint</span></td>
                            <td>Total surface runoff before removing drainage boost</td>
                            <td>Total surface runoff, including all adjustments except for removing drainage boost (DRAbinf and DRAoss). This is an intermediate result that is adjusted via subsequent calculations</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SRTact'] ?>">SRTact</span></td>
                            <td>Total surface runoff after removing drainage boost (mm)</td>
                            <td>SRTact is SRTint after removing drainage boost (DRAbinf and DRAoss). SRTact incorporates all adjustments relative to the surface runoff processes and is considered a key output parameter</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SWCgain'] ?>">SWCgain</span></td>
                            <td>Net SWC gain (mm)</td>
                            <td>Soil layer gains water when SWCfinmm on day i+1 is higher than on day i. SWCgain similar to SWCloss over the long-term indicates that the soil water storage is in equilibrium</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SWCloss'] ?>">SWCloss</span></td>
                            <td>Net SWC loss (mm)</td>
                            <td>Soil layer losses water when SWCfinmm on day i+1 is lower than on day i. SWCloss similar to SWCgain over the long-term indicates that the soil water storage is in equilibrium</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SWClow'] ?>">SWClow</span></td>
                            <td>Days with low soil water content</td>
                            <td>Count for days in low SWC state (triggered by THRlw). This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days that require irrigation or number of days with water deficit</td>                                                                         
                        </tr>
                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['SWChigh'] ?>">SWChigh</span></td>
                            <td>Days with high soil water content</td>
                            <td>Count for days in high SWC state (triggered by THRlw). This is used only for counting the number of days when the soil is in this SWC state and can be used for example for estimating the number of days with excess water present in the soil</td>                                                                         
                        </tr>

                        <tr class="table-info">
                            <td><span style="font-weight:600;" data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span></td>
                            <td>User-provided calibration data</td>
                            <td>If provided, UCD data allows for pairing of SNOW BUDDY calculated parameters with data from other sources during the calibration of the model</td>                                                                         
                        </tr> 
                    </thead>
                    <tbody>        
                    </tbody>
                </table>  
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>             
                
                <br/>
                <br/><h4 class="l2-section" id="chapter_3.6">3.6. Model Calibration</h4><br/>

                <h5>Calibration of the model is performed via the Analysis tab of each of the calculation modules (i.e., SNOW and WATER BALANCE). Calibration is conducted by first pairing the output of the model with the user calibration data (e.g., SNTFcm [Snow layer thickness, mm] model output and measured snow thickness if available) using the "Calibration mapping" menu available under the "Analysis" tab of each calculation module.  Once the pairing is completed, the user can proceed running the respective module ("Run Snow Analysis" or "Run Water Balance Analysis" button at the bottom of the Analysis tab page) and inspect the fitness of the model in the subsequent Calibration overlay window. The fitness of the model for various timesteps and averaging intervals can be inspected in the Calibration overlay window via graphs as well as bivariate statistics.  If the calibration is considered unsatisfactory the user can return to the Analysis menu (i.e., "Return" button), adjust the various coefficients of the model and rerun the analysis. If the calibration is considered satisfactory the user can complete the calculations by proceeding to the next step (i.e., "Proceed to results"). To aid with data inspection and assessment of the fitness of the model SNOW BUDDY includes several univariate and bivariate statistics. Univariate statistics, including average, minimum, maximum and standard deviation are calculated separately for the input (i.e., user provided calibration data) and model output time series. The graphs and the univariate statistics can be used for example for comparing the general trends, the range of values and the amplitude of variations in both data sets. The bivariate statistics include the coefficient of determination (R2), root mean square error (RMSE) and the normalized root mean square error (NRMSE). NRMSE is calculated by using the average, the interquartile range or the differences between maximum and minimum (see definitions below). The bivariate statistics are used for evaluating the fitness of the model, by providing a measure of the differences between the values calculated by the model and the user provided calibration data (i.e., UCD). The equations used for calculating each bivariate statistic are shown below.</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_r_square.png', [
                        'class' => ['img','set-h-60'],
                        'alt' => 'Conceptual model for the Model Calibration'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 1. - Coefficient of determination</h5>
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
                        <h5 class="fig-title">Eq 2. - Root mean square error</h5>
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
                        <h5 class="fig-title">Eq 3. - Normalized root mean square error average</h5>
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
                        <h5 class="fig-title">Eq 4. - Normalized root mean square error IQR</h5>
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
                        <h5 class="fig-title">Eq 5. - Normalized root mean square error min/max</h5>
                        <h6>NRMSE<sub>min/max</sub> - normalized root mean square error calculated using minimum and maximum values of measured data<br/>
                        RMSE - root mean square error<br/>
                        x<sub>max</sub> - maximum value for observed data<br/>
                        x<sub>min</sub> - minimum value for observed data</h6>
                    </div>
                </div>

                <br/>
                <h5>It is recommended that the calibration is conducted by changing one coefficient at a time over a selected range of values. When no further improvement is observed in the model output the user can advance to adjusting the values of the next coefficient. The values of the various coefficients can be considered final once no further improvement in the model fitness is observed. At this time only calibration by trial and error is available, however the integration of an autocalibration routine in SNOW BUDDY is in planning stages.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>                
            </li>

            <li class="pt-5 pb-3 no-marker">
                <h3 class="top-section" id="chapter_4">4. User Guide</h3> 

                <h5>SNOW BUDDY (Snow, Soil Water and Water Balance Model) is an online model for obtaining daily estimates of snow related processes (e.g., snowfall, snowmelt, snow layer thickness), soil water content and a series of soil water budget components (e.g., infiltration, drainage, surface runoff) based on user provided daily meteorological (i.e., mean air temperature, total precipitation, rainfall), evapotranspiration and calibration data. The model provides tabular and graphical representations of the input data, output data, and user calibration data (UCD), as well as representative statistics for various time intervals including daily, monthly, meteorological and growing seasons, yearly and various averaging intervals for multiyear data sets (see section <a href="#chapter_3.2">3.2. Time steps and averaging</a>). The model incorporates extensive calibration routines for each calculation module included (i.e., Snow Module, Water Balance Module), which can be used if user calibration data (i.e., UCD) is provided.</h5>

                <h5>At the top, a contextual menu provides access to the various modules available. The modules can be accessed progressively, in the following order: 1) Home (Information module); 2) Input Data (Data entry module); 3) Snow (Calculation module); and 4) Water Balance (Calculation module). Once the calculations of a module are completed, the user can advance to the next module and can also return to the respective module at any time during the session. Additional menu tabs are available for both the data entry (i.e., Info, Load Data, Graphical View, Table View and Export Input Data for the Input Data module) and calculation (i.e., Info, Analysis, Graphical View, Table View and Export Data available for the SNOW and WATER BALANCE modules) modules. In the following sections the options available under the Input Data - Load menu tab and under the Analysis menu tab of each calculation module are presented in separate subsections. The options available under the other menu tabs are common to all three modules mentioned above and are presented as an additional subsection</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_4.1">4.1. Quick start</h4><br/>

                <h5>In order to run SNOW BUDDY the user has to go through the following steps:</h5>

                <ol class="large-list">
                    <li>
                        <h5>Load Data: provide required data or use the provided test data [Input Data module];</h5>
                    </li>

                    <li>
                        <h5>Perform SNOW calculations: enter required coefficients and select Run Snow Analysis [SNOW module - Analysis]. The calibration of the model is conducted by adjusting the coefficients available on this page in conjunction with the information displayed in the Calibration overlay window, which is launched by using the Run Snow Analysis button;</h5>
                    </li>

                    <li>
                        <h5>Perform WATER BALANCE module calculations: enter required coefficients and select Run Water Balance Analysis [Water Balance - Analysis]. The calibration of the model is conducted by adjusting the coefficients available on this page in conjunction with the information displayed in the Calibration overlay window, which is launched by using the Run Water Analysis button;</h5>
                    </li>

                    <li>
                        <h5>Investigate Results and Export Data: Review SNOW BUDDY output from each module [Table View and/or Graphical View] and export results [Export Data button available under each data entry and calculation modules or the CSV button available under the Stats and Calibration Stats of the Graphical View or under the Table, Stats and Calibration Stats of the Table View].</h5>
                    </li>
                </ol>

                <h5>The steps required for using this model are described in more detail below.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_4.2">4.2. Home Module</h4><br/>

                <h5>This module contains information related to the development, methodology and use of SNOW BUDDY. Under each of the input and calculation modules an Info tab is available, where general information relevant to the respective module is provided.</h5>

                <br/>
                <br/><h4 class="l2-section" id="chapter_4.3">4.3. Load Data (Input Data Module)</h4><br/>

                <h5>The Input Data menu entry has five tabs at the top of the page: Info, Load Data, Graphical View, Table View and Export Input Data.</h5>

                <h5>The first step in conducting an analysis is to upload the input data file to be used in SNOW BUDDY. The users can run SNOW BUDDY either by using the test dataset or by uploading a new dataset.</h5>
             
                <h5>For testing SNOW BUDDY and better understanding how the various components of the model operate, the user can upload the test data set provided by clicking on "Try the tool using the test dataset" button. The test dataset contains three years of weather and user calibration data (UCD). UCD data consists of snow layer thickness (cm; UCD1; corresponding to SNOW BUDDY SNTFcm output parameter; UCD1 measured at Environment and Climate Change Canada [ECCC] Charlottetown weather station, Prince Edward Island, Canada), soil water content (%; UCD2; corresponding to SNOW BUDDY SWCfin output parameter; UCD2 measured at Agriculture and Agri-Food Canada [AAFC] Harrington Experimental Farm, Prince Edward Island, Canada), surface runoff (mm; UCD3; corresponding to SNOW BUDDY SRTact output parameter; UCD3 estimated from hydrograph separation of Bell's Creek stream discharge based on data from measured at ECCC hydrometric stations in Prince Edward Island, Canada) and groundwater recharge (mm; UCD4; corresponding to SNOW BUDDY DRact output parameter; UCD4 estimated from groundwater levels measured in research wells at AAFC Harrington Experimental Farm, Prince Edward Island, Canada).</h5>

                <h5>For using SNOW BUDDY the users need to upload daily timeseries. The model accepts source data sets in Comma Separated File (csv) format. The users can use the "Export Input Data - Daily" menu to obtain a correctly formatted input file that can be used as a model for populating the input data file with user data. The user input file can be uploaded to SNOW BUDDY by using the "Upload user data" button. SNOW BUDDY allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods. It should be noted that the model cannot accommodate missing data (i.e., blank rows in required data columns) or erroneous data entries, and hence it is recommended that the integrity of the source data is verified before uploading.</h5>

                <h5>The input data file consists of a tabular file with 1 column dedicated to calendar date, 4 columns dedicated to required input data (TEMP - daily mean daily air temperature; TOTPP - daily total precipitation; RAIN - daily rain; ETA - daily actual (or crop) evapotranspiration) and 5 columns reserved for optional user calibration data (UCD1 to UCD5). The required input data columns have to contain values in all rows, while the optional data columns can be left blank if data is not available. UCD data sets are not restricted to certain parameters and can include time series for any parameter that the user intends to use for comparing with the output from SNOW BUDDY.  Examples of calibration time series datasets include thickness of snow layer, soil water content, groundwater recharge, surface runoff, etc.</h5>

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
                <h5>Once the input dataset is loaded to SNOW BUDDY via either the "Try the tool using the test data set" or "Upload user data" button an overlay window appears (i.e., "Select the UCD averaging method") asking the user to specify the method used for calculation of monthly values for each UCD timeseries (i.e., averaging vs. summation). Once this step is completed a new button ("UCD") is added to the right of the Input Data tab at the top of the page and the view switches to Graphical View. The UCD menu available at the top of the page allows the user to change the method for the calculation of monthly values for each UCD at any time. See section <a href="#chapter_4.6">4.6</a>. for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>

                <br/>
                <h5>Once the loading and inspecting of the input data is completed the user can click on the SNOW menu entry at the top of the page to advance to the first calculation module.</h5>

                <br/>
                <h5>Consult section <a href="#chapter_3.1">3.1.</a> and section <a href="#chapter_3.3">3.3.</a> for more details.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_4.4">4.4. Analysis - SNOW Module</h4><br/>

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
                <h5>Once the values for Starting values and Coefficients are set and the user selects the pairs to be used during the calibration (i.e., Calibration mapping menu), the user can click on the Run Snow Analysis button and the Calibration overlay window will be displayed. Both the Starting values and the Coefficients can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the model fitness is observed (see section <a href="#chapter_3.6">3.6.</a> for details regarding the calibration procedure). Upon completion of the calibration procedure the view switches to Graphical View. See section <a href="#chapter_3.6">3.6.</a> for instructions regarding the calibration of the model and section <a href="#chapter_4.6">4.6.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>                                                    

                <br/>
                <h5>The user can click on the Water Balance menu entry at the top of the page to advance to the next calculation module.</h5>

                <br/>
                <h5>Consult section <a href="#chapter_3.3">3.3.</a> and section <a href="#chapter_3.4">3.4.</a> for more details.</h5>                   
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_4.5">4.5. Analysis - WATER BALANCE Module</h4><br/>

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
                <h5>Once the values for Starting values and Coefficients are set and the user selects the pairs to be used during the calibration (i.e., Calibration mapping menu), coefficient values are set the user can click on the Run Snow Analysis button and the Calibration overlay window will be displayed. Both the Starting values and the Coefficients can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the model fitness is observed (see section <a href="#chapter_3.6">3.6.</a> for details regarding the calibration procedure). Upon completion of the calibration procedure the view switches to Graphical View. See section <a href="#chapter_3.6">3.6.</a> for instructions regarding the calibration of the model and section <a href="#chapter_4.6">4.6.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>   
                
                <br/>
                <h5>Consult section <a href="#chapter_3.3">3.3.</a> and section <a href="#chapter_3.5">3.5.</a> for more details.</h5>                   
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
                
                <br/>
                <br/><h4 class="l2-section" id="chapter_4.6">4.6. Data inspection, visualisation and export (all modules)</h4><br/>
            
                <h5>Inspection of data via graphical and tabular views can be conducted via the Graphical View, Table View and Export Data menu entries that become available in the Input Data module once the input dataset is loaded to SNOW BUDDY. These menu entries are also available under each of the calculation modules (SNOW and WATER BALANCE) and allow the user to evaluate the output for each of these modules.</h5>

                <br/>
                <h5><strong>Graphical View</strong> allows for plotting of input or output data using various time steps and intervals (see Section <a href="#chapter_3.2">3.2. Time steps and averaging</a> for more details) available via a drop-down menu. The parameters that can be displayed are available in the selection pane located to the right of the plot. Each parameter can be displayed on the primary (left) Y axis or on the secondary (right) Y axis by clicking on the toggle placed at the right of the selection pane. Additional options for customising the plot become visible in the top right corner when the mouse pointer is placed above the plot. These options include zoom, auto scale, reset axes, show data point labels, download plot, etc. Univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the model are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset ("Show Complete Dataset Stats" button) or for a selected subset ("Show stats by Interval" button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page</h5>

                <br/>
                <h5><strong>Table View</strong> allows the user to display data in tabular format using various time steps and intervals (see Section <a href="#chapter_3.2">3.2. Time steps and averaging</a> for more details). The user can also change the number of lines, filter data based on date or adjust the starting date of the data that is displayed. In the initial Table View, the columns displayed are limited to mostly "key" parameters, however the user can change the selection of the parameters to be displayed by selecting the parameters listed above the table. In the respective list, the parameters that are displayed in the table are shown in filled boxes, while the ones that are omitted are included in clear boxes. The “key” parameters are shown in red font. Similar to the Graphical View, univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the model are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset (“Show Complete Dataset Stats” button) or for a selected subset (“Show stats by Interval” button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page.</h5>

                <br/>
                <h5>The <strong>Export Data</strong> tab offers additional options for exporting the entire dataset using various time steps and intervals (see Section <a href="#chapter_3.2">3.2. Time steps and averaging</a> for more details). The Export Data tab also provides options for exporting statistics and metadata (i.e., parameters and coefficients used by the user in the respective module) The data is currently exported in csv format. The csv button located at the top right of each table in Table View or in Graphical View can be used if the intent is to export only the data shown in the current window.</h5>
                                
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_5">5. Limitations</h3>
                
                <h5>SNOW BUDDY allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods.</h5>

                <br/>
                <h5>SNOW BUDDY includes limited input data quality check routines. Hence, the user is advised to conduct a thorough data quality check before uploading input data to minimize the risk for erroneous output.</h5>

                <br/>
                <h5>Some components of the Water Balance module are still in testing stage (i.e., surface runoff, drainage, infiltration) and hence, this module should be used with caution.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_6">6. Terms of Use</h3> 

                <h5>SNOW BUDDY can be used freely.</h5>

                <h5>The authors do not assume any responsibility for the model's operation, output, interpretation, or use of results.</h5>               
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>         
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_7">7. Contact</h3> 

                <h5>
                    Serban Danielescu, Ph.D.<br/>
                    Research Scientist | Chercheur scientifique<br/>
                    Environment and Climate Change Canada | Environnement et Changements Climatiques Canada<br/>
                    Agriculture and Agri-Food Canada | Agriculture et Agroalimentaire Canada<br/>
                    Fredericton Research and Development Centre | Centre de recherche et développement de Fredericton<br/>
                    95 Innovation Rd., Fredericton, NB, E3B 4Z7<br/>
                    Telephone/Téléphone: 506-460-4468<br/>
                    Facsimile/Télécopieur: 506-460-4377<br/>
                    <a href="mailto:serban.danielescu@ec.gc.ca">serban.danielescu@ec.gc.ca</a><br/>
                    <a href="mailto:serban.danielescu2@agr.gc.ca">serban.danielescu2@agr.gc.ca</a>                
                    <?= $this->Html->image('email_addresses.png', ['class' => ['img','max-h-300']]); ?>
                </h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>
               
        </ul>                
    </div>    

    */?>
</div>