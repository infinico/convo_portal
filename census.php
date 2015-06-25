<?php 
    $title = "Convo Portal | Census";
    include("core/init.php");
    //census_protect();
    include("includes/overall/header.php");
    error_reporting(0);

    $result = mysql_query("SELECT * FROM employee");
    $employeeID = $user_data["employeeID"];
    $displayNone = $displaySuccess = "";
    $displayFirstSubmit = "style='display:inline'";
    $displaySecondSubmit = "style='display:none'";
    $firstname[] = $lastname[] = $dob[] = $relationship[] = $gender[] = "";

    if(isset($_POST["button"]) || isset($_POST["submit"])) {
        if(!empty($_POST["firstname0"])){
            $firstname[1] = $_POST["firstname0"];
        }
        else{
            $firstname[1] = "NULL";   
        }

        if(!empty($_POST["firstname1"])){
            $firstname[2] = $_POST["firstname1"];
        }
        else{
            $firstname[2] = "NULL";   
        }

        if(!empty($_POST["firstname2"])){
            $firstname[3] = $_POST["firstname2"];
        }
        else{
            $firstname[3] = "NULL";   
        }
        if(!empty($_POST["firstname3"])){
            $firstname[4] = $_POST["firstname3"];
        }
        else{
            $firstname[4] = "NULL";   
        }
        if(!empty($_POST["firstname4"])){
            $firstname[5] = $_POST["firstname4"];
        }
        else{
            $firstname[5] = "NULL";   
        }

        if(!empty($_POST["lastname0"])){
            $lastname[1] = $_POST["lastname0"];
            //echo $lastname[1];
        }
        else{
            $lastname[1] = "NULL";   
        }

        if(!empty($_POST["lastname1"])){
            $lastname[2] = $_POST["lastname1"];
            //echo $lastname[2];
        }
        else{
            $lastname[2] = "NULL";   
        }

        if(!empty($_POST["lastname2"])){
            $lastname[3] = $_POST["lastname2"];
            //echo $lastname[3];
        }
        else{
            $lastname[3] = "NULL";   
        }

        if(!empty($_POST["lastname3"])){
            $lastname[4] = $_POST["lastname3"];
            //echo $lastname[4];
        }
        else{
            $lastname[4] = "NULL";   
        }
        if(!empty($_POST["lastname4"])){
            $lastname[5] = $_POST["lastname4"];
            //echo $lastname[5];
        }
        else{
            $lastname[5] = "NULL";   
        }

        if(!empty($_POST["dob0"])){
            $dob[1] = $_POST["dob0"];
            //echo $dob[1];
        }
        else{
            $dob[1] = "NULL";   
        }

        if(!empty($_POST["dob1"])){
            $dob[2] = $_POST["dob1"];
            //echo $dob[2];
        }
        else{
            $dob[2] = "NULL";   
        }

        if(!empty($_POST["dob2"])){
            $dob[3] = $_POST["dob2"];
            //echo $dob[3];
        }
        else{
            $dob[3] = "NULL";   
        }

        if(!empty($_POST["dob3"])){
            $dob[4] = $_POST["dob3"];
            //echo $dob[4];
        }
        else{
            $dob[4] = "NULL";   
        }
        if(!empty($_POST["dob4"])){
            $dob[5] = $_POST["dob4"];
            //echo $dob[5];
        }
        else{
            $dob[5] = "NULL";   
        }

        if(!empty($_POST["gender0"])){
            $gender[1] = $_POST["gender0"];
        }
        else{
            $gender[1] = "NULL";   
        }

        if(!empty($_POST["gender1"])){
            $gender[2] = $_POST["gender1"];
        }
        else{
            $gender[2] = "NULL";   
        }

        if(!empty($_POST["gender2"])){
            $gender[3] = $_POST["gender2"];
        }
        else{
            $gender[3] = "NULL";   
        }

        if(!empty($_POST["gender3"])){
            $gender[4] = $_POST["gender3"];
        }
        else{
            $gender[4] = "NULL";   
        }
        if(!empty($_POST["gender4"])){
            $gender[5] = $_POST["gender4"];

        }
        else{
            $gender[5] = "NULL";   
        }

        if(!empty($_POST["relationship0"])){
            $relationship[1] = $_POST["relationship0"];
            //echo $relationship[1];
        }
        else{
            $relationship[1] = "NULL";   
        }

        if(!empty($_POST["relationship1"])){
            $relationship[2] = $_POST["relationship1"];
            //echo $relationship[2];
        }
        else{
            $relationship[2] = "NULL";   
        }

        if(!empty($_POST["relationship2"])){
            $relationship[3] = $_POST["relationship2"];
            //echo $relationship[3];
        }
        else{
            $relationship[3] = "NULL";   
        }

        if(!empty($_POST["relationship3"])){
            $relationship[4] = $_POST["relationship3"];
            //echo $relationship[4];
        }
        else{
            $relationship[4] = "NULL";   
        }
        if(!empty($_POST["relationship4"])){
            $relationship[5] = $_POST["relationship4"];
            //echo $relationship[5];
        }
        else{
            $relationship[5] = "NULL";   
        }

        if($firstname[$i] != "NULL" && $lastname[$i] != "NULL" && $dob[$i] != "NULL" && $relationship[$i] != "NULL" && $gender[$i] != "NULL"){


            if(isset($_POST["submit"])){
                mysql_query("DELETE FROM census WHERE employerID = '$employeeID'");

                for ($i = 1; $i <= 5; $i++){
                    if($firstname[$i] != "NULL" && $lastname[$i] != "NULL" && $dob[$i] != "NULL" && $relationship[$i] != "NULL" && $gender[$i] != "NULL"){

                        $dobInput = explode("-", $dob[$i]);
                        $date_of_birth[$i] = $dobInput[2] . "-" . $dobInput[0] . "-" . $dobInput[1];

                        mysql_query("INSERT INTO census (employerID, firstname, lastname, date_of_birth, gender, relationship) VALUES ('$employeeID', '$firstname[$i]', '$lastname[$i]', '$date_of_birth[$i]', '$gender[$i]', '$relationship[$i]')");
                    }
                }
                $displaySuccess = "style = 'display: none'";
                echo "<h1 class='headerPages'>You have submitted successfully!</h1>";
                exit();
            }
            echo "<div " . $displaySuccess . ">";
            echo "<h1 class='headerPages'>Review Information</h1><br/><h2>Please review your dependents' information for accuracy.</h2>";

            $x = "<table class='table table-bordered table-hover' id='tab_logic'>";
            $x .= "<thead><tr>";
            $x .= "<th>No.</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Gender</th><th>Relationship</th>";
            $x .= "</thead></tr><tbody>";

            for ($i = 1; $i <= 5; $i++){

                if($firstname[$i] != "NULL" && $lastname[$i] != "NULL" && $dob[$i] != "NULL" && $relationship[$i] != "NULL" && $gender[$i] != "NULL"){

                    $x .= "<tr><td>" . $i . "</td><td>" . $firstname[$i] . "</td><td>" . $lastname[$i] . "</td><td>" . $dob[$i] . "</td><td>" . $gender[$i] . "</td><td>" . $relationship[$i] . "</td></tr>"; 
                }
            }
            $x .= "</tbody></table>";
            echo $x;
            echo "</div>";
            $displayNone = "style='display:none'";
            $displayFirstSubmit = "style='display:none'";
            $displaySecondSubmit = "style = 'display: inline'";
        }
    }

    // SELECT values from the employeeID to insert values into the input types
    $query = "SELECT * FROM census WHERE employerID = '$employeeID'";
    $result = mysqli_query($link, $query);
    $num_rows = mysqli_affected_rows($link);

    $i = 0;

    if ($result && $num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //echo $row["employerID"] . $row["firstname"];  
                $firstnameRow[$i] = $row["firstname"];
                $lastnameRow[$i] = $row["lastname"]; 
                $dobRow[$i] = $row["date_of_birth"]; 
                
                $dobInput = explode("-", $dobRow[$i]);
                $date_of_birth_row[$i] = $dobInput[1] . "-" . $dobInput[2] . "-" . $dobInput[0];
                $genderRow[$i] = $row["gender"]; 
                $relationshipRow[$i] = $row["relationship"]; 
                $i++;
            
        }
    }
