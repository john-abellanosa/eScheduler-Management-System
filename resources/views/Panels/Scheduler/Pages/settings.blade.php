@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Settings')

@section('page-title', 'Settings')
@section('page-subtitle', 'Manage your profile and account settings')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/settings.css') }}">
    <title>@yield('title')</title> 
</head>
<body>
    <!-- Main Container -->
    <div class="main-container">

        {{-- <div class="page-header">
            <h1>Settings</h1>
            <p class="subtitle">Manage your profile and account settings</p>
        </div> --}}
        
        <!-- Content Area -->
        <div class="content-container">
            <div class="settings-sidebar">
                <button class="settings-nav-item active" onclick="switchTab('profile')">Profile</button>
                <button class="settings-nav-item" onclick="switchTab('password')">Password</button>
            </div>

            <div class="content">
                <!-- Profile Section -->
                <div id="profile" class="section active">
                    <h2>Profile Information</h2>
                    <p>Update your personal information</p>

                    <div class="form-grid">
                        <!-- ID Field (Read-only) -->
                        <div class="form-group">
                            <label>Employee ID</label>
                            <input type="text" id="employeeId" value="EMP-2024-00123" readonly>
                        </div>

                        <!-- Name Field -->
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" id="nameInput" placeholder="Enter your full name" value="John Lloyd Abellanosa">
                        </div>

                        <!-- Email Field -->
                        <div class="form-group full-width">
                            <label>Email Address</label>
                            <input type="email" id="emailInput" placeholder="Enter your email" value="johnlloyabellanosa1@gmail.com">
                        </div>

                        <!-- Phone Number Field -->
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" id="phoneInput" placeholder="Enter phone number" value="+1 (555) 123-4567">
                        </div>

                        <!-- Address Field -->
                        <div class="form-group full-width">
                            <label>Address</label>
                            <input type="text" id="addressInput" placeholder="Enter your address" value="123 Main Street, City, Country">
                        </div>
                    </div>

                    <button class="btn btn-primary" onclick="saveProfile()">Save Profile</button>
                </div>

                <!-- Password Section -->
                <div id="password" class="section">
                    <h2>Update Password</h2>
                    <p>Ensure your account is using a long, random password to stay secure</p>

                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" id="currentPassword" placeholder="Enter current password">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" id="newPassword" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" id="confirmPassword" placeholder="Confirm new password">
                    </div>

                    <button class="btn btn-primary" onclick="savePassword()">Update Password</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.classList.remove('active'));

            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.settings-nav-item');
            navItems.forEach(item => item.classList.remove('active'));

            // Show selected section
            document.getElementById(tab).classList.add('active');

            // Add active class to clicked nav item
            event.target.classList.add('active');
        }

        function saveProfile() {
            const name = document.getElementById('nameInput').value;
            const email = document.getElementById('emailInput').value;
            const phone = document.getElementById('phoneInput').value;
            const address = document.getElementById('addressInput').value;

            if (!name || !email || !phone || !address) {
                alert('Please fill in all fields');
                return;
            }

            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return;
            }

            alert('Profile saved successfully!');
            console.log('Profile updated:', { name, email, phone, address });
        }

        function savePassword() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Please fill in all fields');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('New passwords do not match');
                return;
            }

            if (newPassword.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }

            alert('Password updated successfully!');

            // Clear the form
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        }
    </script>
</body>
</html>
@endsection