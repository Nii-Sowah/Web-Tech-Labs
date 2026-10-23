<?php

$barName = "Chop Bar";
$order = [
  ["Jollof Rice", 35, 2],
  ["Sobolo", 10, 3]
];

include_once "functions.php";
include_once "functions.php";
require_once "dish.php";

$subtotal = 0;
foreach ($order as $line) {
  $subtotal += lineCost($line[1], $line[2]);
}
$lines = orderLines($order);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chop Bar</title>
</head>
<body>
  <h1><?php showBarName(); ?></h1>
 

  <h2>Order</h2>
  <ul>
    <?php foreach ($lines as $text) { ?>
      <li><?php echo $text; ?></li>
    <?php } ?>
  </ul>
  <p>Subtotal before service charge: GHS <?php echo number_format($subtotal, 2); ?></p>
  <?php addServiceCharge($subtotal); ?>
  <p>Subtotal after service charge: GHS <?php echo number_format($subtotal, 2); ?></p>
 

  <h2>Dishes</h2>
  <?php
  $jollof = new Dish("Jollof Rice", 35);
  $sobolo = new Dish("Sobolo", 10);
  ?>
  <p><?php echo $jollof->describe(); ?></p>
  <p><?php echo $sobolo->describe(); ?></p>
 
  <p>Name property: <?php echo $jollof->name; ?></p>
  <?php
  // echo $jollof->price;
  // Removed: price is protected, so this line causes a
  // "Fatal error: Uncaught Error: Cannot access protected property Dish::$price".
 
  // Cloning: the clone is a separate copy, so changing it leaves the original alone
  $jollofLarge = clone $jollof;
  $jollofLarge->name = "Jollof Rice Large";
  ?>
  <p>Original: <?php echo $jollof->name; ?></p>
  <p>Clone: <?php echo $jollofLarge->name; ?></p>
 
  <?php
  /*
    Scope:
    - public: can be used from anywhere (inside the class, in subclasses and
      in code outside the class).
    - protected: can be used inside the class and its subclasses, but not
      from outside.
    - private: can be used only inside the class that declares it, not even
      in subclasses.

  */
  ?>
  <p>Jollof price via getPrice(): GHS <?php echo $jollof->getPrice(); ?></p>
 

  <p>Dishes created so far: <?php echo Dish::getCount(); ?></p>
 

  <?php $drink = new Drink("Sobolo", 10, "500ml"); ?>
  <p><?php echo $drink->describe(); ?></p>
  <p>Dishes created so far: <?php echo Dish::getCount(); ?></p>
 

  <h2>Destructors</h2>
  <p>
    <?php

    unset($jollof);
    unset($sobolo);
    unset($jollofLarge);
    unset($drink);
    ?>
  </p>
</body>
</html>