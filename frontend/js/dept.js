const leftDeptContainer = document.getElementById("left-dept-container-div");
const rightDeptContainer = document.getElementById("right-dept-container-div");

window.addEventListener('load', () => {
    listDepartments();
});

document.getElementById("searchButton").addEventListener("click", () => {
    filterDepartmentsByName();
});

// adding html elements to main
const createDepartmentContainerHtmls = (dataSet) => {
    // clearing placeholder first
        leftDeptContainer.innerHTML = "";

        let itemCount = dataSet.length / 2;
        let counter = 0;

        dataSet.forEach(data => {

            if(counter < itemCount){
                leftDeptContainer.innerHTML += "<div class='dept-container-div extend-container'>" +
                "<button class='extendbtn'><h3><span class='extendbtn-arrow'> > </span>" + data.dept_name + "</h3></button>" +
                "<div class='extend-item'><p>" + data.descrpt + "</p></div>" +
                "</div>";
                counter++;
            }
            else{
                rightDeptContainer.innerHTML += "<div class='dept-container-div extend-container'>" +
                "<button class='extendbtn'><h3><span class='extendbtn-arrow'> > </span>" + data.dept_name + "</h3></button>" +
                "<div class='extend-item'><p>" + data.descrpt + "</p></div>" +
                "</div>";
            }
    });
    addEventListenerToButtons();
}

// extending description on click 
const addEventListenerToButtons = () => {
    const buttons = document.querySelectorAll(".extendbtn");
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            let a = button.classList.toggle('active');
        })
    })
}

const listDepartments = async () => {
    // placeholder until all departments fetched
    leftDeptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        const response = await fetch("/backend/get/getDepartments.php");
        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        console.log(error);
    }
}

const filterDepartmentsByName = async () => {
    leftDeptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        // TODO: Fetch departments by name
        const response = await fetch(`/backend/get/filterDepartmentsByName.php?name=${document.getElementById("searchField").value}`);
        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        // I would like to show all departments if filter won't work
        listDepartments();
        alert("Filter Error");
        console.log(error);
    }
}