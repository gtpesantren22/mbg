<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - Absensi MBG</title>
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
                        },
                        error: {
                            50: '#ffebee',
                            100: '#ffcdd2',
                            200: '#ef9a9a',
                            300: '#e57373',
                            400: '#ef5350',
                            500: '#f44336',
                            600: '#e53935',
                            700: '#d32f2f',
                            800: '#c62828',
                            900: '#b71c1c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Animation for error icon */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        @keyframes pulse-red {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .error-shake {
            animation: shake 0.5s ease-in-out;
        }

        .error-pulse {
            animation: pulse-red 2s infinite;
        }

        /* Map animation */
        @keyframes map-pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        .map-pulse {
            animation: map-pulse 2s infinite;
        }

        /* Device animation */
        @keyframes device-slide {
            0% {
                transform: translateY(-20px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .device-slide {
            animation: device-slide 0.5s ease-out;
        }

        /* Custom gradient for error page */
        .error-gradient {
            background: linear-gradient(135deg, #c62828 0%, #b71c1c 50%, #d32f2f 100%);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Error Container -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl">
            <!-- Error Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Error Header -->
                <div class="error-gradient text-white">
                    <div class="p-8 lg:p-12">

                        <div class="text-center">
                            <div class="error-shake inline-block mb-6">
                                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto">
                                    <i class="fas fa-ban text-white text-4xl"></i>
                                </div>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-bold mb-4">Akses Ditolak</h1>
                            <p class="text-xl opacity-90 max-w-2xl mx-auto">
                                Sistem mendeteksi masalah keamanan yang mencegah proses absensi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error Content -->
                <div class="p-8 lg:p-12">
                    <!-- Dynamic Error Message -->
                    <div id="errorType" class="mb-10">
                        <!-- Error type will be set by JavaScript -->
                    </div>

                    <!-- Error Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                        <!-- Location Error Card -->
                        <div id="locationError" class="hidden bg-red-50 border-l-4 border-error-600 p-6 rounded-r-xl">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 bg-error-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-error-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-error-800 mb-1">Lokasi Tidak Valid</h3>
                                    <p class="text-error-700">Anda berada di luar area yang diizinkan</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-error-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-location-crosshairs text-error-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-error-900">Lokasi Saat Ini</div>
                                        <div id="currentLocation" class="text-error-700 text-sm">Mendeteksi lokasi...</div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-error-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-circle-check text-error-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-error-900">Lokasi yang Diizinkan</div>
                                        <div id="allowedLocation" class="text-error-700 text-sm">Kantor Pusat MBG</div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-error-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-ruler text-error-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-error-900">Jarak dari Lokasi</div>
                                        <div id="distanceFromLocation" class="text-error-700 text-sm">Menghitung...</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Device Error Card -->
                        <div id="deviceError" class="hidden bg-amber-50 border-l-4 border-amber-600 p-6 rounded-r-xl">
                            <div class="flex items-start mb-4">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-mobile-alt text-amber-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-amber-800 mb-1">Device Tidak Terdaftar</h3>
                                    <p class="text-amber-700">Perangkat ini tidak terdaftar dalam sistem</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-amber-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-fingerprint text-amber-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-amber-900">Device ID</div>
                                        <div id="deviceId" class="text-amber-700 text-sm font-mono">Loading...</div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-amber-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user-shield text-amber-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-amber-900">Status Registrasi</div>
                                        <div class="text-amber-700 text-sm">Tidak terdaftar</div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-amber-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-times text-amber-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-amber-900">Terakhir Diakses</div>
                                        <div class="text-amber-700 text-sm">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Visualization -->
                        <div class="bg-gray-900 rounded-xl p-6 flex items-center justify-center">
                            <div class="relative w-full h-64">
                                <!-- Map Background -->
                                <div class="absolute inset-0 bg-gray-800 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-map text-gray-700 text-6xl"></i>
                                </div>

                                <!-- Allowed Location Circle -->
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <div class="w-32 h-32 border-2 border-green-500 rounded-full flex items-center justify-center map-pulse">
                                        <div class="w-20 h-20 bg-green-500/30 rounded-full flex items-center justify-center">
                                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-building text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Location Marker -->
                                <div id="currentLocationMarker" class="absolute hidden">
                                    <div class="w-16 h-16 bg-error-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-error-500 font-bold text-sm">
                                        Anda
                                    </div>
                                </div>

                                <!-- Distance Line -->
                                <div id="distanceLine" class="absolute hidden w-full h-1 bg-error-500/50"></div>
                            </div>
                        </div>

                        <!-- Device Visualization -->
                        <div class="hidden bg-gray-900 rounded-xl p-6 flex items-center justify-center">
                            <div class="relative w-full h-64">
                                <!-- Device Illustration -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="device-slide">
                                        <div class="relative">
                                            <!-- Phone Body -->
                                            <div class="w-48 h-96 bg-gray-800 rounded-[40px] border-4 border-gray-700 flex flex-col items-center justify-center">
                                                <!-- Screen -->
                                                <div class="w-40 h-80 bg-gray-900 rounded-[30px] flex flex-col items-center justify-center p-4">
                                                    <div class="text-center">
                                                        <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                                            <i class="fas fa-ban text-red-500 text-xl"></i>
                                                        </div>
                                                        <div class="text-red-400 font-bold text-sm mb-1">DEVICE BLOCKED</div>
                                                        <div class="text-gray-400 text-xs">Unauthorized Access</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Notch -->
                                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-24 h-6 bg-gray-800 rounded-b-xl"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Warning Symbol -->
                                <div class="absolute top-4 right-4 w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Langkah Penyelesaian
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div id="locationInstructions" class="hidden">
                                <div class="font-medium text-blue-700 mb-2">Untuk Masalah Lokasi:</div>
                                <ul class="space-y-2 text-blue-600 text-sm">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Pastikan Anda berada di area kantor yang ditentukan
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Aktifkan GPS/lokasi di perangkat Anda
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Hubungi admin jika perlu izin khusus lokasi
                                    </li>
                                </ul>
                            </div>
                            <div id="deviceInstructions" class="hidden">
                                <div class="font-medium text-blue-700 mb-2">Untuk Masalah Device:</div>
                                <ul class="space-y-2 text-blue-600 text-sm">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Gunakan perangkat yang sudah terdaftar
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Hubungi IT untuk registrasi perangkat baru
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-blue-500 mt-1 mr-2"></i>
                                        Pastikan browser dan sistem Anda terupdate
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button id="retryButton" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-4 px-6 rounded-xl font-bold transition flex items-center justify-center text-lg">
                            <i class="fas fa-redo mr-3"></i>
                            Coba Lagi
                        </button>
                        <!-- <button id="contactAdmin" class="flex-1 bg-secondary-600 hover:bg-secondary-700 text-white py-4 px-6 rounded-xl font-bold transition flex items-center justify-center text-lg">
                            <i class="fas fa-headset mr-3"></i>
                            Hubungi Admin
                        </button> -->
                        <!-- <button id="logoutButton" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-4 px-6 rounded-xl font-bold transition flex items-center justify-center text-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Keluar
                        </button> -->
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-8 text-gray-600">
                <p class="text-sm">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Sistem keamanan ini melindungi data absensi perusahaan
                </p>
                <p class="text-xs mt-1">
                    Log ID: <span id="logId" class="font-mono">ERR-2024-</span> •
                    Waktu: <span id="errorTime"></span>
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Admin Modal -->
    <!-- <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Hubungi Admin</h3>
                <p class="text-gray-600 text-sm">Pilih metode kontak yang tersedia</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="tel:+628123456789" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-phone text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Telepon</div>
                            <div class="text-sm text-gray-600">+62 812-3456-789</div>
                        </div>
                    </a>
                    <a href="mailto:admin@mbg.com" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Email</div>
                            <div class="text-sm text-gray-600">admin@mbg.com</div>
                        </div>
                    </a>
                    <a href="https://wa.me/628123456789" target="_blank" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fab fa-whatsapp text-green-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">WhatsApp</div>
                            <div class="text-sm text-gray-600">+62 812-3456-789</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex border-t border-gray-200 p-6">
                <button id="closeContactModal" class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div> -->

    <script>
        // Fungsi untuk mendapatkan parameter error dari URL
        function getErrorFromURL() {
            const params = new URLSearchParams(window.location.search);
            const errorType = params.get('error') || 'location'; // default: location error
            const distance = params.get('distance') || '1.5'; // dalam km
            const lon = params.get('lon') || '00'; // dalam km
            const lat = params.get('lat') || '00'; // dalam km
            return {
                errorType,
                distance,
                lon,
                lat
            };
        }

        // Fungsi untuk generate device ID (simulasi)
        function getDeviceId() {
            // Simpan device ID di localStorage untuk konsistensi
            let deviceId = localStorage.getItem('deviceId');
            if (!deviceId) {
                deviceId = 'DEV-' + Math.random().toString(36).substr(2, 9).toUpperCase();
                localStorage.setItem('deviceId', deviceId);
            }
            return deviceId;
        }

        // Fungsi untuk mendapatkan lokasi saat ini (simulasi)
        async function getCurrentLocation() {
            const {
                lat,
                lon
            } = getErrorFromURL();

            const res = await fetch("<?= base_url('scanner/reverse_geocode?lon=') ?>" + lon + '&lat=' + lat);
            const data = await res.json();

            return data.display_name || "Alamat tidak ditemukan";
        }

        // Fungsi untuk menghitung jarak acak (simulasi)
        function getRandomDistance() {
            return (Math.random() * 5 + 0.5).toFixed(2); // 0.5 - 5.5 km
        }

        // Fungsi untuk update waktu error
        function updateErrorTime() {
            const now = new Date();
            document.getElementById('errorTime').textContent =
                now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }) + ' - ' + now.toLocaleDateString('id-ID');
        }

        // Fungsi untuk setup error berdasarkan tipe
        function setupError(errorType, distance) {
            const errorTypeElement = document.getElementById('errorType');

            if (errorType === 'location') {
                // Setup location error
                document.getElementById('locationError').classList.remove('hidden');
                document.getElementById('locationInstructions').classList.remove('hidden');

                errorTypeElement.innerHTML = `
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center px-6 py-3 bg-error-100 text-error-700 rounded-full font-bold mb-4">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            ERROR LOKASI
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Lokasi di Luar Radius</h2>
                        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                            Anda berada <span class="font-bold text-error-600">${distance} m</span> 
                            di luar radius yang diizinkan untuk melakukan absensi.
                        </p>
                    </div>
                `;

                // Update location info
                (async () => {
                    const alamat = await getCurrentLocation();
                    document.getElementById('currentLocation').textContent = alamat;
                })();
                document.getElementById('distanceFromLocation').textContent = `${distance} m di luar radius`;

                // Show location marker on map
                setTimeout(() => {
                    document.getElementById('currentLocationMarker').classList.remove('hidden');
                    document.getElementById('distanceLine').classList.remove('hidden');

                    // Position marker based on distance (simulasi)
                    const marker = document.getElementById('currentLocationMarker');
                    const line = document.getElementById('distanceLine');

                    // Position marker secara acak di sekitar circle
                    const angle = Math.random() * Math.PI * 2;
                    const radius = 120; // pixels
                    const x = Math.cos(angle) * radius;
                    const y = Math.sin(angle) * radius;

                    marker.style.left = `calc(50% + ${x}px)`;
                    marker.style.top = `calc(50% + ${y}px)`;

                    // Draw line between marker and center
                    line.style.transform = `rotate(${angle}rad)`;
                    line.style.width = `${radius}px`;
                    line.style.left = `50%`;
                    line.style.top = `50%`;
                    line.style.transformOrigin = '0 0';
                }, 100);

            } else if (errorType === 'device') {
                // Setup device error
                document.getElementById('deviceError').classList.remove('hidden');
                document.getElementById('deviceInstructions').classList.remove('hidden');

                errorTypeElement.innerHTML = `
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center px-6 py-3 bg-amber-100 text-amber-700 rounded-full font-bold mb-4">
                            <i class="fas fa-mobile-alt mr-2"></i>
                            ERROR DEVICE
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Device Tidak Terdaftar</h2>
                        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                            Perangkat yang Anda gunakan belum terdaftar dalam sistem absensi MBG.
                        </p>
                    </div>
                `;

                // Update device info
                const deviceId = getDeviceId();
                document.getElementById('deviceId').textContent = deviceId;

                // Generate log ID
                document.getElementById('logId').textContent += deviceId.substr(-6);
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Get error from URL
            const {
                errorType,
                distance
            } = getErrorFromURL();

            // Setup error page
            setupError(errorType, distance);

            // Update time
            updateErrorTime();
            setInterval(updateErrorTime, 1000);

            // Generate log ID
            const logId = 'ERR-' + new Date().getFullYear() + '-' +
                Math.random().toString(36).substr(2, 6).toUpperCase();
            document.getElementById('logId').textContent = logId;

            // Retry button
            document.getElementById('retryButton').addEventListener('click', function() {
                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memvalidasi...';
                this.disabled = true;

                // Simulate validation process
                setTimeout(() => {
                    window.location.href = "<?= base_url('scanner') ?>";
                }, 2000);
            });

            // Contact admin button
            // document.getElementById('contactAdmin').addEventListener('click', function() {
            //     document.getElementById('contactModal').classList.remove('hidden');
            // });

            // Close contact modal
            // document.getElementById('closeContactModal').addEventListener('click', function() {
            //     document.getElementById('contactModal').classList.add('hidden');
            // });

            // Logout button
            // document.getElementById('logoutButton').addEventListener('click', function() {
            //     if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
            //         // Clear any session data
            //         localStorage.removeItem('deviceId');
            //         // Redirect to login
            //         window.location.href = 'login.html';
            //     }
            // });

            // Close modal when clicking outside
            // document.getElementById('contactModal').addEventListener('click', function(e) {
            //     if (e.target === this) {
            //         this.classList.add('hidden');
            //     }
            // });

            // Demo: Simulate location detection
            if (errorType === 'location') {
                setTimeout(() => {
                    const locationElement = document.getElementById('currentLocation');
                    locationElement.innerHTML = `
            <span class="animate-pulse">Mendeteksi lokasi...</span>
        `;

                    setTimeout(async () => {
                        const alamat = await getCurrentLocation();

                        locationElement.innerHTML = `
                <span class="flex items-center">
                    ${alamat}
                    <span class="ml-2 px-2 py-1 bg-error-100 text-error-600 rounded text-xs font-bold">
                        DI LUAR AREA
                    </span>
                </span>
            `;
                    }, 1500);

                }, 500);
            }
        });
    </script>
</body>

</html>