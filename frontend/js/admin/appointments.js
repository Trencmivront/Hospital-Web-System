import { getTodaysAppointments, getAppointments, getActiveSchedules } from './admin-functions.js';

window.addEventListener('load', () => {

    const listDataInAppointments = async () => {
        const todaysAppointments = await getTodaysAppointments() || [];
        const allAppointments = await getAppointments() || [];
        const allActiveSchedules = await getActiveSchedules() || [];

        // Metric counts
        let bookedToday = todaysAppointments.length;
        let completedToday = 0;
        let cancelledToday = 0;

        todaysAppointments.forEach(app => {
            if (app.ap_status === 'COMPLETED') {
                completedToday++;
            } else if (app.ap_status === 'ABSENT' || app.ap_status === 'CLOSED') {
                cancelledToday++;
            }
        });

        // Update metric cards
        const bookedTodayCountEl = document.getElementById("bookedTodayCount");
        if (bookedTodayCountEl) bookedTodayCountEl.textContent = bookedToday;

        const completedTodayCountEl = document.getElementById("completedTodayCount");
        if (completedTodayCountEl) completedTodayCountEl.textContent = completedToday;

        const cancelledTodayCountEl = document.getElementById("cancelledTodayCount");
        if (cancelledTodayCountEl) cancelledTodayCountEl.textContent = cancelledToday;

        const availableSlotsCountEl = document.getElementById("availableSlotsCount");
        if (availableSlotsCountEl) availableSlotsCountEl.textContent = allActiveSchedules.length;

        // Update Table
        const appointmentsTBody = document.getElementById('appointmentsTBody');
        if (appointmentsTBody) {
            appointmentsTBody.innerHTML = "";
            let counter = 0;
            allAppointments.forEach(data => {
                if(counter === 5){
                    return;
                }
                appointmentsTBody.innerHTML += `
                <tr>
                    <td>${data.appointment_id}</td>
                    <td>${data.s_date}</td>
                    <td>${data.s_time}</td>
                    <td>${data.p_first_name} ${data.p_last_name}</td>
                    <td>${data.d_first_name} ${data.d_last_name}</td>
                    <td>${data.dept_name}</td>
                    <td><span class="status-badge ${(data.ap_status).toLowerCase()}">${data.ap_status}</span></td>
                </tr>`;
                counter++;
            });
        }

        // Doctor Utilization Chart (Appointments per Doctor)
        const doctorUtilization = new Map();
        allAppointments.forEach(app => {
            const docName = `Dr. ${app.d_last_name}`;
            doctorUtilization.set(docName, (doctorUtilization.get(docName) || 0) + 1);
        });

        const sortedDoctors = Array.from(doctorUtilization.entries())
            .sort((a, b) => b[1] - a[1])
            .slice(0, 5);

        const chartLabels = sortedDoctors.map(d => d[0]);
        const chartData = sortedDoctors.map(d => d[1]);

        const appointmentsBarCtx = document.getElementById('appointmentsBarChart');
        if (appointmentsBarCtx) {
            new Chart(appointmentsBarCtx, {
                type: 'bar',
                data: {
                    labels: chartLabels.length > 0 ? chartLabels : ['No Data'],
                    datasets: [{
                        label: 'Total Bookings',
                        data: chartData.length > 0 ? chartData : [0],
                        backgroundColor: '#2563eb'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    }

    listDataInAppointments();
});
