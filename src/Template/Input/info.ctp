<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Input Data Module</h2>
        </div>        

        <div class="table-responsive text-left">

            <div class="table-responsive text-left pt-2">
                <h5>The number of columns, data format and the units of the various weather parameters required for the input file are shown in the table below.</h5>                
                <table class="table table-bordered text-center my-3">
                    <thead class="thead-dark">
                        <tr class="table-primary">
                            <td class="customlegend" colspan=7>
                                <fieldset>
                                    <legend>SNOW BUDDY Input data file: format, columns, and units for input and user calibration data (UCD)</legend>
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
            <h5>Notes:</h5>

            <ul>
                <li>
                    <h5><span class="underlined">Required data</span>:
                        <br/>DATE - use yyyy-mm-dd format;                             
                        <br/>TEMP -  daily mean daily air temperature;                                                         
                        <br/>TOTP - daily total precipitation;
                </li>

                <li>
                    <h5><span class="underlined">Optional data</span>:
                        <br/>UCD - user calibration data (up to three columns; leave blank if no data is available)</h5>
                </li>

                <li>
                    <h5>The tool requires daily data</h5>
                </li>

                <li>
                    <h5>The user input data file must be uploaded using a file with one column dedicated to calendar date, two columns dedicated to input data (TEMP, TOTP) and up to three columns reserved for optional user calibration data (UCD1 to UCD3)</h5>
                </li>

                <li>
                    <h5>Use the first row of the data set for column headings</h5>
                </li>

                <li>
                    <h5>SNOWFALL BUDDY includes several input data integrity and quality check routines; however, the user is advised to thoroughly check the input dataset before uploading it to the tool to minimize the risk for erroneous output</h5>
                </li>                    
            </ul>        

            <br/>
            <h5>Consult section <a href="<?= $this->Url->build('/main/index#chapter_3.1');?>">3.1.</a> and section <a href="<?= $this->Url->build('/main/index#chapter_3.3');?>">3.3.</a> for more details.</h5>    
        </div>               
    </div>

</div>