<?php
        $employee_id = $user_data["employee_id"];

        $numOfAckPending = mysqli_query($link, "SELECT COUNT('employee_id') FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND date_ack IS NULL ORDER BY date_sent");

        $countNumOfAckPending = mysqli_fetch_array($numOfAckPending);



       $actionNeeded = mysqli_query($link, "SELECT COUNT('employee_id') FROM acknowledgement_vw WHERE employee_id = '" . $employee_id . 
        "' AND date_ack IS NULL ORDER BY date_sent");

        $countNumOfActionNeeded = mysqli_fetch_array($actionNeeded);
                                    
        //$mergeManagerAccess = mysqli_query($link, "SELECT)


?>



<div class="widget">
    <h2 id="hello">Hello <?php echo $user_data['firstname']; ?>!</h2>
    <!--<p><?php echo $user_data['employee_id']; ?></h2>-->
    <div class="inner">
        <div id ="statusBox" class="block">
            <ul id = "status_logout">
                <li><a href="<?php echo $linkToALL; ?>/logout.php">Log out</a></li>
                <li><a href="<?php echo $linkToALL; ?>/changepassword.php">Change password</a></li>
                <li><a href="#">Action Needed: <?php echo $countNumOfActionNeeded[0]; ?></a>
                    <ul>
                        <li><a href="<?php echo $linkToALL; ?>/HR/acknowledgements.php">Pending Acknowledgement: <?php echo $countNumOfAckPending[0]; ?></a></li>
                       <!-- <li><a href="<?php echo $linkToALL; ?>/manageraccess.php">New Hire Start Date: <?php echo $countNumOfAckPending[0]; ?></a></li> -->
                        
                            
                    </ul>   
                </li> 
              <!--  <li><a href="<?php echo $linkToALL; ?>/HR/acknowledgements.php">Acknowledgement Pending: <?php echo $countNumOfAckPending[0]; ?></a></li>
            

                <!--<a>Acknowlegement Pending: </a> -->
                <!--<li><a href="<?php echo $linkToALL; ?>/changeProfilePic.php">Change Profile Picture</a></li>-->

            </ul>
        </div>
    </div>
</div>




