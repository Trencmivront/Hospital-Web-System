const departmentsContainer = document.getElementById("departments-container");

window.addEventListener('load', () => {

    document.getElementById("searchButton").addEventListener("click", (e) => {
        e.preventDefault();
        filterDepartmentsByName();
    });
    listDepartments();

});

// adding html elements to main
const createDepartmentContainerHtmls = (dataSet) => {
    // clearing placeholder first
    departmentsContainer.innerHTML = "";

    dataSet.forEach(data => {
        departmentsContainer.innerHTML += `
            <div class='dept-card extend-container'>
                <button class='extendbtn'>
                    <div class="dept-icon-circle">
                        ${data.dept_name.charAt(0)}
                    </div>
                    <h3><span class='extendbtn-arrow'> > </span>${data.dept_name}</h3>
                </button>
                <div class='extend-item'>
                    <p>${data.descrpt}</p>
                </div>
            </div>`;
    });
    addEventListenerToButtons();
}

// extending description on click 
const addEventListenerToButtons = () => {
    const buttons = document.querySelectorAll(".extendbtn");
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            button.classList.toggle('active');
            // Toggle active class on parent for easier styling
            button.closest('.dept-card').classList.toggle('active');
        })
    })
}

const listDepartments = async () => {
    // placeholder until all departments fetched
    departmentsContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        const response = await fetch("/api/department/all");

        if(!response.ok){
            const error = await response.json();
            console.log("error");
            departmentsContainer.innerHTML = `<p style="color:red;">${error}</p>`;
            return;
        }

        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        console.log(error);
    }
}

const filterDepartmentsByName = async () => {

    departmentsContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        const response = await fetch(`/api/department/byName?name=${document.getElementById("searchField").value}`);
        
        if(!response.ok){
            const error = await response.json();
            console.log(error);
            departmentsContainer.innerHTML = `<p style="color:red;">${error}</p>`;
            return;
        }
        
        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        listDepartments();
        alert("Filter Error");
        console.log(error);
    }
}