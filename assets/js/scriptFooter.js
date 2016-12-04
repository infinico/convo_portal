
/*
* ON BOARDING PAGE 
*/

$("#background_check_consent_cb").change(function() {
    if($(this).prop("checked")) {
        $("input[type='submit']").removeAttr("disabled");
        $("input[type='submit']").attr("id", "submit_button_enabled");
    }
    else {
         $("input[type='submit']").attr("disabled", true);
        $("input[type='submit']").attr("id", "submit_button_disabled");
    }
});

/*
* EMPLOYEE PAGE
*/
function filterme() {
  //build a regex filter string with an or(|) condition
  var emp_status = $('input:checkbox[name="active_terminate"]:checked').map(function() {
    return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox, not case sensitive
  $('#employee_table').dataTable().fnFilter(emp_status, 9, true, false, false, false);
  $('#acknowledgement_table').dataTable().fnFilter(emp_status, 9, true, false, false, false);
  $('#onboarding_table').dataTable().fnFilter(emp_status, 9, true, false, false, false);

}

/*
* TERMINATION PAGE
*/

$(document).ready(function() {
   $("#termination").change(function() {
        if($(this).prop("checked")) {
            document.getElementById("termination_box").style.display = "block";
        }
       else {  document.getElementById("termination_box").style.display = "none";
       }
   });
});
    
$("#employeeName").change(function() {
    var empID = $(this).val().split("|")[0];
    var jobCode = $(this).val().split("|")[1];
    var pos = $(this).val().split("|")[2];
    var payrollStatus = $(this).val().split("|")[3];
    var convo_location = $(this).val().split("|")[4];
    var emp_status = $(this).val().split("|")[5];
    var firstname = $(this).val().split("|")[6];
    var lastname = $(this).val().split("|")[7];
    var supervisor = $(this).val().split("|")[8];
    var street_address = $(this).val().split("|")[9];
    var city = $(this).val().split("|")[10];
    var res_state = $(this).val().split("|")[11];
    var zipCode = $(this).val().split("|")[12];
    var hourlyRate = $(this).val().split("|")[13];
    var location_code = $(this).val().split("|")[14];    
    var email = $(this).val().split("|")[15];
    var convoNumber = $(this).val().split("|")[16];
    var birthdate = $(this).val().split("|")[17];
    var ssn = $(this).val().split("|")[18];
    
    var birthDateSplit = birthdate.split("-")[1] + "/" + birthdate.split("-")[2] + "/" + birthdate.split("-")[0];
    
    var formattedPhone = ""; 
    
    if(convoNumber.length > 0){
        formattedPhone = convoNumber.substring(0,3) + "-" + convoNumber.substring(3,6) + "-" + convoNumber.substring(6,10); 
    }
    else{
        formattedPhone = "";
    }

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
    $("input[name='convoNumber']").val(formattedPhone);
    $("input[name='current_convoNumber']").val(formattedPhone);

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
    $("input[name='email']").val(email);
    $("input[name='current_email']").val(email);
    $("input[name='birthdate']").val(birthDateSplit); 
    $("input[name='current_birthdate']").val(birthDateSplit); 
    $("input[name='ssn']").val(ssn); 
    $("input[name='current_ssn']").val(ssn); 
});

/*EDIT DATABASE */
$("#positionName").change(function() {
    var positionName = $(this).val().split("|")[0];
    var jobCode = $(this).val().split("|")[1];
    var dept_code = $(this).val().split("|")[2];
    var manager_privileges = $(this).val().split("|")[3];
    var admin_privileges = $(this).val().split("|")[4];
    var dept_name = $(this).val().split("|")[5];
    
    $("input[name='change_positionName']").val(positionName);
    $("input[name='current_positionName']").val(positionName);
    $("input[name='job_code']").val(jobCode);
    $("select[name='dept_name_for_position']").val(dept_code);
    $("input[name='current_dept_name_for_position']").val(dept_name);
    $("input[name='dept_code']").val(dept_code);
    
    $("input[name='current_admin_privileges']").val(admin_privileges);
    if($("input[name='current_admin_privileges']").val() == "1") {
      $("select[name='admin_privileges']").val("Admin");  
    }
    else {
        $("select[name='admin_privileges']").val("Non_admin"); 
    }


    $("input[name='current_manager_privileges']").val(manager_privileges);
    //$("select[name='manager_privileges']").val(manager_privileges);

    if($("input[name='current_manager_privileges']").val() == "1") {
      $("select[name='manager_privileges']").val("Manager");  
    }
    else {
        $("select[name='manager_privileges']").val("Non_manager"); 
    }
});

$("#departmentName").change(function() {
    var departmentName = $(this).val().split("|")[0];
    var deptCode = $(this).val().split("|")[1];
    
    $("input[name='change_department_name']").val(departmentName);
    $("input[name='current_department']").val(departmentName);
    $("input[name='dept_code']").val(deptCode);
});


$("#convoLocation").change(function() {
    var convoLocation = $(this).val().split("|")[0];
    var address = $(this).val().split("|")[1];
    var city = $(this).val().split("|")[2];
    var state = $(this).val().split("|")[3];
    var zipCode = $(this).val().split("|")[4];
    var locationCode = $(this).val().split("|")[5];
    
    $("input[name='location_code']").val(locationCode);
    
    $("input[name='change_convoLocation']").val(convoLocation);
    $("input[name='current_convoLocation']").val(convoLocation);
    
    $("input[name='address']").val(address);
    $("input[name='current_address']").val(address);
    
    $("input[name='city']").val(city);
    $("input[name='current_city']").val(city);
    
    $("select[name='state']").val(state);
    $("input[name='current_state']").val(state);
    
    $("input[name='zipCode']").val(zipCode);
    $("input[name='current_zipCode']").val(zipCode);
});

/*ADD EMPLOYEE(hire.php)*/
$("#new_hire").change(function() {
    var emplid = $(this).val().split("|")[0];
    var firstname = $(this).val().split("|")[1];
    var lastname = $(this).val().split("|")[2];
    var gender = $(this).val().split("|")[3];
    var street_address = $(this).val().split("|")[4];
    var city = $(this).val().split("|")[5];
    var state = $(this).val().split("|")[6];
    var zipCode = $(this).val().split("|")[7];
    var emailAddress = $(this).val().split("|")[8];
    var jobCode = $(this).val().split("|")[9];
    var locationCode = $(this).val().split("|")[10];
    var payrollStatus = $(this).val().split("|")[11];
    var hourlyRate = $(this).val().split("|")[12];
    var supervisorId = $(this).val().split("|")[13];
    var hireDate = $(this).val().split("|")[14];
    var birthDate = $(this).val().split("|")[15];
    var ssn = $(this).val().split("|")[16];
    
    var hireDateSplit = hireDate.split("-")[1] + "/" + hireDate.split("-")[2] + "/" + hireDate.split("-")[0];
    var birthDateSplit = birthDate.split("-")[1] + "/" + birthDate.split("-")[2] + "/" + birthDate.split("-")[0];
    
    $("input[name='hide_employee_id']").val(emplid);
    $("input[name='firstname']").val(firstname);
    $("input[name='lastname']").val(lastname);
    $("select[name='gender']").val(gender);
    $("input[name='street_address']").val(street_address);
    $("input[name='city']").val(city);
    $("select[name='res_state']").val(state);
    $("input[name='zipcode']").val(zipCode);
    $("input[name='email_address']").val(emailAddress);
    $("select[name='change_position_name']").val(jobCode);
    $("select[name='convo_location']").val(locationCode);
    $("select[name='payroll_status']").val(payrollStatus);
    $("input[name='hourly_rate']").val(hourlyRate);
    $("select[name='supervisor']").val(supervisorId);
    $("input[name='hire_date']").val(hireDateSplit);
    $("input[name='dob']").val(birthDateSplit);
    $("input[name='ssn']").val(ssn);
});
