<?php
    /* Environment Variables */
    $_ENV["HOSTNAME"] = "DEMO";
    $linkToALL = "https://www.theinfini.com/portal-demo";
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);

    /* 
        INCOMING CO-OP STUDENT INFORMATION:
        Please change the email address and name for testing.
        The variables are used for email functions (PHPMailer)
        If you have any questions, you can contact Josh at jja4740@rit.edu or Peter at pxy9548@rit.edu
    */
    /*$COOP1Email = 'alw7097@rit.edu';
    $COOP1Name = 'Allison Wong';*/
    $COOP2Email = 'tjt9156@rit.edu';
    $COOP2Name = 'Tiandre Turner';
    $SupervisorCOOPEmail = 'chris@theinfini.com';
    $SupervisorName = 'Chris Campbell';
    
    session_start();
 
    require "database/connect.php";
    require "functions/users.php";
    require "functions/general.php";

    $current_file = explode("/", $_SERVER["SCRIPT_NAME"]);
    $current_file_password = "/convo/" . end($current_file);
    $current_file_employment = "/convo/HR/" . end($current_file);

    if(logged_in() === true) {
        $session_user_id = $_SESSION['emplid'];
        
        $user_data = user_data($session_user_id, 'employee_id', "email", "supervisor_id", 'username', 'password', 'firstname', 'lastname', 'job_code', 'payroll_status', 'location_code', 'res_state', 'password_recover', 'date_of_birth', 'ssn', 'street_address', 'city', 'zipcode', 'job_code', 'hire_date', 'emp_type');
                
        // EMPLOYMENT DATA
        $supervisor_data = supervisor_data($session_user_id, 'employee_id', "supervisor_id", 'firstname', 'lastname');
        
        $position_data = position_data($session_user_id, "employee_id", "job_code");
        if(user_active($user_data["username"]) === false) {
            session_destroy();
            header("Location: index.php");
            exit();
        }

        // This one forces the user to change the password when they click "forget the password"
        if($current_file_password !== "/convo/changepassword.php" && $current_file !== "logout.php" && $user_data["password_recover"] == 1) {
            echo "Location: $linkToALL/changepassword.php?force";
            header("Location: $linkToALL/changepassword.php?force");
            
            exit();
        }
        
        // If the employees don't have email, it is being forced to the employment_data.php and fill out the e-mail address
        if($current_file_employment !== "/convo/HR/employment_data.php" && $current_file !== "logout.php" && $user_data["email"] == NULL) {
            header("Location: $linkToALL/HR/employment_data.php?force");
            exit();
        }
    }
    
    $errors = array();
?>