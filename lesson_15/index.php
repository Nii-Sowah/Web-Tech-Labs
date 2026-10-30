<?php

$dishes = array("Jollof Rice", "Waakye", "Kelewele");
 
$drinks = array();
$drinks[] = "Sobolo";
$drinks[] = "Asaana";
 

$prices = array(
  "Jollof Rice" => 35,
  "Waakye"      => 30,
  "Kelewele"    => 15,
  "Sobolo"      => 10
);
 


$order = array(
  array("Jollof Rice", 35, 2),
  array("Sobolo", 10, 3)
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chop Bar</title>
</head>
<body>
  <h1>Chop Bar</h1>
 

  <h2>Step 1: Numerically indexed arrays</h2>
  <p>Second dish: <?php echo $dishes[1]; ?></p>
  <p>Number of dishes: <?php echo count($dishes); ?></p>
  <p>Is $drinks an array? <?php echo is_array($drinks) ? "Yes" : "No"; ?></p>
  <p>Is "Chop Bar" an array? <?php echo is_array("Chop Bar") ? "Yes" : "No"; ?></p>
 

  <h2>Step 2: Associative arrays</h2>
  <p>Price of Waakye: GHS <?php echo $prices["Waakye"]; ?></p>
 

  <h2>Step 3: foreach...as</h2>
  <p>Dishes:</p>
  <ul>
    <?php foreach ($dishes as $dish) { ?>
      <li><?php echo $dish; ?></li>
    <?php } ?>
  </ul>
  <p>Menu with prices:</p>
  <ul>
    <?php foreach ($prices as $dish => $price) { ?>
      <li><?php echo $dish . " - GHS " . $price; ?></li>
    <?php } ?>
  </ul>
 

  <h2>Step 4: Multidimensional arrays</h2>
  <ul>
    <?php
    $subtotal = 0;
    foreach ($order as $line) {
      $cost = $line[1] * $line[2];
      $subtotal += $cost;
      echo "<li>" . $line[2] . " x " . $line[0] . " - GHS " . $cost . "</li>";
    }
    ?>
  </ul>
  <p>Subtotal: GHS <?php echo number_format($subtotal, 2); ?></p>
 

  <h2>Step 5: Sorting and position</h2>
  <p>Sorted dishes:</p>
  <ul>
    <?php
    sort($dishes);   // alphabetical order
    foreach ($dishes as $dish) {
      echo "<li>" . $dish . "</li>";
    }
    ?>
  </ul>
  <?php shuffle($dishes); // random order, different on every page load ?>
  <p>Today's first dish: <?php echo reset($dishes); ?></p>
  <p>Today's last dish: <?php echo end($dishes); ?></p>
 

  <h2>Step 6: Converting arrays</h2>
  <?php
  $items = explode(",", "Jollof Rice,Waakye,Kelewele");
 
  $customer = "Ama";
  $table = 4;
  $info = compact("customer", "table");
 
  /*
    compact() builds an array out of variables: each variable's name becomes
    a key and its value becomes the value.

    extract() does the reverse: it takes an array and creates a variable for
    each key, named after the key and holding the value.

  */
  extract(array("waiter" => "Kojo", "tip" => 5));
  ?>
  <p>explode() gave <?php echo count($items); ?> items, the last is: <?php echo end($items); ?></p>
  <p>Customer from compact(): <?php echo $info["customer"]; ?></p>
  <p>Waiter from extract(): <?php echo $waiter; ?>, tip: GHS <?php echo $tip; ?></p>
 
</body>
</html>