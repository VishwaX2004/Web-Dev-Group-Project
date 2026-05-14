document.addEventListener('DOMContentLoaded', function () {

    const togglePassword = document.querySelector('#togglePassword');

    const password = document.querySelector('#password-field');

    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        
        // change the input type to show/hide the password
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        
        password.setAttribute('type', type);
        
        // change the eye icon accordingly
        if (type === 'password') {

            eyeIcon.classList.remove('fa-eye-slash');

            eyeIcon.classList.add('fa-eye');

        } else {

            eyeIcon.classList.remove('fa-eye');

            eyeIcon.classList.add('fa-eye-slash');
        }
    });
});