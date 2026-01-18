document.addEventListener('DOMContentLoaded', function() {
const searchInput = document.getElementById('searchInput');
const clearSearchBtn = document.getElementById('clearSearchBtn');
const statusFilterBtns = document.querySelectorAll('.status-filter-btn');
const totalCount = document.getElementById('totalCount');
const countText = document.getElementById('countText');
const pagination = document.getElementById('pagination');
const paginationInfo = document.getElementById('paginationInfo');
const shiftTableBody = document.getElementById('shiftTableBody');
const mobileCardsContainer = document.getElementById('mobileCardsContainer');
const tableHeader = document.querySelector('thead');
const allRows = shiftTableBody.querySelectorAll('tr');

// Week filter elements
const prevWeekBtn = document.getElementById('prevWeekBtn');
const nextWeekBtn = document.getElementById('nextWeekBtn');
const weekDisplay = document.getElementById('weekDisplay');
const datePicker = document.getElementById('datePicker');

// Variables
let currentStatusFilter = 'all';
let currentSearchTerm = '';
let currentPage = 1;
let itemsPerPage = 10;
let isMobileView = window.innerWidth < 768;
let isSearching = false;
let currentWeekOffset = 0;
let currentWeekStart = null;
let currentWeekEnd = null;
let shiftData = [];
let showAllDaysInWeek = true;

// Initialize
initializeData();
updateWeekDisplay();
initializeMobileCards();
updateTableHeight();
attachEventListeners();
filterAndPaginate();
updateCountDisplay();

function initializeData() {
    shiftData = Array.from(allRows).map((row, index) => {
        const nameElement = row.querySelector('.employee-name');
        const idElement = row.querySelector('.employee-id');
        const statusElement = row.querySelector('.status-badge');
        const positionElement = row.querySelector('.position');
        const dateTd = row.querySelector('td:nth-child(3)');
        const shiftTimeTd = row.querySelector('td:nth-child(4)');
        const hoursTd = row.querySelector('td:nth-child(5)');
        
        const shiftRange = shiftTimeTd.querySelector('.shift-range').textContent;
        const breakTime = shiftTimeTd.querySelector('.break-time')?.textContent.replace('Break: ', '') || '';
        
        // Get status from class name
        const statusClass = statusElement.className;
        let statusValue = 'present';
        if (statusClass.includes('status-awol')) statusValue = 'awol';
        else if (statusClass.includes('status-extended')) statusValue = 'extended';
        else if (statusClass.includes('status-early-in')) statusValue = 'early-in';
        else if (statusClass.includes('status-early-out')) statusValue = 'early-out';
        
        // Get position from class name
        const positionClass = positionElement.className;
        let positionType = 'service-manager';
        if (positionClass.includes('manager-in-charge')) positionType = 'manager-in-charge';
        else if (positionClass.includes('shift-leader')) positionType = 'shift-leader';
        else if (positionClass.includes('expediter')) positionType = 'expediter';
        else if (positionClass.includes('b2b')) positionType = 'b2b';
        
        // Parse date from table text
        const dateText = dateTd.textContent;
        const dateParts = dateText.split(' ');
        const month = getMonthNumber(dateParts[0]);
        const day = parseInt(dateParts[1].replace(',', ''));
        const year = parseInt(dateParts[2]);
        const dateObj = new Date(year, month, day);
        
        return {
            element: row,
            name: nameElement.textContent,
            initials: nameElement.textContent.split(' ').map(n => n[0]).join(''),
            id: idElement.textContent.replace('ID: ', ''),
            position: positionElement.textContent,
            positionType: positionType,
            date: dateText,
            dateObj: dateObj,
            shiftRange: shiftRange,
            breakTime: breakTime,
            totalHours: hoursTd.querySelector('.total-hours').textContent,
            status: statusValue,
            statusText: statusElement.textContent
        };
    });
}

function getMonthNumber(monthName) {
    const months = {
        'January': 0, 'February': 1, 'March': 2, 'April': 3, 'May': 4, 'June': 5,
        'July': 6, 'August': 7, 'September': 8, 'October': 9, 'November': 10, 'December': 11
    };
    return months[monthName] || 0;
}

function getStartOfWeek(date) {
    const d = new Date(date);
    const day = d.getUTCDay(); // 0 = Sunday
    const diff = d.getUTCDate() - day;
    const start = new Date(Date.UTC(d.getUTCFullYear(), d.getUTCMonth(), diff));
    return start;
}

function getEndOfWeek(startDate) {
    const end = new Date(startDate);
    end.setUTCDate(startDate.getUTCDate() + 6);
    end.setUTCHours(23, 59, 59, 999);
    return end;
}

function updateWeekDisplay() {
    const now = new Date();
    const adjustedDate = new Date(now);
    adjustedDate.setDate(now.getDate() + (currentWeekOffset * 7));
    
    currentWeekStart = getStartOfWeek(adjustedDate);
    currentWeekEnd = getEndOfWeek(currentWeekStart);
    
    // Format for display
    const options = { month: 'short', day: 'numeric' };
    const weekStartStr = currentWeekStart.toLocaleDateString('en-US', options);
    const weekEndStr = currentWeekEnd.toLocaleDateString('en-US', options);
    const year = currentWeekStart.getFullYear();
    
    weekDisplay.textContent = `${weekStartStr}-${weekEndStr}, ${year}`;
    
    // Set date picker bounds
    const startDateStr = formatDate(currentWeekStart);
    const endDateStr = formatDate(currentWeekEnd);
    
    datePicker.min = startDateStr;
    datePicker.max = endDateStr;
    
    // Clear the date picker to show all days in week by default
    datePicker.value = "";
    showAllDaysInWeek = true;
}

function formatDate(date) {
    // Use UTC to avoid timezone issues
    const year = date.getUTCFullYear();
    const month = String(date.getUTCMonth() + 1).padStart(2, '0');
    const day = String(date.getUTCDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function initializeMobileCards() {
    mobileCardsContainer.innerHTML = '';
    shiftData.forEach((shift, index) => {
        const card = createMobileCard(shift, index);
        mobileCardsContainer.appendChild(card);
    });
}

function createMobileCard(shift, index) {
    const card = document.createElement('div');
    card.className = 'mobile-shift-card';
    card.dataset.index = index;
    card.dataset.status = shift.status;
    card.dataset.name = shift.name.toLowerCase();
    card.dataset.id = shift.id.toLowerCase();
    card.dataset.position = shift.position.toLowerCase();
    card.dataset.positionType = shift.positionType;
    card.dataset.date = shift.date.toLowerCase();
    card.dataset.shiftrange = shift.shiftRange.toLowerCase();
    card.dataset.totalhours = shift.totalHours.toLowerCase();
    card.dataset.statustext = shift.statusText.toLowerCase();
    card.dataset.fullsearch = (
        shift.name.toLowerCase() + ' ' +
        shift.id.toLowerCase() + ' ' +
        shift.position.toLowerCase() + ' ' +
        shift.date.toLowerCase() + ' ' +
        shift.shiftRange.toLowerCase() + ' ' +
        shift.totalHours.toLowerCase() + ' ' +
        shift.statusText.toLowerCase()
    ).replace(/\s+/g, ' ').trim();
    
    // Determine mobile status class
    let mobileStatusClass = 'mobile-status-present';
    if (shift.status === 'awol') mobileStatusClass = 'mobile-status-awol';
    else if (shift.status === 'extended') mobileStatusClass = 'mobile-status-extended';
    else if (shift.status === 'early-in') mobileStatusClass = 'mobile-status-early-in';
    else if (shift.status === 'early-out') mobileStatusClass = 'mobile-status-early-out';
    
    // Determine position class for mobile
    let mobilePositionClass = 'mobile-position-service-manager';
    if (shift.positionType === 'manager-in-charge') mobilePositionClass = 'mobile-position-manager-in-charge';
    else if (shift.positionType === 'shift-leader') mobilePositionClass = 'mobile-position-shift-leader';
    else if (shift.positionType === 'expediter') mobilePositionClass = 'mobile-position-expediter';
    else if (shift.positionType === 'b2b') mobilePositionClass = 'mobile-position-b2b';
    
    card.innerHTML = `
        <div class="card-header">
            <div class="employee-name-id">
                <div class="mobile-avatar">${shift.initials}</div>
                <div class="name-info">
                    <div class="mobile-employee-name">${shift.name}</div>
                    <div class="mobile-employee-id">ID: ${shift.id}</div>
                </div>
            </div>
            <span class="mobile-status-badge ${mobileStatusClass}">${shift.statusText}</span>
        </div>
        <div class="card-details">
            <div class="detail-row">
                <span class="detail-label">Position</span>
                <span class="detail-value ${mobilePositionClass}">${shift.position}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date</span>
                <span class="detail-value">${shift.date}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Hours</span>
                <span class="detail-value">${shift.totalHours}</span>
            </div>
        </div>
        <div class="card-footer">
            <div class="shift-info">
                <span class="info-label">Shift Time</span>
                <div class="shift-time-mobile">
                    <span class="shift-range-mobile">${shift.shiftRange}</span>
                    <span class="break-time-mobile">Break: ${shift.breakTime}</span>
                </div>
            </div>
        </div>
    `;
    
    return card;
}

function updateTableHeight() {
    if (window.innerWidth >= 768) {
        const rowHeight = 64;
        const maxHeight = itemsPerPage * rowHeight;
        shiftTableBody.style.maxHeight = `${maxHeight}px`;
        
        const minHeight = 5 * rowHeight;
        if (maxHeight < minHeight) {
            shiftTableBody.style.maxHeight = `${minHeight}px`;
        }
    }
}

function attachEventListeners() {
    // Search input
    searchInput.addEventListener('input', function() {
        currentSearchTerm = this.value.toLowerCase().trim();
        isSearching = currentSearchTerm.length > 0;
        
        if (currentSearchTerm.length > 0) {
            clearSearchBtn.style.display = 'flex';
        } else {
            clearSearchBtn.style.display = 'none';
        }
        
        currentPage = 1;
        filterAndPaginate();
    });
    
    // Clear search button
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        currentSearchTerm = '';
        isSearching = false;
        clearSearchBtn.style.display = 'none';
        currentPage = 1;
        filterAndPaginate();
    });
    
    // Status filter buttons
    statusFilterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            statusFilterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentStatusFilter = this.getAttribute('data-status');
            currentPage = 1;
            filterAndPaginate();
            updateCountDisplay();
        });
    });
    
    // Week navigation
    prevWeekBtn.addEventListener('click', function() {
        currentWeekOffset--;
        updateWeekDisplay();
        currentPage = 1;
        filterAndPaginate();
    });
    
    nextWeekBtn.addEventListener('click', function() {
        currentWeekOffset++;
        updateWeekDisplay();
        currentPage = 1;
        filterAndPaginate();
    });
    
    // Date picker
    datePicker.addEventListener('change', function() {
        if (this.value === "") {
            showAllDaysInWeek = true;
        } else {
            showAllDaysInWeek = false;
            const selectedDate = new Date(this.value);
            if (selectedDate < currentWeekStart) {
                this.value = formatDate(currentWeekStart);
            } else if (selectedDate > currentWeekEnd) {
                this.value = formatDate(currentWeekEnd);
            }
        }
        currentPage = 1;
        filterAndPaginate();
    });
    
    // Pagination
    pagination.addEventListener('click', function(e) {
        const target = e.target.closest('.page-btn');
        if (!target || target.classList.contains('disabled')) return;
        
        const isPrev = target.innerHTML.includes('chevron-left');
        const isNext = target.innerHTML.includes('chevron-right');
        const pageNum = parseInt(target.textContent);
        
        if (isPrev) {
            if (currentPage > 1) {
                currentPage--;
                filterAndPaginate(true);
            }
        } else if (isNext) {
            const visibleRows = getFilteredRows();
            const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                filterAndPaginate(true);
            }
        } else if (!isNaN(pageNum)) {
            currentPage = pageNum;
            filterAndPaginate(true);
        }
    });
    
    // Window resize
    window.addEventListener('resize', function() {
        const wasMobile = isMobileView;
        isMobileView = window.innerWidth < 768;
        
        itemsPerPage = calculateItemsPerPage();
        updateTableHeight();
        
        if (wasMobile !== isMobileView) {
            currentPage = 1;
        }
        
        filterAndPaginate();
    });
}

