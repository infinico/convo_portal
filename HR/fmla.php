<?php
    $page_title = "Family Medical Leave";
    $title = "Convo Portal | Family Medical Leave";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    protect_page();
    include("../assets/inc/header.inc.php");



    $errorType = $errorLeave = $errorReturn = $errorUnknownDate = $errorLeaveReason = $dayDiffError = "";


    if(isset($_POST["submitRequest"])){
        if(empty($_POST["requestType"])){
            $errorType = "<span class='error'>Please select one of these choices</span>";   
        }
        if(empty($_POST["expectedLeave"])){
            $errorLeave = "<span class='error'>Please enter the expected date of leave</span>";   
        }
        if((empty($_POST["expectedReturn"]) && isset($_POST["unknownDate"])) || (!(empty($_POST["expectedReturn"])) && !(isset($_POST["unknownDate"])))){
            //$errorReturn = "<span class='error'>Please enter the expected date of return or check unknown date</span>";   
        }
        else if(!(empty($_POST["expectedReturn"])) && isset($_POST["unknownDate"])){
            $errorReturn = "<span class='error'>Please either enter the date or check the box</span>";
        }
        else{
            $errorReturn = "<span class='error'>Please enter the expected date of return or check unknown date</span>";   
        }
        if(empty($_POST["leaveReason"])){
            $errorLeaveReason = "<span class='error'>Please select one of these reasons</span>";   
        }
        if($errorType == "" && $errorLeave == "" && $errorReturn == "" && $errorLeaveReason == ""){
            $requestType = sanitize($_POST["requestType"]);  
            $expectedLeave = sanitize($_POST["expectedLeave"]);
            $expectedReturn = sanitize($_POST["expectedReturn"]);
            $leaveReason = sanitize($_POST["leaveReason"]);
            
            $expectedLeaveInput = multiexplode(array("-", "/"), $expectedLeave);
            $expectedLeave = $expectedLeaveInput[2] . "-" . $expectedLeaveInput[0] . "-" . $expectedLeaveInput[1];
            
            if(isset($_POST["unknownDate"])){
                $expectedReturn = "01/01/1900";
            }
            $expectedReturnInput = multiexplode(array("-", "/"), $expectedReturn);
            $expectedReturn = $expectedReturnInput[2] . "-" . $expectedReturnInput[0] . "-" . $expectedReturnInput[1];
            
            $day_diff= (strtotime($expectedReturn) - strtotime($expectedLeave)) / (60 * 60 * 24);
            
            if($day_diff >= 90) {
                $dayDiffError = "<span class='error'>You cannot be on leave for more than 90 days.</span>";   
            }
            else if($day_diff < 0 && !isset($_POST["unknownDate"])) {
                $dayDiffError = "<span class='error'>Return date cannot be earlier than expected date of leave.</span>";   
            }
            else {
                mysqli_query($link, "CALL insert_fmla('$session_user_id', CURRENT_TIMESTAMP, '$requestType', '$expectedLeave', '$expectedReturn', '$leaveReason', 'R');");
            //echo "CALL insert_fmla('$session_user_id', CURRENT_TIMESTAMP, '$requestType', '$expectedLeave', '$expectedReturn', '$leaveReason', 'R')";
            
            $fmla_info = "<strong>Employee Name:</strong> " . $user_data["firstname"] . " " . $user_data["lastname"] . "<br/>";
            $fmla_info .= "<strong>Family Medical Leave Request Type:</strong> " . $requestType . "<br/>";
            $fmla_info .= "<strong>Expected Effective Date of Leave:</strong> " . $_POST["expectedLeave"] . "<br/>";
            if(isset($_POST["unknownDate"])) {
                $fmla_info .= "<strong>Exepcted Date of Return:</strong> Unknown <br/>";
            }
            else {
                 $fmla_info .= "<strong>Exepcted Date of Return:</strong> " . $_POST["expectedReturn"] . "<br/>";
            }
            $fmla_info .= "<strong>Leave is being requested for:</strong> " . $leaveReason . "<br/>";
            
            newEmail($user_data['email'], $user_data["firstname"], $user_data["lastname"], 'Family Medical Leave Request', $fmla_info);
            
            echo "<h2 class='headerPages'>Thank you for submitting your Family Medical Leave request. This request has been sent to HR.</h2>";
            die();   
            } 
        }
    }
