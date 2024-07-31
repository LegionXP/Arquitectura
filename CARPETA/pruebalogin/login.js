// logica del login funcional con js

const form = document.querySelector('form');
const usernameInput = document.querySelector('input[name="username"]');
const passwordInput = document.querySelector('input[name="password"]');
const error = document.querySelector('.error');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    const username = usernameInput.value;
    const password = passwordInput.value;
    if (username === 'admin' && password === 'password') {
        window.location.href = 'inicio.html';
    } else {
        // error.style.display = 'block';
    }
});

