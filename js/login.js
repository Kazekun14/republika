function showForm(action) {
    const slider = document.getElementById('slider');
    const adminButton = document.getElementById('adminBtn');
    const managerButton = document.getElementById('managerBtn');
    const username = document.getElementById('username');
    const password = document.getElementById('password')

    adminButton.classList.remove('active');
    managerButton.classList.remove('active');

    if (action === 'admin') {
        slider.style.left = '0';
        adminButton.classList.add('active');
        username.removeAttribute("name");
        username.setAttribute("name", "adminUsername");
        password.removeAttribute("name");
        password.setAttribute("name", "adminPassword");
    } else if (action === 'manager') {
        slider.style.left = '50%';
        managerButton.classList.add('active');
        username.removeAttribute("name");
        username.setAttribute("name", "managerUsername");
        password.removeAttribute("name");
        password.setAttribute("name", "managerPassword");
    }
}