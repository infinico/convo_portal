<?php
    $page_title = "Medical";
    $title = "Convo Portal | Medical";
    include("../core/init.php");
    protect_page();
if(logged_in()){
    benefits_protect();   
}
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Medical</h1>
            
<h2>Eligibility</h2>

<p>Medical insurance is available through United Heathcare to all full-time employees. If full-time status begins on the first of the month, the effective date of coverage begins on that date. Otherwise, the effective date of coverage begins on the first of the month following full-time employment status.</p>

<h2>Coverage</h2>

<p>Convo will pay for 70% of the medical insurance premium, and the remaining 30% will be deducted from the employee’s paycheck on a pre-tax basis. </p>

<h2>Medical Insurance Plan Documents</h2>

<p>Please return all appropriate forms to <a href="mailto:hr@convorelay.com">hr@convorelay.com</a>; don't hesitate to contact us or our broker Joe Courcy at <a href="mailto:jcourcy@chinsurance.cc">jcourcy@chinsurance.cc</a> if you have any further questions.</p>

<p>
<a href="UHC%20Plans%20Comparison.pdf" target="_blank">UHC Plans Comparison</a><br>
<a href="UHC%20Election%20Form.pdf" target="_blank">Election Form</a><br>
<a href="UHC%20Enrollment%20Form.pdf" target="_blank">Enrollment Form (for newly eligible employees)</a><br>
<a href="UHC%20-%20AGZP.pdf" target="_blank">Benefit Summary for Plan AGZP</a><br>
<a href="UHC%20-%20AGZY.pdf" target="_blank">Benefit Summary for Plan AGZY</a><br>
<a href="UHC%20-%20AGZZ.pdf" target="_blank">Benefit Summary for Plan AGZZ</a>
</p>
    
<h2>Find a Doctor: United Healthcare</h2>
<p><a href="https://www.uhc.com/find-a-physician" target="_blank">https://www.uhc.com/find-a-physician</a></p>

<?php
    include("../assets/inc/footer.inc.php");
?>