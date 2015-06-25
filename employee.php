<?php 
    //echo $linkToALL . "/edit.php";
    $title = "Convo Portal | Employees";
    include("core/init.php");
    manager_protect();
    include("assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Employees</h1>
            <div id="active_leave_checkbox">
                <input onchange="filterme()" type="checkbox" id="checkboxLoad" class="active_terminate" name="active_terminate" value="Active" >&nbsp;Active &nbsp;&nbsp;&nbsp;&nbsp; 
                <input onchange="filterme()" type="checkbox" id="checkboxLoad" class="active_terminate" name="active_terminate" value="Leave" >&nbsp;Leave
            </div>
            <div id="termination_checkbox">
                <input onchange="filterme()" type="checkbox" class="active_terminate" name="active_terminate" value="Terminated">&nbsp;Terminated
            </div>
            <br/>

<?php
/*
SELECT e.employee_id, e.firstname, e.lastname, e.supervisor_id, p.position_name AS position, CONCAT(s.firstname, ' ', s.lastname) AS supervisor, CONCAT(MONTH(e.hire_date), '-', DAY(e.hire_date), '-', YEAR(e.hire_date)) AS hireDate, CONCAT(MONTH(e.review_date), '-', DAY(e.review_date), '-', YEAR(e.review_date)) AS reviewDate, e.payroll_status, e.hourly_rate, e.employment_status FROM employee s RIGHT JOIN employee e ON e.supervisor_id = s.employee_id LEFT JOIN position_type p ON e.job_code = p.job_code WHERE employee_id NOT IN("C001", "C002", "C003")
*/
    /*
    * See every employees
    */
    if(has_access($user_data["job_code"]) == true) {
        $query = "SELECT * FROM convo_employee_vw";
        $result = mysqli_query($link, $query);
    }
    else {
        $query = "SELECT * FROM convo_employee_vw WHERE supervisor_id = " . $user_data["employee_id"];
        $result = mysqli_query($link, $query);   
    }
    $num_rows = mysqli_affected_rows($link);
    echo "<table id='example' class='display' cellspacing='0' width='1010px'>";
        if ($result && $num_rows > 0) { 
           echo "<thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Position</th><th>Supervisor</th><th>Hire Date</th><th>Review Date</th><th>Payroll Status</th><th>Hourly Rate</th><th>Status</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>";
                if(has_access($user_data["job_code"]) == true){
                    echo "<a href='$linkToALL/Admin/edit.php?employee_id=" . $row["employee_id"] . "'>" . $row["employee_id"] . "</a>";
                }
                else{
                    echo $row["employee_id"];
                }
            echo "</td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] .  "</td><td>" . $row["position"] . "</td><td>" . $row["supervisor"] . "</td><td>" . date("n/j/Y", strtotime($row["hireDate"])) . "</td>";
                if($row["reviewDate"] == "1-1-1900"){
                    echo "<td></td>";
                }
                else{
                   echo "<td>" . date("n/j/Y", strtotime($row["reviewDate"])) . "</td>";
                }
                
                echo "<td>" .  $row["payroll_status"]. "</td>";
                    if($row["hourly_rate"] == "0.00"){
                        echo "<td></td>";   
                    }
                else{
                    echo "<td>" . $row["hourly_rate"] . "</td>";
                }
                echo "<td>" . $row["employment_status"] . "</td></tr>";  
            }
        }        
    echo "</tbody></table>";
    include("assets/inc/footer.inc.php");
?>