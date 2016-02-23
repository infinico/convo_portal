<?php 
    $page_title = "Employee Acknowledgement";
    $title = "Convo Portal | Employee Acknowledgement";
    
    include("../core/init.php");

    $ip_address = $_SERVER["REMOTE_ADDR"];
    $current_date = date("F j, Y");

    if ($_GET['ack_id'] == false)
        header("Location: acknowledgements.php");
    
    // Acknowledgement ID is extracted from "ack_id" querystring value
    $acknowledgementID = $_GET['ack_id'];
    $acknowledgementType;
    $acknowledgementDate;

    $employee_id = $user_data["employee_id"]; //your employee id when logged in
    $curr_empName = $user_data["firstname"] . " " . $user_data["lastname"];

    $query = "SELECT ack_type, descr, date_ack, curr_emp_name FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND ack_id=" . $acknowledgementID;
    $result = mysqli_query($link, $query);   
    $num_rows = mysqli_affected_rows($link);

    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $acknowledgementType = $row["ack_type"];
            $acknowledgementTitle = $row["descr"];
            $acknowledgementDate = $row["date_ack"];
            $acknowlegementCurrName = $row["curr_emp_name"];
        }
        
        if (strlen($acknowledgementDate) > 0) 
        {
            $date = date_create($acknowledgementDate);
            $current_date = date_format($date, "F j, Y");
        }
    }
    else {
        header("Location: acknowledgements.php");
    }

    // What shows up in this page depends on the acknowledgement type
    switch($acknowledgementType)
    {
        case "FIN":
             $acknowledgementText = "I acknowledge that I have read and understand the <a href=\"../Finance/finance.php\" target=\"_blank\"> Convo Travel &amp; Reimbursement Policy</a>, which outlines my expectations prior to and while traveling on Convo business.";
            break;
        case "MBW":
         $acknowledgementText = "I acknowledge that I have read and understand the following:<br><br>
            In accordance with the Affordable Care Act (ACA), all Convo employees who elect not to 
            enroll into a company-sponsored health plan are required to review and acknowledge the below.<br><br>
            I certify that Convo Communications LLC offered me an opportunity to enroll into a company-sponsored health 
            plan for coverage for myself in addition to any eligible dependents I may have. After carefully reviewing 
            all the options available to me, I am declining enrollment.<br><br>
            I am declining enrollment because of other health insurance coverage that I and/or my eligible dependents 
            have. I understand I may be able to enroll my eligible dependents and myself at a later date only if I 
            have a qualifying event or during the company’s annual open enrollment period.<br><br>
            I understand that in the case of a qualifying event, I must request enrollment via Human Resources within 
            30 days of the qualifying event or termination of my other health plan. Failure to do so will result in a 
            lapse of coverage, as I will not be able to enroll until the company’s next annual open enrollment period.";
            break;
        case "SCF":
            $acknowledgementText = "I acknowledge that I have read and understand the <a href=\"../Benefits/overview.php\" target=\"_blank\"> Benefits Overview</a>, which outlines my expectations as a Video Interpreter at Convo.";
            break;
        case "WPN":
            $acknowledgementText = "I acknowledge that I have read and understand the following:<br><br>
            All Convo employees are required to use their Convo work number whenever they use 
            Convo VRS for a call related to the business of Convo, whether they are in the workplace or not.<br><br>
            Human Resources (HR) will ensure all covered Convo personnel have a Convo work number and that the number 
            is included in an internal database which excludes any VRS calls, made to or from all Convo work numbers, 
            from being submitted for compensation by Convo. You must use your Convo work number whenever you use Convo 
            VRS for Convo-related business.<br><br>
            If you are eligible to use VRS, you may register for a separate Convo number to make VRS calls that are 
            personal and not related to the business of Convo. To ensure the privacy of your personal or non-Convo 
            business related VRS calls, you should use your personal number to make those VRS calls. You may not use a 
            Convo personal number to make VRS calls related to the business of Convo. Your personal number is not 
            included in the Convo internal database.<br><br>
            Covered independent contractors will also be assigned a Convo work number if they are required to use Convo 
            VRS for calls related to the business of Convo, whether they are in the workplace or not.<br><br>
            HR will deactivate and remove from the internal database all terminated employees’ and independent 
            contractor’s Convo work numbers.";
            break;
        default:
            header("Location: acknowledgements.php");
    }

    include("../assets/inc/header.inc.php");
    if(isset($_POST["submitRequest"])){
        if(isset($_POST["checkBox"])){
            
            $employee_query = mysqli_query($link, "CALL update_acknowledgement('$employee_id', $acknowledgementID, '$ip_address', '$curr_empName')"); 
            echo "<br><br><h2 id='headerPages'>Your acknowledgement has been received. Thank you!</h2>"; 
            die();
        }
        else{
            echo "not checked";   
       }
    }
?>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Homemade+Apple" />
<h1 class="headerPages"><?php echo $acknowledgementTitle ?></h1>
<form id= "acknowledgement" method="post">
        <p>
        <input type="checkbox" name="checkBox" id="background_check_consent_cb" value="bg_check_consent_cb"
        <?php
        if(strlen($acknowledgementDate) > 0) { echo "checked disabled"; }
        ?>
        >&nbsp;&nbsp;
        <?php echo $acknowledgementText ?>
        <br/><br/>
        </p>

    <p>
    <b><i><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:'Homemade Apple', cursive"><?php echo(strlen($acknowlegementCurrName) > 0 ? $acknowlegementCurrName : $curr_empName); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
          
    <span style="margin-right: 30%; float:right"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $current_date ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></i></b></span>
        <br/>
        <br/>
        </p>    
    <?php
        if(strlen($acknowledgementDate) == 0) {
    ?>    
    <input type="submit" id="submit_button_disabled" name="submitRequest" value="Submit" disabled/>
    <?php
    }
    ?>
    </form>

<?php
    include("../assets/inc/footer.inc.php");
?>