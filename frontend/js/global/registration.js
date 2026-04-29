const errorTextContainer = document.getElementById("error_message");

window.addEventListener("load", () => {

    loadBloodTypes();
    // TODO: load genders from database
    // loadGenders();

});

document.getElementById("form_submit").addEventListener("submit", (e) => {
    // refresh error message
    errorTextContainer.textContent = "";
    e.preventDefault();

    if (document.getElementById('pat_password').value !== document.getElementById('re_pat_password').value) {
        errorTextContainer.textContent = "Passwords does not match!";
        return;
    }
    // TODO: check for correction of email, phone number before being sent
});

const loadBloodTypes = async () => {
    try{
        const response = await fetch("/backend/controllers/bloodTypeController.php?action=getBloodTypes");

        if(!response.ok){
            const message = await response.json();
            document.getElementById("errorMessage").innerHTML = `<p style="color: red;"> ${message} </p>`;
            console.log(message);
            return;
        }

        const dataSet = await response.json();

        const bloodContainer = document.getElementById("blood_group");

        dataSet.forEach(data => {
            bloodContainer.innerHTML += `<option value="${data.blood_id}">${data.type_name}</option>`;
        });

    }catch(error){
        console.log(error);
    } 
}