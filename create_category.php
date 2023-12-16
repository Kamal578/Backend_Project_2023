<?php
include("database/connectDB.inc.php");
include("models/Model.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and process the form data
    $category = $_POST['category'] ?? '';
    $accountingID = $_POST['accountingID'] ?? '';

    // Perform any necessary validation here

    // Insert the new category into the database
    $query = "INSERT INTO categories (category, accountingID) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $category, $accountingID);

    if ($stmt->execute()) {
        header("Location: categories.php"); // Redirect to the category list page
        exit();
    } else {
        // Handle the error, e.g., display an error message
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="src/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        body{
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="row justify-content-center mt-10">
        <div class="col-md-6 mt-lg-3">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Create New Category</h1>
                </div>
                <div class="card-body">
                    <form action="api/create_category.php" method="post">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="accountingID" class="form-label">Accounting Type (Income/Expense)</label>
                            <select class="form-select" aria-label="Default select example" id="accountingID"
                                name="accountingID" required>
                                <option value="1">Income</option>
                                <option value="2">Expense</option>
                            </select>
                            <!-- <input type="number" class="form-control" id="accountingID" name="accountingID" required> -->
                        </div>
                        <!-- Add additional form fields as needed -->
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </form>
                    <!-- cancel button -->
                    <a href="edit_categories.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>