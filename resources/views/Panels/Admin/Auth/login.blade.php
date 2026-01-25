<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/Auth/login.js'])
    <link rel="icon" href="{{ asset('assets/images/website_icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Auth/login.css') }}">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="eScheduler Logo">
                </div>
                <span class="admin-label">Admin Panel</span>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="decorative-side">
            <div class="decoration-element decoration-element-1"></div>
            <div class="decoration-element decoration-element-2"></div>
            <div class="decoration-element decoration-element-3"></div>

            <div class="decorative-content">
                <div class="feature-icon">
                    <svg class="admin-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-icon lucide-shield">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                    </svg>
                </div>

                <h2 class="decorative-title">Admin Access</h2>
                <p class="decorative-text">
                    Monitor daily operations, manage workforce schedules, and oversee staff requests through a unified administrative workspace designed for efficiency and control.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Centralized shift planning and adjustments</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Review and action staff schedule requests</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Track attendance records and schedule changes</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-side">
            <div class="login-content">
                <div class="form-header">
                    <h1 class="form-title">Welcome Admin!</h1>
                    <p class="form-subtitle">Enter your credentials to access the admin dashboard</p>
                </div>

                <!-- Form Alert - Appears below subtitle -->
                <div class="form-alert" id="formAlert">
                    <div class="form-alert-message" id="formAlertMessage">Invalid Login Credentials</div>
                </div>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-shield input-icon"></i>
                            <input type="text" id="email" name="email" placeholder="admin@example.com">
                        </div>
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password">
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="error-message" id="passwordError"></div>
                    </div>

                    {{-- <a href="#" class="forgot-password-link">Forgot Password?</a> --}}

                    <button type="submit" class="login-btn" id="loginBtn">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="simple-footer">
        <div class="footer-content">
            <div class="copyright">
                &copy; {{ date('Y') }} eScheduler. Scheduler Panel.
            </div>
        </div>
    </footer> 
</body>
</html>