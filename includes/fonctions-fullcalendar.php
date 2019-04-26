<?php

// Function to get all the dates in given range 
function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
    // Declare an empty array 
    $array = array(); 
      
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 

    $i = 0;
  
    // Use loop to store date into array 
    foreach($period as $date) {
        if ($i < 5) {                 
            $array[] = $date->format($format);
        } elseif ( $i == 6 ) {
            $i = -2;
        }
        $i++; 
    }
  
    // Return the array elements 
    return $array; 
}


?>