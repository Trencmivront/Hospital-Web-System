const errorTextContainer = document.getElementById("errorMessage");
const registrationSection = document.getElementById("registration-section");
const verificationSection = document.getElementById("verification-section");
const resendCodeLink = document.getElementById("resendCode");
const timerDisplay = document.getElementById("timerDisplay");

let timerInterval;

window.addEventListener("load", () => {
    setMaxDateValue();
    loadBloodTypes();
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

document.getElementById("verification-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const code = document.getElementById("verificationCode").value;

    if(!code){
        showError("Please write the code");
        return;
    }

    const config = {
        method: "POST",
        headers: {'Content-Type' : 'application/json; charset=utf-8'},
        body: JSON.stringify({code: code})
    }

    try{
        const response = await fetch("/api/patient/verifyCode", config);

        if(!response.ok){
            const message = await response.json();
            showError(message);
            return;
        }
        
        // generate jwt of patient in the backend
        const createJwt = await fetch("/api/patient/jwt");
        
        if(!createJwt.ok){
            const message = await createJwt.json();
            showError(message);
            return;
        }

        alert("Registration and verification successful!");
        window.location = "/profile";
    }catch(error){
        console.log(error);
        showError("An unexpected error occurred.");
    }
});

resendCodeLink.addEventListener('click', async (e) => {
    e.preventDefault();
    errorTextContainer.textContent = ""; // clear errors
    try{
        const response = await fetch("/api/patient/resendCode");
        
        if(!response.ok){
            const message = await response.json();
            showError(message);
            return;
        }

        startTimer(180); // 2 minute timer
    }catch(error){
        console.log(error);
        showError("An unexpected error occurred.");
    }
});

const startTimer = (durationInSeconds) => {
    clearInterval(timerInterval);
    let timeLeft = durationInSeconds;

    resendCodeLink.style.pointerEvents = "none";
    resendCodeLink.style.color = "#ccc";
    timerDisplay.style.display = "inline";

    const updateDisplay = () => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `(${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')})`;
    };

    updateDisplay();

    timerInterval = setInterval(() => {
        timeLeft--;
        updateDisplay();

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            resendCodeLink.style.pointerEvents = "auto";
            resendCodeLink.style.color = ""; // Restore default color
            timerDisplay.style.display = "none";
        }
    }, 1000);
};

const loadBloodTypes = async () => {
    try{
        const response = await fetch("/api/blood/types");

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

const verifyAndSendFormContents = async () => {
    // creating array of inputs
    const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        tc_no: document.getElementById('tc_no').value,
        birth_date: document.getElementById('birth_date').value,
        gender_name: document.getElementById('gender').value,
        blood_id: document.getElementById('blood_group').value,
        phone_num: document.getElementById('phone_num').value,
        email: document.getElementById('email').value,
        password: document.getElementById('pat_password').value
    };

    // Check if any value is empty or null
    const hasEmptyField = Object.values(formData).some(value => value === "" || value === null);
    
    if(hasEmptyField){
        showError('Please fill out all fields.');
        return;
    }

    try {
        const config = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify(formData)
        }

        const response = await fetch("/api/patient/create", config);

        const result = await response.json();

        if(!response.ok) {
            showError(result);
        } else {
            // Success: show verification section
            registrationSection.style.display = "none";
            verificationSection.style.display = "block";
            startTimer(120);
        }
    } catch (error) {
        console.error("Error during registration:", error);
        showError("An unexpected error occurred.");
    }
}

const setMaxDateValue = () => {
    const dateField = document.getElementById("birth_date");
    const today = new Date().toLocaleDateString("en-CA");
    // setting max and current value as same
    dateField.setAttribute("value", today);
    dateField.setAttribute("max", today);
}

// display error on page
const showError = (message) => {
    errorTextContainer.innerHTML = `<p style="color: red;"> ${message} </p>`;    
}