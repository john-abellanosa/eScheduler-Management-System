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