<?php
    $page_title = "Dental/Vision";
    $title = "Convo Portal | Dental/Vision";
    include("../core/init.php");
    protect_page();
if(logged_in()){
    benefits_protect();   
}
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Dental and Vision</h1>

<h2>Eligibility</h2>

<p>Dental and vision insurance are available through HealthEdge to all full-time employees. If full-time status begins on the first of the month, the effective date of coverage begins on that date. Otherwise, the effective date of coverage begins on the first of the month following full-time employment status.</p>

<p>Enrolled employees in California have access to the <a href="https://www.firstdentalhealth.com/" target="_blank">First Dental Health network</a>, while enrolled employees outside of California have access to the <a href="http://www.connectiondental.com/" target="_blank">Connection Dental network</a>.</p>

<p>Vision care providers can be found on the <a href="https://www.eyemed.com/" target="_blank">EyeMed web site</a>.</p>

<h2>Coverage</h2>

<p>Dental and vision insurance coverage is at 100% the employee's cost with pre-tax deductions from your paycheck. </p>

<h2>Dental/Vision Insurance Plan Documents</h2>

<p>You can compare rates for each plan using the <a href="HealthEdge%20Rate%20Sheet.pdf" target="_blank">Rate Sheet</a> . </p>

<p>Newly eligible employees may fill out and return the <a href="HealthEdge%20Enrollment%20Form.pdf" target="_blank">HealthEdge Enrollment Form</a> to 

    <a href="mailto:hr@convorelay.com">hr@convorelay.com</a>.</p>

<?php
    include("../assets/inc/footer.inc.php");
?>