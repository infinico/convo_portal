<?php 
    $page_title = "New Employee Onboarding";
    $title = "New Employee Onboarding";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    admin_protect();
    protect_page();

    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");

    $errorUsername = $errorFirst = $errorLast = $errorPosition = $errorLocation = $errorStreet = $errorCity = $errorZip = $errorState = $errorStreetAddress = $errorCity = $errorZipCode = $errorEmailAddress = $errorPayroll = $errorDate = $errorPhoneNumber = $errorLocation = $errorGender = "";

    if(isset($_POST["submit"])) {
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
        if(empty($_POST["gender"])){
            $errorGender = "<span class='error'>Please enter gender</span>";   
        }
        
        else if(empty($_POST["username"])){
            $errorUsername = "<span class='error'>Please enter username</span>";
        }
        else if(user_exists($_POST["username"]) === true) {
            $errorUsername = "<span class='error'>Sorry, the username \"" . $_POST["username"] . "\" is already taken.</span>";   
        }
        
        if($errorUsername == "" && $errorFirst == "" &&  $errorLast == "" && $errorPosition == "" && $errorLocation == "" && $errorState == "" && $errorStreetAddress == "" && $errorCity == "" && $errorZipCode == "" && $errorPayroll == "" && $errorDate == "" && $errorGender == ""){
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
            $gender = sanitize($_POST["gender"]);
            $hourlyRate = sanitize($_POST["hourly_rate"]);
            $username = sanitize($_POST["username"]);
            $generated_password = substr(md5(rand(999, 999999)), 0, 8); //generated password
            $md5_password = md5($generated_password);
            
            // Convert from MM-DD-YYYY to YYYY-MM-DD to follow the MySQL Date Format
            $hireDateInput = multiexplode(array("-", "/"), $hire_date);
            $hireDate = $hireDateInput[2] . "-" . $hireDateInput[0] . "-" . $hireDateInput[1];
        
           $sql = "CALL insert_onboarding_hire('$firstname', '$lastname', '$jobTitle', '$street_address', '$city', '$state', '$zipcode', '$location', '$supervisor', '$payrollStatus', '$hourlyRate', '$hireDate', CURRENT_TIMESTAMP, 'Active', '1', '1', '$emailAddress', '$gender', '$username', 'O', '$md5_password');";
            //echo $sql;
            //die();
            mysqli_query($link, $sql);   
            
            onboarding_reset_password($firstname, $username, $emailAddress, $generated_password);
            
            echo "<h2 class='headerPages'>" . $firstname . " " . $lastname . "'s information was successfully added to the database, and an email has been sent to " . $firstname . ".</h2>";
            die();      
        }
    }
?>
    
            <h1 class="headerPages"> New Employee Onboarding</h1>
            <h3>Please fill out the new employee's information below.</h3>

            <form id="hire" method="POST">

                <!-- Personal Information -->
                <h2>Personal Information</h2>                         

               <!-- First Name -->
                <span class="spanHeader">First Name: </span>
                <input type="text" id="firstname" name="firstname" size="10" placeholder="First Name" value=<?php if(isset($_POST["submit"])){echo $_POST['firstname'];} ?>><?php echo $errorFirst; ?><br/><br/>

                <!-- Last Name -->
                <span class="spanHeader">Last Name: </span>
                <input type="text" id="lastname" name="lastname" size="10" placeholder="Last Name" value=<?php if(isset($_POST["submit"])){echo $_POST['lastname'];} ?>><?php echo $errorLast; ?><br/><br/>

                <!-- Gender -->
                <span class="spanHeader">Gender: </span>
                <select name="gender">
                    <option value="">Select a gender</option>
                    <option value="M" <?php if(isset($_POST["submit"]) && $_POST["gender"] == "M"){echo "selected='selected'";} ?>>M</option>
                    <option value="F" <?php if(isset($_POST["submit"]) && $_POST["gender"] == "F"){echo "selected='selected'";} ?> >F</option>
                </select> <?php echo $errorGender; ?><br/><br/>

                <!-- Street Address-->
                <span class="spanHeader">Street Address: </span>
                <input type="text" id="street_address" class="input-xlarge" name="street_address" placeholder="Street Address" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['street_address'] . "'";} ?>><?php echo $errorStreetAddress; ?><br/><br/>

                <!-- City -->
                <span class="spanHeader">City: </span>
                <input type="text" id="city" name="city" placeholder="City" value=<?php if(isset($_POST["submit"])){echo "'" .  $_POST['city'] . "'"; } ?>><?php echo $errorCity; ?><br/><br/>

                <!-- Resident State -->
                <span class="spanHeader">Resident State: </span>
                <select name="res_state" class="input-medium">
                    <?= create_option_list($states, "state") ?>
                </select><?php echo $errorState; ?><br/><br/>

                <!-- Zip Code -->
                <span class="spanHeader">Zip Code: </span>
                <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" maxlength="5" value=<?php if(isset($_POST["submit"])){echo $_POST['zipcode'];} ?>><?php echo $errorZipCode; ?><br/><br/>
                
                <span class="spanHeader">Email Address: </span>
                <input type="text" id="email_address" class="input-large" name="email_address" placeholder="example@gmail.com" value=<?php if(isset($_POST["submit"])){echo $_POST['email_address'];} ?>><?php echo $errorEmailAddress; ?><br/><br/>

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
                <input type="text" name="hourly_rate" class="input-small" value='0.00'><br/><br/>

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
                
                <!-- EMPLOYEE USERNAME AND PASSWORD INFORMATION -->
                <h2>Login Credentials</h2>

                <!-- Username-->
                <span class="spanHeader">Username: </span>
                <input type="text" name="username" value=<?php if(isset($_POST["submit"])){echo $_POST['username'];} ?>><?php echo $errorUsername ?><br/><br/>              
                <input type="submit" id="addButton" name="submit" value="Add">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>