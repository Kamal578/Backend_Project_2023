function confirmDelete(transactionID) {
    if (confirm("Are you sure you want to delete this transaction?")) {
        window.location.href = "api/delete.php?transactionID=" + transactionID;
    }
    else{
        return false;
    }
}

function confirmDeleteCategory(categoryID) {
    if (confirm("Are you sure you want to delete this category?")) {
        window.location.href = "api/delete_category.php?categoryID=" + categoryID;
    } else {
        return false;
    }
}