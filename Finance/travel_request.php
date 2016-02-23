<?php 
    $page_title = "Travel Request";
    $title = "Convo Portal | Travel Request";
    require_once "../includes/phpmailer/vendor/autoload.php";
    require("../includes/phpmailer/libs/PHPMailer/class.phpmailer.php");
    include("../core/init.php");
    include("../assets/inc/header.inc.php");

?>
<script text="text/javascript">
    
    function $(x){
        return document.getElementById(x);   
    }

    function calculateQuantity(){
        
        var mileage = $("quantityMileage").value;
        var breakfast = $("quantityBreakfast").value;
        var lunch = $("quantityLunch").value;
        var dinner = $("quantityDinner").value;
        
        // formula
        var resultMileage = mileage * 0.56;
        var resultBreakfast = breakfast * 8;    
        var resultLunch = lunch * 12;
        var resultDinner = dinner * 20;
        
        //var caluclation = document.getElementById("calculate");
        var total = resultMileage + resultBreakfast + resultLunch + resultDinner;

        $("total_quantity").value = total;
        
        //calculation = resultMileage + resultBreakfast + resultLunch + resultDinner;
        
    }
    
    
</script>

<?php


$errorName = $errorDate = "";

if(isset($_POST["submit"])){
    
    
        $name = sanitize($_POST["travelerName"]);
        $travelDate = sanitize($_POST["travelDate"]);

    
        if(empty($_POST["travelerName"])){
            $errorName = "<span class='error'> Please enter your first name</span>";
        }

        if(empty($_POST["travelDate"])){
            $errorDate = "<span class='error'> Please enter your travel dates </span>";
        }
    
        if($errorName == "" && $errorDate == ""){
            
                $subjectHeader = "Request for Travel sent";
        
                $bodyMessage = "Name: " .  sanitize($_POST["travelerName"]) . "<br/>" . "Travel Date: " . sanitize($_POST["travelDate"]) . "<br/>" . "Flying from: " . sanitize($_POST["fromAir"]) . "<br/>" . "Flying to: " .  sanitize($_POST["toAir"]) . "<br/>" .  "Time: " . sanitize($_POST["timeRange"]) . "<br/>" . "Hotel check in Date: " .  sanitize($_POST["checkin"]) . "<br/>" . "Hotel checkout Date: " . sanitize($_POST["checkout"]) . "<br/>" . "Hotel Preference and Reason: " . sanitize($_POST["hotelPreference"]) . "<br/>" . "Car rental pickup Date: " . sanitize($_POST["pickup"]) . "<br/>" . "Car rental dropoff Date: " . sanitize($_POST["dropoff"]) . "<br/>" . "Car preference and reason: " . sanitize($_POST["carPreference"]) . "<br/>" . "Other reservation pickup Date: " . sanitize($_POST["reservationPickup"]) . "<br/>" . "Other reservation dropoff Date: " . sanitize($_POST["reservationDropoff"]) . "<br/>" . "Other reservation preference and reasons: " . sanitize($_POST["reservationPreference"]);
        
               newEmail($_POST["email"], $_POST["firstname"], $subjectHeader, $bodyMessage);
       
        //echo ("Hello");
        
               echo "<h2 class='headerPages'>Your request was sent successfully.</h2>"; 
               die();   
        
        }

    }

?>

        <h1 class="headerPages">Travel Request Form</h1>
            <h3>Please fill out the request form.</h3>

