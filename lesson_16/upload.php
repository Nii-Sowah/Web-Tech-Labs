<?php
$uploadDir = __DIR__ . "/uploads";
$maxSize = 1024 * 1024; 
$allowed = ["image/jpeg" => "jpg", "image/png" => "png"];
 
$file = null;
$error = "";
$success = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["payment"])) {
  $file = $_FILES["payment"];
 
  if ($file["error"] === UPLOAD_ERR_NO_FILE) {
    $error = "Please choose a file first.";
    $file = null;
  } elseif ($file["error"] !== UPLOAD_ERR_OK) {
    $error = "The upload failed (error code " . $file["error"] . "). The file may be too large.";
  } else {

    $imageInfo = getimagesize($file["tmp_name"]);
    $realType = $imageInfo ? $imageInfo["mime"] : "";
 
    if (!isset($allowed[$realType])) {
      $error = "Only JPEG or PNG images are accepted.";
    } elseif ($file["size"] > $maxSize) {
      $error = "The file is too large. The limit is 1 MB.";
    } else {
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755);
      }

      $newName = "payment_" . bin2hex(random_bytes(8)) . "." . $allowed[$realType];
 
      if (move_uploaded_file($file["tmp_name"], $uploadDir . "/" . $newName)) {
        $success = "Thank you! Your payment photo was saved as " . $newName . ".";
      } else {
        $error = "Sorry, the file could not be saved.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Payment Photo</title>
</head>
<body>
  <h1>Upload your payment photo</h1>
 
  <form method="post" enctype="multipart/form-data">
    <label for="payment">Payment photo (JPEG or PNG, under 1 MB):</label>
    <input type="file" name="payment" id="payment">
    <button type="submit">Upload</button>
  </form>
 
  <?php if ($file !== null) { ?>
    <h2>File details</h2>
    <ul>
      <li>Name: <?php echo htmlspecialchars($file["name"]); ?></li>
      <li>Type: <?php echo htmlspecialchars($file["type"]); ?></li>
      <li>Size: <?php echo (int) $file["size"]; ?> bytes</li>
    </ul>
  <?php } ?>
 
  <?php if ($error !== "") { ?>
    <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
  <?php } ?>
 
  <?php if ($success !== "") { ?>
    <p><strong><?php echo htmlspecialchars($success); ?></strong></p>
  <?php } ?>
 
  <p><a href="index.php">Back to receipts</a></p>
</body>
</html>
