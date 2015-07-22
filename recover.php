<?php
    ob_start();
    $page_title = "Recover";
    $title = "Convo Portal | Recover";
	include("core/init.php");
	logged_in_redirect();
	include("assets/inc/header.inc.php");

    if(isset($_GET["success"]) !== true) {
        if($_GET["mode"] == "password") {
            echo "<br/><br/><br/><h1 class='headerPages'>Recover - Password</h1>"; 
            echo "<p>Please enter your email address to recover your password.</p>";
        }
        else if($_GET["mode"] == "username") {
            echo "<br/><br/><br/><h1 class='headerPages'>Recover - Username</h1>"; 
            echo "<p>Please enter your email address to recover your username.</p>";
        }
    }
	if(isset($_GET["success"]) === true && empty($_GET["success"]) === true) {
?>
	<br/><br/><br/><h2 class='headerPages'>You will recieve an email you requested shortly!</h2>
<?php
	}
	else {
		$mode_allowed = array("username", "password");

		if(isset($_GET["mode"]) === true && in_array($_GET["mode"], $mode_allowed)) {
			if(isset($_POST["email"]) === true && empty($_POST["email"]) === false) {
				if(email_exists($_POST["email"]) === true) {
					recover($_GET["mode"], $_POST["email"]);
					header("Location: $linkToALL/recover.php?success");
                    exit();
				}
				else {
					echo "<p>We couldn't find that email address in our system. Please try again.</p>";
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
					<input type="submit" value="Recover" id="recoverButton"></li>
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
