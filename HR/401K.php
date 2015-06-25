<?php
    $title = "Convo Portal | 401K";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">401(k) Savings &amp; Investment Plan</h1>

            <h2>Overview</h2>

            <p>Part-time and full-time employees are eligible to participate in the 401(k) Plan as long as they are over 21 years old.</p>

<?php
    $age = $user_data["date_of_birth"];
    if($user_data["payroll_status"] == "FT" || $user_data["payroll_status"] == "PT"){
        if((date("Y") - date("Y", strtotime($user_data["date_of_birth"]))) < 21){
            echo "<p class='not_eligible'>Our records show that you are under 21 years of age. You will become eligible for participation in the 401(k) Plan after you turn 21.</p>";
        }
        else{
            echo "<p class='eligible'>You are eligible for participation in the 401(k) Plan.</p>";
        }
    }
    else{
        echo "<p class='not_eligible'>You are not eligible for participation in the 401(k) Plan until you are employed as full-time or part-time.</p>";
    }


?>

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