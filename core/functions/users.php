<?php
    /*
    * LOGIN FUNCTIONS
    */

    // employee ID from the username will apply to the Login Function below
    function user_id_from_username($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE username = '$username'");
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                return $row["employee_id"];   
            }
            else {
                return false;   
            }
        }
    }

    function login($username, $password) {
        global $link;
        $user_id = user_id_from_username($username);
        
        $username = sanitize($username);
        $password = md5($password);
        
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE username = '$username' AND password = '$password'");
        
        while($row = mysqli_fetch_assoc($query)){
            if(mysqli_num_rows($query) > 0 ) {
                //echo "Login Successful";
                return $user_id;   
            }
            else {
                return false;   
            }
        }
    }

    function logged_in() {
        return(isset($_SESSION['employee_id'])) ? true : false;   
    }

    // The users are active when they register the usernames
    function user_active($username) {
        global $link;
        $username = sanitize($username);
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE username = '$username' AND active = 1");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    function test_employee_id($employeeID){
        global $link;
        $query = mysqli_query($link, "SELECT * FROM employee WHERE employee_id = '$employeeID'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
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
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE ssn = '$ssn' AND date_of_birth = '$dob'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
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
        
        $fields = "" . implode(", ", array_keys($register_data)) . "";
        $data = "\"" . implode("\" , \"", $register_data) . "\"";
        
        mysqli_query($link, "UPDATE employee SET username = '$username', password = '$password' WHERE ssn = '$ssn' AND date_of_birth = '$dob'");

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
            $update[] = "$field = \"$data\"";
        }
        mysqli_query($link, "UPDATE employee SET " . implode(", ", $update) . " WHERE employee_id = '$user_id'") or die(mysqli_error($link));
    }

    function change_password($user_id, $password) {
        global $link;
        $user_id = $user_id;
        //setcookie("password", $password, time() + 7200);
        $password = md5($password); 
        mysqli_query($link, "UPDATE employee SET password = '$password', password_recover = 0 WHERE employee_id = '$user_id'");    
    }

    /*
    * ACCESS FUNCTIONS
    */

    // Employee Page - Access for Hire and Changes(Terminations)
    function has_access($job_code) {
        global $link;
        $job_code = $job_code;
        //$type = (int)$type;
        
        $query = mysqli_query($link, "SELECT job_code FROM position_type WHERE job_code = '$job_code' AND admin_privilege = '1'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    // Manager Access - Links buttons visible and unvisible if they are not manager.
    function has_access_manager($job_code) {
        global $link;
        $job_code = $job_code;    
        $query = mysqli_query($link, "SELECT job_code FROM position_type WHERE job_code = '$job_code' AND manager_privilege = '1'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    //Interpreting Department Access - everyone in this department have access.
    function has_access_interpreting($job_code){
        global $link;
        $query = mysqli_query($link, "SELECT job_code FROM position_type WHERE job_code = '$job_code' AND dept_code = 'INT'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    function has_access_support($job_code){
        global $link;
        $query = mysqli_query($link, "SELECT job_code FROM position_type WHERE job_code = '$job_code' AND dept_code = 'SUP'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
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
            $query = mysqli_query($link, "SELECT $fields FROM employee WHERE employee_id = '$user_id'");
            //$result = mysql_result($link, $query);
            $data = mysqli_fetch_assoc($query);
            
            return $data;
        }
    }

    /*
    * CENSUS DATA FUNCTIONS 
    */

    // Census Access for the full-time employees only.
    function has_access_census($user_id) {
        global $link;
        $user_id = $user_id;    
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE employee_id = '$user_id' AND payroll_status = 'FT'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

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
            $query = mysqli_query($link, "SELECT $fields FROM employee WHERE employee_id = '$user_id'");
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
        
        $query = mysqli_query($link, "SELECT COUNT('supervisor_id') FROM employee WHERE employee_id = '$user_id' AND supervisor_id = '$supervisor_id'");
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
            $query = mysqli_query($link, "SELECT $fields FROM employee s INNER JOIN employee e ON s.employee_id = e.supervisor_id WHERE e.employee_id = '$user_id'");
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
            $query = mysqli_query($link, "SELECT $fields, p.position_name FROM employee e INNER JOIN position_type p ON e.job_code = p.job_code WHERE e.employee_id = '$user_id'");
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
        $query = mysqli_query($link, "SELECT COUNT('employee_id') FROM employee WHERE username = '$username'");
        if(mysqli_num_rows($query) > 0 ) {
            return true;   
        }
        else {
            return false;   
        }
    }

    // Employee ID Exists - must be unique and can't be same employeeID
    function employee_id_exists($employee_id) {
        global $link;
        $employee_id = sanitize($employee_id);
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE employee_id = '$employee_id'");
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
        $query = mysqli_query($link, "SELECT position_name FROM position_type WHERE position_name = '$positionName'");
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
        $query = mysqli_query($link, "SELECT department_name FROM department WHERE department_name = '$departmentName'");
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
        $query = mysqli_query("SELECT location_code FROM location WHERE convo_location = '$convoLocation'");
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
        $query = mysqli_query($link, "SELECT job_code FROM position_type WHERE job_code = '$jobCode'");
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
        $query = mysqli_query($link, "SELECT dept_code FROM department WHERE dept_code = '$deptCode'");
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
        $query = mysqli_query($link, "SELECT location_code FROM location WHERE location_code = '$locationCode'");
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
    }

    function file_attachment($email, $firstname, $lastname, $state, $fileDL, $fileSSN){
        
        $fileDlAttachment = $fileDL['tmp_name'];
        $fileSSNAttachment = $fileSSN['tmp_name'];
        
        $mail = new PHPMailer;
        
        $mail->SMTPAuth = true;
        
        $mail->Host = 'stmp.gmail.com';
        $mail->Username = 'convoportal@gmail.com';
        $mail->Password = 'ConvoPortal#1!';
        $mail->STMPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->From = 'pxy9548@rit.edu';
        $mail->FromName = 'Peter Yeung';
        $mail->AddCC('jja4740@rit.edu', 'Joshua Aziz');
        $mail->AddCC('pxy9548@rit.edu', 'Peter Yeung');
        $mail->AddCC('chris@theinfini.com', 'Chris Campbell');
        
        $mail->AddAttachment($fileDlAttachment, $lastname . "_" . $fileDL['name']);
        $mail->AddAttachment($fileSSNAttachment, $lastname . "_" . $fileSSN['name']);
        
        $mail->Subject = $firstname . " " . $lastname . " - " . $state;
        $mail->Body = $firstname . " " . $lastname . " - " . $state;
        $mail->AltBody = $firstname . " " . $lastname . " - " . $state;
        
        $mail->send();
    }


 /* RECOVER */

    function user_id_from_email($email) {
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
    }
    
    function recover($mode, $email) {
        $mode = sanitize($mode);
        $email = sanitize($email);

        $user_data = user_data(user_id_from_email($email), "employee_id", "firstname", "username");

        if($mode == "username") {
            // Recover username
            email($email, "Your username", "Hello " . $user_data["firstname"] . "\n\nYour username is: " . $user_data["username"] . "\n\n -CONVO Portal");
        }
        else if($mode == "password") {
            // Recover password
            $generated_password = substr(md5(rand(999, 999999)), 0, 8);
            //die($generated_password);
            change_password($user_data["employee_id"], $generated_password);

            update_user($user_data["employee_id"], array("password_recover" => "1"));

            email($email, "Your password recovery", "Hello " . $user_data["firstname"] . "\n\nYour new password is: " . $generated_password . "\n\n -CONVO Portal");
        }
    }
    
    function email_exists($email) {
        global $link;
        $emil= sanitize($email);
        $query = mysqli_query($link, "SELECT employee_id FROM employee WHERE email = '$email'");
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
            $url = '/convo/';
            
            $bread = explode('/', $_SERVER['PHP_SELF']);
            if($_SERVER["PHP_SELF"] !== "/convo/index.php") {
             $returnString = "<br/><br/><br/><span class='bc0'><a href='$url'>Convo Portal</a> &raquo; </span>";   
            }
            for($i=$startAtCrumb;$i<count($bread)-1;$i++){
                $url.=$bread[$i].'/';
                $returnString .= "<span class='bc$i'><a href='$url'>"
                .prettify($bread[$i])."</a>";
            }
            if($_SERVER["PHP_SELF"] == "/convo/employee.php" || $_SERVER["PHP_SELF"] == "/convo/changepassword.php" || $_SERVER["PHP_SELF"] == "/convo/register.php" || $_SERVER["PHP_SELF"] == "/convo/contact.php" || $_SERVER["PHP_SELF"] == "/convo/selectEmployee.php") {
                echo $returnString . "<strong>" . $page_title . "</strong></span>";
            } 
            else if($_SERVER["PHP_SELF"] !== "/convo/index.php" ) {
                echo $returnString . " &raquo; " . $page_title . "</span>";
            }
        }
    }

    function prettify($dirName){
        $dirName = str_replace('_', ' ', $dirName);
        $dirName = str_replace('%20', ' ', $dirName);
        return $dirName;
    }    
?>