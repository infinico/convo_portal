<?php 
    ob_start();
    $title = "Convo Portal";
    include("core/init.php");
    include("assets/inc/header.inc.php");
    include("includes/includes_functions.php");
    //include("includes/widgets/login.php"); 
    $resultemployee = mysql_query("SELECT * FROM employee_info_vw");


    if(isset($_POST["submit"])){
        echo "Submit";
        if(empty($_POST["employeeName"])){
            echo "EMPTY";   
        }
        else{
            echo "EMPLOYEE NAME";
            $_SESSION['employee_id'] = $_POST["employeeName"];
            $session_user_id = $_SESSION['employee_id'];
            test_employee_id($session_user_id);
            //echo $session_user_id;
            
            //$_SESSION['employee_id'] = $login;
        
        $user_data = user_data($session_user_id, 'employee_id', "email", "supervisor_id", 'username', 'password', 'firstname', 'lastname', 'job_code', 'payroll_status', 'location_code', 'res_state', 'password_recover', 'date_of_birth', 'ssn', 'street_address', 'city', 'zipcode', 'job_code', 'hire_date');
            //echo $user_data["username"] . "<br/>" . $user_data["password"];
            header("Location: index.php");
            exit();
            /*
            if((login($user_data["username"], $user_data["password"])) == true){
                //echo "HELLO";
                
            }*/
        }
    }
?>


<h1 class="headerPages">Impersonate Employee</h1>

    <form id="impersonateEmployee" method="POST">
        <span class="spanHeader">Employee: </span>
        <?php
            echo "<select id='employeeName' name='employeeName'><option value=''>Select an employee</option>";
            while($row = mysql_fetch_assoc($resultemployee)) {
                echo "<option value = '" . $row['employee_id'] . "'";
                
                echo ">" . $row['lastname'] . ", " . $row["firstname"] . "</option>";   
            }
            echo "</select>";?>
        
        
        <input type="submit" name="submit" value="Next"/>
        
    </form>


<?php
    include("includes/overall/footer.php"); 
?>