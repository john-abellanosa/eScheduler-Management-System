document.addEventListener("DOMContentLoaded", function () {
    function checkScreenSize() {
        const isMobile = window.innerWidth <= 768;
        const departmentSections = document.querySelectorAll(
            ".department-section"
        );

        departmentSections.forEach((section) => {
            const tableWrapper = section.querySelector(".table-wrapper");
            const table = section.querySelector("table");
            const deptStats = section.querySelector(".dept-stats");
            const emptyMessage = section.querySelector(".empty-message-inline");
            const addCrewBtn = section.querySelector(".btn-add-crew");
            const departmentHeader =
                section.querySelector(".department-header");

            // For mobile view
            if (isMobile) {
                // Hide the table
                if (tableWrapper) tableWrapper.style.display = "none";
                if (table) table.style.display = "none";

                // Create mobile header structure if not exists
                if (!section.querySelector(".header-top-row")) {
                    createMobileHeader(
                        section,
                        departmentHeader,
                        deptStats,
                        emptyMessage,
                        addCrewBtn
                    );
                }

                // Convert table rows to mobile cards if not already done
                if (
                    table &&
                    !section.querySelector(".mobile-cards-container")
                ) {
                    convertTableToCards(section, table);
                }

                // // Handle empty departments
                // const hasCrew = section.querySelector('table tbody tr');
                // if (!hasCrew && emptyMessage && !section.querySelector('.no-crew-message')) {
                //     const noCrewMessage = document.createElement('div');
                //     noCrewMessage.className = 'no-crew-message';
                //     noCrewMessage.innerHTML = '<i class="fas fa-inbox"></i> NO CREW PLOTTED FOR THIS DEPARTMENT';
                //     section.appendChild(noCrewMessage);
                // }
            }
            // For desktop view
            else {
                // Show the table
                if (tableWrapper) {
                    tableWrapper.style.display = "block";
                }
                if (table) table.style.display = "table";

                // Remove mobile header elements
                const mobileHeaderElements = section.querySelectorAll(
                    ".header-top-row, .mobile-add-crew-btn, .dept-stats.mobile-stats, .empty-message-inline.mobile-empty"
                );
                mobileHeaderElements.forEach((el) => el.remove());

                // Remove mobile cards
                const mobileCards = section.querySelector(
                    ".mobile-cards-container"
                );
                if (mobileCards) mobileCards.remove();

                // Remove no crew message if exists
                const noCrewMessage = section.querySelector(".no-crew-message");
                if (noCrewMessage) noCrewMessage.remove();

                // Ensure original elements are visible
                if (deptStats) deptStats.style.display = "flex";
                if (emptyMessage) emptyMessage.style.display = "flex";
                if (addCrewBtn) addCrewBtn.style.display = "flex";
            }
        });
    }

    // Function to create mobile header layout
    function createMobileHeader(
        section,
        departmentHeader,
        deptStats,
        emptyMessage,
        addCrewBtn
    ) {
        const topRow = document.createElement("div");
        topRow.className = "header-top-row";

        // Get just the department title element, not the entire header-content-left
        const departmentTitle =
            departmentHeader.querySelector(".department-title");
        const blueDot = departmentHeader.querySelector(".blue-dot");

        // Create new left content for mobile
        const mobileLeftContent = document.createElement("div");
        mobileLeftContent.style.display = "flex";
        mobileLeftContent.style.alignItems = "center";
        mobileLeftContent.style.gap = "8px";
        mobileLeftContent.style.flex = "1";

        // Clone blue dot if exists
        if (blueDot) {
            const clonedBlueDot = blueDot.cloneNode(true);
            mobileLeftContent.appendChild(clonedBlueDot);
        }

        // Clone department title if exists
        if (departmentTitle) {
            const clonedTitle = departmentTitle.cloneNode(true);
            // Remove any styling classes that might cause full width
            clonedTitle.style.margin = "0";
            clonedTitle.style.padding = "8px 10px";
            clonedTitle.style.fontSize = "13px";
            mobileLeftContent.appendChild(clonedTitle);
        }

        topRow.appendChild(mobileLeftContent);

        // Create mobile add crew button
        if (addCrewBtn) {
            const mobileAddBtn = addCrewBtn.cloneNode(true);
            mobileAddBtn.className = "mobile-add-crew-btn";
            mobileAddBtn.onclick = addCrewBtn.onclick;
            topRow.appendChild(mobileAddBtn);
        }

        // Insert top row at beginning of department header
        departmentHeader.insertBefore(topRow, departmentHeader.firstChild);

        // Create mobile department stats if they exist
        if (deptStats) {
            const mobileStats = deptStats.cloneNode(true);
            mobileStats.classList.add("mobile-stats");
            departmentHeader.appendChild(mobileStats);
        }

        // Create mobile empty message if it exists
        if (emptyMessage && !section.querySelector("table tbody tr")) {
            const mobileEmptyMsg = emptyMessage.cloneNode(true);
            mobileEmptyMsg.classList.add("mobile-empty");
            departmentHeader.appendChild(mobileEmptyMsg);
        }

        // Hide the original header-content-left on mobile
        const originalHeaderLeft = departmentHeader.querySelector(
            ".header-content-left"
        );
        if (originalHeaderLeft) {
            originalHeaderLeft.style.display = "none";
        }
    }

    // Function to convert table rows to mobile cards
    function convertTableToCards(section, table) {
        const tbody = table.querySelector("tbody");
        if (!tbody || tbody.children.length === 0) return;

        const cardsContainer = document.createElement("div");
        cardsContainer.className = "mobile-cards-container";

        // Check if this is the manager section
        const isManagerSection = section.closest(".manager-section") !== null;

        // Convert each row to a card
        Array.from(tbody.children).forEach((row) => {
            const cells = row.children;
            if (cells.length < 5) return; // Skip if not enough cells

            // Create card
            const card = document.createElement("div");
            card.className = "mobile-crew-card";

            // Extract data from table row
            const crewName = cells[0].textContent.trim();
            const station = cells[1].innerHTML;
            const breakTime = cells[2].innerHTML;
            const hours = cells[3].innerHTML;
            const totalHours = cells[4].textContent.trim();

            // Create card HTML - conditionally include actions for non-manager sections
            let cardHTML = `
                        <div class="crew-card-header">
                            <div class="crew-name">${crewName}</div>
                            <div class="mobile-total-hours">${totalHours}</div>
                        </div>
                        <div class="crew-card-body">
                            <div class="crew-detail-item">
                                <div class="detail-label">Station</div>
                                <div class="detail-value">${station}</div>
                            </div>
                            <div class="crew-detail-item">
                                <div class="detail-label">Break Time</div>
                                <div class="detail-value">${breakTime}</div>
                            </div>
                            <div class="crew-detail-item">
                                <div class="detail-label">Shift Hours</div>
                                <div class="detail-value">${hours}</div>
                            </div>
                        </div>`;

            // Only add footer with actions for non-manager sections
            if (!isManagerSection) {
                cardHTML += `
                            <div class="crew-card-footer">
                                <div class="mobile-actions">
                                    <button class="mobile-action-btn mobile-edit-btn" onclick="editCrew('${crewName}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="mobile-action-btn mobile-delete-btn" onclick="deleteCrew('${crewName}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>`;
            }

            card.innerHTML = cardHTML;
            cardsContainer.appendChild(card);
        });

        // Add cards container to section
        const tableWrapper = section.querySelector(".table-wrapper");
        if (tableWrapper) {
            section.insertBefore(cardsContainer, tableWrapper.nextSibling);
        } else {
            section.appendChild(cardsContainer);
        }
    }

    // Initialize on load and resize
    window.addEventListener("DOMContentLoaded", checkScreenSize);
    window.addEventListener("resize", checkScreenSize);

    // Initial check
    checkScreenSize();
});
