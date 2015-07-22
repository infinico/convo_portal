<!-- INDEX - ANNOUNCEMENT -->
    //echo $today . "<br/>";
/*
    $queryFutAnnouncement = "SELECT * FROM announcement_vw WHERE announcement_id = 2";
    $resultA = mysqli_query($link, $queryFutAnnouncement);
    $num_rows_viewA = mysqli_affected_rows($link);
    if($resultA && $num_rows_viewA > 0) {
    while($row = mysqli_fetch_assoc($resultA)){
        $content = $row["home_page"];
        $effective_date = $row["effective_date"];
    }
    }*/
    
    //$query = "CALL search_announcement(2, '$content', '$effective_date')";
    //echo $query;
    //mysqli_query($link, $query);

/*
    // Announcements to get values
    $queryAnnouncements = "SELECT * FROM announcement_vw where announcement_id = 2";
    $result = mysqli_query($link, $queryAnnouncements);
    $num_rows = mysqli_affected_rows($link);

    if($result && $num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)){
            $content = $row["home_page"];
            $effective_date = $row["effective_date"];
        }
    }


    if(logged_in() == true){
        //$query = "CALL search_announcement(1, '$content', '$effective_date')";
        mysql_query("CALL search_announcement(1, '$content', '$effective_date')");
        $query = "SELECT * FROM announcement_vw where announcement_id = 1";
        $result_content = mysqli_query($link, $query);
        $num_rows_content = mysqli_affected_rows($link);
        if($result_content && $num_rows_content > 0) {
           while($row = mysqli_fetch_assoc($result_content)) {
               echo $row["home_page"];
           }
        }
    }
    else {
        echo "<h2>Please login or <a href='register.php'>register</a> to access the Portal.</h2>";
    }
    */

/*    
//Anniversary for Employees !!!!
    $query = "SELECT firstname, lastname, hire_date, CONCAT(MONTH(hire_date), '/', DAY(hire_date)) AS hireDate FROM employer WHERE (employment_status = 'Active' OR employment_status = 'Leave') AND DATE_ADD(hire_date, INTERVAL YEAR(CURDATE())-YEAR(hire_date) YEAR) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 0 DAY) ORDER BY hireDate ASC";
    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);

    if($result && $num_rows > 0) {
        echo "<h1>Happy Anniversary to Employees who have been working</h1>";
        while($row = mysqli_fetch_assoc($result)){
            if((date("Y") - date($row["hire_date"])) == 1){
                echo $row["firstname"] . " " . $row["lastname"] . " " . (date("Y") - date($row["hire_date"])) . " year (" . $row["hireDate"] . ")<br/>";   
            }
            else if((date("Y") - date($row["hire_date"])) == 0){
                //doing nothing, just hide new employee   
            }
            else{
                echo $row["firstname"] . " " . $row["lastname"] . " " . (date("Y") - date($row["hire_date"])) . " years (" . $row["hireDate"] . ")<br/>";
            }
        }
    }

    echo "<br/><br/>";
    //Birthday for Employees !!!!
    $query2 = "SELECT firstname, lastname, CONCAT(MONTH(date_of_birth), '/', DAY(date_of_birth)) AS birthday FROM employer WHERE (employment_status = 'Active' OR employment_status = 'Leave') AND DATE_ADD(date_of_birth, INTERVAL YEAR(CURDATE())-YEAR(date_of_birth) YEAR) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 0 DAY) ORDER BY birthday ASC";
    $result2 = mysqli_query($link, $query2);
    $num_rows2 = mysqli_affected_rows($link);

    if($result2 && $num_rows2 > 0) {
        echo "<h1>Happy Birthday!</h1>";
        while($row = mysqli_fetch_assoc($result2)){
            echo $row["firstname"] . " " . $row["lastname"] . " - " . $row["birthday"] ."<br/>";    
        }
    }
*/


