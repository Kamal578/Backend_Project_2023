<?php
include("../database/connectDB.inc.php");
include("../models/Model.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the last paymentID
    $queryLastID = "SELECT MAX(paymentID) AS lastID FROM payments";
    $resultLastID = $mysqli->query($queryLastID);
    $lastIDRow = $resultLastID->fetch_assoc();
    $lastPaymentID = ($lastIDRow['lastID']) ? $lastIDRow['lastID'] : 0;

    // Increment the last paymentID to get a new one
    $newPaymentID = $lastPaymentID + 1;

    // Validate and process the form data
    $paymentMethod = $_POST['paymentMethod'] ?? '';

    // Perform any necessary validation here

    // Insert the new payment into the database
    $query = "INSERT INTO payments (paymentID, paymentMethod) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("is", $newPaymentID, $paymentMethod);

    if ($stmt->execute()) {
        // Redirect to the payment list page after successful creation
        header("Location: http://localhost/backendproject2023/edit_payment_methods.php");
        exit();
    } else {
        // Handle the error, e.g., display an error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
