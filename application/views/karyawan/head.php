<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Absensi MBG</title>
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
</head>

<body class="bg-gray-50 min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-gradient-to-r from-primary-700 to-primary-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-5">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">Absensi MBG</h1>
                    <p class="text-primary-100 text-sm">Selamat datang, <?= $user['name'] ?></p>
                </div>
                <div class="relative">
                    <button id="profileMenu" class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-10">
                        <a href="profil.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i>Profil Saya
                        </a>
                        <a href="pengaturan.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Pengaturan
                        </a>
                        <div class="border-t my-1"></div>
                        <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>