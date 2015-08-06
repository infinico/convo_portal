                <div class="widget">    <!-- Widget -->
                    <div class="inner"> <!-- Inner -->
                        <form action="login.php" method="post" id="loginBox">
                            <ul id="login">
                                <li>
                                    <input type="text" name="username" placeholder="Username" <?php if(isset($_COOKIE['username'])){echo "value ='" . $_COOKIE['username'] . "'";} ?>>
                                </li>
                                <li>
                                    <input type="password" name="password" placeholder="Password" <?php if(isset($_COOKIE['password'])){echo "value ='" . $_COOKIE['password'] . "'";} ?>>
                                </li>
                                <li>
                                    <input type="submit" value="Login" id="logIn" name="login">
                                </li>
                                <li id="rememberBox">
                                    <input type="checkbox" value="RememberMe" id="remBox" name="remBox">Remember Me
                                </li>
                                
                                <li>
                                    <div id="account"><a href="<?php echo $linkToALL; ?>/register.php" >Don't have an account? Register</a></div>
                                </li>
                                
                                <li><div class="forget">Forgot your <a href="recover.php?mode=username">username</a> or  <a href="recover.php?mode=password">password</a>?</div></li>
                            </ul>
                        </form>
                    </div>  <!-- Inner // -->
                </div>  <!-- Widget //-->