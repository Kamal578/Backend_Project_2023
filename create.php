<?php
include("database/connectDB.inc.php");
include("models/Model.php");

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>Create</title>
</head>
<link rel="stylesheet" href="src/css/create.css">
<link rel="stylesheet" href="src/css/main.css">

<body>
   <form action='/backendproject2023/api/create.php' method="post">
      <fieldset>
         <legend>
            <h1>Creating new transaction</h1>
         </legend>
         <article id="nonselectables">
            <p class="nonselectable">
               <label class="label" for="date">Date</label>
               <input type="date" name="date" id="date" required>
            </p>
            <p class="nonselectable">
               <label class="label" for="amount">Amount</label>
               <input type="number" name="amount" id="amount" required>
            </p>
            <p class="nonselectable">
               <label class="label" for="description">Description</label>
               <input type="text" name="description" id="description" required>
            </p>
         </article>
         <label class="label" for="category">Category</label>
         <select name='category' id="category">
            <?php
            foreach ($categoryList as $categoryID => $category) {
               echo "<option value=\"$categoryID\">$category->category</option>";
            }
            ?>
         </select>

         <label class="label" for="paymentMethod">Payment Method</label>
         <select name='paymentMethod' id="paymentMethod">
            <?php
            foreach ($paymentList as $paymentID => $payment) {
               echo "<option value=\"$paymentID\">$payment->paymentMethod</option>";
            }
            ?>
         </select>

         <br>
         <div id="buttonsContainer">
            <input type="submit" value="Submit" id="submit" class='button' onclick="checkIfEmpty()"> <br>
            <a id="cancel" href="home.php" class='button'>Cancel</a>
         </div>
      </fieldset>
   </form>
   <script src="src/js/dateRestrictor.js"></script>
</body>

</html>