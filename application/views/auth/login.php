<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi MBG</title>
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

<body class="bg-gradient-to-br from-primary-600 to-secondary-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Card Login -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 p-6 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-fingerprint text-white text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">ABSENSI MBG</h1>
                <p class="text-white/90 mt-1">Masuk ke akun Anda</p>
            </div>

            <!-- Form Login -->
            <div class="p-6">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?= form_open('auth/login', [
                    'autocomplete' => 'off',
                    'novalidate' => 'novalidate',
                    // 'id' => 'loginForm',
                    'class' => 'space-y-5',
                ]) ?>
                <!-- Username Input -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Masukkan username"
                            required>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Masukkan password"
                            required>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>
                    <a href="#" class="text-sm text-secondary-600 hover:text-secondary-800 font-medium">Lupa password?</a>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Masuk
                </button>
                <?= form_close() ?>


                <!-- Divider -->
                <!-- <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau gunakan</span>
                    </div>
                </div> -->

                <!-- Fingerprint Login -->
                <!-- <div class="text-center">
                    <button
                        id="fingerprintBtn"
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <i class="fas fa-fingerprint text-2xl"></i>
                    </button>
                    <p class="text-sm text-gray-600 mt-2">Login dengan sidik jari</p>
                </div> -->
            </div>

            <!-- Footer Card -->
            <!-- <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
                <p class="text-xs text-center text-gray-600">
                    &copy; 2023 Absensi MBG. Hak cipta dilindungi.
                </p>
            </div> -->
        </div>

        <!-- Demo Credentials -->
        <div class="mt-6 bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
            <p class="text-white text-sm font-medium">Aplikasi Absensi MBG</p>
            <p class="text-white/90 text-sm">&copy; 2025 Absensi MBG. Hak cipta dilindungi.</p>
            <!-- <p class="text-white/90 text-sm">Username: <span class="font-mono">admin</span> | Password: <span class="font-mono">password</span></p> -->
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Validasi sederhana
            if (username === '' || password === '') {
                alert('Username dan password harus diisi');
                return;
            }

            // Simulasi proses login
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;

            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            button.disabled = true;

            setTimeout(() => {
                window.location.href = 'beranda.html';
            }, 1500);
        });
    </script>
</body>

</html>