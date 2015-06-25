<?php 
    $title = "Convo Portal | Announcements";

    include("../core/init.php");
    include("../assets/inc/header.inc.php");
    admin_protect();

    if(isset($_POST["submit"])) {
        $content = mysql_real_escape_string($_POST["content"]); 
        $effectiveDate = sanitize($_POST["effective_date"]);
        $announcementTime = sanitize($_POST["announcement_time"]);

        
        // Convert from MM/DD/YYYY to YYYY-DD-MM
        $effectiveDateInput = multiexplode(array("-", "/"), $effectiveDate);
        $effective_date = $effectiveDateInput[2] . "-" . $effectiveDateInput[0] . "-" . $effectiveDateInput[1];

        $effective_dateTime = $effective_date . " " . date("H:i", strtotime($announcementTime));
        
        //echo $effective_date;
        //echo "CALL update_announcement(1, '$content', '$effective_dateTime')";
        //echo "CALL update_announcement(2, '$content', '$effective_dateTime')";
        mysql_query("CALL insert_announcement('$content', '$effective_dateTime')");
    }

/*
BEGIN 
UPDATE announcement cur, (SELECT * FROM announcement a WHERE a.announcement_id = p_announcement_id) AS fut SET cur.home_page = fut.p_home_page WHERE fut.p_effective_date < NOW();
END
*/
?>


            <script type="text/javascript">
                tinymce.init({
                    selector: "textarea",
                    theme: "modern",
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace visualblocks visualchars code fullscreen",
                        "insertdatetime nonbreaking save table contextmenu directionality",
                        "template paste textcolor colorpicker textpattern"
                    ],
                    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                    toolbar2: "print preview media | forecolor backcolor",
                    image_advtab: true,
                    setContent: "TEST",
                });
            </script>

            <h1 class="headerPages">Editing Announcements</h1>
            <h2 class="current_announcement">Current:</h2>
<?php
    $queryAnnouncements = "SELECT * FROM announcement_vw WHERE NOW() >= effective_date ORDER BY effective_date DESC";
    $result = mysqli_query($link, $queryAnnouncements);
    $num_rows = mysqli_affected_rows($link);
    if($result && $num_rows > 0) {
        //while(){
            $row = mysqli_fetch_assoc($result);
            echo $row["home_page"];
        //}
    }
?>

<?php
    $queryAnnouncements = "SELECT * FROM announcement_vw WHERE NOW() <= effective_date ORDER BY effective_date ASC";
    $result = mysqli_query($link, $queryAnnouncements);
    $num_rows = mysqli_affected_rows($link);
    if($result && $num_rows > 0) {
        echo "<h2 class='current_announcement'>Future Announcement</h2>";
        while($row = mysqli_fetch_assoc($result)){
        //$row = mysqli_fetch_assoc($result);
            //$effDate = date('m/d/Y h:i:s a', strtotime($row["effective_date"]));
            $future_announcement = $row["home_page"];
            $future_date = date('m/d/Y', strtotime($row["effective_date"]));
            $future_time = date('g:i a', strtotime($row["effective_date"]));
            echo date('F d, Y g:i:s a', strtotime($row["effective_date"])) . " (CST)";
            echo $row["home_page"];
            echo "<hr/>";
        }
    }
?>


            <form method="post" action="announcements.php">
                <textarea name="content" style="width:100%"><?php echo $future_announcement; ?></textarea><br/>

                    <span>Effective Date:</span>
                    <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="effective_date" value="<?php echo $future_date;?>">

                    <span>Time (CST):</span>
                    <input type="text" class="input-small" name="announcement_time" value="<?php echo $future_time;?>"><br/>

                <input type="submit" name="submit" value="Submit">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>