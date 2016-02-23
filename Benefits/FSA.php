<?php
    $page_title = "Flexible Spending Account";
    $title = "Convo Portal | Flexible Spending Account";
    include("../core/init.php");
    protect_page();
if(logged_in()){
    benefits_protect();   
}
    include("../assets/inc/header.inc.php");
?>

            <h1 class="headerPages">Flexible Spending Account (FSA)</h1>

<h2>FSA Plan Information</h2>

<table>
    <tr>
        <td width="20%">Eligibility/Plan Entry</td>
        <td>All Convo employees are eligible effective March 1, 2016. New hires will be eligible on the first day of the month following 30 days of employment.</td>
    </tr>
    <tr>
        <td width="20%">Dependent Care Assistance Expense Limit</td>
        <td>Maximim benefit allowed under dependent care plan: (1) $5000 per year if you are married and file a joint income tax return or are a single parent, (2) $2500 per year if you are married, living together but file separate federal income tax return, (3) Lesser of $5000 or spouse's earned income, or (4) maximum under the regulations if your spouse is inacapable of self-care or is a full time student.</td>
    </tr>
    <tr>
        <td width="20%">Plan Year</td>
        <td>January 1 - December 1 <em>except</em> 2016 where benefits start March 1, 2016. All previous expenses do not apply.</td>
    </tr>
    <tr>
        <td width="20%">Grace Period</td>
        <td>January 1, 2017 - March 15, 2017 to incur expenses against the 2016 Plan Year.</td>
    </tr>
    <tr>
        <td width="20%">Closeout Period</td>
        <td>90 days following the end of the plan year.</td>
    </tr>
</table>
<br/>

<h2>How to Enroll During Open Enrollment</h2>
<p>Current plan year elections will automatically apply to the following plan year. Participants need to take action only if they are changing their annual election or declining enrollment for the following plan year. If this is the first time you are enrolling in the Flexible Spending Account, you may enroll online, by telephone, or mailing in a paper election form.</p>
<table>
    <tr>
        <td width="20%">Online</td>
        <td><a href="https://benefits.paychex.com" target="_blank">https://benefits.paychex.com</a></td>
    </tr>
    <tr>
        <td width="20%">PBA Employer Web</td>
        <td><a href="https://online.paychex.com" target="_blank">https://online.paychex.com</a></td>
    </tr>
    <tr>
        <td width="20%">Telephone</td>
        <td>1-877-244-1771</td>
    </tr>
    <tr>
        <td width="20%">Paper Election Form</td>
        <td>Paper forms can be downloaded from Convo Portal. Completed forms must be copied to Convo HR Department and submitted to Paychex before 11:59 p.m. ET on December 29, 2016.</td>
    </tr>
</table>
<br/>

<p>Under health care reform, unreimbursed medical expense (UME) employee contributions will be limited to $2550 annually. Please note that employers may choose a limit less than $2550.<br><br>
Clients can now assist employees by obtaining enrollment forms, and enrolling the employees through the PBA Employer Web during the Open Enrollment period.<br><br>
<b>Important: </b> The information contained in this summary is for informational purposes only and does not contain all of the provisions pertaining to your plan. This summary is not intended to be a substitute for any formal plan documentation. For a full description of the plan, please refer to the <a href="FSA/Section125.pdf" target="_blank">Section 125 Basic Plan Document</a>, Summary Plan Description, and Adoption Agreement.</p>

<?php
    include("../assets/inc/footer.inc.php");
?>