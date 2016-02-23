<?php 
    $page_title = "Employee Acknowledgements";
    $title = "Convo Portal | Employee Acknowledgements";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");
    $employee_id = $user_data["employee_id"];
?>
<h1 class="headerPages">Employee Acknowledgements</h1>

<h2>Pending Acknowledgements</h2>
<p>
<?php
    $query = "SELECT ack_id, descr FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND date_ack IS NULL ORDER BY date_sent";
    $result = mysqli_query($link, $query);   
    $num_rows = mysqli_affected_rows($link);

    if ($result && $num_rows > 0) { 
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a href=\"acknowledgement.php?ack_id=" . $row["ack_id"] . "\">" . $row["descr"] . "</a><br>";
        }
    }
    else {
        echo "No pending acknowledgements on record";
    }
?>
</p>

<h2>Past Acknowledgements</h2>
<p>
<?php 
    $query = "SELECT * FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . "' AND date_ack IS NOT NULL ORDER BY date_ack";
    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);
    
    if ($result && $num_rows > 0) { 
       echo "<table id='acknowledgement_waivers_table' class='display' cellspacing='0' width='1010px'>" .
           "<thead><tr><th style='background-color:#71AB3A'>Acknowledgement</th>" .
           "<th style='background-color:#71AB3A'>Version</th>" .
           "<th style='background-color:#71AB3A'>Date/Time (CST)</th>" .
           "<th style='background-color:#71AB3A'>IP Address</th>" .
           "</tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td><a href=\"acknowledgement.php?ack_id=" . $row["ack_id"] . "\" target=\"_blank\">" . $row["descr"] . "</td><td>" . $row["ack_version"] . "</td><td>" . $row["date_ack"] .  "</td><td>" .  $row["ip_address"] . "</td></tr>";
        }
        echo "</tbody></table>";
        }
        else{
            echo "No past acknowledgements on record";
        }
?>
</p>



    

<?php
    include("../assets/inc/footer.inc.php");
?>