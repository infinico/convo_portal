<?php
    $page_title = "Forum";
    $title = "Convo Portal | Forum";
    include("./../../core/init.php");
    protect_page();
    include("../../assets/inc/header.inc.php");

    if($_SERVER['REQUEST_METHOD'] != 'POST') {
        //the form hasn't been posted yet, display it
        echo "<form method='post' action=''>
            Category name: <input type='text' name='cat_name' /><br/>
            Category description: <textarea name='cat_description' /></textarea><br/>
            <input type='submit' value='Add category' />
         </form>";
    }
    else {
        //the form has been posted, so save it
        $sql = "INSERT INTO categories(cat_name, cat_description) VALUES('" . $_POST["cat_name"] . "', '" .  $_POST["cat_description"] . "')";
        echo $sql;
        $result = mysqli_query($link, $sql);
        
        if(!$result) {
            //something went wrong, display the error
            echo 'Error' . mysqli_error($link);
        }
        else{
            echo 'New category successfully added.';
        }
    }
?>