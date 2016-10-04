<nav id="primaryNav">
                <ul>    <!-- Main Navigation -->
<?php
    if(logged_in()) {
    if($user_data["emp_type"] == "O")
    {
    ?>
            <li><a href="<?php echo $linkToALL;?>/NEO/index.php">New Employee Onboarding</a></li>
<?php
    }
    else if($user_data["emp_type"] == "C"){
?>
    <li><a href="<?php echo $linkToALL;?>/index.php">Home</a></li>
    <li>
        <a href="#">HR</a>
        <ul class="HR">
            <li>
                <a href="<?php echo $linkToALL;?>/HR/employment_data.php">Employee Data</a>
            </li>
            <li>
                <a href="<?php echo $linkToALL;?>/HR/acknowledgements.php">Acknowledgements</a>
            </li>
        </ul>
    </li>
<?php      
    }   
    else
    {
?>
                    <li><a href="<?php echo $linkToALL;?>/index.php">Home</a></li>
                    <li>
                        <a href="#">HR</a>
                        <ul class="HR">
                            <li><a href="<?php echo $linkToALL;?>/HR/resources.php">Resources</a></li>
                            <li><a href="<?php echo $linkToALL;?>/HR/fmla.php">Family Medical Leave</a></li>
                            <li><a href="<?php echo $linkToALL;?>/HR/employment_data.php">Employee Data</a></li>
                            <li><a href="<?php echo $linkToALL;?>/HR/acknowledgements.php">Acknowledgements</a></li>
                        </ul>      
                    </li>
                    
                    <li>
                        <a href="#">Benefits</a>
                        <ul class="HR">
                        <?php
                            if((has_access_interpreting($user_data["job_code"]) == true) || (has_access_support($user_data["job_code"]) == true)){
                        ?>                          
                            <li><a href="<?php echo $linkToALL;?>/Benefits/overview.php">Overview</a></li> 
                        <?php
                            }
                            if($user_data["payroll_status"] != "GBS" || $user_data["job_code"] == "INT007"){
                        ?>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/401k.php">401(k)</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/medical.php">Medical</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/dental_vision.php">Dental/Vision</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/FSA.php">Flexible Spending Account</a></li>
                        <?php
                            }
                        ?>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/supplemental.php">Supplemental</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Benefits/EAP.php">Employee Assistance Program</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="#">Finance</a>
                        <ul class="finance_menu">
                            <li><a href="<?php echo $linkToALL;?>/Finance/travel_request.php">Travel Reimbursement Form </a></li>            
                            <li><a href="<?php echo $linkToALL;?>/Finance/finance.php">Travel &amp; Reimbursement Policy</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Finance/Travel_Request_Form.xlsx">Travel Request Form (Excel)</a></li>
                            <li><a href="<?php echo $linkToALL;?>/Finance/Reimbursement_Form.xlsx">Travel Reimbursement Form (Excel)</a></li>
                        </ul>      
                    </li>
                    
                    
                    <!--<li>
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
                    </li>-->
<?php
        if(has_access_manager($user_data["job_code"]) == true) {
?>
                    <li><a href="<?php echo $linkToALL;?>/employee.php">Employees</a></li>
<?php
            if(has_access($user_data["job_code"]) == true) {
                $query = "SELECT f.fmla_id FROM fmla_vw f JOIN employee_vw e ON e.employee_id = f.employee_id WHERE status = 'R'";
                if($result = mysqli_query($link, $query)) {
                    // Return the number of rows in result set
                    $row_count = mysqli_num_rows($result);
                }      
            }
            else {
                $query = "SELECT f.fmla_id FROM fmla_vw f JOIN employee_vw e ON e.employee_id = f.employee_id WHERE supervisor_id =" . $user_data["employee_id"] . " AND status = 'R'";
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
                        <a href="<?php echo $linkToALL;?>/Admin/index.php">Admin</a>
                    </li>
<?php
                                                        
        }
    }
}
?>
                </ul> <!-- Main Navigation // -->
            </nav>  <!-- Menu List Ends -->