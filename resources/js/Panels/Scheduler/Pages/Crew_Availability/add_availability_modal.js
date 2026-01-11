
const timeSuggestions = [
    "6am", "7am", "8am", "9am", "10am", "11am", "12pm",
    "1pm", "2pm", "3pm", "4pm", "5pm", "6pm", "7pm", "8pm",
    "6:30am", "7:30am", "8:30am", "9:30am",
    "12:30pm", "1:30pm", "2:30pm", "3:30pm", "4:30pm", "5:30pm",
    "Not Available", "Off"
];

const DAYS = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];

// ============================================
// TIME OPTION SELECTION
// ============================================
function selectTimeOption(day, option) {
    const timeOptions = document.querySelectorAll(`.time-option[data-day="${day}"]`);
    const customWrapper = document.getElementById(`${day}Custom`);
    const hiddenInput = document.getElementById(`${day}Time`);

    timeOptions.forEach((btn) => {
        if (btn.getAttribute("data-value") === option) {
            btn.classList.add("active");
        } else {
            btn.classList.remove("active");
        }
    });

    if (option === "custom") {
        customWrapper.style.display = "block";
        hiddenInput.value = "";
    } else if (option === "flex") {
        customWrapper.style.display = "none";
        hiddenInput.value = "Flex";
        document.getElementById(`${day}Start`).value = "";
        document.getElementById(`${day}End`).value = "";
    } else {
        customWrapper.style.display = "none";
        hiddenInput.value = "";
    }
}

// ============================================
// TIME SUGGESTIONS
// ============================================
function showTimeSuggestions(inputId) {
    const input = document.getElementById(inputId);
    const suggestionsId = `${inputId}Suggestions`;
    const suggestions = document.getElementById(suggestionsId);

    if (!input || !suggestions) return;

    suggestions.innerHTML = "";
    const inputValue = input.value.toLowerCase();
    const filtered = timeSuggestions.filter((time) =>
        time.toLowerCase().includes(inputValue)
    );

    filtered.forEach((time) => {
        const div = document.createElement("div");
        div.className = "time-suggestion";
        div.textContent = time;
        div.addEventListener("click", () => {
            input.value = time;
            suggestions.style.display = "none";
            updateHiddenTimeInput(inputId.replace("Start", "").replace("End", ""));
        });
        suggestions.appendChild(div);
    });

    suggestions.style.display = filtered.length > 0 ? "block" : "none";
}

function validateTimeInput(inputId) {
    const input = document.getElementById(inputId);
    const value = input.value.trim();

    if (!value) return;

    const timeRegex = /^([1-9]|1[0-2])(:[0-5][0-9])?(am|pm)$/i;
    const specialRegex = /^(not available|n\/a|na|off|none)$/i;

    if (!timeRegex.test(value) && !specialRegex.test(value)) {
        input.style.borderColor = "#dc2626";
        input.style.boxShadow = "0 0 0 2px rgba(220, 38, 38, 0.1)";
    } else {
        input.style.borderColor = "#10b981";
        input.style.boxShadow = "0 0 0 2px rgba(16, 185, 129, 0.1)";
    }

    updateHiddenTimeInput(inputId.replace("Start", "").replace("End", ""));
}

function updateHiddenTimeInput(day) {
    const startInput = document.getElementById(`${day}Start`);
    const endInput = document.getElementById(`${day}End`);
    const hiddenInput = document.getElementById(`${day}Time`);
    const timeOptions = document.querySelectorAll(`.time-option[data-day="${day}"]`);
    const isFlexSelected = timeOptions[0].classList.contains("active");

    if (isFlexSelected) {
        hiddenInput.value = "Flex";
    } else if (startInput && startInput.value && endInput && endInput.value) {
        hiddenInput.value = `${startInput.value}-${endInput.value}`;
    } else if (startInput && startInput.value) {
        hiddenInput.value = startInput.value;
    } else {
        hiddenInput.value = "";
    }
}

// ============================================
// QUICK ACTIONS
// ============================================
function setAllDays(value) {
    DAYS.forEach((day) => {
        if (value === "flex") {
            selectTimeOption(day, "flex");
        }
    });
}

function clearAllDays() {
    DAYS.forEach((day) => {
        const timeOptions = document.querySelectorAll(`.time-option[data-day="${day}"]`);
        timeOptions.forEach((btn) => btn.classList.remove("active"));

        const customWrapper = document.getElementById(`${day}Custom`);
        if (customWrapper) customWrapper.style.display = "none";

        const startInput = document.getElementById(`${day}Start`);
        const endInput = document.getElementById(`${day}End`);
        if (startInput) startInput.value = "";
        if (endInput) endInput.value = "";

        const hiddenInput = document.getElementById(`${day}Time`);
        if (hiddenInput) hiddenInput.value = "";
    });
}

function initAvailabilityModal() {
    clearAllDays();
}

// ============================================
// MODAL FUNCTIONS
// ============================================
function openAddAvailabilityModal() {
    const modal = document.getElementById("availabilityModal");
    const modalTitle = document.getElementById("modalTitle");
    const form = document.getElementById("availabilityForm");

    modalTitle.textContent = "Add Crew Availability";
    form.reset();
    document.getElementById("availabilityId").value = "";
    initAvailabilityModal();

    modal.style.display = "block";
    document.body.style.overflow = "hidden";
}

