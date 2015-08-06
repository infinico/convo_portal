<?php 
    $page_title = "Event Calendar";
    //error_reporting(0);
    $title = "Event Calendar";
    include("../core/init.php");
    //admin_protect();
    protect_page();
    include("../assets/inc/header.inc.php"); 
?>
<script>
            function goLastMonth(month, year){
                if(month == 1){
                    --year;
                    month = 13;
                }
                --month;
                var monthstring = ""+month+"";
                var monthlength = monthstring.length;
                if(monthlength <= 1){
                    monthstring = "0"+monthstring;   
                }
                document.location.href = "<?php $_SERVER["PHP_SELF"];?>?month="+monthstring+"&year="+year;
            }
            
            function goNextMonth(month, year){
               if(month == 12){
                    ++year;
                   month = 0;
               }
                ++month;
                var monthstring = ""+month+"";
                var monthlength = monthstring.length;
                if(monthlength <= 1){
                    monthstring = "0"+monthstring;   
                }
                document.location.href = "<?php $_SERVER["PHP_SELF"];?>?month="+monthstring+"&year="+year;
            }
    
            function hoverThis(){
                $(".event_info").css("cursor", "pointer");
            }    
        </script>
<?php
    if(isset($_GET['day'])){
        $day = $_GET['day'];   
    }
    else{
        $day = date("j");
    }
    if(isset($_GET['month'])){
        $month = $_GET['month'];  
        //echo $month;
    }
    else{
        $month = date("n");
    }
    if(isset($_GET['year'])){
        $year = $_GET['year'];   
    }
    else{
        $year = date("Y");
    }
    $currentTimeStamp = strtotime("$year-$month-$day");
    $monthName = date("F", $currentTimeStamp);
    //echo $monthName;
    $numDays = date("t", $currentTimeStamp);
    //echo $numDays;
    $counter = 0;
    $title = $startDate = $endDate = $startDate = $startTime = $endTime = $location = $detial = "";
    $errorTitle = $errorStartDate = $errorEndDate = $errorStartTime = $errorEndTime = $errorLocation = $errorDetail = "";
    if(isset($_GET['add'])){
        
        if(empty($_POST['txtTitle'])){
            $errorTitle = "<span class='error'>Please enter event title</span>";
        }
        if(empty($_POST['txtStartDate'])){
            $errorStartDate = "<span class='error'>Please enter start date</span>";
        }
        if(empty($_POST['txtEndDate'])){
            $errorEndDate = "<span class='error'>Please enter end date</span>";
        }
        if(empty($_POST['txtStartTime'])){
            $errorStartTime = "<span class='error'>Please enter start time</span>";
        }
        if(empty($_POST['txtEndTime'])){
            $errorEndTime = "<span class='error'>Please enter end time</span>";
        }
        if(empty($_POST['txtLocation'])){
            $errorLocation = "<span class='error'>Please enter location</span>";
        }
        if(empty($_POST['txtDetail'])){
            $errorDetail = "<span class='error'>Please enter detail</span>";
        }
        if($errorTitle == "" && $errorStartDate == "" && $errorEndDate == "" && $errorStartTime == "" && $errorEndTime == "" && $errorLocation == "" && $errorDetail == ""){
            $title = $_POST['txtTitle'];
            $startDate = $_POST['txtStartDate'];
            $endDate = $_POST['txtEndDate'];
            $startTime = $_POST['txtStartTime'];
            $endTime = $_POST['txtEndTime'];
            $location = $_POST['txtLocation'];
            $detail = $_POST['txtDetail'];
            $endDateFormat = multiexplode(array("-", "/"), $endDate);
            $end_date = $endDateFormat[2] . "-" . $endDateFormat[0] . "-" . $endDateFormat[1];
            $startdate = $year . "-" . $month . "-" . $day;
            $result = mysqli_query($link, "INSERT INTO event_calendar(title, detail, start_date, end_date, start_time, end_time, location, date_added) VALUES ('" . $title . "','" . $detail . "','" . $startdate . "','" . $end_date . "','" . $startTime . "','" . $endTime . "','" . $location . "', NOW())");
            //echo "INSERT INTO event_calendar(title, detail, event_date, start_date, end_date, start_time, end_time, location, date_added) VALUES ('" . $title . "','" . $detail . "','" . $startdate . "','" . $endDate . "','" . $startTime . "','" . $endTime . "','" . $location . "', NOW())";
            //echo "INSERT INTO event_calendar(title, detail, event_date, date_added) VALUES ('" . $title . "','" . $detail . "','" . $eventdate . "', 'NOW()')";
            if($result){
                echo "<br/><br/><h2>Event was successfully added<h2>";
                die();
            }
            else{
                echo "Aw Failed...";
            }
        }
    }
    else if(isset($_POST["deleteevent"])){
        //echo "YUP DELETE";
        $eventdate = $year . "-" . $month . "-" . $day;
        $event_id = $_GET["event_id"];
        mysqli_query($link, "CALL delete_event('$event_id')");
        //echo "DELETE FROM `event_calendar` WHERE event_date = " . $eventdate;
        //echo $eventdate;
        echo "<br/><br/><h2>Event was successfully deleted</h2>";
        die();
    }
    else if(isset($_POST['editevent'])){
        
        
        if(empty($_POST['txtTitle'])){
            $errorTitle = "<span class='error'>Please enter event title</span>";
        }
        if(empty($_POST['txtStartDate'])){
            $errorStartDate = "<span class='error'>Please enter start date</span>";
        }
        if(empty($_POST['txtEndDate'])){
            $errorEndDate = "<span class='error'>Please enter end date</span>";
        }
        if(empty($_POST['txtStartTime'])){
            $errorStartTime = "<span class='error'>Please enter start time</span>";
        }
        if(empty($_POST['txtEndTime'])){
            $errorEndTime = "<span class='error'>Please enter end time</span>";
        }
        if(empty($_POST['txtLocation'])){
            $errorLocation = "<span class='error'>Please enter location</span>";
        }
        if(empty($_POST['txtDetail'])){
            $errorDetail = "<span class='error'>Please enter detail</span>";
        }
        if($errorTitle == "" && $errorStartDate == "" && $errorEndDate == "" && $errorStartTime == "" && $errorEndTime == "" && $errorLocation == "" && $errorDetail == ""){
            $title = $_POST['txtTitle'];
            $detail = $_POST['txtDetail'];
            $startDate = $_POST['txtStartDate'];
            $endDate = $_POST['txtEndDate'];
            $startTime = $_POST['txtStartTime'];
            $endTime = $_POST['txtEndTime'];
            $location = $_POST['txtLocation'];
            $event_id = $_GET["event_id"];
            $endDateFormat = multiexplode(array("-", "/"), $endDate);
            $end_date = $endDateFormat[2] . "-" . $endDateFormat[0] . "-" . $endDateFormat[1];
            $startDateFormat = multiexplode(array("-", "/"), $startDate);
            $start_date = $startDateFormat[2] . "-" . $startDateFormat[0] . "-" . $startDateFormat[1];
            //$startdate = $year . "-" . $month . "-" . $day;
            mysqli_query($link, "CALL update_event('$title', '$detail', '$event_id', '$start_date', '$end_date', '$startTime', '$endTime', '$location')");
            //echo "UPDATE event_calendar SET title = '" . $title . "', detail = '" . $detail . "' WHERE event_date = '" . $eventdate . "'"; 
            echo "<br/><br/><h2>Event was successfully Edited<h2>";
            die();
        }
    }
