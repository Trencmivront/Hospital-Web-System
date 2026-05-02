const leftDeptContainer = document.getElementById("left-dept-container-div");
const rightDeptContainer = document.getElementById("right-dept-container-div");

window.addEventListener('load', () => {

    document.getElementById("searchButton").addEventListener("click", () => {
        filterDepartmentsByName();
    });
    listDepartments();

});

// adding html elements to main
const createDepartmentContainerHtmls = (dataSet) => {
    // clearing placeholder first
        leftDeptContainer.innerHTML = "";
        rightDeptContainer.innerHTML = "";

        const line = document.getElementById('vertical-line');

        let itemCount = dataSet.length / 2;
        let counter = 0;

        dataSet.forEach(data => {

            if(counter < itemCount){
                line.style.display = 'none';
                leftDeptContainer.innerHTML += "<div class='dept-container-div extend-container'>" +
                "<button class='extendbtn'><h3><span class='extendbtn-arrow'> > </span>" + data.dept_name + "</h3></button>" +
                "<div class='extend-item'><p>" + data.descrpt + "</p></div>" +
                "</div>";
                counter++;
            }
            else{
                line.style.display = 'block';
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
    rightDeptContainer.innerHTML = '';
    leftDeptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        const response = await fetch("/backend/controllers/departmentController.php?action=getDepartments");

        // show error upon error?...
        if(!response.ok){
            const error = await response.json();
            console.log("error");
            leftDeptContainer.innerHTML = `<p style="color:red;">${error}</p>`;
            return;
        }

        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        console.log(error);
    }
}

const filterDepartmentsByName = async () => {

    rightDeptContainer = "";
    leftDeptContainer.innerHTML = '<p class="placeholder">Loading departments…</p>';

    try{
        // TODO: Fetch departments by name
        const response = await fetch(`/backend/controllers/departmentController.php?action=filterDepartmentsByName&name=${document.getElementById("searchField").value}`);
        
        // show error upon error?...
        if(!response.ok){
            const error = await response.json();
            console.log(error);
            leftDeptContainer.innerHTML = `<p style="color:red;">${error}</p>`;
            return;
        }
        
        const dataSet = await response.json();
        createDepartmentContainerHtmls(dataSet);
    }catch(error){
        // I would like to show all departments if filter won't work
        listDepartments();
        alert("Filter Error");
        console.log(error);
    }
}