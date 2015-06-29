<?php 
    $page_title = "Add DB Values";
    error_reporting(0);
    $title = "Convo Portal | Add Database ";
    include("../core/init.php");
    admin_protect();
    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");

    $flagPosition = $flagLocation = $flagDepartment = 0;

    $errorJobCode = $errorDeptCode = $errorPosition = $errorDepartment = $errorLocationCode = $errorLocation = $errorAddress = $errorCity = $errorState = $errorZipCode = ""; 


    if(isset($_POST["submit"])){
        
        if(!(empty($_POST["position_name"])) || !(empty($_POST["job_code"]))){
            if(empty($_POST["job_code"])){
                $errorJobCode = "<span class='error'>Please enter job code.</span>";
            }
            else if(job_code_exists($_POST["job_code"]) == true){
                $errorJobCode = "<span class='error'>The job code exists in the database, please enter different code.</span>";
            }
            if(empty($_POST["position_name"])){
                $errorPosition = "<span class='error'>Please enter position name.</span>";   
            }
            else if(position_name_exists($_POST["position_name"]) == true) {
                $errorPosition = "<span class='error'>The position name exists in the database, please enter different name.</span>";   
            }
            if($errorPosition == "" && $errorJobCode == ""){
                $positionName = sanitize($_POST["position_name"]);
                $jobCode = sanitize($_POST["job_code"]);
                $dept_code = sanitize($_POST["dept_name_for_position"]);
                $manager_privileges = sanitize($_POST["manager_privileges"]);
                $admin_privileges = sanitize($_POST["admin_privileges"]);
            
                if($admin_privileges == "Admin"){
                    $admin_privileges = "1";   
                }
                else{
                    $admin_privileges = "0";   
                }

                if($manager_privileges == "Manager"){
                    $manager_privileges = "1";   
                }

                else{
                    $manager_privileges = "0";
                }
               mysql_query("CALL insert_position('$positionName', '$jobCode', '$dept_code', '$manager_privileges', '$admin_privileges')");
                $flagPosition = 1; 
            }
        }
        
        if(!(empty($_POST["department_name"])) || !(empty($_POST["dept_code"]))){
            if(empty($_POST["dept_code"])){
                $errorDeptCode = "<span class='error'>Please enter department code.</span>";
            }
            else if(department_code_exists($_POST["dept_code"]) == true){
                $errorDeptCode = "<span class='error'>The department code exists in the database, please enter different code.</span>";
            }
            if(empty($_POST["department_name"])){
                $errorDepartment = "<span class='error'>Please enter department name.</span>";
            }
            else if(department_name_exists($_POST["department_name"]) == true) {
                $errorDepartment = "<span class='error'>The department name exists in the database, please enter different name.</span>";   
            }
            if($errorDepartment == "" && $errorDeptCode == ""){
                $departmentName = sanitize($_POST["department_name"]);
                $deptCode = sanitize($_POST["dept_code"]);
                mysql_query("CALL insert_department('$departmentName', '$deptCode')"); 
                $flagDepartment = 1;
            }
        }
        
        if(!(empty($_POST["convo_location"])) || !(empty($_POST["address"])) || !(empty($_POST["city"])) || !(empty($_POST["res_state"])) || !(empty($_POST["zipCode"])) || !(empty($_POST["location_code"]))){
            if(empty($_POST["location_code"])){
                $errorLocationCode = "<span class='error'>Please enter location code.</span>";
            }
            else if(convo_location_code_exists($_POST["location_code"]) == true){
                $errorLocationCode = "<span class='error'>The location code exists in the database, please enter different code.</span>";
            }
            if(empty($_POST["convo_location"])){
                $errorLocation = "<span class='error'>Please enter convo location.</span>";   
            }
            if(convo_location_exists($_POST["convo_location"]) == true) {
                $errorLocation = "<span class='error'>The convo location exists in the database, please enter different location.</span>";   
            }
            if(empty($_POST["address"])){
                $errorAddress = "<span class='error'>Please enter convo address</span>";   
            }
            if(empty($_POST["city"])){
                $errorCity = "<span class='error'>Please enter city</span>";   
            }
            if(empty($_POST["res_state"])){
                $errorState = "<span class='error'>Please select state</span>";   
            }
            if(empty($_POST["zipCode"])){
                $errorZipCode = "<span class='error'>Please enter zip code</span>";   
            }
            else if(!(is_numeric($_POST["zipCode"]))){
                $errorZipCode = "<span class='error'>Please enter numbers only.</span>";   
            }
            if($errorLocationCode == "" && $errorLocation == "" && $errorAddress == "" && $errorCity == "" && $errorState == "" && $errorZipCode == ""){
                $convoLocation = sanitize($_POST["convo_location"]);
                $address = sanitize($_POST["address"]);
                $city = sanitize($_POST["city"]);
                $state = sanitize($_POST["res_state"]);
                $zipCode = sanitize($_POST["zipCode"]);
                $locationCode = sanitize($_POST["location_code"]);
                
                mysql_query("CALL insert_location('$locationCode', '$convoLocation', '$address', '$city', '$state', '$zipCode')");
                $flagLocation = 1;                
            }
        }
        
        if($flagPosition == 1 && $flagDepartment == 1 && $flagLocation == 1){
            echo "<h2 class='headerPages'>New position name, department name, and location were added to database successfully!</h2>";  
            die();
        }
        else if($flagPosition == 1 && $flagDepartment){
            echo "<h2 class='headerPages'>New position and department name were added to database successfully!</h2>";
            die();
        }
        else if($flagPosition == 1 && $flagLocation){
            echo "<h2 class='headerPages'>New position name and location were added to database successfully!</h2>"; 
            die();
        }
        else if($flagDepartment == 1 && $flagLocation == 1){
            echo "<h2 class='headerPages'>New department name and location were added to database successfully!</h2>"; 
            die();
        }
        else if($flagPosition == 1){
            echo "<h2 class='headerPages'>New position name was added to database successfully!</h2>"; 
            die();
        }
        else if($flagDepartment == 1){
            echo "<h2 class='headerPages'>New department name was added to database successfully!</h2>";  
            die();
        }
        else if($flagLocation == 1){
            echo "<h2 class='headerPages'>New location was added to database successfully!</h2>";   
            die();
        }
    }
