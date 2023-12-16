<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

if (array_key_exists('paymentID', $_GET) && is_numeric($_GET['paymentID'])) {
    $paymentID = intval($_GET['paymentID']);
} else {
    exit();
}

$query = "SELECT * FROM payments WHERE paymentID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $paymentID);
$stmt->execute();
$stmt->bind_result($paymentID, $paymentMethod);
$stmt->fetch();
$stmt->close();

// Update payment details
$query = "UPDATE payments SET paymentMethod=? WHERE paymentID=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("si", $_POST['paymentMethod'], $paymentID);
$stmt->execute();
$stmt->close();

header("Location: http://localhost/backendproject2023/edit_payment_methods.php");
?>