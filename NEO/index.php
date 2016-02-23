<?php 
    $page_title = "New Employee Onboarding Review";
    $title = "New Employee Onboarding Review";


    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");

    include("../includes/includes_functions.php");
    include("../assets/inc/header.inc.php");

    $endProgramBooleanFlag = "N";
    $errorUploadDL = $errorUploadSSN = $file_name_new_dl = $file_name_new_ssn = "";

if(isset($_POST["submitOnboarding"])){

    $firstname = sanitize($_POST["firstname"]);
    $lastname = sanitize($_POST["lastname"]);
}
    $extensions = array("pdf", "doc", "jpg", "jpeg", "bmp", "gif", "png", "svg");

    // Driver's License Upload
    if(isset($_FILES["fileDL"])){

        $file = $_FILES["fileDL"];
        
        //print_r($file);
        
        $notAllowed = $errorSize = "";
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
       
        $file_ext=explode('.',$file_name);
        //$file_ext=end($file_ext);

        $file_ext=strtolower(end($file_ext));
        //echo $file_ext;
        
       
        if(in_array($file_ext,$extensions) == true){

           //$notAllowed="Please upload PDF file.";
            if($file_error == 0){
                if($file_size < 4200000){
                    $file_name_new_dl = $user_data["lastname"] . ' ' . $user_data["firstname"] . ' DL.' . $file_ext;

                    $file_destination_dl = $root . '/convo/Admin/upload_oe/' . $file_name_new_dl;
                    
                    if(move_uploaded_file($file_tmp, $file_destination_dl)){
                        $endProgramBooleanFlag = "Y";
                        //die();
                    }
                    else{
                        echo "not uploaded";   
                    }
                
                }
                else{
                    echo "The file size must be less than 4MB";   
                }
            }
        } 
        /* ELSE STATEMENT - FILE TYPE CANNOT BE UPLOADED*/
        else if ($file_ext != ""){
            
            $errorUploadDL = "<span class='error'>This file type cannot be uploaded</span>";
        }
    }

    // SS CARD Upload
    if(isset($_FILES["fileSSN"])){
        
        $file = $_FILES["fileSSN"];
        
        //print_r($file);
        $notAllowed = $errorSize = "";
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
       
        

        $file_ext=explode('.',$file_name);
        //$file_ext=end($file_ext);

        $file_ext=strtolower(end($file_ext));
        //echo $file_ext;
        
        
        if(in_array($file_ext,$extensions) == true){
            
             $endProgramBooleanFlag = "N";
           //$notAllowed="Please upload PDF file.";
            if($file_error == 0){
                if($file_size < 4200000){

                    $file_name_new_ssn = $user_data["lastname"] .  ' ' . $user_data["firstname"] . ' SS card.' . $file_ext;
                    
                    $file_destination_ssn = $root . '/convo/Admin/upload_oe/' . $file_name_new_ssn;
                    
                    if(move_uploaded_file($file_tmp, $file_destination_ssn)){
                        $endProgramBooleanFlag = "Y";
                        //die();
                    }
                    else{
                        echo "not uploaded";   
                    }
                
                }
                else{
                    echo "The file size must be less than 4MB";   
                }
            }
        }
        /* ELSE STATEMENT - FILE TYPE CANNOT BE UPLOADED*/
        else if ($file_ext != ""){
            
            $errorUploadSSN = "<span class='error'>This file type cannot be uploaded</span>";
        }
    }

    $errorFirst = $errorLast = $errorCity = $errorState = $errorStreetAddress = $errorZipCode = $errorEmail = $errorFiles =  "";
    $fileDL = $fileSSN = "";


    if(isset($_POST["submitOnboarding"])){
        
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
            $errorZipCode = "<span class='error'>Please enter numbers only for zip code.</span>";
        }
        if(empty($_POST["email"])) {
            $errorEmail = "<span class='error'> Please enter email address</span>"; 
        }
        if(empty($_FILES["fileDL"]["name"]) && empty($_FILES["fileSSN"]["name"])){
            $errorFiles = "<span class='error'>Please upload both your Driver's License/State ID and Social Security card.</span><br/>";   
        }   

        if($errorFirst == "" &&  $errorLast == "" && $errorState == "" && $errorStreetAddress == "" && $errorCity == "" && $errorZipCode == "" && $errorEmail == "" && $errorFiles == "" && $errorUploadDL == "" && $errorUploadSSN == "") {
                $employeeID = $user_data["employee_id"];

                $state = sanitize($_POST["res_state"]);
                $street_address = sanitize($_POST["street_address"]);
                $city = sanitize($_POST["city"]);
                $zipcode = sanitize($_POST["zipcode"]);
                $email = sanitize($_POST["email"]);
      
                //$fileDL = $_FILES["fileDL"];
                //$fileSSN = $_FILES["fileSSN"];


                //mysqli_query($link, "CALL insert_new_hire('$firstname', '$lastname', '$street_address', '$city', '$state', '$zipcode', '$email', '$emergencyName', '$emergencyNumber', CURRENT_TIMESTAMP);"); 

               
            mysqli_query($link, "CALL update_onboarding_hire('$employeeID', '$firstname', '$lastname', '$street_address', '$city', '$state', '$zipcode', '$email')");
            
            
            echo "<h2 class='headerPages'>Thank you for uploading your files!<br/><br/>
         
         While waiting for your background check to clear, please download and fill out the following forms:<br/><br/> 
         <a href='http://www.irs.gov/pub/irs-pdf/fw4.pdf' target='_blank'>Federal Form W-4</a><br>
         <a href='http://www.uscis.gov/sites/default/files/files/form/i-9.pdf' target='_blank'> I-9 Form </a><br/>";
                        
            if($state == "NY"){
              echo "<a href='https://www.tax.ny.gov/forms/' target='_blank'>New York State Tax Form </a> ";    
            }

            else if($state == "AL"){
                echo "<a href='http://revenue.alabama.gov/incometax/itformsindex.cfm' target='_blank'>Alabama State Tax Form </a> ";    
            }

            else if($state == "CA"){
                echo "<a href='https://www.ftb.ca.gov/forms/search/index.aspx' target='_blank'>California State Tax Form </a> ";    
            }

            else if($state == "IN"){
                echo "<a href='http://www.in.gov/dor/3489.htm' target='_blank'>Indiana State Tax Form </a> ";    
            }


            echo "<br>Return these forms to <a href='mailto:hr@convorelay.com'>hr@convorelay.com</a> at your earliest convenience.</h2>";
            

            if($endProgramBooleanFlag == "Y"){
                
                $fileDLOnPortal = $fileSSNOnPortal = "";
                
                if ($file_name_new_dl != "")
                {
                    $fileDLOnPortal = $linkToALL . '/Admin/upload_oe/' . $file_name_new_dl;
                }
 
                if ($file_name_new_ssn != "")
                {
                    $fileSSNOnPortal = $linkToALL . '/Admin/upload_oe/' . $file_name_new_ssn;
                }
                
                fileUploaded($firstname, $lastname, $fileDLOnPortal, $fileSSNOnPortal);
                
                die();
            } 
         }
    }
