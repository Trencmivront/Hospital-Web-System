
window.addEventListener('load', ()=>{

  const patientsBarCtx = document.getElementById('patientsBarChart');
  if (patientsBarCtx) {
    new Chart(patientsBarCtx, {
      type: 'bar',
      data: {
        labels: ['Cardiology','Orthopedics','General','ER','Pediatrics'],
        datasets: [{label: 'Admissions', data: [58, 42, 31, 76, 52], backgroundColor: '#2563eb'}]
      },
      options: {responsive: true, plugins: {legend: {display: false}}}
    });
  }

  const appointmentsBarCtx = document.getElementById('appointmentsBarChart');
  if (appointmentsBarCtx) {
    new Chart(appointmentsBarCtx, {
      type:'bar',
      data:{labels:['Dr. Kaya','Dr. Demir','Dr. Smith','Dr. Aydin','Dr. Yilmaz'],datasets:[{label:'Booked',data:[32,26,21,18,14],backgroundColor:'#2563eb'}]},
      options:{responsive:true,plugins:{legend:{display:false}}}
    });
  }

  const doctorBarCtx = document.getElementById('doctorBarChart');
  if (doctorBarCtx) {
    new Chart(doctorBarCtx, {
      type:'bar',
      data:{labels:['Dr. Kaya','Dr. Demir','Dr. Smith','Dr. Aydin','Dr. Yilmaz'],datasets:[{label:'Patients',data:[80,70,65,54,48],backgroundColor:'#1d4ed8'}]},
      options:{responsive:true,plugins:{legend:{display:false}}}
    });
  }

}
);
