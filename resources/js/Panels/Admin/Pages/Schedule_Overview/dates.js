document.addEventListener("DOMContentLoaded", function () {
    // Days and months arrays
    const days = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
    ];
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    const shortMonths = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    // Get current date
    const today = new Date();
    let selectedDay = today.getDay(); // 0 = Sunday, 1 = Monday, etc.

    // Calculate the Sunday of current week
    let currentWeekStart = new Date(today);
    currentWeekStart.setDate(today.getDate() - today.getDay());
    currentWeekStart.setHours(0, 0, 0, 0);

    // Check if a date is in the current displayed week
    function isDateInCurrentWeek(date) {
        const weekStart = new Date(currentWeekStart);
        const weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);
        weekEnd.setHours(23, 59, 59, 999);
        return date >= weekStart && date <= weekEnd;
    }

    // Update the selected date display
    function updateSelectedDateDisplay() {
        const selectedDate = new Date(currentWeekStart);
        selectedDate.setDate(currentWeekStart.getDate() + selectedDay);

        const dayName = days[selectedDay];
        const monthName = months[selectedDate.getMonth()];
        const dateNumber = selectedDate.getDate();
        const year = selectedDate.getFullYear();

        // Check if element exists
        const selectedDateElement = document.querySelector(
            ".selected-date span"
        );
        if (selectedDateElement) {
            selectedDateElement.textContent = `${dayName}, ${monthName} ${dateNumber}, ${year}`;
        }
    }

    // Update the week range display
    function updateWeekRangeDisplay() {
        const sunday = new Date(currentWeekStart);
        const saturday = new Date(currentWeekStart);
        saturday.setDate(sunday.getDate() + 6);

        const formatWeekDate = (date) => {
            return `${shortMonths[date.getMonth()]} ${date.getDate()}`;
        };

        const weekDisplay = `Week: ${formatWeekDate(sunday)} - ${formatWeekDate(
            saturday
        )}, ${sunday.getFullYear()}`;

        // Check if element exists
        const weekDateElement = document.querySelector(".week-date span");
        if (weekDateElement) {
            weekDateElement.textContent = weekDisplay;
        }
    }

    // Update day selector active states
    function updateDaySelector() {
        const dayItems = document.querySelectorAll(".day-item");
        if (dayItems.length === 0) return;

        // Remove active class from all days
        dayItems.forEach((day) => {
            day.classList.remove("active");
        });

        // Check if today is in the current displayed week
        const isTodayInWeek = isDateInCurrentWeek(today);

        // If today is in the displayed week, highlight today, otherwise highlight Sunday
        if (isTodayInWeek) {
            selectedDay = today.getDay();
            if (dayItems[selectedDay]) {
                dayItems[selectedDay].classList.add("active");
            }
        } else {
            selectedDay = 0; // Sunday
            if (dayItems[0]) {
                dayItems[0].classList.add("active");
            }
        }
    }

    // Handle day selection
    function selectDay(dayIndex) {
        selectedDay = dayIndex;
        updateSelectedDateDisplay();

        // Update active day in selector
        const dayItems = document.querySelectorAll(".day-item");
        if (dayItems.length === 0) return;

        dayItems.forEach((day) => {
            day.classList.remove("active");
        });

        if (dayItems[dayIndex]) {
            dayItems[dayIndex].classList.add("active");
        }
    }

    // Navigate to previous week
    function prevWeek() {
        currentWeekStart.setDate(currentWeekStart.getDate() - 7);

        // Check if today is in the new week
        const isTodayInWeek = isDateInCurrentWeek(today);
        if (isTodayInWeek) {
            selectedDay = today.getDay();
        } else {
            selectedDay = 0; // Sunday
        }

        updateWeekRangeDisplay();
        updateSelectedDateDisplay();
        updateDaySelector();
    }

    // Navigate to next week
    function nextWeek() {
        currentWeekStart.setDate(currentWeekStart.getDate() + 7);

        // Check if today is in the new week
        const isTodayInWeek = isDateInCurrentWeek(today);
        if (isTodayInWeek) {
            selectedDay = today.getDay();
        } else {
            selectedDay = 0; // Sunday
        }

        updateWeekRangeDisplay();
        updateSelectedDateDisplay();
        updateDaySelector();
    }

    // Initialize everything
    function initializeHeader() {
        // Check if required elements exist
        const dayItems = document.querySelectorAll(".day-item");
        const prevArrow = document.querySelector(".week-arrow.left");
        const nextArrow = document.querySelector(".week-arrow.right");
        const printBtn = document.querySelector(".header-btn");

        if (dayItems.length === 0) {
            console.error("Day items not found! Check your HTML structure.");
            return;
        }

        // Set up day click handlers
        dayItems.forEach((day, index) => {
            day.addEventListener("click", function () {
                selectDay(index);
            });
        });

        // Set up week navigation handlers
        if (prevArrow) {
            prevArrow.addEventListener("click", prevWeek);
        }

        if (nextArrow) {
            nextArrow.addEventListener("click", nextWeek);
        }

        // Initial display updates
        updateWeekRangeDisplay();
        updateSelectedDateDisplay();
        updateDaySelector();
    }

    // Run initialization
    initializeHeader();
});
