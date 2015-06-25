<?php
    $title = "Convo Portal | Convo University";
    include("../core/init.php");
    //protect_page();
    include("../assets/inc/header.inc.php");

    $query_log = "CALL insert_log('$session_user_id', CURRENT_TIMESTAMP)";
    mysqli_query($link, $query_log);
?>

<h1 class="headerPages">Convo University</h1>

<h2>Waiting patiently for content from Sherry Hicks</h2>

<?php
    include("../assets/inc/footer.inc.php");
?>