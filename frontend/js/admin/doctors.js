import { getActiveAppointmentCountOfDoctors, getDoctors } from "./admin-functions.js";

window.addEventListener('load', ()=>{

    const listDataInDoctorsPage = async () =>{

        const allDoctors = await getDoctors();
        //TODO: Fix
        const doctorCount = allDoctors.length;
        const appointmentCountOfDoctors = await getActiveAppointmentCountOfDoctors();

        document.getElementById("totalDoctorCount").textContent = doctorCount;
        // first 5 doctors
        const firstFiveDoctors = appointmentCountOfDoctors.slice(0, 5);
        const doctorNameLabels = new Array();
        const doctorAppointmentCounts = new Array();

        firstFiveDoctors.forEach(doctor => {
            // for chart
            doctorNameLabels.push("Dr." + doctor.last_name);
            doctorAppointmentCounts.push(doctor.ap_count);
        });

        const doctorBarCtx = document.getElementById('doctorBarChart');
        if (doctorBarCtx) {
            new Chart(doctorBarCtx, {
            type:'bar',
            data:{labels:doctorNameLabels ,datasets:[{label:'Patients',data:doctorAppointmentCounts ,backgroundColor:'#1d4ed8'}]},
            options:{responsive:true,plugins:{legend:{display:false}}}
            });
        }



    }

    listDataInDoctorsPage();

});