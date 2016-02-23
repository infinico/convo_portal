<!--
Infini Consulting
CONVO Portal v1.5
Copyright 2015
-->

<!DOCTYPE HTML>
<html>
    <?php 
       // $linkToALL = "https://test.theinfini.com/convo";  
        //$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    ?>
    <head>  <!-- Head Starts -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <link rel="icon" href="<?php echo $linkToALL;?>/assets/images/infini.ico" type="image/png">  
        
        <title><?php echo $title; ?></title>  
        
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/bootstrap.min.css" />
        
        <!-- Credits by jonthornton for Datepicker design and Timepicker-->
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/jquery.timepicker.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/bootstrap-datepicker.css" />
        
        <!-- Start WOWSlider.com HEAD section -->
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/plugins/WOWSlider/engine1/style.css" />
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/plugins/WOWSlider/engine1/jquery.js"></script>
        <!-- End WOWSlider.com HEAD section -->
        
        <link rel="stylesheet" type="text/css" media="print" href="<?php echo $linkToALL;?>/assets/css/print.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/convo_style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $linkToALL;?>/assets/css/table.css">
        
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/jquery-1.11.1.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
        
        <!-- Credits by jonthornton for Datepicker design and Timepicker-->
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/jquery.timepicker.js"></script>
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/bootstrap-datepicker.js"></script>
        
        <script type="text/javascript" src="<?php echo $linkToALL;?>/assets/js/script.js"></script>
        
      <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <link rel="stylesheet" href="/resources/demos/style.css">-->

 

        
        
        
        
    
    </head> <!-- Head ends -->
    <body onload="onLoad()">    <!-- Body -->
        <header>
            <!--<div class="infini-logo">
            <a href="https://www.theinfini.com" target="_blank"><img id="infinilogo" src="<?php echo $linkToALL;?>/assets/images/infini.svg" alt="Infini" width="200"/></a></div>-->
            <aside>              
<?php      
    if(isset($_POST["login"]) && $_POST["username"] == "tester" && $_POST["password"] == "DBacce$$"){
        header("Location: selectEmployee.php");   
    }
    else if(logged_in() === true) {
        include("$root/convo/includes/widgets/loggedin.php");
    }
    else {
        include("$root/convo/includes/widgets/login.php");
    }
?>       
            </aside>  
            
<?php include("$root/convo/assets/inc/nav.inc.php"); ?>

            
        </header>
        <div class="clear"></div>   <!-- Clear -->
        <div id="container">    <!-- Main Container -->
            <div id="convoLogo">    <!-- Convo Logo -->
                <strong class="logo-org fn org url">
                    <a href="<?php echo $linkToALL;?>/index.php"></a>
                </strong>
            </div>  <!-- Convo Logo // -->
            
            
            <?php
            /*$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
            $url = $_SERVER["REQUEST_URI"];
            foreach($crumbs as $crumb){
                echo "<a href='$url'>" . ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ') . "</a>";
            }*/
            if($_SERVER["PHP_SELF"] !== "/convo/onboarding.php" ) {
                echo breadcrumbs($page_title);
            }

            ?>