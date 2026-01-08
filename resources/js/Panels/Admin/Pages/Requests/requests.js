document.addEventListener("DOMContentLoaded", function () {
const colors = {
    primaryBlue: '#1a3a8f',
    secondaryBlue: '#2a56d6',
    lightBlue: '#eef2ff',
    darkText: '#333333',
    lightText: '#666666',
    pending: '#ff9800',
    approved: '#28a745',
    rejected: '#dc3545',
    leave: '#17a2b8',
    swap: '#ffc107',
    give: '#6f42c1'
};

const requests = [
    {
        id: 1,
        name: 'Sarah Johnson',
        role: 'Crew Member',
        status: 'pending',
        type: 'leave',
        title: 'Annual Leave Request',
        reason: 'I am requesting annual leave for a planned family vacation. My shifts have been reviewed and I am open to adjustments if needed.',
        period: 'Jan 20 - Jan 25, 2024',
        related: 'Shift A1 - Morning',
        submitted: '2 hours ago',
        employeeId: 'FF012'
    },
    {
        id: 2,
        name: 'Mike Chen',
        role: 'Manager',
        status: 'pending',
        type: 'swap',
        title: 'Schedule Swap Request',
        reason: 'I am requesting a schedule swap due to an urgent family matter. The employee involved has already agreed to the change.',
        period: 'Jan 22, 2024',
        related: 'Swap with John Doe (Shift B2 ↔ B3)',
        submitted: '1 day ago',
        employeeId: 'MG003'
    },
    {
        id: 3,
        name: 'Emma Wilson',
        role: 'Manager',
        status: 'pending',
        type: 'give',
        title: 'Give Schedule',
        reason: 'I would like to give my assigned shift to another employee due to a prior personal commitment on that date.',
        period: 'Jan 25, 2024',
        related: 'Saturday Morning Shift',
        submitted: '2 days ago',
        employeeId: 'MG005'
    },
    {
        id: 4,
        name: 'John Davis',
        role: 'Crew Member',
        status: 'approved',
        type: 'leave',
        title: 'Medical Leave Request',
        reason: 'I am requesting medical leave as advised by my doctor. Supporting documents have been submitted for verification.',
        period: 'Feb 1 - Feb 10, 2024',
        related: 'Shift C2 - Afternoon',
        submitted: '3 days ago',
        employeeId: 'FF015'
    },
    {
        id: 5,
        name: 'Lisa Anderson',
        role: 'Manager',
        status: 'rejected',
        type: 'swap',
        title: 'Weekend Shift Swap',
        reason: 'I requested a weekend shift swap due to a personal obligation. However, I understand the operational constraints that led to this request being declined.',
        period: 'Jan 15, 2024',
        related: 'Swap with Tom Brown (Weekend A)',
        submitted: '1 week ago',
        employeeId: 'MG007'
    },
    {
        id: 6,
        name: 'David Miller',
        role: 'Crew Member',
        status: 'pending',
        type: 'leave',
        title: 'Emergency Leave',
        reason: 'I am requesting emergency leave due to an unexpected family situation. I will provide any required documentation as soon as possible.',
        period: 'Jan 18 - Jan 20, 2024',
        related: 'Shift D3 - Night',
        submitted: '5 hours ago',
        employeeId: 'FF018'
    },
    {
        id: 7,
        name: 'Robert Taylor',
        role: 'Crew Member',
        status: 'approved',
        type: 'give',
        title: 'Give Schedule',
        reason: 'I am offering my scheduled shift to another team member who is available and willing to take additional hours.',
        period: 'Dec 24, 2024',
        related: 'Night Shift Coverage',
        submitted: '2 weeks ago',
        employeeId: 'FF022'
    },
    {
        id: 8,
        name: 'Jessica Brown',
        role: 'Manager',
        status: 'pending',
        type: 'swap',
        title: 'Department Swap',
        reason: 'I am requesting a temporary department swap to support cross-training and operational needs during the specified period.',
        period: 'Mar 1 - Mar 15, 2024',
        related: 'Cross-department training',
        submitted: 'Yesterday',
        employeeId: 'MG012'
    },
    {
        id: 9,
        name: 'Michael Scott',
        role: 'Crew Member',
        status: 'pending',
        type: 'leave',
        title: 'Family Emergency',
        reason: 'Need to attend to a family emergency out of town.',
        period: 'Feb 5 - Feb 7, 2024',
        related: 'Shift E4 - Evening',
        submitted: '3 hours ago',
        employeeId: 'FF025'
    },
    {
        id: 10,
        name: 'Pam Beesly',
        role: 'Manager',
        status: 'approved',
        type: 'swap',
        title: 'Shift Exchange',
        reason: 'Exchanging shifts with coworker for personal appointment.',
        period: 'Feb 10, 2024',
        related: 'Swap with Jim Halpert',
        submitted: '2 days ago',
        employeeId: 'MG015'
    },
    {
        id: 11,
        name: 'Dwight Schrute',
        role: 'Crew Member',
        status: 'pending',
        type: 'give',
        title: 'Offer Shift',
        reason: 'Available to cover additional shifts this weekend.',
        period: 'Feb 11-12, 2024',
        related: 'Weekend Coverage',
        submitted: '1 day ago',
        employeeId: 'FF028'
    },
    {
        id: 12,
        name: 'Jim Halpert',
        role: 'Crew Member',
        status: 'rejected',
        type: 'leave',
        title: 'Personal Day',
        reason: 'Requesting personal day for important errands.',
        period: 'Feb 15, 2024',
        related: 'Day Shift',
        submitted: '4 days ago',
        employeeId: 'FF030'
    }
];

// Pagination variables
let currentPage = 1;
let totalPages = 1;
let filteredRequests = [];
let isGridView = false;
let isMobile = false;

let filters = {
    status: 'all',
    type: 'all',
    search: ''
};

// DOM Elements
let listViewBtn, gridViewBtn, requestsList, requestsGrid;
let desktopSearchInput, desktopSearchClear, mobileSearchInput, mobileSearchClear;
let paginationInfo, pagination;

// Initialize DOM elements
function initializeDOMElements() {
    listViewBtn = document.getElementById('listViewBtn');
    gridViewBtn = document.getElementById('gridViewBtn');
    requestsList = document.getElementById('requestsList');
    requestsGrid = document.getElementById('requestsGrid');
    desktopSearchInput = document.getElementById('desktopSearchInput');
    desktopSearchClear = document.getElementById('desktopSearchClear');
    mobileSearchInput = document.getElementById('mobileSearchInput');
    mobileSearchClear = document.getElementById('mobileSearchClear');
    paginationInfo = document.getElementById('paginationInfo');
    pagination = document.getElementById('pagination');
}

// Calculate items per page based on viewport and view type
function calculateItemsPerPage() {
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;
    
    // Update mobile detection
    isMobile = screenWidth <= 768;
    
    if (isMobile) {
        // Mobile - calculate based on screen height
        const cardHeight = isGridView ? 320 : 180; // Grid cards are taller than list cards
        const headerHeight = 350; // Approximate header height
        const paginationHeight = 70;
        const availableHeight = screenHeight - headerHeight - paginationHeight - 50;
        const items = Math.floor(availableHeight / cardHeight);
        
        // Return reasonable range for mobile
        return Math.max(4, Math.min(items, 8));
    } else if (isGridView) {
        // Desktop Grid View - Calculate based on available space
        const gridCardHeight = 280;
        const headerHeight = 250;
        const paginationHeight = 70;
        
        const availableHeight = screenHeight - headerHeight - paginationHeight - 50;
        const rows = Math.floor(availableHeight / gridCardHeight);
        
        let columns;
        if (screenWidth >= 1200) {
            columns = 3;
        } else if (screenWidth >= 900) {
            columns = 2;
        } else {
            columns = 1;
        }
        
        const items = rows * columns;
        return Math.max(6, Math.min(items, 12));
    } else {
        // Desktop List View - Fixed at 5 items
        return 5;
    }
}

// Get items per page
let itemsPerPage = calculateItemsPerPage();

// View preference key for localStorage
const VIEW_PREFERENCE_KEY = 'request-management-view-preference';

// Get saved view preference or default to 'list'
function getSavedViewPreference() {
    const savedPreference = localStorage.getItem(VIEW_PREFERENCE_KEY);
    return savedPreference === 'grid' ? 'grid' : 'list';
}

// Save view preference to localStorage
function saveViewPreference(viewType) {
    localStorage.setItem(VIEW_PREFERENCE_KEY, viewType);
}

// View Switching with persistence
function switchView(isGrid) {
    // Save current scroll position
    const scrollPosition = window.scrollY;
    const oldPage = currentPage;
    
    isGridView = isGrid;
    const oldItemsPerPage = itemsPerPage;
    itemsPerPage = calculateItemsPerPage();
    
    // Recalculate current page to maintain approximate position
    if (oldItemsPerPage !== itemsPerPage) {
        const firstItemIndex = (oldPage - 1) * oldItemsPerPage;
        currentPage = Math.max(1, Math.floor(firstItemIndex / itemsPerPage) + 1);
    }
    
    if (isGridView) {
        requestsList.style.display = 'none';
        requestsGrid.classList.add('active');
        requestsGrid.style.display = 'grid';
        listViewBtn.classList.remove('active');
        gridViewBtn.classList.add('active');
        saveViewPreference('grid');
    } else {
        requestsList.style.display = 'flex';
        requestsGrid.classList.remove('active');
        requestsGrid.style.display = 'none';
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        saveViewPreference('list');
    }
    
    // Re-render requests when switching views
    renderRequests();
    
    // Restore scroll position after render
    setTimeout(() => {
        window.scrollTo(0, scrollPosition);
    }, 50);
}

// Initialize view based on saved preference
function initializeView() {
    const savedView = getSavedViewPreference();
    const isGrid = savedView === 'grid';
    switchView(isGrid);
}

// Utility Functions
function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').toUpperCase();
}

function getStatusBadgeClass(status) {
    switch(status) {
        case 'pending': return 'badge-pending';
        case 'approved': return 'badge-approved';
        case 'rejected': return 'badge-rejected';
        default: return 'badge-pending';
    }
}

function getTypeIcon(type) {
    switch(type) {
        case 'leave': return '<i class="fas fa-umbrella-beach" style="color: var(--primary-blue);"></i>';
        case 'swap': return '<i class="fas fa-exchange-alt" style="color: var(--primary-blue);"></i>';
        case 'give': return '<i class="fas fa-calendar-plus" style="color: var(--primary-blue);"></i>';
        default: return '<i class="fas fa-file-alt" style="color: var(--primary-blue);"></i>';
    }
}

function getTypeLabel(type) {
    switch(type) {
        case 'leave': return 'Leave Request';
        case 'swap': return 'Schedule Swap';
        case 'give': return 'Give Schedule';
        default: return 'Request';
    }
}

// Card Creation Functions
function createListCard(req) {
    const statusClass = getStatusBadgeClass(req.status);
    
    return `
        <div class="request-card-list" data-id="${req.id}" data-status="${req.status}" data-type="${req.type}">
            <div class="request-card-header">
                <div class="user-info-section">
                    <div class="avatar">${getInitials(req.name)}</div>
                    <div class="user-details">
                        <div class="user-details-row">
                            <p class="request-name">${req.name}</p>
                        </div>
                        <div class="user-details-row">
                            <span class="request-role">${req.role}</span>
                        </div>
                    </div>
                </div>
                
                <div class="status-position">
                    <span class="badge ${statusClass}">${req.status.toUpperCase()}</span>
                </div>
            </div>
            
            <div class="request-content">
                <div class="request-type-section">
                    <div class="request-type-list">
                        ${getTypeIcon(req.type)}
                        <span>${req.title}</span>
                    </div>
                </div>
                
                <p class="request-reason">${req.reason}</p>
                
                <div class="request-meta">
                    <span class="meta-item">
                        <i class="far fa-calendar"></i>
                        ${req.period}
                    </span>
                    <span class="meta-item">
                        <i class="far fa-clock"></i>
                        ${req.submitted}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-id-card"></i>
                        ID: ${req.employeeId}
                    </span>
                
                    <div class="list-actions">
                        ${req.status === 'pending' ? `
                            <button class="list-btn approve" onclick="window.requestManager.handleApprove(${req.id})" title="Approve Request">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="list-btn reject" onclick="window.requestManager.handleReject(${req.id})" title="Reject Request">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                        <button class="list-btn view" onclick="window.requestManager.viewRequestDetails(${req.id})" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function createGridCard(req) {
    const statusClass = getStatusBadgeClass(req.status);
    
    return `
        <div class="request-card-grid" data-id="${req.id}" data-status="${req.status}" data-type="${req.type}">
            <div class="card-header-grid">
                <div class="card-avatar-section">
                    <div class="avatar">${getInitials(req.name)}</div>
                    <div class="card-details">
                        <p class="request-name">${req.name}</p>
                        <span class="request-role">${req.role}</span>
                    </div>
                </div>
                <div>
                    <span class="badge ${statusClass}">${req.status.toUpperCase()}</span>
                </div>
            </div>
            
            <div class="card-content">
                <div class="card-type">
                    ${getTypeIcon(req.type)}
                    <span>${req.title}</span>
                </div>
                
                <p class="card-reason">${req.reason}</p>
                
                <div class="card-meta">
                    <div><i class="far fa-calendar"></i> ${req.period}</div>
                    <div><i class="far fa-clock"></i> ${req.submitted}</div>
                    <div><i class="fas fa-id-card"></i> ID: ${req.employeeId}</div>
                </div>
            </div>
            
            <div class="card-actions-container">
                <div class="card-actions">
                    ${req.status === 'pending' ? `
                        <button class="card-btn approve" onclick="window.requestManager.handleApprove(${req.id})" title="Approve Request">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="card-btn reject" onclick="window.requestManager.handleReject(${req.id})" title="Reject Request">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                    <button class="card-btn view" onclick="window.requestManager.viewRequestDetails(${req.id})" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Search Functions
function updateClearButton(inputElement, clearButton) {
    if (inputElement.value.trim() !== '') {
        clearButton.style.display = 'flex';
    } else {
        clearButton.style.display = 'none';
    }
}

function clearSearch(inputElement, clearButton) {
    inputElement.value = '';
    clearButton.style.display = 'none';
    filters.search = '';
    currentPage = 1;
    renderRequests();
}

function handleSearchInput(inputElement, clearButton) {
    updateClearButton(inputElement, clearButton);
    filters.search = inputElement.value.trim().toLowerCase();
    currentPage = 1;
    renderRequests();
}

// Filter Functions
function filterRequests() {
    filteredRequests = requests.filter(req => {
        const statusMatch = filters.status === 'all' || req.status === filters.status;
        const typeMatch = filters.type === 'all' || req.type === filters.type;
        const searchMatch = !filters.search || 
            req.name.toLowerCase().includes(filters.search) ||
            req.role.toLowerCase().includes(filters.search) ||
            req.title.toLowerCase().includes(filters.search) ||
            req.reason.toLowerCase().includes(filters.search) ||
            req.employeeId.toLowerCase().includes(filters.search) ||
            req.period.toLowerCase().includes(filters.search) ||
            req.submitted.toLowerCase().includes(filters.search) ||
            req.related.toLowerCase().includes(filters.search);
        
        return statusMatch && typeMatch && searchMatch;
    });
    
    return filteredRequests;
}

// Pagination Functions
function getPaginatedRequests() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return filteredRequests.slice(startIndex, endIndex);
}

function updatePaginationInfo() {
    const totalItems = filteredRequests.length;
    const startIndex = (currentPage - 1) * itemsPerPage + 1;
    const endIndex = Math.min(currentPage * itemsPerPage, totalItems);
    
    if (totalItems === 0) {
        paginationInfo.textContent = 'Showing 0 entries';
    } else {
        paginationInfo.textContent = `Showing ${startIndex}-${endIndex} of ${totalItems} entries`;
    }
    
    totalPages = Math.ceil(totalItems / itemsPerPage);
}

function updatePagination() {
    // Clear pagination buttons
    pagination.innerHTML = '';
    
    if (totalPages <= 1) {
        // No pagination needed if only 1 page
        return;
    }
    
    // Previous button
    const prevButton = document.createElement('button');
    prevButton.className = 'page-btn' + (currentPage === 1 ? ' disabled' : '');
    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevButton.disabled = currentPage === 1;
    prevButton.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            renderRequests();
            if (isMobile) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });
    pagination.appendChild(prevButton);
    
    // Calculate which pages to show based on screen width
    const screenWidth = window.innerWidth;
    let maxVisiblePages;
    
    if (screenWidth <= 768) {
        maxVisiblePages = 3;
    } else if (screenWidth <= 1024) {
        maxVisiblePages = 5;
    } else {
        maxVisiblePages = 7;
    }
    
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    // Adjust if we're near the end
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    // First page button if needed
    if (startPage > 1) {
        const firstPageButton = createPageButton(1);
        pagination.appendChild(firstPageButton);
        
        if (startPage > 2) {
            const ellipsis = document.createElement('div');
            ellipsis.className = 'page-ellipsis';
            ellipsis.textContent = '...';
            pagination.appendChild(ellipsis);
        }
    }
    
    // Page buttons
    for (let i = startPage; i <= endPage; i++) {
        const pageButton = createPageButton(i);
        pagination.appendChild(pageButton);
    }
    
    // Last page button if needed
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const ellipsis = document.createElement('div');
            ellipsis.className = 'page-ellipsis';
            ellipsis.textContent = '...';
            pagination.appendChild(ellipsis);
        }
        
        const lastPageButton = createPageButton(totalPages);
        pagination.appendChild(lastPageButton);
    }
    
    // Next button
    const nextButton = document.createElement('button');
    nextButton.className = 'page-btn' + (currentPage === totalPages ? ' disabled' : '');
    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            renderRequests();
            if (isMobile) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });
    pagination.appendChild(nextButton);
}

