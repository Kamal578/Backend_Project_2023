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

// Check if the provided categoryID and paymentID exist in the respective tables
$categoryExists = checkIfExists($_POST['category'], 'categories', 'categoryID');
$paymentExists = checkIfExists($_POST['paymentMethod'], 'payments', 'paymentID');

if (!$categoryExists || !$paymentExists) {
    // Handle the case where the categoryID or paymentID does not exist
    echo "Invalid categoryID or paymentID provided.";
    exit();
}

// Update transaction details
$query = "UPDATE transactions SET date=?, amount=?, description=?, categoryID=?, paymentID=? WHERE transactionID=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sdsiii", $_POST['date'], $_POST['amount'], $_POST['description'], $_POST['category'], $_POST['paymentMethod'], $transactionID);
$stmt->execute();
$stmt->close();

// Optionally, you can update related data in other tables (e.g., answers) if needed.

header("Location: http://localhost/backendproject2023/home.php");

// Function to check if a value exists in a table
function checkIfExists($value, $table, $column) {
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
