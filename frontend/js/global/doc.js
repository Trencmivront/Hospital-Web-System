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
    doctors.forEach(d => {
        const doctorCard = `<div class="card">
            <h3>${d.first_name} ${d.last_name}</h3>
            <p>${d.name}</p>
        </div>`;
        doctorListContainer.appendChild(createElementFromHTML(doctorCard));    
    });



}