function createPageButton(pageNumber) {
    const button = document.createElement('button');
    button.className = 'page-btn' + (currentPage === pageNumber ? ' active' : '');
    button.textContent = pageNumber;
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const oldPage = currentPage;
        currentPage = pageNumber;
        
        if (oldPage !== pageNumber) {
            renderRequests();
            if (isMobile) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });
    return button;
}

function renderRequests() {
    filteredRequests = filterRequests();
    const paginated = getPaginatedRequests();
    
    updatePaginationInfo();
    updatePagination();
    
    if (filteredRequests.length === 0) {
        requestsList.innerHTML = `
            <div class="empty-state full-width">
                <i class="fas fa-inbox"></i>
                <h3>No Requests Found</h3>
                <p>${filters.search ? `No requests found for "${filters.search}". Try adjusting your search.` : 'No requests match your current filters. Try adjusting your filter criteria.'}</p>
            </div>
        `;
        
        requestsGrid.innerHTML = `
            <div class="empty-state full-width">
                <i class="fas fa-inbox"></i>
                <h3>No Requests Found</h3>
                <p>${filters.search ? `No requests found for "${filters.search}". Try adjusting your search.` : 'No requests match your current filters. Try adjusting your filter criteria.'}</p>
            </div>
        `;
        
        updateStats();
        return;
    }
    
    requestsList.innerHTML = '';
    requestsGrid.innerHTML = '';
    
    paginated.forEach(req => {
        const listCard = createListCard(req);
        const gridCard = createGridCard(req);
        
        requestsList.innerHTML += listCard;
        requestsGrid.innerHTML += gridCard;
    });
    
    updateStats();
}

