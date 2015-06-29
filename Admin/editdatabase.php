<?php 
    $page_title = "Edit DB Values";
    error_reporting(0);
    $title = "Convo Portal | Edit Database";
    include("../core/init.php");
    admin_protect();
    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");
    //$url_empID = $_GET["employerID"];

$flagPosition = $flagLocation = $flagDepartment = 0;

    $errorName = $errorPosition = $errorDepartment = $errorEmpStatus = $errorPayroll = $errorLocation = $errorTerm = "";
   $resultPositionDB = mysql_query("SELECT * FROM position_db_vw");
    $resultDepartmentName = mysql_query("SELECT * FROM department_vw");

    if(isset($_POST["submit"])) {       
        if(!(empty($_POST["positionName"]))){
            $jobCode = sanitize($_POST["job_code"]);
            $jobTitle = sanitize($_POST["change_positionName"]);
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

            mysql_query("CALL update_position_type('$jobTitle', '$dept_code',  '$manager_privileges', '$admin_privileges', '$jobCode')");
            
            $flagPosition = 1;
        }
        if(!(empty($_POST["departmentName"]))){
            $deptCode = sanitize($_POST["dept_code"]);
            $department = sanitize($_POST["change_department_name"]);
            mysql_query("CALL update_department('$deptCode', '$department')"); 
            $flagDepartment = 1;
        }
        
        if(!(empty($_POST["convoLocation"]))){
            $locationCode = sanitize($_POST["location_code"]);
            $location = sanitize($_POST["change_convoLocation"]);
            $address = sanitize($_POST["address"]);
            $city = sanitize($_POST["city"]);
            $state = sanitize($_POST["state"]);
            $zipcode = sanitize($_POST["zipCode"]);
            
            mysql_query("CALL update_location('$locationCode', '$location', '$address','$city', '$state', '$zipcode')"); 
            
            $flagLocation = 1;
        }
        
        if($flagPosition == 1 && $flagDepartment == 1 && $flagLocation == 1){
            echo "<h2 class='headerPages'>Position name, department name, and location were updated to database successfully!</h2>";  
            die();
        }
        else if($flagPosition == 1 && $flagDepartment){
            echo "<h2 class='headerPages'>Position and department name were updated to database successfully!</h2>";
            die();
        }
        else if($flagPosition == 1 && $flagLocation){
            echo "<h2 class='headerPages'>Position name and location were updated to database successfully!</h2>"; 
            die();
        }
        else if($flagDepartment == 1 && $flagLocation == 1){
            echo "<h2 class='headerPages'>Department name and location were updated to database successfully!</h2>"; 
            die();
        }
        else if($flagPosition == 1){
            echo "<h2 class='headerPages'>Position name was updated to database successfully!</h2>"; 
            die();
        }
        else if($flagDepartment == 1){
            echo "<h2 class='headerPages'>Department name was updated to database successfully!</h2>";  
            die();
        }
        else if($flagLocation == 1){
            echo "<h2 class='headerPages'>Location was updated to database successfully!</h2>";   
            die();
        }
        
        
        
        //echo "UPDATE department SET department = '$department' WHERE dept_code = '$deptCode'";
    }
