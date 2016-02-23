<?php 
    $page_title = "Employee Directory";
    $title = "Convo Portal | Employee Directory";
    include("/core/init.php");
    include("/assets/inc/header.inc.php");
  
    $resultDept = mysqli_query($link, "SELECT 'All Departments' department_name UNION SELECT department_name FROM department"); 

    $resultLocation= mysqli_query($link, "SELECT location_code, convo_location FROM location WHERE active = 'Y' ORDER BY convo_location"); 
    
    $resultPosition = mysqli_query($link, "SELECT job_code, position_name FROM position_vw");

?>




<h1 class="headerPages">Employee Directory</h1>

<style>
    td, tr{
        display: inline-block;
        
    }
    
    #table{
        font-size: 14px;
        float: left;
        padding-left: 30px;
        width: 175px;
        height: 350px;
        margin-left: 10px; 
    }


</style>

<form action="employee_directory.php" method="post">
    
    
    <?php

        //$image_id = $_GET['image_id'];
        
        
        

    ?>
    
      <span class="spanHeader">First Name: </span>
        <input type="text" id="directory" name ="searchFirstName" placeholder="Or first few letters"></span>
            <br/><br/>


      <span class="spanHeader">Last Name: </span>
        <input type="text" id="directory" name ="searchLastName" placeholder="Or first few letters"></p>
    

    <span class="spanHeader">Position: </span>
            <?php
                    echo "<select id='position_name' class='input-xlarge' name='change_position_name'><option value=''>Select a Position</option>";
                    while($row = mysqli_fetch_assoc($resultPosition)) {
                        echo "<option value = '" . $row['job_code'] . "'";

                        if(isset($_POST["submit"]) && $_POST["change_position_name"] == $row['job_code']){
                            echo "selected='selected'";
                        }       
                        echo ">" . $row['job_code'] . " - " . $row['position_name'] . "</option>";   
                    }
                    echo "</select>";
                ?>

         <br/><br/>

                <span class="spanHeader">Convo Location: </span>
                   
                    <?php
                        echo "<select id='location' name='location'><option value=''>Select a location</option>";
                        while($row = mysqli_fetch_assoc($resultLocation)) {


                            echo "<option value = '" . $row['location_code'] . "'";

                            if(isset($_POST["submit"]) && $_POST["location"] == $row['location_code']){
                                echo "selected= 'selected'";    
                            }

                            echo ">" . $row["convo_location"] . "</option>";   
                        }
                        echo "</select>";?>
                <br/><br/>



<span class="spanHeader">Department: </span>
        <?php
            echo "<select id='departmentName' name='departmentName'><option value=''>Select a department</option>";
            while($row = mysqli_fetch_assoc($resultDept)) {
                
                
                echo "<option value = '" . $row['department_name'] . "'";
                
                if(isset($_POST["submit"]) && $_POST["departmentName"] == $row['department_name']){
                    echo "selected= 'selected'";    
                }
                
                echo ">" . $row["department_name"] . "</option>";   
            }
            echo "</select>";?>
        
        <br/>


    <input type="submit" id="searchSubmit" name="searchSubmit" value="Search">
</form>






<?php

if(isset($_POST["searchSubmit"])){



    $query = "SELECT firstname, lastname, position, hireDate, convoNumber, department_name, convo_location, fileName FROM convo_employee_vw WHERE employment_status = 'Active' ";
        
    $firstName = $_POST["searchFirstName"];
        
    if ($firstName != '')
        $query .= "AND firstname LIKE '" . $firstName . "%' ";

    $lastName = $_POST["searchLastName"];
    if ($lastName != '')
        $query .= "AND lastname LIKE '" . $lastName . "%' ";

    $location = $_POST["location"];
    if ($location != '')
        $query .= "AND location_code = '" . $location . "' ";

    
    $position = $_POST["change_position_name"];
    if ($position != '')
        $query .= "AND job_code = '" . $position . "' ";  
    
    
    $department = $_POST["departmentName"];
    if ($department != '')
        $query .= "AND department_name = '" . $department . "' ";  
        

    $query .= "ORDER BY lastname, firstname";
  

    $result = mysqli_query($link, $query);   
    $num_rows = mysqli_affected_rows($link);
    


    
    $imgDirectory = "assets/images/directory/";

    if ($result && $num_rows > 0) { 
        while ($row = mysqli_fetch_assoc($result)) {
            
            $imgFile = "";
            
            if ($row['fileName'] != '')
            {
                $imgFile = "<img src='" . $imgDirectory . $row['fileName'] . "'/>";
            }
            else{
                $imgFile = "<img src='assets/images/directory/nophoto.jpg'/>";
            }
            
            echo "<div id='table'><tr><td>" . $imgFile . "<br>" . "</td></tr><tr><td>" . "<b>Name: </b>" . $row["firstname"] . " " . $row["lastname"] . "<br/>" . "<b>Hire Date:</b> " . $row["hireDate"] . "<br/>" . "<b>Number: </b>" . $row["convoNumber"] . "<br/>" . "<b>Position: </b>" . $row["position"] . "<br/>" . "<b>Department: </b>" . $row["department_name"] . "<br/>" . "<b>Location: </b>" . $row["convo_location"] . "<tr/><td/></div>";
            //echo "<a href=\"acknowledgement.php?ack_id=" . $row["ack_id"] . "\">" . $row["descr"] . "</a><br>";
        }
    }
    else {
        echo "No data on record";
    }
    
    
    
 
}
?>

<?php
    include("/assets/inc/footer.inc.php");
?>