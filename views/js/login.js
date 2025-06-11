const formContainer = document.getElementById('form-container');
const switchToRegister = document.getElementById('switch-to-register');
const switchToLogin = document.getElementById('switch-to-login');

// Alternar para o formulário de registro
switchToRegister.addEventListener('click', () => {
    formContainer.classList.add('show-register');
});

// Alternar para o formulário de login
switchToLogin.addEventListener('click', () => {
    formContainer.classList.remove('show-register');
});

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

// Submissão do formulário de login
document.getElementById('login-form').addEventListener('submit', function(e) {
    Swal.fire({
        title: "Login realizado com sucesso!",
        icon: "success",
        draggable: true
    });
});

// Submissão do formulário de registro
document.getElementById('register-form').addEventListener('submit', function(e) {
    Swal.fire({
        title: "Registro realizado com sucesso!",
        icon: "success",
        draggable: true
    });
});