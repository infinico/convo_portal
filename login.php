<?php
    include("core/init.php");


    if(empty($_POST) === false) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        //echo $username, " ", $password;
        
        //Username and Password fields are empty 
        if(empty($username) === true || empty($password) === true) {
            $errors[] = "If you forget your username or password, you can <a href='register.php'>register</a> again.";
        }
        
        //Check if the username is either exist or not in our database system
        else if (user_exists($username) === false) {
            $errors[] = "If you forget your username or password, you can <a href='register.php'>register</a> again.";      
        }
        
        //Users have not check their email to activiate their account
        /*else if(user_active($username) === false) {
            $errors[] = "You haven't activiated your account!";   
        }*/
        
        
        else {
            //Max characters for password is 30
            if(strlen($password) > 30) {
                $errors[] = "Password is too long.";
            }

            $login = login($username, $password);
            
            //Either username and password input is incorrect
            if($login === false) {
                $errors[] = "That username/password combination is incorrect";   
            }
            else {
                // echo "OK!";
                //die($login);
                if(isset($_POST["remBox"])){
                    //Store username and password into the cookies 
                    setcookie("username", $username, time() + 7200);
                    setcookie("password", $password, time() + 7200);
                }
                
                // Set the user Session
                $_SESSION['employee_id'] = $login;
                
                // Redirect user to home
                header("Location: index.php");
                exit();
            }
        }
    }
    else {
        $errors[] = "No data received";
    
    }

    $title = "Convo Portal | Login";
    include("assets/inc/header.inc.php");

    if(empty($errors) === false) {
        ?>
        <br/><br/><br/>
        <h2 class="headerPages">Incorrect Login</h2>
        <?php echo output_errors($errors);
    }

    include("assets/inc/footer.inc.php");
?>