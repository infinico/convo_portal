<?php 
    $page_title = "Onboarding Report";
    $title = "Convo Portal | Onboarding Report";
    include("../core/init.php");
    manager_protect();
    include("../assets/inc/header.inc.php");
?>

        <h1 class="headerPages">New Employee Onboarding Report</h1>


<?php
    $query = "SELECT * FROM new_hire_vw";
    $result = mysqli_query($link, $query);
    
    $num_rows = mysqli_affected_rows($link);
    echo "<table id='onboarding_table' class='display' cellspacing='0' width='1010px'>";
        if ($result && $num_rows > 0) { 
           echo "<thead><tr><th style='background-color:#71AB3A'>First Name</th>" .
               "<th style='background-color:#71AB3A'>Last Name</th>" .
               "<th style='background-color:#71AB3A'>City</th>" .
               "<th style='background-color:#71AB3A'>State</th>" .
               "<th style='background-color:#71AB3A'>Email</th>" .
               "<th style='background-color:#71AB3A'>Updated At</th>" .
               "<th style='background-color:#71AB3A'>Status</th>" .

               "</tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["city"]  . "</td><td>" . $row["res_state"] . "</td><td><a target=_blank href= mailto:" . $row["email_address"] . ">" . $row["email_address"] . "</a></td><td>" . $row["updated_at"] . "</td><td>" . $row["status"] . "</td></tr>";

            }
        }        
    echo "</tbody></table>";
    include("../assets/inc/footer.inc.php");
?>