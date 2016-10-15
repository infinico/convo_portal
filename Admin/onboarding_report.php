<?php 
    $page_title = "Onboarding Status";
    $title = "Convo Portal | Onboarding Checklist";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    manager_protect();
    include("../assets/inc/header.inc.php");


    //$resultemployee = mysqli_query($link, "SELECT * FROM employee_info_vw");
        
        $query = "SELECT * FROM employee_info_vw JOIN neo_tracking WHERE neo_tracking.employee_id = employee_info_vw.employee_id";

        
        $result = mysqli_query($link, $query);

        $num_rows = mysqli_affected_rows($link);

    
    if(isset($_POST["submit"])) {
        
       //$backgroundcheck_query = "SELECT * FROM employee_info_vw WHERE employee_id = '" . $_POST['backgroundChecked$i'] . "'";
       //$supervisor_query= 
        
       // echo "NUM: " . $num_rows;
        for($i=1; $i < $num_rows; $i++){
        
           // echo $i . ": " . isset($_POST["backgroundChecked$i"]);
                
            if(isset($_POST["backgroundChecked$i"])){
                
                $name =                     
                //$supervisor = "SELECT supervisor_id FROM employee_info_vw";
            
                $employee_id = sanitize($_POST["backgroundChecked$i"]);

                mysqli_query($link, "CALL update_neo_background('$employee_id', 'Y')") or die($link);

                onboarding_checklist_notification($name, $supervisor);

                echo "<h2 class='headerPages'>The employee checklist was updated successfully!</h2>";


                die();

            } 
            
          
        }
    }
?>

<h1 class="headerPages">New Employee Checklist</h1>

<form id= "neo_form" action="onboarding_report.php" method="post">
    <?php
        
$i = 1;
        echo "<table id='onboarding_table' class='display' cellspacing='0' width='1010px'>";
            if ($result && $num_rows > 0) { 
               echo "<thead><tr><th style='background-color:#71AB3A'>First Name</th>" .
                   "<th style='background-color:#71AB3A'>Last Name</th>" .
                   "<th style='background-color:#71AB3A'>Status</th>" .
                   "<th style='background-color:#71AB3A'>Hire Date</th>" .
                   "<th style='background-color:#71AB3A'>Background Check Cleared</th>" .


                   "</tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    $i++;
                    
                    if($row["bkgd_clear"] != "Y"){
                    
                        echo "<tr><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["checklist_status"]  . "</td><td>" . $row["hire_date"] . "</td><td><input type='checkbox' name='backgroundChecked$i' value='" . $row["employee_id"] . "'>";
                    }
                    else{
                        echo "<tr><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["checklist_status"]  . "</td><td>" . $row["hire_date"] . "</td><td><input type='checkbox' checked='checked' disabled='disabled' name='backgroundChecked$i' value='" . $row["employee_id"] . "'>";              
                    }

                }
            }        
        echo "</tbody></table>";

?>

    <input type="submit" id="submit" name="submit" value="Update">

</form>


<?php

    include("../assets/inc/footer.inc.php");
?>