?>

            <h1 class="headerPages">Add DB Values</h1>

            <form id="addDatabase" method="POST">
                <!-- Position -->
                <h2>Position</h2>
                <span class="spanHeader">Job Code: </span>
                <input type="text" id="job_code" name="job_code" placeholder="Job Code" value=<?php if(isset($_POST["submit"])){echo $_POST['job_code'];} ?>><?php echo $errorJobCode; ?><br/><br/>

                <span class="spanHeader">Position Name: </span>
                <input type="text" id="position_name" name="position_name" class="input-xlarge" placeholder="Employee Role" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['position_name'] . "'";} ?>><?php echo $errorPosition; ?><br/><br/>

                <span class="spanHeader">Department Change: </span>
                <?php
                    echo "<select id='dept_name_for_position' name='dept_name_for_position'><option value=''>Select a department name</option>";
                    while($row = mysql_fetch_assoc($resultDepartment)) {
                        echo "<option value = '" . $row["dept_code"] . "'>" . $row["dept_code"] . " - " . $row["department_name"] . "</option>";   
                    }
                    echo "</select>";?>
                <input type='hidden' name='dept_code' class="input-xlarge" style='background:#E9E9E9;' readonly>
                <br/><br/>

                <span class="spanHeader">Admin Privilege:</span>
                <select value="admin_privileges" name="admin_privileges" class="input-medium">
                    <option value="">Select a privillege</option>
                    <option value = "Admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Admin"){echo "selected='selected'";} ?>>Yes</option>
                    <option value = "Non_admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Non_admin"){echo "selected='selected'";} ?>>No</option>
                </select><br/><em class="note">Permission to add, edit, and terminate employees.</em><br/><br/>


                <span class="spanHeader">Manager Privilege:</span>
                <select value="manager_privileges" name="manager_privileges" class="input-medium">
                    <option value="">Select a privillege</option>
                    <option value = "Manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Manager"){echo "selected='selected'";} ?>>Yes</option>
                    <option value = "Non_manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Non_manager"){echo "selected='selected'";} ?>>No</option>
                </select> <br/><em class="note">Permission to view direct reports' information and materials that are restricted to managers.</em><br/>


                <!-- Department -->
                <h2>Department</h2>

                <span class="spanHeader">Department Code: </span>
                <input type="text" id="dept_code" name="dept_code" placeholder="Department Code" value=<?php if(isset($_POST["submit"])){echo $_POST['dept_code'];} ?>><?php echo $errorDeptCode; ?><br/><br/>

                <span class="spanHeader">Department Name: </span>
                <input type="text" id="department_name" name="department_name" class="input-xlarge" placeholder="Department Name" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['department_name'] . "'";} ?>><?php echo $errorDepartment; ?><br/><br/>


                <h2>Location</h2>
                <!-- Convo Location -->

                <span class="spanHeader">Location Code: </span>
                <input type="text" id="location_code" name="location_code" placeholder="Location Code" value=<?php if(isset($_POST["submit"])){echo $_POST['location_code'];} ?>><?php echo $errorLocationCode; ?><br/><br/>

                <span class="spanHeader">Convo Location: </span>
                <input type="text" id="convo_location" name="convo_location" class="input-xlarge" placeholder="Convo Location" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['convo_location'] . "'";} ?>><?php echo $errorLocation; ?><br/><br/>

                <!-- Address -->
                <span class="spanHeader">Address: </span>
                <input type="text" id="address" name="address" class="input-xlarge" placeholder="Address" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['address'] . "'";} ?>><?php echo $errorAddress; ?><br/><br/>

                <!-- City -->
                <span class="spanHeader">City: </span>
                <input type="text" id="city" name="city" placeholder="City" value=<?php if(isset($_POST["submit"])){echo "'" . $_POST['city'] . "'";} ?>><?php echo $errorCity; ?><br/><br/>

                <!-- State -->
                <span class="spanHeader">State: </span>
                <select name="res_state" class="input-medium">
                    <?= create_option_list($states, "state") ?>
                </select><?php echo $errorState; ?><br/><br/>

                <!-- Zip Code -->
                <span class="spanHeader">Zip Code: </span>
                <input type="text" id="zipCode" name="zipCode" maxlength = "5" placeholder="Zip Code" value=<?php if(isset($_POST["submit"])){echo $_POST['zipCode'];} ?>><?php echo $errorZipCode; ?><br/><br/>

                <input type="submit" id="addButton" name="submit" value="Add">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>