<?php
    $page_title = "Incorrect Login";
    include("core/init.php");

    if(empty($_POST) === false) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        //Username and Password fields are empty 
        if(empty($username) === true || empty($password) === true) {
            $errors[] = "If you forget your username or password, recover your <a href='recover.php?mode=username'>username</a> or reset <a href='recover.php?mode=password'>password</a>.";
        }
        
        //Check if the username is either exist or not in our database system
        else if (user_exists($username) === false) {
            $errors[] = "If you forget your username or password,recover your <a href='recover.php?mode=username'>username</a> or reset <a href='recover.php?mode=password'>password</a>.";      
        }
        else if (user_terminated($username) === true) {
            $errors[] = "Sorry, you no longer have access to the Convo portal. ";
        }
        
        else {
            //Max characters for password is 30
            if(strlen($password) > 30) {
                $errors[] = "Password is too long.";
            }

            $login = login($username, $password);
            
            //Either username and password input is incorrect
            if($login == false) {
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
                $_SESSION['emplid'] = $login;
                
                // Check if user needs to acknowledge anything. If true, redirect to acknowledgement page
                /*$sql = "SELECT ack_type FROM pending_acknowledgements_vw WHERE employee_id = '" . $login . "'";
                $acknowledgementQuery = mysqli_query($link, $sql);

                while($row = mysqli_fetch_assoc($acknowledgementQuery)){
                    if(mysqli_num_rows($acknowledgementQuery) > 0 ) {
                        header("Location: acknowledgement.php?type=" . $row["ack_type"]); 
                        exit();
                    }
                }*/
                
                // Redirect user to home page
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