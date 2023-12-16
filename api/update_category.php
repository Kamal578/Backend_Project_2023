<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

if (array_key_exists('categoryID', $_GET) and is_numeric($_GET['categoryID'])) {
    $categoryID = intval($_GET['categoryID']);
} else {
    exit();
}

$query = "SELECT * FROM categories WHERE categoryID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$stmt->bind_result($categoryID, $category, $accountingID);
$stmt->fetch();
$stmt->close();

// Check if the provided accountingID exists in the accounting table
$accountingExists = checkIfExists($_POST['accountingID'], 'accounting', 'accountingID');

if (!$accountingExists) {
    // Handle the case where the accountingID does not exist
    echo "Invalid accountingID provided.";
    exit();
}

// Update category details
$query = "UPDATE categories SET category=?, accountingID=? WHERE categoryID=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sii", $_POST['categoryName'], $_POST['accountingID'], $categoryID);
$stmt->execute();
$stmt->close();

header("Location: http://localhost/backendproject2023/edit_categories.php");

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
