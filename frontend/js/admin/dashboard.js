import { showError, userIsNotAuthenticated, getTodaysAppointments,
  getAppointments, getPatients, getDoctors, getMonthlyRevenue} from './admin-functions.js';

window.addEventListener('load', () => {

    // Leaflet map
    // for fun
    if(document.getElementById('map')){
        try{
        const map = L.map('map',{zoomControl:false,attributionControl:false}).setView([39.92077,32.85411],5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
        L.circle([39.92077,32.85411],{radius:50000,color:'#4f46e5',fillColor:'#c7c6ff',fillOpacity:0.4}).addTo(map);
        }catch(e){console.warn('Leaflet not available',e)}
    }

    const listDataInDashboardPage = async () => {
        // getting values from database
        const allAppointments = await getAppointments() || [];
        const todaysAppointments = await getTodaysAppointments() || [];
        const allPatients = await getPatients() || [];
        const allDoctors = await getDoctors() || [];
        const monthlyRevenue = await getMonthlyRevenue() || [];

        // todays appointments count
        const todaysAppointmentCountEl = document.getElementById("todaysAppointmentCount");
        if (todaysAppointmentCountEl) {
        todaysAppointmentCountEl.textContent = todaysAppointments.length;
        }

        // recent appointments list
        const recentAppointmentsTBody = document.getElementById('recentAppointmentsTBody');
        if (recentAppointmentsTBody) {
        recentAppointmentsTBody.innerHTML = "";
        let counter = 0;
        allAppointments.forEach(data => {
            if(counter === 3){
            return;
            }
            recentAppointmentsTBody.innerHTML += `<tr><td>${data.s_time}</td><td>${data.p_first_name} ${data.p_last_name}</td>
            <td>${data.d_first_name} ${data.d_last_name}</td><td>${data.dept_name}</td><td>${data.ap_status}</td></tr>`;
            counter++;
        });
        }

        // total patient count
        const totalPatientCountEl = document.getElementById("totalPatientCount");
        if (totalPatientCountEl) {
        totalPatientCountEl.textContent = allPatients.length;
        }

        // on duty doctors count
        const onDutyDoctorsEl = document.getElementById("onDutyDoctors");
        if (onDutyDoctorsEl) {
        onDutyDoctorsEl.textContent = allDoctors.length;
        }

        // monthly revenue
        const monthlyData = Array(12).fill(0);
        let totalRevenue = 0;
        monthlyRevenue.forEach(item => {
        const revenue = parseFloat(item.monthly_revenue) || 0;
        totalRevenue += revenue;
        monthlyData[parseInt(item.month) - 1] = revenue;
        });
        // avarage monthly revenue
        const averageRevenue = monthlyRevenue.length > 0 ? (totalRevenue / monthlyRevenue.length).toFixed(2) : "0.00";
        const averageRevenueEl = document.getElementById('avarageMonthlyRevenue');
        if (averageRevenueEl) {
        averageRevenueEl.textContent = averageRevenue + " $";
        }
        // listing values in chart
        const barCtx = document.getElementById('barChart');
        if (barCtx) {
        new Chart(barCtx, {
                type: 'bar',
                data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets:[{label:'Sales',data:monthlyData,backgroundColor:'#4f46e5'}]
                },
                options:{responsive:true,plugins:{legend:{display:false}}}
        });
        }
    }

    listDataInDashboardPage();
  
});