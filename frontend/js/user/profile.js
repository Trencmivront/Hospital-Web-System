document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const targetSection = item.getAttribute('data-section');

            // Update menu active state
            menuItems.forEach(mi => mi.classList.remove('active'));
            item.classList.add('active');

            // Show target section
            contentSections.forEach(section => {
                if (section.id === targetSection) {
                    section.classList.add('active');
                } else {
                    section.classList.remove('active');
                }
            });

            console.log(`Switched to section: ${targetSection}`);
        });
    });

    // Handle cancel appointment button
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    cancelButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            const date = row.cells[0].innerText;
            if (confirm(`Are you sure you want to cancel your appointment on ${date}?`)) {
                row.remove();
                alert('Appointment cancelled.');
            }
        });
    });
});