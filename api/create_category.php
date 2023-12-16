<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the last categoryID
    $queryLastID = "SELECT MAX(categoryID) AS lastID FROM categories";
    $resultLastID = $mysqli->query($queryLastID);
    $lastIDRow = $resultLastID->fetch_assoc();
    $lastCategoryID = ($lastIDRow['lastID']) ? $lastIDRow['lastID'] : 0;

    // Increment the last categoryID to get a new one
    $newCategoryID = $lastCategoryID + 1;

    // Validate and process the form data
    $category = $_POST['category'] ?? '';
    $accountingID = $_POST['accountingID'] ?? '';

    // Perform any necessary validation here

    // Insert the new category into the database
    $query = "INSERT INTO categories (categoryID, category, accountingID) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("isi", $newCategoryID, $category, $accountingID);
    
    if ($stmt->execute()) {
        // Redirect to the category list page after successful creation
        header("Location: http://localhost/backendproject2023/edit_categories.php");
        exit();
    } else {
        // Handle the error, e.g., display an error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
