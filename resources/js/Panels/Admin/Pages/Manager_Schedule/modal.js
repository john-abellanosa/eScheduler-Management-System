document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('managerModal');
    const openBtn = document.getElementById('addManagerBtn');
    const closeBtn = modal.querySelector('.close-btn');
    const cancelBtn = modal.querySelector('.btn-modal-secondary');

    const formInputs = modal.querySelectorAll('input, select');

    // OPEN MODAL
    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
    });

    // CLOSE MODAL (X button) — DO NOT CLEAR
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // CANCEL BUTTON — CLOSE + CLEAR
    cancelBtn.addEventListener('click', () => {
        clearForm();
        modal.classList.remove('active');
    });

    // CLICK OUTSIDE MODAL — CLOSE (NO CLEAR)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // CLEAR FORM FUNCTION
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
