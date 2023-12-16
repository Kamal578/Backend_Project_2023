<?php
include("database/connectDB.inc.php");
include("models/Model.php");

if (array_key_exists('transactionID', $_GET) and is_numeric($_GET['transactionID'])) {
    $transactionID = intval($_GET['transactionID']);
} else {
    exit();
}

$queryCategories = "SELECT * FROM categories";
$mysqliResultCategories = $mysqli->query($queryCategories);

$categoryList = array();
while ($var = $mysqliResultCategories->fetch_assoc()) {
    extract($var);
    $categoryList[$categoryID] = new Categories($categoryID, $category, $accountingID);
}

$queryPayments = "SELECT * FROM payments";
$mysqliResultPayments = $mysqli->query($queryPayments);

$paymentList = array();
while ($var = $mysqliResultPayments->fetch_assoc()) {
    extract($var);
    $paymentList[$paymentID] = new Payments($paymentID, $paymentMethod);
}

$query = "SELECT * FROM transactions WHERE transactionID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $transactionID);
$stmt->execute();
$stmt->bind_result($transactionID, $date, $amount, $description, $categoryID, $paymentID);
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
    <title>Update</title>
</head>
<script src="src/js/dateRestrictor.js"></script>
<body>

    <?php
    echo "<h1 id='title'>Transaction ID: $transactionID</h1>";

    echo "<form action='api/update.php?transactionID=$transactionID' method='post'>
            <p><label for='date' id='newDate'>Date <br/></label>
            <input type='date' name='date' id='date' value='$date' required></p>
            <p><label for='amount' id='newAmount'>Amount</label><br/>  
            <input type='number' name='amount' id='amount' value='$amount' required></p>
            <p><label for='description' id='newDescription'>Description<br/></label>
            <input type='text' name='description' id='description' value='$description' required></p>";

    echo "<label for='category' id='newCategory'>Category</label>
            <select name='category' id='category'>";
    foreach ($categoryList as $categoryID => $category) {
        $selected = ($categoryID == $categoryID) ? 'selected' : '';
        echo "<option value='$categoryID' $selected>$category->category</option>";
    }
    echo "</select>";

    echo "<label for='paymentMethod' id='newPaymentMethod'>Payment Method</label>
            <select name='paymentMethod' id='paymentMethod'>";
    foreach ($paymentList as $paymentID => $payment) {
        $selected = ($paymentID == $paymentID) ? 'selected' : '';
        echo "<option value='$paymentID' $selected>$payment->paymentMethod</option>";
    }
    echo "</select>";

    echo "<input type='submit' value='Submit' id='submit' class='actionButton submit'>";
    echo "</form>";

    echo "<h1 style='margin-bottom: 1rem;'><a href='/backendproject2023/index.php' class='actionButton cancel'>Cancel</h1>";
    ?>
</body>

</html>