const deptContainer = document.getElementById("dept_container");

window.addEventListener('load', () => {
    listDepartments();
});

document.getElementById("searchButton").addEventListener("click", () => {
    filterDepartmentsByName();
});

const listDepartments = async () => {
    // placeholder until all departments fetched
    deptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        const config = {
            method: "GET"
        }

        const response = await fetch("/backend/get/getDepartments.php", config);

        const dataSet = await response.json();

        deptContainer.innerHTML = "";

        dataSet.forEach(data => {

            let divId = 1;

            deptContainer.innerHTML += "<div class='dept-container-div flex-wrap-space'>" +
            "<h3>" + data.dept_name + "</h3>" +
            "<p>" + data.descrpt + "</p>" +
            "</div>";
        });
    }catch(error){
        console.log(error);
    }
}

const filterDepartmentsByName = async () => {
    deptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        // TODO: Fetch departments by name
        const response = await fetch(`/backend/get/filterDepartmentsByName.php?name=${document.getElementById("searchField").value}`);

        const dataSet = await response.json();
        deptContainer.innerHTML = "";

        dataSet.forEach(data => {
            deptContainer.innerHTML += "<div>" +
            "<h3>" + data.dept_name + "</h3>" +
            "<p>" + data.descrpt + "</p>" +
            "</div>";
        }); 
    }catch(error){
        // I would like to show all departments if filter won't work
        listDepartments();
        alert("Filter Error");
        console.log(error);
    }
}