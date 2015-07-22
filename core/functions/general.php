<?php
    function email($to, $subject, $body) {
        mail($to, $subject, $body, "From: pxy9548@rit.edu");
    }

    // Redirect the Page
    function logged_in_redirect() {
        if(logged_in() === true) {
            header("Location: $linkToALL/convo/index.php");  
            exit();
        }
    }

    // Protect Page
    function protect_page() {
        if(logged_in() === false) {
            header("Location: $linkToALL/convo/protected.php");
            exit();
        }
    }

    // Admin Protect Page 
    function admin_protect() {
        global $user_data;
        if(has_access($user_data["job_code"]) === false) {
            header("Location: $linkToALL/convo/index.php");
            exit();
        }
    }

    // Manager Protect Page
    function manager_protect(){
        global $user_data;
        if(has_access_manager($user_data["job_code"]) === false){
            header("Location: $linkToALL/convo/index.php");
            exit();
        }
    }

    // Census Protect Page
    function census_protect(){
        global $user_data;
        if(has_access_census($user_data["job_code"]) === false){
            header("Location: $linkToALL/convo/index.php");
            exit();
        }
    }

    function array_sanitize(&$item) {
        $item = strip_tags(mysqli_real_escape_string($link, $item));
    }

    function sanitize($data) {
        global $link;
        return htmlentities(strip_tags(mysqli_real_escape_string($link, $data)));    
    }

    function output_errors($errors) {
        return "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
    }

   function multiexplode ($delimiters, $string) {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
?>