?>
<script>
    function goBack() {
       window.history.back();
    }
</script>

<h1 <?php echo $displayNone; ?> class="headerPages">Employee Census Information</h1>

<?php  
    echo "<h2 " . $displayNone . ">Our records show you live at: " . $user_data["street_address"] . ", " . $user_data["city"] . ", " . $user_data["res_state"] . " " . $user_data["zipcode"] . "</h2>";
?>

<p <?php echo $displayNone; ?>>If your home address is incorrect, please contact HR at <a href="mailto:hr@convorelay.com">hr@convorelay.com</a></p>

<p <?php echo $displayNone; ?>>Please enter your dependents' information below, even if you do not plan to enroll for health insurance, or if you only intend to request coverage for yourself.  This census information will be used by Convo while comparing costs for health insurance vendors. It does <strong>NOT</strong> mean you will be enrolling them for health insurance.
</p>
<form action="census.php" id="myForm" method="POST">
<div class="container" <?php echo $displayNone; ?>>
    <div class="row clearfix">
    	<div class="col-sm-2 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead>
					<tr>
						<th class="text-center">
							First Name
						</th>
						<th class="text-center">
							Last Name
						</th>
						<th class="text-center">
							Date of Birth <br/>(MM-DD-YYYY)
						</th>
                        <th class="text-center">
							Gender
						</th>
    					<th class="text-center">
							Relationship
						</th>
					</tr>
				</thead>
				<tbody>
                    <!-- DEPENDENT INFORMATION 1 starts -->
    				<tr id='dependent_information0' name="dependent_information0" data-id="0" class="hidden">
						<td data-name="firstname">
						    <input type="text" name='firstname0' placeholder='First Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['firstname0'];}else{ echo $firstnameRow[0]; } ?>"/>
						</td>
						<td data-name="lastname">
						    <input type="text" name='lastname0' placeholder='Last Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['lastname0'];}else{ echo $lastnameRow[0]; } ?>"/>
						</td>
						<td data-name="dob">
						    <input type="text" name="dob0" class="datepicker" placeholder="MM-DD-YYYY" value="<?php if(isset($_POST["button"])){echo $_POST['dob0'];}else{ echo $date_of_birth_row[0]; } ?>"/>
						</td>                
						<td data-name="gender">
						    <select name="gender0">
                                <option value="">Select one</option>
                                <option value="Male" <?php if(isset($_POST["button"]) && $_POST["gender0"] == "Male"){echo "selected='selected'";}else if($genderRow[0] == "Male") { echo "selected='selected'";} ?>>Male</option>
                                <option value="Female" <?php if(isset($_POST["button"]) && $_POST["gender0"] == "Female"){echo "selected='selected'";}else if($genderRow[0] == "Female") { echo "selected='selected'";} ?>>Female</option>                          
                            </select>
						</td>
    					<td data-name="relationship">
						    <select name="relationship0">
        				        <option value="">Select Option</option>
    					        <option value="Employee" <?php if(isset($_POST["button"]) && $_POST["relationship0"] == "Employee"){echo "selected='selected'";}else if($relationshipRow[0] == "Employee"){ echo "selected='selected'"; } ?>>Employee</option>
        				        <option value="Spouse/Domestic Partner" <?php if(isset($_POST["button"]) && $_POST["relationship0"] == "Spouse/Domestic Partner"){echo "selected='selected'";}else if($relationshipRow[0] == "Spouse/Domestic Partner"){ echo "selected='selected'"; } ?>>Spouse/Domestic Partner</option>
        				        <option value="Child" <?php if(isset($_POST["button"]) && $_POST["relationship0"] == "Child"){echo "selected='selected'";}else if($relationshipRow[0] == "Child"){ echo "selected='selected'"; } ?>>Child</option>
						    </select>
						</td>
					</tr>
                    <!-- DEPENDENT INFORMATION 1 ends -->
                    
                    <!-- DEPENDENT INFORMATION 2 starts -->
                    <tr id='dependent_information1' name="dependent_information1" data-id="1" class="hidden">
						<td data-name="firstname">
						    <input type="text" name='firstname1'  placeholder='First Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['firstname1'];}else{ echo $firstnameRow[1]; } ?>"/>
						</td>
						<td data-name="lastname">
						    <input type="text" name='lastname1' placeholder='Last Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['lastname1'];}else{ echo $lastnameRow[1]; } ?>"/>
						</td>
						<td data-name="dob">
						    <input type="text" name="dob1" class="datepicker" placeholder="MM-DD-YYYY" value="<?php if(isset($_POST["button"])){echo $_POST['dob1'];}else{ echo $date_of_birth_row[1]; } ?>"/>
						</td>
						<td data-name="gender">
						    <select name="gender1">
                                <option value="">Select one</option>
                                <option value="Male" <?php if(isset($_POST["button"]) && $_POST["gender1"] == "Male"){echo "selected='selected'";}else if($genderRow[1] == "Male") { echo "selected='selected'";} ?>>Male</option>
                                <option value="Female" <?php if(isset($_POST["button"]) && $_POST["gender1"] == "Female"){echo "selected='selected'";}else if($genderRow[1] == "Female") { echo "selected='selected'";} ?>>Female</option>                          
                            </select>
						</td>
    					<td data-name="relationship">
						    <select name="relationship1">
        				        <option value="">Select Option</option>
    					        <option value="Employee" <?php if(isset($_POST["button"]) && $_POST["relationship1"] == "Employee"){echo "selected='selected'";}else if($relationshipRow[1] == "Employee") { echo "selected='selected'";} ?>>Employee</option>
        				        <option value="Spouse/Domestic Partner" <?php if(isset($_POST["button"]) && $_POST["relationship1"] == "Spouse/Domestic Partner"){echo "selected='selected'";}else if($relationshipRow[1] == "Spouse/Domestic Partner") { echo "selected='selected'";} ?>>Spouse/Domestic Partner</option>
        				        <option value="Child" <?php if(isset($_POST["button"]) && $_POST["relationship1"] == "Child"){echo "selected='selected'";}else if($relationshipRow[1] == "Child") { echo "selected='selected'";} ?>>Child</option>
						    </select>
						</td>
					</tr>
                    <!-- DEPENDENT INFORMATION 2 ends -->
                    
                    <!-- DEPENDENT INFORMATION 3 starts -->
                    <tr id='dependent_information2' name="dependent_information2" data-id="2" class="hidden">
						<td data-name="firstname">
						    <input type="text" name='firstname2'  placeholder='First Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['firstname2'];}else{ echo $firstnameRow[2]; } ?>"/>
						</td>
						<td data-name="lastname">
						    <input type="text" name='lastname2' placeholder='Last Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['lastname2'];}else{ echo $lastnameRow[2]; } ?>"/>
						</td>
						<td data-name="dob">
						    <input type="text" name="dob2" class="datepicker" placeholder="MM-DD-YYYY" value="<?php if(isset($_POST["button"])){echo $_POST['dob2'];}else{ echo $date_of_birth_row[2]; } ?>"/>
						</td>
						<td data-name="gender">
						    <select name="gender2">
                                <option value="">Select one</option>
                                <option value="Male" <?php if(isset($_POST["button"]) && $_POST["gender2"] == "Male"){echo "selected='selected'";}else if($genderRow[2] == "Male") { echo "selected='selected'";} ?>>Male</option>
                                <option value="Female" <?php if(isset($_POST["button"]) && $_POST["gender2"] == "Female"){echo "selected='selected'";}else if($genderRow[2] == "Female") { echo "selected='selected'";} ?>>Female</option>                          
                            </select>
						</td>
    					<td data-name="relationship">
						    <select name="relationship2">
        				        <option value="">Select Option</option>
    					        <option value="Employee" <?php if(isset($_POST["button"]) && $_POST["relationship2"] == "Employee"){echo "selected='selected'";}else if($relationshipRow[2] == "Employee") { echo "selected='selected'";} ?>>Employee</option>
        				        <option value="Spouse/Domestic Partner" <?php if(isset($_POST["button"]) && $_POST["relationship2"] == "Spouse/Domestic Partner"){echo "selected='selected'";}else if($relationshipRow[2] == "Spouse/Domestic Partner") { echo "selected='selected'";} ?>>Spouse/Domestic Partner</option>
        				        <option value="Child" <?php if(isset($_POST["button"]) && $_POST["relationship2"] == "Child"){echo "selected='selected'";}else if($relationshipRow[2] == "Child") { echo "selected='selected'";}?>>Child</option>
						    </select>
						</td>
					</tr>
                    <!-- DEPENDENT INFORMATION 3 ends -->
                    
                    <!-- DEPENDENT INFORMATION 4 starts -->
                    <tr id='dependent_information3' name="dependent_information3" data-id="3" class="hidden">
						<td data-name="firstname">
						    <input type="text" name='firstname3'  placeholder='First Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['firstname3'];}else{ echo $firstnameRow[3]; } ?>"/>
						</td>
						<td data-name="lastname">
						    <input type="text" name='lastname3' placeholder='Last Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['lastname3'];}else{ echo $lastnameRow[3]; } ?>"/>
						</td>
						<td data-name="dob">
						    <input type="text" name="dob3" class="datepicker" placeholder="MM-DD-YYYY" value="<?php if(isset($_POST["button"])){echo $_POST['dob3'];}else{ echo $date_of_birth_row[3]; } ?>"/>
						</td>
						<td data-name="gender">
						    <select name="gender3">
                                <option value="">Select one</option>
                                <option value="Male" <?php if(isset($_POST["button"]) && $_POST["gender3"] == "Male"){echo "selected='selected'";}else if($genderRow[3] == "Male") { echo "selected='selected'";} ?>>Male</option>
                                <option value="Female" <?php if(isset($_POST["button"]) && $_POST["gender3"] == "Female"){echo "selected='selected'";}else if($genderRow[3] == "Female") { echo "selected='selected'";} ?>>Female</option>                          
                            </select>
						</td>
    					<td data-name="relationship">
						    <select name="relationship3">
        				        <option value="">Select Option</option>
    					        <option value="Employee" <?php if(isset($_POST["button"]) && $_POST["relationship3"] == "Employee"){echo "selected='selected'";}else if($relationshipRow[3] == "Employee") { echo "selected='selected'";} ?>>Employee</option>
        				        <option value="Spouse/Domestic Partner" <?php if(isset($_POST["button"]) && $_POST["relationship3"] == "Spouse/Domestic Partner"){echo "selected='selected'";}else if($relationshipRow[1] == "Spouse/Domestic Partner") { echo "selected='selected'";} ?>>Spouse/Domestic Partner</option>
        				        <option value="Child" <?php if(isset($_POST["button"]) && $_POST["relationship3"] == "Child"){echo "selected='selected'";}else if($relationshipRow[3] == "Child") { echo "selected='selected'";} ?>>Child</option>
						    </select>
						</td>
					</tr>
                    <!-- DEPENDENT INFORMATION 4 ends -->
                    
                    <!-- DEPENDENT INFORMATION 5 starts -->
                    <tr id='dependent_information4' name="dependent_information4" data-id="4" class="hidden">
						<td data-name="firstname">
						    <input type="text" name='firstname4'  placeholder='First Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['firstname4'];}else{ echo $firstnameRow[4]; } ?>"/>
						</td>
						<td data-name="lastname">
						    <input type="text" name='lastname4' placeholder='Last Name' class="form-control" value="<?php if(isset($_POST["button"])){echo $_POST['lastname4'];}else{ echo $lastnameRow[4]; } ?>"/>
						</td>
						<td data-name="dob">
						    <input type="text" name="dob4" class="datepicker" placeholder="MM-DD-YYYY" value="<?php if(isset($_POST["button"])){echo $_POST['dob4'];}else{ echo $date_of_birth_row[4]; } ?>"/>
						</td>
						<td data-name="gender">
						    <select name="gender4">
                                <option value="">Select one</option>
                                <option value="Male" <?php if(isset($_POST["button"]) && $_POST["gender4"] == "Male"){echo "selected='selected'";}else if($genderRow[4] == "Male") { echo "selected='selected'";} ?>>Male</option>
                                <option value="Female" <?php if(isset($_POST["button"]) && $_POST["gender4"] == "Female"){echo "selected='selected'";}else if($genderRow[4] == "Female") { echo "selected='selected'";} ?>>Female</option>                          
                            </select>
						</td>
    					<td data-name="relationship">
						    <select name="relationship4">
        				        <option value="">Select Option</option>
    					        <option value="Employee" <?php if(isset($_POST["button"]) && $_POST["relationship4"] == "Employee"){echo "selected='selected'";}else if($relationshipRow[4] == "Employee") { echo "selected='selected'";} ?>>Employee</option>
        				        <option value="Spouse/Domestic Partner" <?php if(isset($_POST["button"]) && $_POST["relationship4"] == "Spouse/Domestic Partner"){echo "selected='selected'";}else if($relationshipRow[4] == "Spouse/Domestic Partner") { echo "selected='selected'";} ?>>Spouse/Domestic Partner</option>
        				        <option value="Child" <?php if(isset($_POST["button"]) && $_POST["relationship4"] == "Child"){echo "selected='selected'";}else if($relationshipRow[4] == "Child") { echo "selected='selected'";} ?>>Child</option>
						    </select>
						</td>
					</tr>
                    <!-- DEPENDENT INFORMATION 5 ends -->
                    
				</tbody>
			</table>
		</div>    <!-- TABLE responsive ends -->
	</div>
</div>
    <button class="btn-success" name="button"<?php echo $displayFirstSubmit; ?>>Review</button>
    <button class="btn-success" name="Edit" <?php echo $displaySecondSubmit; ?> onclick="goBack();">Edit</button>
    <input type="submit" class="btn-success" value = "Submit" name="submit" <?php echo $displaySecondSubmit; ?>>
</form>

<?php
    include("includes/overall/footer.php"); 
?>