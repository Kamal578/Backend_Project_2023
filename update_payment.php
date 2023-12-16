<?php
include("database/connectDB.inc.php");
include("models/Model.php");

if (array_key_exists('paymentID', $_GET) && is_numeric($_GET['paymentID'])) {
    $paymentID = intval($_GET['paymentID']);
} else {
    exit();
}

$queryPayments = "SELECT * FROM payments";
$mysqliResultPayments = $mysqli->query($queryPayments);

$paymentList = array();
while ($var = $mysqliResultPayments->fetch_assoc()) {
    extract($var);
    $paymentList[$paymentID] = new Payments($paymentID, $paymentMethod);
}

$query = "SELECT * FROM payments WHERE paymentID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $paymentID);
$stmt->execute();
$stmt->bind_result($paymentID, $paymentMethod);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/update.css">
    <link rel="stylesheet" href="src/css/main.css">
    <title>Update Payment</title>
</head>

<body>

    <?php
    echo "<h1 id='title'>Payment ID: $paymentID</h1>";

    echo "<form action='api/update_payment.php?paymentID=$paymentID' method='post'>
            <p><label for='paymentMethod' id='newPaymentMethod'>Payment Method<br/></label>
            <input type='text' name='paymentMethod' id='paymentMethod' value='$paymentMethod' required></p>";

    echo "<input type='submit' value='Submit' id='submit' class='actionButton submit'>";
    echo "</form>";

    echo "<h1 style='margin-bottom: 1rem;'><a href='/maarif/payments.php' class='actionButton cancel'>Cancel</h1>";
    ?>
</body>

</html>
