document.addEventListener("DOMContentLoaded", () => {
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const tableLinks = document.querySelectorAll('.dropdown-menu a');
    const tableBody = document.getElementById('dataTableBody');
    const panelHeading = document.querySelector('.panel-large h2');

    // 1. Toggle the Tables sub-menu dropdown open/closed
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('show-menu');
            
            // Toggle the arrow direction symbol
            if (dropdownMenu.classList.contains('show-menu')) {
                dropdownBtn.innerHTML = 'Tables ▴';
            } else {
                dropdownBtn.innerHTML = 'Tables ▾';
            }
        });
    }

    // Handle sub-item clicks and change data dynamically
    tableLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            // Clear the existing rows in the <tbody>
            tableBody.innerHTML = '';

            // Get the text of the clicked item to decide what data to show
            const selection = link.textContent.trim();
            panelHeading.textContent = selection;

            // Render matching table structural rows based on user click
            if (selection === "Patient Records") {
                tableBody.innerHTML = `
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Patient</td>
                        <td><span class="status-active">Active</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Patient</td>
                        <td><span class="status-active">Active</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>jhon abram</td>
                        <td>Patient</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                `;
            } else if (selection === "Doctor Records") {
                tableBody.innerHTML = `
                    <tr>
                        <td>D101</td>
                        <td>Dr. Alexander</td>
                        <td>Doctor</td>
                        <td><span class="status-active">On Duty</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                    <tr>
                        <td>D102</td>
                        <td>Dr. Watson</td>
                        <td>Doctor</td>
                        <td><span class="status-inactive">Off Duty</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                `;
            } else if (selection === "Appointment Records") {
                tableBody.innerHTML = `
                    <tr>
                        <td>A901</td>
                        <td>Checkup - John Doe</td>
                        <td>Appointment</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td><button>Edit</button></td>
                    </tr>
                `;
            }
        });
    });
});