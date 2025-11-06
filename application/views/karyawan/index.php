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
                        <a href="login.html" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <!-- Status Absensi Hari Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-5 mb-6 border border-gray-100">
            <h2 class="text-gray-500 text-sm font-medium mb-2">Status Absensi Hari Ini</h2>

            <?php if (!$data) { ?>
                <!-- Belum Hadir -->
                <div class="flex items-center justify-between">
                    <div id="" class="text-2xl font-bold text-gray-700">Belum Hadir</div>
                    <div id="" class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-gray-400 text-xl"></i>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Hadir -->
                <div class="flex items-center justify-between">
                    <div id="" class="text-2xl font-bold text-primary-700">Hadir</div>
                    <div id="" class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-primary-600 text-xl"></i>
                    </div>
                </div>
                <div id="statusTime" class="text-gray-500 text-sm mt-2">
                    Masuk : <span><?= date('H:i', strtotime($data->masuk)) ?></span> | Pulang : <span id=""><?= date('H:i', strtotime($data->pulang)) ?></span>
                </div>
            <?php } ?>
        </div>

        <!-- Tombol Absensi -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <!-- Tombol Absen Masuk -->
            <?php
            if (!$data) {
                $inbtn = 'bg-gradient-to-r from-secondary-600 to-secondary-700 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200 flex flex-col items-center justify-center';
                $outbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
                $indsbld = '';
                $outdsbld = 'disabled';
            } elseif ($data && $data->masuk != '00:00:00' && $data->pulang == '00:00:00') {
                $inbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
                $outbtn = 'bg-gradient-to-r from-secondary-600 to-secondary-700 text-white rounded-2xl p-5 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200 flex flex-col items-center justify-center';
                $indsbld = 'disabled';
                $outdsbld = '';
            } else {
                $inbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
                $outbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
                $indsbld = 'disabled';
                $outdsbld = 'disabled';
            }
            ?>
            <button
                id="checkinBtn"
                class="<?= $inbtn ?>" <?= $indsbld ?>>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-fingerprint text-2xl"></i>
                </div>
                <span class="font-semibold text-lg">Absen Masuk</span>
                <span class="text-white/90 text-sm mt-1">Tap untuk absen</span>
            </button>

            <!-- Tombol Absen Pulang -->
            <button
                id="checkoutBtn"
                class="<?= $outbtn ?>" <?= $outdsbld ?>>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-qrcode text-2xl"></i>
                </div>
                <span class="font-semibold text-lg">Absen Pulang</span>
                <span class="text-white/90 text-sm mt-1">Tap untuk absen</span>
            </button>
        </div>

        <!-- Riwayat Absensi -->
        <div class="bg-white rounded-2xl shadow-sm p-5 mb-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Terbaru</h2>
                <a href="riwayat.html" class="text-secondary-600 text-sm font-medium flex items-center">
                    Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>

            <div id="" class="space-y-4">
                <div id="" class="space-y-4">
                    <?php foreach ($hasil as $rw): ?>
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <div class="font-medium text-gray-800"><?= tanggal_indo($rw->tanggal, true) ?></div>
                                <div class="text-xs text-gray-500"><?= date('H:i', strtotime($rw->masuk)) . ' - ' . date('H:i', strtotime($rw->pulang)) ?></div>
                            </div>
                            <span class="font-semibold">${item.status}</span>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
                <div class="text-2xl font-bold text-primary-700">24</div>
                <div class="text-xs text-gray-500 mt-1">Hadir Bulan Ini</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
                <div class="text-2xl font-bold text-amber-600">1</div>
                <div class="text-xs text-gray-500 mt-1">Terlambat</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
                <div class="text-2xl font-bold text-secondary-600">98%</div>
                <div class="text-xs text-gray-500 mt-1">Kehadiran</div>
            </div>
        </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-3 shadow-lg">
        <a href="beranda.html" class="flex flex-col items-center text-primary-600">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs mt-1">Beranda</span>
        </a>
        <a href="riwayat.html" class="flex flex-col items-center text-gray-500">
            <i class="fas fa-history text-lg"></i>
            <span class="text-xs mt-1">Riwayat</span>
        </a>
        <!-- <a href="izin.html" class="flex flex-col items-center text-gray-500">
            <i class="fas fa-file-alt text-lg"></i>
            <span class="text-xs mt-1">Izin</span>
        </a> -->
        <a href="profil.html" class="flex flex-col items-center text-gray-500">
            <i class="fas fa-user text-lg"></i>
            <span class="text-xs mt-1">Profil</span>
        </a>
    </nav>

    <!-- Modal Absen dengan QR Scanner -->
    <div id="attendanceModal"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-6 mx-4 max-w-sm w-full">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-800 mb-2" id="modalTitle">Scan QR untuk Absen</h3>
                <p class="text-gray-600 mb-4" id="modalMessage">Arahkan kamera ke QR code absensi.</p>

                <!-- Area kamera -->
                <div id="qrReader" class="rounded-xl overflow-hidden border border-gray-200"></div>

                <!-- Tombol aksi -->
                <div class="flex space-x-3 mt-4">
                    <button id="switchCamera"
                        class="px-3 py-2 text-sm bg-gray-100 rounded-lg hover:bg-gray-200 flex items-center">
                        <i class="bi bi-camera-reverse me-1"></i> Ganti Kamera
                    </button>
                    <button id="modalCancel"
                        class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-xl font-medium">
                        Batal
                    </button>
                    <audio id="success-sound" src="<?= base_url('assets/audio/berhasil.mp3') ?>"></audio>
                    <audio id="error-sound" src="<?= base_url('assets/audio/tidak_ada.mp3') ?>">"></audio>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type) {
            // Buat elemen notifikasi
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 transform transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Hapus notifikasi setelah 3 detik
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Render riwayat absensi
            const switchBtn = document.getElementById('switchCamera');
            let html5QrCode;
            let cameras = [];
            let currentCameraIndex = 0;

            // Event listener untuk tombol absen masuk
            document.getElementById('checkinBtn').addEventListener('click', function() {
                if (!this.disabled) {
                    document.getElementById('modalTitle').textContent = 'Scan QR Absen Masuk';
                    document.getElementById('modalMessage').textContent = 'Arahkan kamera anda ke QR Code yang sudah disediakan!';
                    // document.getElementById('modalConfirm').onclick = checkIn;
                    document.getElementById('attendanceModal').classList.remove('hidden');
                    openModalWithCamera()
                }
            });

            // Event listener untuk tombol absen pulang
            document.getElementById('checkoutBtn').addEventListener('click', function() {
                if (!this.disabled) {
                    document.getElementById('modalTitle').textContent = 'Konfirmasi Absen Pulang';
                    document.getElementById('modalMessage').textContent = 'Apakah Anda yakin ingin melakukan absen pulang sekarang?';
                    // document.getElementById('modalConfirm').onclick = checkOut;
                    document.getElementById('attendanceModal').classList.remove('hidden');
                    openModalWithCamera()
                }
            });

            // Event listener untuk tombol batal di modal
            document.getElementById('modalCancel').addEventListener('click', function() {
                document.getElementById('attendanceModal').classList.add('hidden');
                stopCamera()
            });

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

            function startCamera(cameraId) {
                html5QrCode = new Html5Qrcode("qrReader");
                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                };
                html5QrCode.start(
                    cameraId,
                    config,
                    qrCodeMessage => {
                        console.log("✅ QR Terdeteksi:", qrCodeMessage);
                        stopCamera();
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                function(pos) {
                                    sendAbsen(pos, qrCodeMessage)
                                },
                                function(err) {
                                    alert("Gagal mendapatkan lokasi! " + err.message);
                                }, {
                                    enableHighAccuracy: true
                                }
                            );
                        } else {
                            alert("Browser Anda tidak mendukung GPS!");
                        }
                    },
                    errorMessage => {
                        console.log("Scanning...", errorMessage);
                    }
                ).catch(err => console.error("Gagal memulai kamera:", err));
            }

            function stopCamera() {
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        html5QrCode.clear();
                    }).catch(err => {
                        console.error("Gagal menghentikan kamera:", err);
                    });
                }
            }

            function openModalWithCamera() {
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        cameras = devices;
                        currentCameraIndex = 0;
                        startCamera(cameras[currentCameraIndex].id);
                    } else {
                        alert("Tidak ada kamera terdeteksi!");
                    }
                }).catch(err => {
                    console.error("Tidak dapat mengakses kamera:", err);
                });
            }

            // 🔄 Ganti kamera (front/back)
            switchBtn.addEventListener('click', () => {
                if (cameras.length > 1) {
                    stopCamera();
                    currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
                    startCamera(cameras[currentCameraIndex].id);
                } else {
                    alert("Hanya ada satu kamera di perangkat ini.");
                }
            });

            function sendAbsen(pos, hasil) {
                soundToPlay = document.getElementById("success-sound");
                soundToPlayErr = document.getElementById("error-sound");
                const latitude = pos.coords.latitude;
                const longitude = pos.coords.longitude;

                // alert(latitude + ' : ' + longitude)
                $.ajax({
                    url: '<?= base_url('karyawan/input') ?>',
                    type: 'post',
                    data: {
                        qrhasil: hasil,
                        latitude: latitude,
                        longitude: longitude
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 'success') {
                            showNotification(res.message, 'success')
                            soundToPlay.play().catch(err => console.error("Error playing sound:", err));
                            document.getElementById('attendanceModal').classList.add('hidden');
                            setTimeout(function() {
                                window.location.reload()
                            }, 1500);
                        } else {
                            showNotification(res.message, 'error')
                            soundToPlayErr.play().catch(err => console.error("Error playing sound:", err));
                            openModalWithCamera()
                        }
                    },
                    error: function(xhr, status, error) {
                        showNotification(xhr.responseText, 'error')
                    }
                })
            }

        });
    </script>
</body>

</html>