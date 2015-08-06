<?php 
    $page_title = "Contact Us";
    $title = "Convo Portal";
    require_once "includes/phpmailer/vendor/autoload.php";
    require("includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("core/init.php");
    include("assets/inc/header.inc.php");

$emailStatus = $errorMessage = $errorEmail = $errorFN = $errorLN = $errorSubject = "";
if(isset($_POST["submitContact"])){
    if(empty($_POST["firstname"])){
        $errorFN = "<span class='error'>Please enter your first name</span>";
        
    }
    if(empty($_POST["lastname"])){
        $errorLN = "<span class='error'>Please enter your last name</span>"; 
        
    }
    if(empty($_POST["email"])){
        $errorEmail = "<span class='error'> Please enter your email</span>";
        
    }
    else if(!preg_match("/^([0-9a-zA-Z]+[-._+&amp;])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$/", $_POST["email"])){
        $errorEmail = "<span class='error'>Please enter email. ex: example@gmail.com</span>";
        
    }
    if(empty($_POST["message"])){
        $errorMessage = "<span class='error'>Please enter the message</span>";   
        
    }
    
    if(empty($_POST["subject"])){
        $errorSubject = "<span class='error'>Please select a subject</span>";  
        
    }

    // Send to the employees using automatic email saying Thank you and we will reply you soon as possible
    if($errorFN == "" && $errorLN == "" && $errorEmail == "" && $errorMessage == "" && $errorSubject == ""){
        newEmail($_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["subject"], $_POST["message"]);
        
        echo "<h2 class='headerPages'>Your mail was sent successfully.</h2>"; 
        die();
        
    }
}

?>

            <br/><br/><br/><br/>
            <div class="contact">   <!-- Contact -->
                <div class="container"> <!-- Container -->
                    <form class="well span8" method="POST">
                        <div class="row">   <!-- Row -->
                            <div class="span3"> <!-- Span3 -->
                                <label>First Name</label><?php if(isset($_POST["submitContact"])){ echo $errorFN;} ?>
                                <input class="span3" name="firstname" placeholder= "Your First Name" type="text" value='<?php if(logged_in() == true && $user_data["firstname"] != NULL){echo $user_data['firstname'];}?>'>

                                <label>Last Name</label><?php if(isset($_POST["submitContact"])){ echo $errorLN;} ?>
                                <input class="span3" name="lastname" placeholder="Your Last Name" type="text" value='<?php if(logged_in() == true && $user_data["lastname"] != NULL){echo $user_data['lastname'];}?>'>

                                <label>Email Address</label><?php if(isset($_POST["submitContact"])){ echo $errorEmail;} ?>
                                <input class="span3" name="email" placeholder="Your email address" type="text" value='<?php if(logged_in() == true && $user_data["email"] != NULL){echo $user_data['email'];}?>'>

                                <label>Subject</label><?php if(isset($_POST["submitContact"])){ echo $errorSubject;} ?>
                                <select class="span3" id="subject" name="subject">
                                    <option value="">Choose One:</option>
                                    <option value="login">Login</option>
                                    <option value="Questions">Questions/Concerns</option>
                                    <option value="suggestions">Suggestions</option>
                                    <option value="none">Other</option>
                                </select>
                            </div>  <!-- Span3 //-->
                            <div class="span5"> <!-- Span5 -->
                                <label>Message</label><?php if(isset($_POST["submitContact"])){ echo $errorMessage;} ?>
                                <textarea class="input-xlarge span5" id="message" name="message" rows="10"></textarea>
                            </div>  <!-- Span5 // -->

                            <input type="submit" name="submitContact" class="btn btn-primary pull-right" value="Send" />
                        </div>  <!-- Row // -->
                    </form>
                </div>  <!-- class Container ends -->
            </div>  <!-- Contact ends -->
            <div class="contact_info">  <!-- Contact Info -->
                <h2>Contact Us</h2>
                <hr/>
                <address>
                    <strong>Convo HR</strong><br>
                    <a href="mailto:HR@convorelay.com">HR@convorelay.com</a>
                </address>
            </div>  <!-- Contact Info // -->
<?php
    include("assets/inc/footer.inc.php");
?>