function calculateItemsPerPage() {
    const screenHeight = window.innerHeight;
    if (window.innerWidth < 768) {
        return 5;
    } else {
        const rowHeight = 64;
        const headerHeight = 280;
        const paginationHeight = 70;
        const bottomMargin = 20;
        
        const availableHeight = screenHeight - headerHeight - paginationHeight - bottomMargin;
        const calculatedItems = Math.max(5, Math.floor(availableHeight / rowHeight));
        return calculatedItems;
    }
}

function getFilteredRows() {
    const filteredData = shiftData.filter(shift => {
        // 1. Week filter
        const shiftWeekStart = getStartOfWeek(shift.dateObj);
        const shiftWeekStartStr = formatDate(shiftWeekStart);
        const currentWeekStartStr = formatDate(currentWeekStart);
        
        if (currentWeekStartStr !== shiftWeekStartStr) {
            return false;
        }
        
        // 2. Date filter
        if (!showAllDaysInWeek && datePicker.value !== "") {
            const selectedDate = new Date(datePicker.value);
            const selectedDateStr = formatDate(selectedDate);
            const shiftDateStr = formatDate(shift.dateObj);
            
            if (shiftDateStr !== selectedDateStr) {
                return false;
            }
        }
        
        // 3. Status filter
        if (currentStatusFilter !== 'all' && shift.status !== currentStatusFilter) {
            return false;
        }
        
        // 4. Search filter
        if (currentSearchTerm) {
            const searchIn = currentSearchTerm.toLowerCase();
            return (
                shift.name.toLowerCase().includes(searchIn) || 
                shift.id.toLowerCase().includes(searchIn) ||
                shift.position.toLowerCase().includes(searchIn) ||
                shift.date.toLowerCase().includes(searchIn) ||
                shift.shiftRange.toLowerCase().includes(searchIn) ||
                shift.totalHours.toLowerCase().includes(searchIn) ||
                shift.statusText.toLowerCase().includes(searchIn)
            );
        }
        
        return true;
    });
    
    return filteredData;
}

