window.addEventListener('load', ()=>{
  
  const getAppointments = async () => {

    try{

      const response = await fetch("/api/appointment/getToday");

      if(response.status === 403){
        alert("please go away");
        window.location = "/";
        return;
      }

      else if (!response.ok){
        showError(response);
        return;
      }

      const dataSet = await response.json();

      document.getElementById("todaysAppointmentCount").textContent = dataSet.length;

    }catch(error){

    }

  }
  
  
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

  const showError = async (response) => {
    console.log(response);
    const message = await response.json();
  }

  getAppointments();

}
);