function updateStats() {
    const pendingCount = requests.filter(r => r.status === 'pending').length;
    const leaveCount = requests.filter(r => r.type === 'leave').length;
    const swapCount = requests.filter(r => r.type === 'swap').length;
    const giveCount = requests.filter(r => r.type === 'give').length;
    
    const pendingElement = document.querySelector('[data-type="pending"] .stat-value');
    const leaveElement = document.querySelector('[data-type="leave"] .stat-value');
    const swapElement = document.querySelector('[data-type="swap"] .stat-value');
    const giveElement = document.querySelector('[data-type="give"] .stat-value');
    
    if (pendingElement) pendingElement.textContent = pendingCount;
    if (leaveElement) leaveElement.textContent = leaveCount;
    if (swapElement) swapElement.textContent = swapCount;
    if (giveElement) giveElement.textContent = giveCount;
}

// Action Handlers
function handleApprove(id) {
    const req = requests.find(r => r.id === id);
    if (req && req.status === 'pending') {
        if (confirm(`Approve request from ${req.name}?\n\n${req.title}\n${req.reason}`)) {
            req.status = 'approved';
            renderRequests();
            showToast('Request approved successfully', 'success');
        }
    }
}

function handleReject(id) {
    const req = requests.find(r => r.id === id);
    if (req && req.status === 'pending') {
        if (confirm(`Reject request from ${req.name}?\n\n${req.title}\n${req.reason}`)) {
            req.status = 'rejected';
            renderRequests();
            showToast('Request rejected', 'warning');
        }
    }
}