function filterAndPaginate(maintainScrollPosition = false) {
    const filteredRows = getFilteredRows();
    const totalItems = filteredRows.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    
    if (currentPage > totalPages && totalPages > 0) {
        currentPage = totalPages;
    } else if (totalPages === 0) {
        currentPage = 1;
    }
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    if (window.innerWidth < 768) {
        // Mobile view
        const allCards = mobileCardsContainer.querySelectorAll('.mobile-shift-card');
        let visibleCount = 0;
        
        allCards.forEach((card, index) => {
            const shift = shiftData[index];
            if (!shift) {
                card.style.display = 'none';
                return;
            }
            
            const shiftWeekStart = getStartOfWeek(shift.dateObj);
            const shiftWeekStartStr = formatDate(shiftWeekStart);
            const currentWeekStartStr = formatDate(currentWeekStart);
            
            let shouldShow = true;
            
            // 1. Week filter
            if (currentWeekStartStr !== shiftWeekStartStr) {
                shouldShow = false;
            }
            // 2. Date filter
            else if (!showAllDaysInWeek && datePicker.value !== "") {
                const selectedDate = new Date(datePicker.value);
                const selectedDateStr = formatDate(selectedDate);
                const shiftDateStr = formatDate(shift.dateObj);
                
                if (shiftDateStr !== selectedDateStr) {
                    shouldShow = false;
                }
            }
            // 3. Status filter
            else if (currentStatusFilter !== 'all' && shift.status !== currentStatusFilter) {
                shouldShow = false;
            }
            // 4. Search filter
            else if (currentSearchTerm) {
                const searchIn = currentSearchTerm.toLowerCase();
                if (!card.dataset.fullsearch.includes(searchIn)) {
                    shouldShow = false;
                }
            }
            
            // Apply pagination
            if (shouldShow && visibleCount >= startIndex && visibleCount < endIndex) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
                if (shouldShow) visibleCount++;
            }
        });
        
        // Show/hide no results message
        if (totalItems === 0) {
            showNoResultsMessage(true);
        } else {
            removeNoResultsMessage(true);
        }
        
    } else {
        // Desktop view
        if (totalItems === 0) {
            tableHeader.style.display = 'none';
        } else {
            tableHeader.style.display = '';
        }
        
        // Hide all rows first
        shiftData.forEach(shift => {
            shift.element.style.display = 'none';
        });
        
        // Show only filtered rows for current page
        filteredRows.slice(startIndex, endIndex).forEach(shift => {
            shift.element.style.display = '';
        });
        
        // Show/hide no results message
        if (totalItems === 0) {
            showNoResultsMessage(false);
        } else {
            removeNoResultsMessage(false);
        }
        
        if (maintainScrollPosition) {
            setTimeout(() => {
                shiftTableBody.scrollTop = 0;
            }, 10);
        }
    }
    
    // Update UI
    updatePaginationInfo(totalItems, startIndex, endIndex);
    updateCountDisplay();
    createPaginationButtons(totalPages);
    updateTableHeight();
    
    document.querySelector('.pagination-container').style.display = 'flex';
}

