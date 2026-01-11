document.addEventListener("DOMContentLoaded", function () {
    const searchAvailabilityInput = document.getElementById(
        "searchAvailabilityInput"
    );
    const clearSearchBtn = document.getElementById("clearSearchBtn");
    const pagination = document.getElementById("pagination");
    const paginationInfo = document.getElementById("paginationInfo");
    const availabilityTableBody = document.getElementById(
        "availabilityTableBody"
    );
    const mobileCardsContainer = document.getElementById(
        "mobileCardsContainer"
    );
    const availabilityTableContainer = document.querySelector(
        ".availability-table"
    );
    const tableHeader = document.querySelector("thead");
    const allRows = availabilityTableBody.querySelectorAll("tr");

    let currentSearchTerm = "";
    let currentPage = 1;
    let itemsPerPage = calculateItemsPerPage();
    let isMobileView = window.innerWidth < 768;
    let isSearching = false;

    // Extract availability data from table rows
    const availabilityData = Array.from(allRows).map((row) => {
        const nameElement = row.querySelector(".crew-name");
        const idElement = row.querySelector(".crew-id");
        const avatarElement = row.querySelector(".avatar");
        const sundayElement = row.querySelector("td:nth-child(2)");
        const mondayElement = row.querySelector("td:nth-child(3)");
        const tuesdayElement = row.querySelector("td:nth-child(4)");
        const wednesdayElement = row.querySelector("td:nth-child(5)");
        const thursdayElement = row.querySelector("td:nth-child(6)");
        const fridayElement = row.querySelector("td:nth-child(7)");
        const saturdayElement = row.querySelector("td:nth-child(8)");

        const initials = avatarElement.textContent;
        const name = nameElement.textContent;
        const id = idElement.textContent.replace("ID: ", "");

        return {
            element: row,
            name: name,
            initials: initials,
            id: id,
            sunday: sundayElement.textContent,
            monday: mondayElement.textContent,
            tuesday: tuesdayElement.textContent,
            wednesday: wednesdayElement.textContent,
            thursday: thursdayElement.textContent,
            friday: fridayElement.textContent,
            saturday: saturdayElement.textContent,
        };
    });

    // Initialize mobile cards
    initializeMobileCards();

    // Set initial table height
    updateTableHeight();

    // Listen for window resize
    window.addEventListener("resize", function () {
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

    // Initialize count display
    attachEventListeners();
    filterAndPaginate();

    function initializeMobileCards() {
        mobileCardsContainer.innerHTML = "";
        availabilityData.forEach((crew, index) => {
            const card = createMobileCard(crew, index);
            mobileCardsContainer.appendChild(card);
        });
    }

    function createMobileCard(crew, index) {
        const card = document.createElement("div");
        card.className = "mobile-availability-card";
        card.dataset.index = index;
        card.dataset.name = crew.name.toLowerCase();
        card.dataset.id = crew.id.toLowerCase();

        // Create searchable data attribute
        const searchData = [
            crew.name.toLowerCase(),
            crew.id.toLowerCase(),
            crew.sunday.toLowerCase(),
            crew.monday.toLowerCase(),
            crew.tuesday.toLowerCase(),
            crew.wednesday.toLowerCase(),
            crew.thursday.toLowerCase(),
            crew.friday.toLowerCase(),
            crew.saturday.toLowerCase(),
        ].join(" ");

        card.dataset.fullsearch = searchData.replace(/\s+/g, " ").trim();

        card.innerHTML = `
                            <div class="card-header">
                                <div class="crew-name-id">
                                    <div class="mobile-avatar">${crew.initials}</div>
                                    <div>
                                        <div class="mobile-crew-name">${crew.name}</div>
                                        <div class="mobile-crew-id">ID: ${crew.id}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mobile-days-grid">
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Sunday</span>
                                    <span class="mobile-day-value">${crew.sunday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Monday</span>
                                    <span class="mobile-day-value">${crew.monday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Tuesday</span>
                                    <span class="mobile-day-value">${crew.tuesday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Wednesday</span>
                                    <span class="mobile-day-value">${crew.wednesday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Thursday</span>
                                    <span class="mobile-day-value">${crew.thursday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Friday</span>
                                    <span class="mobile-day-value">${crew.friday}</span>
                                </div>
                                <div class="mobile-day-row">
                                    <span class="mobile-day-label">Saturday</span>
                                    <span class="mobile-day-value">${crew.saturday}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="mobile-actions">
                                    <button class="mobile-action-btn mobile-edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('${crew.id}', '${crew.name}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="mobile-action-btn mobile-delete-btn" title="Delete Availability">
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
        const cardHeight = 420; // Approximate height of mobile card with days
        const paginationHeight = 70;
        const headerHeight = window.innerWidth < 768 ? 180 : 85;
        const bottomMargin = 10;

        const availableHeight =
            screenHeight - headerHeight - paginationHeight - bottomMargin;

        if (window.innerWidth < 768) {
            const calculated = Math.floor((availableHeight * 0.9) / cardHeight);
            return Math.max(3, calculated);
        } else {
            return Math.max(5, Math.floor((availableHeight * 0.9) / rowHeight));
        }
    }

    function updateTableHeight() {
        if (window.innerWidth >= 768) {
            const rowHeight = 64;
            const maxHeight = itemsPerPage * rowHeight;
            availabilityTableBody.style.maxHeight = `${maxHeight}px`;

            const minHeight = 5 * rowHeight;
            if (maxHeight < minHeight) {
                availabilityTableBody.style.maxHeight = `${minHeight}px`;
            }
        }
    }

    function attachEventListeners() {
        searchAvailabilityInput.addEventListener("input", function () {
            currentSearchTerm = this.value.toLowerCase().trim();
            isSearching = currentSearchTerm.length > 0;

            // Show/hide clear button based on input
            if (currentSearchTerm.length > 0) {
                clearSearchBtn.style.display = "flex";
            } else {
                clearSearchBtn.style.display = "none";
            }

            currentPage = 1;
            filterAndPaginate();
        });

        // Clear search button functionality
        clearSearchBtn.addEventListener("click", function () {
            searchAvailabilityInput.value = "";
            currentSearchTerm = "";
            isSearching = false;
            clearSearchBtn.style.display = "none";
            currentPage = 1;
            filterAndPaginate();
        });

        pagination.addEventListener("click", function (e) {
            const target = e.target.closest(".page-btn");
            if (!target || target.classList.contains("disabled")) return;

            const isPrev = target.innerHTML.includes("chevron-left");
            const isNext = target.innerHTML.includes("chevron-right");
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

        // Add event listener for Enter key in search
        searchAvailabilityInput.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                filterAndPaginate();
            }
        });
    }

    function getFilteredRows() {
        const filteredData = availabilityData.filter((crew) => {
            // Apply search filter if there's a search term
            if (currentSearchTerm) {
                const searchIn = currentSearchTerm.toLowerCase();

                // Search in all fields
                return (
                    crew.name.toLowerCase().includes(searchIn) ||
                    crew.id.toLowerCase().includes(searchIn) ||
                    crew.sunday.toLowerCase().includes(searchIn) ||
                    crew.monday.toLowerCase().includes(searchIn) ||
                    crew.tuesday.toLowerCase().includes(searchIn) ||
                    crew.wednesday.toLowerCase().includes(searchIn) ||
                    crew.thursday.toLowerCase().includes(searchIn) ||
                    crew.friday.toLowerCase().includes(searchIn) ||
                    crew.saturday.toLowerCase().includes(searchIn)
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
            const allCards = mobileCardsContainer.querySelectorAll(
                ".mobile-availability-card"
            );
            allCards.forEach((card) => (card.style.display = "none"));

            const visibleCards = Array.from(allCards).filter((card) => {
                // Apply search filter
                if (currentSearchTerm) {
                    const searchIn = currentSearchTerm.toLowerCase();
                    // Search in the combined data attribute
                    return card.dataset.fullsearch.includes(searchIn);
                }

                return true;
            });

            visibleCards.slice(startIndex, endIndex).forEach((card) => {
                card.style.display = "block";
            });

            // Show "no results" message if no cards found
            if (totalItems === 0) {
                showNoResultsMessage(true);
            } else {
                removeNoResultsMessage(true);
            }
        } else {
            // Handle desktop table
            if (totalItems === 0) {
                tableHeader.style.display = "none";
            } else {
                tableHeader.style.display = "";
            }

            availabilityData.forEach((crew) => {
                crew.element.style.display = "none";
            });

            filteredRows.slice(startIndex, endIndex).forEach((crew) => {
                crew.element.style.display = "";
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
                    availabilityTableBody.scrollTop = 0;
                }, 10);
            }
        }

        updatePaginationInfo(totalItems, startIndex, endIndex);
        createPaginationButtons(totalPages);
        updateTableHeight();
    }

    function showNoResultsMessage(isMobile) {
        removeNoResultsMessage(isMobile);

        if (isMobile) {
            const noResultsMessage = document.createElement("div");
            noResultsMessage.className = "no-results";
            noResultsMessage.innerHTML = `
                            <i class="fas fa-search"></i>
                            <p>No results found</p>
                            <p class="small-text">
                                ${
                                    currentSearchTerm
                                        ? `No crew found for "${currentSearchTerm}". Try adjusting your search.`
                                        : "No crew available."
                                }
                            </p>
                        `;

            mobileCardsContainer.appendChild(noResultsMessage);
        } else {
            const noResultsRow = document.createElement("tr");
            noResultsRow.className = "no-results-message";
            noResultsRow.innerHTML = `
                            <td colspan="9">
                                <div style="text-align: center; padding: 40px 20px; color: var(--light-text);">
                                    <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--border-color); display: block;"></i>
                                    <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No results found</p>
                                    <p style="font-size: 0.85rem; color: var(--light-text);">
                                        ${
                                            currentSearchTerm
                                                ? `No crew found for "${currentSearchTerm}". Try adjusting your search.`
                                                : "No crew available."
                                        }
                                    </p>
                                </div>
                            </td>
                        `;

            availabilityTableBody.appendChild(noResultsRow);
        }
    }

    function removeNoResultsMessage(isMobile) {
        if (isMobile) {
            const existingMessage =
                mobileCardsContainer.querySelector(".no-results");
            if (existingMessage) {
                existingMessage.remove();
            }
        } else {
            const existingMessage = document.querySelector(
                ".no-results-message"
            );
            if (existingMessage) {
                existingMessage.remove();
            }

            const filteredRows = getFilteredRows();
            if (filteredRows.length > 0 && window.innerWidth > 768) {
                tableHeader.style.display = "";
            }
        }
    }

    function updatePaginationInfo(totalItems, startIndex, endIndex) {
        const displayStart = totalItems === 0 ? 0 : startIndex + 1;
        const displayEnd = Math.min(endIndex, totalItems);

        if (totalItems === 0) {
            paginationInfo.textContent = "";
        } else {
            paginationInfo.textContent = `Showing ${displayStart}-${displayEnd} of ${totalItems} entries`;
        }
    }

    function createPaginationButtons(totalPages) {
        if (totalPages <= 1) {
            pagination.innerHTML = "";
            return;
        }

        let paginationHTML = "";

        // Previous button
        paginationHTML += `<button class="page-btn ${
            currentPage === 1 ? "disabled" : ""
        }">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>`;

        // Determine max visible pages based on screen width
        const screenWidth = window.innerWidth;
        const maxVisiblePages =
            screenWidth < 768 ? 3 : screenWidth < 1024 ? 5 : 7;

        let startPage = Math.max(
            1,
            currentPage - Math.floor(maxVisiblePages / 2)
        );
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Always show first page
        if (startPage > 1) {
            paginationHTML += `<button class="page-btn ${
                1 === currentPage ? "active" : ""
            }">1</button>`;
            if (startPage > 2) {
                paginationHTML += `<div class="page-ellipsis">...</div>`;
            }
        }

        // Show visible page numbers
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `<button class="page-btn ${
                i === currentPage ? "active" : ""
            }">${i}</button>`;
        }

        // Always show last page if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `<div class="page-ellipsis">...</div>`;
            }
            paginationHTML += `<button class="page-btn ${
                totalPages === currentPage ? "active" : ""
            }">${totalPages}</button>`;
        }

        // Next button
        paginationHTML += `<button class="page-btn ${
            currentPage === totalPages ? "disabled" : ""
        }">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>`;

        pagination.innerHTML = paginationHTML;
    }
});
