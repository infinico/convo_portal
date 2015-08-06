<?php 
    $page_title = "Change Password";
    $title = "Convo Portal | Change Password";
    include("core/init.php");
    include("assets/inc/header.inc.php");
    protect_page();
    $errors = "";

    if(empty($_POST) === false) {
        $required_fields = array("current_password", "password", "password_again");
        
        foreach($_POST as $key => $value) {
            if(empty ($value) && in_array($key, $required_fields) === true) {
                //$errors[] = "Fields marked with an asterik are required";  
                //break 1;
            }
        } 
        
        if(md5($_POST["current_password"]) === $user_data["password"]) {
            if(trim($_POST["password"]) !== trim($_POST["password_again"])) {
                $errors = "<span class='error'>Your new passwords do not match.</span>";
            } else if(strlen($_POST["password"]) < 6) {
                $errors = "<span class='error'>Your password must be at least 6 characters.</span>";  
            } 
        }
        else {
            $errors = "<span class='error'>Your current password is incorrect.</span>";
         }
    }
    $displayNone = "";

    if(isset($_GET["success"]) === true && empty($_GET["successs"]) === true) {
        echo "Your password has changed!"; 
    }
    else {
        if(isset($_GET["force"]) === true && empty($_GET["force"]) === true) {
        ?>
           <br/><h3 class="force_password" style='color:red;'>You may change your temporary password to something else.</h3>
        <?php
        }
        if(empty($_POST) === false && empty($errors) === true) {
            change_password($session_user_id, $_POST["password"]);
            $displayNone = "style='display:none'";
            //header("Location: changepassword.php?success");
            
            echo "<h1 class='headerPages'>Your password has been changed successfully!</p>";
?>
            <script>$(".force_password").hide()</script>
<?php
			die(); 
        }
        else if(empty($errors) === false) {
         //   echo output_errors($errors);

        }
    ?>

            <h1 class="headerPages" <?php echo $displayNone; ?>>Change Password</h1>
            <form action="" method="post">
                <span class="spanHeader">Current Password: </span>
                <input type="password" name="current_password"><br/>

                <span class="spanHeader">New Password: </span>
                <input type="password" name="password">&nbsp;&nbsp;<em>The password must be between 6 and 30 characters.</em><br/>

                <span class="spanHeader">Confirm Password: </span>
                <input type="password" name="password_again"><br/>

                <input id="changePassButton" type="submit" value="Change Password">
            </form>
<?php 
        echo $errors;
    }
    include("assets/inc/footer.inc.php");
?>