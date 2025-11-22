<?php $this->load->view('admin/head'); ?>

<!-- Main Content -->
<div class="md:pl-64 flex flex-col flex-1">
    <!-- Desktop Header -->
    <div class="hidden md:block bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?= $title ?></h1>
                        <p class="text-gray-600"><?= $title2 ?></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900"><?= $user['name'] ?></p>
                            <p class="text-xs text-gray-500">Super Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1 p-4 md:p-6">
        <!-- Mobile Page Title -->
        <div class="md:hidden mb-6">
            <h1 class="text-xl font-bold text-gray-900"><?= $title ?></h1>
            <p class="text-gray-600 text-sm"><?= $title2 ?></p>
        </div>

        <!-- Stats Cards - Mobile Optimized -->
        <div class="grid grid-cols-2 gap-3 mb-6 md:grid-cols-1 lg:grid-cols-3 md:gap-5">
            <!-- Total Karyawan -->
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Total Karyawan</p>
                        <p class="text-lg font-bold text-gray-900"><?= $karyawan ?></p>
                    </div>
                </div>
                <div class="mt-2 text-xs text-green-600 font-medium">
                    +2 dari bulan lalu
                </div>
            </div>

            <!-- Hadir Hari Ini -->
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-check text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Hadir Hari Ini</p>
                        <p class="text-lg font-bold text-gray-900"><?= $hadir ?></p>
                    </div>
                </div>
                <div class="mt-2 text-xs text-red-600 font-medium">
                    <?= $karyawan - ($hadir + $izin) ?> belum absen
                </div>
            </div>

            <!-- Izin -->
            <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Izin</p>
                        <p class="text-lg font-bold text-gray-900"><?= $izin ?></p>
                    </div>
                </div>
                <div class="mt-2 text-xs text-blue-600 font-medium">
                    Perizinan hari ini
                </div>
            </div>
        </div>

        <!-- Charts & Tables Section -->
        <div class="space-y-6">
            <!-- Grafik Kehadiran -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-3 border-b border-gray-200 md:px-6 md:py-4">
                    <h3 class="text-base font-medium text-gray-900 md:text-lg">Statistik Kehadiran</h3>
                </div>
                <div class="p-4 md:p-6">
                    <div class="h-60 md:h-80 flex items-center justify-center bg-gray-50 rounded-lg">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-chart-bar text-3xl mb-3 md:text-4xl"></i>
                            <p class="text-sm md:text-base">Grafik kehadiran akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </main>
</div>

<?php $this->load->view('admin/foot'); ?>