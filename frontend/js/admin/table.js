import { manageTableData } from './admin-functions.js';

document.addEventListener("DOMContentLoaded", () => {
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const tableLinks = document.querySelectorAll('.dropdown-menu a');
    const tableBody = document.getElementById('dataTableBody');
    const tableHead = document.getElementById('tableHead');
    const tableTitle = document.getElementById('tableTitle');

    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const formFields = document.getElementById('formFields');
    const closeBtn = document.querySelector('.close-btn');

    let currentTableName = '';
    let currentData = [];

    const apiEndpoints = {
        'Patient': '/api/patient',
        'Doctor': '/api/doctor',
        'Appointment': '/api/appointment',
        'Department': '/api/department',
        'Specialization': '/api/specialization',
        'Schedule': '/api/schedule',
        'Doctor_Schedule': '/api/doctor_schedule',
        'Blood_Type': '/api/blood',
        'Punishment': '/api/punishment',
        'Patient_Punishment': '/api/patient_punishment',
        'Treatment': '/api/treatment',
        'Bill': '/api/bill',
        'Admin': '/api/admin'
    };

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
        link.addEventListener('click', async (e) => {
            e.preventDefault();
            const tableName = link.getAttribute('data-table');
            const selectionLabel = link.textContent.trim();
            
            currentTableName = tableName;
            tableTitle.textContent = selectionLabel;
            
            // Clear existing table data
            tableHead.innerHTML = '';
            tableBody.innerHTML = '<tr><td colspan="100%">Loading...</td></tr>';

            const data = await manageTableData(tableName);
            currentData = data;

            if (!data || data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="100%">No records found.</td></tr>';
                return;
            }

            // Generate Table Headers
            const headers = Object.keys(data[0]);
            let headRow = '<tr>';
            headers.forEach(header => {
                headRow += `<th>${header}</th>`;
            });
            headRow += '<th>Actions</th></tr>';
            tableHead.innerHTML = headRow;

            // Generate Table Rows
            tableBody.innerHTML = '';
            data.forEach(row => {
                let tr = '<tr>';
                // reach to values with their names
                headers.forEach(header => {
                    tr += `<td>${row[header] !== null ? row[header] : 'N/A'}</td>`;
                });
                tr += `<td><button class="action-btn edit-btn">Edit</button> <button class="action-btn delete">Delete</button></td>`;
                tr += '</tr>';
                tableBody.insertAdjacentHTML('beforeend', tr);
            });
        });
    });

    // Event delegation for Edit and Delete buttons
    tableBody.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (!row) return;

        const rowIndex = Array.from(tableBody.children).indexOf(row);
        const rowData = currentData[rowIndex];

        if (e.target.classList.contains('delete')) {
            handleDelete(rowData);
        } else if (e.target.classList.contains('edit-btn')) {
            openEditModal(rowData);
        }
    });

    const handleDelete = async (rowData) => {
        const idKey = Object.keys(rowData)[0];
        const idValue = rowData[idKey];
        const baseUrl = apiEndpoints[currentTableName];

        if (confirm(`Are you sure you want to delete this record (ID: ${idValue})?`)) {
            try {
                const response = await fetch(`${baseUrl}/delete`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ [idKey]: idValue })
                });

                if (response.ok) {
                    alert('Record deleted successfully');
                    // Refresh table
                    const activeLink = document.querySelector(`.dropdown-menu a[data-table="${currentTableName}"]`);
                    activeLink.click();
                } else {
                    const error = await response.json();
                    alert('Failed to delete record: ' + (error.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error deleting record:', error);
                alert('An error occurred while deleting the record.');
            }
        }
    };

    const openEditModal = (rowData) => {
        formFields.innerHTML = '';
        Object.keys(rowData).forEach(key => {
            const div = document.createElement('div');
            const label = document.createElement('label');
            label.textContent = key.replace(/_/g, ' ').toUpperCase();
            
            let input;
            if (key.includes('date')) {
                input = document.createElement('input');
                input.type = 'date';
            } else if (key.includes('time')) {
                input = document.createElement('input');
                input.type = 'time';
            } else {
                input = document.createElement('input');
                input.type = 'text';
            }

            input.name = key;
            input.value = rowData[key] !== null ? rowData[key] : '';
            
            // Disable ID and timestamp fields
            if (key === Object.keys(rowData)[0] || key === 'created_at' || key === 'updated_at') {
                input.readOnly = true;
                input.style.backgroundColor = '#f0f0f0';
            }

            div.appendChild(label);
            div.appendChild(input);
            formFields.appendChild(div);
        });
        editModal.style.display = 'block';
    };

    if (closeBtn) {
        closeBtn.onclick = () => editModal.style.display = 'none';
    }

    window.onclick = (event) => {
        if (event.target == editModal) editModal.style.display = 'none';
    };

    if (editForm) {
        editForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(editForm);
            const data = Object.fromEntries(formData.entries());
            const baseUrl = apiEndpoints[currentTableName];

            try {
                const response = await fetch(`${baseUrl}/update`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    alert('Record updated successfully');
                    editModal.style.display = 'none';
                    // Refresh table
                    const activeLink = document.querySelector(`.dropdown-menu a[data-table="${currentTableName}"]`);
                    activeLink.click();
                } else {
                    const error = await response.json();
                    alert('Failed to update record: ' + (error.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error updating record:', error);
                alert('An error occurred while updating the record.');
            }
        };
    }

    // Auto-select the first table (Patient) on page load
    if (tableLinks.length > 0) {
        tableLinks[0].click();
    }
});
