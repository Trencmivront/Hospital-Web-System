window.addEventListener('load', () => {

    const usernameField = document.getElementById('username');     
    const passwordField = document.getElementById("password");
    const errorTextContainer = document.getElementById("errorMessage");

    document.getElementById('adminLoginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        // cut empty spaces
        const username = usernameField.value.trim();
        const password = passwordField.value.trim();

        if(!username || !password) {
            showError("Please fill in all fields.");
            return;
        }

        const body = {
            username: username,
            password: password
        };

        const config = {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
            body: JSON.stringify(body)
        };

        try {
            const response = await fetch("/api/admin/login", config);

            if (!response.ok) {
                const message = await response.json();
                showError(message);
                return;
            }
            
            // Redirect to dashboard on success
            window.location.href = '/frontend/html/admin/dashboard.html';

        } catch (error) {
            console.error(error);
            showError("An unexpected error occurred. Please try again.");
        }
    });

    const showError = (message) => {
        errorTextContainer.innerHTML = `<p style="color: red; font-size: 14px; margin-top: 10px; text-align: center;">${message}</p>`;
    };
});
