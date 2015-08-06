<?php 
    $page_title = "New Employee Onboarding";
    $title = "New Employee Onboarding";
    require_once "includes/phpmailer/vendor/autoload.php";
    require("includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("core/init.php");
    include("assets/inc/header.inc.php");
    include("includes/includes_functions.php");

    $errorFirst = $errorLast = $errorCity = $errorState = $errorStreetAddress = $errorZipCode = $errorDOB = $errorEmail = $errorEmergencyName = $errorEmergencyNumber = $errorFiles = "";

    $fileDL = $fileSSN = "";


    if(isset($_POST["submitNewHire"])){
        if(empty($_POST["firstname"])) {
            $errorFirst = "<span class='error'>Please enter first name</span>";
        }
        if(empty($_POST["lastname"])) {
            $errorLast = "<span class='error'>Please enter last name</span>";  
        }
        if(empty($_POST["res_state"])) {
            $errorState = "<span class='error'>Please pick resident state</span>";  
        }
        if(empty($_POST["street_address"])){
            $errorStreetAddress = "<span class='error'>Please enter street address</span>";   
        }
        if(empty($_POST["city"])){
            $errorCity = "<span class='error'>Please enter city</span>";   
        }
        if(empty($_POST["zipcode"])){
            $errorZipCode = "<span class='error'>Please enter zip code</span>";   
        }
        else if(is_numeric($_POST["zipcode"]) == false){
            $errorZipCode = "<span class='error'>Please enter in number onl.</span>";
        }
        if(empty($_POST["dob"])){
            $errorDOB = "<span class='error'>Please enter date of birth</span>";     
        }
        if(empty($_POST["email"])) {
            $errorEmail = "<span class='error'> Please enter email address</span>"; 
        }
        if(empty($_POST["emergencyName"])) {
            $errorEmergencyName = "<span class='error'> Please enter contact's name</span>"; 
        }
        if(empty($_POST["emergencyNumber"])) {
            $errorEmergencyNumber = "<span class='error'> Please enter contact's phone number</span>"; 
        }
        if(empty($_FILES["fileDL"]["name"]) && empty($_FILES["fileSSN"]["name"])){
            $errorFiles = "<span class='error'>Please upload both your driver license and Social Security card.</span>";   
        }
        if($errorFirst == "" &&  $errorLast == "" && $errorState == "" && $errorStreetAddress == "" && $errorCity == "" && $errorZipCode == "" && $errorDOB == "" && $errorEmail == "" && $errorEmergencyName == "" && $errorEmergencyNumber == "" && $errorFiles == "") {
                $firstname = sanitize($_POST["firstname"]);
                $lastname = sanitize($_POST["lastname"]);
                $state = sanitize($_POST["res_state"]);
                $street_address = sanitize($_POST["street_address"]);
                $city = sanitize($_POST["city"]);
                $zipcode = sanitize($_POST["zipcode"]);
                $dob = sanitize($_POST["dob"]);
                $email = sanitize($_POST["email"]);
                $emergencyName = sanitize($_POST["emergencyName"]);
                $emergencyNumber = sanitize($_POST["emergencyNumber"]);
                $fileDL = $_FILES["fileDL"];
                $fileSSN = $_FILES["fileSSN"];
                            

                $dobInput = multiexplode(array("-", "/"), $dob);
                $date_of_birth = $dobInput[2] . "-" . $dobInput[0] . "-" . $dobInput[1];


                $hire_emp_info = "<strong>Name:</strong> " . $firstname . " " . $lastname . "<br/>";
                $hire_emp_info .= "<strong>Address:</strong> " . $street_address . ", " . $city . ", " . $state . " " . $zipcode . "<br/>";
                $hire_emp_info .= "<strong>Date of Birth:</strong> " . $dob . "<br/>";
                $hire_emp_info .= "<strong>E-mail Address:</strong> " . $email . "<br/>";
                $hire_emp_info .= "<h3>Emergency Contact Information</h3>";
                $hire_emp_info .= "<strong>Contact's Name:</strong> " . $emergencyName . "<br/>";
                $hire_emp_info .= "<strong>Contact's Phone Number:</strong> " . $emergencyNumber . "<br/>";
              //  $hire_emp_info .= "Read the link for more information: " . $linkToALL . "/Convo%20New%20Hire%20Packet%20-%20FT.pdf";

                mysqli_query($link, "CALL insert_new_hire('$firstname', '$lastname', '$street_address', '$city', '$state', '$zipcode', '$date_of_birth', '$email', '$emergencyName', '$emergencyNumber', CURRENT_TIMESTAMP);");

                //newEmail($email, $firstname, $lastname, 'New Employee Onboarding', $hire_emp_info);

                file_attachment($email, $firstname, $lastname, $state, $fileDL, $fileSSN);
                ?>
                <script>
                    $("#primaryNav").hide();
                    $("aside").hide(); 
                    $("#convoLogo a").removeAttr("href");
                </script>
<?php
                echo "<h2 class='headerPages'><br/><br/><br/>Thank you for your submission. We will contact you after your background check is cleared. Please contact <a href='mailto:hr@convorelay.com'>hr@convorelay.com</a> with any questions.</h2>";
                die(); 
            }

    }
?>

   
            <script>
                $("#primaryNav").hide();
                $("aside").hide(); 
                $("#convoLogo a").removeAttr("href");
            </script>
            <br/><br/><br/>
            <h2 class="headerPages">Welcome to Convo! Please fill out all the fields below. We also need copies of your driver license and Social Security card for your background check. Please have these ready to be uploaded.</h2>

            <form id="form" action="<?php $location = $_SERVER['PHP_SELF']; echo ''.$location.'#form';?>" method="post" enctype="multipart/form-data">
                <h2>Personal Information</h2>

                <!-- First Name -->
                <span class="spanHeader">First Name: </span>
                <input type="text" id="firstname" name="firstname" size="10" placeholder="First Name" value=<?php if(isset($_POST["submitNewHire"])){echo $_POST['firstname'];} ?>>
                <?php echo $errorFirst; ?><br/><br/>

                <!-- Last Name -->
                <span class="spanHeader">Last Name: </span>
                <input type="text" id="lastname" name="lastname" size="10" placeholder="Last Name" value=<?php if(isset($_POST["submitNewHire"])){echo $_POST['lastname'];} ?>>
                <?php echo $errorLast; ?><br/><br/>

                <!-- Street Address-->
                <span class="spanHeader">Street Address: </span>
                <input type="text" id="street_address" class="input-xlarge" name="street_address" placeholder="Street Address" value=<?php if(isset($_POST["submitNewHire"])){echo "'" . $_POST['street_address'] . "'";} ?>>
                <?php echo $errorStreetAddress; ?><br/><br/>

                <!-- City -->
                <span class="spanHeader">City: </span>
                <input type="text" id="city" name="city" placeholder="City" value=<?php if(isset($_POST["submitNewHire"])){echo "'" .  $_POST['city'] . "'"; } ?>>
                <?php echo $errorCity; ?><br/><br/>

                <!-- Resident State -->
                <span class="spanHeader">Resident State: </span>
                <select name="res_state" class="input-medium">
                    <?= create_option_list($states, "state") ?>
                </select>
                <?php echo $errorState; ?><br/><br/>

                <!-- Zip Code -->
                <span class="spanHeader">Zip Code: </span>
                <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" maxlength="9" value=<?php if(isset($_POST["submitNewHire"])){echo $_POST['zipcode'];} ?>>
                <?php echo $errorZipCode; ?><br/><br/>

                <!-- Date of Birth -->
                <span class="spanHeader">Date of Birth:</span>
                <input type="text" placeholder="MM/DD/YYYY" name="dob" value=<?php if(isset($_POST["submitNewHire"])){echo $_POST['dob'];} ?>>
                <?php echo $errorDOB; ?><br/><em class="note">MM/DD/YYYY</em><br/><br/>
                
                <!-- Email Address -->
                <span class="spanHeader">E-mail address:</span>
                <input type="text" class="input-large" name="email" value=<?php if(isset($_POST["submitNewHire"])){echo $_POST['email'];} ?>>
                <?php echo $errorEmail; ?><br/><br/>

                <h2>Emergency Contact Information</h2>
                <!-- Emergency Name -->
                <span class="spanHeader">Contact's Name:</span>
                <input type="text" class="input-large" name="emergencyName" value=<?php if(isset($_POST["submitNewHire"])){echo "'" . $_POST['emergencyName'] . "'";} ?>>
                <?php echo $errorEmergencyName; ?><br/><br/>

                <!-- Emergency Phone number -->
                <span class="spanHeader">Contact's Phone Number:</span>
                <input type="text" name="emergencyNumber" value=<?php if(isset($_POST["submitNewHire"])){echo "'" . $_POST['emergencyNumber'] . "'";} ?>>
                <?php echo $errorEmergencyNumber; ?><br/><br/>
                
                <?php echo $errorFiles; ?>
                <p>Upload Driver License: <input type="file" id="fileDL" name="fileDL"/> </p>
                <p>Upload Social Security Card: <input type="file" id="fileSSN" name="fileSSN"/> </p>

                <!-- Background Check Consent -->
                <h2>Background Check Consent</h2>
                <p>I understand that Convo will engage a private company to verify the following information in connection with my application with Convo:</p>
                <ul class="background_check_consent">
                    <li>Accuracy of personal information - name and address</li>
                    <li>Accuracy of work history</li>
                    <li>Any prior criminal record history</li>
                    <li>Legal permission to work in the United States</li>
                    <li>License/certification still in good standing</li>
                </ul>
                <p>I certify that the information that I have provided or will provide on my resume and new hire paperwork are complete and accurate in every respect.  I understand that a false statement or omission of facts therein may result in my subsequent dismissal for cause.  I understand that my authorization below serves as my written consent to a background check.  A copy of the background check report may be requested.</p>

                <input type="checkbox" id="background_check_consent_cb" value="bg_check_consent_cb"><span class="background_span">I authorize Convo to run a background check prior to employment.  I understand I will need to provide Convo with copies of my Social Security card and driver's license or state-issued ID as soon as possible.</span><br/><br/>
                <input type="submit" id="submit_button_disabled" name="submitNewHire" value="Submit" disabled/>
            </form>
<?php
    include("assets/inc/footer.inc.php"); 
?>
