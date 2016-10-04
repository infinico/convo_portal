<?php 
    $page_title = "Convo Portal";
    $title = "Convo Portal";
    include("core/init.php");
    include("assets/inc/header.inc.php");

    $today = date('Y-m-d H:i:s');
?>
<br/><br/><br/><br/>

<?php
    if(logged_in() == true)
    {
        $queryAnnouncements = "SELECT * FROM news WHERE NOW() >= effective_date ORDER BY effective_date DESC";
        $result = mysqli_query($link, $queryAnnouncements);
        $num_rows = mysqli_affected_rows($link);
        while($row = mysqli_fetch_assoc($result))
        {
            echo replace(getSearchTerms(), getYoutubeCode($row["youtube_id"]), $row["home_page"]);
        }
    }
    else {
        echo "<h2>Please login or <a href='register.php'>register</a> to access the Portal.</h2>";
    }

    include("assets/inc/footer.inc.php"); 
?>
