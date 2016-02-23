<?php 
    $page_title = "Check Stub Request";
    $title = "Check Stub Request";

    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");

    include("../includes/includes_functions.php");
    include("../assets/inc/header.inc.php");
?>
<h2 class="headerPages">Check Stub Request</h2>
<?php
    if(isset($_POST["submitOnboarding"]))
    {

        echo "Thank you for your submission. Your request has been emailed to HR, and if your email address is valid, you should receive a copy of this email.";
        
        sendCheckOptInEmail($user_data['firstname'], $user_data['lastname'], $user_data['email']);
                
        die();
    }   
?>
<form id="form" action="<?php $location = $_SERVER['PHP_SELF']; echo ''.$location.'';?>" method="post" enctype="multipart/form-data">

<input type="checkbox" id="background_check_consent_cb" value="bg_check_consent_cb">&nbsp;&nbsp;I would like to continue receiving a hard copy of my bi-weekly check stub.<br/><br/>               

    <input type="hidden" name="action" value="Submit"/> <input type="submit" id="submit_button_disabled" name="submitOnboarding" value="Submit"/>        
                
</form>
<?php
    include("../assets/inc/footer.inc.php"); 
?>