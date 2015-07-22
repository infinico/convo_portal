<?php
    $page_title = "Forum";
    $title = "Convo Portal | Forum";
    include("./../../core/init.php");
    protect_page();
    include("../../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Forum</h1>
            <div id="forum_menu">
                <a class="item" href="<?php echo $linkToALL;?>/Experts/forum/index.php">Home</a> -
                <a class="item" href="<?php echo $linkToALL;?>/Experts/forum/create_topic.php">Creata a topic</a> - 
                <a class="item" href="<?php echo $linkToALL;?>/Experts/forum/create_cat.php">Creata a category</a> - 
            </div>

<?php
$query = "SELECT cat_id, cat_name, cat_description FROM categories";
    $result = mysqli_query($link, $query);

    if(!$result) {
        echo "The categories could not be displayed, please try again later.";
    }
    else {
        if(mysqli_num_rows($result) == 0) {
            echo 'No categories defined yet.';
        }
        else {
            // Prepare thet table
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Category</th><th>Last Topic</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='forum_table'>";
                echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h3><a href="category.php?id=">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';                
                        echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                echo '</td>';
                echo '</tr>';
                echo "</div>";    
            }
        }
    }


//    include("./../../assets/inc/footer.inc.php");
?>