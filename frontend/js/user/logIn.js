window.addEventListener('load', () => {

    // Initializing fields
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");
    const rememberMeButton = document.getElementById("rememberMe");
    const errorTextContainer = document.getElementById("errorMessage");

    const loginSection = document.getElementById("login-section");
    const verificationSection = document.getElementById("verification-section");
    const resendCodeLink = document.getElementById("resendCode");
    const timerDisplay = document.getElementById("timerDisplay");

    let timerInterval;

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
                resendCodeLink.style.color = "#1d3fa6";
                timerDisplay.style.display = "none";
            }
        }, 1000);
    };

    document.getElementById("submitButton").addEventListener('click', async (e) => {
        e.preventDefault();

        const body = {
            email: emailField.value,
            password: passwordField.value,
        }

        const config = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(body)
        }

        try {
            const response = await fetch("/backend/controllers/patientController.php?action=logIn", config);

            if (!response.ok) {
                const data = await response.json();
                showError(data);
                return;
            }
            
            loginSection.style.display = "none";
            verificationSection.style.display = "block";
            startTimer(120); // 2 minute timer, then enable resend code button

        } catch (error) {
            console.error(error);
            showError("An unexpected error occurred.");
        }
    });

    document.getElementById("verifyButton").addEventListener("click", async () => {
        e.preventDefault();

        const code = document.getElementById("verificationCode").value;

        if(!code){
            showError("Please write code!");
        }

        const config = {
            method: "POST",
            verification_code: code,
        }

        try{

            const response = await fetch("/backend/controllers/patientController.php?action=verifyCode", config);

            if(!response.ok){
                const data = await response.json();
                showError(data);
                return;
            }
        
            // generate jwt of patient in the backend
            const createJwt = await fetch("/backend/controllers/patientController.php?action=createPatientJwt");

            if(!createJwt.ok){
                const data = await createJwt.json();
                showError(data);
                return;
            }

        }catch(error){
            console.log(error);
        }

        window.location = "/frontend/html/user/profile.html";

    })

    resendCodeLink.addEventListener('click', (e) => {
        e.preventDefault();
        //TODO: generate resend email logic, after some tf2 games
        // also don't forget to erase previous code when button clicked
        startTimer(120);
    });

    // display error on page
    const showError = (message) => {
        errorTextContainer.innerHTML = `<p style="color: red;"> ${message} </p>`;    
    }

})