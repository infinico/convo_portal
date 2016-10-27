<?php
$page_title = "New Employee Onboarding Review";
$title = "New Employee Onboarding Review";


require_once "../includes/phpmailer/vendor/autoload.php";
require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
include("../core/init.php");

include("../includes/includes_functions.php");
include("../assets/inc/header.inc.php");

$endProgramBooleanFlag = "N";
$errorUpload = $file_name_new =  "";
$filesUploaded = array();

//if(isset($_POST["submitOnboarding"])){

//    $firstname = sanitize($_POST["firstname"]);
//    $lastname = sanitize($_POST["lastname"]);
//}
$extensions = array("pdf", "doc", "jpg", "jpeg", "bmp", "gif", "png", "svg", "docx");

// SS CARD Upload
if(isset($_FILES["files"])){

    $files = $_FILES["files"];
    //var_dump($files);
    //print_r($file);
    $notAllowed = $errorSize = "";
    $fileNames = $files['name'];
    $fileSizes = $files['size'];
    $fileTmps = $files['tmp_name'];
    $fileErrors = $files['error'];


    for($index = 0; $index < sizeof($fileNames); $index++)
    {
        $fileName = $fileNames[$index];
        $file_ext=explode('.', $fileName);
        //$file_ext=end($file_ext);

        $file_ext=strtolower(end($file_ext));
        //echo $file_ext;


        if(in_array($file_ext,$extensions) == true){

            $endProgramBooleanFlag = "N";
            //$notAllowed="Please upload PDF file.";
            if($fileErrors[$index] == 0){
                if($fileSizes[$index] < 4200000){

                    $filesUploaded[] = $file_name_new = $user_data["lastname"] .  ' ' . $user_data["firstname"] . '_' . $fileName;
                    //echo "File Name: " . $file_name_new . "\n";
                    $file_destination_ssn = $root . '/convo/Admin/upload_oe/' . $file_name_new;

                    if(move_uploaded_file($fileTmps[$index], $file_destination_ssn)){
                        $endProgramBooleanFlag = "Y";
                        //die();
                    }
                    else{
                        $errorUpload = "<span class='error'>The files are not uploaded</span>";
                    }

                }
                else{
                    $errorFiles = "<span class='error'>The file size must be less than 4MB</span>";
                }
            }
        }
        /* ELSE STATEMENT - FILE TYPE CANNOT BE UPLOADED*/
        else if ($file_ext != ""){

            $errorUpload = "<span class='error'>This file type cannot be uploaded</span>";
        }
    }
}

$errorFiles =  "";
$fileDL = $fileSSN = "";


if(isset($_POST["submitOnboarding"])){
    $files = $_FILES["files"];
    //var_dump($files);
    //print_r($file);
    $notAllowed = $errorSize = "";
    $fileNames = $files['name'];
    $fileSizes = $files['size'];
    $fileTmps = $files['tmp_name'];
    $fileErrors = $files['error'];

    if(empty($_FILES["files"]["name"])){
        $errorFiles = "<span class='error'>Please upload files.</span><br/>";
    }

    if($errorUpload == "" && $errorFiles == "") {



        // Convert from MM-DD-YYYY to YYYY-MM-DD to follow the MySQL Date Format
        //$dobInput = multiexplode(array("-", "/"), $dob);
        //$date_of_birth = $dobInput[2] . "-" . $dobInput[0] . "-" . $dobInput[1];

        //$fileDL = $_FILES["fileDL"];
        //$fileSSN = $_FILES["fileSSN"];

        //mysqli_query($link, "CALL update_onboarding_hire('$employeeID', '$firstname', '$lastname', '$street_address', '$city', '$state', '$zipcode', '$email', '$date_of_birth', '$ssn')");


        echo "<h2 class='headerPages'>Thank you for uploading your files!<br/><br/>";


        if($endProgramBooleanFlag == "Y"){

            $filesOnPortal = "";
            //var_dump($filesUploaded);
            foreach ($filesUploaded as $fileName)
            {
                if ($fileName != "")
                {
                    echo $filesOnPortal = $linkToALL . "/Admin/upload_oe/" . $fileName . "\n";
                }
            }

            // email hr about files?
            //fileUploaded($firstname, $lastname, $fileDLOnPortal, $fileSSNOnPortal);

            die();
        }
    }
    die();
}
?>




<h2 class="headerPages">Welcome to Convo! Please review all the fields below. We also need copies of your Driver's License/State ID and Social Security card for your background check. Please have these ready to be uploaded.</h2>
<br />


<form id="form" action="test_secure_files_upload.php" method="post" enctype="multipart/form-data">
    <h2>Secure File Upload</h2>

    <?php echo $errorFiles; ?>


    <!-- Files to Upload -->


    <span class="spanHeader">Test Secure Files:</span>
    <?php echo $errorUpload; ?>
    <input type="file" id="secureFile" name="files[]" multiple=""/>
    <br />
    <br />
    <input type="checkbox" id="background_check_consent_cb" value="bg_check_consent_cb" />
    <span class="background_span">Checkmate</span>
    <br />
    <br />
    <input type="hidden" name="action" value="upload" />
    <input type="submit" id="submit_button_disabled" name="submitOnboarding" value="Submit" />

    <!--<input type="submit" id="submit_button_disabled" name="submitNewHire" value="Submit" disabled/>-->
</form>
<?php
    include("../assets/inc/footer.inc.php");
?>