function showNoResultsMessage(isMobile) {
    removeNoResultsMessage(isMobile);
    
    if (isMobile) {
        const noResultsMessage = document.createElement('div');
        noResultsMessage.className = 'no-results';
        noResultsMessage.innerHTML = `
            <i class="fas fa-search"></i>
            <p>No shift records found</p>
            <p class="small-text">
                ${currentSearchTerm ? `No shifts found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No shift records match the selected filter.'}
            </p>
        `;
        mobileCardsContainer.appendChild(noResultsMessage);
    } else {
        const noResultsRow = document.createElement('tr');
        noResultsRow.className = 'no-results-message';
        noResultsRow.innerHTML = `
            <td colspan="6">
                <div style="text-align: center; padding: 40px 20px; color: var(--light-text);">
                    <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--border-color); display: block;"></i>
                    <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No shift records found</p>
                    <p style="font-size: 0.85rem; color: var(--light-text);">
                        ${currentSearchTerm ? `No shifts found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No shift records match the selected filter.'}
                    </p>
                </div>
            </td>
        `;
        shiftTableBody.appendChild(noResultsRow);
    }
}

function removeNoResultsMessage(isMobile) {
    if (isMobile) {
        const existingMessage = mobileCardsContainer.querySelector('.no-results');
        if (existingMessage) {
            existingMessage.remove();
        }
    } else {
        const existingMessage = document.querySelector('.no-results-message');
        if (existingMessage) {
            existingMessage.remove();
        }
    }
}

