const errorTextContainer = document.getElementById("errorMessage");

window.addEventListener("load", () => {
    loadBloodTypes();
    loadGenders();
});

document.getElementById("registrationForm").addEventListener("submit", (e) => {
    e.preventDefault();
    // refresh error message
    errorTextContainer.textContent = "";
    
    if (document.getElementById('pat_password').value !== document.getElementById('re_pat_password').value) {
        showError("Passwords does not match!");
        return;
    }

    verifyAndSendFormContents();
});

const loadBloodTypes = async () => {
    try{
        const response = await fetch("/backend/controllers/bloodTypeController.php?action=getBloodTypes");

        const dataSet = await response.json();
        if(!response.ok){
            showError(dataSet);
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
            showError(dataSet);
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

const verifyAndSendFormContents = async () => {
    // creating array of inputs
    const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        tc_no: document.getElementById('tc_no').value,
        birth_date: document.getElementById('birth_date').value,
        gender: document.getElementById('gender').value,
        blood_group: document.getElementById('blood_group').value,
        phone_num: document.getElementById('phone_num').value,
        email: document.getElementById('email').value,
        password: document.getElementById('pat_password').value
    };

    // Check if any value is empty or null
    // some() determines whether an value of object returns true for condition
    const hasEmptyField = Object.values(formData).some(value => value === "" || value === null);
    
    if(hasEmptyField){
        showError('Please fill out all fields.');
        return;
    }

    try {
        const config = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        }

        const response = await fetch("/backend/controllers/patientController.php?action=createPatient", config);

        const result = await response.json();

        if(!response.ok) {
            showError(result);
        } else {
            alert("Registration successful! You can now log in.");
            window.location.href = "../user/login.html";
        }
    } catch (error) {
        console.error("Error during registration:", error);
        showError("An unexpected error occurred.");
    }
}
// display error on page
const showError = (message) => {
    errorTextContainer.innerHTML = `<p style="color: red;"> ${message} </p>`;    
}