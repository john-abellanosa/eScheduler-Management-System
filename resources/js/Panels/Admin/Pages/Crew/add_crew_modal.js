document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("employeeModal");
    const closeBtn = modal.querySelector(".close-btn");
    const cancelBtn = document.getElementById("cancelBtn");
    const submitBtn = document.getElementById("submitBtn");
    const employeeForm = document.getElementById("employeeForm");
    const addEmployeeBtn = document.getElementById("addEmployeeBtn"); // NEW

    // Get all form inputs
    const formInputs = modal.querySelectorAll("input, select");

    // OPEN MODAL FUNCTION - REMOVED from window object
    const openEmployeeModal = function () {
        modal.classList.add("active");
    };

    // ADD EVENT LISTENER TO THE BUTTON - NEW
    if (addEmployeeBtn) {
        addEmployeeBtn.addEventListener("click", openEmployeeModal);
    }

    // CLOSE MODAL (X button) - NO CLEAR
    closeBtn.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    // CANCEL BUTTON - CLOSE + CLEAR FORM
    cancelBtn.addEventListener("click", () => {
        clearForm();
        modal.classList.remove("active");
    });

    // CLICK OUTSIDE MODAL - CLOSE (NO CLEAR)
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("active");
        }
    });

    // ESCAPE KEY TO CLOSE MODAL
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            modal.classList.remove("active");
        }
    });

    // FORM SUBMISSION
    submitBtn.addEventListener("click", (e) => {
        e.preventDefault();

        if (validateForm()) {
            // If validation passes, submit the form
            submitForm();
        }
    });

    // FORM VALIDATION FUNCTION
    function validateForm() {
        let isValid = true;

        // Clear previous error messages
        const errorMessages = modal.querySelectorAll(".error-message");
        errorMessages.forEach((error) => (error.textContent = ""));

        // Validate each required field
        formInputs.forEach((input) => {
            if (input.hasAttribute("required") && !input.value.trim()) {
                isValid = false;
                const errorElement = input
                    .closest(".form-group")
                    .querySelector(".error-message");
                errorElement.textContent = "This field is required";
            }

            // Additional validation for email
            if (input.id === "email" && input.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    const errorElement = input
                        .closest(".form-group")
                        .querySelector(".error-message");
                    errorElement.textContent =
                        "Please enter a valid email address";
                }
            }

            // Additional validation for phone
            if (input.id === "phone" && input.value.trim()) {
                const phoneRegex = /^[0-9]{4}-[0-9]{3}-[0-9]{4}$/;
                if (!phoneRegex.test(input.value)) {
                    isValid = false;
                    const errorElement = input
                        .closest(".form-group")
                        .querySelector(".error-message");
                    errorElement.textContent = "Format: 0912-345-6789";
                }
            }
        });

        return isValid;
    }

    // FORM SUBMISSION FUNCTION
    function submitForm() {
        // Collect form data
        const formData = {
            firstName: document.getElementById("firstName").value,
            lastName: document.getElementById("lastName").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            street: document.getElementById("street").value,
            barangay: document.getElementById("barangay").value,
            city: document.getElementById("city").value,
            province: document.getElementById("province").value,
            hireDate: document.getElementById("hireDate").value,
        };

        console.log("Form submitted with data:", formData);

        // Here you would typically send the data to a server
        // For now, we'll just show an alert and clear the form
        alert("Employee added successfully!");
        clearForm();
        modal.classList.remove("active");
    }

    // CLEAR FORM FUNCTION
    function clearForm() {
        formInputs.forEach((input) => {
            if (input.tagName === "SELECT") {
                input.selectedIndex = 0;
            } else {
                input.value = "";
            }
        });

        // Clear error messages
        const errorMessages = modal.querySelectorAll(".error-message");
        errorMessages.forEach((error) => (error.textContent = ""));
    }
});