<?php 
    $page_title = "Add Acknowledgement";
    error_reporting(0);
    $title = "Convo Portal | Add Acknowledgement";
    include("../core/init.php");
    admin_protect();
    protect_page();
    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");
    $url_empID = $_GET["employee_id"];

    $resultemployee = mysqli_query($link, "SELECT employee_id, firstname, lastname FROM convo_employee_vw WHERE employment_status ='Active' ORDER BY lastname, firstname");
    $ackResult = mysqli_query($link, "SELECT * FROM acknowledgement_type_vw");
    
    

$errorEmpName = $errorAckType =  "";

    if(isset($_POST["submit"])) {
        if(empty($_POST["employeeName"])){
            $errorEmpName = "<span class='error'> Please select an employee </span>";
        }
        
        if(empty($_POST["change_ack_type"])){
            $errorAckType = "<span class='error'> Please select an acknowledgement type </span>";
        }
        
            
        /*if(empty($_POST["employeeName"])) {
            $errorName = "<span class='error'>Please select the employee name</span>";  
        }
        if(empty($_POST["change_position_name"])){
            $errorPosition = "<span class='error'> Please select a position</span>";
        } */
          
            
        if($errorEmpName == "" && $errorAckType == "" ){

            $employeeID = sanitize($_POST["employeeName"]);
            $ack_type = sanitize($_POST["change_ack_type"]);
            $sql = "CALL insert_acknowledgement('$employeeID', '$ack_type', 1)";
            // die($sql);

            mysqli_query($link, $sql);

            echo "<h2 class='headerPages'>The employee's acknowledgement was added!</h2>";
            die();
        }
    }
    
?>


            <h1 class="headerPages">Add Acknowlegement</h1>
            <h3>To make any changes, select an employee from the list.</h3>

            <!-- EMPLOYEE INFORMATION -->
            <h2>Add Acknowledgement </h2>
            <form id="changes" action="add_acknowledgement.php" method="POST">
                
             <!-- EMPLOYEE -->    
                
                
                <span class="spanHeader">Employee: </span>
                <?php
                    echo "<select id='employeeName' name='employeeName'><option value=''>Select an employee</option>";
                    while($row = mysqli_fetch_assoc($resultemployee)) {
                        echo "<option value = '" . $row['employee_id'] . "'";
                        if(isset($_POST["submit"]) && $_POST["employeeName"] == $row['employee_id']){
                            echo "selected='selected'";
                        }

                        echo ">" . $row['lastname'] . ", " . $row["firstname"] . "</option>";   
                    }
                    echo "</select>";

                ?><?php echo $errorEmpName;?>
                
                <br/>
            
                
            <!-- ACK TYPE -->    
                <span class="spanHeader">Ack Type: </span>
                    <?php
                        echo "<select id='ack_type' class='input-xlarge' name='change_ack_type'><option value=''>Select an Ack Type</option>";
                        while($row = mysqli_fetch_assoc($ackResult)) {
                            echo "<option value ='" . $row['type'] . "'";
                             if(isset($_POST["submit"]) && $_POST["change_ack_type"] == $row['type']){
                                echo "selected='selected'";
                            }
                            echo ">" . $row['descr'] . "</option>";       
                        }
                        echo "</select>"; 
                    ?><?php echo $errorAckType; ?>

               <br/>
                
                <input type="submit" id="addButton" name="submit" value="Add">
            </form>
<?php
include("../assets/inc/footer.inc.php");
?>