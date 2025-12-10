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

    <!-- System Time -->
    <div id="system-time-display">
        Loading time...
    </div>

    <script>
        (function() {
            const timeLabel = "<?php echo __('system_time'); ?>";
            let currentServerTime = new Date("<?php echo date('Y/m/d H:i:s'); ?>");

            const display = document.getElementById('system-time-display');

            function updateTime() {
                const year = currentServerTime.getFullYear();
                const month = String(currentServerTime.getMonth() + 1).padStart(2, '0');
                const day = String(currentServerTime.getDate()).padStart(2, '0');
                const h = String(currentServerTime.getHours()).padStart(2, '0');
                const m = String(currentServerTime.getMinutes()).padStart(2, '0');
                const s = String(currentServerTime.getSeconds()).padStart(2, '0');

                display.textContent = `${timeLabel}: ${year}-${month}-${day} ${h}:${m}:${s}`;
                currentServerTime.setSeconds(currentServerTime.getSeconds() + 1);
            }

            updateTime();
            setInterval(updateTime, 1000);
        })();
    </script>

</body>
</html>

<style>
    #themeToggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999; /* always on top */

        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: none;
        background-color: #333;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;

        padding: 8px 9px 13px 8px; /* visually centered */
    }
    [data-theme="dark"] #themeToggle {
        background-color: #fff;
        color: #333;
        padding: 10px 9px 13px 10px; /* visually centered */
    }

    #system-time-display {
        position: fixed;
        bottom: 10px;
        left: 10px;
        z-index: 9999; 

        background-color: rgba(255, 255, 255, 0.5);
        color: #000;
        
        padding: 5px 10px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 14px;
        pointer-events: none;
    }

    [data-theme="dark"] #system-time-display {
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
    }
</style>