function showForm(action) {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const slider = document.getElementById('slider');
    const loginButton = document.getElementById('loginBtn');
    const registerButton = document.getElementById('registerBtn');

    loginButton.classList.remove('active');
    registerButton.classList.remove('active');

    if (action === 'login') {
        slider.style.left = '0';
        loginButton.classList.add('active');
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    } else if (action === 'register') {
        slider.style.left = '50%';
        registerButton.classList.add('active');
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
    }
}

const params = new URLSearchParams(window.location.search);
const action = params.get('action');
if (action === 'register') {
    showForm('register');
} else {
    showForm('login');
}

