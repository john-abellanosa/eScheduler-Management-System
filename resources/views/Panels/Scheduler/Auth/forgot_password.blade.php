<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/website_icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Auth/forgot_password.css') }}">
    <title>Forgot Password - Scheduler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

    </style>
</head>

<body>

    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="eScheduler Logo">
                </div>
                <span class="admin-label">Scheduler Panel</span>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="login-side">
            <div class="login-content"> 
                <div class="form-header">
                    <h1 class="form-title">Forgot Password?</h1>
                    <p class="form-subtitle">Enter your email address to reset your password</p>
                    <div class="instructions">
                        <strong>Instructions:</strong> Enter the email address associated with your scheduler account. We'll send you a verification code to reset your password.
                    </div>
                </div>

                <form id="forgotPasswordForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" placeholder="scheduler@example.com">
                        </div>
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <div class="buttons-container">
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span id="btnText">Send Verification Code</span>
                        </button>
                        
                        <a href="{{ route('Panels.Scheduler.Auth.login') }}" class="remember-password-link">
                            <i class="fas fa-arrow-left"></i>
                            Remember your password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="simple-footer">
        <div class="footer-content">
            <div class="copyright">
                &copy; 2026 eScheduler. Scheduler Panel.
            </div>
        </div>
    </footer>

    <script>
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
    </script>
</body>
</html>