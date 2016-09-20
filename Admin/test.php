<?php 
    $page_title = "New Employee Tracking";
    $title = "Convo Portal | Hire";
    include("../core/init.php");
    admin_protect();
    protect_page();

    include("../assets/inc/header.inc.php");
    include("../includes/includes_functions.php");

    $errorId = $errorName = $errorTitle = $errorLocation = $errorHire = $errorStart = "";

    if(isset($_POST["submit"])) {
        if(empty($_POST["employee_id"])) {
            $errorId = "<span class='error'> Please enter employee ID from Paychex</span>";   
        }
        else if($_POST["employee_id"]{0} == "C"){
            if(!(is_numeric($_POST["employee_id"]{1})) || !(is_numeric($_POST["employee_id"]{2})) || !(is_numeric($_POST["employee_id"]{3})) || strlen($_POST["employee_id"]) != 4){
                $errorId = "<span class='error'>If it is a contractor, please use \"C###\"</span>"; 
            }
        }
        else if(!(is_numeric($_POST["employee_id"]))){
            $errorId = "<span class='error'>Please enter numbers or first character 'C' for contractor</span>";   
        }
        else if(employee_id_exists($_POST["employee_id"]) == true) {
            $errorId = "<span class='error'>The employee ID exists in the database, please enter different employee ID</span>";   
        }
        if(empty($_POST["name"])) {
            $errorFirst = "<span class='error'>Please enter first name</span>";
        }
        
        if(empty($_POST["title"])) {
            $errorTitle = "<span class='error'>Please enter the title</span>";
        }
        
        if(empty($_POST["location"])) {
            $errorFirst = "<span class='error'>Please select location</span>";
        }
        
        
        if(empty($_POST["hire_date"])) {
            $errorFirst = "<span class='error'>Please enter the title</span>";
        }
        
        if(empty($_POST["start_date"])) {
            $errorFirst = "<span class='error'>Please enter the title</span>";
        }

        
        if($errorId == "" && $errorName == "" &&  $errorTitle == ""){
            $employee_id = sanitize($_POST["employee_id"]);
            $name = sanitize($_POST["name"]);
            $title = sanitize($_POST["title"]);

        
            // Convert from MM-DD-YYYY to YYYY-MM-DD to follow the MySQL Date Format
            $hireDateInput = multiexplode(array("-", "/"), $hire_date);
            $hireDate = $hireDateInput[2] . "-" . $hireDateInput[0] . "-" . $hireDateInput[1];
            
            $dobInput = multiexplode(array("-", "/"), $dob);
            $date_of_birth = $dobInput[2] . "-" . $dobInput[0] . "-" . $dobInput[1];
            
            
            if(strlen($new_hire_id) > 0)
            {
                $sql = "CALL update_employee_hire('$new_hire_id', '$firstname', '$lastname', '$jobTitle', '$street_address');";
                //echo $sql;
                //die();
                mysqli_query($link, $sql);
            }
            else
            {
                //mysqli_query($link, "CALL insert_employee_hire('$employee_id', '$firstname', '$lastname', '$jobTitle', '$street_address');");
            }
            
            
                
            //echo "<h2 class='headerPages'>The employee's information was added to database successfully!</h2>";
            die();      
        }
    }
?>
    
            <h1 class="headerPages">Update employee</h1>
            <h3>Please update employee's checklist below.</h3>

            <form id="hire" method="POST">

                <!-- Personal Information -->
                <h2>Personal Information</h2>
                
                <span class="spanHeader">NEO:</span>
                <?php   
                        echo "<select id='new_hire' name='new_hire'>";
                        echo "<option value=''>Select NEO</option>";
                        while($row = mysqli_fetch_assoc($resultNewHire)) 
                        {
                            echo "<option value ='" . 
                                $row['employee_id'] . "|" . 
                                $row['name'] . "|" . 
                                "'";

                            echo ">" . $row['lastname'] . ", " . $row["firstname"] . "</option>";   
                        }
                        echo "</select>";
                ?><input type="hidden" name="hide_employee_id" value="<?php if(isset($_POST["submit"])){echo $_POST["hide_employee_id"];} ?>"><br/><br/>
                

               <!-- First Name -->
                <span class="spanHeader">Name: </span>
                <input type="text" id="name" name="name" size="10" maxlength="40" placeholder="Name" readonly value=<?php if(isset($_POST["submit"])){echo $_POST['name'];} ?>><?php echo $errorName; ?><br/><br/>
                
                <!-- Title -->
                <span class="spanHeader">Title: </span>
                <input type="text" id="title" name="title" size="10" maxlength="40" placeholder="Title" readonly value=<?php if(isset($_POST["submit"])){echo $_POST['title'];} ?>><?php echo $errorTitle; ?><br/><br/>

                <span class="spanHeader">Location: </span>
                <input type="text" id="title" name="title" size="10" maxlength="40" placeholder="Location" readonly value=<?php if(isset($_POST["submit"])){echo $_POST['location'];} ?>><?php echo $errorTitle; ?><br/><br/>
