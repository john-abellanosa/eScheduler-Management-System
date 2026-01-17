       const userBtn = document.getElementById('userBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const backdrop = document.getElementById('backdrop');
        const settingsBtn = document.getElementById('settingsBtn');
        const logoutBtn = document.getElementById('logoutBtn');

        // Toggle dropdown
        userBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('active');
            backdrop.classList.toggle('active');
        });

        // Close dropdown when clicking backdrop
        backdrop.addEventListener('click', () => {
            dropdownMenu.classList.remove('active');
            backdrop.classList.remove('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('active');
                backdrop.classList.remove('active');
            }
        });