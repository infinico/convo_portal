<?php
    $page_title = "Employee Log";
    $title = "Convo Portal | Employee Log";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");

    //$query_log = "CALL insert_log('$session_user_id', CURRENT_TIMESTAMP)";
    //mysqli_query($link, $query_log);

?>

<h1 class="headerPages">Employee Log</h1>

<?php
    echo "<table class='table table-bordered table-hover' id='tab_logic'>";
    echo "<thead><tr>";
    echo "<th>Employee</th><th>Page Visited</th><th>Date Visited (CST)</th>";
    echo "</thead></tr><tbody>";

    $query = "SELECT * FROM log_vw";

    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);
    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["name"] . "</td><td width='20%'>" . $row["convoU_page"] . "</td><td>" . date('l, F d, Y g:i:s A', strtotime($row["last_visit"])) . "</td></tr>";
        }
    }
    echo"</tbody></table>";

    include("../assets/inc/footer.inc.php");
?>