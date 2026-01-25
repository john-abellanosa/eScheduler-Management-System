document.addEventListener('DOMContentLoaded', function() {
    const verifyOtpForm = document.getElementById('verifyOtpForm');
    const otpContainer = document.getElementById('otpContainer');
    const otpError = document.getElementById('otpError');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const timerElement = document.getElementById('timer');
    const resendLink = document.getElementById('resendLink');

    let otpInputs = [];

    // Create 6 OTP input boxes
    function createOtpInputs() {
        for (let i = 0; i < 6; i++) {
            const input = document.createElement('input');
            input.type = 'text';
            input.maxLength = 1;
            input.className = 'otp-input';
            input.dataset.index = i;
            
            // Only allow numbers
            input.addEventListener('input', function(e) {
                // Remove non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Clear any error when user types
                clearOtpError();
                
                // Move to next input if a number is entered
                if (this.value.length === 1 && i < 5) {
                    otpInputs[i + 1].focus();
                }
            });
            
            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && i > 0) {
                    otpInputs[i - 1].focus();
                }
            });
            
            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                
                // Clear any error when user pastes
                clearOtpError();
                
                for (let j = 0; j < Math.min(pasteData.length, 6); j++) {
                    if (i + j < 6) {
                        otpInputs[i + j].value = pasteData[j];
                    }
                }
                
                // Focus the last filled input
                const lastIndex = Math.min(i + pasteData.length - 1, 5);
                if (lastIndex >= 0) {
                    otpInputs[lastIndex].focus();
                }
            });
            
            otpContainer.appendChild(input);
            otpInputs.push(input);
        }
    }

    // Get OTP value
    function getOtpValue() {
        return otpInputs.map(input => input.value).join('');
    }

    // Show error for OTP
    function showOtpError(message) {
        otpInputs.forEach(input => input.classList.add('error'));
        otpError.textContent = message;
        otpError.classList.add('show');
    }

    // Clear OTP error
    function clearOtpError() {
        otpInputs.forEach(input => input.classList.remove('error'));
        otpError.classList.remove('show');
    }

    // Validate OTP
    function validateOtp(otp) {
        // Check if OTP is empty
        if (otp.length === 0) {
            return 'Please enter the verification code';
        }
        
        // Check if all 6 digits are entered
        if (otp.length !== 6) {
            return 'Please enter all 6 digits';
        }
        
        // Check if all are numbers
        if (!/^\d{6}$/.test(otp)) {
            return 'Invalid code. Please enter only numbers';
        }
        
        return null; // No error
    }

    // Form submission - Validations only
    verifyOtpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        clearOtpError();
        
        const otp = getOtpValue();
        const validationError = validateOtp(otp);
        
        if (validationError) {
            showOtpError(validationError);
            return;
        }
        
        // If validation passes, form can be submitted to backend
        // For now, just log success
        console.log('OTP validation passed:', otp);
        
        // You can uncomment the following to submit the form to your backend:
        // this.submit();
    });

    // Initialize
    createOtpInputs();
    
    // Auto-focus on first OTP input
    if (otpInputs.length > 0) {
        otpInputs[0].focus();
    }
});