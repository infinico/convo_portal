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

<p>Medical insurance is available to all full-time employees. If full-time status begins on the first of the month, the effective date of coverage begins on that date. Otherwise, the effective date of coverage begins on the first of the month following full-time employment status.</p>

<h2>Coverage</h2>

<p>Convo will pay for 70% of the medical insurance premium, and the remaining 30% will be deducted from 

    the employee’s paycheck on a pre-tax basis. </p>

<h2>Medical Insurance Plan Documents</h2>

<p>Employees will be able to choose between Aetna and Cigna as their medical insurance provider.  You 

    can compare rates and sign up for your medical insurance plan using the <a href="Medical%20Rate%20Sheet.pdf" target="_blank">Rate Sheet</a>. Newly eligible employees may fill out and return this form to 

    <a href="mailto:hr@convorelay.com">hr@convorelay.com</a>. </p>

<div id="aetna">
    <h3><strong>Aetna Documents</strong></h3>
    
    <a href="Aetna%20Enrollment%20Form.pdf" target="_blank">Aetna Enrollment Form</a><br/>
    <a href="Aetna%20-%20NG2.pdf" target="_blank">Medical Schedule of Benefits: NG2</a><br/>
    <a href="Aetna%20-%20NG3.pdf" target="_blank">Medical Schedule of Benefits: NG3</a><br/>
    <a href="Aetna%20-%20NG5.pdf" target="_blank">Medical Schedule of Benefits: NG5</a>
    
    <h3><strong>Find a Doctor: Aetna</strong></h3>
    
    <ol>
        <li>Open <a href="http://www.aetna.com/dse/search?site_id=dse" target="_blank">Aetna</a></li>
        <li>Enter keyword in search box</li>
        <li>Enter your location</li>
        <li>Click on Search to display results</li>
        <li>Choose the "Aetna Choice@POS II (Open Access)" option found in the second Aetna group (22nd option)</li>
        <li>Click on Continue to display results</li>
    
    </ol>
    
</div>


<div id="cigna">
    <h3><strong>Cigna Documents</strong></h3>
    <a href="CIGNA%20Enrollment%20Form.pdf" target="_blank">Cigna Enrollment/Change Form</a><br/>
    <a href="CIGNA%20-%20NG2.pdf" target="_blank">Medical Schedule of Benefits: NG2</a><br/>
    <a href="CIGNA%20-%20NG3.pdf" target="_blank">Medical Schedule of Benefits: NG3</a><br/>
    <a href="CIGNA%20-%20NG5.pdf" target="_blank">Medical Schedule of Benefits: NG5</a>
    
    <h3><strong>Find a Doctor: Cigna</strong></h3>
    
    <ol>
        <li>Open <a href="http://hcpdirectory.cigna.com/web/public/pr

oviders" target="_blank">Cigna</a></li>
        <li>Enter your location</li>
        <li>Click on "Pick" under "Select a Plan"</li>
        <li>Choose the third option: "Open Access Plus, OA Plus, Choice Fund OA Plus With CareLink"</li>
        <li>Enter keyword in search box</li>
        <li>Click on Search to display results</li>
    
    
    </ol>
</div>

<?php
    include("../assets/inc/footer.inc.php");
?>