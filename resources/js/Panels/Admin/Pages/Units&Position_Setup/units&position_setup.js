let departmentsData = [
    {
        id: 1,
        name: "Kitchen",
        stations: [
            { id: 101, name: "ASM/GRILL" },
            { id: 102, name: "Initiator" }
        ]
    },
    {
        id: 2,
        name: "Front Counter",
        stations: [
            { id: 201, name: "Counter 1" },
            { id: 202, name: "Counter 2" }
        ]
    },
    {
        id: 3,
        name: "Drive-Thru",
        stations: [
            { id: 301, name: "Counter" },
            { id: 302, name: "Presenter/Runner" }
        ]
    },
    {
        id: 4,
        name: "Delivery System",
        stations: [
            { id: 401, name: "ASM/Runner" },
            { id: 402, name: "Cashier 1" }
        ]
    }
];

let managerPositions = [
    { id: 1, name: "Service Manager" },
    { id: 2, name: "Manager In-Charge" },
    { id: 3, name: "Shift Leader" },
    { id: 4, name: "B2B" }
];

let pendingDelete = null;
let pendingEdit = null;
let searchQuery = '';

// Search functions
function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    searchQuery = searchInput.value.toLowerCase().trim();
    
    // Show/hide clear button
    if (searchQuery.length > 0) {
        clearBtn.classList.add('visible');
    } else {
        clearBtn.classList.remove('visible');
    }
    
    renderDepartments();
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    searchInput.value = '';
    searchQuery = '';
    clearBtn.classList.remove('visible');
    
    renderDepartments();
}

// Filter departments and stations based on search query
function getFilteredDepartments() {
    if (!searchQuery) return departmentsData;

    return departmentsData.filter(dept => {
        // Check if department name matches
        if (dept.name.toLowerCase().includes(searchQuery)) {
            return true;
        }
        
        // Check if any station name matches
        const matchingStations = dept.stations.filter(station => 
            station.name.toLowerCase().includes(searchQuery)
        );
        
        return matchingStations.length > 0;
    }).map(dept => {
        // If search query exists, filter stations within the department
        if (searchQuery) {
            const filteredStations = dept.stations.filter(station => 
                station.name.toLowerCase().includes(searchQuery) || 
                dept.name.toLowerCase().includes(searchQuery)
            );
            return {
                ...dept,
                stations: filteredStations
            };
        }
        return dept;
    });
}

// Update stats
function updateStats() {
    // Crew stats
    const filteredDepts = getFilteredDepartments();
    const totalDepartments = filteredDepts.length;
    const totalStations = filteredDepts.reduce((sum, dept) => sum + dept.stations.length, 0);
    
    document.getElementById('totalDepartments').textContent = totalDepartments;
    document.getElementById('totalStations').textContent = totalStations;
    
    // Manager stats
    const totalPositions = managerPositions.length;
    document.getElementById('totalPositions').textContent = totalPositions;
}

// Crew Functions
function addNewDepartment() {
    const input = document.getElementById('departmentInput');
    const name = input.value.trim();

    if (name) {
        const newDept = {
            id: Date.now(),
            name: name,
            stations: []
        };
        departmentsData.push(newDept);
        input.value = '';
        renderDepartments();
        updateStats();
    }
}

function addNewStation(departmentId) {
    const input = document.querySelector(`#stationInput-${departmentId}`);
    const name = input.value.trim();

    if (name) {
        const department = departmentsData.find(d => d.id === departmentId);
        if (department) {
            department.stations.push({
                id: Date.now(),
                name: name
            });
            input.value = '';
            renderDepartments();
            updateStats();
        }
    }
}

// Manager Functions
function addNewPosition() {
    const input = document.getElementById('positionInput');
    const name = input.value.trim();

    if (name) {
        const newPosition = {
            id: Date.now(),
            name: name
        };
        managerPositions.push(newPosition);
        input.value = '';
        renderManagerPositions();
        updateStats();
    }
}

function deletePosition(positionId) {
    const position = managerPositions.find(p => p.id === positionId);
    if (position) {
        openDeleteConfirmation('position', null, positionId, position.name);
    }
}

function editPosition(positionId) {
    const position = managerPositions.find(p => p.id === positionId);
    if (position) {
        openEditModal('position', null, positionId, position.name);
    }
}

// Common Modal Functions
function openDeleteConfirmation(type, departmentId, itemId, name) {
    pendingDelete = { type, departmentId, itemId, name };
    const modal = document.getElementById('deleteConfirmationModal');
    const message = document.getElementById('confirmationMessage');

    if (type === 'department') {
        message.textContent = `Are you sure you want to delete the department "${name}"? All stations within this department will also be removed.`;
    } else if (type === 'station') {
        message.textContent = `Are you sure you want to delete the station "${name}"?`;
    } else if (type === 'position') {
        message.textContent = `Are you sure you want to delete the position "${name}"?`;
    }

    modal.classList.add('active');
}

function closeDeleteConfirmation() {
    document.getElementById('deleteConfirmationModal').classList.remove('active');
    pendingDelete = null;
}

function performDelete() {
    if (!pendingDelete) return;

    if (pendingDelete.type === 'department') {
        departmentsData = departmentsData.filter(d => d.id !== pendingDelete.departmentId);
    } else if (pendingDelete.type === 'station') {
        const department = departmentsData.find(d => d.id === pendingDelete.departmentId);
        if (department) {
            department.stations = department.stations.filter(s => s.id !== pendingDelete.itemId);
        }
    } else if (pendingDelete.type === 'position') {
        managerPositions = managerPositions.filter(p => p.id !== pendingDelete.itemId);
    }

    closeDeleteConfirmation();
    renderDepartments();
    renderManagerPositions();
    updateStats();
}

