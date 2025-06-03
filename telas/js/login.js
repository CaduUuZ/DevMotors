const formContainer = document.getElementById('formContainer');

function showRegister() {
    formContainer.classList.add('show-register');
}

function showLogin() {
    formContainer.classList.remove('show-register');
}

// Efeito de animação nos inputs
document.querySelectorAll('.input-field').forEach(input => {
    input.addEventListener('input', function() {
        if (this.value !== '') {
            this.classList.add('has-value');
        } else {
            this.classList.remove('has-value');
        }
    });
});

// Submissão dos formulários
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Login realizado com sucesso!');
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Registro realizado com sucesso!');
    showLogin();
});