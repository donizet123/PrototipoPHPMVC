// Toggle Sidebar en móvil
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

// Cerrar sidebar al hacer clic fuera en móvil
document.addEventListener('click', function(event) {
    if (window.innerWidth <= 768) {
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (sidebar && menuToggle) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    }
});

// Marcar menú activo según URL actual
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && currentPath.includes(href.split('/').slice(-2).join('/'))) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
});

// Confirmar antes de cerrar sesión
const logoutLink = document.querySelector('.logout');
if (logoutLink) {
    logoutLink.addEventListener('click', function(e) {
        if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            e.preventDefault();
        }
    });
}