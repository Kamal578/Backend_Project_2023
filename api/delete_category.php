<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

// Check if categoryID is provided in the URL and is numeric
if (isset($_GET['categoryID']) && is_numeric($_GET['categoryID'])) {
    $categoryID = intval($_GET['categoryID']);
} else {
    // Handle the case where categoryID is not provided or not numeric
    echo "Invalid categoryID.";
    exit();
}

// Delete related transactions first
$queryDeleteTransactions = "DELETE FROM transactions WHERE categoryID = ?";
$stmtDeleteTransactions = $mysqli->prepare($queryDeleteTransactions);
$stmtDeleteTransactions->bind_param("i", $categoryID);
$stmtDeleteTransactions->execute();
$stmtDeleteTransactions->close();

// Perform the deletion operation
$query = "DELETE FROM categories WHERE categoryID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $categoryID);

if ($stmt->execute()) {
    // Redirect to the category list page after successful deletion
    header("Location: http://localhost/backendproject2023/edit_categories.php");
    exit();
} else {
    // Handle the error, e.g., display an error message
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
