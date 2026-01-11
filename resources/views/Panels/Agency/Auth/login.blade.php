<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eScheduler - Scheduler Panel Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background: #f8fafc;
            color: #1a1a1a;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header - Blue Theme */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 0 2rem;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            height: 60px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo {
            width: 160px;
            height: 160px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: transparent;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .admin-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding-left: 1rem;
            border-left: 1px solid #e5e5e5;
        }

        /* Main Content */
        .main {
            display: flex;
            min-height: 100vh;
        }

        /* Left Side - Scheduler Decoration */
        .decorative-side {
            flex: 1;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #1e3a8a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Calendar/Schedule Grid Background */
        .calendar-grid {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image:
                linear-gradient(90deg, transparent 95%, rgba(255, 255, 255, 0.3) 95%),
                linear-gradient(0deg, transparent 95%, rgba(255, 255, 255, 0.3) 95%);
            background-size: 50px 50px;
            animation: gridMove 30s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(50px);
            }
        }

        /* Animated background elements */
        .decorative-side::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            top: -150px;
            right: -150px;
            animation: float 8s ease-in-out infinite;
        }

        .decorative-side::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            bottom: -100px;
            left: -100px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) translateX(0px);
            }

            50% {
                transform: translateY(-30px) translateX(20px);
            }
        }

        /* Schedule Timeline Animation */
        .timeline {
            position: absolute;
            width: 2px;
            height: 70%;
            background: rgba(255, 255, 255, 0.3);
            left: 25%;
            top: 15%;
            animation: timelinePulse 3s ease-in-out infinite;
        }

        .timeline::before,
        .timeline::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 50%;
            left: -5px;
        }

        .timeline::before {
            top: 0;
            animation: dotPulse 2s ease-in-out infinite;
        }

        .timeline::after {
            bottom: 0;
            animation: dotPulse 2s ease-in-out infinite reverse;
        }

        @keyframes timelinePulse {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.6;
            }
        }

        @keyframes dotPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }
        }

        /* Additional decorative elements */
        .decoration-element {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: pulse 6s ease-in-out infinite;
        }

        .decoration-element-1 {
            width: 250px;
            height: 250px;
            background: #ffffff;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .decoration-element-2 {
            width: 150px;
            height: 150px;
            background: #ffffff;
            bottom: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        .decoration-element-3 {
            width: 200px;
            height: 200px;
            background: #ffffff;
            top: 50%;
            right: 10%;
            animation-delay: 4s;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .decorative-content {
            position: relative;
            z-index: 1;
            max-width: 450px;
            padding: 3rem;
            color: #ffffff;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .admin-icon {
            width: 40px;
            height: 40px;
        }

        .decorative-title {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .decorative-text {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.8;
            margin-bottom: 2.5rem;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .feature-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .feature-check {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .feature-check i {
            font-size: 12px;
            color: #ffffff;
        }

        .feature-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        /* Right Side - Login Form */
        .login-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-content {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            margin-bottom: 2.5rem;
            text-align: left;
        }

        .form-title {
            font-size: 28px;
            font-weight: 600;
            color: #1a1a1a;
            letter-spacing: -0.3px;
        }

        .form-subtitle {
            font-size: 14px;
            color: #6b7280;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            letter-spacing: 0.2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            z-index: 2;
        }

        input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: #ffffff;
            color: #1a1a1a;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        input.error {
            border-color: #dc2626;
        }

        input::placeholder {
            color: #9ca3af;
        }

        /* Password visibility toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            z-index: 3;
            transition: color 0.2s ease;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #1e3a8a;
        }

        /* Forgot Password Link */
        .forgot-password-link {
            display: flex;
            justify-content: flex-end;
            font-size: 13px;
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 1.40rem;
            transition: color 0.2s ease;
        }

        .forgot-password-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 14px;
            font-weight: 600;
            background: #1e3a8a;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-btn:hover:not(:disabled) {
            background: #1e40af;
        }

        .login-btn:active:not(:disabled) {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .simple-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem 2rem;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            background: #FFFFFF;
            border-top: 1px solid #e5e5e5;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 1024px) {
            .main {
                flex-direction: column;
            }

            .decorative-side {
                padding: 3rem 2rem;
                min-height: 200px;
            }

            .login-side {
                padding: 3rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .simple-footer,
            .header-content {
                height: 60px;
            }

            .login-content {
                max-width: 100%;
            }

            .decorative-side {
                display: none;
            }

            .login-side {
                padding: 4rem 1.5rem;
            }

            .footer-content {
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 0.8rem;
            }

            .form-title {
                font-size: 24px;
            }

            .simple-footer {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0.5rem 1rem;
            }
        }
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

                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-shield input-icon"></i>
                            <input type="text" id="email" name="email" placeholder="Please Enter your Email Address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Please Enter your Password">
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <a href="#" class="forgot-password-link">Forgot password?</a>

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
                &copy; 2026 eScheduler. Scheduler Panel.
            </div>
        </div>
    </footer>

</body>

</html>