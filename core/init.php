<?php
    $_ENV["HOSTNAME"] = "TESTING";

    session_start();
 
    require "database/connect.php";
    require "functions/users.php";
    require "functions/general.php";

    $current_file = explode("/", $_SERVER["SCRIPT_NAME"]);
    $current_file = end($current_file);

    if(logged_in() === true) {
        $session_user_id = $_SESSION['employee_id'];
        
        $user_data = user_data($session_user_id, 'employee_id', "email", "supervisor_id", 'username', 'password', 'firstname', 'lastname', 'job_code', 'payroll_status', 'location_code', 'res_state', 'password_recover', 'date_of_birth', 'ssn', 'street_address', 'city', 'zipcode', 'job_code', 'hire_date');
                
        // EMPLOYMENT DATA
        $supervisor_data = supervisor_data($session_user_id, 'employee_id', "supervisor_id", 'firstname', 'lastname');
        
        $position_data = position_data($session_user_id, "employee_id", "job_code");
        if(user_active($user_data["username"]) === false) {
            session_destroy();
            header("Location: index.php");
            exit();
        }

        // This one forces the user to change the password when they click "forget the password"
        if($current_file !== "changepassword.php" && $current_file !== "logout.php" && $user_data["password_recover"] == 1) {
            header("Location: changepassword.php?force");
            exit();
        }
    }
    
    $errors = array();
?>