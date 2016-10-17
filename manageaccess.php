<?php
$page_title = "Manager Access";
$title = "Convo Portal | Manager Access";
$errorDate = "";
$identification = "";
require_once "includes/phpmailer/vendor/autoload.php";
require("includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
include("core/init.php");
manager_protect();
include("assets/inc/header.inc.php");
define('PATTERN', "(([1-12]|[01-12]){2}/([1-31]|[01-31]){2}/(" . date('Y') . "|" . (date('Y') + 1) . ")|([1-12]|[01-12]){2}-([1-31]|[01-31]){2}-(" . date('Y') . "|" . (date('Y') + 1) . "))");

if(isset($_POST["submit"]))
{
    $array = $_POST["start_date"];
    
    foreach($array as $employees)
    {
        // add loop for checking before send it to the database
        foreach($employees as $startDateInfo){
            preg_match(PATTERN, $startDateInfo, $startDate);
            if(!empty($startDateInfo))
            {
                if(empty($startDate))
                {
                    $identification .= key($employees) . ',';
                    $errorDate = "<span class='error'> Please enter valid start date</span>";
                }
                    
            }
        }
    }

    if($errorDate == "")
    {
        foreach($array as $employees)
        {
            // add loop for checking before send it to the database
            foreach($employees as $startDateInfo){
                $startDateInfo = sanitize($startDateInfo);
                preg_match(PATTERN, $startDateInfo, $startDate);
                if(!empty($startDateInfo) && !empty($startDate))
                {
                    $key = explode('|', key($employees));
                    $name = $key[0];
                    $id = $key[1];
                    $startDate = $startDate[0];
                    $query = "CALL update_neo_tracking($id, '$startDateInfo');";
                    mysqli_query($link, $query) or sendErrorEmail($link);
                    onboarding_start_date_notification($name, $startDate);
                }
            }  
        }

        // echo that it was updated successfully..
        echo "<h2 class='headerPages'>The employee's information was updated successfully!</h2>";
        die();
    }

}

function compareIndex($searchIndex, $identification)
{
    $array = explode(",", $identification);
    foreach($array as $index)
    {
        if($index === $searchIndex)
            return true;
    }
    return false;
}
?>

<h1 class="headerPages">New Employee Onboarding Report</h1>

<form id="test" action="manageaccess.php" method="post">
    <?php
    $query = "select employee_id, firstname, lastname, payroll_status, hire_date, start_date from employee join neo_tracking on employee.emplid = neo_tracking.employee_id";
    $result = mysqli_query($link, $query);

    $num_rows = mysqli_affected_rows($link);
    echo "<table id='test_table' class='display' cellspacing='0' width='1010px'>";
    if ($result && $num_rows > 0) {
        echo "<thead><tr><th style='background-color:#71AB3A'>First Name</th>" .
        "<th style='background-color:#71AB3A'>Last Name</th>" .
        "<th style='background-color:#71AB3A'>Status</th>" .
        "<th style='background-color:#71AB3A'>Hire Date</th>" .
        "<th style='background-color:#71AB3A'>Start Date</th>" .
        "</tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            $firstName = $row["firstname"];
            $lastName = $row["lastname"];
            $start_date = $row["start_date"];
            $index  = $firstName . ' ' . $lastName . '|' . $row["employee_id"];
            echo "<tr><td>" . $firstName . "</td><td>" . $lastName . "</td><td>" .  $row["payroll_status"] . "</td><td>" . $row["hire_date"] . "</td><td>" . ($start_date != null ? $start_date : '<input type="text" name="start_date[][' . $index . ']" maxlength="2000">');

            if(compareIndex($index, $identification))
               echo $errorDate;
          
            echo "</td></tr>";
        }
    }
    echo "</tbody></table>";
    ?>
    <input type="submit" id="updateButton" name="submit" value="Update" />
</form>


<?php
include("assets/inc/footer.inc.php");
?>