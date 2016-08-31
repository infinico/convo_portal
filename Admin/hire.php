<?php 
    $page_title = "Add Employee";
    $title = "Convo Portal | Hire";
    include("../core/init.php");
    admin_protect();
    protect_page();

    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");

    $errorId = $errorFirst = $errorLast = $errorPosition = $errorLocation = $errorStreet = $errorCity = $errorZip = $errorState = $errorStreetAddress = $errorCity = $errorZipCode = $errorEmailAddress = $errorPayroll = $errorDate = $errorPhoneNumber = $errorLocation = $errorDOB = $errorSSN = $errorGender = "";

    if(isset($_POST["submit"])) {
        if(empty($_POST["employee_id"])) {
            $errorId = "<span class='error'> Please enter employee ID from Paychex</span>";   
        }
        else if($_POST["employee_id"]{0} == "C"){
            if(!(is_numeric($_POST["employee_id"]{1})) || !(is_numeric($_POST["employee_id"]{2})) || !(is_numeric($_POST["employee_id"]{3})) || strlen($_POST["employee_id"]) != 4){
                $errorId = "<span class='error'>If it is a contractor, please use \"C###\"</span>"; 
            }
        }
        else if(!(is_numeric($_POST["employee_id"]))){
            $errorId = "<span class='error'>Please enter numbers or first character 'C' for contractor</span>";   
        }
        else if(employee_id_exists($_POST["employee_id"]) == true) {
            $errorId = "<span class='error'>The employee ID exists in the database, please enter different employee ID</span>";   
        }
        if(empty($_POST["firstname"])) {
            $errorFirst = "<span class='error'>Please enter first name</span>";
        }
        if(empty($_POST["lastname"])) {
            $errorLast = "<span class='error'>Please enter last name</span>";  
        }
        if(empty($_POST["change_position_name"])) {
            $errorPosition = "<span class='error'>Please enter a position</span>";   
        }
        if(empty($_POST["convo_location"])) {
            $errorLocation = "<span class='error'>Please enter a location</span>";
        }
        if(empty($_POST["res_state"])) {
            $errorState = "<span class='error'>Please pick Resident State</span>";  
        }
        if(empty($_POST["street_address"])){
            $errorStreetAddress = "<span class='error'>Please enter street address</span>";   
        }
        if(empty($_POST["city"])){
            $errorCity = "<span class='error'>Please enter city</span>";   
        }
        if(empty($_POST["zipcode"])){
            $errorZipCode = "<span class='error'>Please enter zip code</span>";   
        }
        else if(is_numeric($_POST["zipcode"]) == false){
            $errorZipCode = "<span class='error'>Please enter in number only</span>";
        }
        if(empty($_POST["email_address"])){
            $errorEmailAddress = "<span class='error'>Please enter an email address</span>";   
        }
        if(empty($_POST["payroll_status"])) {
            $errorPayroll = "<span class='error'>Please pick Payroll Status</span>";  
        } 
        if(empty($_POST["hire_date"])) {
            $errorDate = "<span class='error'>Please enter Month, Day, and Year</span>";     
        }
        /*if(empty($_POST["phone_number"])) {
            $errorPhoneNumber = "<span class='error'>Please enter Convo number </span>";     
        } */
        
        if(empty($_POST["dob"])){
            $errorDOB = "<span class='error'>Please enter date of birth</span>";   
        }
        if(empty($_POST["gender"])){
            $errorGender = "<span class='error'>Please enter gender</span>";   
        }
        if(empty($_POST["ssn"])){
            $errorSSN = "<span class='error'>Please enter last 4 digits ssn</span>";   
        }

        else if(!(is_numeric($_POST["ssn"]))){
            $errorSSN = "<span class='error'>Please enter number only</span>";
        }
        
        if($errorId == "" && $errorFirst == "" &&  $errorLast == "" && $errorPosition == "" && $errorLocation == "" && $errorState == "" && $errorStreetAddress == "" && $errorCity == "" && $errorZipCode == "" && $errorPayroll == "" && $errorDate == "" && $errorPhoneNumber == "" && $errorDOB == "" && $errorGender == "" && $errorSSN == ""){
            $employee_id = sanitize($_POST["employee_id"]);
            $firstname = sanitize($_POST["firstname"]);
            $lastname = sanitize($_POST["lastname"]);
            $jobTitle = sanitize($_POST["change_position_name"]);
            $location = sanitize($_POST["convo_location"]);
            $state = sanitize($_POST["res_state"]);
            $street_address = sanitize($_POST["street_address"]);
            $city = sanitize($_POST["city"]);
            $zipcode = sanitize($_POST["zipcode"]);
            $emailAddress = sanitize($_POST["email_address"]);
            $payrollStatus = sanitize($_POST["payroll_status"]);
            $supervisor = sanitize($_POST["supervisor"]);
            $hire_date = sanitize($_POST["hire_date"]);
            $phone_number = sanitize($_POST["phone_number"]);
            $dob = sanitize($_POST["dob"]);
            $ssn = sanitize($_POST["ssn"]);
            $gender = sanitize($_POST["gender"]);
            $hourlyRate = sanitize($_POST["hourly_rate"]);
            $new_hire_id = sanitize($_POST["hide_employee_id"]);
        
            // Convert from MM-DD-YYYY to YYYY-MM-DD to follow the MySQL Date Format
            $hireDateInput = multiexplode(array("-", "/"), $hire_date);
            $hireDate = $hireDateInput[2] . "-" . $hireDateInput[0] . "-" . $hireDateInput[1];
            
            $dobInput = multiexplode(array("-", "/"), $dob);
            $date_of_birth = $dobInput[2] . "-" . $dobInput[0] . "-" . $dobInput[1];
            
            $phoneNumber = clean_up_phone($phone_number);
            
            if(strlen($new_hire_id) > 0)
            {
                $sql = "CALL update_employee_hire('$new_hire_id', '$firstname', '$lastname', '$jobTitle', '$street_address', '$city', '$state', '$zipcode', '$location', '$supervisor', '$payrollStatus', '$hourlyRate', '$hireDate', CURRENT_TIMESTAMP, 'Active', '1', '0', '$emailAddress','$date_of_birth', '$ssn', '$gender', '$phoneNumber','$employee_id');";
                //echo $sql;
                //die();
                mysqli_query($link, $sql);
            }
            else
            {
                mysqli_query($link, "CALL insert_employee_hire('$employee_id', '$firstname', '$lastname', '$jobTitle', '$street_address', '$city', '$state', '$zipcode', '$location', '$supervisor', '$payrollStatus', '$hourlyRate', '$hireDate', CURRENT_TIMESTAMP, 'Active', '1', '0', '$emailAddress','$date_of_birth', '$ssn', '$gender', '$phoneNumber');");
            }
            
            
            
            echo "<h2 class='headerPages'>The employee's information was added to database successfully!</h2>";
            die();      
        }
    }
