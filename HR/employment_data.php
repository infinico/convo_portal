<?php
    $page_title = "Employment Data";
    $title = "Convo Portal | Employment Data";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
    $employee_id = $user_data["employee_id"];

    $errorEmail = "";

    $query = "SELECT * FROM employee_vw WHERE employee_id = '$employee_id'";

    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);

    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $email_address = $row["email"];
            $hireDate = $row["hire_date"];
            $hireDateInput = explode("-", $hireDate);
            $hire_date = $hireDateInput[1] . "/" . $hireDateInput[2] . "/" . $hireDateInput[0];
        }
    }

    if(isset($_POST["submit"])) {
        if(empty($_POST["email_address"])) {
            $errorEmail = "<span class='hireErrors'> Please enter email address</span>"; 
        }
        if($errorEmail == "") {
            $email = sanitize($_POST["email_address"]);
            
            $queryEmail = "CALL update_email('$employee_id', '$email')";
            $resultEmail = mysqli_query($link, $queryEmail);
            $num_rowsEmail = mysqli_affected_rows($link);
            if ($resultEmail && $num_rowsEmail > 0) {
                echo "<h2 class='headerPages'>Email was updated successfully!</h2>";
                die();
            }
        }
    }
?>

            <h1 class="headerPages">My Employment Data</h1>

            <p>If your home address is incorrect, please fill out <a href="HR/resources/W-4%20form.pdf" target="_blank">W-4 Form</a> and email to <a href="mailto:HR@convorelay.com">HR@convorelay.com</a>.</p>

<?php
    if($email_address == "") {
        echo "<h3 style='color:red;'>Your email address is required for all portal transactions.</h3>";
    }   
?>

            <form class="employment_data_form" method="POST">
                <h2>Home Address</h2>
                <span class="spanHeader">Street Address: </span>
                <input type="text" class="input-large" name="home_address" style='background:#E9E9E9;' readonly value="<?php echo $user_data["street_address"]; ?>"/><br/>
                <span class="spanHeader">City: </span>
                <input type="text" class="input-large" name="city" style='background:#E9E9E9;' readonly value="<?php echo $user_data["city"]; ?>"/><br/>
                <span class="spanHeader">State: </span>
                <input type="text" class="input-small" name="state" style='background:#E9E9E9;' readonly value="<?php echo $user_data["res_state"]; ?>"/><br/>
                <span class="spanHeader">Zip Code: </span>
                <input type="text" class="input-small" name="zip_code" style='background:#E9E9E9;' readonly value="<?php echo $user_data["zipcode"]; ?>"/><br/>

                <br/>

                <h2>Personal Information</h2>
                <span class="spanHeader">Email Address: </span>
                 <input type="text" class="input-large" name="email_address" placeholder="Email Address" value="<?php if(isset($_POST["submit"])){echo $_POST['email_address'];}else{ echo $user_data["email"]; } ?>"/><?php echo $errorEmail; ?><br/>

                <br/>

                <h2>Employee Information</h2>
                <span class="spanHeader">Position: </span>
                <input type="text" class="input-large" name="position" style='background:#E9E9E9;' readonly value="<?php echo $position_data["position_name"]; ?>"/><br/>
                <span class="spanHeader">Supervisor: </span>
                <input type="text" class="input-large" name="supervisor" style='background:#E9E9E9;' readonly value="<?php echo $supervisor_data["firstname"] . " " . $supervisor_data["lastname"]; ?>"/><br/>
                <span class="spanHeader">Date of Hire: </span>
                <input type="text" class="input-medium" name="hire_date" style='background:#E9E9E9;' readonly value="<?php echo $hire_date; ?>"/><br/>
                <br/>

                <input type="submit" class="btn-success" value ="Submit" name="submit">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>