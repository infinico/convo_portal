<?php 
    $page_title = "Employee Acknowledgement";
    $title = "Convo Portal | Employee Acknowledgement";
    
    include("core/init.php");

    $ip_address = $_SERVER["REMOTE_ADDR"];
    $current_date = date("F j, Y");

    if ($_GET['type'] == false)
        header("Location: index.php");
    
    // Acknowledgement type is extracted from "type" querystring value
    $acknowledgementType = $_GET['type'];

    // What shows up in this page depends on the acknowledgement type, which is based on the querystring
    $acknowledgementText = "";
    switch($acknowledgementType)
    {
        case "FIN":
            $acknowledgementTitle = "Convo Travel &amp; Reimbursement Policy Acknowledgement";
            $acknowledgementText = "I acknowledge that I have read and understand the <a href=\"Finance/finance.php\" target=\"_blank\"> Convo Travel &amp; Reimbursement Policy</a>, which outlines my expectations prior to and while traveling on Convo business.";
            break;
        case "SCF":
            $acknowledgementTitle = "Status Change Acknowledgement";
            $acknowledgementText = "I acknowledge that I have read and understand the <a href=\"Benefits/overview.php\" target=\"_blank\"> Benefits Overview</a>, which outlines my expectations as a Video Interpreter at Convo.";
            break;
        default:
            header("Location: index.php");
    }

    include("assets/inc/header.inc.php");
    if(isset($_POST["submitRequest"])){
        $employee_id = $user_data["employee_id"]; //your employee id when logged in
        if(isset($_POST["checkBox"])){
            $employee_query = mysqli_query($link, "CALL update_acknowledgement('$employee_id', '$acknowledgementType', 1, '$ip_address')"); 
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
        <input type="checkbox" name="checkBox" id="background_check_consent_cb" value="bg_check_consent_cb">&nbsp;&nbsp;
        <?php echo $acknowledgementText ?>
        <br/><br/>
        </p>

    <p>
    <b><i><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:'Homemade Apple', cursive"><?php echo $user_data['firstname'];?> <?php echo $user_data['lastname']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
            
    <span style="margin-right: 30%; float:right"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $current_date ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></i></b></span>
        <br/>
        <br/>
        </p>    
        <input type="submit" id="submit_button_disabled" name="submitRequest" value="Submit" disabled/>
    </form>

<?php
    include("assets/inc/footer.inc.php");
?>