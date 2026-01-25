document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const changePasswordForm = document.getElementById('changePasswordForm');
    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
    const toggleNewPassword = document.getElementById('toggleNewPassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    
    // Error Elements
    const currentPasswordError = document.getElementById('currentPasswordError');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    
    // Requirement Elements
    const reqLength = document.getElementById('reqLength');
    const reqLowercase = document.getElementById('reqLowercase');
    const reqUppercase = document.getElementById('reqUppercase');
    const reqNumber = document.getElementById('reqNumber');
    const reqMatch = document.getElementById('reqMatch');

    // Password toggle functionality
    toggleCurrentPassword.addEventListener('click', function() {
        togglePasswordVisibility(currentPasswordInput, this);
    });

    toggleNewPassword.addEventListener('click', function() {
        togglePasswordVisibility(newPasswordInput, this);
    });

    toggleConfirmPassword.addEventListener('click', function() {
        togglePasswordVisibility(confirmPasswordInput, this);
    });

    function togglePasswordVisibility(input, button) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        button.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    }

    // Update requirement indicators
    function updateRequirements() {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        // Length requirement
        if (password.length >= 8) {
            reqLength.classList.add('valid');
            reqLength.querySelector('i').className = 'fas fa-check-circle';
        } else {
            reqLength.classList.remove('valid');
            reqLength.querySelector('i').className = 'fas fa-circle';
        }
        
        // Lowercase requirement
        if (/[a-z]/.test(password)) {
            reqLowercase.classList.add('valid');
            reqLowercase.querySelector('i').className = 'fas fa-check-circle';
        } else {
            reqLowercase.classList.remove('valid');
            reqLowercase.querySelector('i').className = 'fas fa-circle';
        }
        
        // Uppercase requirement
        if (/[A-Z]/.test(password)) {
            reqUppercase.classList.add('valid');
            reqUppercase.querySelector('i').className = 'fas fa-check-circle';
        } else {
            reqUppercase.classList.remove('valid');
            reqUppercase.querySelector('i').className = 'fas fa-circle';
        }
        
        // Number requirement
        if (/\d/.test(password)) {
            reqNumber.classList.add('valid');
            reqNumber.querySelector('i').className = 'fas fa-check-circle';
        } else {
            reqNumber.classList.remove('valid');
            reqNumber.querySelector('i').className = 'fas fa-circle';
        }
        
        // Match requirement
        if (password && confirmPassword && password === confirmPassword) {
            reqMatch.classList.add('valid');
            reqMatch.querySelector('i').className = 'fas fa-check-circle';
        } else {
            reqMatch.classList.remove('valid');
            reqMatch.querySelector('i').className = 'fas fa-circle';
        }
    }

    // Validation functions
    function validateCurrentPassword() {
        const password = currentPasswordInput.value.trim();
        const errorElement = currentPasswordError;
        
        if (!password) {
            showError(currentPasswordInput, errorElement, 'Current password is required');
            return false;
        }
        
        if (password.length < 8) {
            showError(currentPasswordInput, errorElement, 'Password must be at least 8 characters');
            return false;
        }
        
        clearError(currentPasswordInput, errorElement);
        return true;
    }

    function validateNewPassword() {
        const password = newPasswordInput.value.trim();
        const errorElement = newPasswordError;
        
        if (!password) {
            showError(newPasswordInput, errorElement, 'New password is required');
            return false;
        }
        
        if (password.length < 8) {
            showError(newPasswordInput, errorElement, 'Password must be at least 8 characters');
            return false;
        }
        
        if (!/(?=.*[a-z])/.test(password)) {
            showError(newPasswordInput, errorElement, 'Password must contain at least one lowercase letter');
            return false;
        }
        
        if (!/(?=.*[A-Z])/.test(password)) {
            showError(newPasswordInput, errorElement, 'Password must contain at least one uppercase letter');
            return false;
        }
        
        if (!/(?=.*\d)/.test(password)) {
            showError(newPasswordInput, errorElement, 'Password must contain at least one number');
            return false;
        }
        
        // Check if new password is same as current
        if (password === currentPasswordInput.value.trim()) {
            showError(newPasswordInput, errorElement, 'New password must be different from current password');
            return false;
        }
        
        clearError(newPasswordInput, errorElement);
        return true;
    }

    function validateConfirmPassword() {
        const password = confirmPasswordInput.value.trim();
        const newPassword = newPasswordInput.value.trim();
        const errorElement = confirmPasswordError;
        
        if (!password) {
            showError(confirmPasswordInput, errorElement, 'Please confirm your password');
            return false;
        }
        
        if (password !== newPassword) {
            showError(confirmPasswordInput, errorElement, 'Passwords do not match');
            return false;
        }
        
        clearError(confirmPasswordInput, errorElement);
        return true;
    }

    // UI Helper functions
    function showError(input, errorElement, message) {
        input.classList.add('error');
        input.classList.remove('valid');
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }

    function clearError(input, errorElement) {
        input.classList.remove('error');
        errorElement.classList.remove('show');
    }

    // Real-time validation and requirement updates
    currentPasswordInput.addEventListener('input', function() {
        validateCurrentPassword();
        updateRequirements();
    });

    newPasswordInput.addEventListener('input', function() {
        validateNewPassword();
        updateRequirements();
        // Also validate confirm password when new password changes
        validateConfirmPassword();
    });

    confirmPasswordInput.addEventListener('input', function() {
        validateConfirmPassword();
        updateRequirements();
    });

    // Form submission
    changePasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        const isCurrentValid = validateCurrentPassword();
        const isNewValid = validateNewPassword();
        const isConfirmValid = validateConfirmPassword();
        
        if (isCurrentValid && isNewValid && isConfirmValid) {
            // Simulate API call
            const originalBtnText = btnText.textContent;
            submitBtn.disabled = true;
            btnText.textContent = 'Updating...';
            
            setTimeout(() => {
                // Reset button
                submitBtn.disabled = false;
                btnText.textContent = originalBtnText;
                
                // Show success message
                alert('Password changed successfully!');
                
                // In real implementation, redirect to login
                // window.location.href = '{{ route("Panels.Scheduler.Auth.login") }}';
            }, 1500);
        }
    });

    // Initialize
    currentPasswordInput.focus();
});