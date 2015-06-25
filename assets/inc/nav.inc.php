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
    // Only full-time and part-time employees can see 401(k)
    //if($user_data["payroll_status"] != "GBS"){

?>
                             <li><a href="<?php echo $linkToALL;?>/HR/401k.php">401(k)</a></li>                          
<?php
    //}
    // Only full-time employees can see Open Enrollment
    // Exception is Monique Clark (emplid 229) who is considering full time and wants to check benefits before deciding
    // Tabitha Poplin (emplid 274)
    // Jonathan Plaxco (emplid 327)
    if($user_data["payroll_status"] == "FT" || $session_user_id == '229' ||  $session_user_id == '274' || $session_user_id == '327' ){

?>
                             <li><a href="<?php echo $linkToALL;?>/HR/OpenEnrollment.php">Open Enrollment</a></li>   
<?php
    }
?>
                        </ul>      
                    </li>
                    <li >
                        <a href="#">Experts</a>
                        <ul class="subMenu">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Heart of Convo Expert</a></li>
                            <li><a href="#">Milestones</a></li>
                            <li class="children">
                                <a href="#">Toolbox</a>
                                <ul class="subMenu">
                                    <li><a href="#">Expert Tools</a></li>
                                    <li><a href="#">Color Your Home</a></li>
                                    <li><a href="#">Procedures &amp; Features</a></li>
                                </ul>
                            </li>
                            <li class="children">
                                <a href="#">Badge System</a>
                                <ul>
                                    <li><a href="#">Convo Expert</a></li>
                                    <li><a href="#">Local Expert</a></li>
                                    <li><a href="#">National Expert</a></li>
                                    <li><a href="#">Support Expert</a></li>
                                    <li><a href="#">Top Expert</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Convo University</a>
                        <ul class="convo_university">
                            <li><a href="<?php echo $linkToALL;?>/ConvoU/index.php">Home</a></li>
                            <li><a href="<?php echo $linkToALL;?>/ConvoU/module.php">Module 1</a></li>
                            <li><a href="<?php echo $linkToALL;?>/ConvoU/log.php">Employee Log</a></li>
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
        }
        if(has_access($user_data["job_code"]) == true) {
?>
                    <li>
                        <a href="#">Admin</a>
                        <ul>
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