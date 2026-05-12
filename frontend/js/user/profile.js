window.addEventListener('load', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    const appointmentContainer = document.getElementById('appointmentContainer');
    //  add log out button function
    document.getElementById("logOutButton").addEventListener("click", async () => {

        try{
            const response = await fetch("/backend/controllers/patientController.php?action=logOut");

            if(!response.ok){
                console.log();
                return;
            }

            window.location = "/index.html";        
        }catch(error){
            console.log(error);
        }

    });

    const getAppointments = async () => {
        // since we have stored user_id in session, only thing we need to do is to send request
        try{
            const response = await fetch("/backend/controllers/appointmentController.php?action=getAppointmentsOfPatient");

            if(response.status === 403){
                displayAppointmentError(response);
                alert("You are not allowed to be here.");
                // redirect person to main page
                window.location = "/index.html"
                return;
            }
            else if(!response.ok){
                displayAppointmentError(response);
                return;
            }

            const data = await response.json();

            listAppointments(data);
        }catch(error){
            console.log(error);
        }

    }

    const listAppointments = (data) => {
        data.forEach(a => {
            isActive = a.is_active == 1 ? "Active" : "Inactive"

            appointmentContainer.innerHTML += `<tr>
                                            <td>${a.s_date} | ${a.s_time}</td>
                                            <td>${a.dept_name}</td>
                                            <td>${a.first_name} ${a.last_name}</td>
                                            <td>${isActive}</td>
                                        </tr>`
        });                                      
    }

    const displayAppointmentError = (response) =>{
        document.getElementById('appointmentFetchError').innerHTML = `<p style="color: red;">${response.message}</p>`;
        console.log(response);
    }

    // list appointments of patient
    getAppointments();
});