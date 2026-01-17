@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Announcement')

@section('page-title', 'Announcement')
@section('page-subtitle', 'Create and view announcements')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Pages/Dashboard/announcement.css') }}">
    <title>@yield('title')</title> 
</head>
<body>
    <div class="container">

        <div class="dashboard-header">
            <div class="header-left">
                <nav class="nav-links">
                    <a href="{{ route('Panels.Admin.Pages.Dashboard.dashboard') }}" class="nav-link">Dashboard</a>
                    <a href="{{ route('Panels.Admin.Pages.Dashboard.announcement') }}" class="nav-link active">Announcement</a>
                </nav>
            </div>
            <div class="header-right">
                <div class="datetime-display">
                    <div class="date-display" id="currentDate">-- -- ----</div>
                    <div class="time-display" id="currentTime">--:--:--</div>
                </div>
            </div>
        </div> 

        <div class="main-container">
            <div class="left-section">
                <!-- Create Announcement Form -->
                <div class="form-section">
                    <div class="section-title">Create New Announcement</div>

                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" placeholder="Enter announcement title" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea id="content" placeholder="Write your announcement message..."></textarea>
                    </div>

                    <div class="button-group">
                        <button class="btn-publish" onclick="publishAnnouncement()">Publish Announcement</button>
                        <button class="btn-reset" onclick="resetForm()">Clear Form</button>
                    </div>

                    <div class="status-message" id="statusMessage"></div>
                </div>

                <!-- Example Announcements -->
                <div class="example-announcements">
                    <div class="section-title">Your Announcements</div>
                    
                    <!-- New announcement will be inserted here -->
                    <div id="announcementsList">
                        <div class="announcement-item new">
                            <div class="announcement-title">
                                <span>New Feature Release</span>
                                <span class="new-badge">NEW</span>
                            </div>
                            <div class="announcement-content">
                                We've just released a new dashboard feature that allows real-time analytics. Check it out in the reports section.
                            </div>
                            <div class="announcement-meta">
                                <span>Posted: March 16, 2026 at 06:49 AM</span>
                            </div>
                        </div>

                        <div class="announcement-item">
                            <div class="announcement-title">System Maintenance Schedule</div>
                            <div class="announcement-content">
                                The system will undergo maintenance this Saturday from 2:00 AM to 4:00 AM. 
                                Please save your work and log out before this time.
                            </div>
                            <div class="announcement-meta">
                                <span>Posted: March 14, 2026 at 10:30 AM</span>
                            </div>
                        </div>

                        <div class="announcement-item">
                            <div class="announcement-title">Holiday Schedule Update</div>
                            <div class="announcement-content">
                                The office will be closed from December 24th to December 26th for Christmas holidays.
                                Normal operations will resume on December 27th.
                            </div>
                            <div class="announcement-meta">
                                <span>Posted: March 11, 2026 at 02:15 PM</span>
                            </div>
                        </div>

                        <div class="announcement-item">
                            <div class="announcement-title">New Policy Implementation</div>
                            <div class="announcement-content">
                                Starting next month, all employees must complete the new cybersecurity training 
                                module. The training will be available on the employee portal.
                            </div>
                            <div class="announcement-meta">
                                <span>Posted: March 9, 2026 at 09:00 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- From Scheduler Section -->
            <div class="right-section">
                <div class="scheduler-header">
                    <div class="scheduler-title">From Scheduler</div> 
                </div>

                <div class="scheduler-item">
                    <div class="scheduler-item-title">
                        <span>Weekly Team Meeting</span> 
                    </div>
                    <div class="scheduler-item-content">
                        Regular team meeting to discuss project updates, challenges, and next week's priorities.
                    </div>
                    <div class="scheduler-item-meta">
                        <div class="schedule-info">
                            <span class="schedule-date">March 16, 2026 at 06:49 AM</span>
                        </div> 
                    </div>
                </div>

                <div class="scheduler-item">
                    <div class="scheduler-item-title">
                        <span>Monthly Report Submission</span> 
                    </div>
                    <div class="scheduler-item-content">
                        Submit monthly performance and progress reports to the management team.
                    </div>
                    <div class="scheduler-item-meta">
                        <div class="schedule-info">
                            <span class="schedule-date">March 15, 2026 at 05:00 PM</span>
                        </div> 
                    </div>
                </div>

                <div class="scheduler-item">
                    <div class="scheduler-item-title">
                        <span>Quarterly Review Meeting</span> 
                    </div>
                    <div class="scheduler-item-content">
                        Quarterly performance review meeting with department heads and team leads.
                    </div>
                    <div class="scheduler-item-meta">
                        <div class="schedule-info">
                            <span class="schedule-date">March 14, 2026 at 11:30 AM</span>
                        </div> 
                    </div>
                </div>

                <div class="scheduler-item">
                    <div class="scheduler-item-title">
                        <span>System Backup Reminder</span> 
                    </div>
                    <div class="scheduler-item-content">
                        Automated system backup process. Ensure all critical data is saved before backup starts.
                    </div>
                    <div class="scheduler-item-meta">
                        <div class="schedule-info">
                            <span class="schedule-date">March 13, 2026 at 08:45 AM</span>
                        </div> 
                    </div>
                </div>

                <div class="scheduler-item">
                    <div class="scheduler-item-title">
                        <span>Training Session</span> 
                    </div>
                    <div class="scheduler-item-content">
                        Mandatory cybersecurity training session for all employees.
                    </div>
                    <div class="scheduler-item-meta">
                        <div class="schedule-info">
                            <span class="schedule-date">March 12, 2026 at 03:20 PM</span>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script> 
        function updateDateTime() {
            const now = new Date();
            
            // Format date - more compact
            const options = { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            };
            document.getElementById('currentDate').textContent = 
                now.toLocaleDateString('en-US', options);
            
            // Format time
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        // Update time every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call
    </script>

    <script>
        function formatDateTime(date) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];
            
            const month = months[date.getMonth()];
            const day = date.getDate();
            const year = date.getFullYear();
            
            let hours = date.getHours();
            const minutes = date.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            
            return `${month} ${day}, ${year} at ${hours}:${minutes} ${ampm}`;
        }

        function publishAnnouncement() {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();

            if (!title || !content) {
                showStatus('Please fill in both title and content', false);
                return;
            }

            const now = new Date();
            const formattedDate = formatDateTime(now);

            // Create new announcement element
            const announcementHTML = `
                <div class="announcement-item new">
                    <div class="announcement-title">
                        <span>${title}</span>
                        <span class="new-badge">NEW</span>
                    </div>
                    <div class="announcement-content">
                        ${content}
                    </div>
                    <div class="announcement-meta">
                        <span>Posted: ${formattedDate}</span>
                    </div>
                </div>
            `;

            // Add new announcement at the top of the list
            const announcementsList = document.getElementById('announcementsList');
            announcementsList.insertAdjacentHTML('afterbegin', announcementHTML);

            // Remove "new" class from other announcements after 24 hours
            setTimeout(() => {
                const newAnnouncement = announcementsList.firstElementChild;
                if (newAnnouncement) {
                    newAnnouncement.classList.remove('new');
                    newAnnouncement.querySelector('.new-badge').remove();
                }
            }, 86400000); // 24 hours in milliseconds

            showStatus('Announcement published successfully!', true);
            
            // Clear form after delay
            setTimeout(() => {
                resetForm();
            }, 2000);
        }

        function resetForm() {
            document.getElementById('title').value = '';
            document.getElementById('content').value = '';
            document.getElementById('statusMessage').classList.remove('show');
        }

        function showStatus(message, isSuccess) {
            const statusEl = document.getElementById('statusMessage');
            statusEl.textContent = message;
            statusEl.className = 'status-message show ' + (isSuccess ? 'success' : 'error');
            
            // Auto-hide success message after 3 seconds
            if (isSuccess) {
                setTimeout(() => {
                    statusEl.classList.remove('show');
                }, 3000);
            }
        }

        // Initialize some dates
        document.addEventListener('DOMContentLoaded', function() {
            // Update dates for existing items
            const now = new Date();
            const dates = [
                new Date(now.getFullYear(), now.getMonth(), now.getDate(), 6, 49),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 2, 10, 30),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 5, 14, 15),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 7, 9, 0)
            ];

            // Update announcement dates
            const announcementMetas = document.querySelectorAll('.announcement-meta span');
            announcementMetas.forEach((meta, index) => {
                if (dates[index]) {
                    meta.textContent = `Posted: ${formatDateTime(dates[index])}`;
                }
            });

            // Update scheduler dates
            const scheduleDates = document.querySelectorAll('.schedule-date');
            const schedulerDates = [
                new Date(now.getFullYear(), now.getMonth(), now.getDate(), 6, 49),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 1, 17, 0),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 2, 11, 30),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 3, 8, 45),
                new Date(now.getFullYear(), now.getMonth(), now.getDate() - 4, 15, 20)
            ];

            scheduleDates.forEach((dateEl, index) => {
                if (schedulerDates[index]) {
                    dateEl.textContent = formatDateTime(schedulerDates[index]);
                }
            });
        });
    </script>
</body>
</html>
@endsection