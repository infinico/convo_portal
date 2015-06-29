<?php
    $page_title = "Home";
    $title = "Convo Portal | Admin Home";
    include("../core/init.php");
    //protect_page();
    logged_in_redirect();
    include("../assets/inc/header.inc.php");
?>

<h1 class="headerPages">Admin</h1>

<h2>Admin Homepage</h2>

<?php
    include("../assets/inc/footer.inc.php");
?>