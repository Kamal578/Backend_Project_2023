<?php

class Accounting {
    public $accountingID;
    public $accountingType;
    public $multCoefficient;

    public function __construct($accountingID, $accountingType, $multCoefficient) {
        $this->accountingID = $accountingID;
        $this->accountingType = $accountingType;
        $this->multCoefficient = $multCoefficient;
    }
}

class Categories {
    public $categoryID;
    public $category;
    public $accountingID;

    public function __construct($categoryID, $category, $accountingID) {
        $this->categoryID = $categoryID;
        $this->category = $category;
        $this->accountingID = $accountingID;
    }
}

class Payments {
    public $paymentID;
    public $paymentMethod;

    public function __construct($paymentID, $paymentMethod) {
        $this->paymentID = $paymentID;
        $this->paymentMethod = $paymentMethod;
    }
}

class Transactions {
    public $transactionID;
    public $date;
    public $amount;
    public $description;
    public $categoryID;
    public $paymentID;

    public function __construct($transactionID, $date, $amount, $description, $categoryID, $paymentID) {
        $this->transactionID = $transactionID;
        $this->date = $date;
        $this->amount = $amount;
        $this->description = $description;
        $this->categoryID = $categoryID;
        $this->paymentID = $paymentID;
    }
}

?>
