window.addEventListener('load', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    const appointmentContainer = document.getElementById('appointmentContainer');
    // book appointment input elements
    const selectDepartment = document.getElementById("selectDepartment");
    const selectDoctor = document.getElementById("selectDoctor");
    const inputDate = document.getElementById("inputDate");
    const inputTime = document.getElementById("inputTime");
    
    //  add log out button function
    document.getElementById("logOutButton").addEventListener("click", async () => {

        try{
            const response = await fetch("/api/patient/logout");

            if(!response.ok){
                console.log(response);
                return;
            }

            window.location = "/";        
        }catch(error){
            console.log(error);
        }

    });

    document.getElementById("bookAppointmentButton").addEventListener("click", () => {
        document.getElementById("shadowBackground").style.display = "flex";
    });

    document.getElementById("shadowBackground").addEventListener("click", (event) => {

        if (event.target === event.currentTarget) {
            document.getElementById("shadowBackground").style.display = "none";
        }

    });

    const fetchDepartments = async () => {
        try {
            const response = await fetch("/api/department/all");
            if (!response.ok) {
                console.error(response);
                return;
            }
            const departments = await response.json();
                departments.forEach(dept => {
                selectDepartment.innerHTML += `<option value="${dept.dept_id}">${dept.dept_name}</option>`;
            });
        } catch (error) {
            console.error(error);
        }
    };

    const fetchDoctors = async (dept_id) => {

        try{
            const response = await fetch(`/api/doctor/byDepartment?dept_id=${dept_id}`);

            if(!response.ok){
                console.error("Failed to fetch doctors");
                return;
            }

            const doctors = await response.json();

            if (doctors.length === 0) {
                selectDoctor.innerHTML = '<option value="">No doctors available</option>';
                selectDoctor.setAttribute("disabled", true);
                // Reset subsequent fields
                inputDate.setAttribute("disabled", true);
                inputTime.setAttribute("disabled", true);
                inputDate.value = "";
                inputTime.value = "";
            } else {
                selectDoctor.innerHTML = '<option value="">--Select Doctor--</option>';
                doctors.forEach(doc => {
                    selectDoctor.innerHTML += `<option value="${doc.doctor_id}">${doc.first_name} ${doc.last_name}</option>`;
                });
                selectDoctor.removeAttribute("disabled");
            }

        }catch(error){
            console.log(error);
            return;
        }
    }

    fetchAvailableDatesOfDoctor = async (doctor_id) => {
        
        try{

            const response = await fetch("/api/");

        }catch(error){
            console.log(error);
        }

    }

    selectDepartment.addEventListener("change", async () => {
        // after selecting department, we want to list, if value is not "pluh"
        if(selectDepartment.value === ""){
            selectDoctor.setAttribute("disabled", true);
            inputDate.setAttribute("disabled",true);
            inputTime.setAttribute("disabled", true);
            return;
        }
        // get id of the department, since id is value of option;
        fetchDoctors(selectDepartment.value);

    });

    selectDoctor.addEventListener("change", async () => {

        if(selectDoctor.value === ""){
        inputDate.setAttribute("disabled",true);
        inputTime.setAttribute("disabled", true);
        return;
        }
        // allow user to select date
        inputDate.removeAttribute("disabled");
        fetchAvailableDatesOfDoctor(selectDoctor.values);
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
                actionBtn = "<button class='view-btn'> View </button>";                
            }
            else if(a.ap_status === 'ACTIVE'){
                actionBtn = "<button class='cancel-btn'> Cancel </button>"
            }
            // cancelled by the user
            else if(a.ap_status === 'CLOSED'){
                actionBtn = "<button class='disabled-btn'> Closed </button>"
            }

            appointmentContainer.innerHTML += `<tr id="${a.appointment_id}" data-doctor_id="${a.doctor_id}" data-schedule_id="${a.schedule_id}">
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
    // fetch departments
    fetchDepartments();
});