?>

        <h1 class="headerPages">Edit DB Values</h1>

        <h2>Position</h2>
        <form id="changes" action="editdatabase.php" method="POST">
            <span class="spanHeader">Position Name: </span>
            <?php
                echo "<select id='positionName' class='input-xlarge' name='positionName'><option value=''>Select a position name</option>";
                while($row = mysql_fetch_assoc($resultPositionDB)) {
                    echo "<option value = '" . $row["position_name"] . "|" . $row["job_code"] . "|" . $row["dept_code"] . "|" . $row["manager_privilege"] . "|" . $row["admin_privilege"] . "|" . $row["department_name"] . "'>" . $row["job_code"] . " - " . $row["position_name"] . "</option>";   
                }
                echo "</select>";?>
            <input type='hidden' name='job_code' class="input-xlarge" style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Position Name Change: </span>
            <input type='text' name='change_positionName' class="input-xlarge">        
            <input type='text' name='current_positionName' class="input-xlarge" style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Department Change: </span>
            <?php
                echo "<select id='dept_name_for_position' class='input-xlarge' name='dept_name_for_position'><option value=''>Select a department name</option>";
                while($row = mysql_fetch_assoc($resultDepartmentName)) {
                    echo "<option value = '" . $row["dept_code"] . "'>" . $row["dept_code"] . " - " . $row["department_name"] . "</option>";   
                }
                echo "</select>";?>
            <input type='text' name='current_dept_name_for_position' class="input-xlarge" style='background:#E9E9E9;' readonly>
            <input type='hidden' name='dept_code' class="input-xlarge" style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Admin Privilege:</span>
            <select value="admin_privileges" name="admin_privileges" class="input-medium">
                <option value="">Select a privilege</option>
                <option value = "Admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Admin"){echo "selected='selected'";} ?>>Yes</option>
                <option value = "Non_admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Non_admin"){echo "selected='selected'";} ?>>No</option>
            </select> <input type='text' class="input-small" name='current_admin_privileges' style='background:#E9E9E9;' readonly><em> <strong>1:</strong> admin privileges and <strong>0:</strong> no admin privileges</em><br/><em class="note">Permission to add, edit, and terminate employees.</em><br/><br/>


            <span class="spanHeader">Manager Privilege:</span>
            <select value="manager_privileges" name="manager_privileges" class="input-medium">
                <option value="">Select a privilege</option>
                <option value = "Manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Manager"){echo "selected='selected'";} ?>>Yes</option>
                <option value = "Non_manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Non_manager"){echo "selected='selected'";} ?>>No</option>
            </select> <input type='text' class="input-small" name='current_manager_privileges' style='background:#E9E9E9;' readonly><em> <strong>1:</strong> manager privileges and <strong>0:</strong> no manager privileges</em><br/><em class="note">Permission to view direct reports' information and materials that are restricted to managers.</em><br/>

            <h2>Department</h2>

            <span class="spanHeader">Department: </span>
            <?php
                echo "<select id='departmentName' name='departmentName'><option value=''>Select a Department</option>";
                while($row = mysql_fetch_assoc($resultDepartment)) {
                    echo "<option value = '" . $row['department_name'] . "|" . $row["dept_code"] . "'>" . $row["dept_code"] . " - " . $row['department_name'] . "</option>";   
                }
                echo "</select>";?>
            <input type='hidden' name='dept_code' style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Department Name Change: </span>
            <input type='text' name='change_department_name' class="input-xlarge">        

            <input type='text' name='current_department' class="input-xlarge"  style='background:#E9E9E9;' readonly>            <br/><br/>

            <!-- PERSONAL INFORMATION -->
            <h2>Location</h2>
            <span class="spanHeader">Convo Location: </span>
            <?php
                echo "<select id='convoLocation' class='input-xlarge' name='convoLocation'><option value=''>Select a Convo Location</option>";
                while($row = mysql_fetch_assoc($resultLocation)) {
                    echo "<option value = '" . $row['convo_location'] . "|" . $row['address'] . "|" . $row["city"] . "|" . $row["state"] . "|" . $row["zip_code"] . "|". $row["location_code"] . "'>" . $row["location_code"] . " - " . $row['convo_location'] . "</option>";   
                }
                echo "</select>";?>
            <input type='hidden' name='location_code' class="input-xlarge" style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Convo Location: </span>
            <input type='text' name='change_convoLocation' class="input-xlarge">
            <input type='text' name='current_convoLocation' class="input-xlarge"  style='background:#E9E9E9;' readonly>
            <br/><br/>

            <span class="spanHeader">Address: </span>
            <input type='text' name='address' class="input-xlarge">
            <input type='text' name='current_address' class="input-xlarge" style='background:#E9E9E9;' readonly><br/><br/>

            <span class="spanHeader">City: </span>
            <input type='text' name='city' class="input-xlarge">
            <input type='text' name='current_city' class="input-xlarge" style='background:#E9E9E9;' readonly><br/><br/>

            <span class="spanHeader">State: </span>
            <select name="state" class="input-medium">
                <?= create_option_list($states, "state") ?>
            </select>
            <input type='text' name='current_state' class="input-small" style='background:#E9E9E9;' readonly><br/><br/>  

            <span class="spanHeader">Zip Code: </span>
            <input type='text' name='zipCode' class="input-small" maxlength="5">
            <input type='text' name='current_zipCode' class="input-small" style='background:#E9E9E9;' readonly><br/><br/>       
            <br/>
            <input type="submit" id="updateButton" name="submit" value="Update">
        </form>
<?php
    include("../assets/inc/footer.inc.php");
?>