<?php
    ob_start();
    $page_title = "Approval Center";
    $title = "Convo Portal | Approval Center";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");

    $fmla_id = $_GET['fmla_id'];

    $errorComments = "";

    $query = mysqli_query($link, "SELECT 
        `f`.`fmla_id` AS `fmla_id`,
        `f`.`employee_id` AS `employee_id`,
        `e`.`firstname` AS `firstname`,
        `e`.`lastname` AS `lastname`,
        `e`.`street_address` AS `street_address`,
        `e`.`city` AS `city`,
        `e`.`res_state` AS `res_state`,
        `l`.`address` AS `convo_address`,
        `l`.`city` AS `convo_city`,
        `l`.`state` AS `convo_state`,
        `e`.`hire_date` AS `hire_date`,
        `e`.`email` AS `email`,
        `f`.`effective_date` AS `effective_date`,
        `f`.`return_date` AS `return_date`,
        `f`.`leave_reason` AS `leave_reason`
    FROM
        (`convotesting`.`fmla` `f`
        JOIN `convotesting`.`employee` `e` ON ((`f`.`employee_id` = `e`.`employee_id`))
        JOIN  `convotesting`.`location` `l` ON ((`l`.`location_code` = `e`.`location_code`))) WHERE `f`.`fmla_id` = '$fmla_id'");
    while($row = mysqli_fetch_assoc($query)) {
        $fmla_id = $row["fmla_id"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $streetAddress = $row["street_address"];
        $city = $row["city"];
        $res_state = $row["res_state"];
        $convoAddress = $row["convo_address"];
        $convoCity = $row["convo_city"];
        $convoState = $row["convo_state"];
        $hireDate = $row["hire_date"];
        $email = $row["email"];
        $effectiveDate = $row["effective_date"];
        $returnDate = $row["return_date"];
        $leaveReason = $row["leave_reason"]; 
        
        
    }
    if(empty($_POST["hr_comments"])){
        $errorComments = "<span class='error'>Please enter comments</span>";
    }

    if($errorComments == ""){
        if(isset($_POST['confirm'])){
            $subjectHeader = "FMLA Request Confirmation";
            $bodyMessage = sanitize($_POST["hr_comments"]);
            newEmail($email, $firstname, $lastname, $subjectHeader, $bodyMessage);
            
            
            mysqli_query($link, "UPDATE fmla SET status = 'C' WHERE fmla_id = '$fmla_id'");

            echo "<h2>CONFIRMED SUCCESSFULLY</h2>";
            die();
        }
        else if(isset($_POST['decline'])){
            
            $subjectHeader = "FMLA Request Confirmation";
            $bodyMessage = sanitize($_POST["hr_comments"]);
            newEmail($email, $firstname, $lastname, $subjectHeader, $bodyMessage);
            
            
            mysqli_query($link, "UPDATE fmla SET status = 'D' WHERE fmla_id = '$fmla_id'");

            echo "<h2>DECLINED SUCCESSFULLY</h2>";
            die();
        }
    }
    else if(isset($_POST['cancel'])){
        //echo $linkToALL . "/Approval%20Center/index.php";
        header("Location: " . $linkToALL . "/Approval%20Center/index.php");
    }

    //$query_log = "CALL insert_log('$session_user_id', CURRENT_TIMESTAMP)";
    //mysqli_query($link, $query_log);

?>

<h1 class="headerPages">Employee Action Form - Family and Medical Leave of Absence</h1>

<p>Please confirm or decline the <strong>Leave of Absence Request</strong> below:</p>

<form method="post">
    <h2>Employee Information</h2>
    <span class="fmlaHeader">Employee Name: </span>
    <input type="text" name="name" class="input-large" value="<?php echo $firstname . " " . $lastname; ?>" readonly><br/>
    
    <span class="fmlaHeader">Home Address:</span>
    <input type="text" name="home_address" class="input-xlarge" value="<?php echo $streetAddress . ", " . $city . ", " . $res_state; ?>" readonly><br/>
    
    <span class="fmlaHeader">Work Address:</span>
    <input type="text" name="work_address" class="input-xlarge" value="<?php echo $convoAddress . ", " . $convoCity . ", " . $convoState; ?>" readonly><br/>
    
    <span class="fmlaHeader">Date of Hire:</span>
    <input type="text" name="date_of_hire" value="<?php echo $hireDate; ?>" readonly><br/>
    
    <span class="fmlaHeader">Email:</span>
    <input type="text" name="date_of_hire" value="<?php echo $email; ?>" readonly><br/><br/>
    
    <h2>Request Information</h2>
    <span class="fmlaHeader">Expected Effective Date of Leave: </span>
    <input type="text" name="expected_date_leave" value="<?php echo $effectiveDate; ?>" readonly><br/>
    
    <span class="fmlaHeader">Expected Date of Return: </span>
    <input type="text" name="expected_date_return" value="<?php echo $returnDate; ?>" readonly><br/>
    
    <span class="fmlaHeader">Leave is being requested for one of the following reasons(please select one): </span>
    <input type="text" class="input-xlarge" name="leave_reason" value="<?php echo $leaveReason; ?>" readonly><br/>
    
    <span class="fmlaHeader">HR Comments:</span><?php if(isset($_POST["confirm"]) || isset($_POST["decline"])){echo $errorComments;}?>
    <textarea name="hr_comments" rows="5" cols="4"></textarea><br/>
    
    <input type="submit" class="btn btn-success" name="confirm" value="Confirm">
    <input type="submit" class="btn btn-danger" name="decline" value="Decline">
    <input type="submit" class="btn btn-default" name="cancel" value="Cancel">
</form>

<?php
    include("../assets/inc/footer.inc.php");
?>