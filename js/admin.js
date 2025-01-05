// Sidebar toggle functionality
const sidebar = document.getElementById('sidebar');
const content = document.querySelector('.content');
const sidebarClose = document.getElementById('sidebarClose');
const sidebarOpen = document.getElementById('sidebarOpen');

function toggleSidebar() {
  sidebar.classList.toggle('collapsed');
  content.classList.toggle('expanded');
}

sidebarClose.addEventListener('click', toggleSidebar);
sidebarOpen.addEventListener('click', toggleSidebar);

const navLinks = document.querySelectorAll('.nav-link');
const sections = {
  dashboard: document.getElementById('dashboard'),
  accounts: document.getElementById('accounts'),
  bookings: document.getElementById('bookings'),
  reservations: document.getElementById('reservations'),
  inbox: document.getElementById('inbox')
};
const navItems = {
  dashboard: document.getElementById('navDashboard'),
  accounts: document.getElementById('navAccounts'),
  bookings: document.getElementById('navBookings'),
  reservations: document.getElementById('navReservations'),
  inbox: document.getElementById('navInbox')
};

navLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    navLinks.forEach(l => l.classList.remove('active'));
    e.target.closest('.nav-link').classList.add('active');
  });
});

function showContent(action) {
  Object.values(sections).forEach(section => section.classList.add('d-none'));
  Object.values(navItems).forEach(navItem => navItem.classList.remove('active'));

  if (sections[action]) {
    sections[action].classList.remove('d-none');
    navItems[action].classList.add('active');
  }
}

function showAccountType(action) {
    const customerAccounts = document.getElementById('customerAccounts');
    const managerAccounts = document.getElementById('managerAccounts');
    const totalCustomer = document.getElementById('totalCustomer');
    const totalManager = document.getElementById('totalManager');

    if (action === 'customer') {
      customerAccounts.classList.remove('d-none');
      managerAccounts.classList.add('d-none');
      totalCustomer.classList.remove('d-none');
      totalManager.classList.add('d-none');
    } else if (action === 'manager') {
      managerAccounts.classList.remove('d-none');
      customerAccounts.classList.add('d-none');
      totalManager.classList.remove('d-none');
      totalCustomer.classList.add('d-none');
    }
}