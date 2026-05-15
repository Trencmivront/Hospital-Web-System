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
});