?>
    <table border="1" id='eventTable'>
        <tr class="eventRow">
            <td class="eventData"><input type="button" value='<' name='previousbutton' onclick="goLastMonth(<?php echo $month . ", " . $year?>)"></td>
            <td colspan="5" id="monthYear"><?php echo $monthName . " " . $year;  ?></td>
            <td class="eventData"><input type="button" value='>' name='nextbutton' onclick="goNextMonth(<?php echo $month . ", " . $year?>)"></td>
        </tr>
        <tr class="eventRow">
            <td>Sunday</td>
            <td>Monday</td>
            <td>Tuesday</td>
            <td>Wednesday</td>
            <td>Thursday</td>
            <td>Friday</td>
            <td>Saturday</td>
        </tr>
        <?php
            echo "<tr>";
            
            for($i = 1; $i < $numDays+1; $i++, $counter++){
                $timeStamp = strtotime("$year-$month-$i");
                $firstDay = '';
                //echo $month;
                if($i == 1){
                    $firstDay = date("w", $timeStamp);
                    
                    for($j = 0; $j < $firstDay; $j++, $counter++){
                        echo "<td>&nbsp;</td>";   
                    }
                }
                if($counter % 7 == 0 && $counter != 0){
                    echo "</tr><tr>";
                }
                $monthstring = $month;
                $monthlength = strlen($monthstring);
                $daystring = $i;
                $daylength = strlen($daystring);
                if($monthlength <= 1){
                    $monthstring = "0" . $monthstring;   
                }
                if($daylength <= 1){
                    $daystring = "0" . $daystring;   
                }
                
                $todayDate = date("m/d/Y");
                $dateToCompare = $monthstring . '/' . $daystring . '/' . $year;
                $dateInDB = $year . '-' . $monthstring . '-' . $daystring;
                
                
                
                
                $eventCount = "SELECT * FROM event_calendar WHERE start_date = '" . $dateInDB . "'";   
                $numEvent = mysqli_num_rows(mysqli_query($link, $eventCount));
                
                $eventQuery = "SELECT * FROM event_calendar";
                $result = mysqli_query($link, $eventQuery);
                $result2 = mysqli_query($link, $eventQuery);
            
                echo "<td";
                
                if($todayDate == $dateToCompare){
                    echo " class='today'";   
                }
                else if($numEvent >= 1){
                    echo " class='event'";   
                }
                else{
                    echo " class='days'";   
                }
                
                if(has_access($user_data["job_code"]) == true){
                    echo "><a href='" . $_SERVER['PHP_SELF'] . "?month=" . $monthstring . "&day=" . $daystring . "&year=" . $year . "&v=true'>" . $i . "</a>";
                }
                else{
                    echo ">" . $i;
                }
                
                echo "<br/><br/>";
                $count = 1;
                while($row = mysqli_fetch_assoc($result)){
                    $start_date = date("Y-m-d", strtotime($row['start_date']));
                    //echo strtotime($start_date);
                    $end_date = date("Y-m-d", strtotime($row['end_date']));
                    
                    //echo $start_date . " " . $end_date;
                    //echo $row["event_id"];
                    //echo strtotime($start_date) <= strtotime($end_date);
                    if(strtotime($dateInDB) <= strtotime($end_date) && strtotime($dateInDB) >= strtotime($start_date)){
                        //echo $row["event_id"];
                        //echo strtotime($start_date) <= strtotime($end_date);
                        
                        echo "<span class='event'>" . $count . ". <a href='" . $_SERVER['PHP_SELF'] . '?month=' . $monthstring . '&day=' . $daystring . '&year=' . $year . "&event_id=" . $row["event_id"] . "&e=true' class='popper' data-popbox='pop" . $row["event_id"] . "'>" .  $row["title"] . "</a></span>";
                        
                        echo "<div id='pop" . $row["event_id"] . "' class='popbox'><h2>" . $row["title"] . "</a></h2> (<em>";
                        
                        
                        if($row["start_date"] == $row["end_date"]){
                            echo date("l, F j, Y", strtotime($row["start_date"]));  
                        }
                        else{
                            echo date("l, F j, Y", strtotime($row["start_date"])) . " - " . date("l, F j, Y", strtotime($row["end_date"])); 
                        }
                            
                        echo " @ " . $row["start_time"] . "-" . $row["end_time"] . "</em>)";
                        echo "<br/>Location: <strong>" . $row["location"] . "</strong><br/><br/><p>" . $row["detail"] . "</p></div>";
                        //echo "<br/><div class='eventDate'><p class='event_info' onmouseover='hoverThis()'>" . $row['title'] . "</p><div class='eventHover'>" . $row["detail"] . "</div>" . "</div>";
                        //break;  
                        echo "<br/>";
                        
                        $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                        //echo $start_date;
                        $count++;
                        
                    }
                }
                
                echo "</td>";
            }
            echo "</tr>";
        ?>

    </table>

    <?php
        if(isset($_GET['v'])){ 
            echo "<span><strong>" . $month . "/" . $day . "/" . $year . "</strong></span><br/>";
            include("event_form.php");
        }
        else if(isset($_GET['e'])){
            $eventQuery = "SELECT * FROM event_calendar";
            $result = mysqli_query($link, $eventQuery);
            $dateEvent = $year . "-" . $month . "-" . $day;
            
            while($row = mysqli_fetch_assoc($result)){
                if($_GET["event_id"] == $row['event_id']){
                    include("event_edit.php");   
                }
            }
        }
    ?>

    <script>
        $(function() {
            var moveLeft = 0;
            var moveDown = 0;
            $('a.popper').hover(function(e) {
                var target = '#' + ($(this).attr('data-popbox'));

                $(target).show();
                moveLeft = $(this).outerWidth();
                moveDown = ($(target).outerHeight() / 2);
            }, function() {
                var target = '#' + ($(this).attr('data-popbox'));
                $(target).hide();
            });

            $('a.popper').mousemove(function(e) {
                var target = '#' + ($(this).attr('data-popbox'));

                leftD = e.pageX + parseInt(moveLeft);
                maxRight = leftD + $(target).outerWidth();
                windowLeft = $(window).width() - 40;
                windowRight = 0;
                maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 20);

                if(maxRight > windowLeft && maxLeft > windowRight)
                {
                    leftD = maxLeft;
                }

                topD = e.pageY - parseInt(moveDown);
                maxBottom = parseInt(e.pageY + parseInt(moveDown) + 20);
                windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
                maxTop = topD;
                windowTop = parseInt($(document).scrollTop());
                if(maxBottom > windowBottom)
                {
                    topD = windowBottom - $(target).outerHeight() - 20;
                } else if(maxTop < windowTop){
                    topD = windowTop + 20;
                }

                $(target).css('top', topD).css('left', leftD);
            });
        });
    </script>

<?php
    include("../assets/inc/footer.inc.php");
?>