<?php
    $title = "Convo Portal | Log";
    include("core/init.php");
    protect_page();
    include("assets/inc/header.inc.php");

    $query_log = "CALL insert_log('$session_user_id', CURRENT_TIMESTAMP)";
    mysqli_query($link, $query_log);

?>

<h1 class="headerPages">Log</h1>

<?php
    echo "<table class='table table-bordered table-hover' id='tab_logic'>";
    echo "<thead><tr>";
    echo "<th>Employee ID</th><th>Last Visit</th>";
    echo "</thead></tr><tbody>";

    $query = "SELECT * FROM log";

    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);
    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["employee_id"] . "</td><td>" . date('m/d/Y g:i:s A', strtotime($row["last_visit"])) . "</td></tr>";
        }
    }
    echo"</tbody></table>";

    include("assets/inc/footer.inc.php");
?>