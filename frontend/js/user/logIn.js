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

    document.getElementById("login-form").addEventListener('submit', async (e) => {
        e.preventDefault();

        const body = {
            email: emailField.value,
            password: passwordField.value,
            remember_me: rememberMeButton.value
        }

        const config = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(body)
        }

        try {
            const response = await fetch("/api/patient/login", config);

            if (!response.ok) {
                showError(response);
                return;
            }
            
            // show verification code input
            loginSection.style.display = "none";
            verificationSection.style.display = "block";
            startTimer(120); // 2 minute timer, then enable resend code button
            // clear previous errors if there are any
            errorTextContainer.innerHTML = "";

        } catch (error) {
            console.error(error);
        }
    });

    document.getElementById("verification-form").addEventListener("submit", async (e) => {
        e.preventDefault();

        const code = document.getElementById("verificationCode").value;

        if(!code){
            errorTextContainer.innerHTML = "<p style='color: red;'> Please write the code </p>";
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
                showError(response);
                return;
            }
            
            // generate jwt of patient in the backend
            const createJwt = await fetch("/api/patient/jwt");
            
            if(!createJwt.ok){
                showError(createJwt);
                return;
            }

            window.location = "/profile";
        }catch(error){
            console.log(error);
        }
    })

    resendCodeLink.addEventListener('click', async (e) => {
        e.preventDefault();
        //TODO: generate resend email logic, after some tf2 games
        showError(""); // clear errors
        try{
            const response = await fetch("/api/patient/resendCode");
            
            if(!response.ok){
                showError(response);
                return;
            }

            startTimer(120); // 2 minute timer, then enable resend code button
            // clear previous errors if there are any
            showError("");
        }catch(error){
            console.log(error);
        }

        startTimer(120);
    });

    // display error on page
    const showError = async (response) => {
        console.log(response);
        const message = await response.json();
        errorTextContainer.innerHTML = `<p style="color: red;"> ${message} </p>`;    
    }

})