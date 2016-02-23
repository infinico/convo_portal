<?php
    $page_title = "Resources";
    $title = "Convo Portal | Forms & Resources";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Forms &amp; Resources</h1>
            <br />
            <div id="colLeft">    <!-- column Left -->
                <!-- Employee Resources -->
                <h2>Employee Resources</h2>
                <ul class="resources">
                    <li><a href="Resources/2016%20payroll%20schedule.pdf" target="_blank">2016 Payroll Schedule</a></li>
                    <li><a href="OptInForMailedPaycheck.php">Check Stub Request</a></li>
                    <li><a href="Resources/PaychexRegistration.pdf" target="_blank">Paychex Registration</a></li>
                </ul><br/>
                <?php
                    // INTERPRETER RESOURCES
                    if(has_access_interpreting($user_data["job_code"]) == true || has_access($user_data["job_code"]) == true){
                ?>
                    <h2>Interpreting Resources</h2>
                    <ul class="resources">
                        <li><a href="Resources/InterpreterGuidelines.pdf" target="_blank">Interpreter Guidelines</a></li>
                    </ul><br/>
                <?php
                    }   
                    ?>
                
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
</div>

<?php
    include("../assets/inc/footer.inc.php");
?>