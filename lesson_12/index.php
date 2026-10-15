<?php


$barName = "Chop Bar";
$jollofPrice = 35;
$soboloPrice = 10;
$isMember = true;
$hasCoupon = false;
$isOpen = true;


$order = [
    ["Jollof Rice", $jollofPrice, 2],
    ["Sobolo", $soboloPrice, 3]
];


define("TAX_RATE", 0.15);


$order[1][2]++;

$subtotal = ($order[0][1] * $order[0][2]) + ($order[1][1] * $order[1][2]);


$total = $subtotal;
$total += 5;
$total += $subtotal * TAX_RATE;

$receipt = "";
foreach ($order as $line) {
    $receipt .= $line[2] . " x " . $line[0] . " - GHS "
        . number_format($line[1] * $line[2], 2) . "\n";
}


function lineCost($price, $qty) {
    return $price * $qty;
}

function showName () {
    global $barName;
    echo $barName;
}


function countOrders() {
    static $count = 0;
    $count++;
    echo "countOrders() has been called $count time(s)";
}

function showGlobalName() {
    print $GLOBALS['barName'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chop Bar Menu</title>
</head>
<body>
 
  <h1>Chop Bar Menu</h1>
  <ul>
    <li>Jollof Rice - GHS 35</li>
    <li>Waakye - GHS 30</li>
    <li>Sobolo - GHS 10</li>
  </ul>
  <p>Today's date:

    <?php echo date("l, F j, Y"); ?></p>
    <p>Time: <?php echo date("H:i:s"); ?></p>



  <h2>Step 2: Variables and constants</h2>
  <p>Second dish in the order: <?php echo $order[1][0]; ?></p>
  <p>"3" + 2 = <?php echo "3" + 2; ?> (PHP converts the string "3" to a number)</p>
 

  <h2>Step 3: Operators</h2>
  <p>Subtotal: GHS <?php echo number_format($subtotal, 2); ?></p>
  <p>Total (subtotal + GHS 5 service charge + 15% tax): GHS <?php echo number_format($total, 2); ?></p>
  <pre><?php echo $receipt; ?></pre>
  <ul>
    <li>Subtotal greater than 100? <?php echo $subtotal > 100 ? "Yes" : "No"; ?></li>
    <li>Member AND coupon? <?php echo ($isMember && $hasCoupon) ? "Yes" : "No"; ?></li>
    <li>Member OR coupon? <?php echo ($isMember || $hasCoupon) ? "Yes" : "No"; ?></li>
    <li>NOT member? <?php echo (!$isMember) ? "Yes" : "No"; ?></li>
    <?php  ?>
    <li>Member XOR coupon? <?php echo ($isMember xor $hasCoupon) ? "Yes" : "No"; ?></li>
  </ul>
 

  <h2>Step 4: Strings</h2>
  <p>
    <?php

    echo 'Single quotes: $barName<br>';
    echo "Double quotes: $barName<br>";
    echo 'Escape character: Kofi\'s Corner';
    ?>
  </p>
  <pre><?php
$totalFormatted = number_format($total, 2);
echo <<<_END
Receipt for $barName
$receipt
Total: GHS $totalFormatted
_END;
?></pre>
 

  <h2>Step 5: Functions and scope</h2>
  <?php
  $subtotal = 0;
  foreach ($order as $line) {
    $subtotal += lineCost($line[1], $line[2]);
  }
  ?>
  <p>Recalculated subtotal using lineCost(): GHS <?php echo number_format($subtotal, 2); ?></p>
  <p>showName() prints: <?php showName(); ?></p>
  <p><?php countOrders(); ?></p>
  <p><?php countOrders(); ?></p>
  <p><?php countOrders(); ?></p>
 

  <h2>Step 6: Printing and superglobals</h2>
  <?php

  ?>
  <p>The Chop Bar is: <?php $isOpen ? print "Open" : print "Closed"; ?></p>
  <p>Line number: <?php print __LINE__; ?></p>
  <p>File: <?php print htmlspecialchars(__FILE__); ?></p>
  <p>Server name: <?php print htmlspecialchars($_SERVER['SERVER_NAME']); ?></p>
  <p>Bar name via $GLOBALS: <?php showGlobalName(); ?></p>
 
</body>
</html>