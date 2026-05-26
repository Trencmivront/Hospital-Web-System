
window.addEventListener('load', ()=>{

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
