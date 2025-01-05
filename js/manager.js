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
  myAccount: document.getElementById('myAccount'),
  bookings: document.getElementById('bookings'),
  reservations: document.getElementById('reservations'),
  inbox: document.getElementById('inbox')
};
const navItems = {
  dashboard: document.getElementById('navDashboard'),
  myAccount: document.getElementById('navMyAccount'),
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

const dateInput = document.getElementById('myAccountDatebirth');
const today = new Date();
const maxDate = new Date(today.getFullYear() - 13, today.getMonth(), today.getDate());
dateInput.max = maxDate.toISOString().split('T')[0];

dateInput.addEventListener('click', () => {
  dateInput.showPicker();
});
