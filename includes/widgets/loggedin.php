                <div class="widget">
                    <h2 id="hello">Hello <?php echo $user_data['firstname']; ?>!</h2>
                    <div class="inner">
                        <div id ="statusBox" class="block">
                            <ul id = "status_logout">
                                <li><a href="<?php echo $linkToALL; ?>/logout.php">Log out</a></li>
                                <li><a href="<?php echo $linkToALL; ?>/changepassword.php">Change password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>