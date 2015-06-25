<?php
    /*
    * LOGIN FUNCTIONS
    */

    // employee ID from the username will apply to the Login Function below
    function user_id_from_username($username) {
        $username = sanitize($username);
        $query = mysql_query("SELECT employee_id FROM employee WHERE username = '$username'");
        return mysql_result($query, 0, "employee_id");
    }

    function login($username, $password) {
        $user_id = user_id_from_username($username);
        
        $username = sanitize($username);
        $password = md5($password);
        
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE username = '$username' AND password = '$password'");
        
        return(mysql_result($query, 0) == 1) ? $user_id : false;
    }

    function logged_in() {
        return(isset($_SESSION['employee_id'])) ? true : false;   
    }

    // The users are active when they register the usernames
    function user_active($username) {
        $username = sanitize($username);
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE username = '$username' AND active = 1");
        return(mysql_result($query, 0) == 1) ? true : false;      
    }

    function test_employee_id($employeeID){
        $query = mysql_query("SELECT * FROM employee WHERE employee_id = '$employeeID'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }


    /*
    * REGISTRATION FUNCTIONS
    */

    // VERIFY SSN and DOB
    function register_verify_exists($ssn, $dob) {
        $ssn = sanitize($ssn);
        $dob = sanitize($dob);
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE ssn = '$ssn' AND DATE_FORMAT(date_of_birth,'%m-%d-%Y') = '$dob'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    // Register the username
    function register_user($register_data, $ssn, $dob) { 
        array_walk($register_data, "array_sanitize");
        $password = md5($register_data["password"]);
        //$password = $register_data["password"];
        $username = $register_data["username"];
        //$register_data["ssn"] = md5($register_data["ssn"]);
        //$ssn = $register_data["ssn"];
        
        $fields = "" . implode(", ", array_keys($register_data)) . "";
        $data = "\"" . implode("\" , \"", $register_data) . "\"";
        
        mysql_query("UPDATE employee SET username = '$username', password = '$password' WHERE ssn = '$ssn' AND DATE_FORMAT(date_of_birth,'%m-%d-%Y') = '$dob'");

        /*email($register_data["email"], "Activate your account", "
            Hello " . $register_data["firstname"] . ",\n\nYou need to activiate your account, so use the link below:\n\nhttp://localhost/testing/activiate.php?email=" . $register_data["email"] . " &email_code=" . $register_data["email_code"] . "\n\n-Infini Consulting");*/
    }

    /*
    * UPDATE FUNCTIONS
    */

    // Whenever the employees update the information
    function update_user($user_id, $update_data) { 
        $update = array();
        array_walk($update_data, "array_sanitize");

        foreach($update_data as $field => $data) {
            $update[] = "$field = \"$data\"";
        }
        mysql_query("UPDATE employee SET " . implode(", ", $update) . " WHERE employee_id = '$user_id'") or die(mysql_error());
    }

    function change_password($user_id, $password) {
        $user_id = $user_id;
        //setcookie("password", $password, time() + 7200);
        $password = md5($password); 
        mysql_query("UPDATE employee SET password = '$password', password_recover = 0 WHERE employee_id = '$user_id'");    
    }

    /*
    * ACCESS FUNCTIONS
    */

    // Employee Page - Access for Hire and Changes(Terminations)
    function has_access($job_code) {
        $job_code = $job_code;
        //$type = (int)$type;
        
        $query = mysql_query("SELECT COUNT('job_code') FROM position_type WHERE job_code = '$job_code' AND admin_privilege = '1'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }

    // Manager Access - Links buttons visible and unvisible if they are not manager.
    function has_access_manager($job_code) {
        $job_code = $job_code;    
        $query = mysql_query("SELECT COUNT('job_code') FROM position_type WHERE job_code = '$job_code' AND manager_privilege = '1'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }

    //Interpreting Department Access - everyone in this department have access.
    function has_access_interpreting($job_code){
        $query = mysql_query("SELECT COUNT('job_code') FROM position_type WHERE job_code = '$job_code' AND dept_code = 'INT'");
        return (mysql_result($query, 0) == 1) ? true: false;
    }

    function has_access_support($job_code){
        $query = mysql_query("SELECT COUNT('job_code') FROM position_type WHERE job_code = '$job_code' AND dept_code = 'SUP'");
        return (mysql_result($query, 0) == 1) ? true: false;
    }

    // Policy Access allows to see the links depending on the positions.
    /*function policy_access($user_id, $position) {
        $user_id = $user_id;
        
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE employee_id = '$user_id' AND position_name = '$position'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }*/

    // Employee's information
    function user_data($user_id) {
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "" . implode(", ", $func_get_args) . "";
            $query = mysql_query("SELECT $fields FROM employee WHERE employee_id = '$user_id'");
            //$result = mysql_result($link, $query);
            $data = mysql_fetch_assoc($query);
            
            return $data;
        }
    }

    /*
    * CENSUS DATA FUNCTIONS 
    */

    // Census Access for the full-time employees only.
    function has_access_census($user_id) {
        $user_id = $user_id;    
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE employee_id = '$user_id' AND payroll_status = 'FT'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }

    // Census Data collects the employees' information from the database.
    function census_data($user_id) {
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "" . implode(", ", $func_get_args) . "";
            $query = mysql_query("SELECT $fields FROM employee WHERE employee_id = '$user_id'");
            //$result = mysql_result($link, $query);
            $data = mysql_fetch_assoc($query);
            
            return $data;
        }
    }

    /*
    * DATA FUNCTIONS
    */

    // Supervisor Name function to get the employee's name
    function supervisor_name($user_id, $supervisor_id) {
        $user_id = $user_id;
        
        $query = mysql_query("SELECT COUNT('supervisor_id') FROM employee WHERE employee_id = '$user_id' AND supervisor_id = '$supervisor_id'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }

    // Supervisor Data - get the information from the supervisors
    function supervisor_data($user_id) {
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "s." . implode(", s.", $func_get_args) . "";
            $query = mysql_query("SELECT $fields FROM employee s INNER JOIN employee e ON s.employee_id = e.supervisor_id WHERE e.employee_id = '$user_id'");
            $data = mysql_fetch_assoc($query);
            
            return $data;
        }
    }

 // Position Data
    function position_data($user_id) {
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "e." . implode(", e.", $func_get_args) . "";
            $query = mysql_query("SELECT $fields, p.position_name FROM employee e INNER JOIN position_type p ON e.job_code = p.job_code WHERE e.employee_id = '$user_id'");
            $data = mysql_fetch_assoc($query);
            
            return $data;
        }
    }

    
    /*
    * EXIST FUNCTIONS
    */

    // User Exists - can't have twice same username and must be unique
    function user_exists($username) {
        $username = sanitize($username);
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE username = '$username'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    // Employee ID Exists - must be unique and can't be same employeeID
    function employee_id_exists($employee_id) {
        $employee_id = sanitize($employee_id);
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE employee_id = '$employee_id'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    //Position Name Exists - can't be same position name (Under Add DB Values)
    function position_name_exists($positionName) {
        $positionName = sanitize($positionName);
        $query = mysql_query("SELECT COUNT('position_name') FROM position_type WHERE position_name = '$positionName'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }
    //Department Name Exists - can't be same department name (Under Add DB Values)
    function department_name_exists($departmentName) {
        $departmentName = sanitize($departmentName);
        $query = mysql_query("SELECT COUNT('department_name') FROM department WHERE department_name = '$departmentName'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    //Convo Location Exists - can't be same convo location (Under Add DB Values)
    function convo_location_exists($convoLocation) {
        $convoLocation = sanitize($convoLocation);
        $query = mysql_query("SELECT COUNT('location_code') FROM location WHERE convo_location = '$convoLocation'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }
    
    //Job Code Exists - can't be same job code (Under Add DB Values)
    function job_code_exists($jobCode) {
        $jobCode = sanitize($jobCode);
        $query = mysql_query("SELECT COUNT('job_code') FROM position_type WHERE job_code = '$jobCode'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    //Department Code Exists - can't be same department code (Under Add DB Values)
    function department_code_exists($deptCode) {
        $deptCode = sanitize($deptCode);
        $query = mysql_query("SELECT COUNT('dept_code') FROM department WHERE dept_code = '$deptCode'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }
    //Convo Location Code Exists - can't be same convo location code (Under Add DB Values)
    function convo_location_code_exists($locationCode) {
        $locationCode = sanitize($locationCode);
        $query = mysql_query("SELECT COUNT('location_code') FROM location WHERE location_code = '$locationCode'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }

    /*
    * EMAIL FUNCTIONS
    */

    function newEmail($email, $firstname, $lastname, $subjectHeader, $bodyMessage){
        // CONTACT FORM
        if(isset($_POST["submitContact"])){
            $to = $email;
            $subject = "CONVO Portal - Automatic Response: " . $subjectHeader;
            $message .= "Hello " . $firstname . ", \n\n";
            $message .= "Thank you for e-mailing CONVO Human Resources.  We will try to do our best to respond to your e-mail as soon as possible.  You can expect a response within two business days.\n\n";
            $message .= "Your message was sent to Human Resources:\n\n";
            $message .= "\"" . $bodyMessage . "\"\n\n";
            $message .= "If you have any questions, please contact CONVO Human Resources at HR@convorelay.com.\n\n";
            $message .= "CONVO Human Resources\n";
            $message .= "Email:  HR@convorelay.com";
            $headers .= "From: CONVO Portal<pxy9548@rit.edu>\r\n";

            @mail($to, $subject, $message, $headers);
            //$emailStatus = "Mail sent"; 


            if($_ENV["HOSTNAME"] = "TESTING"){
                $to2 = 'pxy9548@rit.edu';
                $subject2 = 'Convo - ' . $subjectHeader . ' TESTING'; 
            }
            else if($_ENV["HOSTNAME"] = "DEVELOPING"){
                $to2 = 'jja4740@rit.edu';
                $subject2 = 'Convo - ' . $subjectHeader . ' DEVELOPING'; 
            }


            $message2 .= "Hello HR,\n\n";
            $message2 .= $bodyMessage . "\n\n";
            $message2 .= $firstname . " " . $lastname;
            $headers2 .= "From: " . $firstname . " " . $lastname . "<" . $email . ">\r\n";
            $headers2 .= "CC: jja4740@rit.edu, pxy9548@rit.edu\r\n"; 
            @mail($to2, $subject2, $message2, $headers2);
        }
        // ONBOARDING
        else if(isset($_POST["submitNewHire"])){
            
            $to = $email;
            $subject = $subjectHeader;  // Subject is New Hired Employee
            $message .= "<p>Dear " . $firstname . ",</p>";
            $message .= "<p>Thank you for submitting your New Employee Onboarding information!  We have the following information:</p>";
            $message .= $bodyMessage . "\n\n";
            $message .= "<h2>Information Needed for Background Check<strong></h2>";
            $message .= "<p>First, please scan a copy of your Social Security Card and Driver's License (or state-issued ID card). You may email this to hr@convorelay.com. To expedite processing, please do this at your earliest convenience.</p>";
            $message .= "<h2>New Hire Paperwork</h2>";
            $message .= "<p>Please complete the new hire packet before your first day of work.  This packet can be found here: <a href='https://test.theinfini.com/convo/Convo%20New%20Hire%20Packet%20-%20FT.pdf'>Convo New Hire Packet</a>.  When completed, please scan and send this to hr@convorelay.com.</p>";
            $message .= "<p>Questions?</p>";
            $message .= "<p>Please contact your to-be supervisor or HR if you have any questions.</p>";
            $message .= "<p>We look forward to working with you!</p>";
            $message .= "<p>Sincerely,</p>";
            $message .= "<p>The Convo HR Team</p>";
            //$message .= "CONVO Human Resources\n";
            //$message .= "Email:  HR@convorelay.com";
            $headers .= "From: CONVO Portal<pxy9548@rit.edu>\r\n";
            $headers .= "CC: jja4740@rit.edu, pxy9548@rit.edu, chris@theinfini.com\r\n"; 
            
            // Convert text into HTML
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;\r\n";
            
            //$filename = "<a href='HR\401K\EmployeeFAQ.pdf'>Background Check Form</a>";
            
            if($_ENV["HOSTNAME"] = "TESTING"){
                $to = 'pxy9548@rit.edu';
                $subject = $subjectHeader . ' - TESTING'; 
            }
            else if($_ENV["HOSTNAME"] = "DEVELOPING"){
                $to = 'jja4740@rit.edu';
                $subject = $subjectHeader . ' - DEVELOPING'; 
            }
        
            mail($to, $subject, $message, $headers); 
        }
        // FMLA REQUEST
        else if(isset($_POST["submitRequest"])){
            $to = $email;
            $subject = $subjectHeader;
            $message .= "<p>Dear " . $firstname . ",</p>";
            $message .= "<p>Thank you for submitting your Family Medical Leave Request Form!  We have the following information: </p>";
            $message .= $bodyMessage . "\n\n";
            $message .= "<p>Test Test Test</p>";
            $message .= "<p>Please contact your manager or HR if you have any questions.</p>";
            $message .= "<p>Sincerely,</p>";
            $message .= "<p>CONVO Team</p>";
            $headers .= "From: CONVO Portal<pxy9548@rit.edu>\r\n";
            $headers .= "CC: jja4740@rit.edu, pxy9548@rit.edu, chris@theinfini.com\r\n"; 
            
            // Convert text into HTML
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;\r\n";
            mail($to, $subject, $message, $headers); 
        }
    }


    


/*
    function user_id_from_email($email) {
        $email= sanitize($email);
        $query = mysql_query("SELECT employee_id FROM employee WHERE email = '$email'");
        return mysql_result($query, 0, "employee_id");
    }
    
    function recover($mode, $email) {
        $mode = sanitize($mode);
        $email = sanitize($email);

        $user_data = user_data(user_id_from_email($email), "employee_id", "firstname", "username");

        if($mode == "username") {
            // Recover username
            email($email, "Your username", "Hello " . $user_data["firstname"] . "\n\nYour username is: " . $user_data["username"] . "\n\n -Infini Consulting");
        }
        else if($mode == "password") {
            // Recover password
            $generated_password = substr(md5(rand(999, 999999)), 0, 8);
            //die($generated_password);
            change_password($user_data["employee_id"], $generated_password);

            update_user($user_data["employee_id"], array("password_recover" => "1"));

            email($email, "Your password recovery", "Hello " . $user_data["firstname"] . "\n\nYour new password is: " . $generated_password . "\n\n -Infini Consulting");

        }
    }
    
    function email_exists($email) {
        $emil= sanitize($email);
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE email = '$email'");
        return(mysql_result($query, 0) == 1) ? true : false;
    }
    
    function activate($email, $email_code) {
        $email      = mysql_real_escape_string($email);
        $email_code = mysql_real_escape_string($email_code);
        $query  = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE email = '$email' AND email_code = '$email_code' AND active = 0");
        if(mysql_result($query, 0) == 1) {
            // query to update user active status
            mysql_query("UPDATE employee SET active = 1 WHERE email = '$email'");
            return true;
        }
        else {
            return false;
        }

    }
*/
?>