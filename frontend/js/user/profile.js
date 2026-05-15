window.addEventListener('load', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    const appointmentContainer = document.getElementById('appointmentContainer');
    
    //  add log out button function
    document.getElementById("logOutButton").addEventListener("click", async () => {

        try{
            const response = await fetch("/api/patient/logout");

            if(!response.ok){
                console.log();
                return;
            }

            window.location = "/";        
        }catch(error){
            console.log(error);
        }

    });

    document.getElementById("bookAppointmentButton").addEventListener("click", () => {

        document.getElementById("bookAppointmentContainer").style.display = "block";

    });

    const getAppointments = async () => {
        // since we have stored user_id in session, only thing we need to do is to send request
        try{
            const response = await fetch("/api/appointment/ofPatient");

            if(response.status === 403){
                displayAppointmentError(response);
                alert("You are not allowed to be here.");
                // erase existing token data if there is
                try{
                    const response = await fetch("/api/patient/logout");

                    if(!response.ok){
                        console.log();
                        return;
                    }     
                    }catch(error){
                        console.log(error);
                    }
                // redirect person to main page
                window.location = "/"
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

            let actionBtn = '';

            if(a.ap_status === 'COMPLETED'){
                actionBtn = "<button class='view-btn'> </button>";                
            }
            else if(a.ap_status === 'ACTIVE'){
                actionBtn = "<button class='cancel-btn'> </button>"
            }
            else if(a.ap_status === 'CLOSED'){
                
            }

            appointmentContainer.innerHTML += `<tr style="cursor:pointer;" id="${a.appointment_id}" data-doctor_id="${a.doctor_id}" data-schedule_id="${a.schedule_id}">
                                            <td>${a.s_date} | ${a.s_time}</td>
                                            <td>${a.dept_name}</td>
                                            <td>${a.first_name} ${a.last_name}</td>
                                            <td>${a.ap_status}</td>
                                            <td>${actionBtn}</td>
                                        </tr>`;
        });                                      
    }

    const displayAppointmentError = (response) =>{
        document.getElementById('appointmentFetchError').innerHTML = `<p style="color: red;">${response.message}</p>`;
        console.log(response);
    }

    // list appointments of patient
    getAppointments();
});