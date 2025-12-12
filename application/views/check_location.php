<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memvalidasi Lokasi - Absensi MBG</title>
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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Animasi loading */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) translateX(0px);
            }

            25% {
                transform: translateY(-5px) translateX(5px);
            }

            50% {
                transform: translateY(0px) translateX(10px);
            }

            75% {
                transform: translateY(5px) translateX(5px);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        .spin-animation {
            animation: spin 2s linear infinite;
        }

        .bounce-animation {
            animation: bounce 1s infinite;
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Progress bar animation */
        @keyframes progress {
            0% {
                width: 0%;
            }

            100% {
                width: 100%;
            }
        }

        .progress-animation {
            animation: progress 3s linear infinite;
        }

        /* Background dots */
        .bg-dots {
            background-image: radial-gradient(#4caf50 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Loading Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Animated Icon -->
            <div class="relative mb-8">
                <div class="absolute inset-0">
                    <div class="w-32 h-32 bg-primary-100 rounded-full mx-auto pulse-animation"></div>
                </div>
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-white text-3xl bounce-animation"></i>
                    </div>
                </div>

                <!-- Floating dots around icon -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-4 h-4 bg-primary-300 rounded-full float-animation"></div>
                </div>
                <div class="absolute top-1/2 right-0 translate-x-1/2 -translate-y-1/2">
                    <div class="w-3 h-3 bg-primary-400 rounded-full float-animation" style="animation-delay: 0.5s;"></div>
                </div>
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                    <div class="w-3 h-3 bg-primary-300 rounded-full float-animation" style="animation-delay: 1s;"></div>
                </div>
                <div class="absolute top-1/2 left-0 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-4 h-4 bg-primary-400 rounded-full float-animation" style="animation-delay: 1.5s;"></div>
                </div>
            </div>

            <!-- Title and Message -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Memvalidasi Lokasi</h1>
            <p class="text-gray-600 mb-8">
                Sistem sedang memverifikasi lokasi Anda. Harap tunggu sebentar...
            </p>

            <!-- Estimated Time -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-center">
                    <i class="fas fa-clock text-primary-500 mr-2"></i>
                    <span class="text-sm text-gray-600">Proses validasi membutuh beberapa waktu.... </span>
                    <!-- <span class="ml-1 font-medium text-primary-600" id="">5 detik</span> -->
                </div>
            </div>


        </div>

        <!-- Footer Info -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            <p>
                <i class="fas fa-info-circle mr-1"></i>
                Pastikan GPS/lokasi diaktifkan untuk proses validasi
            </p>
        </div>
    </div>

</body>
<script>
    function requestLocation() {
        if (!navigator.geolocation) {
            alert("Browser tidak mendukung GPS");
            window.location.href = "<?= base_url('scanner/errorJarak') ?>";
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                let lat = pos.coords.latitude;
                let lon = pos.coords.longitude;

                // Kirim ke server untuk validasi radius
                fetch("<?= base_url('scanner/cekAlamat') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "latitude=" + lat + "&longitude=" + lon
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.status === "error") {
                            // alert(res.message);
                            window.location.href = "<?= base_url('scanner/errorJarak?error=location&distance=') ?>" + res.jarak + '&lon=' + res.lon + '&lat=' + res.lat;
                        } else {
                            window.location.href = "<?= base_url('scanner/qrSannerEmployeesByIDQR') ?>";
                        }
                    });
            },
            function(err) {
                alert("Izin lokasi ditolak. Aktifkan GPS untuk melanjutkan.");
                window.location.href = "<?= base_url('scanner/errorJarak') ?>";
            }
        );
    }

    window.onload = requestLocation;
</script>

</html>