<br/><br/>
                
            <span class="spanHeader">Hire Date:</span>
                <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="hire_date" readonly value=<?php if(isset($_POST["submit"])){echo $_POST['hire_date'];} ?>><?php echo $errorHire; ?><br/><br/>
                
                <span class="spanHeader">Start Date:</span>
                <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="start_date" readonly value=<?php if(isset($_POST["submit"])){echo $_POST['start_date'];} ?>><?php echo $errorStart; ?>
                
                
                <br/><br/><br/>
                
                <h1> On-boarding </h1>
                
            
                <!--<div class = "checklistcenter -->
                    <p> Received DL</p>
                
                    <form action="">

                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>
                    </form>    
                <!--</div> -->
                
               <!-- <div class="checklistright"> -->
                
                    <p> Received SSN </p>

                    <form action="">

                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>        
                    </form>
                <!--</div> -->
                    
                    
                <p> Background request received </p>
                    
                
                <form action="">
                <input type="radio" value="Yes"> Yes  <br/>
                <input type="radio" value="No"> No  <br/>
                <input type="radio" value="notapplicable"> Not Applicable <br/><br/>        
                </form>
                
                
               <div class="checklistcenter">
                    <p> Background cleared? </p>
                    <form action="">    
                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>   
                    </form>
                
    
                
                    <p> W-4 received </p>

                    <form action="">
                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>  

                    </form> 
                
                     
        
                <p> I-9 form received </p>
                 
                <form action="">
                
                <input type="radio" value="Yes"> Yes  <br/>
                <input type="radio" value="No"> No  <br/>
                <input type="radio" value="notapplicable"> Not Applicable <br/><br/>               
                    
                   </form>
                    
                </div>   
                   
                
                <div class="checklistright">

                
                    <p> Direct Deposit received </p>

                    <form action="">    
                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>                   
                    </form>
            
    
                    <p> Training Email sent out </p>
                    <form action="">   
                    <input type="radio" value="Yes"> Yes  <br/>
                    <input type="radio" value="No"> No  <br/>
                    <input type="radio" value="notapplicable"> Not Applicable <br/><br/>  
                    </form>
                    
                
                    
                <p> Employee agreement </p>
                
                <form action="">    
                <input type="radio" value="Yes"> Yes  <br/>
                <input type="radio" value="No"> No  <br/>
                <input type="radio" value="notapplicable"> Not Applicable <br/><br/>       
                </form> 
                
                </div>

                <br/>
                <br/>
                <br/>
                <br/>
                    
                <h1> Video Interpreters </h1>
                
                <form action="">
                
                <input type="checkbox" value="set up"> Signed Confidentiality <br/>
                <input type="checkbox" value="set up"> Signed Guideline <br/>
                <input type="checkbox" value="set up"> Signed SCF <br/>
                <input type="checkbox" value ="set up"> POC signature  <br/>
                
                    
                <br/>


                </form>
                
                
                <div id="nonvis">
                <h1> Non-Video Interpreters </h1>
                
                <form action="">
               
                <input type="checkbox" value="set up"> Signed Employee agreement <br/>
                <input type="checkbox" value="set up"> HelpDesk access requested <br/>
                <input type="checkbox" value="set up"> Setup work email <br/>
                <input type="checkbox" value="set up"> WPN received <br/>
                <input type="checkbox" value="set up"> WPN acknowledgement signed <br/>


                </form>
                </div>
                
                <div id="paychex">                
                <h1> PayChex </h1>
                
                <form action="">
                <input type="checkbox" value="set up"> PayChex set up <br/>
                <input type="checkbox" value="set up"> Portal set up <br/>
                <input type="checkbox" value="set up"> Communicate with EE to register for Portal access <br/>
                <input type="checkbox" value="set up"> Deductions set up<br/>
    
                </form>
                    
                <textarea rows="4" cols="15">
                
                </textarea>
                
                </div>
                
                <h1> Benefits Coverage </h1>
                <p> Effective Date:</p>
                <input type="text" placeholder="MM/DD/YYYY" class="datepicker" name="effective_date" value="<?php if(!empty($future_date)){echo $future_date;}?>">

                
                <form action="">
                    
                <p>Enrollment form received</p>    
                <input type="radio" value="Yes"> Yes  <br/>
                <input type="radio" value="No"> No  <br/>
                <input type="radio" value="No"> N/A  <br/>
                <input type="radio" value="waivered"> Waivered <br/> <br/>
                
                
            
            
                <p>Enrollment Confirmed</p>
                <input type="radio" value="Yes"> Yes <br/>
                <input type="radio" value="No"> No  <br/>
                <input type="radio" value="notapplicable"> Not Applicable <br/>
            
    
                </form>
            
            
            

                <input type="submit" id="updateButton" name="submit" value="Update">
            </form>
<?php
    include("../assets/inc/footer.inc.php");
?>
