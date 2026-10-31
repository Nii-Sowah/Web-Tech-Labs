<?php

date_default_timezone_set("Africa/Accra"); 
 
function yesNo($value) {
  return $value ? "Yes" : "No";
}


$order = [
  ["Jollof Rice", 35, 2],
  ["Sobolo", 10, 3]
];
$orderNumber = 42;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chop Bar Receipts</title>
</head>
<body>
  <h1>Chop Bar</h1>
 

  <h2>Step 1: printf</h2>
  <p>
    <?php
    foreach ($order as $line) {
      printf("%d x %s - GHS %.2f<br>", $line[2], $line[0], $line[1] * $line[2]);
    }
    ?>
  </p>
  <pre><?php
printf("%-15s%8s\n", "Dish", "Price");
foreach ($order as $line) {
  printf("%-15s%8.2f\n", $line[0], $line[1] * $line[2]);
}
?></pre>
  <p><?php printf("Order #%05d", $orderNumber); ?></p>
 
  <h2>Step 2: sprintf</h2>
  <?php
  $receiptLines = [];
  $subtotal = 0;
  foreach ($order as $line) {
    $cost = $line[1] * $line[2];
    $subtotal += $cost;
    $formatted = sprintf("%d x %-12s GHS %6.2f", $line[2], $line[0], $cost);
    $receiptLines[] = $formatted;
  }
  $receiptLines[] = sprintf("%-16s GHS %6.2f", "Total", $subtotal);
  $receipt = implode("\n", $receiptLines);
  ?>
  <pre><?php echo $receipt; ?></pre>
 

  <h2>Step 3: Date and time</h2>
  <p>Now: <?php echo date("l, d F Y H:i"); ?></p>
  <p>RSS format: <?php echo date(DATE_RSS); ?></p>
  <p>30 February 2026: <?php echo checkdate(2, 30, 2026) ? "Valid" : "Invalid"; ?></p>
  <p>28 February 2026: <?php echo checkdate(2, 28, 2026) ? "Valid" : "Invalid"; ?></p>
 

  <h2>Step 4: Creating and reading files</h2>
  <?php
  $file = __DIR__ . "/orders.txt";
  ?>
  <p>Does orders.txt exist yet? <?php echo yesNo(file_exists($file)); ?>
     (No on the first load, Yes after you reload.)</p>
  <?php


  $line1 = sprintf("%s | Order #%05d | 2 x Jollof Rice, 3 x Sobolo | GHS %.2f",
                   date("d M Y H:i"), $orderNumber, $subtotal);
  $handle = fopen($file, "w");
  fwrite($handle, $line1 . "\n");
  fclose($handle);
 

  $handle = fopen($file, "r");
  $firstLine = fgets($handle);
  fclose($handle);
  ?>
  <p>First line: <?php echo htmlspecialchars($firstLine); ?></p>
 
  <h2>Step 5: Updating and locking</h2>
  <?php

  $line2 = sprintf("%s | Order #%05d | 1 x Waakye | GHS %.2f",
                   date("d M Y H:i"), $orderNumber + 1, 30);
  $handle = fopen($file, "a"); 
  flock($handle, LOCK_EX);
  fwrite($handle, $line2 . "\n");
  flock($handle, LOCK_UN);
  fclose($handle);
  ?>
  <p>Whole file:</p>
  <pre><?php echo htmlspecialchars(file_get_contents($file)); ?></pre>
 

  <h2>Step 6: Copy, move, delete</h2>
  <?php
  $backup = __DIR__ . "/backup.txt";
  $archive = __DIR__ . "/archive.txt";
 
  copy($file, $backup);
  ?>
  <p>After copy(): backup.txt exists? <?php echo yesNo(file_exists($backup)); ?></p>
  <?php
  rename($backup, $archive);
  ?>
  <p>After rename(): archive.txt exists? <?php echo yesNo(file_exists($archive)); ?>,
     backup.txt exists? <?php echo yesNo(file_exists($backup)); ?></p>
  <?php
  unlink($archive);
  ?>
  <p>After unlink(): archive.txt exists? <?php echo yesNo(file_exists($archive)); ?></p>
 
  <p><a href="upload.php">Upload a payment photo</a></p>
</body>
</html>
 