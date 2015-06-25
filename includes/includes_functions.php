<?php
    $resultPosition = mysql_query("SELECT * FROM position_vw");
    $resultDepartment = mysql_query("SELECT * FROM department_vw");
    $resultLocation = mysql_query("SELECT * FROM location_vw");
    $resultSupervisor = mysql_query("SELECT * FROM employee_supervisor_vw");

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

?>