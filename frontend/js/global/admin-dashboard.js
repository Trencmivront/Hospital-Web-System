window.addEventListener('load', ()=>{
  // Bar chart (Monthly Sales)
  const barCtx = document.getElementById('barChart');
  if(barCtx){
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets:[{label:'Sales',data:[120,200,150,220,180,240,300,260,200,320,280,200],backgroundColor:'#4f46e5'}]
      },
      options:{responsive:true,plugins:{legend:{display:false}}}
    });
  }

  // Doughnut chart
  const doughCtx = document.getElementById('doughnutChart');
  if(doughCtx){
    new Chart(doughCtx,{
      type:'doughnut',
      data:{labels:['Complete','Remaining'],datasets:[{data:[75,25],backgroundColor:['#4f46e5','#e6e6ff'],hoverOffset:4}]},
      options:{responsive:true,cutout:'70%',plugins:{legend:{position:'bottom'}}}
    });
  }

  // Leaflet map
  if(document.getElementById('map')){
    try{
      const map = L.map('map',{zoomControl:false,attributionControl:false}).setView([39.92077,32.85411],5);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
      L.circle([39.92077,32.85411],{radius:50000,color:'#4f46e5',fillColor:'#c7c6ff',fillOpacity:0.4}).addTo(map);
    }catch(e){console.warn('Leaflet not available',e)}
  }

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

  const patientsLineCtx = document.getElementById('patientsLineChart');
  if (patientsLineCtx) {
    new Chart(patientsLineCtx, {
      type: 'line',
      data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{label:'Admissions',data:[18,22,19,26,23,20,28],borderColor:'#4f46e5',backgroundColor:'rgba(79,70,229,0.15)',fill:true,tension:0.35}]
      },
      options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
    });
  }

  const patientsDoughCtx = document.getElementById('patientsDoughnutChart');
  if (patientsDoughCtx) {
    new Chart(patientsDoughCtx, {
      type:'doughnut',
      data:{labels:['In Treatment','Recovered','Observation'],datasets:[{data:[48,30,22],backgroundColor:['#2563eb','#4f46e5','#93c5fd']}]},
      options:{responsive:true,cutout:'70%',plugins:{legend:{position:'bottom'}}}
    });
  }

  const appointmentsLineCtx = document.getElementById('appointmentsLineChart');
  if (appointmentsLineCtx) {
    new Chart(appointmentsLineCtx, {
      type:'line',
      data: {
        labels: ['Week 1','Week 2','Week 3','Week 4'],
        datasets: [{label:'Appointments',data:[112,134,128,146],borderColor:'#1d4ed8',backgroundColor:'rgba(29,78,216,0.16)',fill:true,tension:0.4}]
      },
      options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
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

  const doctorLineCtx = document.getElementById('doctorLineChart');
  if (doctorLineCtx) {
    new Chart(doctorLineCtx, {
      type:'line',
      data:{labels:['Mon','Tue','Wed','Thu','Fri'],datasets:[{label:'Successful Ops',data:[5,7,6,8,6],borderColor:'#4f46e5',backgroundColor:'rgba(79,70,229,0.15)',fill:true,tension:0.35}]},
      options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
    });
  }
});


 