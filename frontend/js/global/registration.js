const errorTextContainer = document.getElementById("error_message");

window.addEventListener("load", () => {

    

});

document.getElementById("form_submit").addEventListener("submit", (e) => {
    // refresh error message
    errorTextContainer.textContent = "";
    e.preventDefault();

    if (document.getElementById('pat_password').value !== document.getElementById('re_pat_password').value) {
        errorTextContainer.textContent = "Passwords does not match!";
        return;
    }
});