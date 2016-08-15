<?php
    $db_host = "104.130.32.112";
    $db_user = "webuser";
    $db_pass = "DBacce$$";
    $db_name = "portaldemo";
  
    // Intialize the database connection
    $link = mysqli_connect ($db_host, $db_user, $db_pass, $db_name);
  
    // Verify that we have a valid connection
    if (!$link) {
      echo "Connection Error: " . mysqli_connect_error();
      die();
    }
?>