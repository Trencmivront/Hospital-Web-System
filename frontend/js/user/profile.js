window.addEventListener('load', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');
    const appointmentContainer = document.getElementById('appointmentContainer');
    const floatingFormContainer = document.getElementById('floatingFormContainer');
    // book appointment input elements
    const bookAppointmentContainer = document.getElementById("bookAppointmentContainer");
    const selectDepartment = document.getElementById("selectDepartment");
    const selectDoctor = document.getElementById("selectDoctor");
    const selectDate = document.getElementById("selectDate");
    const selectTime = document.getElementById("selectTime");

    // update patient input elements
    const updatePatientContainer = document.getElementById("updatePatientContainer");
    const updatePatientForm = document.getElementById("updatePatientForm");
    const updateFirstName = document.getElementById("updateFirstName");
    const updateLastName = document.getElementById("updateLastName");
    const updateGender = document.getElementById("updateGender");
    const updateEmail = document.getElementById("updateEmail");
    const updatePhone = document.getElementById("updatePhone");
    const updateBloodType = document.getElementById("updateBloodType");
    const updateBirthDate = document.getElementById("updateBirthDate");
    const updatePassword = document.getElementById("updatePassword");
    
    let currentPatient = null;
    
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
        floatingFormContainer.style.display = "flex";
        bookAppointmentContainer.style.display = "block";
        updatePatientContainer.style.display = "none";
    });

    document.getElementById("closeAppointmentBooking").addEventListener("click", () => {
        if(confirm("Cancel Booking?")){
            floatingFormContainer.style.display = "none";
            bookAppointmentContainer.style.display = "none";
        }else{
            return;
        }
    });

    document.getElementById("editProfileButton").addEventListener("click", () => {
        floatingFormContainer.style.display = "flex";
        updatePatientContainer.style.display = "block";
        bookAppointmentContainer.style.display = "none";
        
        if (currentPatient) {
            updateFirstName.value = currentPatient.first_name;
            updateLastName.value = currentPatient.last_name;
            updateGender.value = currentPatient.gender_name;
            updateEmail.value = currentPatient.email;
            updatePhone.value = currentPatient.phone_num;
            updateBloodType.value = currentPatient.blood_id;
            updateBirthDate.value = currentPatient.birth_date;
        }
    });

    document.getElementById("closeUpdatePatient").addEventListener("click", () => {
        floatingFormContainer.style.display = "none";
        updatePatientContainer.style.display = "none";
    });

    appointmentContainer.addEventListener('click', async (e) => {
        if (e.target.classList.contains('cancel-btn')) {
            const row = e.target.closest('tr');
            const appointment_id = row.id;

            if (confirm("Are you sure you want to cancel this appointment?")) {
                try {
                    const response = await fetch("/api/appointment/delete", {
                        method: 'POST', // Using POST as the controller expects it for reading php://input in some cases, though DELETE could also work if configured.
                        headers: {
                            "Content-Type": "application/json; charset=utf-8"
                        },
                        body: JSON.stringify({ appointment_id: appointment_id })
                    });

                    if (response.status === 403) {
                        userIsNotAuthenticated();
                        return;
                    }

                    if (!response.ok) {
                        alert("Could not cancel appointment");
                        return;
                    }

                    alert("Appointment cancelled successfully");
                    getAppointments(); // Refresh the list
                } catch (error) {
                    alert("Network Error");
                    console.log(error);
                }
            }
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

    const fetchBloodTypes = async () => {
        try {
            const response = await fetch("/api/blood/types");
            if (!response.ok) {
                console.error(response);
                return;
            }
            const bloodTypes = await response.json();
            
            bloodTypes.forEach(blood => {
                updateBloodType.innerHTML += `<option value="${blood.blood_id}">${blood.type_name}</option>`;
            });
        } catch (error) {
            console.error(error);
        }
    };

    const fetchDoctors = async (dept_id) => {

        try{
            const response = await fetch(`/api/doctor/byDepartment?dept_id=${dept_id}`);

            if(!response.ok){
                console.error(response);
                return;
            }

            const doctors = await response.json();

            if (doctors.length === 0) {
                selectDoctor.innerHTML = '<option value="">No doctors available</option>';
                selectDoctor.setAttribute("disabled", true);
                // Reset subsequent fields
                selectDate.setAttribute("disabled", true);
                selectTime.setAttribute("disabled", true);
                selectDate.value = "";
                selectTime.value = "";
            } else {
                selectDoctor.innerHTML = '<option value="">-- Doctor --</option>';
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

    const fetchAvailableDatesOfDoctor = async (doctor_id) => {
        try {
            const response = await fetch(`/api/doctor/availableDays?doctor_id=${doctor_id}`);
            if (!response.ok) {
                console.error(response);
                return;
            }

            const dates = await response.json();
            
            if(dates.length === 0){
                selectDate.innerHTML = "<option value=''> No Available Dates </option>";
                
                selectDate.setAttribute("disabled", true);
                selectTime.setAttribute("disabled", true);
                selectDate.value = "";
                selectTime.value = "";
            }
            else{
                selectDate.innerHTML = '<option value="">-- Date --</option>';
                dates.forEach(date => {
                selectDate.innerHTML += `<option value='${date.s_date}'>${date.s_date}</option>`;
                });
                selectDate.removeAttribute("disabled");
            }

        } catch (error) {
            console.error(error);
        }
    }

    const fetchAvailableTimesOfDay = async (date) => {
        try {
            const doctor_id = selectDoctor.value;
            const response = await fetch(`/api/schedule/byDate?doctor_id=${doctor_id}&date=${date}`);
            
            if (!response.ok) {
                console.error(response);
                return;
            }

            const times = await response.json();
            
            if (times.length === 0) {
                selectTime.innerHTML = "<option value=''> No Available Times </option>";
                selectTime.setAttribute("disabled", true);
                selectTime.value = "";
            } else {
                selectTime.innerHTML = '<option value="">-- Time --</option>';
                times.forEach(time => {
                    // now we will get doctor_schedule_id and patient_id to create appointment
                    selectTime.innerHTML += `<option value='${time.doctor_schedule_id}'>${time.s_time}</option>`;
                });
                selectTime.removeAttribute("disabled");
            }
        } catch (error) {
            console.error(error);
        }
    }

    document.getElementById("appointmentForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        // if any of the values are null, then exit
        if(!selectDepartment.value || !selectDoctor.value || !selectDate.value || !selectTime.value){
            alert("Please Fill The Form");
            return;
        }

        try{
            // we already having dept_id in doctor entity
            // these are enough for creation of appointment
            // patient_id is stored in session
            const body = {
                doctor_schedule_id: selectTime.value
            }

            const config = {
                method: 'POST',
                headers: {
                    "Content-Type" : "application/json; charset=utf-8"
                },
                body: JSON.stringify(body)
            }

            const response = await fetch("/api/appointment/create", config);
            
            if(response.status === 403){
                displayError(response, "bookAppointmentErrorContainer");
                userIsNotAuthenticated();
                return;
            }

            else if(response.status !== 201){
                displayError(response, "bookAppointmentErrorContainer");
                return;
            }

            if(confirm('Book appointment?')){
                alert("Appointment Booked");
                // close form
                floatingFormContainer.style.display = "none";
                bookAppointmentContainer.style.display = "none";
            }
            else{
                // exit before listing appointments again
                return;
            }

            getAppointments();

        }catch(error){
            alert("Network Error");
            console.log(error);
        }

    })

    updatePatientForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        if(!confirm("Are you sure?")){
            return;
        }
        
        const body = {
            first_name: updateFirstName.value,
            last_name: updateLastName.value,
            gender_name: updateGender.value,
            email: updateEmail.value,
            phone_num: updatePhone.value,
            blood_id: updateBloodType.value,
            birth_date: updateBirthDate.value,
            pat_password: updatePassword.value || null
        };

        try {
            const response = await fetch("/api/patient/update", {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json; charset=utf-8"
                },
                body: JSON.stringify(body)
            });

            if (response.status === 403) {
                userIsNotAuthenticated();
                return;
            }

            if (!response.ok) {
                displayError(response, "updatePatientErrorContainer");
                return;
            }

            alert("Information Updated Successfully");
            floatingFormContainer.style.display = "none";
            updatePatientContainer.style.display = "none";
            fetchPatientData(); // Refresh displayed data
        } catch (error) {
            alert("Network Error");
            console.log(error);
        }
    });

    selectDepartment.addEventListener("change", async () => {
        // after selecting department, we want to reset all
        selectDoctor.setAttribute("disabled", true);
        selectDate.setAttribute("disabled",true);
        selectTime.setAttribute("disabled", true);
        selectDoctor.value = "";
        selectDate.value = "";
        selectTime.value = "";

        // get id of the department, since id is value of option;
        fetchDoctors(selectDepartment.value);

    });

    selectDoctor.addEventListener("change", async () => {
        selectDate.setAttribute("disabled",true);
        selectTime.setAttribute("disabled", true);
        selectDate.value = "";
        selectTime.value = "";

        fetchAvailableDatesOfDoctor(selectDoctor.value);
    });

    selectDate.addEventListener("change", () => {
        selectTime.setAttribute("disabled", true);
        selectTime.value = "";

        fetchAvailableTimesOfDay(selectDate.value);
    });

    const getAppointments = async () => {
        // since we have stored user_id in session, only thing we need to do is to send request
        try{
            const response = await fetch("/api/appointment/ofPatient");

            if(response.status === 403){
                displayError(response, "appointmentFetchError");
                userIsNotAuthenticated();
                return;
            }
            else if(!response.ok){
                displayError(response, "appointmentFetchError");
                return;
            }

            const data = await response.json();
            listAppointments(data);
        }catch(error){
            console.log(error);
        }
    }

    const fetchPatientData = async () => {
        try {
            const response = await fetch("/api/patient/byId");
            if (response.status === 403) {
                userIsNotAuthenticated();
                return;
            }
            if (!response.ok) {
                console.error(response);
                return;
            }
            const patient = await response.json();
            currentPatient = patient; // Store current patient data
            displayPatientData(patient);
        } catch (error) {
            console.error(error);
        }
    };

    const displayPatientData = (patient) => {
        document.getElementById("full_name").textContent = `${patient.first_name} ${patient.last_name}`;
        document.getElementById("tc_no").textContent = patient.tc_no;
        document.getElementById("gender").textContent = patient.gender_name === 'M' ? 'Male' : (patient.gender_name === 'F' ? 'Female' : 'Unknown');
        document.getElementById("email").textContent = patient.email;
        document.getElementById("tel_no").textContent = patient.phone_num;
        document.getElementById("blood_group").textContent = patient.blood_type;
        document.getElementById("birth_date").textContent = patient.birth_date;
        document.getElementById("password").textContent = "********";
        
        const welcomeSpan = document.querySelector(".top-bar-user-name strong");
        if (welcomeSpan) {
            welcomeSpan.textContent = `${patient.first_name} ${patient.last_name}`;
        }
    };

    const listAppointments = (data) => {
        appointmentContainer.innerHTML = "";
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

    const displayError = async (response, containerId) =>{
        console.log(response);
        message = await response.json();
        const container = document.getElementById(containerId);
        if (container) {
            container.innerHTML = `<p style="color: red;text-align:center;">${message}</p>`;
        }
        
    }

    const userIsNotAuthenticated = async () => {
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
        window.location = "/";
    }

    // setting max date for date picker
    const date = new Date();
    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let year = date.getFullYear();

    let currentDate = `${year}-${month}-${day}`;

    updateBirthDate.setAttribute('max', currentDate);

    // fetch patient profile
    fetchPatientData();
    // list appointments of patient
    getAppointments();
    // fetch departments
    fetchDepartments();
    // fetch blood types
    fetchBloodTypes();
});