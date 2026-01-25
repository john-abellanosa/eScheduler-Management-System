<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Scheduler/Auth/login.js'])
    <link rel="icon" href="{{ asset('assets/images/website_icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Auth/login.css') }}">
    <title>Scheduler Login</title>
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
        <div class="decorative-side">
            <div class="calendar-grid"></div>
            <div class="timeline"></div> 

            <div class="decorative-content">
                <div class="feature-icon">
                    <svg class="admin-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M8 14h.01"></path>
                        <path d="M12 14h.01"></path>
                        <path d="M16 14h.01"></path>
                        <path d="M8 18h.01"></path>
                        <path d="M12 18h.01"></path>
                        <path d="M16 18h.01"></path>
                    </svg>
                </div>

                <h2 class="decorative-title">Scheduler Access</h2>
                <p class="decorative-text">
                    Manage staff shifts, track schedules, and handle requests to keep every shift covered and operations running smoothly.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Assign and adjust shifts efficiently</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Manage daily schedules for all staff</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Manage Time Availability</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="feature-text">Handle Swap, Give, and Off-Duty requests</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-side">
            <div class="login-content">
                <div class="form-header">
                    <h1 class="form-title">Welcome Scheduler!</h1>
                    <p class="form-subtitle">Enter your credentials to access the scheduler dashboard</p>
                </div>

                <!-- Form Alert - Appears below subtitle -->
                <div class="form-alert" id="formAlert">
                    <div class="form-alert-message" id="formAlertMessage">Invalid login credentials</div>
                </div>

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-shield input-icon"></i>
                            <input type="text" id="email" name="email" placeholder="scheduler@example.com">
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

                    <a href="{{ route('Panels.Scheduler.Auth.forgot_password') }}" class="forgot-password-link">Forgot password?</a>

                    <button type="submit" class="login-btn" id="loginBtn">
                        <span id="btnText">Login</span>
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