document.addEventListener('DOMContentLoaded', function() {
    const searchManagerInput = document.getElementById('searchManagerInput');
    const statusFilterBtns = document.querySelectorAll('.status-filter-btn');
    const totalCount = document.getElementById('totalCount');
    const countText = document.getElementById('countText');
    const pagination = document.getElementById('pagination');
    const paginationInfo = document.getElementById('paginationInfo');
    const managerTableBody = document.getElementById('managerTableBody');
    const mobileCardsContainer = document.getElementById('mobileCardsContainer');
    const managerTableContainer = document.querySelector('.employee-table');
    const tableHeader = document.querySelector('thead');
    const allRows = managerTableBody.querySelectorAll('tr');
    
    let currentStatusFilter = 'all';
    let currentSearchTerm = '';
    let currentPage = 1;
    let itemsPerPage = calculateItemsPerPage();
    let isMobileView = window.innerWidth < 768;
    
    // Store scroll position before pagination changes
    let scrollPositionBeforePagination = 0;
    
    // Extract employee data from table rows
    const employeeData = Array.from(allRows).map(row => {
        const nameElement = row.querySelector('.employee-name');
        const idElement = row.querySelector('.employee-id');
        const statusElement = row.querySelector('.status');
        const contactTd = row.querySelector('td:nth-child(2)');
        const addressTd = row.querySelector('td:nth-child(3)');
        const hireDateTd = row.querySelector('td:nth-child(4)');
        
        // Extract email and phone from contact column
        const contactDivs = contactTd.querySelectorAll('div');
        const email = contactDivs[0].textContent;
        const phone = contactDivs[1].textContent;
        
        // Extract address from address column
        const addressDivs = addressTd.querySelectorAll('div');
        const address = addressDivs[0].textContent;
        const city = addressDivs[1].textContent;
        
        // Get status class
        const statusClass = statusElement.className.split(' ')[1];
        
        return {
            element: row,
            name: nameElement.textContent,
            initials: nameElement.textContent.split(' ').map(n => n[0]).join(''),
            id: idElement.textContent.replace('ID: ', ''),
            email: email,
            phone: phone,
            address: address,
            city: city,
            hireDate: hireDateTd.textContent,
            status: statusClass,
            statusText: statusElement.textContent
        };
    });
    
    // Initialize mobile cards
    initializeMobileCards();
    
    // Set initial table height
    updateTableHeight();
    
    // Listen for window resize
    window.addEventListener('resize', function() {
        const wasMobile = isMobileView;
        isMobileView = window.innerWidth < 768;
        
        itemsPerPage = calculateItemsPerPage();
        updateTableHeight();
        
        // Only reset page if view type changed
        if (wasMobile !== isMobileView) {
            currentPage = 1;
        }
        
        filterAndPaginate();
    });
    
    updateTotalCount();
    attachEventListeners();
    filterAndPaginate();
    
    function initializeMobileCards() {
        mobileCardsContainer.innerHTML = '';
        employeeData.forEach((employee, index) => {
            const card = createMobileCard(employee, index);
            mobileCardsContainer.appendChild(card);
        });
    }
    
    function createMobileCard(employee, index) {
        const card = document.createElement('div');
        card.className = 'mobile-employee-card';
        card.dataset.index = index;
        card.dataset.status = employee.status;
        card.dataset.name = employee.name.toLowerCase();
        card.dataset.id = employee.id.toLowerCase();
        card.dataset.email = employee.email.toLowerCase();
        card.dataset.phone = employee.phone;
        
        card.innerHTML = `
            <div class="card-header">
                <div class="employee-name-id">
                    <div class="mobile-avatar">${employee.initials}</div>
                    <div>
                        <div class="mobile-employee-name">${employee.name}</div>
                        <div class="mobile-employee-id">ID: ${employee.id}</div>
                    </div>
                </div>
                <span class="mobile-status ${employee.status}">${employee.statusText}</span>
            </div>
            <div class="card-details">
                <div class="detail-row">
                    <span class="detail-label">Contact</span>
                    <div class="detail-value">
                        ${employee.email}
                        <small>${employee.phone}</small>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address</span>
                    <div class="detail-value">
                        ${employee.address}
                        <small>${employee.city}</small>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Hire Date</span>
                    <div class="detail-value">
                        ${employee.hireDate}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="mobile-actions">
                    <button class="mobile-action-btn mobile-edit-btn" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="mobile-action-btn mobile-delete-btn" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;
        
        return card;
    }
    
    function calculateItemsPerPage() {
        const screenHeight = window.innerHeight;
        const rowHeight = 64;
        const cardHeight = 320; // Approximate height of mobile card
        const paginationHeight = 70;
        const headerHeight = window.innerWidth < 768 ? 300 : 190;
        const bottomMargin = 10;
        
        const availableHeight = screenHeight - headerHeight - paginationHeight - bottomMargin;
        
        if (window.innerWidth < 768) {
            // SET MINIMUM TO 5 FOR MOBILE DEVICES
            const calculated = Math.floor((availableHeight * 0.9) / cardHeight);
            return Math.max(5, calculated); // Minimum 5 cards on mobile
        } else {
            return Math.max(5, Math.floor((availableHeight * 0.9) / rowHeight));
        }
    }
    
    function updateTableHeight() {
        if (window.innerWidth >= 768) {
            const rowHeight = 64;
            const maxHeight = itemsPerPage * rowHeight;
            managerTableBody.style.maxHeight = `${maxHeight}px`;
            
            const minHeight = 5 * rowHeight;
            if (maxHeight < minHeight) {
                managerTableBody.style.maxHeight = `${minHeight}px`;
            }
        }
    }
    
    function attachEventListeners() {
        searchManagerInput.addEventListener('input', function() {
            currentSearchTerm = this.value.toLowerCase().trim();
            currentPage = 1;
            filterAndPaginate();
        });
        
        statusFilterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                statusFilterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentStatusFilter = this.getAttribute('data-status');
                currentSearchTerm = '';
                currentPage = 1;
                searchManagerInput.value = '';
                filterAndPaginate();
                updateTotalCount();
            });
        });
        
        pagination.addEventListener('click', function(e) {
            // Store current scroll position for mobile
            if (window.innerWidth < 768) {
                scrollPositionBeforePagination = window.scrollY || document.documentElement.scrollTop;
            }
            
            const target = e.target.closest('.page-btn');
            if (!target || target.classList.contains('disabled')) return;
            
            const isPrev = target.innerHTML.includes('chevron-left');
            const isNext = target.innerHTML.includes('chevron-right');
            const pageNum = parseInt(target.textContent);
            
            if (isPrev) {
                if (currentPage > 1) {
                    currentPage--;
                    filterAndPaginate(true); // Pass true to maintain scroll position
                }
            } else if (isNext) {
                const visibleRows = getFilteredRows();
                const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    filterAndPaginate(true); // Pass true to maintain scroll position
                }
            } else if (!isNaN(pageNum)) {
                currentPage = pageNum;
                filterAndPaginate(true); // Pass true to maintain scroll position
            }
        });
    }
    
    function getFilteredRows() {
        if (window.innerWidth < 768) {
            // Filter mobile cards
            const cards = mobileCardsContainer.querySelectorAll('.mobile-employee-card');
            return Array.from(cards).filter(card => {
                if (currentStatusFilter !== 'all' && card.dataset.status !== currentStatusFilter) {
                    return false;
                }
                
                if (currentSearchTerm) {
                    const searchIn = currentSearchTerm.toLowerCase();
                    return card.dataset.name.includes(searchIn) || 
                        card.dataset.id.includes(searchIn) ||
                        card.dataset.email.includes(searchIn) ||
                        card.dataset.phone.includes(searchIn);
                }
                
                return true;
            });
        } else {
            // Filter desktop rows
            return employeeData.filter(employee => {
                if (currentStatusFilter !== 'all' && employee.status !== currentStatusFilter) {
                    return false;
                }
                
                if (currentSearchTerm) {
                    const searchIn = currentSearchTerm.toLowerCase();
                    return employee.name.toLowerCase().includes(searchIn) || 
                        employee.id.toLowerCase().includes(searchIn) ||
                        employee.email.toLowerCase().includes(searchIn) ||
                        employee.phone.includes(searchIn);
                }
                
                return true;
            });
        }
    }
    
    function filterAndPaginate(maintainScrollPosition = false) {
        const filteredRows = getFilteredRows();
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        // Validate current page
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        } else if (totalPages === 0) {
            currentPage = 1;
        }
        
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        if (window.innerWidth < 768) {
            // Handle mobile cards
            const allCards = mobileCardsContainer.querySelectorAll('.mobile-employee-card');
            allCards.forEach(card => card.style.display = 'none');
            
            const visibleCards = filteredRows.slice(startIndex, endIndex);
            visibleCards.forEach(card => {
                card.style.display = 'block';
            });
            
            // Show "no results" message if no cards found
            if (totalItems === 0) {
                showNoResultsMessage(true);
            } else {
                removeNoResultsMessage(true);
            }
            
            // If we're changing pages on mobile, scroll to show the cards
            if (maintainScrollPosition && visibleCards.length > 0) {
                // Wait for DOM to update
                setTimeout(() => {
                    if (window.innerWidth < 768) {
                        // For mobile, scroll to the first card of the current page
                        // or maintain previous scroll position relative to content
                        const firstVisibleCard = visibleCards[0];
                        if (firstVisibleCard) {
                            // Calculate position relative to the mobile container
                            const containerTop = mobileCardsContainer.getBoundingClientRect().top;
                            const cardTop = firstVisibleCard.getBoundingClientRect().top;
                            const scrollToPosition = window.scrollY + (cardTop - containerTop) - 20;
                            
                            window.scrollTo({
                                top: scrollToPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                }, 50);
            }
        } else {
            // Handle desktop table
            if (totalItems === 0) {
                tableHeader.style.display = 'none';
            } else {
                tableHeader.style.display = '';
            }
            
            employeeData.forEach(employee => {
                employee.element.style.display = 'none';
            });
            
            filteredRows.slice(startIndex, endIndex).forEach(employee => {
                employee.element.style.display = '';
            });
            
            // Show "no results" message if no rows found
            if (totalItems === 0) {
                showNoResultsMessage(false);
            } else {
                removeNoResultsMessage(false);
            }
            
            // For desktop, maintain the table scroll position
            if (maintainScrollPosition) {
                setTimeout(() => {
                    managerTableBody.scrollTop = 0;
                }, 10);
            }
        }
        
        updatePaginationInfo(totalItems, startIndex, endIndex);
        updateCountDisplay(totalItems);
        createPaginationButtons(totalPages);
        updateTableHeight();
    }
    
    function showNoResultsMessage(isMobile) {
        removeNoResultsMessage(isMobile);
        
        if (isMobile) {
            const noResultsMessage = document.createElement('div');
            noResultsMessage.className = 'no-results';
            noResultsMessage.innerHTML = `
                <i class="fas fa-search"></i>
                <p>No results found</p>
                <p class="small-text">
                    ${currentSearchTerm ? 'Try adjusting your search or filter to find what you\'re looking for.' : 'No manager match the selected filter.'}
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
                        <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No results found</p>
                        <p style="font-size: 0.85rem; color: var(--light-text);">
                            ${currentSearchTerm ? 'Try adjusting your search or filter to find what you\'re looking for.' : 'No manager match the selected filter.'}
                        </p>
                    </div>
                </td>
            `;
            
            managerTableBody.appendChild(noResultsRow);
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
            
            const filteredRows = getFilteredRows();
            if (filteredRows.length > 0 && window.innerWidth > 768) {
                tableHeader.style.display = '';
            }
        }
    }
    
    function updatePaginationInfo(totalItems, startIndex, endIndex) {
        const displayStart = totalItems === 0 ? 0 : startIndex + 1;
        const displayEnd = Math.min(endIndex, totalItems);
        
        if (totalItems === 0) {
            paginationInfo.textContent = '';
        } else {
            paginationInfo.textContent = `Showing ${displayStart}-${displayEnd} of ${totalItems} entries`;
        }
    }
    
    function updateCountDisplay(totalItems) {
        let countDisplay = '';
        
        if (currentStatusFilter === 'all') {
            countDisplay = `${totalItems} Total Manager`;
        } else if (currentStatusFilter === 'active') {
            countDisplay = `${totalItems} Active Manager`;
        } else if (currentStatusFilter === 'inactive') {
            countDisplay = `${totalItems} Inactive Manager`;
        } else if (currentStatusFilter === 'terminated') {
            countDisplay = `${totalItems} Terminated Manager`;
        } else if (currentStatusFilter === 'resigned') {
            countDisplay = `${totalItems} Resigned Manager`;
        }
        
        if (currentSearchTerm && totalItems > 0) {
            countDisplay += ' (Search Results)';
        }
        
        countText.textContent = countDisplay;
    }
    
    function updateTotalCount() {
        const statusCounts = {
            all: employeeData.length,
            active: employeeData.filter(emp => emp.status === 'active').length,
            inactive: employeeData.filter(emp => emp.status === 'inactive').length,
            terminated: employeeData.filter(emp => emp.status === 'terminated').length,
            resigned: employeeData.filter(emp => emp.status === 'resigned').length
        };
        
        countText.textContent = `${statusCounts.all} Total Manager`;
    }
    
    function createPaginationButtons(totalPages) {
        if (totalPages <= 1) {
            pagination.innerHTML = '';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}">
            <i class="fas fa-chevron-left"></i>
        </button>`;
        
        // Determine max visible pages based on screen width
        const screenWidth = window.innerWidth;
        const maxVisiblePages = screenWidth < 768 ? 3 : (screenWidth < 1024 ? 5 : 7);
        
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        // Always show first page
        if (startPage > 1) {
            paginationHTML += `<button class="page-btn ${1 === currentPage ? 'active' : ''}">1</button>`;
            if (startPage > 2) {
                paginationHTML += `<div class="page-ellipsis">...</div>`;
            }
        }
        
        // Show visible page numbers
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
        }
        
        // Always show last page if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `<div class="page-ellipsis">...</div>`;
            }
            paginationHTML += `<button class="page-btn ${totalPages === currentPage ? 'active' : ''}">${totalPages}</button>`;
        }
        
        // Next button
        paginationHTML += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}">
            <i class="fas fa-chevron-right"></i>
        </button>`;
        
        pagination.innerHTML = paginationHTML;
    }
});