?>

            <h1 class="headerPages">Family and Medical Leave of Absence</h1>

            <!-- General Provisions -->
            <h2 class="fmla_header">General Provisions</h2>
            <p>The Family and Medical Leave Act of 1993 (FMLA) is enforced by the Wage and Hour Division of the U.S. Department of Labor. It requires covered employers to grant up to 12 workweeks of unpaid leave in a 12 month period with job restoration and continuation of benefits to Eligible Employees who need to care for themselves or qualified family members. Qualified family member means spouse/domestic partner, child and parent.</p><br/>

            <!-- Eligible Employee -->
            <h2 class="fmla_header">Eligible Employee</h2>
            <p>For purposes of Family and Medical Leave (FML), an “Eligible Employee” means an employee who has:</p>
            <ol class="fmla_list_order">
                <li>been employed with Convo for at least 12 months prior to the requested leave, and </li>
                <li>worked a minimum of 1,250 hours in the prior 12 month period immediately preceding the leave. </li>
            </ol><br/>

            <!-- Qualifying Events -->
            <h2 class="fmla_header">Qualifying Events</h2>
            <p>The following describe qualifying events for the leave:</p>
            <ul class="fmla_list">
                <li>Birth of a child, adoption of a child, or placement of a foster child </li>
                <li>To care for employee’s spouse/domestic partner, child (18 years or younger or incapable of self-care if older), or parent with a serious health condition</li>
                <li>A serious health condition for the employee that renders him or her unable to perform the essential functions of the position held or</li>
                <li>For any qualifying exigency arising out of the fact that a spouse, son, daughter, or parent is a military member on covered active duty or call to covered active duty status.</li>
            </ul><br/>

            <!-- Leave Rights and Obligations -->
            <h2 class="fmla_header">Leave Rights and Obligations</h2>
            <p>Leave may be taken for up to 12 weeks in a 12 month period when required by a serious health condition as described in the list of qualifying events above. For further clarification of FML and its application to employees, please contact Human Resources. Employees are generally required to give a 30- day written notice of intent to utilize their FML if the leave is foreseeable. Written notice should be submitted to both the employee’s supervisor and Human Resources. In the event of an emergency or for foreseeable events occurring in less than 30 days, employees must notify Human Resources as soon as they can reasonably do so.
            </p>

            <p>Convo reserves the right to require the employee to provide written medical certification of a serious medical condition for both self and dependents. Forms may be obtained from Human Resources. Convo also reserves the right to require second or third medical opinions (at Convo’s expense) and periodic recertification of a serious health condition. Benefits will be continued throughout the duration of the FML under each employee’s current Active Status terms and conditions.</p>

            <p>Employees are ensured reinstatement to their current position, unless:</p>

            <ul class="fmla_list">
                <li>The current position has been eliminated due to reorganization or layoffs</li>
                <li>The employee fraudulently obtained the leave</li>
                <li>The employee gives unequivocal notice that he or she does not intend to return to work</li>
                <li>The employee fails to return to work after the 12-week leave expires, or</li>
                <li>Any other reason permitted by law</li>
            </ul>
            <p>If the employee chooses not to return from FML, he or she may be liable for repayment of premiums for medical benefits paid on the employee’s behalf while on FML.</p><br/>

            <!-- Intermittent Family Medical Leave -->
            <h2 class="fmla_header">Intermittent Family Medical Leave</h2>
            <p>The Family Medical Leave Act permits employees to take leave on an intermittent basis or to work a reduced schedule under certain circumstances (CFR Section 203). Intermittent/reduced scheduled leave may be taken when medically necessary to care for a seriously ill family member, or because of the employee’s serious health condition. Intermittent/reduced schedule leave may be taken to care for a newborn or newly placed adopted or foster care child only with the employer’s approval.</p>

            <p>Only the amount of leave actually taken while on intermittent/reduced schedule leave may be charged as FML. Employees may not be required to take more FML leave than necessary to address the circumstances that cause the need for leave. Employers may account for FML leave in the shortest period of time that their payroll systems use, provided it is one hour or less (CFR Section 825-205).</p>

            <p>Employees needing intermittent/reduced schedule leave for foreseeable medical treatment must work with their employers to schedule the leave so as to not unduly disrupt the employer’s operations, subject to the approval of the employee’s health care provider.</p>
            <br/>

            <!-- Family Medical Leave Request Form -->
            <h2 class="fmla_header">Family Medical Leave Request Form</h2><br/>


            <form id="form" action="<?php $location = $_SERVER['PHP_SELF']; echo ''.$location.'#form';?>" method="post">
                <?php if(isset($_POST["submitRequest"])){ echo $errorType; } ?><br/>
                <span class="fmlaHeader">FML Request Type:</span>
                <input type="radio" name="requestType" value="Full time off" <?php if(!isset($_POST["requestType"])){} else if(isset($_POST["submitRequest"]) && $_POST['requestType'] == "Full time off"){echo "checked=checked";} ?>>Full time off <br/>
                <div class="fmlaInputRight">
                    <input type="radio" name="requestType" class="fmlaRadio" value="Intermittent time off" <?php  if(!isset($_POST["requestType"])){} else if(isset($_POST["submitRequest"]) && $_POST['requestType'] == "Intermittent time off"){echo "checked=checked";} ?>>Intermittent time off
                </div><br/><br/>
                
                <?php if(isset($_POST["submitRequest"])){ echo $errorLeave; } ?><?php if(isset($_POST["submitRequest"])){ echo $dayDiffError; } ?><br/>
                <span class="fmlaHeader">Expected Effective Date of Leave:</span>
                <input type="text" class="datepicker" name="expectedLeave" placeholder="mm/dd/yyyy" value="<?php if(isset($_POST["submitRequest"])){echo $_POST['expectedLeave'];} ?>"><br/><br/>
                
                <?php if(isset($_POST["submitRequest"])){ echo $errorReturn; } ?><br/>
                <span class="fmlaHeader">Expected Date of Return:</span>
                <input type="text" class="datepicker" name="expectedReturn" placeholder="mm/dd/yyyy" value="<?php if(isset($_POST["submitRequest"])){echo $_POST['expectedReturn'];} ?>"> OR <input type="checkbox" name="unknownDate" <?php if(isset($_POST["submitRequest"]) && isset($_POST["unknownDate"])){echo "checked=checked";} ?>>Unknown <br/><br/>
                
                <?php if(isset($_POST["submitRequest"])){ echo $errorLeaveReason; } ?><br/>
                <span class="fmlaHeader">Leave is being requested for one of the following reasons(please select one):</span>
                <input type="radio" name="leaveReason" value="Adoption or foster care" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Adoption or foster care"){echo "checked=checked";} ?>>Adoption or foster care<br/>
                <div class="fmlaInputRight">
                    <input type="radio" name="leaveReason" value="Health condition of dependent child" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Health condition of dependent child"){echo "checked=checked";} ?>>Health condition of dependent child<br/>
                    <input type="radio" name="leaveReason" value="Health condition of employee" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Health condition of employee"){echo "checked=checked";} ?>>Health condition of employee<br/>
                    <input type="radio" name="leaveReason" value="Maternity/Paternity" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Maternity/Paternity"){echo "checked=checked";} ?>>Maternity/Paternity<br/>
                    <input type="radio" name="leaveReason" value="Health condition of parent" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Health condition of parent"){echo "checked=checked";} ?>>Health condition of parent <br/>
                    <input type="radio" name="leaveReason" value="Health condition of spouse" <?php if(!isset($_POST["leaveReason"])){} else if(isset($_POST["submitRequest"]) && $_POST['leaveReason'] == "Health condition of spouse"){echo "checked=checked";} ?>>Health condition of spouse<br/><br/><br/>
                </div>

                <input type="checkbox" id="background_check_consent_cb" value="bg_check_consent_cb"><span class="background_span">I understand that the submission of this Request does not constitute approval for requested leave of absense. I understand that a failure to return to work at the end of my approved leave period may be treated as resignation.</span><br/><br/>
                <input type="submit" id="submit_button_disabled" name="submitRequest" value="Submit" disabled/>


            </form>

<?php
    include("../assets/inc/footer.inc.php");
?>