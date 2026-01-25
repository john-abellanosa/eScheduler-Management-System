document.addEventListener('DOMContentLoaded', function() { 
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('passwordToggle');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const formAlert = document.getElementById('formAlert'); 
    const formAlertMessage = document.getElementById('formAlertMessage');


    // Password visibility toggle
    passwordToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Simple email validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Show error for input
    function showInputError(input, errorElement, message) {
        input.classList.add('error');
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }

    // Clear input error
    function clearInputError(input, errorElement) {
        input.classList.remove('error');
        errorElement.classList.remove('show');
    }

    // Show form alert
    function showFormAlert(message) {
        formAlertMessage.textContent = message;
        formAlert.classList.add('show');
    }

    // Hide form alert
    function hideFormAlert() {
        formAlert.classList.remove('show');
    }

    // Real-time clear errors when user types
    emailInput.addEventListener('input', function() {
        clearInputError(emailInput, emailError);
        hideFormAlert(); // Hide alert when user starts typing
    });

    passwordInput.addEventListener('input', function() {
        clearInputError(passwordInput, passwordError);
        hideFormAlert(); // Hide alert when user starts typing
    });

    // Form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset errors
        clearInputError(emailInput, emailError);
        clearInputError(passwordInput, passwordError);
        hideFormAlert();
        
        // Get values
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        
        let isValid = true;
        
        // Validate email
        if (!email) {
            showInputError(emailInput, emailError, 'Email address is required');
            isValid = false;
        } else if (!validateEmail(email)) {
            showInputError(emailInput, emailError, 'Please enter a valid email address');
            isValid = false;
        }
            
        // Validate password
        if (!password) {
            showInputError(passwordInput, passwordError, 'Password is required');
            isValid = false;
        } else if (password.length < 8) {
            showInputError(passwordInput, passwordError, 'Password must be at least 8 characters');
            isValid = false;
        } else if (!/(?=.*[a-z])/.test(password)) {
            showInputError(passwordInput, passwordError, 'Password must contain at least one lowercase letter');
            isValid = false;
        } else if (!/(?=.*[A-Z])/.test(password)) {
            showInputError(passwordInput, passwordError, 'Password must contain at least one uppercase letter');
            isValid = false;
        } else if (!/(?=.*\d)/.test(password)) {
            showInputError(passwordInput, passwordError, 'Password must contain at least one number');
            isValid = false;
        }

        if (isValid) {
            window.location.href = '{{ route("Panels.Scheduler.Pages.Dashboard.dashboard") }}';
        }
        
        if (!isValid) {
            return;
        } 
    }); 

    emailInput.focus();
});