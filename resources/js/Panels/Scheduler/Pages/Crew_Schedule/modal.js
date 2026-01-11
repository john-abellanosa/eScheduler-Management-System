document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('crewModal');
    const closeBtn = modal.querySelector('.close-btn');
    const cancelBtn = modal.querySelector('.btn-modal-secondary');
    const deptNameSpan = document.getElementById('modalDeptName');

    const formInputs = modal.querySelectorAll('input, select');

    // OPEN MODAL FROM BUTTON
    window.openModal = function (button) {
        const departmentHeader = button.closest('.department-header');
        const departmentTitle =
            departmentHeader.querySelector('.department-title').textContent;

        deptNameSpan.textContent = departmentTitle;
        modal.classList.add('active');
    };

    // CLOSE MODAL (X) — DO NOT CLEAR
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // CANCEL — CLOSE + CLEAR
    cancelBtn.addEventListener('click', () => {
        clearForm();
        modal.classList.remove('active');
    });

    // CLICK OUTSIDE — CLOSE (NO CLEAR)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // CLEAR FORM
    function clearForm() {
        formInputs.forEach(input => {
            if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            } else {
                input.value = '';
            }
        });
    }
});
