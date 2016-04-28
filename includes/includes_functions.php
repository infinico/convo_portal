<?php
    $resultPosition = mysqli_query($link, "SELECT * FROM position_vw");
    $resultDepartment = mysqli_query($link, "SELECT * FROM department_vw");
    $resultLocation = mysqli_query($link, "SELECT * FROM location_vw");
    $resultSupervisor = mysqli_query($link, "SELECT * FROM employee_supervisor_vw");
    //$resultNewHire = mysqli_query($link, "SELECT * FROM new_hire_vw");
    $resultNewHire = mysqli_query($link, "SELECT employee_id, firstname, lastname, gender, street_address, city, res_state, zipcode, email, job_code, location_code, payroll_status, hourly_rate, supervisor_id, hire_date, date_of_birth, ssn FROM employee_info_vw WHERE emp_type = 'O' ORDER BY lastname, firstname");

    // State Creation
$states = array(
        "Alaska" => "AK",
		"Alabama" => "AL",
        "Arkansas" => "AR",
    	"Arizona" => "AZ",
    	"California" => "CA",
    	"Colorado" => "CO",
    	"Connecticut" => "CT",
        "Washington DC" => "DC",
    	"Delaware" => "DE",
    	"Florida" => "FL",
    	"Georgia" => "GA",
    	"Hawaii" => "HI",
        "Iowa" => "IA",
    	"Idaho" => "ID",
    	"Illinois" => "IL",
        "Indiana" => "IN",
    	"Kansas" => "KS",
    	"Kentucky" => "KY",
    	"Louisana" => "LA",
        "Massachusetts" => "MA",
        "Maryland" => "MD",
    	"Maine" => "ME",
    	"Michigan" => "MI",
    	"Minnesota" => "MN",
        "Missouri" => "MO",
    	"Mississippi" => "MS",
    	"Montana" => "MT",
        "North Carolina" => "NC",
        "North Dakota" => "ND",
    	"Nebraska" => "NE",
        "New Hampshire" => "NH",
        "New Jersey" => "NJ",
        "New Mexico" => "NM",
    	"Nevada" => "NV",
    	"New York" => "NY",
    	"Ohio" => "OH",
    	"Oklahoma" => "OK",
    	"Oregon" => "OR",
    	"Pennsylvania" => "PA",
    	"Rhode Island" => "RI",
    	"South Carolina" => "SC",
    	"South Dakota" => "SD",
    	"Tennessee" => "TN",
    	"Texas" => "TX",
    	"Utah" => "UT",
        "Virginia" => "VA",
    	"Vermont" => "VT",
    	"Washington" => "WA",
        "Wisconsin" => "WI",
    	"West Virginia" => "WV",
    	"Wyoming" => "WY",
	);
    function create_option_list($data, $title) {
        $output = "<option value=''>Select a $title</option>";
        
        foreach($data as $name) {
            $output .= "<option value='$name'";
            
            if(isset($_POST["submit"]) && $_POST["res_state"] == $name){
                $output .= "selected='selected'";
            }
            $output .= ">$name</option>";
        }
        return $output;
    }	// End Create Option List Function




    // for NEO/index.php to keep states value set after submission
   function set_option_list($data, $title, $user_data) {
        $output = "<option value=''>Select a $title</option>";
        
        foreach($data as $name) {
            // variable
            $output .= "<option value='$name'";
            
            //if(isset($_POST["submitNewHire"]) && $_POST["res_state"] == $user_data){
                if($name == $user_data){ 
                $output .= "selected='selected'";
            }
            $output .= ">$name</option>";
        }
        return $output;
   }
    
// End Create Option List Function

?>