<div class="widget">
    <h2 id="hello">Hello <?php echo $user_data['firstname']; ?>!</h2>
    <!--<p><?php echo $user_data['employee_id']; ?></h2>-->
    <div class="inner">
        <div id ="statusBox" class="block">
            <ul id = "status_logout">
                <li><a href="<?php echo $linkToALL; ?>/logout.php">Log out</a></li>
                <li><a href="<?php echo $linkToALL; ?>/changepassword.php">Change password</a></li>
                <!--<li><a href="<?php echo $linkToALL; ?>/changeProfilePic.php">Change Profile Picture</a></li>-->

            </ul>
        </div>
    </div>
</div>