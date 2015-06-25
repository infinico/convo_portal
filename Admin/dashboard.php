<?php 
    $title = "Convo Portal | Dashboard";

    include("../core/init.php");
    include("../assets/inc/header.inc.php");
    admin_protect();

    /*Video Interpreter*/
    $resultVI = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE job_code = 'INT007' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countVI = mysqli_fetch_array($resultVI);

    /*Employment Status*/
    $resultActive = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE employment_status = 'Active'");
    $countActive = mysqli_fetch_array($resultActive);
    
    $resultLeave = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE employment_status = 'Leave'");
    $countLeave = mysqli_fetch_array($resultLeave);

    $resultTerminated = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE employment_status = 'Terminated'");
    $countTerminated = mysqli_fetch_array($resultTerminated);

    /*Convo Location*/
    $resultMobile = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'AL01' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countMobile = mysqli_fetch_array($resultMobile);
    
    $resultRoseville = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'CA02' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countRoseville = mysqli_fetch_array($resultRoseville);

    $resultPleasanton = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'CA01' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countPleasanton = mysqli_fetch_array($resultPleasanton);

    $resultFortWayne = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'IN01' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countFortWayne = mysqli_fetch_array($resultFortWayne);
    
    $resultRochester = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'NY01' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countRochester = mysqli_fetch_array($resultRochester);

    $resultNewYork = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'NY02' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countNewYork = mysqli_fetch_array($resultNewYork);

    $resultAustin = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'TX01' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countAustin = mysqli_fetch_array($resultAustin);

    $resultNone = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE location_code = 'NONE' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countNone = mysqli_fetch_array($resultNone);


    /*Payroll Status*/

    $resultFT = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE payroll_status = 'FT' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countFT = mysqli_fetch_array($resultFT);

    $resultPT = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE payroll_status = 'PT' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countPT = mysqli_fetch_array($resultPT);

    $resultGBS = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE payroll_status = 'GBS' AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $countGBS = mysqli_fetch_array($resultGBS);
    
    /*Growth of hired emoployee*/
    //1 month
    $result1Month = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND (employment_status = 'Active' OR employment_status = 'Leave') ");
    $count1Month = mysqli_fetch_array($result1Month);
    //3 months
    $result1_3Months = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date BETWEEN CURDATE() - INTERVAL 3 MONTH AND CURDATE() - INTERVAL 1 MONTH AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $count1_3Months = mysqli_fetch_array($result1_3Months);
    //6 months
    $result3_6Months = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE() - INTERVAL 3 MONTH AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $count3_6Months = mysqli_fetch_array($result3_6Months);
    //1 year
    $result6Months_1Year = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() - INTERVAL 6 MONTH AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $count6Months_1Year = mysqli_fetch_array($result6Months_1Year);
    //2 years
    $result1_2Years = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date BETWEEN CURDATE() - INTERVAL 2 YEAR AND CURDATE() - INTERVAL 1 YEAR AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $count1_2Years = mysqli_fetch_array($result1_2Years);
    //3+ years
    $result2YearsUP = mysqli_query($link, "SELECT COUNT('employee_id') FROM convo_employee_vw WHERE hire_date < NOW() - INTERVAL 2 YEAR AND (employment_status = 'Active' OR employment_status = 'Leave')");
    $count2YearsUP = mysqli_fetch_array($result2YearsUP);
    
?>

            <h1 class="headerPages">Dashboard</h1>

            <div id="colLeft">    <!-- column Left -->
                <h2>Video Interpreters</h2>
                <span class="spanHeader">Number of Active VIs:</span><?php echo $countVI[0]; ?><br/><br/>

                <h2>Employees by Employment Type</h2>
                <span class="spanHeader">Active employees:</span><?php echo $countActive[0]; ?><br/>
                <span class="spanHeader">Employees on leave:</span><?php echo $countLeave[0]; ?><br/>
                <span class="spanHeader">Terminated employees:</span><?php echo $countTerminated[0]; ?><br/><br/>

                <h2>Employees by Convo Location</h2>
                <span class="spanHeader">Mobile, AL:</span><?php echo $countMobile[0]; ?><br/>
                <span class="spanHeader">Pleasanton, CA:</span><?php echo $countPleasanton[0]; ?><br/>
                <span class="spanHeader">Roseville, CA:</span><?php echo $countRoseville[0]; ?><br/>
                <span class="spanHeader">Fort Wayne, IN:</span><?php echo $countFortWayne[0]; ?><br/>
                <span class="spanHeader">New York, NY:</span><?php echo $countNewYork[0]; ?><br/>
                <span class="spanHeader">Rochester, NY:</span><?php echo $countRochester[0]; ?><br/>
                <span class="spanHeader">Austin, TX:</span><?php echo $countAustin[0]; ?><br/>
                <span class="spanHeader">Telecommuter:</span><?php echo $countNone[0]; ?><br/><br/>
            </div>  <!-- column Left // -->

            <div id="colRight">   <!-- column Right -->
                <h2>Employees by Employment Status</h2>
                <span class="spanHeader">Full Time:</span><?php echo $countFT[0]; ?><br/>
                <span class="spanHeader">Part Time:</span><?php echo $countPT[0]; ?><br/>
                <span class="spanHeader">GBS:</span><?php echo $countGBS[0]; ?><br/><br/>

                <h2>Workforce Growth</h2>
                <span class="dashboard">Last month:</span><?php echo $count1Month[0]; ?><br/>
                <span class="dashboard">Between 1-3 months ago:</span><?php echo $count1_3Months[0]; ?><br/>
                <span class="dashboard">Between 3-6 months ago:</span><?php echo $count3_6Months[0]; ?><br/>
                <span class="dashboard">Between 6 months-1 year ago:</span><?php echo $count6Months_1Year[0]; ?><br/>
                <span class="dashboard">Between 1-2 years ago:</span><?php echo $count1_2Years[0]; ?><br/>
                <span class="dashboard">More than 2 years ago:</span><?php echo $count2YearsUP[0]; ?><br/><br/>
            </div>  <!-- column Right // -->
<?php
    include("../assets/inc/footer.inc.php"); 
?>