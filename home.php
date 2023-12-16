<?php
include("database/connectDB.inc.php");
include("models/Model.php");

try {
    $query = "SELECT * FROM categories";
    $mysqliResult = $mysqli->query($query);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

$categoryList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    $categoryList[$categoryID] = new Categories($categoryID, $category, $accountingID);
}

try {
    $query = "SELECT * FROM payments";
    $mysqliResult = $mysqli->query($query);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

$paymentList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    $paymentList[$paymentID] = new Payments($paymentID, $paymentMethod);
}

try {
    $query = "SELECT * FROM transactions 
              JOIN categories USING(categoryID) 
              JOIN payments USING(paymentID)";
    $mysqliResult = $mysqli->query($query);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

$transactionList = array();
while ($var = $mysqliResult->fetch_assoc()) {
    extract($var);
    if (!array_key_exists($transactionID, $transactionList))
        $transactionList[$transactionID] = new Transactions($transactionID, $date, $amount, $description, $categoryID, $paymentID);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="src/css/main.css">
    <link rel="stylesheet" href="src/css/home.css">
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
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/backendproject2023/home.php">Backend Project</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/backendproject2023/home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_categories.php">Modify Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_payment_methods.php">Modify Payment Methods</a>
                </li>
            </ul>
        </div>
    </nav>
    <a class="create" href="create.php">
        Add new transaction
    </a>

    <div class="row justify-content-center mt-10">
        <div class="col-md-12 mt-lg-3">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Transaction List</h1>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered" id='mainTable' style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($transactionList as $keyTransactionID => $valueTransaction) {
                                echo "<tr>
                                        <th score='row' class='id'><strong> $keyTransactionID</strong></td>
                                        <td class='date'>$valueTransaction->date </td>
                                        <td class='amount'>$valueTransaction->amount</td>
                                        <td class='description'>$valueTransaction->description</td>
                                        <td class='category'>" . $categoryList[$valueTransaction->categoryID]->category . "</td>
                                        <td class='paymentMethod'>" . $paymentList[$valueTransaction->paymentID]->paymentMethod . "</td>
                                        <td class='action'>
                                            <a class='edit btn btn-primary' href='update.php?transactionID=$keyTransactionID'>Edit</a>
                                            <button style='width:100%;height:100%;' class='delete btn btn-danger' onClick='confirmDelete($keyTransactionID)'>Delete</a>
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