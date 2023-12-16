function confirmDelete(questionID) {
    if (confirm("Are you sure you want to delete this question?")) {
        window.location.href = "api/delete.php?questionID=" + questionID;
    }
    else{
        return false;
    }
}