function openEditModal(type, departmentId, itemId, currentName) {
    pendingEdit = { type, departmentId, itemId, currentName };
    const modal = document.getElementById('editItemModal');
    const label = document.getElementById('editItemLabel');
    const input = document.getElementById('editItemInput');

    if (type === 'department') {
        label.textContent = 'Department Name:';
    } else if (type === 'station') {
        label.textContent = 'Station Name:';
    } else if (type === 'position') {
        label.textContent = 'Position Title:';
    }
    
    input.value = currentName;
    setTimeout(() => {
        input.focus();
        input.select();
    }, 0);

    modal.classList.add('active');
}

function closeEditModal() {
    document.getElementById('editItemModal').classList.remove('active');
    pendingEdit = null;
}

function saveItemEdit() {
    if (!pendingEdit || !pendingEdit.currentName) return;

    const newName = document.getElementById('editItemInput').value.trim();
    if (newName && newName !== pendingEdit.currentName) {
        if (pendingEdit.type === 'department') {
            const department = departmentsData.find(d => d.id === pendingEdit.departmentId);
            if (department) department.name = newName;
        } else if (pendingEdit.type === 'station') {
            const department = departmentsData.find(d => d.id === pendingEdit.departmentId);
            if (department) {
                const station = department.stations.find(s => s.id === pendingEdit.itemId);
                if (station) station.name = newName;
            }
        } else if (pendingEdit.type === 'position') {
            const position = managerPositions.find(p => p.id === pendingEdit.itemId);
            if (position) position.name = newName;
        }
    }

    closeEditModal();
    renderDepartments();
    renderManagerPositions();
    updateStats();
}

// Render Functions
function renderDepartments() {
    const container = document.getElementById('departmentsList');
    const filteredDepartments = getFilteredDepartments();
    
    if (filteredDepartments.length === 0) {
        if (searchQuery) {
            container.innerHTML = '<div class="empty-state">No departments or stations found matching your search.</div>';
        } else {
            container.innerHTML = '<div class="empty-state">No departments have been created yet. Add your first department to get started!</div>';
        }
        container.classList.remove('departments-grid');
        return;
    }

    container.classList.add('departments-grid');
    let html = '';
    
    filteredDepartments.forEach(dept => {
        html += `
            <div class="department-card">
                <div class="department-header">
                    <h3 class="department-title">${dept.name}</h3>
                    <div class="header-actions">
                        <button class="btn-edit btn-sm" onclick="openEditModal('department', ${dept.id}, null, '${dept.name.replace(/'/g, "\\'")}')" title="Edit Department">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete btn-sm" onclick="openDeleteConfirmation('department', ${dept.id}, null, '${dept.name.replace(/'/g, "\\'")}')" title="Delete Department">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="department-content">
                    <div class="add-station-section">
                        <label class="section-label">Add Station to ${dept.name}</label>
                        <div class="input-group-row">
                            <input 
                                type="text" 
                                id="stationInput-${dept.id}" 
                                class="form-input"
                                placeholder="Enter station name"
                                onkeypress="if(event.key === 'Enter') addNewStation(${dept.id})"
                            >
                            <button class="btn btn-primary" onclick="addNewStation(${dept.id})">
                                <i class="fas fa-plus icon-add"></i>
                                <span>Add Station</span>
                            </button>
                        </div>
                    </div>`;

        if (dept.stations.length === 0) {
            html += '<p class="no-stations-message">No stations have been added to this department yet</p>';
        } else {
            html += `
                <table class="stations-table">
                    <thead>
                        <tr>
                            <th class="table-header">Station Name</th>
                            <th class="table-header-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;
            
            dept.stations.forEach(station => {
                html += `
                    <tr>
                        <td class="table-cell">
                            <span class="status-indicator"></span>
                            ${station.name}
                        </td>
                        <td class="table-cell-actions">
                            <div class="actions-cell">
                                <button class="btn-edit btn-sm" onclick="openEditModal('station', ${dept.id}, ${station.id}, '${station.name.replace(/'/g, "\\'")}')" title="Edit Station">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-delete btn-sm" onclick="openDeleteConfirmation('station', ${dept.id}, ${station.id}, '${station.name.replace(/'/g, "\\'")}')" title="Delete Station">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
            });
            
            html += `
                    </tbody>
                </table>`;
        }
        
        html += `
                </div>
            </div>`;
    });
    
    container.innerHTML = html;
}

function renderManagerPositions() {
    const container = document.getElementById('positionsList');
    
    if (managerPositions.length === 0) {
        container.innerHTML = '<div class="empty-positions">No manager positions have been added yet.</div>';
        return;
    }

    let html = '';
    
    managerPositions.forEach(position => {
        html += `
            <div class="position-item">
                <div class="position-name">${position.name}</div>
                <div class="position-actions">
                    <button class="btn-edit btn-sm" onclick="editPosition(${position.id})" title="Edit Position">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-delete btn-sm" onclick="deletePosition(${position.id})" title="Delete Position">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>`;
    });
    
    container.innerHTML = html;
}

// Initial render on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set up search input event listeners
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    
    // Check initial search value
    if (searchQuery.length > 0) {
        clearBtn.classList.add('visible');
    }
    
    // Add input event listener for real-time search
    searchInput.addEventListener('input', handleSearch);
    
    // Render initial data
    renderDepartments();
    renderManagerPositions();
    updateStats();
}); 