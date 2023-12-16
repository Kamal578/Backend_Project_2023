<?php
include("database/connectDB.inc.php");
include("models/Model.php");

// Fetch categories from the database
$queryCategories = "SELECT * FROM categories";
$mysqliResultCategories = $mysqli->query($queryCategories);

$categoryList = array();
while ($var = $mysqliResultCategories->fetch_assoc()) {
    extract($var);
    $categoryList[$categoryID] = new Categories($categoryID, $category, $accountingID);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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
        *{
            overflow: hidden;
        }
        .buttons{
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 1rem;
        }

        .buttons > * {
            margin: 0 1rem;
            width: 10rem;
        }
    </style>
</head>

<body>

    <div class="row justify-content-center mt-10">
        <div class="col-md-12 mt-lg-3">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Category List</h1>
                </div>
                <div class="buttons">
                    <button class="btn btn-success" onClick="window.location.href='create_category.php'">Add
                        Category</button>
                    <button class="btn btn-danger" onClick="window.location.href='home.php'">Go Back</button>
                </div>
                <div class="card-body">
                    <table id="mainTable" class="table table-striped table-bordered" id='mainTable' style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Category</th>
                                <th scope="col">Accounting Type</th>
                                <!-- Add additional columns as needed -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categoryList as $categoryID => $category) {
                                echo "<tr>
                                        <td>$categoryID</td>
                                        <td>$category->category</td>
                                        <td>";
                                if ($category->accountingID == 1) {
                                    echo 'Income</td>';
                                } else {
                                    echo 'Expense</td>';
                                }

                                echo "<td>
                                        <a class='edit btn btn-primary' href='update_category.php?categoryID=$categoryID'>Edit</a>
                                        <button class='delete btn btn-danger' onClick='confirmDeleteCategory($categoryID)'>Delete</button>
                                      </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="src/js/delete.js"></script>
    <script>
        new DataTable('#mainTable');
    </script>

</body>

</html>