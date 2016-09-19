<?php 
    $page_title = "Changes";
    error_reporting(0);
    $title = "Convo Portal | Changes";
    include("../core/init.php");
    admin_protect();
    protect_page();
    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");
    $url_empID = $_GET["employee_id"];
    $resultemployee = mysqli_query($link, "SELECT * FROM employee_info_vw");
    
    $errorName = $errorPosition = $errorEmpStatus = $errorPayroll = $errorLocation = $errorTerm = $errorFirstName = $errorLastName = $errorStreetAddress = $errorCity = $errorState = $errorZipCode = $errorEmail = $errorPhone =  "";
    if(isset($_POST["submit"])) {
        $employeeID = sanitize($_POST["employee_id"]);
        $jobTitle = sanitize($_POST["change_position_name"]);
        $payrollStatus = sanitize($_POST["change_payroll_status"]);
        $location = sanitize($_POST["convo_location"]);
        $employmentStatus = sanitize($_POST["emp_status"]);
        $supervisor = sanitize($_POST["supervisor"]);
        $firstname = sanitize($_POST["firstname"]);
        $lastname = sanitize($_POST["lastname"]);
        $street_address = sanitize($_POST["street_address"]);
        $city = sanitize($_POST["city"]);
        $res_state = sanitize($_POST["res_state"]);
        $zipcode = sanitize($_POST["zipCode"]);
        $hourlyRate = sanitize($_POST["hourly_rate"]);  
        $email = sanitize($_POST["email"]);
        $convoNumber = sanitize($_POST["convoNumber"]);
        
        
        /* testing */
        //$convoNumber = str_replace("-","", $convoNumber);
        
        //$convonumber = $convoNumber;
        //preg_replace('/\d{3}', '$0-', str_replace('.', null, trim($convonumber)), 2);
        //echo convoNumber;
        
            
        if(empty($_POST["employeeName"])) {
            $errorName = "<span class='error'>Please select the employee name</span>";  
        }
        if(empty($_POST["change_position_name"])){
            $errorPosition = "<span class='error'> Please select a position</span>";
        }
        if(empty($_POST["change_payroll_status"])){
            $errorPayroll = "<span class='error'> Please select the payroll status</span>";
        }
        if(empty($_POST["department"])){
            $errorDepartment = "<span class='error'> Please select the department</span>";
        }
        if(empty($_POST["convo_location"])){
            $errorLocation = "<span class='error'> Please select the location</span>";
        }
        if(empty($_POST["emp_status"])){
            $errorEmpStatus = "<span class='error'> Please select employment status</span>";   
        }
        
        if(empty($_POST["firstname"])){
            $errorFirstName = "<span class='error'> Please enter first name</span>";
        }
        
         if(empty($_POST["lastname"])){
            $errorLastName = "<span class='error'> Please enter last name</span>";
        }
        
        if(empty($_POST["street_address"])){
            $errorStreetAddress = "<span class='error'> Please enter street addresss</span>";
        }
        
        if(empty($_POST["city"])){
            $errorCity = "<span class='error'> Please enter city</span>";
        }
        
        if(empty($_POST["res_state"])){
            $errorState = "<span class='error'> Please pick a state</span>";
        } 
        
        
        if(empty($_POST["zipCode"])){
            $errorZipCode = "<span class='error'> Please enter zip code</span></span>";
        }  
        
        if(empty($_POST["email"])){
            $errorEmail= "<span class='error'> Please enter email</span>";
        }         
        
        
        
        
        if(isset($_POST["termination"]) == "Yes") {
            if(empty($_POST["termination_reason"])) {
                $errorTerm = "Please type reason.";   
            }
            
            $termination_checked = sanitize($_POST["termination"]);
            $termination_date = sanitize($_POST["termination_date"]);
            $termination_reason = sanitize($_POST["termination_reason"]);
            
            $terminationDateInput = multiexplode(array("-", "/"), $termination_date);
            $terminationDate = $terminationDateInput[2] . "-" . $terminationDateInput[0] . "-" . $terminationDateInput[1];
            
                //echo "UPDATE employee SET termination_date = '$terminationDate', termination_reason = '$termination_reason', employment_status = 'Terminated' WHERE employeeID = '$employeeID'";
                mysqli_query($link, "CALL terminate_employee_info('$terminationDate', '$termination_reason', 'Terminated', '0', '$employeeID')");
            
                echo "<h2 class='headerPages'>The employee was terminated successfully!</h2>";
                die();
        }
        else {   
            $phone = validatePhoneNumber($convoNumber);
            
            if($phone == false){
                $errorPhone = "<span class='error'> Please enter 10 digits only.</span>"; 
                
            }
            
            $phoneNumber = clean_up_phone($convoNumber);
            
            if($errorName == "" && $errorPhone == "" && $errorPosition == "" && $errorPayroll == "" && $errorLocation == "" && $errorEmpStatus == "" && $errorFirstName == "" && $errorLastName == "" && $errorStreetAddress == "" && $errorCity == "" && $errorState == "" && $errorZipCode == "" && $errorEmail == ""){
                
                $sql = "CALL update_employee_info('$jobTitle', '$location',  '$payrollStatus', '$hourlyRate', '$employmentStatus', '$supervisor', CURRENT_TIMESTAMP, '$firstname', '$lastname', '$street_address', '$city', '$res_state', '$zipcode', '$employeeID', '$email', '$phoneNumber')";
                
                if (!mysqli_query($link, $sql))
                {
                    echo("Error description: " . mysqli_error($link));
                }
                else
                {
                    echo "<h2 class='headerPages'>The employee's information was updated successfully!</h2>";
                }
                die();
            }
        }
    }
