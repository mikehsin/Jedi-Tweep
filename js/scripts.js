function checkRedirect() {
    let userChoice = window.confirm("Are you sure you want to clear all content and move to the home page? All changes will be lost and this action is not reversible. Please confirm.")

    if (userChoice === true) {
        window.location = "index.php"
    }
}