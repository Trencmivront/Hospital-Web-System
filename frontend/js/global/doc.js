window .addEventListener("load", () => {
    loadDoctors();
}   );

const loadDoctors = async () => {
    try{
        const response = await fetch("/api/doctor/all");

        if(!response.ok){
            console.log(response);
            return;
        } 
        const doctors = await response.json();      
        listDoctors(doctors);
    }catch(error){
        console.log(error);
    } ;
}

const listDoctors = (doctors) => {
    const doctorListContainer = document.getElementById("doctorListContainer");
    if (!doctorListContainer) return;

        if (!document.getElementById("dynamic-doctor-styles")) {
        const styleBlock = document.createElement("style");
        styleBlock.id = "dynamic-doctor-styles";
        styleBlock.textContent = `
            .doctor-card {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                margin-bottom: 15px;
            }
            .doctor-name {
                margin: 0 0 8px 0;
                font-size: 18px;
                color: #1e293b;
                font-family: sans-serif;
            }
            .doctor-specialty {
                margin: 0;
                font-size: 14px;
                color: #3b82f6;
                font-weight: 600;
                font-family: sans-serif;
            }
        `;
        document.head.appendChild(styleBlock);
    }
    doctorListContainer.innerHTML = '';    
    
    doctors.forEach(d => {
        const doctorCard = `
            <div class="doctor-card">
                <h3 class="doctor-name">Dr. ${d.first_name} ${d.last_name}</h3>
                <p class="doctor-specialty">${d.spec_name}</p>
            </div>
        `;
        doctorListContainer.innerHTML += doctorCard;    
    });
};