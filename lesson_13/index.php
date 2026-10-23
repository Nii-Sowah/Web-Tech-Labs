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
        /* 
        Echo true prints 1, because php converts true to the string "!" when it is echoed, echo false prints nothing ran emoty string), because false is converted to an empty string.
        */ 


        ?>
        <p>echo true prints: [<?php echo true; ?>]</p>
        <p> echo false prints: [<?php echo false; ?>]</p>


        <h2>Step 2: Operators</h2>
        <p> Quantity of Sobolo after ++; <?php echo $order[1][2]; ?></p>
        <p>Subtotal: GHS <?php echo number_format($subtotal, 2); ?></p>
        <p><?php echo $receiptLine; ?></p>
        <p>Combined prices (array union):</p>
        <ul>
            <?php foreach ($combined as $dish => $price) { ?>
                <li><?php echo $dish; ?>: GHS <?php echo number_format($price, 2); ?></li>
            <?php } ?>
        </ul>
        <p>12 ^ 9 = <?php echo 12 ^ 9; ?> (bitwise XOR: 1100 ^ 1001 = 0101)</p>
        

        <h2>Step 3: Precedence and Associativity</h2>
        <?php
        ?>
        <p> 2 + 3 * 4 = <?php echo 2 + 3 * 4; ?></p>
        <p>(2 + 3) * 4 = <?php echo (2 + 3) * 4; ?></p>
        <p>20 - 5 - 3 = <?php echo 20 - 5 - 3; ?></p>


        <h2>Step 4: Relational operators and conditionals</h2>
        <ul><li>"10" == 10: <?php echo ("10" == 10) ? "Yes" : "No"; ?></li>
        <li>"10" === 10: <?php echo ("10" === 10) ? "Yes" : "No"; ?></li>
        <li>$subtotal != 100: <?php echo ($subtotal != 100) ? "Yes" : "No"; ?></li>
    </ul>
    <p>
        <?php
        if ($subtotal = 150) {
            echo "Big order! Free drink on us.";
        } elseif ($subtotal >= 50) {
            echo "Thanks for your order!";
        } else {
            echo "Small chop, still sweet!";
        }
        ?>
    </p>
    <p>We are currently: <?php echo $isOpen ? "open" : "closed"; ?></p>


    <h2>Step 5: Switch</h2>
    <p>
        Payment method: <?php echo $paymentMethod; ?><br>
        <?php
        switch ($paymentMethod) {
            case "cash":
                echo "Please pay at the counter.";
                break;
            case "momo":
                echo "Please pay with Mobile Money to the Chop Bar number..";
                break;
            case "card":
                echo "Please pay with your card.";
                break;
            default:
                echo "Sorry, we do not accept that payment method.";
        }
        ?>
    </p>

    <h2>Step 6: Loops</h2>

    <p>Order lines (the line with quantity 0 is skipped with continue):</p>
    <ul>
        <?php
        $order[] = ["Waakye", 30, 0]; // a line with a quantity of 0

        for ($i = 0; $i < count($order); $i++) {
            if ($order[$i][2] == 0) {
                continue; //skip this line and go to the next one
            }
            echo "<li>" . $order[$i][2] . " x " . $order[$i][0] . " - GHS " . ($order[$i][1] * $order[$i][2]) . "</li>";
        }
        ?>
    </ul>
    <p>Countdown (while):</p>
  <p>
    <?php
    $count = 3;
    while ($count >= 1) {
      echo $count . "<br>";
      $count--;
    }
    echo "Order ready!";
    ?>
  </p>
 
  <p>do...while (starts at 5, runs while the number is less than 3):</p>
  <p>
    <?php
    $number = 5;
    do {
      echo "The loop body ran with number = " . $number
         . " even though 5 is not less than 3, because do...while checks the condition after running.";
    } while ($number < 3);
    ?>
  </p>
 
  <p>Dish names (break stops at Sobolo):</p>
  <p>
    <?php
    for ($i = 0; $i < count($order); $i++) {
      echo $order[$i][0] . "<br>";
      if ($order[$i][0] == "Sobolo") {
        break; // stop the loop as soon as Sobolo is reached
      }
    }
    ?>
  </p>
 
  <h2>Step 7: Implicit and explicit casting</h2>
  <?php
  /*
    Implicit casting happens automatically: PHP changes a value's type by
    itself because of the operation being done, for example "5" + 5 turns the
    string "5" into a number so the + can add it.
    Explicit casting is when the programmer forces the type with a cast
    operator such as (int), (float), (string) or (bool).
  */
  ?>
  <ul>
    <li>"5" + 5 = <?php echo "5" + 5; ?> (implicit)</li>
    <li>(int) "12 plates" = <?php echo (int) "12 plates"; ?></li>
    <li>(float) "35.50" = <?php echo (float) "35.50"; ?></li>
    <li>(string) 70 . " cedis" = <?php echo (string) 70 . " cedis"; ?></li>
    <li>(bool) 0 = <?php echo ((bool) 0) ? "true" : "false"; ?></li>
    <li>(bool) "Sobolo" = <?php echo ((bool) "Sobolo") ? "true" : "false"; ?></li>
  </ul>

    </body>
</html>