<!-- Mobile Bottom Navigation -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-3 shadow-lg z-30">
    <a href="#" class="flex flex-col items-center text-primary-600">
        <i class="fas fa-tachometer-alt text-lg"></i>
        <span class="text-xs mt-1">Dashboard</span>
    </a>
    <a href="#" class="flex flex-col items-center text-gray-500">
        <i class="fas fa-users text-lg"></i>
        <span class="text-xs mt-1">Karyawan</span>
    </a>
    <a href="#" class="flex flex-col items-center text-gray-500">
        <i class="fas fa-history text-lg"></i>
        <span class="text-xs mt-1">Rekap</span>
    </a>
    <a href="#" class="flex flex-col items-center text-gray-500">
        <i class="fas fa-cog text-lg"></i>
        <span class="text-xs mt-1">Settings</span>
    </a>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    // Mobile menu functionality
    function initMobileMenu() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileSidebar = document.getElementById('mobileSidebar');

        if (mobileMenuButton && mobileSidebar) {
            mobileMenuButton.addEventListener('click', () => {
                mobileSidebar.classList.add('mobile-menu-active');
                mobileOverlay.classList.add('overlay-active');
            });

            closeMobileMenu.addEventListener('click', () => {
                mobileSidebar.classList.remove('mobile-menu-active');
                mobileOverlay.classList.remove('overlay-active');
            });

            mobileOverlay.addEventListener('click', () => {
                mobileSidebar.classList.remove('mobile-menu-active');
                mobileOverlay.classList.remove('overlay-active');
            });
        }
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // renderEmployeeTable();
        // renderEmployeeCards();
        // renderRecentActivities();
        initMobileMenu();

        // Update waktu real-time
        function updateTime() {
            const now = new Date();
            const timeElement = document.querySelector('.text-gray-600');
            if (timeElement) {
                timeElement.textContent = `Terakhir diperbarui: ${now.toLocaleTimeString('id-ID')}`;
            }
        }

        updateTime();
        setInterval(updateTime, 60000); // Update setiap menit
    });
</script>
</body>

</html>