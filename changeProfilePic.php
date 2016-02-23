<?php 
    $page_title = "Upload Employee Picture";
    $title = "Upload Employee Picture";

    include("/core/init.php");
    include("/includes/includes_functions.php");
    include("/assets/inc/header.inc.php");

    $errorMessage = $filePicture = "";

    $extensions = array("jpg", "jpeg", "bmp", "gif", "png", "svg");

    // Driver's License Upload
    if(isset($_FILES["profile"]) && $_POST["submitPicture"])
    { 
        if(empty($_FILES["profile"]["name"]))
        {
            $errorMessage = "Please upload your profile picture.";   
        }  
        else  
        {
            
            $file = $_FILES["profile"];

            $notAllowed = $errorSize = "";
            $file_name = $file['name'];
            $file_size = $file['size'];
            $file_tmp = $file['tmp_name'];
            $file_error = $file['error'];

            $file_ext=explode('.',$file_name);
            //$file_ext=end($file_ext);

            $file_ext=strtolower(end($file_ext));
            //echo $file_ext;
       
            if(in_array($file_ext,$extensions) == true)
            {
                //$notAllowed="Please upload PDF file.";
                if($file_error == 0)
                {
                    if($file_size < 1200000)
                    {
                        //$filePicture = $user_data["lastname"] . ' ' . $user_data["firstname"] . '.' . $file_ext;
                        $filePicture = 'testimagesize.' . $file_ext;
                        $testsize = $root . '/convo/assets/images/directory/' . $filePicture;
                        
                        if(move_uploaded_file($file_tmp, $testsize))
                        {
                            list($width, $height) = getimagesize($testsize);
                            //list($width, $height) = getimagesize("assets/images/directory/nophoto.jpg");

                            echo "<br/>width: " . $width . "<br />";
                            echo "height: " .  $height;

                            if($height * .5 < $width)
                            {
                                $errorMessage = "Your image is too wide. Please crop or use a different image.";
                            }
                            else if($height * .5 < $width)
                            {
                                $errorMessage = "Your image is too tall. Please crop and upload again.";
                            }
                            else
                            {
                                $filePicture = $user_data["lastname"] . ' ' . $user_data["firstname"] . '.' . $file_ext;
                                $file_destination_dl = $root . '/convo/assets/images/directory/' . $filePicture;
                                //echo $file_destination_dl;

                                if(copy($testsize, $file_destination_dl))
                                    //move_uploaded_file($file_tmp, $file_destination_dl
                                {
                                    //$endProgramBooleanFlag = "Y";
                                    //die();
                                }
                                else
                                {
                                    echo "not uploaded";   
                                }  
                            } 
                        }
                        
                       /* else
                        {
                            $filePicture = $user_data["lastname"] . ' ' . $user_data["firstname"] . '.' . $file_ext;
                            $file_destination_dl = $root . '/convo/assets/images/directory/' . $filePicture;
                            echo $file_destination_dl;

                            if(move_uploaded_file($file_tmp, $file_destination_dl))
                            {
                                //$endProgramBooleanFlag = "Y";
                                //die();
                            }
                            else
                            {
                                echo "not uploaded";   
                            }  
                        }*/
                    }
                    else
                    {
                        $errorMessage = "The file size must be less than or equal to 1MB. This file is " . round($file_size/1024) . " KB.";   
                    }
                }
            } 
            /* ELSE STATEMENT - FILE TYPE CANNOT BE UPLOADED*/
            else
            {          
                $errorMessage = "This file type cannot be uploaded. Please use JPG, GIF, PNG, BMP, or JPEG.";
            }
        }
        
        if($errorMessage == "") 
        {
            $employeeID = $user_data["employee_id"];
            //$filePic = $user_data["fileName"];
               
            $sqlquery = "CALL update_employee_image('$employeeID', '$filePicture')";
            mysqli_query($link, $sqlquery);
            
            echo "<h2 class='headerPages'>Thank you for uploading your image.<br/><br/>";   
         }
    }
    
?>

        <form id="form" action="changeProfilePic.php" method="post" enctype="multipart/form-data">                
                
                <br><span class='error'><?php echo $errorMessage; ?></span><br/><br/>
    
                <span class="spanHeader">Upload Image:</span>
                <!--?php echo $errorUploadDL; ?> -->
                <input type="file" id="profile" name="profile"/><br/><br/>
 
        <input type="hidden" name="action" value="upload"/> <input type="submit" id="submit_button_disabled" name="submitPicture" value="Submit"/>        
                
            </form>
<?php
    include("/assets/inc/footer.inc.php"); 
?>
