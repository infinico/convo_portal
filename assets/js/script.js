/*
* Datepicker    
*/
  $(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'mm-dd-yy', constrainInput: false });
  });

/*
* Logged in Widget
*/
var flag = false;

function onLoad(){
    filterme();
    
    var empID = $("#employeeName").val().split("|")[0];
    var jobCode = $("#employeeName").val().split("|")[1];
    var pos = $("#employeeName").val().split("|")[2];
    var payrollStatus = $("#employeeName").val().split("|")[3];
    var convo_location = $("#employeeName").val().split("|")[4];
    var emp_status = $("#employeeName").val().split("|")[5];
    var firstname = $("#employeeName").val().split("|")[6];
    var lastname = $("#employeeName").val().split("|")[7];
    var supervisor = $("#employeeName").val().split("|")[8];
    var street_address = $("#employeeName").val().split("|")[9];
    var city = $("#employeeName").val().split("|")[10];
    var res_state = $("#employeeName").val().split("|")[11];
    var zipCode = $("#employeeName").val().split("|")[12];
    var hourlyRate = $("#employeeName").val().split("|")[13];
    var location_code = $("#employeeName").val().split("|")[14];

   // Employee Information
    $("input[name='employee_id']").val(empID);
    $("select[name='change_position_name']").val(jobCode);
    $("input[name='current_position_name']").val(pos);
    $("input[name='current_payroll_status']").val(payrollStatus);
    $("select[name='change_payroll_status']").val(payrollStatus);
    $("input[name='hourly_rate']").val(hourlyRate);
    $("input[name='current_hourly_rate']").val(hourlyRate);
    $("input[name='current_convo_location']").val(convo_location);
    $("select[name='convo_location']").val(location_code);
    $("input[name='current_emp_status']").val(emp_status);
    $("select[name='emp_status']").val(emp_status);
    $("input[name='current_supervisor']").val(supervisor);
    $("select[name='supervisor']").val(supervisor); 

    // Personal Information
    $("input[name='current_firstname']").val(firstname);
    $("input[name='firstname']").val(firstname);
    $("input[name='current_lastname']").val(lastname);
    $("input[name='lastname']").val(lastname);
    $("input[name='current_street_address']").val(street_address);
    $("input[name='street_address']").val(street_address);
    $("input[name='current_city']").val(city);
    $("input[name='city']").val(city);
    $("input[name='current_res_state']").val(res_state);
    $("select[name='res_state']").val(res_state);
    $("input[name='current_zipCode']").val(zipCode);
    $("input[name='zipCode']").val(zipCode);
}

function clicked(){  
    if(!flag){
        document.getElementById("statusList").style.display = "inline";
        //document.getElementById("status").style.float = "right";
        document.getElementById("showHide").innerHTML = "Hide";
        //document.getElementById("status2").style.margin = "100px";

        flag = true;
    }
    else{
        document.getElementById("statusList").style.display = "none";
        document.getElementById("showHide").innerHTML = "Show";
        //document.getElementById("status2").style.margin = "-100px";
        flag = false;
    }
}

/*
* CENSUS PAGE
*/
function goBack() {
   window.history.back();
}

/*
* TERMINATION PAGE
*/ 

$(document).ready(function() {
    $('input[name="announcement_time"]').timepicker();
    $('#active_leave_checkbox input:checkbox').prop('checked', 'checked');

    $("#example").dataTable().fnDestroy();
    $('#example').dataTable( {
        "language": {
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "order": [
            [2, "asc" ],
            [1, "asc" ]
        ],
        "columns": [
            { "width": "6%" },  // Employee ID
            { "width": "10%" }, // First Name
            { "width": "10%" }, // Last Name
            { "width": "15%" }, // Position
            { "width": "13%" }, // Supervisor
            { "width": "14%" }, // Hire Date
            { "width": "16%" }, // Review Date
            { "width": "2%" },  // Payroll Status
            { "width": "10%" }, // Hourly Rate
            { "width": "15%" }  // Employment Status
        ]
    });
    
   $("#termination").change(function() {
        if($(this).prop("checked")) {
            document.getElementById("termination_box").style.display = "block";
        }
       else {  document.getElementById("termination_box").style.display = "none";
       }
   });
});
    
    function textCounter( field, countfield, maxlimit ) {
        if ( field.value.length > maxlimit ) {
            field.value = field.value.substring( 0, maxlimit );
            field.blur();
            field.focus();
            return false;
        } 
        else {
            countfield.value = maxlimit - field.value.length;
        }
    }