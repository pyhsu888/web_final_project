    <!-- Dark Mode Toggle Button -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">🌙</button>

    <script>
        // Dark Mode Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        function updateToggleIcon() {
            const isDark = html.getAttribute('data-theme') === 'dark';
            themeToggle.textContent = isDark ? '☀️' : '🌙';
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleIcon();
        });

        // Initialize icon on page load
        updateToggleIcon();
    </script>
</body>
</html>
