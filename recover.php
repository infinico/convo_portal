<?php
    ob_start();
    require_once "includes/phpmailer/vendor/autoload.php";
    require("includes/phpmailer/libs/PHPMailer/class.phpmailer.php");

    $page_title = "Recover";
    $title = "Convo Portal | Recover";
	include("core/init.php");
	logged_in_redirect();
	include("assets/inc/header.inc.php");

    if(isset($_GET["success"]) !== true) {
        if($_GET["mode"] == "password") {
            echo "<br/><br/><br/><h1 class='headerPages'>Reset - Password</h1>"; 
            echo "<p>Please enter your email address to reset your password.</p>";
        }
        else if($_GET["mode"] == "username") {
            echo "<br/><br/><br/><h1 class='headerPages'>Recover - Username</h1>"; 
            echo "<p>Please enter your email address to recover your username.</p>";
        }
    }
	if(isset($_GET["success"]) === true && empty($_GET["success"]) === true) {
?>
	<br/><br/><br/><h2 class='headerPages'>Please check your email, thank you.</h2>
<?php
	}
	else {
		$mode_allowed = array("username", "password");
        
                if(isset($_POST["submit"])) {
             if(empty($_POST["email"])) {
                echo "<p style='color: red;'>Please type the email address.</p>";   
            }   
        }

		if(isset($_GET["mode"]) === true && in_array($_GET["mode"], $mode_allowed)) {
			if(isset($_POST["email"]) === true && empty($_POST["email"]) === false) {
				if(email_exists($_POST["email"]) === true) {
					recover($_GET["mode"], $_POST["email"]);
					header("Location: $linkToALL/recover.php?success");
                    exit();
				}
				else {
					echo "<p style='color: red;'>We couldn't find that email address in our system. Please try again.</p>";
				}
			}
?>
		<form action="" method="post">
			<ul>
				<li>
					Please enter your email address:<br>
					<input type="text" name="email">
				</li>
				<li>
<?php
                if(isset($_GET["success"]) !== true) {
        if($_GET["mode"] == "password") {
            echo "<input type='submit' name='submit' value='Reset' id='recoverButton'></li>";
        }
        else if($_GET["mode"] == "username") {
            echo "<input type='submit' name='submit' value='Recover' id='recoverButton'></li>";
        }
    }
?>
				</li>
			</ul>
		</form>
	<?php 
		}
		else {
			header("Location: index.php");
			exit();
		}
	}
	include("assets/inc/footer.inc.php");
?>