?>


            <h1 class="headerPages">Changes</h1>
            <h3>To make any changes, select an employee from the list.</h3>

            <!-- EMPLOYEE INFORMATION -->
            <h2>Employee Information</h2>
            <form id="changes" action="edit.php" method="POST">
                
             <!-- EMPLOYEE -->    
                
                
                <span class="spanHeader">Employee: </span>
                <?php
                    echo "<select id='employeeName' name='employeeName'><option value=''>Select an employee</option>";
                    while($row = mysqli_fetch_assoc($resultemployee)) {
                        echo '<option value = "' . $row['employee_id'] . '|' . $row['job_code'] . '|' . $row['position_name'] . '|' . $row['payroll_status'] . '|' . $row["convo_location"] . '|' . $row["employment_status"] . '|' . $row['firstname'] . '|' . $row["lastname"] . '|' . $row["supervisor_id"] . '|' . $row["street_address"] . '|' . $row["city"] . '|' . $row["res_state"] . '|' . $row["zipcode"] . '|' . $row["hourly_rate"] . '|' . $row["location_code"] . '|' . $row["email"] . '|' . $row["convoNumber"] . '"';
                        if($row["employee_id"] == $url_empID){
                            echo "selected='selected'";   
                        }
                        else if(isset($_POST["submit"])){
                            if(explode("|", $_POST["employeeName"])[0] == $row["employee_id"]){
                                echo "selected='selected'"; 
                            }
                        }
                        echo ">" . $row['lastname'] . ", " . $row["firstname"] . "</option>";   
                    }
                    echo "</select>";
                
                ?>
                
                <input type='text' name='employee_id' size='5' style='background:#E9E9E9;' readonly placeholder="Employee ID" 
                       value="<?php
                            if(isset($_POST["submit"])){
                                echo $_POST["employee_id"];
                            }
                        ?>"> <?php echo $errorName; ?><br/><br/>                
                
            <!-- POSITION -->    
                <span class="spanHeader">Position: </span>
                    <?php
                        echo "<select id='position_name' class='input-xlarge' name='change_position_name'><option value=''>Select a Position</option>";
                        while($row = mysqli_fetch_assoc($resultPosition)) {
                            echo "<option value ='" . $row['job_code'] . "'";
                             if(isset($_POST["submit"]) && $_POST["change_position_name"] == $row['job_code']){
                                echo "selected='selected'";
                            }
                            echo ">" . $row['job_code'] . " - " . $row['position_name'] . "</option>";       
                        }
                        echo "</select>"; 
                    ?>

                <input type='text' name='current_position_name' class="input-xlarge" style='background:#E9E9E9;' readonly
                    value="<?php
                            if(isset($_POST["submit"])){
                                echo $_POST["current_position_name"];
                            }
                        ?>">
                <br/><?php echo $errorPosition; ?><br/>
                
                
                 <!-- PAYROLL STATUS -->

                <span class="spanHeader">Payroll Status: </span>
                <select value="payroll_status" name="change_payroll_status">
                    <option value="">Select a Payroll Status</option>
                    <option value="GBS" <?php if(isset($_POST["submit"]) && $_POST["change_payroll_status"] == "GBS"){echo "selected='selected'";} ?>>GBS</option>
                    <option value="PT" <?php if(isset($_POST["submit"]) && $_POST["change_payroll_status"] == "PT"){echo "selected='selected'";} ?>>PT</option>
                    <option value="FT" <?php if(isset($_POST["submit"]) && $_POST["change_payroll_status"] == "FT"){echo "selected='selected'";} ?>>FT</option>
                </select>
                <input type='text' name='current_payroll_status' class="input-small" style='background:#E9E9E9;' readonly 
                       value="<?php
                            if(isset($_POST["submit"])){
                                echo $_POST["change_payroll_status"];
                            }
                        ?>">
                <?php echo $errorPayroll; ?><br/><br/>
                
                
             <!-- CONOV LOCATION -->    

                <span class="spanHeader">Convo Location: </span>
                    <?php
                        echo "<select id='convo_location' name='convo_location'><option value=''>Select a Convo Location</option>";
                        while($row = mysqli_fetch_assoc($resultLocation)) {
                            echo "<option value = '" . $row['location_code'] . "'";
                                if(isset($_POST["submit"]) && $_POST["convo_location"] == $row["location_code"]){
                                    echo "selected='selected'";   
                                }
                            
                            
                            echo ">" . $row['convo_location'] . "</option>";   
                        }
                        echo "</select>";?>
                <input type='text' name='current_convo_location' class="input-xlarge"  style='background:#E9E9E9;' readonly
                       value="<?php
                            if(isset($_POST["submit"])){
                                echo $_POST["current_convo_location"];
                            }
                        ?>">
                <?php echo $errorLocation; ?><br/><br/>
                
                
             <!-- SUPERVISOR -->    
                

                <span class="spanHeader">Supervisor: </span>
                    <?php   
                        echo "<select id='supervisor' name='supervisor'>";
                        echo "<option value=''>Select a supervisor</option>";
                        while($row = mysqli_fetch_assoc($resultSupervisor)) {
                            echo "<option value ='" . $row['employee_id'] . "'";
                            if(isset($_POST["submit"]) && $_POST["supervisor"] == $row['supervisor_id']){
                                echo "selected='selected'";
                            }
                            echo ">" . $row['supervisor'] . "</option>";   
                        }
                        echo "</select> <input type='text' name='current_supervisor' style='background:#E9E9E9;' readonly value><br/><em class='note'>blank means no supervisor</em>";
                    ?>  

                <br/><br/>

                
             <!-- EMPLOYMENT STATUS -->
                
                
                <span class="spanHeader">Employment Status: </span>
                <select value="emp_status" name="emp_status">
                    <option value="">Select a status</option>
                    <option value="Active" <?php if(isset($_POST["submit"]) && $_POST["emp_status"] == "Active"){echo "selected='selected'";} ?>>Active</option>
                    <option value="Leave"  <?php if(isset($_POST["submit"]) && $_POST["emp_status"] == "Leave"){echo "selected='selected'";} ?>>Leave</option>
                </select>
                <input type='text' name='current_emp_status' class="input-small"  style='background:#E9E9E9;' readonly 
                       value="<?php
                            if(isset($_POST["submit"])){
                                echo $_POST["emp_status"];
                            }
                        ?>"
                       
                       ><?php echo $errorEmpStatus ?><br/><br/>
                
            
             <!-- HOURLY RATE -->    

                <span class="spanHeader">Hourly Rate: </span>
                <input type="text" name="hourly_rate" class="input-small">
                <input type='text' name='current_hourly_rate' class="input-small" style='background:#E9E9E9;' value="<?php if(isset($_POST["submit"])){echo $_POST['hourly_rate'];} ?>" readonly><br/><br/>
                
                
             <!-- CONVO NUMBER -->    
                
                <span class="spanHeader">Convo Number: </span>
                <input type="text" name="convoNumber" class="input-medium" placeholder="xxx-xxx-xxxx" value=<?php if(isset($_POST["submit"])){echo $_POST['convoNumber'];} ?>> 
                <input type='text' name='current_convoNumber' class="input-medium"  style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['convoNumber'];} ?>> 
                <?php echo $errorPhone;?>    
            <!--<input type="text" name="current_convoNumber" class="input-medium" style='background:#E9E9E9;' placeholder="xxx-xxx-xxxx"  value="php if(isset($_POST["submit"])){echo $_POST['hourly_rate'];} ?>" readonly>{echo $errorPhone;} ?> -->
                
                
                
                <br/><br/><br/>

            
                
                <!-- PERSONAL INFORMATION -->
                
                <h2>Personal Information</h2>
                <span class="spanHeader">First Name: </span>
                <input type='text' name='firstname' class="input-medium" value=<?php if(isset($_POST["submit"])){echo $_POST['firstname'];} ?>>
                <input type='text' name='current_firstname' class="input-medium"  style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['firstname'];} ?>> 
                <?php echo $errorFirstName;?> <br/><br/>
               
                
                
                <span class="spanHeader">Last Name: </span>
                <input type='text' name='lastname' class="input-medium" value=<?php if(isset($_POST["submit"])){echo $_POST['lastname'];} ?>>
                <input type='text' name='current_lastname' class="input-medium" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['lastname'];} ?>>  
                <?php echo $errorLastName;?> <br/><br/>
              

                <span class="spanHeader"> Street Address: </span>
                <input type='text' name='street_address' class="input-xlarge" value=<?php if(isset($_POST["submit"])){echo "\"" . $_POST['street_address'] ."\"";} ?>>
                <input type='text' name='current_street_address' class="input-xlarge" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo "\"" . $_POST['street_address'] . "\"";} ?>>  
                <?php echo $errorStreetAddress;?> <br/><br/>
                
  
             
                <span class="spanHeader">City: </span>
                <input type='text' name='city' class="input-xlarge" value=<?php if(isset($_POST["submit"])){echo $_POST['city'];} ?>>
                <input type='text' name='current_city' class="input-xlarge" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['city'];} ?>>
                <?php echo $errorCity;?><br/><br/>
                    

                <span class="spanHeader">Resident State: </span>
                    <select name="res_state" class="input-medium">
                        <?= create_option_list($states, "state") ?>
                    </select>
                <input type='text' name='current_res_state' class="input-small" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['res_state'];} ?>>     
                <?php echo $errorState;?>  <br/><br/> 
                 

                <span class="spanHeader">Zip Code: </span>
                <input type='text' name='zipCode' class="input-small" maxlength="5" value=<?php if(isset($_POST["submit"])){echo $_POST['zipCode'];} ?>>
                <input type='text' name='current_zipCode' class="input-small" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['zipCode'];} ?>>
                <?php echo $errorZipCode;?> <br/><br/>
                               
                
                <span class="spanHeader">Email: </span>
                <input type='text' name='email' class="input-xlarge" maxlength="50" value=<?php if(isset($_POST["submit"])){echo $_POST['email'];} ?>>
                <input type='text' name='current_email' class="input-xlarge" style='background:#E9E9E9;' readonly value=<?php if(isset($_POST["submit"])){echo $_POST['email'];} ?>>
                <?php echo $errorEmail;?><br/><br/>     
                
                
                
                <!-- TERMINATION REASON -->
                <h2>Termination</h2>
                <span class="spanHeader">Terminate Employee?</span>
                <input type="checkbox" id = "termination" name="termination" value="terminate"><br/><br/><br/>
                <div id="termination_box">
                    <span class="spanHeader">Termination Date: </span><input type="text" class="datepicker" value="MM/DD/YYYY" name="termination_date"><br/><em class="note">MM/DD/YYYY</em><br/>
                    <span class="spanHeader">Termination Reason:</span><br/><?php echo $errorTerm; ?>

                    <input onblur="textCounter(this.form.recipients,this,1024);" disabled  onfocus="this.blur();" tabindex="999" maxlength="3" size="3" value="1024" name="counter"> characters remaining<br/>
                    <textarea onblur="textCounter(this,this.form.counter,1024);" onkeyup="textCounter(this,this.form.counter,1024);" style="WIDTH: 608px; HEIGHT: 94px;" name="termination_reason" rows="1" cols="15"></textarea>
                    <br/><br/>
                </div>
                <input type="submit" id="updateButton" name="submit" value="Update">
            </form>
<?php
include("../assets/inc/footer.inc.php");
?>