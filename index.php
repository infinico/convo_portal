<?php 
    $title = "Convo Portal";
    include("core/init.php");
    include("assets/inc/header.inc.php");

    $today = date('Y-m-d H:i:s');

?>

            <br/><br/><br/><br/>

<?php
    $queryView = "SELECT * FROM announcement_vw WHERE NOW() >= effective_date ORDER BY effective_date DESC";
    $resultView = mysqli_query($link, $queryView);
    $num_rows_view = mysqli_affected_rows($link);
    if($resultView && $num_rows_view > 0 && logged_in() == true) {
        //while($row = mysqli_fetch_assoc($resultView)){
            $row = mysqli_fetch_assoc($resultView);
            echo $row["home_page"];
        //}
    }
    else {
        echo "<h2>Please login or <a href='register.php'>register</a> to access the Portal.</h2>";
    }

    include("assets/inc/footer.inc.php"); 
?>