<form id="travel_request" method="POST">  
                
    <span class="spanHeader"> Traveler's Name:</span>
  <input type="text" id="travelerName" class="input-xlarge" name="travelerName" placeholder="Traveler Name" value=""><?php if(isset($_POST["submit"])){echo $errorName;}?><br/><br/>
                
                                
    <span class="spanHeader"> Date Travel:</span>
  <input type="text" id="travelDate" class="input-xlarge" name="travelDate" placeholder="e.g. 1/1/2015 - 1/20/15" value=""><?php if(isset($_POST["submit"])){echo $errorDate;}?><br/><br/>
                
                <h3>Airport</h3>
                                
    <span class="spanHeader"> From (airport code) :</span>
  <input type="text" id="fromAir" class="input-xlarge" name="fromAir" placeholder="e.g. ROC" value=""><br/><br/>
                
                                     
        <span class="spanHeader"> To (airport code) : </span>
  <input type="text" id="toAir" class="input-xlarge" name="toAir" placeholder="e.g. AUS" value=""><br/><br/>
                
           <span class="spanHeader"> Time Range : </span>
  <input type="text" id="timeRange" class="input-xlarge" name="timeRange" placeholder="e.g. 3:30pm - 5:30pm" value=""><br/><br/>
                
                
                <h3> Hotel Reservations</h3>
                
      <span class="spanHeader"> Check in Date :  </span>
  <input type="text" id="checkin" class="form-control datepicker" name="checkin" placeholder="Check in Date" value=""><br/><br/>
                
                
     <span class="spanHeader"> Check out Date :  </span>
  <input type="text" id="checkout" class="form-control datepicker" name="checkout" placeholder="Check Out Date" value=""><br/><br/>
                
       <span class="spanHeader"> Location and/or preferred hotel and why :  </span>
  <input type="text" id="preference" class="input-xlarge" name="hotelPreference" placeholder="" value=""><br/><br/>
                
                
                <h3> Car Rental Reservations</h3>
                
               <span class="spanHeader"> Pick up Date:  </span>
  <input type="text" class="form-control datepicker" name="pickup" placeholder="Pick up Date" value=""><br/><br/>                
                
              <span class="spanHeader"> Drop off Date:  </span>
  <input type="text" class="form-control datepicker" name="dropoff" placeholder="Drop off Date" value=""><br/><br/>                
                
          <span class="spanHeader"> Location and/or preferred car and why :  </span>
  <input type="text" id="preference" class="input-xlarge" name="carPreference" placeholder="Preference" value=""><br/><br/>
                
                
                
                <h3> Other Reservations </h3>
                
                
           <span class="spanHeader"> Pick up Date:  </span>
  <input type="text" class="form-control datepicker" name="reservationPickup" placeholder="Pick up Date"><br/><br/>                                     
                   
          <span class="spanHeader"> Drop off Date:  </span>
  <input type="text" class="form-control datepicker" name="reservationDropoff" placeholder="Drop off Date"><br/><br/>  
                
     <span class="spanHeader"> Location and/or preferred and why :  </span>
  <input type="text" id="preference" class="input-xlarge" name="reservationPreference" placeholder="" value=""><br/><br/>
                
                 
                <h3> Advance Request </h3>
                
                <span class="spanHeader"> Special notes ** </span>

                <em class="note">
                    <em>Car mileage - 56 cent per mile</em><br/>
                    <em>Per Diem (breakfast) - $8 per authorized breakfast</em><br/>
                    <em>Per Diem (lunch) - $12 per authorized lunch</em><br/>
                    <em>Per Diem (dinner) - $20 per authorized dinner</em><br/><br/>
                </em>

                <br/><br/>
                
                <div class="columnLeftQuantity">
                    <span class="spanHeader"> Expense Type </span><br/>
                        <br/><br/><br/>  
                    <span class="spanHeader"> Personal car mileage/fuel</span><br/><br/>
                    <span class="spanHeader"> Per Diem - Breakfast</span><br/><br/>
                    <span class="spanHeader"> Per Diem - Lunch</span><br/><br/>
                    <span class="spanHeader"> Per Diem - Dinner</span><br/><br/>
                </div>
                
              
                
                

                <div class="columnRightQuantity">
                    
                  <span class="spanHeader"> Quantity </span>  <br/>
                   <br/><br/>       
           <input type="text" class="input-xlarge" name="quantityMileage" id="quantityMileage" placeholder="e.g. 2"><br/>
        <input type="text" class="input-xlarge" name="quantityBreakfast" id="quantityBreakfast" placeholder="e.g. 2"><br/>
        <input type="text" class="input-xlarge" name="quantityLunch" id="quantityLunch" placeholder="e.g. 2"><br/>  
         <input type="text" class="input-xlarge" name="quantityDinner" id="quantityDinner" placeholder="e.g. 2"><br/>  
            
            <input type="button" id="calculate" name="calculate" value="Calculate" onclick="calculateQuantity();">
        

                </div>

            
                <br/><br/>
                


            <h3> Total </h3>
            
            <!-- TOTAL FROM CALCULATION -->
            <input type='text' name='total_quantity' id="total_quantity" class="input-small" style='background:#E9E9E9;' value="" readonly><br/><br/>
    
            <br/>
            
            <!-- SUBMIT BUTTON -->
            <input type="submit" name="submit" class = "submitButton" id="submitBtn"> 
        </form>





<?php
    include("../assets/inc/footer.inc.php");
?>