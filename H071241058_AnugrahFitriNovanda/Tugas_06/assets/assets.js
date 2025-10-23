document.addEventListener('DOMContentLoaded', function() {
    console.log("Website Manajemen Proyek siap!");

    //  MENU BURGER ---
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('menu-overlay');

    if (hamburgerBtn && sidebar && overlay) {
        // membuka menu
        const openSidebar = () => {
            sidebar.classList.add('is-mobile', 'sidebar-open');
            overlay.classList.add('active');
        };

        // menutup menu
        const closeSidebar = () => {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('active');
            // menambahkan waktu
            setTimeout(() => {
                if (!sidebar.classList.contains('sidebar-open')) {
                    sidebar.classList.remove('is-mobile');
                }
            }, 300);
        };

        hamburgerBtn.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
    }

    const modal = document.getElementById('descriptionModal');
    if (modal) { 
        const closeBtn = modal.querySelector('.close-btn');
        const modalTaskName = document.getElementById('modalTaskName');
        const modalTaskDescription = document.getElementById('modalTaskDescription');
        const viewButtons = document.querySelectorAll('.view-desc-btn');
        const openModal = (e) => {
            const button = e.currentTarget;
            modalTaskName.textContent = button.getAttribute('data-task-name');
            modalTaskDescription.textContent = button.getAttribute('data-description');
            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
        };
        const closeModal = () => {
            modal.style.visibility = 'hidden';
            modal.style.opacity = '0';
        };
        viewButtons.forEach(button => button.addEventListener('click', openModal));
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    }

    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.addEventListener('click', function(e) {
            e.preventDefault();
            try { this.showPicker(); } 
            catch (error) { console.error("Browser tidak mendukung showPicker(): ", error); }
        });
    });

    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('#sidebar nav ul li a');
    sidebarLinks.forEach(function(link) {
        const linkPath = new URL(link.href).pathname;
        if (currentPath.endsWith(linkPath.substring(linkPath.lastIndexOf('/') + 1))) {
            link.classList.add('active');
        }
    });
});