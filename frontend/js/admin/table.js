import { manageTableData } from './admin-functions.js';

document.addEventListener("DOMContentLoaded", () => {
    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const tableLinks = document.querySelectorAll('.dropdown-menu a');
    const tableBody = document.getElementById('dataTableBody');
    const tableHead = document.getElementById('tableHead');
    const tableTitle = document.getElementById('tableTitle');

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
            
            tableTitle.textContent = selectionLabel;
            
            // Clear existing table data
            tableHead.innerHTML = '';
            tableBody.innerHTML = '<tr><td colspan="100%">Loading...</td></tr>';

            const data = await manageTableData(tableName);

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
                tr += `<td><button class="action-btn">Edit</button> <button class="action-btn delete">Delete</button></td>`;
                tr += '</tr>';
                tableBody.insertAdjacentHTML('beforeend', tr);
            });
        });
    });
});