function openEditAvailabilityModal(crewId, crewName) {
    const modal = document.getElementById("availabilityModal");
    const modalTitle = document.getElementById("modalTitle");
    const form = document.getElementById("availabilityForm");

    modalTitle.textContent = `Edit Availability - ${crewName}`;
    document.getElementById("crewSelect").value = crewId;
    document.getElementById("availabilityId").value = crewId;
    initAvailabilityModal();

    if (crewId === "CR001") {
        selectTimeOption("sunday", "custom");
        document.getElementById("sundayStart").value = "6pm";
        document.getElementById("sundayEnd").value = "12am";
        updateHiddenTimeInput("sunday");

        selectTimeOption("monday", "custom");
        document.getElementById("mondayStart").value = "9am";
        document.getElementById("mondayEnd").value = "5pm";
        updateHiddenTimeInput("monday");

        selectTimeOption("tuesday", "flex");

        selectTimeOption("wednesday", "custom");
        document.getElementById("wednesdayStart").value = "9am";
        document.getElementById("wednesdayEnd").value = "5pm";
        updateHiddenTimeInput("wednesday");

        selectTimeOption("thursday", "custom");
        document.getElementById("thursdayStart").value = "9am";
        document.getElementById("thursdayEnd").value = "5pm";
        updateHiddenTimeInput("thursday");

        selectTimeOption("friday", "custom");
        document.getElementById("fridayStart").value = "6pm";
        document.getElementById("fridayEnd").value = "12am";
        updateHiddenTimeInput("friday");
    } else if (crewId === "CR002") {
        selectTimeOption("monday", "custom");
        document.getElementById("mondayStart").value = "8am";
        document.getElementById("mondayEnd").value = "4pm";
        updateHiddenTimeInput("monday");

        selectTimeOption("tuesday", "custom");
        document.getElementById("tuesdayStart").value = "8am";
        document.getElementById("tuesdayEnd").value = "4pm";
        updateHiddenTimeInput("tuesday");

        selectTimeOption("wednesday", "custom");
        document.getElementById("wednesdayStart").value = "8am";
        document.getElementById("wednesdayEnd").value = "4pm";
        updateHiddenTimeInput("wednesday");

        selectTimeOption("thursday", "custom");
        document.getElementById("thursdayStart").value = "8am";
        document.getElementById("thursdayEnd").value = "4pm";
        updateHiddenTimeInput("thursday");

        selectTimeOption("friday", "flex");
        selectTimeOption("saturday", "flex");
    }

    modal.style.display = "block";
    document.body.style.overflow = "hidden";
}

function closeAvailabilityModal() {
    const modal = document.getElementById("availabilityModal");
    modal.style.display = "none";
    document.body.style.overflow = "auto";
    document.getElementById("availabilityForm").reset();
    clearAllDays();
}

function submitAvailability() {
    const form = document.getElementById("availabilityForm");

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const crewSelect = document.getElementById("crewSelect");
    if (!crewSelect.value) {
        alert("Please select a crew member");
        crewSelect.focus();
        return;
    }

    let hasAvailability = false;
    const availabilityData = {};

    DAYS.forEach((day) => {
        const hiddenInput = document.getElementById(`${day}Time`);
        if (hiddenInput && hiddenInput.value) {
            hasAvailability = true;
            availabilityData[`${day}_time`] = hiddenInput.value;
        }
    });

    if (!hasAvailability) {
        alert("Please set availability for at least one day");
        return;
    }

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const selectedOption = crewSelect.options[crewSelect.selectedIndex];
    const crewName = selectedOption.text.split(" (")[0];

    data.crew_name = crewName;
    data.timestamp = new Date().toISOString();

    const finalData = { ...data, ...availabilityData };

    console.log("Availability Data:", finalData);

    const isEdit = data.availability_id ? true : false;
    alert(
        `${isEdit ? "Availability updated" : "Availability added"} successfully for ${crewName}!\n\nAvailability will be reflected in the table.`
    );

    closeAvailabilityModal();

    setTimeout(() => {
        location.reload();
    }, 500);
}

// ============================================
// EVENT LISTENERS - Initialize on DOM ready
// ============================================
document.addEventListener("DOMContentLoaded", () => {
    // Button listeners
    document.getElementById("addAvailabilityBtn").addEventListener("click", openAddAvailabilityModal);
    document.getElementById("closeModalBtn").addEventListener("click", closeAvailabilityModal);
    document.getElementById("cancelBtn").addEventListener("click", closeAvailabilityModal);
    document.getElementById("submitBtn").addEventListener("click", submitAvailability);
    document.getElementById("setAllFlexBtn").addEventListener("click", () => setAllDays("flex"));
    document.getElementById("clearAllBtn").addEventListener("click", clearAllDays);

    // Time option buttons
    document.querySelectorAll(".time-option").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const day = btn.getAttribute("data-day");
            const value = btn.getAttribute("data-value");
            selectTimeOption(day, value);
        });
    });

    // Time input listeners
    document.querySelectorAll(".time-input").forEach((input) => {
        input.addEventListener("focus", () => {
            showTimeSuggestions(input.id);
        });

        input.addEventListener("input", () => {
            validateTimeInput(input.id);
        });
    });

    // Hide suggestions when clicking outside
    document.addEventListener("click", (e) => {
        if (!e.target.classList.contains("time-input")) {
            document.querySelectorAll(".time-suggestions").forEach((el) => {
                el.style.display = "none";
            });
        }
    });

    // Modal backdrop close
    window.addEventListener("click", (event) => {
        const modal = document.getElementById("availabilityModal");
        if (event.target === modal) {
            closeAvailabilityModal();
        }
    });

    // Escape key close
    document.addEventListener("keydown", (e) => {
        const modal = document.getElementById("availabilityModal");
        if (e.key === "Escape" && modal.style.display === "block") {
            closeAvailabilityModal();
        }
    });
}); 