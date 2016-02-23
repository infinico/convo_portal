<?php
    $page_title = "Portal Admininistration";
    $title = "Convo Portal | Portal Admininistration";
    include("/../core/init.php");
    include("/../assets/inc/header.inc.php");
    protect_page();

?>

            <h1 class="headerPages">Portal Admininistration</h1>
            <br />
            <div id="colLeft">    <!-- column Left -->
                <h2>Reports</h2>
                <ul class="resources">
                    <li><a href="email_directory.php">Email Directory  </a></li>
                    <li><a href="acknowledgement_report.php">Acknowledgements</a></li>
                    <li><a href="onboarding_report.php">New Employee Onboarding</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>

                </ul><br/>
                
                <h2>Database Administration</h2>
                <ul class="resources">
                    <li><a href="hire.php">Add Employee</a></li>
                    <li><a href="edit.php">Edit Employees</a></li>
                    <li><a href="createdatabase.php">Add Database Values</a></li>
                    <li><a href="editdatabase.php">Edit Database Values</a></li>
                    <li><a href="announcements.php">Announcements</a></li>
                    <li><a href="add_acknowledgement.php">Add Acknowledgment</a></li>

                </ul>
                
                <h2>File Management</h2>
                <ul class="resources">
                    <li><a href="files_uploaded.php">Files Uploaded</a></li>
                </ul>        
            </div>  <!-- column Left // -->
            <div id="colRight">   <!-- column Right -->
            </div>  <!-- column Right //-->

<?php
    include("/../assets/inc/footer.inc.php");
?>