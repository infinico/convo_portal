<?php
        $employee_id = $user_data["employee_id"];
        
        //acknowledgement
        $numOfAckPending = mysqli_query($link, "SELECT COUNT('employee_id') FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND date_ack IS NULL ORDER BY date_sent");
        $countNumOfAckPending = mysqli_fetch_array($numOfAckPending);




        // manager acces
        /*$managerAccess = mysqli_query($link, "SELECT COUNT('employee_id) FROM employee_vw UNION neo_tracking_vw ON employee_vw.employee_id = neo_tracking_vw.employee_id");
        $countManagerAccess = mysqli_fetch_array($managerAccess); */




        // counts the number of 'action needed' 
       $actionNeeded = mysqli_query($link, "SELECT COUNT('employee_id') FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND date_ack IS NULL ORDER BY date_sent");
        $countNumOfActionNeeded = mysqli_fetch_array($actionNeeded);
        

?>



<div class="widget">
    <h2 id="hello">Hello <?php echo $user_data['firstname']; ?>!</h2>
    <!--<p><?php echo $user_data['employee_id']; ?></h2>-->
    <div class="inner">
        <div id ="statusBox" class="block">
            <ul id = "status_logout">
                <li><a href="<?php echo $linkToALL; ?>/logout.php">Log out</a></li>
                <li><a href="<?php echo $linkToALL; ?>/changepassword.php">Change password</a></li>
                <li>
                    
            <?php

                if($countNumOfActionNeeded[0] != 0)
                {
                    
                    echo "<a href='#'>Action Needed: " . $countNumOfActionNeeded[0] . "</a>" .
                        "<ul><li><a href='" . $linkToALL . "/HR/acknowledgements.php'>Pending Acknowledgement:" . $countNumOfAckPending[0] . 
                        "</a></li></ul>";
                    
                }
                else
                {
                echo "Action Needed: 0";
                }
                
                ?>
   
                </li> 
              <!--  <li><a href="<?php echo $linkToALL; ?>/HR/acknowledgements.php">Acknowledgement Pending: <?php echo $countManagerAccess[0]; ?></a></li>
            

                <!--<a>Acknowlegement Pending: </a> -->
                <!--<li><a href="<?php echo $linkToALL; ?>/changeProfilePic.php">Change Profile Picture</a></li>-->

            </ul>
        </div>
    </div>
</div>




