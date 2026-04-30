const errorTextContainer = document.getElementById("error_message");

window.addEventListener("load", () => {
    loadBloodTypes();
    loadGenders();
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

        const dataSet = await response.json();
        if(!response.ok){
            document.getElementById("errorMessage").innerHTML = `<p style="color: red;"> ${dataSet} </p>`;
            console.log(dataSet);
            return;
        }

        const bloodContainer = document.getElementById("blood_group");

        dataSet.forEach(data => {
            bloodContainer.innerHTML += `<option value="${data.blood_id}">${data.type_name}</option>`;
        });

    }catch(error){
        console.log(error);
    } 
}

const loadGenders = async () => {
    try{
        const response = await fetch("/backend/controllers/genderController.php?action=getGenders");
        
        const dataSet = await response.json();
        if(!response.ok){
            document.getElementById("errorMessage").innerHTML = `<p style="color: red;"> ${dataSet} </p>`;
            console.log(dataSet);
            return;
        }

        const genderContainer = document.getElementById("gender");
        dataSet.forEach(data => {
            genderContainer.innerHTML += `<option value="${data.gender_name}">${data.gender_name}</option>`;
        });
    }catch(error){
        console.log(error);
    }
}