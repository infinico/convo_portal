<?php
    $page_title = "Open Enrollment";
    $title = "Convo Portal | Open Enrollment";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");


    if(isset($_FILES["filePDF"])){

        $file = $_FILES["filePDF"];
        //print_r($file);
        $notAllowed = $errorSize = "";
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
       
        $extensions = array("pdf", "doc");

        $file_ext=explode('.',$file_name);
        //$file_ext=end($file_ext);

        $file_ext=strtolower(end($file_ext));

        if(in_array($file_ext,$extensions) == true){
           //$notAllowed="Please upload PDF file.";
            if($file_error == 0){
                if($file_size < 4200000){
                    $file_name_new = $convo_user_data["lastname"] . ' ' . $convo_user_data["firstname"]  . '.' . $file_ext;
                    $file_destination = $root . '/convo/Admin/upload_oe/' . $file_name_new;
                    if(move_uploaded_file($file_tmp, $file_destination)){
                        echo "<h2 class='headerPages'>Thank you for uploading your file. If you need to make a change, you can <a href='OpenEnrollment.php'> upload your file</a> again.</h2>"; 
                        die();
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
    }
?>

            <h1 class="headerPages">Open Enrollment</h1>

            <p>We have a <a href="HR/Benefits/Introduction.pdf">new provider</a> this year.</p>

            <p>Download the <a href="HR/Benefits/Questionnaire.pdf">Medical Questionnaire</a> and fill out all relevant fields. You can either return this form to <a href="mailto:hr@convorelay.com">hr@convorelay.com</a> or upload your file at your earliest convenience.</p>

            <form action="OpenEnrollment.php" method="post" enctype="multipart/form-data"> 
                <p>Upload Medical Questionnaire: <input type="file" id="filePDF" name="filePDF"/> </p>
                <p><input type="hidden" name="action" value="upload"/> <input type="submit" name="submit" value="Submit"/> </p> 
            </form>
            <p>Please direct all benefits-related questions to <a href="mailto:hr@convorelay.com">hr@convorelay.com</a>.</p>
<?php
    include("../assets/inc/footer.inc.php"); 
?>