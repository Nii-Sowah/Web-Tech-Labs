<?php
/*  
    A local variable is one created within afunction and cannot be called outside of that function

    A global variab;e is one that is created outside of a specific function and can e referenced anytwhee within the code
    
    A static variable is a variable created with the static keyword and is local to its function but the value within the variable remains the same hence the static name.
    
*/

//returns a line of the order
function lineCost($price, $qty) {
  return $price * $qty;
}

function orderLines($order) {
  $lines = [];
  foreach ($order as $line) {
    $lines[] = $line[2] . " x " . $line[0] . " - GHS " . lineCost($line[1], $line[2]);
  }
  return $lines;
}

function addServiceCharge(&$subtotal) {
  $subtotal += 5;
}
 

function showBarName() {
  global $barName;
  echo $barName;
}