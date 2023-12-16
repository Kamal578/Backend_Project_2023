function confirmDelete(transactionID) {
    if (confirm("This action will delete this transaction PERMANENTLY. Are you sure?")) {
        window.location.href = "api/delete.php?transactionID=" + transactionID;
    }
    else{
        return false;
    }
}

function confirmDeleteCategory(categoryID) {
    if (confirm("This action will delete this category and all of the associated transactions PERMANENTLY. Are you sure?")) {
        window.location.href = "api/delete_category.php?categoryID=" + categoryID;
    } else {
        return false;
    }
}

function confirmDeletePaymentMethod(paymentMethodID) {
    if (confirm("This action will delete this payment method and all of the associated transactions PERMANENTLY. Are you sure?")) {
        window.location.href = "api/delete_payment.php?paymentID=" + paymentMethodID;
    } else {
        return false;
    }
}