?>
    
            <h1 class="headerPages">Add employee</h1>
            <h3>Please fill out the new employee's information below.</h3>

            <form id="hire" method="POST">

                <!-- Personal Information -->
                <h2>Personal Information</h2>
                
                <span class="spanHeader">Employee:</span>
                <?php   
                        echo "<select id='new_hire' name='new_hire'>";
                        echo "<option value=''>Select onboarded employee</option>";
                        while($row = mysqli_fetch_assoc($resultNewHire)) 
                        {
                            echo "<option value ='" . 
                                $row['employee_id'] . "|" . 
                                $row['firstname'] . "|" . 
                                $row['lastname'] . "|" . 
                                $row['gender'] . "|" . 
                                $row['street_address'] . "|" . 
                                $row['city'] . "|" .
                                $row['res_state'] . "|" . 
                                $row['zipcode'] . "|" . 
                                $row['email'] . "|" .
                                $row['job_code'] . "|" .
                                $row['location_code'] . "|" .
                                $row['payroll_status'] . "|" .
                                $row['hourly_rate'] . "|" .
                                $row['supervisor_id'] . "|" .
                                $row['hire_date'] . "|" .
                                $row['date_of_birth'] . "|" .
                                $row['ssn'] .
                                "'";

                            echo ">" . $row['lastname'] . ", " . $row["firstname"] . "</option>";   
                        }
                        echo "</select>";
                ?><input type="hidden" name="hide_employee_id" value="<?php if(isset($_POST["submit"])){echo $_POST["hide_employee_id"];} ?>"><br/><br/>
                

               <!-- First Name -->
                <span class="spanHeader">First Name: </span>
                <input type="text" id="firstname" name="firstname" size="10" maxlength="40" placeholder="First Name" value=<?php if(isset($_POST["submit"])){echo $_POST['firstname'];} ?>><?php echo $errorFirst; ?><br/><br/>

                <!-- Last Name -->
                <span class="spanHeader">Last Name: </span>
                <input type="text" id="lastname" name="lastname" size="10" maxlength="40" placeholder="Last Name" value=<?php if(isset($_POST["submit"])){echo $_POST['lastname'];} ?>><?php echo $errorLast; ?><br/><br/>

                <!-- Gender -->
                <span class="spanHeader">Gender: </span>
                <select name="gender">
                    <option value="">Select a gender</option>
                    <option value="M" <?php if(isset($_POST["submit"]) && $_POST["gender"] == "M"){echo "selected='selected'";} ?>>M</option>
                    <option value="F" <?php if(isset($_POST["submit"]) && $_POST["gender"] == "F"){echo "selected='selected'";} ?> >F</option>
                </select> <?php echo $errorGender; ?><br/><br/>

                <!-- Date of Birth -->
                <span class="spanHeader">Date of Birth:</span>
                <input type="text" placeholder="MM/DD/YYYY" name="dob" maxlength="10" value=<?php if(isset($_POST["submit"])){echo $_POST['dob'];} ?>>
                <?php echo $errorDOB; ?><br/><br/>

                <!-- SSN -->
                <span class="spanHeader">SSN:</span>
                <input type="text" name="ssn" maxlength="4" size="5" placeholder="Enter last four digits" value=<?php if(isset($_POST["submit"])){echo $_POST['ssn'];} ?>>
                <?php echo $errorSSN; ?><br/><br/>

                <!-- Street Address-->
                <span class="spanHeader">Street Address: </span>
                <input type="text" id="street_address" class="input-xlarge" name="street_address" maxlength="255" placeholder="Street Address" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['street_address'] . "'";} ?>><?php echo $errorStreetAddress; ?><br/><br/>

                <!-- City -->
                <span class="spanHeader">City: </span>
                <input type="text" id="city" name="city" maxlength="255" placeholder="City" value=<?php if(isset($_POST["submit"])){echo "'" .  $_POST['city'] . "'"; } ?>><?php echo $errorCity; ?><br/><br/>

                <!-- Resident State -->
                <span class="spanHeader">Resident State: </span>
                <select name="res_state" class="input-medium">
                    <?= create_option_list($states, "state") ?>
                </select><?php echo $errorState; ?><br/><br/>

                <!-- Zip Code -->
                <span class="spanHeader">Zip Code: </span>
                <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" maxlength="5" value=<?php if(isset($_POST["submit"])){echo $_POST['zipcode'];} ?>><?php echo $errorZipCode; ?><br/><br/>
                
                <span class="spanHeader">Email Address: </span>
                <input type="text" id="email_address" class="input-large" name="email_address" maxlength="50" placeholder="example@gmail.com" value=<?php if(isset($_POST["submit"])){echo $_POST['email_address'];} ?>><?php echo $errorEmailAddress; ?><br/><br/>
                
                


                <!-- EMPLOYEE INFORMATION -->
                <h2>Employee Information</h2>

                <!-- Position -->
                <span class="spanHeader">Position: </span>
                <?php
                    echo "<select id='position_name' class='input-xlarge' name='change_position_name'><option value=''>Select a Position</option>";
                    while($row = mysqli_fetch_assoc($resultPosition)) {
                        echo "<option value = '" . $row['job_code'] . "'";

                        if(isset($_POST["submit"]) && $_POST["change_position_name"] == $row['job_code']){
                            echo "selected='selected'";
                        }       
                        echo ">" . $row['job_code'] . " - " . $row['position_name'] . "</option>";   
                    }
                    echo "</select>";
                    echo $errorPosition; 
                ?>
                <br/><br/>

                <!-- Convo Location -->
                <span class="spanHeader">Convo Location: </span>
                    <?php
                        echo "<select id='convo_location' class='input-xlarge' name='convo_location'><option value=''>Select a Convo Location</option>";
                        while($row = mysqli_fetch_assoc($resultLocation)) {
                            echo "<option value = '" . $row['location_code'] . "'";
                            if(isset($_POST["submit"]) && $_POST["convo_location"] == $row['location_code']){
                                echo "selected='selected'";
                            }
                            echo ">" . $row["location_code"] . " - " . $row['convo_location'] . "</option>";   
                        }
                        echo "</select>";
                        echo $errorLocation; 
                    ?>
                <br/><br/>

                <!-- Payroll Status -->
                <span class="spanHeader">Payroll Status: </span>
                <select id="payroll_status" name="payroll_status">
                    <option value="">Select a Payroll Status</option>
                    <option value="GBS" <?php if(isset($_POST["submit"]) && $_POST["payroll_status"] == "GBS"){echo "selected='selected'";} ?>>GBS</option>
                    <option value="FT" <?php if(isset($_POST["submit"]) && $_POST["payroll_status"] == "FT"){echo "selected='selected'";} ?>>FT</option>
                    <option value="PT" <?php if(isset($_POST["submit"]) && $_POST["payroll_status"] == "PT"){echo "selected='selected'";} ?>>PT</option>
                </select><?php echo $errorPayroll; ?><br/><br/>

                <!-- Hourly Rate -->
                <span class="spanHeader">Hourly Rate: </span>
                <input type="text" name="hourly_rate" class="input-small" value='0.00' maxlength="10"><br/><br/>

                <!-- Supervisor -->
                <span class="spanHeader">Supervisor: </span>
                    <?php   
                        echo "<select id='supervisor' name='supervisor'>";
                        echo "<option value=''>Select a supervisor</option>";
                        while($row = mysqli_fetch_assoc($resultSupervisor)) {
                        echo "<option value ='" . $row['employee_id'] . "'";
                        if(isset($_POST["submit"]) && $_POST["supervisor"] == $row['employee_id']){
                            echo "selected='selected'";
                        }
                        echo ">" . $row['supervisor'] . "</option>";   
                    }
                        echo "</select><br/> <em class='note'>blank means no supervisor</em>";
                    ?><br/><br/>

                <!-- Hire Date -->
                <span class="spanHeader">Hire Date:</span>
                <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="hire_date" value=<?php if(isset($_POST["submit"])){echo $_POST['hire_date'];} ?>><?php echo $errorDate; ?><br/><br/>
                
                <!-- Phone Number -->
                <span class="spanHeader">Convo Number:</span>
                <input type="text" placeholder="xxx-xxx-xxxx" class="input-large" name="phone_number" maxlength="12" value=<?php

               if(isset($_POST["submit"])){echo $_POST['phone_number'];} ?>><br/><br/>
                
                <!-- EmployeeID -->
                <span class="spanHeader">Paychex Employee ID: </span>
                <input type="text" id="employee_id" name="employee_id" placeholder="Get from Paychex" maxlength="4" value=<?php if(isset($_POST["submit"])){echo $_POST['employee_id'];} ?>><?php echo $errorId; ?><br/><br/>
            

                <input type="submit" id="addButton" name="submit" value="Add">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>