<!-- EDIT PHP -->
<span class="spanHeader">Department: </span>
            <?php
                echo "<select id='department' name='department'><option value=''>Select a Department</option>";
                while($row = mysql_fetch_assoc($resultDepartment)) {
                    echo "<option value = '" . $row['department_name'] . "'>" . $row['department_name'] . "</option>";   
                }
                echo "</select>";?>
        <input type='text' name='current_department' class="input-medium"  style='background:#E9E9E9;' readonly>            <br/><br/>
        
        
        <span class="spanHeader">Admin Privilege:</span>
            <select value="admin_privileges" name="admin_privileges" class="input-medium">
                <option value="">Select a privillege</option>
                <option value = "Admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Admin"){echo "selected='selected'";} ?>>Yes</option>
                <option value = "Non_admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Non_admin"){echo "selected='selected'";} ?>>No</option>
            </select> <input type='text' class="input-small" name='current_admin_privileges' style='background:#E9E9E9;' readonly><em> <strong>1:</strong> admin privileges and <strong>0:</strong> no admin privileges</em><br/><em class="note">Permission to add, edit, and terminate employees.</em><br/><br/>
                    
            <span class="spanHeader">Manager Privilege:</span>
            <select value="manager_privileges" name="manager_privileges" class="input-medium">
                <option value="">Select a privillege</option>
                <option value = "Manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Manager"){echo "selected='selected'";} ?>>Yes</option>
                <option value = "Non_manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Non_manager"){echo "selected='selected'";} ?>>No</option>
            </select> <input type='text' class="input-small" name='current_manager_privileges' style='background:#E9E9E9;' readonly><em> <strong>1:</strong> manager privileges and <strong>0:</strong> no manager privileges</em><br/><em class="note">Permission to view direct reports' information and materials that are restricted to managers.</em>

<!-- HIRE PHP -->

        if(empty($_POST["admin_privileges"])){
            $errorAdminPrivileges = "<span class='hireErrors'>Please select a privilege</span>";   
        }
        if(empty($_POST["manager_privileges"])){
            $errorManagerPrivileges = "<span class='hireErrors'>Please select a privilege</span>";   
        }
        <!-- Department -->
        <span class="spanHeader">Department: </span>
            <?php
                echo "<select id='department_name' name='department_name'><option value=''>Select a Department</option>";
                while($row = mysql_fetch_assoc($resultDepartment)) {
                    echo "<option value = '" . $row['department_name'] . "'";
                    if(isset($_POST["submit"]) && $_POST["department_name"] == $row['department_name']){
                        echo "selected='selected'";
                    }
                    echo ">" . $row['department_name'] . "</option>";   
                }
                echo "</select>";
                echo $errorDepartment; 
            ?>
        <br/><br/>

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

 <!-- Admin Privileges -->
        <span class="spanHeader">Admin Privilege:</span>
        <select value="admin_privileges" name="admin_privileges">
            <option value="">Select a privillege</option>
            <option value = "Admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Admin"){echo "selected='selected'";} ?>>Yes</option>
            <option value = "Non_admin" <?php if(isset($_POST["submit"]) && $_POST["admin_privileges"] == "Non_admin"){echo "selected='selected'";} ?> selected>No</option>
        </select><?php echo $errorAdminPrivileges; ?><br/><em class="note">Permission to add, edit, and terminate employees.</em><br/><br/>
               
        <!-- Manager Privileges -->
        <span class="spanHeader">Manager Privilege:</span>
        <select value="manager_privileges" name="manager_privileges">
            <option value="">Select a privillege</option>
            <option value = "Manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Manager"){echo "selected='selected'";} ?>>Yes</option>
            <option value = "Non_manager" <?php if(isset($_POST["submit"]) && $_POST["manager_privileges"] == "Non_manager"){echo "selected='selected'";} ?> selected>No</option>
        </select><?php echo $errorManagerPrivileges; ?><br/><em class="note">Permission to view direct reports' information and materials that are restricted to managers.</em><br/>

<!-- SCRIPT and SCRIPTFOOTER JS -->
    var department = $("#employeeName").val().split("|")[3];
    $("input[name='current_department']").val(department);
    $("select[name='department']").val(department);


$("input[name='current_admin_privileges']").val(admin_privileges);
    if($("input[name='current_admin_privileges']").val() == "1") {
      $("select[name='admin_privileges']").val("Admin");  
    }
    else {
        $("select[name='admin_privileges']").val("Non_admin"); 
    }


    $("input[name='current_manager_privileges']").val(manager_privileges);
    //$("select[name='manager_privileges']").val(manager_privileges);

    if($("input[name='current_manager_privileges']").val() == "1") {
      $("select[name='manager_privileges']").val("Manager");  
    }
    else {
        $("select[name='manager_privileges']").val("Non_manager"); 
    }

