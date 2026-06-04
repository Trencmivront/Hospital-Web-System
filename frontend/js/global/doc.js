window.addEventListener("load", () => {
    loadDoctors();
    initSearch();
});

const loadDoctors = async () => {
    try {
        const response = await fetch("/api/doctor/all");

        if (!response.ok) {
            console.log(response);
            return;
        }
        const doctors = await response.json();
        listDoctors(doctors);
    } catch (error) {
        console.log(error);
    }
};

const initSearch = () => {
    const searchField = document.getElementById("searchField");
    const searchButton = document.getElementById("searchButton");
    const searchForm = document.querySelector(".search-wrapper");

    if (searchForm) {
        searchForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const name = searchField.value;
            await filterDoctors(name);
        });
    }
};

const filterDoctors = async (name) => {
    try {
        const response = await fetch(`/api/doctor/byName?name=${encodeURIComponent(name)}`);
        if (!response.ok) {
            console.log(response);
            return;
        }
        const doctors = await response.json();
        listDoctors(doctors);
    } catch (error) {
        console.log(error);
    }
};

const listDoctors = (doctors) => {
    const doctorListContainer = document.getElementById("doctorListContainer");
    if (!doctorListContainer) return;

    doctorListContainer.innerHTML = '';

    if (doctors.length === 0) {
        doctorListContainer.innerHTML = '<p class="no-results">No doctors found matching your search.</p>';
        return;
    }

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
