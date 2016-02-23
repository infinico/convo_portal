<?php 
    $page_title = "Acknowledgement Report";
    $title = "Convo Portal | Acknowledgement Report";
    include("../core/init.php");
    manager_protect();
    protect_page();

    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Acknowledgement Report</h1>


<?php
    $query = "SELECT * FROM acknowledgement_vw";
    $result = mysqli_query($link, $query);
    
    $num_rows = mysqli_affected_rows($link);
    echo "<table id='acknowledgement_table' class='display' cellspacing='0' width='1010px'>";
        if ($result && $num_rows > 0) { 
           echo "<thead><tr><th style='background-color:#71AB3A'>Employee ID</th>" .
               "<th style='background-color:#71AB3A'>First Name</th>" .
               "<th style='background-color:#71AB3A'>Last Name</th>" .
               "<th style='background-color:#71AB3A'>Ack Type</th>" .
               "<th style='background-color:#71AB3A'>Version</th>" .
               "<th style='background-color:#71AB3A'>Date Sent</th>" .
               "<th style='background-color:#71AB3A'>Date Ack</th>" .
               "<th style='background-color:#71AB3A'>IP Address</th>" .
               "</tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] .  "</td><td>" . $row["ack_type"] . "</td><td>" . $row["ack_version"] . "</td><td>" . $row["date_sent"] . "</td><td>" . $row["date_ack"] . "</td><td>" . $row["ip_address"] . "</td></tr>";

            }
        }        
    echo "</tbody></table>";
    include("../assets/inc/footer.inc.php");
?>