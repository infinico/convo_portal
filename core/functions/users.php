<?php
    /*
    * LOGIN FUNCTIONS
    */

    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    // employee ID from the username will apply to the Login Function below
    function user_id_from_username($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE username = '$username'");
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                return $row["employee_id"];   
            }
            else {
                sendErrorEmail($link);
                return false;   
            }
        }
    }

    function login($username, $password) {
        global $link;
        $user_id = user_id_from_username($username);
        
        $username = sanitize($username);
        $password = md5($password);
        
        $sql = "SELECT employee_id FROM employee_vw WHERE username = '$username' AND password = '$password'";
        $query = mysqli_query($link, $sql);
        
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                //echo "Login Successful";
                return $user_id;   
            }
            else {
                sendErrorEmail($link);
                return false;   
            }
        }
    }

    function logged_in() {
        return(isset($_SESSION['emplid'])) ? true : false;   
    }

    // The users are active when they register the usernames
    function user_active($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE username = '$username' AND active = 1");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            sendErrorEmail($link);
            return false;   
        }
    }

    function test_employee_id($employeeID){
        global $link;
        $query = mysqli_query($link, "SELECT * FROM employee_vw WHERE employee_id = $employeeID");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            sendErrorEmail($link);
            return false;   
        }
    }


    /*
    * REGISTRATION FUNCTIONS
    */

    // VERIFY SSN and DOB
    function register_verify_exists($ssn, $dob) {
        global $link;
        $ssn = sanitize($ssn);
        $dob = sanitize($dob);
        $dob = str_replace("/","-",$dob);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE ssn = '$ssn' AND DATE_FORMAT(date_of_birth, '%m-%d-%Y') = '$dob'");
        
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            sendErrorEmail($link);
            return false;   
        }
    }

    // Register the username
    function register_user($register_data, $ssn, $dob) {
        global $link;
        array_walk($register_data, "array_sanitize");
        $password = md5($register_data["password"]);
        //$password = $register_data["password"];
        $username = $register_data["username"];
        //$register_data["ssn"] = md5($register_data["ssn"]);
        //$ssn = $register_data["ssn"];
        $dob = str_replace("/","-",$dob);
        
        
        $fields = "" . implode(", ", array_keys($register_data)) . "";
        $data = "\"" . implode("\" , \"", $register_data) . "\"";
        mysqli_query($link, "CALL register_user('$username','$password','$ssn','$dob')") or sendErrorEmail($link);


        /*email($register_data["email"], "Activate your account", "
            Hello " . $register_data["firstname"] . ",\n\nYou need to activiate your account, so use the link below:\n\nhttp://localhost/testing/activiate.php?email=" . $register_data["email"] . " &email_code=" . $register_data["email_code"] . "\n\n-Infini Consulting");*/
    }

    /*
    * UPDATE FUNCTIONS
    */

    // Whenever the employees update the information
    function update_user($user_id, $update_data) { 
        global $link;
        $update = array();
        array_walk($update_data, "array_sanitize");

        foreach($update_data as $field => $data) {
            $update[] = "$data";
        }
        $recover = implode($update);        
        //mysqli_query($link, "CALL update_user($user_id, $recover)") or die(mysqli_error($link));
        mysqli_query($link, "CALL update_user($user_id, $recover)") or sendErrorEmail($link);


    }

    function change_password($user_id, $password) {
        global $link;
        $user_id = $user_id;
        //setcookie("password", $password, time() + 7200);
        $password = md5($password);
        mysqli_query($link, "CALL update_password($user_id, '$password')") or sendErrorEmail($link);    
    }

    /*
    * ACCESS FUNCTIONS
    */

    // Employee Page - Access for Hire and Changes(Terminations)
    function has_access($job_code) {
        global $link;
        $job_code = $job_code;
        //$type = (int)$type;
        
        $query = mysqli_query($link, "SELECT job_code FROM position_vw WHERE job_code = '$job_code' AND admin_privilege = '1'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            //sendErrorEmail($link);
            return false;   
        }
    }

    // Manager Access - Links buttons visible and unvisible if they are not manager.
    function has_access_manager($job_code) {
        global $link;
        $job_code = $job_code;    
        $query = mysqli_query($link, "SELECT job_code FROM position_vw WHERE job_code = '$job_code' AND manager_privilege = '1'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            //sendErrorEmail($link);
            return false;   
        }
    }

    //Interpreting Department Access - everyone in Interpreting and Operations have access.
    function has_access_interpreting($job_code){
        global $link;
        $query = mysqli_query($link, "SELECT job_code FROM position_vw WHERE job_code = '$job_code' AND dept_code IN('INT','OPS')");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            //sendErrorEmail($link); // THIS IS THE PROBLEM
            return false;   
        }
    }

    function has_access_support($job_code){
        global $link;
        $query = mysqli_query($link, "SELECT job_code FROM position_vw WHERE job_code = '$job_code' AND dept_code = 'SUP'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            //sendErrorEmail($link);
            return false;   
        }
    }

    // Policy Access allows to see the links depending on the positions.
    /*function policy_access($user_id, $position) {
        $user_id = $user_id;
        
        $query = mysql_query("SELECT COUNT('employee_id') FROM employee WHERE employee_id = '$user_id' AND position_name = '$position'");
        return (mysql_result($query, 0) == 1) ? true : false;
    }*/

    // Employee's information
    function user_data($user_id) {
        global $link;
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "" . implode(", ", $func_get_args) . "";
            
            $sql = "SELECT $fields FROM employee_vw WHERE employee_id = $user_id";
            $query = mysqli_query($link, $sql) or sendErrorEmail($link);
            //$result = mysql_result($link, $query);
            $data = mysqli_fetch_assoc($query);
            
            return $data;
        }
    }

    /*
    * CENSUS DATA FUNCTIONS 
    */

    // Census Access for the full-time employees only.
    /*function has_access_census($user_id) {
        global $link;
        $user_id = $user_id;   
        $sql = "SELECT employee_id FROM employee_vw WHERE employee_id = $user_id AND payroll_status = 'FT'";
        echo $sql;
        $query = mysqli_query($link, $sql);
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }*/

    // Census Data collects the employees' information from the database.
    function census_data($user_id) {
        global $link;
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "" . implode(", ", $func_get_args) . "";
            $query = mysqli_query($link, "SELECT $fields FROM employee_vw WHERE employee_id = $user_id") or sendErrorEmail($link);
            //$result = mysql_result($link, $query);
            $data = mysqli_fetch_assoc($query);
            
            return $data;
        }
    }

    /*
    * DATA FUNCTIONS
    */

    // Supervisor Name function to get the employee's name
    function supervisor_name($user_id, $supervisor_id) {
        global $link;
        $user_id = $user_id;
        
        $query = mysqli_query($link, "SELECT COUNT('supervisor_id') FROM employee_vw WHERE employee_id = $user_id AND supervisor_id = '$supervisor_id'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    // Supervisor Data - get the information from the supervisors
    function supervisor_data($user_id) {
        global $link;
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "s." . implode(", s.", $func_get_args) . "";
            $query = mysqli_query($link, "SELECT $fields FROM employee_vw s INNER JOIN employee_vw e ON s.employee_id = e.supervisor_id WHERE e.employee_id = $user_id") ; //sendErrorEmail($link);
            $data = mysqli_fetch_assoc($query);
            
            return $data;
        }
    }

 // Position Data
    function position_data($user_id) {
        global $link;
        $data = array();
        $user_id = $user_id;
        
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();
        
        if($func_num_args > 1) {
            unset($func_get_args[0]);
            
            $fields = "e." . implode(", e.", $func_get_args) . "";
            $query = mysqli_query($link, "SELECT $fields, p.position_name FROM employee_vw e INNER JOIN position_vw p ON e.job_code = p.job_code WHERE e.employee_id = $user_id") ; //sendErrorEmail($link);
            $data = mysqli_fetch_assoc($query);
            
            return $data;
        }
    }

    
    /*
    * EXIST FUNCTIONS
    */

    // User Exists - can't have twice same username and must be unique
    function user_exists($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE username = '$username'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    // User Terminated - user has been terminated and is no longer given access
    function user_terminated($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE username = '$username' AND employment_status = 'Terminated'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    function logout_user() {
        return(isset($_SESSION['emplid'])) ? true : false;   
    }

    // Employee ID Exists - must be unique and can't be same employeeID
    function employee_id_exists($employee_id) {
        global $link;
        $employee_id = sanitize($employee_id);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE employee_id = $employee_id");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    //Position Name Exists - can't be same position name (Under Add DB Values)
    function position_name_exists($positionName) {
        global $link;
        $positionName = sanitize($positionName);
        $query = mysqli_query($link, "SELECT position_name FROM position_vw WHERE position_name = '$positionName'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }
    //Department Name Exists - can't be same department name (Under Add DB Values)
    function department_name_exists($departmentName) {
        global $link;
        $departmentName = sanitize($departmentName);
        $query = mysqli_query($link, "SELECT department_name FROM department_vw WHERE department_name = '$departmentName'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    //Convo Location Exists - can't be same convo location (Under Add DB Values)
    function convo_location_exists($convoLocation) {
        global $link;
        $convoLocation = sanitize($convoLocation);
        $query = mysqli_query("SELECT location_code FROM location_vw WHERE convo_location = '$convoLocation'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }
    
    //Job Code Exists - can't be same job code (Under Add DB Values)
    function job_code_exists($jobCode) {
        global $link;
        $jobCode = sanitize($jobCode);
        $query = mysqli_query($link, "SELECT job_code FROM position_vw WHERE job_code = '$jobCode'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    //Department Code Exists - can't be same department code (Under Add DB Values)
    function department_code_exists($deptCode) {
        global $link;
        $deptCode = sanitize($deptCode);
        $query = mysqli_query($link, "SELECT dept_code FROM department_vw WHERE dept_code = '$deptCode'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }
    //Convo Location Code Exists - can't be same convo location code (Under Add DB Values)
    function convo_location_code_exists($locationCode) {
        global $link;
        $locationCode = sanitize($locationCode);
        $query = mysqli_query($link, "SELECT location_code FROM location_vw WHERE location_code = '$locationCode'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    /*
    * EMAIL FUNCTIONS
    */

    function newEmail($email, $firstname, $lastname, $subjectHeader, $bodyMessage){
        
        //global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
        
            
        // TRAVEL REQUEST FORM
        if(isset($_POST["submit"])){
            
        //    $mail = new PHPMailer;
        
        //    $mail->SMTPAuth = true;

        //    $mail->Host = 'smtp.gmail.com';
        //    $mail->Username = 'convoportal@gmail.com';
        //    $mail->Password = 'ConvoPortal#1!';
        //    $mail->STMPSecure = 'ssl';
        //    $mail->Port = 465;

        //    $mail->From = 'alw7097@rit.edu';
        //    $mail->FromName = 'Convo Portal';
        //    $mail->AddAddress = $email;
        //    $mail->AddCC($COOP1Email, $COOP1Name);
        //    /*$mail->AddCC($COOP2Email, $COOP2Name);*/
        //    $mail->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
            $message = "Hello " . $firstname . ", \n\n";
            $message .= "<p>Thank you for e-mailing CONVO Human Resources.  We will try to do our best to respond to your e-mail as soon as possible.  You can expect a response within two business days.</p>";
            $message .= "<p>Your message was sent to Human Resources:</p>";
            $message .= "<p>\"" . $bodyMessage . "\"</p>";
            $message .= "<p>If you have any questions, please contact CONVO Human Resources at HR@convorelay.com.</p>";
            $message .= "<p>CONVO Human Resources</p>";
            $message .= "<p>Email:  HR@convorelay.com</p>";

            if($_ENV["HOSTNAME"] == "PRODUCTION"){
                $subject = "CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO"){
                $subject = "DEMO - CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "TESTING"){
                $subject = "TESTING - CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            
            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    //$to = 'pxy9548@rit.edu';
            //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . " - TESTING"; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    //$to = 'jja4740@rit.edu';
            //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . ' - DEVELOPING'; 
            //}

        sendEmail($email, $subject, $message, $bodyMessage);
        //    $mail->Subject = $subject;
        //    $mail->Body = $message;
        //    $mail->AltBody = $bodyMessage;

        //    $mail->send();
            
            
            
        //    $receiver = new PHPMailer;
        
        //    $receiver->SMTPAuth = true;

        //    $receiver->Host = 'smtp.gmail.com';
        //    $receiver->Username = 'convoportal@gmail.com';
        //    $receiver->Password = 'ConvoPortal#1!';
        //    $receiver->STMPSecure = 'ssl';
        //    $receiver->Port = 465;

        //    $receiver->From = $email;
        //    $receiver->FromName = $firstname . " " . $lastname;
        //    $receiver->AddAddress = 'alw7097@rit.edu';
        //    $receiver->AddCC($COOP1Email, $COOP1Name);
        //    /*$receiver->AddCC($COOP2Email, $COOP2Name); */
        //    $receiver->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
            $message2 = "<p>Hello HR,</p>";
            $message2 .= "<p>" . $bodyMessage . "</p>";
            $message2 .= "<p>" . $firstname . " " . $lastname . "</p>";

            if($_ENV["HOSTNAME"] == "PRODUCTION"){
                $subject = "Convo - Automatic Response: " . $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO"){
                $subject = "DEMO - Convo - Automatic Response: " . $subjectHeader;
            }
            else{
                $subject = "TESTING - Convo - Automatic Response: " . $subjectHeader;
            }
            
            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    $subject2 = 'Convo - ' . $subjectHeader . ' TESTING'; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    $subject2 = 'Convo - ' . $subjectHeader . ' DEVELOPING'; 
            //}

        sendEmail($email, $subject2, $message2, $bodyMessage);
        //    $receiver->Subject = $subject2;
        //    $receiver->Body = $message2;
        //    $receiver->AltBody = $bodyMessage;

        //    $receiver->send();
        }
        
        // CONTACT FORM
        if(isset($_POST["submitContact"])){
            
            //$mail = new PHPMailer;
        
            //$mail->SMTPAuth = true;

            //$mail->Host = 'smtp.gmail.com';
            //$mail->Username = 'convoportal@gmail.com';
            //$mail->Password = 'ConvoPortal#1!';
            //$mail->STMPSecure = 'ssl';
            //$mail->Port = 465;

            //$mail->From = 'alw7097@rit.edu';
            //$mail->FromName = 'Convo Portal';
            //$mail->AddAddress = $email;
            //$mail->AddCC($COOP1Email, $COOP1Name);
            ///*$mail->AddCC($COOP2Email, $COOP2Name);*/
            //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
            $message = "Hello " . $firstname . ", \n\n";
            $message .= "<p>Thank you for e-mailing CONVO Human Resources.  We will try to do our best to respond to your e-mail as soon as possible.  You can expect a response within two business days.</p>";
            $message .= "<p>Your message was sent to Human Resources:</p>";
            $message .= "<p>\"" . $bodyMessage . "\"</p>";
            $message .= "<p>If you have any questions, please contact CONVO Human Resources at HR@convorelay.com.</p>";
            $message .= "<p>CONVO Human Resources</p>";
            $message .= "<p>Email:  HR@convorelay.com</p>";

            if($_ENV["HOSTNAME"] == "PRODUCTION"){
                $subject = "CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO"){
                $subject = "DEMO - CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            else{
                $subject = "TESTING - CONVO Portal - Automatic Response: " . $subjectHeader;
            }
            
            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    //$to = 'pxy9548@rit.edu';
            //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . " - TESTING"; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    //$to = 'jja4740@rit.edu';
            //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . ' - DEVELOPING'; 
            //}

            sendEmail($email, $subject, $message, $bodyMessage);
            //$mail->Subject = $subject;
            //$mail->Body = $message;
            //$mail->AltBody = $bodyMessage;

            //$mail->send();
            
            
            
            //$receiver = new PHPMailer;
        
            //$receiver->SMTPAuth = true;

            //$receiver->Host = 'smtp.gmail.com';
            //$receiver->Username = 'convoportal@gmail.com';
            //$receiver->Password = 'ConvoPortal#1!';
            //$receiver->STMPSecure = 'ssl';
            //$receiver->Port = 465;

            //$receiver->From = $email;
            //$receiver->FromName = $firstname . " " . $lastname;
            //$receiver->AddAddress = 'alw7097@rit.edu';
            //$receiver->AddCC($COOP1Email, $COOP1Name);
            ///*$receiver->AddCC($COOP2Email, $COOP2Name); */
            //$receiver->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
            $message2 = "<p>Hello HR,</p>";
            $message2 .= "<p>" . $bodyMessage . "</p>";
            $message2 .= "<p>" . $firstname . " " . $lastname . "</p>";

            if($_ENV["HOSTNAME"] == "PRODUCTION"){
                $subject = "CONVO - Automatic Response: " . $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO"){
                $subject = "DEMO - CONVO - Automatic Response: " . $subjectHeader;
            }
            else{
                $subject = "TESTING - CONVO - Automatic Response: " . $subjectHeader;
            }
            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    $subject2 = 'Convo - ' . $subjectHeader . ' TESTING'; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    $subject2 = 'Convo - ' . $subjectHeader . ' DEVELOPING'; 
            //}

            sendEmail($email, $subject2, $message2, $bodyMessage);
            //$receiver->Subject = $subject2;
            //$receiver->Body = $message2;
            //$receiver->AltBody = $bodyMessage;

            //$receiver->send();
        }
        // ONBOARDING
        else if(isset($_POST["submitNewHire"])){
                    
            /*$to = $email;
            $subject = $subjectHeader;  // Subject is New Hired Employee
            $message .= "<p>Dear " . $firstname . ",</p>";
            $message .= "<p>Thank you for submitting your New Employee Onboarding information!  We have the following information:</p>";
            $message .= $bodyMessage . "\n\n";
            $message .= "<h2>Information Needed for Background Check<strong></h2>";
            $message .= "<p>First, please scan a copy of your Social Security Card and Driver's License (or state-issued ID card). You may email this to hr@convorelay.com. To expedite processing, please do this at your earliest convenience.</p>";
            $message .= "<h2>New Hire Paperwork</h2>";
            $message .= "<p>Please complete the new hire packet before your first day of work.  This packet can be found here: <a href='https://test.theinfini.com/convo/New%20Hire%20Packet.pdf'>Convo New Hire Packet</a>.  When completed, please scan and send this to hr@convorelay.com.</p>";
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
        
            mail($to, $subject, $message, $headers); */
        }
       
        
        // FMLA REQUEST
        else if(isset($_POST["submitRequest"])){
            
            //$mail = new PHPMailer;
        
            //$mail->SMTPAuth = true;

            //$mail->Host = 'smtp.gmail.com';
            //$mail->Username = 'convoportal@gmail.com';
            //$mail->Password = 'ConvoPortal#1!';
            //$mail->STMPSecure = 'ssl';
            //$mail->Port = 465;

            //$mail->From = 'hr@convorelay.com';
            //$mail->FromName = 'Convo HR';
            //$mail->AddAddress = $email;
            //$mail->AddCC($COOP1Email, $COOP1Name);
            //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
            $message = "<p>Dear " . $firstname . ",</p>";
            $message .= "<p>Thank you for submitting your Family Medical Leave request.  We have the following information: </p>";
            $message .= $bodyMessage . "\n\n";
            $message .= "<p>Please contact us or your manager if you have any questions.</p>";
            $message .= "<p>Sincerely,</p>";
            $message .= "<p>Convo HR Team</p>";

            if($_ENV["HOSTNAME"] == "PRODUCTION")
            {
                $subject = $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO")
            {
                $subject = 'DEMO - ' . $subjectHeader;
            }
            else
            {
                $subject = 'TESTING - ' . $subjectHeader;
            }

            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    //$to = 'pxy9548@rit.edu';
            //    $subject = $subjectHeader . ' - TESTING'; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    //$to = 'jja4740@rit.edu';
            //    $subject = $subjectHeader . ' - DEVELOPING'; 
            //}

            sendEmail($email, $subject, $message, $bodyMessage);


            //$mail->Subject = $subject;
            //$mail->Body = $message;
            //$mail->AltBody = $bodyMessage;

            //$mail->send(); 
        }
        
        else if(isset($_POST["confirm"]) || isset($_POST["decline"])){
            //$mail = new PHPMailer;
        
            //$mail->SMTPAuth = true;

            //$mail->Host = 'smtp.gmail.com';
            //$mail->Username = 'convoportal@gmail.com';
            //$mail->Password = 'ConvoPortal#1!';
            //$mail->STMPSecure = 'ssl';
            //$mail->Port = 465;

            //$mail->From = 'alw7097@rit.edu';
            //$mail->FromName = 'Allison Wong';
            //$mail->AddAddress = $email;
            //$mail->AddCC($COOP1Email, $COOP1Name);
            ///*$mail->AddCC($COOP2Email, $COOP2Name); */
            //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);

            if($_ENV["HOSTNAME"] == "PRODUCTION")
            {
                $subject = $subjectHeader;
            }
            else if($_ENV["HOSTNAME"] == "DEMO")
            {
                $subject = 'DEMO - ' . $subjectHeader;
            }
            else
            {
                $subject = 'TESTING - ' . $subjectHeader;
            }

            if($_ENV["HOSTNAME"] == "TESTING"){
                //$to = 'pxy9548@rit.edu';
                $subject = $subjectHeader . ' - TESTING'; 
            }
            else if($_ENV["HOSTNAME"] == "DEVELOPING"){
                //$to = 'jja4740@rit.edu';
                $subject = $subjectHeader . ' - DEVELOPING'; 
            }

            $message = $bodyMessage . "<br/><br/>If you have any questions or concerns, please email HR@convorelay.com.";
            sendEmail($email, $subject, $message, $bodyMessage);
            //$mail->Subject = $subject;
            //$mail->Body = $bodyMessage . "<br/><br/>If you have any questions or concerns, please email HR@convorelay.com.";
            //$mail->AltBody = $bodyMessage;

            //$mail->send();
        }
    }

    function file_attachment($email, $firstname, $lastname, $state, $fileDL, $fileSSN){
        
       // global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
        
        //$fileDlAttachment = $fileDL['tmp_name'];
        //$fileSSNAttachment = $fileSSN['tmp_name'];
        
        ////file_name_new = $convo_user_data["lastname"] . ' ' . $convo_user_data["firstname"]  . '.' . $file_ext;

        ////$file_destination = $root . '/convo/Admin/upload_oe/' . $file_name_new;
        ////move_uploaded_file($fileDlAttachment, $fileDL['tmp_name']
        
        
               /* $uploads_dir = '/uploads';
        foreach ($_FILES["pictures"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                $name = $_FILES["pictures"]["name"][$key];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
            }
        } */
        
        
        //try{
        //    $mail = new PHPMailer;

        //    $mail->SMTPAuth = true;
        //    //$mail->IsSMTP();
        //    $mail->Host = 'stmp.gmail.com';
        //    $mail->Username = 'convoportal@gmail.com';
        //    $mail->Password = 'ConvoPortal#1!';
        //    $mail->STMPSecure = 'ssl';
        //    $mail->Port = 465;

        //    $mail->From = 'noreply@theinfini.com';
        //    $mail->FromName = 'Convo Portal';
        //    $mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);
        //    $mail->AddCC($COOP1Email, $COOP1Name);
        //   /* $mail->AddCC($COOP2Email, $COOP2Name); */
        //    $mail->AddCC($SupervisorCOOPEmail, $SupervisorName);

        //    $mail->AddAttachment($fileDlAttachment, $lastname . "_" . $fileDL['name']);
        //    $mail->AddAttachment($fileSSNAttachment, $lastname . "_" . $fileSSN['name']);

            $subject = $firstname . " " . $lastname . " - " . $state;
            $message = $firstname . " " . $lastname . " - " . $state;
            $bodyMessage = $firstname . " " . $lastname . " - " . $state;
            $attachments = array("lastname"=>$lastname,"DL"=>$fileDL, "SSN"=>$fileSSN);
        sendEmail($email, $subject, $message, $bodyMessage, $attachments);
        //    $mail->send();
        //    echo 'Message has been sent.';
            
        //}
        //catch(phpmailerException $e){
        //    echo $e -> errorMessage();
        //    //echo $fileDlAttachment;
        //}
    }


 /* RECOVER */

    function user_id_from_email($email) {
        global $link;
        $email= sanitize($email);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE email = '$email'");
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                //echo "Login Successful";
                return $row["employee_id"];   
            }
            else {
                return false;   
            }
        }
    }
    
    function recover($mode, $email) {
        //global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
        
        
        
        //$mode = sanitize($mode);
        //$email = sanitize($email);
        //$user_data = user_data(user_id_from_email($email), "employee_id", "firstname", "username");
        
        //$mail = new PHPMailer;

        //$mail->SMTPAuth = true;

        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'convoportal@gmail.com';
        //$mail->Password = 'ConvoPortal#1!';
        //$mail->STMPSecure = 'ssl';
        //$mail->Port = 465;

        //$mail->From = 'noreply@theinfini.com';
        //$mail->FromName = 'Convo Portal';
        //$mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);
        //$mail->AddAddress($email);
        //$mail->AddCC($COOP1Email, $COOP1Name);
        //$mail->AddCC($COOP2Email, $COOP2Name); 
        //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);
            

        if($mode == "username") {
            // Recover username
            //email($email, "Your username", "Hello " . $user_data["firstname"] . "\n\nYour username is: " . $user_data["username"] . "\n\n -CONVO Portal");

            if($_ENV["HOSTNAME"] == "PRODUCTION")
            {
                $subject = "Your username";
            }
            else if($_ENV["HOSTNAME"] == "DEMO")
            {
                $subject = 'DEMO - Your username';
            }
            else
            {
                $subject = 'TESTING - Your username';
            }

            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    //$to = 'pxy9548@rit.edu';
            //    $subject = 'Your username - TESTING'; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    //$to = 'jja4740@rit.edu';
            //    $subject = 'Your username - DEVELOPING'; 
            //}

            $message = "Hello " . $user_data["firstname"] . ",<br/><br/>Your username is: " . $user_data["username"] . "<br/> <br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            $bodyMessage = "Hello " . $user_data["firstname"] . ",<br/><br/>Your username is: " . $user_data["username"] . "<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em> - The Convo Portal Team at Infini Consulting";
            //$mail->Subject = $subject;
            //$mail->Body = "Hello " . $user_data["firstname"] . ",<br/><br/>Your username is: " . $user_data["username"] . "<br/> <br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            //$mail->AltBody = "Hello " . $user_data["firstname"] . ",<br/><br/>Your username is: " . $user_data["username"] . "<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em> - The Convo Portal Team at Infini Consulting";
            sendEmail($email, $subject, $message, $bodyMessage);
            //$mail->send(); 
        }
        else if($mode == "password") {
            // Recover password
            $generated_password = substr(md5(rand(999, 999999)), 0, 8);
            //die($generated_password);
            change_password($user_data["employee_id"], $generated_password);

            update_user($user_data["employee_id"], array("password_recover" => 1));

            //email($email, "Your password recovery", "Hello " . $user_data["firstname"] . "\n\nYour temporary password is: " . $generated_password . "\n\nAfter logging in, you will be prompted to change your password.\n\n -CONVO Portal");

            if($_ENV["HOSTNAME"] == "PRODUCTION")
            {
                $subject = "Your password recovery";
            }
            else if($_ENV["HOSTNAME"] == "DEMO")
            {
                $subject = 'DEMO - Your password recovery';
            }
            else
            {
                $subject = 'TESTING - Your password recovery';
            }
            
            //if($_ENV["HOSTNAME"] == "TESTING"){
            //    //$to = 'pxy9548@rit.edu';
            //    $subject = 'Your password recovery - TESTING'; 
            //}
            //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
            //    //$to = 'jja4740@rit.edu';
            //    $subject = 'Your password recovery - DEVELOPING'; 
            //}

            $message = "Hello " . $user_data["firstname"] . ",<br/><br/> Your username is: " . $username . " Your temporary password is: " . $generated_password . "<br/><br/>After logging in, you will be prompted to change your password.<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            $bodyMessage = "Hello " . $user_data["firstname"] . ",<br/><br/>Your temporary password is: " . $generated_password . "<br/><br/>After logging in, you will be prompted to change your password.<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";

            //$mail->Subject = $subject;
            //$mail->Body = "Hello " . $user_data["firstname"] . ",<br/><br/> Your username is: " . $username . " Your temporary password is: " . $generated_password . "<br/><br/>After logging in, you will be prompted to change your password.<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            //$mail->AltBody = "Hello " . $user_data["firstname"] . ",<br/><br/>Your temporary password is: " . $generated_password . "<br/><br/>After logging in, you will be prompted to change your password.<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            sendEmail($email, $subject, $message, $bodyMessage);
            //$mail->send(); 
        }
    }


 /* TEMP PASSWORD FOR ONBOARDING EMPLOYEES   */


    /*function userIdEmail($email) {
        global $link;
        $email= sanitize($email);
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE email = '$email'");
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                //echo "Login Successful";
                return $row["employee_id"];   
            }
            else {
                return false;   
            }
        }
    } */
    
    function onboarding_reset_password($firstname, $username, $email, $generated_password) {
        global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
        
        //$email = sanitize($email);
        //$url = "https://test.theinfini.com/convo/";
        
        //$mail = new PHPMailer;
        //$mail->SMTPAuth = true;
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'convoportal@gmail.com';
        //$mail->Password = 'ConvoPortal#1!';
        //$mail->STMPSecure = 'ssl';
        //$mail->Port = 465;

        //$mail->From = 'noreply@theinfini.com';
        //$mail->FromName = 'Convo Portal';
        //$mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);

        $subject = "Access to Convo Employee Portal";
        
        if($_ENV["HOSTNAME"] == "PRODUCTION")
        {
            $mail->AddAddress($email);
            //$mail->AddCC("hr@convorelay.com");
            $mail->AddBCC($SupervisorCOOPEmail);
        }
          else if($_ENV["HOSTNAME"] == "DEMO")
        {
            //$mail->AddAddress($SupervisorCOOPEmail);
            $mail->AddCC($COOP2Email, $COOP2Name);
            $subject = "DEMO - " . $subject;
        }
        else
        {
            //$mail->AddAddress($SupervisorCOOPEmail);
            $mail->AddCC($COOP2Email, $COOP2Name);
            $subject = "TESTING - " . $subject;
        }
        
        //$mail->Subject = $subject;

        $body = "Hi " . $firstname . ",<br/><br/>Congratulations and welcome to the Convo family!<br><br>Prior to employment, we need to run your background check. Please be prepared to upload a copy of your state-issued Driver License and a copy of your Social Security card to Convo's employee portal.<br><br>Please click on the link to the portal: " . $url . "<br/><br/>Your username is: " . $username . "<br/><br/>" . "Your temporary password is: " . $generated_password . "<br><br>Once these documents have been received and background check cleared, we will then notify you and your manager to arrange a date and time for training and the official beginning of your employment with Convo.<br/><br/><em><strong>This is an automatically generated email; please do not reply to this message.</strong></em><br/><br/> - The Convo Portal Team at Infini Consulting";
            
        //$mail->Body = $body;
        //$mail->AltBody = $body;

        sendEmail($email, $subject, $body, $body);
        //$mail->send(); 
    } 

function fileUploaded($firstname, $lastname, $fileDL, $fileSSN) {
        global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;

        //$mail = new PHPMailer;
        //$mail->SMTPAuth = true;
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'convoportal@gmail.com';
        //$mail->Password = 'ConvoPortal#1!';
        //$mail->STMPSecure = 'ssl';
        //$mail->Port = 465;

        //$mail->From = 'noreply@theinfini.com';
        //$mail->FromName = 'Convo Portal';
        //$mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);
        //$mail->AddCC($COOP1Email, $COOP1Name);
        //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);
            
        $subject = "Onboarding Files Received for " . $firstname . " " . $lastname;
        if($_ENV["HOSTNAME"] == "PRODUCTION")
        {
            // WHERE this should go to? HR@convorelay.com
            $mail->AddAddress($SupervisorCOOPEmail);
            $mail->AddBCC($SupervisorCOOPEmail);
        }
        else if($_ENV["HOSTNAME"] == "DEMO")
        {
            $mail->AddAddress($SupervisorCOOPEmail);
            $mail->AddCC($COOP1Email, $COOP1Name);
            $subject = "DEMO - " . $subject; 
        }
        else 
        {
            $mail->AddAddress($SupervisorCOOPEmail);
            $mail->AddCC($COOP1Email, $COOP1Name);
            $subject = "TESTING - " . $subject; 
        }
        
        //$mail->Subject = $subject;
        $body = $firstname . " " . $lastname . " has uploaded files necessary for background check.<br/><br/>" .
            "<a href=\"$fileDL\">Driver's License</a>";
    
        if ($fileSSN != "")
        {
            $body .= "<br><a href=\"$fileSSN\">Social Security Card</a>";
        }

        //$mail->Body = $body;
        //$mail->AltBody = $body;
        sendEmail($email, $subject, $body, $body);
        //$mail->send(); 
    } 

function sendCheckOptInEmail($firstname, $lastname, $email) 
{
    //global $SupervisorCOOPEmail, $SupervisorName;
    //$requestor = $firstname . " " . $lastname;
    
    //$mail = new PHPMailer;
    //$mail->SMTPAuth = true;
    //$mail->Host = 'smtp.gmail.com';
    //$mail->Username = 'convoportal@gmail.com';
    //$mail->Password = 'ConvoPortal#1!';
    //$mail->STMPSecure = 'ssl';
    //$mail->Port = 465;

    //$mail->From = 'noreply@theinfini.com';
    //$mail->FromName = 'Convo Portal';
    //$mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);
    //$mail->AddAddress('chrisc@convorelay.com');
    
    //if ($email != "")
    //{
    //    $mail->AddCC($email, $requestor);
    //}
            
    //$subject = "Pay Stub Request for " . $requestor;
    //$mail->Subject = $subject;
    
    //$body = "I would like to continue receiving a hard copy of my bi-weekly check stub.<br/><br/>" . $requestor;
    //$mail->Body = $body;
    //$mail->AltBody = $body;
    
    //$mail->send(); 
}

/**
 * The ability to send an email automatically.
 * @param mixed $mode 
 * @param mixed $email 
 * @param mixed $subject 
 * @param mixed $bodyMessage 
 * @param mixed $altBodyMessage 
 */
function sendEmail($email, $subject, $bodyMessage, $altBodyMessage, $attachments = null){
    global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
    $email = sanitize($email);
    $user_data = user_data(user_id_from_email($email), "employee_id", "firstname", "username");

    $mail = testHere();
    $mail->AddReplyTo($SupervisorCOOPEmail, $SupervisorName);
    $mail->AddAddress($email);
    //$mail->AddCC($COOP1Email, $COOP1Name);
    $mail->AddCC($COOP2Email, $COOP2Name);
    $mail->AddCC($SupervisorCOOPEmail, $SupervisorName);

    if($attachments != null){
        $lastname = $attachments['lastname'];
        $fileDL = $attachments['DL'];
        $fileSSN = $attachments['SSN'];
        $fileDlAttachment = $fileDL['tmp_name'];
        $fileSSNAttachment = $fileSSN['tmp_name'];
        $mail->AddAttachment($fileDlAttachment, $lastname . "_" . $fileDL['name']);
        $mail->AddAttachment($fileSSNAttachment, $lastname . "_" . $fileSSN['name']);
    }

    //if($_ENV["HOSTNAME"] == "DEMO"){
    //    //$to = 'jja4740@rit.edu';
    //    $subject = "Portal Demo - Automatic Response: Database Error";
    //}
    //else if($_ENV["HOSTNAME"] == "PRODUCTION"){
    //    //$to = 'pxy9548@rit.edu';
    //    $subject = "CONVO Portal - Automatic Response: Database Error";
    //}
    //else{
    //    //$to = 'jja4740@rit.edu';
    //    $subject = "Testing CONVO Portal - Automatic Response: Database Error";
    //}

    //if($_ENV["HOSTNAME"] == "TESTING"){
    //    //$to = 'pxy9548@rit.edu';
    //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . " - TESTING";
    //}
    //else if($_ENV["HOSTNAME"] == "DEVELOPING"){
    //    //$to = 'jja4740@rit.edu';
    //    $subject = "CONVO Portal - Automatic Response: " . $subjectHeader . ' - DEVELOPING';
    //}

    testSendEmail($mail, $subject, $bodyMessage, $altBodyMessage);
}

function sendErrorEmail($query){
    global $COOP1Email, $COOP2Email, $SupervisorCOOPEmail, $COOP1Name, $COOP2Name, $SupervisorName;
    $mail = testHere();
    //$to = $SupervisorCOOPEmail . "," . $COOP2Email;
    //$to = $COOP2Email;
    //email($to, "Database Error", mysqli_error($query));

    $mail->AddAddress($COOP2Email);
    //$mail->AddCC($COOP1Email, $COOP1Name);
    //$mail->AddCC($COOP2Email, $COOP2Name);
    //$mail->AddCC($SupervisorCOOPEmail, $SupervisorName);

    if($_ENV["HOSTNAME"] == "DEMO"){
        //$to = 'jja4740@rit.edu';
        $subject = "Portal Demo - Automatic Response: Database Error";
    }
    else if($_ENV["HOSTNAME"] == "PRODUCTION"){
        //$to = 'pxy9548@rit.edu';
        $subject = "CONVO Portal - Automatic Response: Database Error";
    }
    else{
        //$to = 'jja4740@rit.edu';
        $subject = "Testing Portal - Automatic Response: Database Error";
    }

    testSendEmail($mail, $subject, mysqli_error($query));
}

function testHere(){
    $mail = new PHPMailer;

    $mail->SMTPAuth = true;

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'convoportal@gmail.com';
    $mail->Password = 'ConvoPortal#1!';
    $mail->STMPSecure = 'ssl';
    $mail->Port = 465;
    $mail->From = 'noreply@theinfini.com';
    $mail->FromName = 'Convo Portal';
    return $mail;
}

function testSendEmail($mail, $subject, $body, $altBodyMessage=null){
    $mail->Subject = $subject;
    $mail->Body = $bodyMessage;
    if($altBodyMessage != null){
        $mail->AltBody = $altBodyMessage;
    }
    $mail->send();
}



function email_exists($email) {
        global $link;
        $emil= sanitize($email);
        $query = mysqli_query($link, "SELECT employee_id FROM employee_vw WHERE email = '$email'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }


/*  
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


    function breadcrumbs($page_title){
        if(logged_in() == true) {
            $startAtCrumb = 2;
            $url = '/portal-demo/';
            
            $bread = explode('/', $_SERVER['PHP_SELF']);
            if($_SERVER["PHP_SELF"] !== "/portal-demo/index.php") {
             $returnString = "<br/><br/><br/><span class='bc0'><a href='$url'>Convo Portal</a> &raquo; </span>";   
            }
            for($i=$startAtCrumb;$i<count($bread)-1;$i++){
                $url.=$bread[$i].'/';
                $returnString .= "<span class='bc$i'><a href='$url'>"
                .prettify($bread[$i])."</a>";
            }
            if($_SERVER["PHP_SELF"] == "/portal-demo/employee.php" || $_SERVER["PHP_SELF"] == "/portal-demo/changepassword.php" || $_SERVER["PHP_SELF"] == "/portal-demo/register.php" || $_SERVER["PHP_SELF"] == "/portal-demo/contact.php" || $_SERVER["PHP_SELF"] == "/portal-demo/selectEmployee.php") {
                echo $returnString . "<strong>" . $page_title . "</strong></span>";
            }
            else if($_SERVER["PHP_SELF"] !== "/portal-demo/index.php" ) {
                echo $returnString . " &raquo; " . $page_title . "</span>";
            }
        }
    }

    function prettify($dirName){
        $dirName = str_replace('_', ' ', $dirName);
        $dirName = str_replace('%20', ' ', $dirName);
        return $dirName;
    }

function clean_up_phone($phoneNumber){
    
    $phonelength = strlen($phoneNumber);
    
    for($i=0; $i<= $phonelength; $i++){
        $charNum = substr($phoneNumber, $i, 1);
        
        if($charNum == ')'){
            $phoneNumber = str_replace(')', '', $phoneNumber);   
        }
        else if($charNum == '('){
            $phoneNumber = str_replace('(', '', $phoneNumber);   
        }
        else if($charNum == '-'){
            $phoneNumber = str_replace('-', '', $phoneNumber);   
        }
        else if($charNum == '/'){
            $phoneNumber = str_replace('/', '', $phoneNumber);   
        }
        /*else if($charNum == ' '){
            $phoneNumber = str_replace(' '), '', $phoneNumber);
        }*/
    }
    
    
    
    return $phoneNumber;   
}

function validatePhoneNumber($phone){
    $countDigit = 0;
    $phonelength = strlen($phone);
    
    if($phonelength == 0){
        return true;
    }
    
    for($i = 0; $i <= $phonelength; $i++){
        $charNumber = substr($phone, $i, 1);
        
        if(is_numeric($charNumber)){
            $countDigit++;
            //echo 'Not valid';
        }
    }
    if($countDigit == 10){
        return $phone;   
    }
    else{
        return false;   
    }
}

?>