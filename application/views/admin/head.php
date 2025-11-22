<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Absensi MBG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e8f5e9',
                            100: '#c8e6c9',
                            200: '#a5d6a7',
                            300: '#81c784',
                            400: '#66bb6a',
                            500: '#4caf50',
                            600: '#43a047',
                            700: '#388e3c',
                            800: '#2e7d32',
                            900: '#1b5e20',
                        },
                        secondary: {
                            50: '#e3f2fd',
                            100: '#bbdefb',
                            200: '#90caf9',
                            300: '#64b5f6',
                            400: '#42a5f5',
                            500: '#2196f3',
                            600: '#1e88e5',
                            700: '#1976d2',
                            800: '#1565c0',
                            900: '#0d47a1',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles for better mobile experience */
        .mobile-menu-active {
            transform: translateX(0) !important;
        }

        .overlay-active {
            display: block !important;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Mobile Header -->
    <div class="md:hidden bg-gradient-to-r from-primary-700 to-primary-800 text-white shadow-lg sticky top-0 z-30">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <button id="mobileMenuButton" class="mr-3">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center">
                    <i class="fas fa-fingerprint text-xl mr-2"></i>
                    <span class="font-bold">Admin MBG</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                </div>
                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary-800 to-primary-900 transform -translate-x-full transition-transform duration-300 md:hidden">
        <div class="flex items-center justify-center h-16 flex-shrink-0 px-4 bg-primary-900 border-b border-primary-700">
            <div class="flex items-center">
                <i class="fas fa-fingerprint text-white text-2xl mr-2"></i>
                <span class="text-white text-xl font-bold">Admin MBG</span>
            </div>
        </div>

        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <nav class="mt-5 flex-1 px-4 space-y-2">
                <a href="<?= base_url('admin') ?>" class="<?= $menu == 'dashboard' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <div x-data="{ open: false }" class="relative">
                    <!-- Tombol -->
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl
                       <?= $menu == 'karyawan' || $menu == 'divisi' || $menu == 'users' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?>">
                        <span><i class="fas fa-database mr-3"></i> Master Data</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>

                    <!-- Isi dropdown -->
                    <div x-show="open" x-transition @click.outside="open = false"
                        class="mt-1 ml-4 flex flex-col bg-primary-800 rounded-lg shadow-lg overflow-hidden">

                        <a href="<?= base_url('admin/karyawan') ?>"
                            class="px-4 py-2 text-sm <?= $menu == 'karyawan' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                            <i class="fas fa-users mr-2"></i> Data Karyawan
                        </a>

                        <a href="<?= base_url('admin/divisi') ?>"
                            class="px-4 py-2 text-sm <?= $menu == 'divisi' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                            <i class="fas fa-sitemap mr-2"></i> Data Divisi
                        </a>

                        <a href="<?= base_url('admin/users') ?>"
                            class="px-4 py-2 text-sm <?= $menu == 'users' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                            <i class="fa-solid fa-user-lock mr-2"></i> Data User Akun
                        </a>
                    </div>
                </div>

                <a href="#" class="<?= $menu == 'izin' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                    <i class="fas fa-file-alt mr-3"></i>
                    Pengajuan Izin
                </a>
                <a href="<?= base_url('rekap/absensi') ?>" class="<?= $menu == 'rekap' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                    <i class="fas fa-history mr-3"></i>
                    Rekap Absensi
                </a>

                <!--<a href="#" class="<?= $menu == 'dashboard' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a> -->
                <a href="#" class="<?= $menu == 'pengaturan' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                    <i class="fas fa-cog mr-3"></i>
                    Pengaturan
                </a>
            </nav>
        </div>

        <div class="flex-shrink-0 flex border-t border-primary-700 p-4">
            <div class="flex items-center w-full">
                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-white"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-white">Admin System</p>
                    <a href="<?= base_url('auth/logout') ?>" class="text-xs font-medium text-primary-200 hover:text-white">Keluar</a>
                </div>
                <button id="closeMobileMenu" class="text-primary-200 hover:text-white">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
        <div class="flex-1 flex flex-col min-h-0 bg-gradient-to-b from-primary-800 to-primary-900">
            <div class="flex items-center justify-center h-16 flex-shrink-0 px-4 bg-primary-900">
                <div class="flex items-center">
                    <i class="fas fa-fingerprint text-white text-2xl mr-2"></i>
                    <span class="text-white text-xl font-bold">Admin MBG</span>
                </div>
            </div>

            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <nav class="mt-5 flex-1 px-4 space-y-2">
                    <a href="<?= base_url('admin') ?>" class="<?= $menu == 'dashboard' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <div x-data="{ open: false }" class="relative">
                        <!-- Tombol -->
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl
                       <?= $menu == 'karyawan' || $menu == 'divisi' || $menu == 'users' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?>">
                            <span><i class="fas fa-database mr-3"></i> Master Data</span>
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>

                        <!-- Isi dropdown -->
                        <div x-show="open" x-transition @click.outside="open = false"
                            class="mt-1 ml-4 flex flex-col bg-primary-800 rounded-lg shadow-lg overflow-hidden">

                            <a href="<?= base_url('admin/karyawan') ?>"
                                class="px-4 py-2 text-sm <?= $menu == 'karyawan' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                                <i class="fas fa-arrow-right mr-2"></i> Data Karyawan
                            </a>

                            <a href="<?= base_url('admin/divisi') ?>"
                                class="px-4 py-2 text-sm <?= $menu == 'divisi' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                                <i class="fas fa-arrow-right mr-2"></i> Data Divisi
                            </a>
                            <a href="<?= base_url('admin/users') ?>"
                                class="px-4 py-2 text-sm <?= $menu == 'users' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                                <i class="fas fa-arrow-right mr-2"></i> Data User Akun
                            </a>
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <!-- Tombol -->
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl
                       <?= $menu == 'absensi' || $menu == 'izin' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?>">
                            <span><i class="fas fa-calendar-check mr-3"></i> Absensi</span>
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>

                        <!-- Isi dropdown -->
                        <div x-show="open" x-transition @click.outside="open = false"
                            class="mt-1 ml-4 flex flex-col bg-primary-800 rounded-lg shadow-lg overflow-hidden">

                            <a href="<?= base_url('absensi') ?>"
                                class="px-4 py-2 text-sm <?= $menu == 'absensi' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                                <i class="fas fa-arrow-right mr-2"></i> Input Absensi
                            </a>

                            <a href="<?= base_url('absensi/izin') ?>"
                                class="px-4 py-2 text-sm <?= $menu == 'izin' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-600' ?>">
                                <i class="fas fa-arrow-right mr-2"></i> Perizianan
                            </a>
                        </div>
                    </div>

                    <a href="<?= base_url('rekap/absensi') ?>" class="<?= $menu == 'rekap' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                        <i class="fas fa-history mr-3"></i>
                        Rekap Absensi
                    </a>
                    <!-- <a href="#" class="<?= $menu == 'dashboard' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Laporan
                    </a> -->
                    <a href="#" class="<?= $menu == 'pengaturan' ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl">
                        <i class="fas fa-cog mr-3"></i>
                        Pengaturan
                    </a>
                </nav>
            </div>

            <div class="flex-shrink-0 flex border-t border-primary-700 p-4">
                <div class="flex items-center w-full">
                    <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-white"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white"><?= $user['name'] ?></p>
                        <a href="<?= base_url('auth/logout') ?>" class="text-xs font-medium text-primary-200 hover:text-white">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>