import {getPatients, getAppointments} from "./admin-functions.js";

window.addEventListener('load', () => {

    const listDataInPatients = async () => {

        const allPatients = await getPatients();
        const allAppointments = await getAppointments();

        let patientCount = 0;
        let todaysRegisteredPatients = 0;

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '.' + mm + '.' + yyyy;

        const recentPatientsTBody = document.getElementById("recentPatientsTBody");
        recentPatientsTBody.innerHTML = "";
        let patientCounter = 0;
        allPatients.forEach(patient => {
            patientCount++;
            let createdAt = patient.created_at;
            let date = new Date(createdAt);

            // Using tr-TR to match the dd.mm.yyyy format used in 'today' variable
            if(date.toLocaleDateString('tr-TR') === today){
                todaysRegisteredPatients++;
                if(patientCounter !== 4){
                    recentPatientsTBody.innerHTML += `
                    <tr>
                        <td>${patient.patient_id}</td>
                        <td>${patient.first_name} ${patient.last_name}</td>
                        <td>${patient.birth_date}</td>
                        <td>${patient.phone_num}</td>
                        <td>${patient.created_at}</td>
                    </tr>`;
                    patientCounter++;
                }
                
            }
        });
        document.getElementById("totalPatients").textContent = patientCount;
        document.getElementById("newPatientsToday").textContent = todaysRegisteredPatients;

        let activeAppointmentCount = 0;
        let deptNames = new Map();
        allAppointments.forEach(appointment => {
            let dept_name = appointment.dept_name;

            if(!deptNames.has(dept_name)){
                deptNames.set(dept_name, 0);
            }

            if(deptNames.has(dept_name)){
                deptNames.set(dept_name, (deptNames.get(dept_name) || 0) + 1);
            }

            if(appointment.ap_status === 'ACTIVE'){
                activeAppointmentCount++;
            }

        });
        document.getElementById("activeAppointments").textContent = activeAppointmentCount;
    
        const patientsBarCtx = document.getElementById('patientsBarChart');
        if (patientsBarCtx) {
            new Chart(patientsBarCtx, {
            type: 'bar',
            data: {
                labels: Array.from(deptNames.keys()).slice(0,5),
                datasets: [{label: 'Admissions', data: Array.from(deptNames.values()).slice(0,5), backgroundColor: '#2563eb'}]
            },
            options: {responsive: true, plugins: {legend: {display: false}}}
            });
        }
    }

  listDataInPatients();

});