<?php include 'head.php' ?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6">

    <!-- Card Profil -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <!-- Foto Profil -->
        <div class="text-center mb-6">
            <div class="relative inline-block">
                <div class="w-24 h-24 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <button class="absolute bottom-4 right-0 bg-white rounded-full p-2 shadow-lg border border-gray-200">
                    <i class="fas fa-camera text-gray-600 text-sm"></i>
                </button>
            </div>
            <h2 class="text-xl font-bold text-gray-900"><?= $info->full_name ?></h2>
            <p class="text-gray-600"><?= $info->jabatan ?></p>
            <div class="flex items-center justify-center mt-2">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-circle text-xs mr-1"></i> Aktif
                </span>
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-id-card text-primary-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">ID Karyawan</span>
                </div>
                <p class="text-lg font-semibold text-gray-900"><?= $info->employee_id ?></p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-building text-primary-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Divisi</span>
                </div>
                <p class="text-lg font-semibold text-gray-900"><?= $info->jabatan ?></p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-calendar-alt text-primary-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Bergabung</span>
                </div>
                <p class="text-lg font-semibold text-gray-900">-</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-envelope text-primary-600 mr-2"></i>
                    <span class="text-sm font-medium text-gray-700">Email</span>
                </div>
                <p class="text-lg font-semibold text-gray-900"><?= $info->email ?></p>
            </div>
        </div>

        <!-- Statistik Kehadiran -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-primary-600 mr-2"></i>
                Statistik Kehadiran Bulan Ini
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary-600">24</div>
                    <div class="text-xs text-gray-600">Hari Hadir</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">2</div>
                    <div class="text-xs text-gray-600">Izin</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">98%</div>
                    <div class="text-xs text-gray-600">Presensi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Profil -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
        <!-- Informasi Kontak -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-address-book text-primary-600 mr-2"></i>
                Informasi Kontak
            </h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Telepon</p>
                        <p class="font-medium text-gray-900"><?= $info->phone_number ?></p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-medium text-gray-900">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaturan Akun -->
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-cog text-primary-600 mr-2"></i>
                Pengaturan Akun
            </h3>
            <div class="space-y-3">
                <a href="#" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-xl transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-primary-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Ubah Password</p>
                            <p class="text-sm text-gray-500">Perbarui kata sandi Anda</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
            </div>
        </div>
    </div>

</main>

<?php include 'btnav.php' ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk dropdown profil
        document.getElementById('profileMenu').addEventListener('click', function() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        });

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#profileMenu') && !event.target.closest('#profileDropdown')) {
                document.getElementById('profileDropdown').classList.add('hidden');
            }
        });
    })
</script>
</body>

</html>