?>

   

            
            <h2 class="headerPages">Welcome to Convo! Please review all the fields below. We also need copies of your Driver's License/State ID and Social Security card for your background check. Please have these ready to be uploaded.</h2>
            <br/>


            <form id="form" action="<?php $location = $_SERVER['PHP_SELF']; echo ''.$location.'';?>" method="post" enctype="multipart/form-data">
                <h2>Personal Information</h2>

                <!-- First Name -->
                <span class="spanHeader">First Name: </span>
                <input type="text" id="firstname" name="firstname" size="10" placeholder="First Name" value="<?php echo $user_data["firstname"]; ?>">
                <?php echo $errorFirst; ?><br/><br/>

                <!-- Last Name -->
                <span class="spanHeader">Last Name: </span>
                <input type="text" id="lastname" name="lastname" size="10" placeholder="Last Name" value="<?php echo $user_data["lastname"]; ?>">
                <?php echo $errorLast; ?><br/><br/>

                <!-- Street Address-->
                <span class="spanHeader">Street Address: </span>
                <input type="text" id="street_address" class="input-xlarge" name="street_address" placeholder="Street Address" value="<?php echo $user_data["street_address"]; ?>">
                <?php echo $errorStreetAddress; ?><br/><br/>

                <!-- City -->
                <span class="spanHeader">City: </span>
                <input type="text" id="city" name="city" placeholder="City" value="<?php echo $user_data["city"];  ?>">
                <?php echo $errorCity; ?><br/><br/>

                <!-- Resident State -->
                <span class="spanHeader">Resident State: </span>
                <select name="res_state" class="input-medium">
                    <?= set_option_list($states, "state", $user_data["res_state"] ) ?>
                    
                </select>
                
                <?php echo $errorState; ?><br/><br/>

                <!-- Zip Code -->
                <span class="spanHeader">Zip Code: </span>
                <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" maxlength="9" value="<?php echo $user_data["zipcode"] ?>">
                <?php echo $errorZipCode; ?><br/><br/>
                
                <!-- Email Address -->
                <span class="spanHeader">E-mail address:</span>
                <input type="text" class="input-large" name="email" placeholder="Email Address" value="<?php echo $user_data["email"]; ?>">
                <?php echo $errorEmail; ?><br/><br/><br/>

                
                <?php echo $errorFiles; ?>
            
                
                <!-- Files to Upload -->
                
    
                <span class="spanHeader">Driver's License/State ID:</span>
                <!--?php echo $errorUploadDL; ?> -->
                <input type="file" id="fileDL" name="fileDL"/><br/><br/>
                
                <span class="spanHeader">Social Security card:</span>
                <?php echo $errorUploadSSN; ?> 
                <input type="file" id="fileSSN" name="fileSSN"/><br/>                
                
                
                <!-- Background Check Consent -->
                <br/>
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

                <input type="checkbox" id="background_check_consent_cb" value="bg_check_consent_cb"><span class="background_span">I authorize Convo to run a background check prior to employment.  I understand I will need to provide Convo with copies of my Social Security card and Driver's License or state-issued ID as soon as possible.</span><br/><br/>
                
                
        <input type="hidden" name="action" value="upload"/> <input type="submit" id="submit_button_disabled" name="submitOnboarding" value="Submit"/>        
                
                <!--<input type="submit" id="submit_button_disabled" name="submitNewHire" value="Submit" disabled/>-->
            </form>
<?php
    include("../assets/inc/footer.inc.php"); 
?>
