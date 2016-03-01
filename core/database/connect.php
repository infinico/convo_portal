<?php
    $db_host = "localhost";
    $db_user = "webuser";
    $db_pass = "DBacce$$";
    $db_name = "convotesting";
  
    // Intialize the database connection
    $link = mysqli_connect ($db_host, $db_user, $db_pass, $db_name);
  
    // Verify that we have a valid connection
    if (!$link) {
      echo "Connection Error: " . mysqli_connect_error();
      die();
    }
?>