<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

$query = "SELECT `transactionID` FROM `transactions` ORDER BY transactionID";
$mysqliResult = $mysqli->query($query);

while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    $last_ID = intval($var['transactionID']);
}

// $last_ID = $last_ID + 1;
$transactionID_last = $last_ID;

$query = "SELECT * FROM categories";
$mysqliResult = $mysqli->query($query);

$categoryList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    $categoryList[$categoryID] = new Categories($categoryID, $category, $accountingID);
}

$query = "SELECT * FROM payments";
$mysqliResult = $mysqli->query($query);

$paymentList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    $paymentList[$paymentID] = new Payments($paymentID, $paymentMethod);
}

$query = "SELECT * FROM transactions JOIN categories USING(categoryID) JOIN payments USING(paymentID)";
$mysqliResult = $mysqli->query($query);

$transactionList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    if (!array_key_exists($transactionID, $transactionList)) {
        $transactionList[$transactionID] = new Transactions($transactionID, $date, $amount, $description, $categoryID, $paymentID);
    }
}

$new_transactionID = $transactionID_last + 1;
$transactionList[$new_transactionID] = new Transactions($new_transactionID, $_POST['date'], $_POST['amount'], $_POST['description'], $_POST['category'], $_POST['paymentMethod']);

$query = "INSERT INTO `transactions`(`transactionID`, `date`, `amount`, `description`, `categoryID`, `paymentID`) VALUES ($new_transactionID, '" . $transactionList[$new_transactionID]->date . "', '" . $transactionList[$new_transactionID]->amount . "', '" . $transactionList[$new_transactionID]->description . "', '" . $transactionList[$new_transactionID]->categoryID . "', '" . $transactionList[$new_transactionID]->paymentID . "')";
$mysqliResult = $mysqli->query($query);

header("Location: http://localhost/backendproject2023/home.php");
?>
