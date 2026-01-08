document.addEventListener("DOMContentLoaded", () => {
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationPanel = document.getElementById("notificationPanel");
    const notificationOverlay = document.getElementById("notificationOverlay");
    const closePanel = document.getElementById("closePanel");
    const notifBadge = document.getElementById("notifBadge");
    const markAllRead = document.getElementById("markAllRead");
    const notificationsList = document.getElementById("notificationsList");
    const filterLinks = document.querySelectorAll(".filter-link");

    let panelOpen = false;
    let notifications = [];
    let autoRefreshInterval = null;
    let currentTab = 'all';

    // Fixed example notifications data
    const exampleNotifications = [
        { 
            id: 1, 
            title: "Shift Swap Request", 
            message: "John Smith wants to swap his Friday evening shift with your Saturday morning shift.", 
            created_at: new Date(Date.now() - 30 * 60000).toISOString(),
            status: "new" 
        },
        { 
            id: 2, 
            title: "Schedule Published", 
            message: "Next week's schedule is now available. Please review your assigned shifts.", 
            created_at: new Date(Date.now() - 2 * 3600000).toISOString(),
            status: "read" 
        },
        { 
            id: 3, 
            title: "Coverage Needed", 
            message: "Urgent: Need coverage for cashier shift tomorrow from 2 PM to 6 PM.", 
            created_at: new Date(Date.now() - 5 * 3600000).toISOString(),
            status: "new" 
        },
        { 
            id: 4, 
            title: "Training Reminder", 
            message: "Food safety training session scheduled for Thursday at 10 AM in the main dining area.", 
            created_at: new Date(Date.now() - 1 * 86400000).toISOString(),
            status: "read" 
        },
        { 
            id: 5, 
            title: "Overtime Opportunity", 
            message: "Extra hours available this weekend. Sign up in the manager's office by end of day.", 
            created_at: new Date(Date.now() - 2 * 86400000).toISOString(),
            status: "read" 
        }
    ];

    // Load notifications - ALWAYS use example data, no localStorage
    function loadNotifications() {
        // Always use fresh example data
        notifications = [...exampleNotifications];
        
        // Sort by date (newest first)
        notifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        
        updateBadge();
        renderNotifications();
    }

    function formatTimestamp(datetime) {
        const now = new Date();
        const notificationDate = new Date(datetime);
        const diffMs = now - notificationDate;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);
        
        if (diffMins < 1) return 'Just now';
        if (diffMins < 60) return `${diffMins}m ago`;
        if (diffHours < 24) return `${diffHours}h ago`;
        if (diffDays < 7) return `${diffDays}d ago`;
        
        return notificationDate.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit'
        });
    }

    // Create a simple SVG icon for empty state
    const getEmptyStateIcon = () => {
        return `
            <svg class="empty-state-icon"
                width="48"
                height="48"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M18 8a6 6 0 00-10.8-3.6"/>
                <path d="M6 8v4c0 .8-.3 1.6-.9 2.2L4 15h10"/>
                <path d="M9.5 18a2.5 2.5 0 005 0"/>
                <path d="M3 3l18 18"/>
            </svg>
        `;
    };

    // Render notifications based on current tab
    function renderNotifications() {
        notificationsList.innerHTML = '';
        
        // Filter notifications based on current tab
        let filteredNotifications = notifications;
        if (currentTab === 'unread') {
            filteredNotifications = notifications.filter(n => n.status === 'new');
        }
        
        if (filteredNotifications.length === 0) {
            let emptyMessage = '';
            let emptyTitle = '';
            
            if (currentTab === 'unread') {
                emptyTitle = "No unread notifications";
                emptyMessage = "You're all caught up! All notifications have been read.";
            } else {
                emptyTitle = "No notifications";
                emptyMessage = "You're all caught up! Check back later for updates.";
            }
            
            notificationsList.innerHTML = `
                <div class="empty-state">
                    ${getEmptyStateIcon()}
                    <div class="empty-state-title">${emptyTitle}</div>
                    <div class="empty-state-message">${emptyMessage}</div>
                </div>
            `;
            return;
        }

        filteredNotifications.forEach(n => {
            const item = document.createElement('div');
            item.className = `notification-item ${n.status === 'new' ? 'unread' : ''}`;
            item.dataset.id = n.id;
            item.innerHTML = `
                <div class="notification-title">
                    ${n.title} 
                </div>
                <div class="notification-message">${n.message}</div>
                <div class="notification-datetime">${formatTimestamp(n.created_at)}</div>
            `;
            notificationsList.appendChild(item);

            // Mark single notification as read on click (only for current session)
            item.addEventListener("click", () => {
                if (n.status === 'new') {
                    n.status = 'read';
                    item.classList.remove('unread');
                    updateBadge();
                    
                    // If we're in unread tab and this was the last unread, show empty state
                    if (currentTab === 'unread') {
                        const remainingUnread = notifications.filter(n => n.status === 'new').length;
                        if (remainingUnread === 0) {
                            renderNotifications();
                        }
                    }
                }
            });
        });
    }
 
    // Update badge
    function updateBadge() {
        const unreadCount = notifications.filter(n => n.status === 'new').length;
        
        if (unreadCount > 0) {
            // If count is 100 or more, show "99+"
            if (unreadCount >= 100) {
                notifBadge.textContent = '99+';
                notifBadge.classList.add('exceed-limit');
            } else {
                notifBadge.textContent = unreadCount;
                notifBadge.classList.remove('exceed-limit');
            }
            notifBadge.style.display = 'flex';
        } else {
            notifBadge.textContent = '';
            notifBadge.style.display = 'none';
            notifBadge.classList.remove('exceed-limit');
        }
    }

    // Panel open/close
    notificationBtn.addEventListener("click", () => {
        notificationPanel.classList.add("open");
        notificationOverlay.classList.add("active");
        panelOpen = true;
        document.body.style.overflow = "hidden";
        
        // Add history entry for mobile back button
        if (window.history && window.history.pushState) {
            history.pushState({ panelOpen: true }, '', '#notification-panel');
        }
    });

    function closeNotificationPanel() {
        notificationPanel.classList.remove("open");
        notificationOverlay.classList.remove("active");
        panelOpen = false;
        document.body.style.overflow = "";
        
        // Remove history entry
        if (window.history && window.history.state && window.history.state.panelOpen) {
            history.back();
        }
    }

    closePanel.addEventListener("click", closeNotificationPanel);
    notificationOverlay.addEventListener("click", closeNotificationPanel);
    
    // Escape key to close
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && panelOpen) closeNotificationPanel();
    });
    
    // Mobile back button handling
    window.addEventListener('popstate', (e) => {
        if (panelOpen) {
            closeNotificationPanel();
        }
    });

    // Filter (all/unread)
    filterLinks.forEach(link => {
        link.addEventListener("click", function () {
            filterLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
            currentTab = this.dataset.tab;
            renderNotifications();
        });
    });

    // Mark all read button
    markAllRead.addEventListener("click", () => {
        // Mark all notifications as read
        notifications.forEach(n => {
            if (n.status === 'new') {
                n.status = 'read';
            }
        });
        
        // Update badge
        updateBadge();
        
        // If we're in unread tab, switch to all tab automatically
        if (currentTab === 'unread') {
            filterLinks.forEach(l => {
                if (l.dataset.tab === 'all') {
                    l.classList.add("active");
                } else {
                    l.classList.remove("active");
                }
            });
            currentTab = 'all';
        }
        
        // Re-render notifications
        renderNotifications();
    });

    // Auto-refresh function - interval runs but doesn't change data
    function startAutoRefresh() {
        // Clear existing interval if any
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
        
        // Set new interval (every 10 seconds)
        autoRefreshInterval = setInterval(() => {
            // Auto-refresh runs but does NOT change notification data
            // It only maintains the interval functionality
            console.log(`Auto-refresh at ${new Date().toLocaleTimeString()}`);
        }, 10000); // 10 seconds
    }

    // Initial load
    loadNotifications();
    
    // Start auto-refresh (interval runs but doesn't change data)
    startAutoRefresh();
    
    // Clean up interval when page unloads
    window.addEventListener('beforeunload', () => {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    });
});