function updatePaginationInfo(totalItems, startIndex, endIndex) {
    const displayStart = totalItems === 0 ? 0 : startIndex + 1;
    const displayEnd = Math.min(endIndex, totalItems);
    
    if (totalItems === 0) {
        paginationInfo.textContent = 'No records found';
    } else {
        paginationInfo.textContent = `Showing ${displayStart}-${displayEnd} of ${totalItems} shifts`;
    }
}

function updateCountDisplay() {
    const filteredRows = getFilteredRows();
    const totalItems = filteredRows.length;
    
    if (isSearching) {
        countText.textContent = `${totalItems} Search Results`;
    } else if (currentStatusFilter === 'all') {
        countText.textContent = `${totalItems} Total Shifts`;
    } else {
        const statusText = currentStatusFilter.charAt(0).toUpperCase() + currentStatusFilter.slice(1);
        countText.textContent = `${totalItems} ${statusText}`;
    }
}

function createPaginationButtons(totalPages) {
    const paginationContainer = document.querySelector('.pagination-container');
    if (paginationContainer) {
        paginationContainer.style.display = 'flex';
    }
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}">
        <i class="fas fa-chevron-left"></i>
    </button>`;
    
    // Always show first page
    paginationHTML += `<button class="page-btn ${1 === currentPage ? 'active' : ''}">1</button>`;
    
    // Show middle pages if more than 2 pages
    if (totalPages > 2) {
        if (currentPage > 3) {
            paginationHTML += `<span class="page-ellipsis">...</span>`;
        }
        
        // Show current page and surrounding pages
        let startPage = Math.max(2, currentPage - 1);
        let endPage = Math.min(totalPages - 1, currentPage + 1);
        
        for (let i = startPage; i <= endPage; i++) {
            if (i > 1 && i < totalPages) {
                paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
            }
        }
        
        if (currentPage < totalPages - 2) {
            paginationHTML += `<span class="page-ellipsis">...</span>`;
        }
    }
    
    // Always show last page if more than 1 page
    if (totalPages > 1) {
        paginationHTML += `<button class="page-btn ${totalPages === currentPage ? 'active' : ''}">${totalPages}</button>`;
    }
    
    // Next button
    paginationHTML += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}">
        <i class="fas fa-chevron-right"></i>
    </button>`;
    
    pagination.innerHTML = paginationHTML;
    
    const container = document.querySelector('.pagination-container');
    if (container) {
        container.style.visibility = 'visible';
        container.style.opacity = '1';
    }
}

// Initialize with calculated items per page
itemsPerPage = calculateItemsPerPage();
filterAndPaginate();
});