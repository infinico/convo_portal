<?php
    include("./../core/init.php");

    class forum_database {
        private $db;
        
        function __construct() {
            // We set our own error_handler
            set_error_handler(array($this, "errorHandler"));
            
            // Connect to Database
            $this->db = mysqli_connect
        }
    }
?>