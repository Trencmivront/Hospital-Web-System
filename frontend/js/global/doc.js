const names =["Ahmet Eyibilen", "Şafak Özdemirci", "Engin Başer",
    "Hakan Kurt","Ayşe Yılmaz", "Mehmet Demir", "Elif Kaya", "Ali Veli", "Zeynep Çelik", "Murat Şahin" ,
    "Fatma Öz", "Emre Yıldız", "Deniz Arslan", "Seda Kılıç", "Caner Aydın", "Gülşah Demir", "Serkan Özz",
    "Ece Yılmaz", "Oğuzhan Kaya", "Büşra Çelik","Ahmet Yıldız", "Ayşe Demir", "Mehmet Arslan", "Elif Kılıç", "Ali Aydın", "Zeynep Özz", "Murat Yılmaz"];

const doctors =[];

for (let i = 0; i < 190; i++) {
    doctors.push({
        name: "Dr. " + names[i % names.length],
        department: ["Genel Cerrahhi","Cardiology", "Neurology" ,"Cardiology", 
            "Neurology", "Orthopedics", "Dermatology", "Pediatrics",
             "Gynecology", "Urology", "Oncology", "Radiology", 
             "Gastroenterology", "ENT (Ear, Nose, Throat)", "Psychiatry",
              "Ophthalmology", "Emergency Medicine", "Anesthesiology", 
              "General Surgery", "Internal Medicine", "Nephrology",
               "Pulmonology", "Endocrinology"][i % 23],
        gender: i % 2 === 0 ? "male" : "female"
    });
}  
const container = document.getElementById("cards-container");
container.innerHTML = "";
let HTML = ""; 

doctors.forEach(doc => {
    const img = doc.gender === "male"
         ? "img/male.jpg.png"
         : "global/imgs/female.jpg";

    HTML += `
        <div class="card">
            <div class="card-image">
                <img src="${img}" alt="${doc.name}">
            </div>
            <div class="card-content">
                <h2>${doc.name}</h2>
                <p>${doc.department}</p>
            </div>
        </div>
    `;
});
container.innerHTML = HTML;