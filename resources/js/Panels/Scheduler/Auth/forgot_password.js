document.addEventListener('DOMContentLoaded', function() {
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

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

    // Real-time clear errors when user types
    emailInput.addEventListener('input', function() {
        clearInputError(emailInput, emailError);
    });

    // Form submission
    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset errors
        clearInputError(emailInput, emailError);
        
        // Get values
        const email = emailInput.value.trim();
        
        let isValid = true;
        
        // Validate email
        if (!email) {
            showInputError(emailInput, emailError, 'Email address is required');
            isValid = false;
        } else if (!validateEmail(email)) {
            showInputError(emailInput, emailError, 'Please enter a valid email address');
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Simulate API call (for frontend demo)
        const originalBtnText = btnText.textContent;
        submitBtn.disabled = true;
        btnText.textContent = 'Sending...';
        
        // Simulate API delay
        setTimeout(() => {
            // In real implementation, this would submit to your backend
            // For now, just reset the button and clear the form
            emailInput.value = '';
            
            // Reset button
            submitBtn.disabled = false;
            btnText.textContent = originalBtnText;
            
        }, 1500);
    });
    
    // Auto-focus on email input when page loads
    emailInput.focus();
});