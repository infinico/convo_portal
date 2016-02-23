<?php 
    include("core/init.php");
    census_protect();
    include("includes/overall/header.php");

    $errorId = "";

    $result = mysql_query("SELECT * FROM employer");

    //echo $convo_user_data["employerID"];

    if(isset($_POST["submit"])) {
        $ssn = sanitize($_POST["ssn_digits"]);
        $dob = sanitize($_POST["dob"]);
        if(empty($_POST["ssn_digits"]) || empty($_POST["dob"])) {
            $errorId = "Please enter your SSN and Date of Birth.";
        }
        else if(($convo_user_data$convo_user_data["ssn"] != $_POST["ssn_digits"]) || ($convo_user_data["date_of_birth"] != $_POST["dob"]) ){
            $errorId = "Wrong SSN or date of birth.  Please try again.";
        }
        else {
            header("Location: census.php");
            exit();
        }
    }
?>

    <h1>Employee Census Information</h1>

    <p>Please enter the last four digits of your Social Security Number and your birthdate to proceed.</p>

    <form id="search_employer" method="POST" action="verify.php">
        <span class="spanHeader">Last 4 SSN Digits: </span>
        <input type="password" name="ssn_digits" size='5' maxlength="4"><br/><br/>
        <span class="spanHeader">Birth Date:</span>
        <input type="date" name="dob"><br/><br/>
        <input id="verify" type="submit" name="submit"><br/><br/>
        
        <?php echo $errorId; ?>
    </form>

<?php
include("includes/overall/footer.php"); 

?>