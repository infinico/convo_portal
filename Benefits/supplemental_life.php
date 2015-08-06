<?php
    $page_title = "Supplemental Life";
    $title = "Convo Portal | Supplemental Life";
    include("../core/init.php");
    protect_page();
if(logged_in()){
    benefits_protect();   
}
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Supplemental Life</h1>

            <h2>Eligibility</h2>

<p>Supplemental life insurance is available through Aflac to all full-time employees. If full-time status begins on the first of the month, the effective date of coverage begins on that date. Otherwise, the effective date of coverage begins on the first of the month following full-time employment status.</p>

<h2>Coverage</h2>

<p>Supplemental life insurance coverage is at 100% the employee's cost with pre-tax deductions from your 

    paycheck. </p>

<h2>Supplemental Life Insurance Plan Documents</h2>

<p>View the <a href="Aflac.pdf" target="_blank">Aflac information sheet</a> for information on how to enroll.</p>

<?php
    include("../assets/inc/footer.inc.php");
?>