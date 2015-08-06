            <nav id="primaryNav">
                <ul>    <!-- Main Navigation -->
                    <li><a href="<?php echo $linkToALL;?>/index.php">Home</a></li>
<?php
    if(logged_in()) {
?>
                    <li>
                        <a href="#">HR</a>
                        <ul class="HR">
                            <li><a href="<?php echo $linkToALL;?>/HR/resources.php">Resources</a></li>
                            <li><a href="<?php echo $linkToALL;?>/HR/fmla.php">FMLA</a></li>
                            <li><a href="<?php echo $linkToALL;?>/HR/employment_data.php">Employment Data</a></li>
<?php
    //}
    // Only full-time employees can see Open Enrollment
    // Exception is Monique Clark (emplid 229) who is considering full time and wants to check benefits before deciding
    // Tabitha Poplin (emplid 274)
    // Jonathan Plaxco (emplid 327)
    if($user_data["payroll_status"] == "FT" || $session_user_id == '229' ||  $session_user_id == '274' || $session_user_id == '327' ){

?>
                             <!--<li><a href="<?php echo $linkToALL;?>/HR/OpenEnrollment.php">Open Enrollment</a></li>-->   
<?php
    }
?>
                        </ul>      
                    </li>
                    
<?php
    if(has_access($user_data["job_code"]) == true || has_access_manager($user_data["job_code"]) == true || $user_data["payroll_status"] != "GBS" || $user_data["job_code"] == "INT007"){
?>
                    <li>
                        <a href="#">Benefits</a>
                        <ul class="benefits_menu">
                            <li><a href="<?php echo $linkToALL;?>/Benefits/401k.php">401(k)</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/medical.php">Medical</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/dental_vision.php">Dental/Vision</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/supplemental_life.php">Supplemental Life</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/HealthBenefits.php">Health Benefits Example</a></li>
                        </ul>
                    </li>
                    
<?php
    }
?>
                    <li>
                        <a href="#">Experts</a>
                        <ul class="experts_menu">
                            <li><a href="<?php echo $linkToALL;?>/Experts/index.php">Home</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Experts/experts_team.php">Meet Expert Team</a></li>
                            <li class="children">
                                <a href="#">Toolbox</a>
                                <ul class="subMenu">
                                    <li><a href="#">Expert Tools</a></li>
                                    <li><a href="<?php echo $linkToALL;?>/Experts/color_your_home.php">Color Your Home 2.0</a></li>
                                    <li><a href="#">Procedures &amp; Features</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo $linkToALL;?>/Experts/badges.php">Badges</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Experts/event_calendar.php">Events</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Convo University</a>
                        <ul class="convo_university_menu">
                            <li><a href="<?php echo $linkToALL;?>/Convo University/index.php">Home</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Convo University/module.php">Module 1</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Convo University/log.php">Employee Log</a></li>
                        </ul>
                    </li>
                    

<?php
        if(has_access_census($user_data["job_code"]) == true){
?>
                    <!--<li><a href="census.php">Census</a></li>-->
<?php
        }
        if(has_access_manager($user_data["job_code"]) == true) {
?>
                    <li><a href="<?php echo $linkToALL;?>/employee.php">Employees</a></li>
<?php
            if(has_access($user_data["job_code"]) == true) {
                $query = "SELECT f.fmla_id FROM fmla f JOIN employee e ON e.employee_id = f.employee_id WHERE status = 'R'";
                if($result = mysqli_query($link, $query)) {
                    // Return the number of rows in result set
                    $row_count = mysqli_num_rows($result);
                }      
            }
            else {
                $query = "SELECT f.fmla_id FROM fmla f JOIN employee e ON e.employee_id = f.employee_id WHERE supervisor_id =" . $user_data["employee_id"] . " AND status = 'R'";
                if($result = mysqli_query($link, $query)) {
                    // Return the number of rows in result set
                    $row_count = mysqli_num_rows($result);
                }
            }
?>
                    <li><a href="<?php echo $linkToALL;?>/Approval%20Center/index.php">Approval Center (<?php echo $row_count; ?>)</a></li>
<?php
        }
        if(has_access($user_data["job_code"]) == true) {
?>
                    <li>
                        <a href="#">Admin</a>
                        <ul class="admin_menu">
                            <li><a href="<?php echo $linkToALL;?>/Admin/hire.php">Add Employee</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/edit.php">Edit Employee</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/createdatabase.php">Add DB Values</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/editdatabase.php">Edit DB Values</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/announcements.php">Announcements</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/files_uploaded.php">Files Uploaded</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Admin/dashboard.php">Dashboard</a></li>
                        </ul>
                    </li>
<?php
        }
    }
?>
                </ul> <!-- Main Navigation // -->
            </nav>  <!-- Menu List Ends -->