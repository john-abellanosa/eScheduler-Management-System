    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/website_icon.png') }}">
    <title>Change Password</title>
    @vite(['resources/js/Panels/Scheduler/Auth/change_password.js'])
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Auth/change_password.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <h1 class="form-title">Change Password</h1>
                    <p class="form-subtitle">Create a new secure password for your account</p>
                    <div class="instructions">
                        <strong>Security Note:</strong> Create a strong password with at least 8 characters including letters, numbers, and special characters.
                    </div>
                </div>

                <form id="changePasswordForm">
                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="currentPassword" name="currentPassword" placeholder="Enter your current password">
                            <button type="button" class="password-toggle" id="toggleCurrentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="currentPasswordError"></div>
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Create a new password">
                            <button type="button" class="password-toggle" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="newPasswordError"></div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password">
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="requirements">
                        <div class="requirements-title">
                            <i class="fas fa-shield-alt"></i>
                            Password Requirements
                        </div>
                        <ul class="requirement-list" id="requirementList">
                            <li class="requirement-item" id="reqLength">
                                <i class="fas fa-circle"></i>
                                At least 8 characters
                            </li>
                            <li class="requirement-item" id="reqLowercase">
                                <i class="fas fa-circle"></i>
                                At least one lowercase letter
                            </li>
                            <li class="requirement-item" id="reqUppercase">
                                <i class="fas fa-circle"></i>
                                At least one uppercase letter
                            </li>
                            <li class="requirement-item" id="reqNumber">
                                <i class="fas fa-circle"></i>
                                At least one number
                            </li>
                            <li class="requirement-item" id="reqMatch">
                                <i class="fas fa-circle"></i>
                                Passwords must match
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="buttons-container">
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="fas fa-key"></i>
                            <span id="btnText">Change Password</span>
                        </button>
                        
                        <a href="{{ route('Panels.Scheduler.Auth.login') }}" class="cancel-link">
                            <i class="fas fa-arrow-left"></i>
                            Back to Login
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
</body>
</html>