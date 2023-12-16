<?php 
include("../database/connectDB.inc.php");
include("../models/Model.php");

if (array_key_exists('transactionID', $_GET) and is_numeric($_GET['transactionID'])) {
    $transactionID = intval($_GET['transactionID']);
} else {
    exit();
}

$query = "SELECT * FROM transactions WHERE transactionID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $transactionID);
$stmt->execute();
$stmt->bind_result($transactionID, $date, $amount, $description, $categoryID, $paymentID);
$stmt->fetch();
$stmt->close();

// Delete the transaction
$query = "DELETE FROM transactions WHERE transactionID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $transactionID);
$stmt->execute();
$stmt->close();

// Optionally, you can delete related data in other tables (e.g., answers) if needed.

header("Location: http://localhost/maarif/home.php");
?>
