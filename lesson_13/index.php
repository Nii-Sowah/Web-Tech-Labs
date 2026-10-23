<?php

$barName = "Chop Bar";
$jollofPrice = 35;
$soboloPrice = 10;
$isOpen = true;
$paymentMethod = "momo";

$order = [
    ["Jollof Rice", $jollofPrice, 2],
    ["Sobolo", $soboloPrice, 3]
];


$order[1][2]++;

$subtotal = ($order[0][1] * $order[0][2] * ($order[1][1] * $order[1][2]));

$total = $subtotal;
$total += 5;

$receiptLine = "Total: GHS " . number_format($total, 2)
             . " (subtotal GHS " . number_format($subtotal, 2)
             . " + service charge GHS 5.00)"; 

$menu = ["jollof" => 45, "waakye" => 30];
$specials = ["waakye" => 25, "kelewele" => 15];
$combined = $menu + $specials;


?>


<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF 8">
        <title>Chop Bar</title>
    </head>

    <body>
        <h1><?php echo $barName; ?></h1>

        <h2>Step 1: Booleans</h2>

        <?php

        ?>
    </body>
</html>