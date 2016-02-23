<?php 
    $page_title = "Email Directory";
    $title = "Convo Portal | Email";

    include("../core/init.php");
    include("../assets/inc/header.inc.php");
    admin_protect();
    protect_page();

    global $link;

    /* Displays the list of departments */
    $resultEmail = mysqli_query($link, "SELECT 'ALL' dept_code, 'All Departments' department_name UNION SELECT dept_code, department_name FROM department"); 
    
    /* Displays the list of Convo locations */
    $resultLocation= mysqli_query($link, "SELECT location_code, convo_location FROM location WHERE active = 'Y' ORDER BY convo_location"); 
    

    

/*----------------------------------------------------------------------------------------- */

   
?>

<h1 class="headerPages">Email Directory</h1>

    <form id="emailDirectory" method="post">
        <span class="spanHeader">Department: </span>
        <?php
            echo "<select id='departmentName' name='departmentName'><option value=''>Select a department</option>";
            while($row = mysqli_fetch_assoc($resultEmail)) {
                
                
                echo "<option value = '" . $row['dept_code'] . "'";
                
                if(isset($_POST["submit"]) && $_POST["departmentName"] == $row['dept_code']){
                    echo "selected= 'selected'";    
                }
                
                echo ">" . $row["department_name"] . "</option>";   
            }
            echo "</select>";?>
        
        <br/>
        

        
        
        <span class="spanHeader">Location: </span>

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

        
        <input type="submit" name="submit" value="Search"/>
        
    </form>

<!-- LIST OF NAMES FROM EMAILS -->
<h2> Name </h2>
<div class="columnLeft">
 <?php       
    if(isset($_POST["submit"])){
        //echo "Submit";
        //echo "Hello" . $_POST["departmentName"];
        if(!(isset($_POST["departmentName"]))){
            echo "EMPTY";   
        }
        else{
            
            
            $deptCode = $_POST["departmentName"];
            $sql = "SELECT firstname, lastname FROM convo_employee_vw WHERE employment_status = 'Active' ";
            
            if ($deptCode != "ALL")
            {
                $sql .= "AND job_code IN(SELECT job_code FROM position_type WHERE dept_code = '$deptCode') ";
            }
            
            $location = $_POST["location"];
            if ($location != "")
            {
                $sql .= "AND location_code = '" . $location . "' ";
            }
            $sql .= "ORDER BY lastname, firstname";
            
            /*echo "SELECT email FROM employee 
WHERE job_code IN(SELECT job_code FROM position_type WHERE dept_code = '$deptCode')
AND (employment_status = 'Active')"; */
            $name_query = mysqli_query($link, $sql);
            
            while($row = mysqli_fetch_assoc($name_query)){
                echo "<p>" . $row["firstname"] . " " . $row["lastname"] . "</p>";
            }

        }
    }
?>
</div>


<!-- LIST OF EMAILS -->
<div class="columnRight">

<h2> Email </h2>

 <?php       
    if(isset($_POST["submit"])){
        //echo "Submit";
        //echo "Hello" . $_POST["departmentName"];
        if(!(isset($_POST["departmentName"]))){
            echo "EMPTY";   
        }
        

        
        else{
            
            
            $deptCode = $_POST["departmentName"];
            $sql = "SELECT email FROM convo_employee_vw WHERE employment_status = 'Active' ";
            
            if ($deptCode != "ALL")
            {
                $sql .= "AND job_code IN(SELECT job_code FROM position_type WHERE dept_code = '$deptCode') ";
            }
            
            $location = $_POST["location"];
            if ($location != "")
            {
                $sql .= "AND location_code = '" . $location . "' ";
            }
            $sql .= "ORDER BY lastname, firstname";
            $email_query = mysqli_query($link, $sql);

        
            while($row = mysqli_fetch_assoc($email_query)){
                //if(is_null($row['email'])){
                if($row['email'] ==  ""){
                    $email = "&nbsp;";
                }
                else
                {
                    $email = $row['email'];
                }
                //if ($row["email"].length
                
                echo "<p>" . $email . "</p>";
            }

        }
    }
?>
</div>

<?php
    include("../assets/inc/footer.inc.php");
?>