function viewRequestDetails(id) {
    const req = requests.find(r => r.id === id);
    if (req) {
        alert(`Request Details:\n\nEmployee: ${req.name} (${req.employeeId})\nRole: ${req.role}\nType: ${getTypeLabel(req.type)}\nStatus: ${req.status.toUpperCase()}\nTitle: ${req.title}\nReason: ${req.reason}\nPeriod: ${req.period}\nSubmitted: ${req.submitted}\nRelated: ${req.related}`);
    }
}

function showToast(message, type = 'info') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.request-toast');
    existingToasts.forEach(toast => toast.remove());
    
    const toast = document.createElement('div');
    toast.className = 'request-toast';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${type === 'success' ? colors.approved : colors.rejected};
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    toast.innerHTML = `
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Filter button click handler
function handleFilterClick(e, isMobile = false) {
    const filterType = e.target.dataset.filter;
    const value = e.target.dataset.value;

    if (!filterType || !value) return;

    const desktopSelector = isMobile ? '.mobile-filter-btn' : '.filter-btn';
    const allButtons = document.querySelectorAll(`${desktopSelector}[data-filter="${filterType}"]`);
    
    allButtons.forEach(b => {
        b.classList.remove('active');
    });
    e.target.classList.add('active');

    filters[filterType] = value;
    currentPage = 1;
    
    if (!isMobile) {
        const mobileButtons = document.querySelectorAll(`.mobile-filter-btn[data-filter="${filterType}"]`);
        mobileButtons.forEach(b => {
            b.classList.remove('active');
            if (b.dataset.value === value) {
                b.classList.add('active');
            }
        });
    } else {
        const desktopButtons = document.querySelectorAll(`.filter-btn[data-filter="${filterType}"]`);
        desktopButtons.forEach(b => {
            b.classList.remove('active');
            if (b.dataset.value === value) {
                b.classList.add('active');
            }
        });
    }
    
    renderRequests();
}

// Set up event listeners
function setupEventListeners() {
    if (!listViewBtn || !gridViewBtn) return;
    
    listViewBtn.addEventListener('click', () => switchView(false));
    gridViewBtn.addEventListener('click', () => switchView(true));

    if (desktopSearchInput && desktopSearchClear) {
        desktopSearchInput.addEventListener('input', () => {
            handleSearchInput(desktopSearchInput, desktopSearchClear);
            if (mobileSearchInput) {
                mobileSearchInput.value = desktopSearchInput.value;
                updateClearButton(mobileSearchInput, mobileSearchClear);
            }
        });

        desktopSearchClear.addEventListener('click', () => {
            clearSearch(desktopSearchInput, desktopSearchClear);
            if (mobileSearchInput) {
                mobileSearchInput.value = '';
                updateClearButton(mobileSearchInput, mobileSearchClear);
            }
        });
    }

    if (mobileSearchInput && mobileSearchClear) {
        mobileSearchInput.addEventListener('input', () => {
            handleSearchInput(mobileSearchInput, mobileSearchClear);
            if (desktopSearchInput) {
                desktopSearchInput.value = mobileSearchInput.value;
                updateClearButton(desktopSearchInput, desktopSearchClear);
            }
        });

        mobileSearchClear.addEventListener('click', () => {
            clearSearch(mobileSearchInput, mobileSearchClear);
            if (desktopSearchInput) {
                desktopSearchInput.value = '';
                updateClearButton(desktopSearchInput, desktopSearchClear);
            }
        });
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', (e) => handleFilterClick(e, false));
    });

    document.querySelectorAll('.mobile-filter-btn').forEach(btn => {
        btn.addEventListener('click', (e) => handleFilterClick(e, true));
    });
}

// Handle window resize with debounce
let resizeTimeout;
function handleResize() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        // Save current state
        const scrollPosition = window.scrollY;
        const oldPage = currentPage;
        const oldItemsPerPage = itemsPerPage;
        
        // Recalculate items per page
        itemsPerPage = calculateItemsPerPage();
        
        // Recalculate current page to maintain viewing position
        if (oldItemsPerPage !== itemsPerPage) {
            const firstItemIndex = (oldPage - 1) * oldItemsPerPage;
            currentPage = Math.max(1, Math.floor(firstItemIndex / itemsPerPage) + 1);
        }
        
        // Re-render with new calculations
        renderRequests();
        
        // Restore scroll position
        setTimeout(() => {
            window.scrollTo(0, scrollPosition);
        }, 100);
    }, 250);
}

// Initialize everything
function initialize() {
    initializeDOMElements();
    setupEventListeners();
    initializeView();
    renderRequests();

    if (desktopSearchInput && desktopSearchClear) {
        updateClearButton(desktopSearchInput, desktopSearchClear);
    }
    if (mobileSearchInput && mobileSearchClear) {
        updateClearButton(mobileSearchInput, mobileSearchClear);
    }
}

// Add CSS for animations if not already present
function addAnimationStyles() {
    if (!document.getElementById('request-animation-styles')) {
        const style = document.createElement('style');
        style.id = 'request-animation-styles';
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// Public API for the module
const requestManager = {
    init: function() {
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                addAnimationStyles();
                initialize();
            });
        } else {
            addAnimationStyles();
            initialize();
        }
    },
    
    handleApprove,
    handleReject,
    viewRequestDetails,
    
    switchView: function(isGrid) {
        switchView(isGrid);
    },
    
    clearViewPreference: function() {
        localStorage.removeItem(VIEW_PREFERENCE_KEY);
    },
    
    getState: function() {
        return {
            currentPage,
            totalPages,
            itemsPerPage,
            filteredRequests,
            isGridView,
            filters,
            isMobile
        };
    }
};

// Make it available globally for onclick events
window.requestManager = requestManager;

// Initialize when script loads if DOM is already ready
if (document.readyState !== 'loading') {
    requestManager.init();
} else {
    document.addEventListener('DOMContentLoaded', () => {
        requestManager.init();
    });
}

// Export for ES modules (Vite compatibility)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = requestManager;
} else if (typeof define === 'function' && define.amd) {
    define([], function() {
        return requestManager;
    });
}
});