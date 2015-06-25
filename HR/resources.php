<?php
    $title = "Convo Portal | Forms & Resources";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Forms &amp; Resources</h1>

            <div id="colLeft">    <!-- column Left -->
                <!-- Employee Resources -->
                <h2>Employee Resources</h2>
                <ul class="resources">
                    <li><a id="payrollButton" href="Resources/2015%20payroll%20schedule.pdf" target="_blank">2015 Payroll Schedule</a></li>
                </ul><br/>

<?php
    if(logged_in()) {
        // SUPERVISOR HANDBOOK and FMLA 
        if(has_access_manager($user_data["job_code"]) == true) {
       
?>
                <!-- Manager Resources -->
                <h2>Manager Resources</h2>
                <ul class="resources">
                    <li><a id = "handbookButton" href="Resources/Supervisor%20Handbook2013.pdf" target="_blank">Manager Guidelines</a></li>
                    <li><a id="FMLAButton" href="Resources/FMLA%20Terms%20and%20Request%20Form.pdf" target="_blank">FMLA Terms and Request Form</a></li>
                </ul><br/>

<?php
        }
        
        // CALL ATTENDANCE POLICY
        if(has_access_interpreting($user_data["job_code"]) == true || has_access($user_data["job_code"]) == true){
?>
                <!-- Interpreting Resources -->
                <h2>Interpreting Resources</h2>
                <ul class="resources">
                    <li><a id="attendanceButton" href="Resources/Call%20Center%20Attendance%20Policy.pdf" target="_blank">Call Center Attendance Policy</a></li>
                </ul><br/>
<?php
        }
        
        //CONVO SUPPORT
        if(has_access_support($user_data["job_code"]) == true || has_access($user_data["job_code"]) == true){
?>   
                <!-- Convo Support -->
                <h2>Convo Support</h2>

                <ul class="resources">
                    <li><a id="supportButton" href="Resources/Support%20Employee%20Categories.pdf" target="_blank">Support Employee Categories</a></li>
                </ul>
<?php
        }
        
    }
?>
            </div>  <!-- column Left // -->
            <div id="colRight">   <!-- column Right -->
                <h2>Tax Forms</h2>
                <ul class="resources">
                    <li><a href="http://www.irs.gov/pub/irs-pdf/fw4.pdf" target="_blank">Federal Form W-4</a></li>
<?php
    if($user_data["res_state"] == "AL" || has_access($user_data["job_code"]) == true){
?>
                    <li><a href="http://revenue.alabama.gov/incometax/itformsindex.cfm" target="_blank">Alabama State Tax Forms</a></li>
<?php
    }
    if($user_data["res_state"] == "CA" || has_access($user_data["job_code"]) == true){
?>
                    <li><a href="https://www.ftb.ca.gov/forms/search/index.aspx" target="_blank">California State Tax Forms</a></li>
<?php
    }
    if($user_data["res_state"] == "IN" || $user_data["res_state"] == "OH" || has_access($user_data["job_code"]) == true){
?>
                    <li><a href="http://www.in.gov/dor/3489.htm" target="_blank">Indiana State Tax Forms</a></li>
<?php
    }
    if($user_data["res_state"] == "NY" || has_access($user_data["job_code"]) == true){
?>
                    <li><a href="http://www.tax.ny.gov/forms/" target="_blank">New York State Tax Forms</a></li>
<?php
    }
?>
                </ul>
            </div>  <!-- column Right //-->
<?php
    include("../assets/inc/footer.inc.php");
?>