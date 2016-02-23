<?php
    $page_title = "Approval Center";
    $title = "Convo Portal | Approval Center";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");

    //$query_log = "CALL insert_log('$session_user_id', CURRENT_TIMESTAMP)";
    //mysqli_query($link, $query_log);

?>

<h1 class="headerPages">Approval Center</h1>
<?php
            if(has_access($user_data["job_code"]) == true) {
                $query = "SELECT f.fmla_id FROM fmla f JOIN employee e ON e.employee_id = f.employee_id WHERE status = 'R'";
                if($result = mysqli_query($link, $query)) {
                    // Return the number of rows in result set
                    $row_count = mysqli_num_rows($result);
                }      
            }
            else {
                $query = "SELECT f.fmla_id FROM fmla f JOIN employee e ON e.employee_id = f.employee_id WHERE supervisor_id =" . $user_data["employee_id"] . " AND status = 'R'";
                if($result = mysqli_query($link, $query)) {
                    // Return the number of rows in result set
                    $row_count = mysqli_num_rows($result);
                }
            }
    if($row_count <= 1) {
        echo "<h3>You have " . $row_count . " request.</h3>";   
    }
    else {
        echo "<h3>You have " . $row_count . " requests.</h3>";  
    }

    echo "<table class='table table-bordered table-hover' id='tab_logic'>";
    echo "<thead><tr>";
    echo "<th>Request ID</th><th>Employee ID</th><th>Employee Name</th><th>Type</th><th>Effective Date</th>";
    echo "</thead></tr><tbody>";

    if(has_access($user_data["job_code"]) == true) {
        $query = "SELECT 
        `f`.`fmla_id` AS `fmla_id`,
        `f`.`employee_id` AS `employee_id`,
        `e`.`firstname` AS `firstname`,
        `e`.`lastname` AS `lastname`,
        `f`.`request_type` AS `request_type`,
        `f`.`effective_date` AS `effective_date`    
            FROM
        (`convotesting`.`fmla` `f`
        JOIN `convotesting`.`employee` `e` ON `f`.`employee_id` = `e`.`employee_id`) WHERE `f`.`status` = 'R' ORDER BY effective_date DESC"; 
    }
    else {
        $query = "SELECT f.fmla_id, e.employee_id, e.supervisor_id, e.lastname, e.firstname, f.request_type, f.effective_date FROM fmla f JOIN employee e ON e.employee_id = f.employee_id WHERE supervisor_id = " . $user_data['employee_id'] . " AND status = 'R' ORDER BY effective_date DESC";
        }
  
//$query = "SELECT eaf.eaf_id, eaf.employee_id, CONCAT(e.lastname, ', ', e.firstname) AS name, eaf.eaf_type, eaf.effective_date FROM employee_action_form eaf INNER JOIN employee e ON e.employee_id = eaf.employee_id";

    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);
    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td><a href='review.php?fmla_id=" . $row["fmla_id"] . "'>" . $row["fmla_id"] . "</a></td><td>" . $row["employee_id"] . "</td><td>" . $row["lastname"] . ", " . $row["firstname"] . "</td><td>" . $row["request_type"] . "</td><td>" . date('l, F d, Y', strtotime($row["effective_date"])) . "</td></tr>";
        }
    }  
    echo"</tbody></table>";

    include("../assets/inc/footer.inc.php");
?>