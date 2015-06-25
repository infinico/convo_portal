<?php
    $title = "Convo Portal | Module";
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");

    $query_log = "CALL insert_log('$session_user_id', 'Module 1', CURRENT_TIMESTAMP)";
    mysqli_query($link, $query_log);

?>

<h1 class="headerPages">Module</h1>

<?php
    include("../assets/inc/footer.inc.php");
?>