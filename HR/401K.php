<?php
    $page_title = "401K";
    $title = "Convo Portal | 401K";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">401(k)</h1>

            <p>Your 401(k) plan is provided by Kramer Financial Services. You can enroll in the 401(k) plan or make changes to: your salary contribution, fund selections, and transfers, or simply view your account balance via Paychex. If you have not registered for an account with Paychex, go to <a href="http://www.paychex.com/login/" target="_blank">http://www.paychex.com/login/</a> and register for Paychex Flex.</p> 

            <h2>Convo 401(k) Savings and Investment Plan Links</h2>
            <ul class='resources'>
                <li><a href="<?php echo $linkToALL; ?>/HR/401K/401kPlanDescription.pdf" target="_blank">401(k) Plan Description and Enrollment</a></li>
                <li><a href="<?php echo $linkToALL; ?>/HR/401K/EmployeeFAQ.pdf" target="_blank">Employee Frequently Asked Questions</a></li>
            </ul>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/IVHUjTSntDI" frameborder="0" allowfullscreen style="margin-left: 200px; margin-top: 10px;"></iframe>
<?php
    include("../assets/inc/footer.inc.php");
?>