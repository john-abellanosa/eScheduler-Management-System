@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Max Crew Management')

@section('page-title', 'Max Crew Management')
@section('page-subtitle', 'Set maximum crew members allowed for each day')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style> 
        :root {
            --color-primary-dark: #1a1a1a;
            --color-primary-light: #1a3a8f;
            --color-primary-medium: #2a4ab0;
            --secondary-blue: #2a56d6;
            --color-bg-white: #ffffff;
            --color-bg-light: #f9f9f9;
            --color-bg-lighter: #fafafa;
            --color-border: #e0e0e0;
            --color-border-dark: #d0d0d0;
            --color-border-hover: #999;
            --color-text-primary: #1a1a1a;
            --color-text-secondary: #000000;
            --color-text-tertiary: #333;
            --color-hover-bg: #f0f0f0;
            --color-active-bg: #e8e8e8;
            --color-success-bg: #f0f8f0;
            --color-success-text: #2d5a2d;
            --color-success-border: #c8e6c9;
            --color-error-bg: #fef8f8;
            --color-error-text: #8b3a3a;
            --color-error-border: #f5cccc;
            --color-error-input: #c00;
        } 

        .container { 
            margin: 1% auto;
            background-color: var(--color-bg-white);
            border-radius: 0;
            border: 1px solid var(--color-border); 
        }

        .page-header {
            background-color: var(--color-bg-white);
            padding: 1.5rem;
            border-bottom: 1px solid var(--color-border);
        }

        .page-header h1 {
            font-size: 1.25rem;
            color: var(--color-primary-dark);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: var(--color-text-secondary);
            font-size: 0.8125rem;
        }

        .week-display {
            background-color: var(--color-bg-white);
            padding: 1rem;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .week-display {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem;
                gap: 1.5rem;
            }
        }

        .week-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .week-range {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-primary-dark);
        }

        .week-total {
            font-size: 0.8125rem;
            color: var(--color-text-secondary);
        }

        .week-navigation {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.25rem;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 640px) {
            .week-navigation {
                justify-content: flex-end;
            }
        }

        .nav-btn {
            width: 2.0625rem;
            height: 2.0625rem;
            border-radius: 0.25rem;
            background-color: var(--color-bg-light);
            border: 1px solid var(--color-border-dark);
            color: var(--color-text-tertiary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .nav-btn:hover {
            background-color: var(--color-hover-bg);
            border-color: var(--color-border-hover);
        }

        .nav-btn:active {
            background-color: var(--color-active-bg);
        }

        .nav-btn svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .week-selector {
            display: flex;
            gap: 0.25rem;
            flex: 0 1 auto;
            min-width: 0;
        }

        .week-btn {
            padding: 0.5rem 0.875rem;
            background-color: var(--color-bg-light);
            border: 1px solid var(--color-border-dark);
            border-radius: 0.25rem;
            cursor: pointer;
            color: var(--color-text-tertiary);
            font-size: 0.8125rem;
            transition: all 0.2s;
            flex: 0 1 auto;
            white-space: nowrap;
        }

        @media (min-width: 640px) {
            .week-btn {
                flex: 0 1 auto;
            }
        }

        .week-btn:hover {
            background-color: var(--color-hover-bg);
            border-color: var(--color-border-hover);
        }

        .week-btn.active {
            background-color: var(--color-primary-light);
            color: var(--color-bg-white);
            border-color: var(--color-primary-light);
        }

        .content {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .content {
                padding: 1.5rem;
            }
        }

        .days-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 640px) {
            .days-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .days-grid {
                grid-template-columns: repeat(7, 1fr);
                gap: 0.75rem;
            }
        }

        .day-card {
            background-color: var(--color-bg-lighter);
            border: 1px solid var(--color-border);
            border-radius: 0.25rem;
            padding: 0.875rem;
            transition: all 0.2s;
        }

        @media (min-width: 768px) {
            .day-card {
                padding: 1rem;
            }
        }

        .day-card:hover {
            border-color: var(--color-border-hover);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .day-header {
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--color-border);
        }

        .day-name {
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.025rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .date {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--color-primary-dark);
            display: flex;
            align-items: baseline;
            gap: 0.25rem;
        }

        .date-number {
            font-size: 1.25rem;
        }

        .date-month {
            font-size: 0.875rem;
            color: var(--color-text-secondary);
            font-weight: 500;
        }

        .input-container {
            margin-top: 0.625rem;
        }

        .input-label {
            display: block;
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin-bottom: 0.375rem;
        }

        .crew-input {
            width: 100%;
            padding: 0.5rem 0.625rem;
            border: 1px solid var(--color-border-dark);
            border-radius: 0.25rem;
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--color-primary-dark);
            text-align: center;
            background-color: var(--color-bg-white);
            transition: border-color 0.2s;
        }

        .crew-input:focus {
            outline: none;
            border-color: var(--color-primary-light);
            background-color: var(--color-bg-white);
        }

        .crew-input::-webkit-outer-spin-button,
        .crew-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .crew-input[type=number] {
            -moz-appearance: textfield;
        }

        .controls {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1rem 0 0 0;
            border-top: 1px solid var(--color-border);
            margin-top: 1.25rem;
        }

        @media (min-width: 640px) {
            .controls {
                flex-direction: row;
                gap: 0.75rem;
            }
        }

        .btn {
            padding: 0.5625rem 1rem;
            border-radius: 0.25rem;
            font-size: 0.8125rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid var(--color-border-dark);
            background-color: var(--color-bg-light);
            color: var(--color-text-tertiary);
            transition: all 0.2s;
            flex: 1;
        }

        @media (min-width: 640px) {
            .btn {
                flex: 0 1 auto;
            }
        }

        .btn-primary {
            background-color: var(--color-primary-light);
            color: var(--color-bg-white);
            border-color: var(--color-primary-light);
        }

        .btn.btn-primary:hover {
            background-color: var(--secondary-blue);
        }

        .btn:hover {
            background-color: var(--color-hover-bg);
            border-color: var(--color-border-hover);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .status {
            padding: 0.75rem 0.875rem;
            border-radius: 0.25rem;
            margin-top: 1rem;
            font-size: 0.8125rem;
            display: none;
            border: 1px solid var(--color-border-dark);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-0.5rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status.success {
            background-color: var(--color-success-bg);
            color: var(--color-success-text);
            border-color: var(--color-success-border);
            display: block;
        }

        .status.error {
            background-color: var(--color-error-bg);
            color: var(--color-error-text);
            border-color: var(--color-error-border);
            display: block;
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Maximum Crew Configuration</h1>
            <p>Set maximum crew members allowed to be plotted for each day</p>
        </div>

        <div class="week-display">
            <div class="week-info">
                <div class="week-range" id="weekRangeDisplay">Week of January 4 - 10, 2026</div>
                <div class="week-total">Total Limit: <strong id="totalLimit">0</strong> crew members</div>
            </div>
            <div class="week-navigation">
                <button class="nav-btn" id="prevWeekBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
                <div class="week-selector">
                    <button class="week-btn" id="prevWeekBtnLarge">Previous</button>
                    <button class="week-btn active" id="currentWeekBtn">Current</button>
                    <button class="week-btn" id="nextWeekBtnLarge">Next</button>
                </div>
                <button class="nav-btn" id="nextWeekBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="content">
            <div class="days-grid" id="daysGrid">
                <!-- Days grid in HTML - will be updated by JavaScript -->
                <div class="day-card" data-day="0">
                    <div class="day-header">
                        <div class="day-name">Sunday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber0">4</span>
                            <span class="date-month" id="dateMonth0">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-04" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="1">
                    <div class="day-header">
                        <div class="day-name">Monday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber1">5</span>
                            <span class="date-month" id="dateMonth1">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-05" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="2">
                    <div class="day-header">
                        <div class="day-name">Tuesday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber2">6</span>
                            <span class="date-month" id="dateMonth2">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-06" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="3">
                    <div class="day-header">
                        <div class="day-name">Wednesday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber3">7</span>
                            <span class="date-month" id="dateMonth3">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-07" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="4">
                    <div class="day-header">
                        <div class="day-name">Thursday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber4">8</span>
                            <span class="date-month" id="dateMonth4">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-08" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="5">
                    <div class="day-header">
                        <div class="day-name">Friday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber5">9</span>
                            <span class="date-month" id="dateMonth5">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-09" value="0">
                    </div>
                </div>
                <div class="day-card" data-day="6">
                    <div class="day-header">
                        <div class="day-name">Saturday</div>
                        <div class="date">
                            <span class="date-number" id="dateNumber6">10</span>
                            <span class="date-month" id="dateMonth6">Jan</span>
                        </div>
                    </div>
                    <div class="input-container">
                        <label class="input-label">Max Crew</label>
                        <input type="number" class="crew-input" data-date="2026-01-10" value="0">
                    </div>
                </div>
            </div>

            <div class="controls">
                <button class="btn btn-primary" id="saveBtn">Save Limits</button> 
            </div>

            <div class="status" id="statusMessage"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let limitsData = {};
            let currentWeekOffset = 0;
            let currentWeekDates = [];

            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'];
            const monthNamesShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                   'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            initializeData();
            updateWeekDisplay();
            setupEventListeners();
            updateTotal();

            function initializeData() {
                const today = new Date();
                generateWeekDates(today);
                
                const inputs = document.querySelectorAll('.crew-input');
                inputs.forEach(input => {
                    const dateKey = input.getAttribute('data-date');
                    const value = parseInt(input.value) || 0;
                    limitsData[dateKey] = value;
                });
            }

            function generateWeekDates(baseDate) {
                const weekStart = getWeekStartDate(baseDate);
                weekStart.setDate(weekStart.getDate() + (currentWeekOffset * 7));

                currentWeekDates = [];
                for (let i = 0; i < 7; i++) {
                    const date = new Date(weekStart);
                    date.setDate(weekStart.getDate() + i);
                    currentWeekDates.push(date);
                }
            }

            function getWeekStartDate(date) {
                const result = new Date(date);
                result.setDate(date.getDate() - date.getDay());
                return result;
            }

            function updateWeekDisplay() {
                const firstDate = currentWeekDates[0];
                const lastDate = currentWeekDates[6];

                let weekRangeText = '';
                if (firstDate.getMonth() === lastDate.getMonth()) {
                    weekRangeText = `${monthNames[firstDate.getMonth()]} ${firstDate.getDate()} - ${lastDate.getDate()}, ${firstDate.getFullYear()}`;
                } else {
                    weekRangeText = `${monthNames[firstDate.getMonth()]} ${firstDate.getDate()} - ${monthNames[lastDate.getMonth()]} ${lastDate.getDate()}, ${firstDate.getFullYear()}`;
                }

                document.getElementById('weekRangeDisplay').textContent = `Week of ${weekRangeText}`;

                currentWeekDates.forEach((date, index) => {
                    const dateKey = date.toISOString().split('T')[0];
                    const dayCard = document.querySelector(`.day-card[data-day="${index}"]`);
                    
                    if (dayCard) {
                        const dayNameElement = dayCard.querySelector('.day-name');
                        if (dayNameElement) {
                            dayNameElement.textContent = dayNames[date.getDay()];
                        }
                        
                        const dateNumberElement = dayCard.querySelector('.date-number');
                        if (dateNumberElement) {
                            dateNumberElement.textContent = date.getDate();
                        }
                        
                        const dateMonthElement = dayCard.querySelector('.date-month');
                        if (dateMonthElement) {
                            dateMonthElement.textContent = monthNamesShort[date.getMonth()];
                        }
                        
                        const inputElement = dayCard.querySelector('.crew-input');
                        if (inputElement) {
                            inputElement.setAttribute('data-date', dateKey);
                            inputElement.value = limitsData[dateKey] || 0;
                        }
                    }
                });

                updateActiveButton();
            }

            function updateActiveButton() {
                const currentBtn = document.getElementById('currentWeekBtn');
                const prevBtn = document.getElementById('prevWeekBtnLarge');
                const nextBtn = document.getElementById('nextWeekBtnLarge');

                [currentBtn, prevBtn, nextBtn].forEach(btn => btn.classList.remove('active'));

                if (currentWeekOffset === 0) {
                    currentBtn.classList.add('active');
                } else if (currentWeekOffset < 0) {
                    prevBtn.classList.add('active');
                } else {
                    nextBtn.classList.add('active');
                }
            }

            function handleInputChange(event) {
                const input = event.target;
                const dateKey = input.getAttribute('data-date');
                let value = input.value.trim();

                if (value === '' || value === '-') {
                    limitsData[dateKey] = 0;
                    input.value = 0;
                } else {
                    let numValue = parseInt(value);
                    if (isNaN(numValue) || numValue < 0) {
                        numValue = 0;
                    }
                    input.value = numValue;
                    limitsData[dateKey] = numValue;
                }

                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                currentWeekDates.forEach(date => {
                    const dateKey = date.toISOString().split('T')[0];
                    total += limitsData[dateKey] || 0;
                });
                document.getElementById('totalLimit').textContent = total;
            }

            function setupEventListeners() {
                document.getElementById('prevWeekBtn').addEventListener('click', () => navigateWeek(-1));
                document.getElementById('nextWeekBtn').addEventListener('click', () => navigateWeek(1));

                document.getElementById('prevWeekBtnLarge').addEventListener('click', () => navigateToWeek(-1));
                document.getElementById('currentWeekBtn').addEventListener('click', () => navigateToWeek(0));
                document.getElementById('nextWeekBtnLarge').addEventListener('click', () => navigateToWeek(1));

                document.querySelectorAll('.crew-input').forEach(input => {
                    input.addEventListener('input', handleInputChange);
                    input.addEventListener('change', handleInputChange);
                });

                document.getElementById('saveBtn').addEventListener('click', saveLimits); 
            }

            function navigateWeek(direction) {
                currentWeekOffset += direction;
                generateWeekDates(new Date());
                updateWeekDisplay();
                updateTotal();
            }

            function navigateToWeek(offset) {
                currentWeekOffset = offset;
                generateWeekDates(new Date());
                updateWeekDisplay();
                updateTotal();
            }

            function saveLimits() {
                const inputs = document.querySelectorAll('.crew-input');
                let isValid = true;

                inputs.forEach(input => {
                    const value = parseInt(input.value);
                    if (isNaN(value) || value < 0) {
                        input.style.borderColor = 'var(--color-error-input)';
                        isValid = false;
                    } else {
                        input.style.borderColor = 'var(--color-border-dark)';
                    }
                });

                if (!isValid) {
                    showStatus('Please enter valid numbers (0 or greater) for all days.', 'error');
                    return;
                }

                const weekData = {};
                currentWeekDates.forEach(date => {
                    const dateKey = date.toISOString().split('T')[0];
                    weekData[dateKey] = limitsData[dateKey];
                });

                console.log('Saved limits:', weekData);

                const direction = currentWeekOffset === 0 ? 'current' :
                                currentWeekOffset < 0 ? 'previous' : 'next';
                showStatus(`Limits saved for ${direction} week.`, 'success');
            } 

            function showStatus(message, type) {
                const statusElement = document.getElementById('statusMessage');
                statusElement.textContent = message;
                statusElement.className = `status ${type}`;

                setTimeout(() => {
                    statusElement.style.display = 'none';
                }, 4000);
            }
        });
    </script>
</body>
</html>
@endsection