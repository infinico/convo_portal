<?php
    $page_title = "Forum";
    $title = "Convo Portal | Forum";
    include("./../../core/init.php");
    protect_page();
    include("../../assets/inc/header.inc.php");

    echo "<br/><br/><h2>Create a topic</h2>";
    if($_SERVER['REQUEST_METHOD'] != 'POST') {   
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($link, $sql);
        
        if(!$result) {
            // the query failed...
            echo "Error while selecting from database.  Please try again later.";
        }
        else {
            echo '<form method="post" action="">
                    Subject: <input type="text" name="topic_subject" />
                    Category:'; 
                 
                echo '<select name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                    }
                echo '</select>'; 
                     
                echo 'Message: <textarea name="post_content" /></textarea>
                    <input type="submit" value="Create topic" />
                 </form>';
        }
    }
    else {
        // Start thr transcation
        $query = "BEGIN WORK";
        $result = mysqli_query($link, $query);
        
        if(!$result) {
            // The query failed, quit
            echo "An error occured while creating your topic, please try it again later";
        }
        else {
            // The form has been posted, so save it
            // Insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES('" . $_POST["topic_subject"] . "', NOW(), " . $_POST["topic_cat"] . ", '" . $session_user_id . "')";
            
            $result = mysqli_query($link, $sql);
            if(!$result) {
                // Something went wrong
                echo "An error occured while inserting your data.  PLease try again later";
                $sql = "ROLLBACK;";
                $result = mysqli_query($link, $sql);
            }
            else {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($link);
                $sql = "INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES('" . $_POST["post_content"] . "' , NOW(), " . $topicid . ", '" . $session_user_id . "')";
                $result = mysqli_query($link, $sql);
                if(!$result) {
                    echo 'An error occured while inserting your post. Please try again later.';
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($link, $sql);       
                }
                else {
                    $sql = "COMMIT";
                    $result = mysqli_query($link, $sql);
                    
                    // after a lot of work, query successed!
                    echo "You have successfully created <a href='$linkToALL/Experts/Forum/topic.php?id=" . $topicid . "'>your new topic</a>";
                }
            }
        }
    }   
?>