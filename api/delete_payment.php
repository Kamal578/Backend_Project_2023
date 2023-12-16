<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

if (array_key_exists('paymentID', $_GET) && is_numeric($_GET['paymentID'])) {
    $paymentID = intval($_GET['paymentID']);
} else {
    exit();
}

// Check if the paymentID exists in the payments table
$paymentExists = checkIfExists($paymentID, 'payments', 'paymentID');

if (!$paymentExists) {
    // Handle the case where the paymentID does not exist
    echo "Invalid paymentID provided.";
    exit();
}

// Delete related transactions first
$queryDeleteTransactions = "DELETE FROM transactions WHERE paymentID = ?";
$stmtDeleteTransactions = $mysqli->prepare($queryDeleteTransactions);
$stmtDeleteTransactions->bind_param("i", $paymentID);
$stmtDeleteTransactions->execute();
$stmtDeleteTransactions->close();

// Now, you can safely delete the payment
$queryDeletePayment = "DELETE FROM payments WHERE paymentID = ?";
$stmtDeletePayment = $mysqli->prepare($queryDeletePayment);
$stmtDeletePayment->bind_param("i", $paymentID);
$stmtDeletePayment->execute();
$stmtDeletePayment->close();

header("Location: http://localhost/backendproject2023/edit_payment_methods.php");

// Function to check if a value exists in a table
function checkIfExists($value, $table, $column)
{
    global $mysqli;
    $query = "SELECT COUNT(*) FROM $table WHERE $column = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $value);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}
?>