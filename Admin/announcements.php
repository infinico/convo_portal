<?php 
    $page_title = "Announcements";
    $title = "Convo Portal | Announcements";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    include("../assets/inc/header.inc.php");
    admin_protect();
    protect_page();

    if(isset($_POST["submit"])) {


        if(!empty($_POST["content"]) && !empty($_POST["effective_date"]) && !empty($_POST["announcement_time"])){
            $content = mysqli_real_escape_string($link, $_POST["content"]); 
            $youtube_id = sanitize($_POST["youtube_id"]);
            $effectiveDate = sanitize($_POST["effective_date"]);
            $announcementTime = sanitize($_POST["announcement_time"]);


            // Convert from MM/DD/YYYY to YYYY-DD-MM
            $effectiveDateInput = multiexplode(array("-", "/"), $effectiveDate);
            $effective_date = $effectiveDateInput[2] . "-" . $effectiveDateInput[0] . "-" . $effectiveDateInput[1];

            $effective_dateTime = $effective_date . " " . date("H:i", strtotime($announcementTime));
            mysqli_query($link, "CALL insert_news('$content', '$youtube_id', '$effective_dateTime')") or sendErrorEmail($link);

            $htmlFormat = replace(getSearchTerms(), getYoutubeCode($youtube_id), $content);
            $queryAnnouncements = "SELECT firstname, email FROM employee WHERE email='tiandre.turner@gmail.com'";
            $result = mysqli_query($link, $queryAnnouncements) or die(mysqli_error($link));
            while($row = mysqli_fetch_assoc($result)){
                if(($email = $row["email"]) != null){
                    sendEmail($email, "Announcement", "Hello " . $row["firstname"] . ",\nHere is a new announcement:\n" . $htmlFormat,
                        "Hello " . $row["firstname"] . ",\nHere is a new announcement:\n" .$htmlFormat);
                }               
            }  
        }
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
                    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                    toolbar2: "print preview media | forecolor backcolor",
                    image_advtab: true,
                    setContent: "TEST",
                });
            </script>

            <h1 class="headerPages">Editing Announcements</h1>
            <h2 class="current_announcement">Current:</h2>
<?php
    $queryAnnouncements = "SELECT * FROM news WHERE NOW() >= effective_date ORDER BY effective_date DESC";
    $result = mysqli_query($link, $queryAnnouncements);
    $num_rows = mysqli_affected_rows($link);
    //if($result && $num_rows > 0) {
    while($row = mysqli_fetch_assoc($result)){
                   
            //$row = mysqli_fetch_assoc($result);
            echo replace(getSearchTerms(), getYoutubeCode($row["youtube_id"]), $row["home_page"]);
            //echo $row["home_page"];
        }
    //}
?>

<?php
    $queryAnnouncements = "SELECT * FROM news WHERE NOW() <= effective_date ORDER BY effective_date ASC";
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
            echo replace(getSearchTerms(), getYoutubeCode($row["youtube_id"]), $row["home_page"]);
            echo "<hr/>";
        }
    }
?>


            <form method="post" action="announcements.php">
                <textarea name="content" style="width:100%"><?php if(!empty($future_announcement)){ echo $future_announcement;} ?></textarea><br/>
                    <span>Youtube:</span>
                    <input type="text" placeholder="youtube id" name="youtube_id" maxlength="11"/>

                    <span>Effective Date:</span>
                    <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="effective_date" value="<?php if(!empty($future_date)){echo $future_date;}?>">

                    <span>Time (CST):</span>
                    <input type="text" class="input-small" name="announcement_time" value="<?php if(!empty($future_time)){echo $future_time;}?>"><br/>

                <input type="submit" name="submit" value="Submit">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>