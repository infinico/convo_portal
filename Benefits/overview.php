<?php
    $page_title = "Benefits Overview";
    $title = "Convo Portal | Benefits Overview";
    include("../core/init.php");
    protect_page();
include("../assets/inc/header.inc.php");
?>

<h1 class="headerPages">Benefits Overview</h1>

<?php
    if(has_access_interpreting($user_data["job_code"]) == true){
?>
    <table>
        <tr>
            <th>VI Employment Category</th>
            <th>Definition</th>
        </tr>
        <tr>
            <td class="center">Full Time (FT)</td>
            <td class="center">Minimum of 32 hours a week (Schedule)<br>
            Minimum of 64 hours each pay period (Payroll)</td>
        </tr>
        <tr>
            <td class="center">Part Time (PT)</td>
            <td class="center">Minimum of 20 hours a week (Schedule)<br>
            Minimum of 40 hours each pay period (Payroll)</td>
        </tr>
        <tr>
            <td class="center">General Benefit Staff (GBS)</td>
            <td class="center">Minimum of 15 hours a month (Schedule &amp; Payroll)</td>
        </tr>
    </table>
        <br/>
    <table>
        <tr>
            <th style="width:70%">Benefits</th>
            <th style="width:10%">FT</th>
            <th style="width:10%">PT</th>
            <th style="width:10%">GBS</th>
        </tr>
        <tr>
            <td>Health Benefits: Convo will contribute 70% towards major medical premiums. Employee can add vision, dental, and/or supplemental benefits at employee's cost</td>
            <td class="center">X</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Accrued PTO: 15 days per 2080 hours worked; must work above minimums</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td></td>
        </tr>
        <tr>
            <td>Accrued CTO: 10 days per 2080 hours worked; must meet above minimums</td>
            <td></td>
            <td></td>
            <td class="center">X</td>
        </tr>
        <tr>
            <td>Paid Holidays</td>
            <td class="center">8 hours</td>
            <td class="center">4 hours</td>
            <td></td>
        </tr>
        <tr>
            <td>Matching 401(k): 25% up to 4% of pay. Vested after 4 years.</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td></td>
        </tr>
        <tr>
            <td>Worker's Compensation</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
        <tr>
            <td>FICA/Medicare</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
        <tr>
            <td>Unemployment</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
    </table>
        <br/>
        <h2>Holiday Expectations</h2>
        <table>
            <tr>
                <th></th>
                <th>GBS</th>
                <th>PT</th>
                <th>FT</th>
            </tr>
            <tr>
                <td>Request time off on Convo Holiday</td>
                <td class="center">2 months in advance</td>
                <td class="center">2 months in advance</td>
                <td class="center">OFF</td>
            </tr>
             <tr>
                <td>Holiday pay (regular pay rate)</td>
                <td class="center">None; can earn differential working pay</td>
                <td class="center">Required to work one Convo Holiday</td>
                <td class="center">N/A</td>
            </tr>
             <tr>
                <td>Required to work on Convo Holiday annually</td>
                <td class="center">Required to work one Convo Holiday</td>
                <td class="center">Required to work one Convo Holiday</td>
                <td class="center">Not required</td>
            </tr>
             <tr>
                <td>Use Holiday pay and work on the same day</td>
                <td class="center">N/A</td>
                <td class="center">Yes, but overtime pay will not apply</td>
                <td class="center">Yes, but overtime pay will not apply</td>
            </tr>
        </table>
        <br/>
<?php
    if($user_data["job_code"] == "INT004"){
?>
<div style="background: #EEEFEB">        
<p>Managers are not required to work on holidays unless there is insufficient coverage for traffic management, especially if their call center is not contributing their expected share of traffic management support.</p>
<ul style="list-style-type:circle; font-size: 1.25em; margin-left: 20px;">
    <li>No Trainings on Convo Holidays.</li>
    <li>Do not pursue the VIs about unassigning their shift for the holidays. It is their responsibility to communicate with us.</li>
    <li>Create a spreadsheet of all VIs based on whether they worked on one or more of Convo's recognized holidays.</li>
</ul>
    </div>
<?php
    }
?>
        <h2>Paid Time Off</h2>
        <p>Full and Part time employees get up to 15 days per 2080 hours worked within meeting the above minimum requirements. Employees can track their information on their pay stubs.</p>

        <h2>Complimentary Time Off</h2>
        <p>General Benefit Staff can earn up to 10 days per 2080 hours worked when satisfying tthe above requirements. Employees can track their information on their pay stubs.</p>

        <h2>Bereavement</h2>
        <p>Convo will pay up to 3 days of bereavement per year for Full time employees.</p>

        <h2>Floating Holidays</h2>
        <p>Depending on when you start your status during the year, Full and Part Time employees get Floating Holidays. This is a paid time off on any day(s) you choose to consider as your designated Floating Holiday. This is tracked by calendar year and cannot be rolled over to the next calendar year.</p>
        
        <h3>Status change January through June</h3>
        <p>FT gets up to 16 hours of Floating Holidays.<br>PT gets up to 8 hours of Floating Holidays.</p>
        <h3>Status change July through December</h3>
        <p>FT gets up to 8 hours of Floating Holidays.<br>PT gets up to 4 hours of Floating Holidays.</p>
        <p>For example, if a PT employee is promoted to FT status in May and already used 4 hours of Floating Holidays in April, then the employee can use 12 hours of Floating Holidays for the rest of the fiscal year, regardless of their status later in the fiscal year.</p>

        <h2>Procedures for Failing to Meet Schedule Commitments</h2>
        <p>If an employee does not meet their status expectation two times in a six-month period then the employee will receive a verbal/email discussion, which in turn starts a six-month probationary period.</p>
        <p>Each failure to meet schedule requirements during the Probationary period will restart the six-month probationary period again.</p>
        <p>If two failures to meet schedule requirements occur within a six-month period, then a written warning will be given.</p>
        <p>If the issue persists then a second warning or termination will occur.</p>
        <p>* <em>OTB (in special circumstances), PTO/CTO use, Medical, Technology-related, and Weather-related reasons are considered valid exemptions for not meeting schedule expectations.</em></p>
        <h2>Hard Work Recognition</h2>
        <p>If you are asked to extend your shift, move your shift, or cover partial or full shifts for your colleague, the manager will document your support. Employees are also responsible to note their support in their notes part in the clock in and clock out box.</p>
        <p><strong>This solution has been developed in the best interests for both VIs and the company for continued long-term success and well-being.</strong></p>

<?php
    }
        elseif(has_access_support($user_data["job_code"]) == true){
?>
    <table>
        <tr>
            <th>Convo Support Employee Category</th>
            <th>Expectation</th>
        </tr>
        <tr>
            <td class="center"><strong>Full Time (FT)</strong><br/>Salary</td>
            <td class="center">Minimum of 35 hours on schedule weekly</td>
        </tr>
        <tr>
            <td class="center"><strong>Part Time (FT)</strong><br/>Hourly</td>
            <td class="center">Flexible with agreement</td>
        </tr>
        <tr>
            <td class="center"><strong>General Benefit Staff (GBS)</strong><br/>Hourly</td>
            <td class="center">Probationary Period 1-2 months</br/>Minimum of 10 hours a week</td>
        </tr>
    </table>
        <br/>
    <table>
        <tr>
            <th style="width:70%">Benefits</th>
            <th style="width:10%">FT</th>
            <th style="width:10%">PT</th>
            <th style="width:10%">GBS</th>
        </tr>
        <tr>
            <td class="center"><strong>Health Benefits</strong><br/>Convo will contribute 70% towards employee's total health premium.<br/>Employee can add vision, dental, and/or supplemental benefits without Convo's contribution.</td>
            <td class="center">X</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Accrued PTO</strong><br>15 days per 52 weeks worked; accrued bi-weekly.</td>
            <td class="center">X</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Accrued CTO</strong><br>15 days per 2080 hours worked; accrued bi-weekly.</td>
            <td></td>
            <td class="center">X</td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Paid Holidays</strong><br>New Year's Day, Independence Day, Thanksgiving Day, and Christmas Day<br>along with choice of 2 floating holidays per year.</td>
            <td class="center">X</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Matching 401(k)</strong><br>25% up to 4% of pay. Vested after 4 years.</td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Bereavement</strong><br>3 days per year with documentation.</td>
            <td class="center">X</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="center"><strong>Worker's Compensation</strong></td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
        <tr>
            <td class="center"><strong>FICA/Medicare</strong></td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
        <tr>
            <td class="center"><strong>Unemployment</strong></td>
            <td class="center">X</td>
            <td class="center">X</td>
            <td class="center">X</td>
        </tr>
    </table>
<?php
    }
?>



<?php
    include("../assets/inc/footer.inc.php");
?>