<?php
    $connect_error = "Sorry, We're experiencing connection problems.";
    mysql_connect("localhost", "root", "mysql#1!") or die($connect_error);
    mysql_select_db("convo") or die(connect_error);
?>

<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "mysql#1!";
    $db_name = "convo";
  
    // Intialize the database connection
    $link = mysqli_connect ($db_host, $db_user, $db_pass, $db_name);
  
    // Verify that we have a valid connection
    if (!$link) {
      echo "Connection Error: " . mysqli_connect_error();
      die();
    }
?>