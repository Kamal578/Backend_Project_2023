<?php
include("database/connectDB.inc.php");
include("models/Model.php");

if (array_key_exists('categoryID', $_GET) and is_numeric($_GET['categoryID'])) {
    $categoryID = intval($_GET['categoryID']);
} else {
    exit();
}

$queryCategories = "SELECT * FROM categories";
$mysqliResultCategories = $mysqli->query($queryCategories);

$categoryList = array();
while ($var = $mysqliResultCategories->fetch_assoc()) {
    extract($var);
    $categoryList[$categoryID] = new Categories($categoryID, $category, $accountingID);
}

$queryPayments = "SELECT * FROM payments";
$mysqliResultPayments = $mysqli->query($queryPayments);

$paymentList = array();
while ($var = $mysqliResultPayments->fetch_assoc()) {
    extract($var);
    $paymentList[$paymentID] = new Payments($paymentID, $paymentMethod);
}

$query = "SELECT * FROM categories WHERE categoryID = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$stmt->bind_result($categoryID, $category, $accountingID);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/update.css">
    <link rel="stylesheet" href="src/css/main.css">
    <title>Update Category</title>
</head>

<body>

    <?php
    echo "<h1 id='title'>Category ID: $categoryID</h1>";

    echo "<form action='api/update_category.php?categoryID=$categoryID' method='post'>
            <p><label for='categoryName' id='newCategoryName'>Category Name <br/></label>
            <input type='text' name='categoryName' id='categoryName' value='$category' required></p>";

    echo "<label for='accountingID' id='newAccountingID'>Accounting</label>
            <select name='accountingID' id='accountingID'>";
    $count = 0;
    foreach ($categoryList as $catID => $cat) {
        $count++;
        if ($count % 2 == 0) {
            $selected = ($catID == $accountingID) ? 'selected' : '';
            echo "<option value='$catID' $selected>";
            if ($cat->accountingID == 1) {
                echo "Income";
            } else {
                echo "Expense";
            }   
            echo "</option>";
        }
    }
    echo "</select>";

    echo "<input type='submit' value='Submit' id='submit' class='actionButton submit'>";
    echo "</form>";

    echo "<h1 style='margin-bottom: 1rem;'><a href='/backendproject2023/edit_categories.php' class='actionButton cancel'>Cancel</h1>";
    ?>
</body>

</html>
