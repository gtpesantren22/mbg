<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi QR Code - Absensi MBG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Gunakan instascan.js yang lebih ringan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
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
        /* Full height layout */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        /* Scanner styles */
        #preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scanner-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 20px;
            background: #000;
        }

        .scanner-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            border: 3px solid #4caf50;
            border-radius: 20px;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);
            z-index: 10;
        }

        /* Scan line animation */
        @keyframes scan {
            0% {
                top: 0%;
            }

            100% {
                top: 100%;
            }
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, transparent, #4caf50, #4caf50, transparent);
            animation: scan 2s linear infinite;
            z-index: 11;
        }

        /* Corner borders */
        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #4caf50;
        }

        .corner-tl {
            top: -4px;
            left: -4px;
            border-right: none;
            border-bottom: none;
            border-radius: 15px 0 0 0;
        }

        .corner-tr {
            top: -4px;
            right: -4px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 15px 0 0;
        }

        .corner-bl {
            bottom: -4px;
            left: -4px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 15px;
        }

        .corner-br {
            bottom: -4px;
            right: -4px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 15px 0;
        }

        /* Success animation */
        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-pulse {
            animation: successPulse 0.5s ease-in-out;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #388e3c;
        }

        /* Full screen adjustments */
        .full-screen-container {
            height: calc(100vh - 80px);
            /* Kurangi tinggi header */
        }

        /* Responsive breakpoints */
        @media (max-width: 768px) {
            .full-screen-container {
                height: calc(100vh - 140px);
                /* Lebih tinggi untuk mobile */
            }

            .split-layout {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                height: auto !important;
                min-height: 50vh;
            }

            .scanner-container {
                height: 60vh;
            }

            .scanner-overlay {
                width: 80%;
                height: 80%;
            }
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-900 text-white h-screen flex flex-col">
    <!-- Header -->
    <div class="w-full text-center py-2 bg-gradient-to-r from-primary-800 to-primary-900">
        <h1 class="text-lg font-bold tracking-wide">
            ABSENSI APP – Dapur MBG Sidomukti Kraksaan
        </h1>
    </div>


    <!-- Main Content - Full Screen Split Layout -->
    <main class="flex-1 overflow-hidden">
        <div class="w-full h-full px-4 lg:px-8 py-4">
            <div class="flex split-layout gap-4 lg:gap-8 h-full">
                <!-- Left Panel (Scanner) - Full Height -->
                <div class="left-panel flex-1 flex flex-col">
                    <!-- Scanner Container -->
                    <div class="bg-gray-800 rounded-2xl p-4 lg:p-6 flex-1 flex flex-col">
                        <div class="text-center mb-4 lg:mb-6">
                            <h2 class="text-lg lg:text-xl font-semibold mb-2">Arahkan Kamera ke QR Code</h2>
                            <p class="text-gray-300 text-sm lg:text-base">Pastikan QR Code berada dalam area kotak scanner</p>
                        </div>

                        <!-- Camera Container - Full Height -->
                        <div class="scanner-container flex-1 mb-4 lg:mb-6">
                            <!-- Scanner Overlay -->
                            <div class="scanner-overlay">
                                <div class="corner corner-tl"></div>
                                <div class="corner corner-tr"></div>
                                <div class="corner corner-bl"></div>
                                <div class="corner corner-br"></div>
                                <div class="scan-line"></div>
                            </div>

                            <!-- Video Preview -->
                            <video id="preview" playsinline></video>

                            <!-- Camera Off State -->
                            <div id="cameraOff" class="absolute inset-0 flex items-center justify-center bg-black">
                                <div class="text-center p-6 lg:p-8">
                                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-video-slash text-gray-400 text-2xl lg:text-3xl"></i>
                                    </div>
                                    <p class="text-gray-300 mb-4 text-base lg:text-lg">Kamera tidak aktif</p>
                                    <button id="startCamera" class="bg-primary-600 hover:bg-primary-700 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-xl transition text-base lg:text-lg">
                                        <i class="fas fa-play mr-2 lg:mr-3"></i>Aktifkan Kamera
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Camera Controls -->
                        <div class="flex justify-center space-x-4 lg:space-x-6">
                            <button id="switchCamera" class="bg-gray-700 hover:bg-gray-600 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-xl transition flex items-center text-base lg:text-lg">
                                <i class="fas fa-sync-alt mr-2 lg:mr-3"></i> Ganti Kamera
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Panel (History & Results) - Full Height -->
                <div class="right-panel w-full lg:w-1/2 flex flex-col">
                    <!-- Result Section -->
                    <div class="flex-1 flex flex-col space-y-4 lg:space-y-6">
                        <!-- Employee Info Card -->
                        <!-- <div id="employeeCard" class="hidden bg-gradient-to-r from-primary-800 to-secondary-800 rounded-2xl p-4 lg:p-6 success-pulse">
                            <div class="flex items-center">
                                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-white/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white text-xl lg:text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 id="employeeName" class="text-lg lg:text-xl font-bold mb-2"></h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs lg:text-sm opacity-80 mb-1">ID Karyawan</div>
                                            <div id="employeeId" class="font-semibold text-base lg:text-lg"></div>
                                        </div>
                                        <div>
                                            <div class="text-xs lg:text-sm opacity-80 mb-1">Divisi</div>
                                            <div id="employeeDivision" class="font-semibold text-base lg:text-lg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Attendance Status -->
                        <div id="attendanceStatus" class=" bg-gray-800 rounded-2xl p-4 lg:p-6">
                            <div class="flex items-center mb-4">
                                <div id="statusIcon" class="w-12 h-12 lg:w-16 lg:h-16 rounded-full flex items-center justify-center mr-4">
                                    <!-- Icon akan diisi oleh JavaScript -->
                                </div>
                                <div class="flex-1">
                                    <h3 id="statusTitle" class="text-lg lg:text-xl font-bold mb-1"></h3>
                                    <p id="statusMessage" class="text-gray-300 text-sm lg:text-base"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-900 rounded-xl p-3 lg:p-4">
                                    <div class="text-xs lg:text-sm text-gray-400 mb-1">Waktu Scan</div>
                                    <div id="scanTime" class="font-bold text-base lg:text-lg"></div>
                                </div>
                                <div class="bg-gray-900 rounded-xl p-3 lg:p-4">
                                    <div class="text-xs lg:text-sm text-gray-400 mb-1">Status</div>
                                    <div id="attendanceType" class="font-bold text-base lg:text-lg"></div>
                                </div>
                            </div>
                        </div>

                        <!-- History Section -->
                        <div class="bg-gray-800 rounded-2xl p-4 lg:p-6 flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-4 lg:mb-6">
                                <h3 class="text-lg lg:text-xl font-semibold flex items-center">
                                    <i class="fas fa-history mr-2 lg:mr-3"></i>
                                    Riwayat Hari Ini
                                </h3>
                                <div class="text-right">
                                    <div class="text-xl lg:text-2xl font-bold text-primary-400" id="totalAttendance">0</div>
                                    <div class="text-xs lg:text-sm text-gray-400">Total Absensi</div>
                                </div>
                            </div>

                            <!-- Stats Cards -->


                            <!-- History List -->
                            <div class="flex-1 overflow-hidden">
                                <div id="attendanceHistory" class="h-full overflow-y-auto custom-scrollbar pr-2 space-y-3">
                                    <!-- Riwayat akan diisi oleh JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Demo Panel - Desktop Only -->
    <!-- <div class="hidden lg:block fixed bottom-8 right-8 bg-gray-800 p-4 lg:p-6 rounded-2xl shadow-2xl" style="width: 280px;">
        <div class="flex items-center mb-3 lg:mb-4">
            <i class="fas fa-flask text-primary-400 text-lg lg:text-xl mr-2 lg:mr-3"></i>
            <h4 class="text-base lg:text-lg font-semibold">Mode Demo</h4>
        </div>
        <p class="text-gray-300 text-xs lg:text-sm mb-3 lg:mb-4">Klik untuk simulasi scan QR:</p>
        <div class="space-y-2 lg:space-y-3">
            <button class="demo-scan w-full bg-primary-600 hover:bg-primary-700 text-white py-2 lg:py-3 rounded-xl transition flex items-center justify-center text-sm lg:text-base"
                data-id="MBG001" data-type="CHECKIN">
                <i class="fas fa-sign-in-alt mr-2 lg:mr-3"></i>
                Ahmad (Masuk)
            </button>
            <button class="demo-scan w-full bg-primary-600 hover:bg-primary-700 text-white py-2 lg:py-3 rounded-xl transition flex items-center justify-center text-sm lg:text-base"
                data-id="MBG002" data-type="CHECKIN">
                <i class="fas fa-sign-in-alt mr-2 lg:mr-3"></i>
                Siti (Masuk)
            </button>
            <button class="demo-scan w-full bg-secondary-600 hover:bg-secondary-700 text-white py-2 lg:py-3 rounded-xl transition flex items-center justify-center text-sm lg:text-base"
                data-id="MBG003" data-type="CHECKOUT">
                <i class="fas fa-sign-out-alt mr-2 lg:mr-3"></i>
                Budi (Pulang)
            </button>
        </div>
    </div> -->

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-gradient-to-b from-green-600 to-green-800 text-white rounded-2xl p-6 lg:p-8 max-w-sm lg:max-w-md w-full text-center">
            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6">
                <i class="fas fa-check text-white text-2xl lg:text-3xl"></i>
            </div>
            <h3 class="text-xl lg:text-2xl font-bold mb-2 lg:mb-3">Absensi Berhasil!</h3>
            <p id="modalEmployeeName" class="text-base lg:text-lg mb-3 lg:mb-4"></p>
            <p id="modalAttendanceTime" class="text-xl lg:text-2xl font-bold mb-6 lg:mb-8"></p>
            <button id="closeModal" class="w-full bg-white text-green-600 py-3 lg:py-4 rounded-xl font-bold hover:bg-gray-100 transition text-base lg:text-lg">
                OKE
            </button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let attendanceHistory = [];
        let scanner = null;
        let cameras = [];
        let activeCameraIndex = 0;
        let audioCtx;

        const activeCamera = 'environment'; // default
        const employees = {}; // pastikan ini diisi dari server

        // =========================
        // Utility
        // =========================
        function formatTime(date) {
            return date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }


        function updateStats() {
            document.getElementById('totalAttendance').textContent = attendanceHistory.length;
        }

        function renderAttendanceHistory() {
            $.ajax({
                url: "<?= base_url('scanner/getHistory') ?>",
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    attendanceHistory = data.map(item => ({
                        employeeId: item.employee_id,
                        name: item.full_name,
                        time: item.pulang && item.pulang != '00:00:00' ? item.pulang : item.masuk,
                        type: item.pulang && item.pulang != '00:00:00' ? 'Pulang' : 'Masuk'
                    }));

                    // ---- Rendering history ----
                    const container = document.getElementById('attendanceHistory');
                    container.innerHTML = '';

                    if (attendanceHistory.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-history text-2xl lg:text-3xl mb-3"></i>
                                <p class="text-base lg:text-lg">Belum ada absensi hari ini</p>
                                <p class="text-xs lg:text-sm mt-2">Mulai scan QR code untuk melihat riwayat</p>
                            </div>`;
                        updateStats();
                        return;
                    }

                    attendanceHistory.forEach(record => {
                        const historyItem = document.createElement('div');
                        historyItem.className = 'flex items-center justify-between bg-gray-900 p-3 rounded-xl hover:bg-gray-850 transition-all';

                        historyItem.innerHTML = `
                            <div class="flex items-center min-w-0">
                                <div class="w-10 h-10 lg:w-12 lg:h-12 ${record.type === 'Masuk' ? 'bg-green-600' : 'bg-blue-600'} rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas ${record.type === 'Masuk' ? 'fa-sign-in-alt' : 'fa-sign-out-alt'} text-white text-sm lg:text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium truncate">${record.name}</div>
                                    <div class="text-xs lg:text-sm text-gray-400 truncate">${record.employeeId} • ${record.time}</div>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0">
                                <span class="px-2 lg:px-3 py-1 rounded-full text-xs font-medium ${record.type === 'Masuk' ? 'bg-green-900 text-green-300' : 'bg-blue-900 text-blue-300'}">
                                    ${record.type}
                                </span>
                            </div>
                        `;
                        container.appendChild(historyItem);
                    });

                    updateStats();
                }
            });
        }


        // =========================
        // Scanner
        // =========================
        function initScanner() {
            const video = document.getElementById('preview');

            if (scanner) scanner.stop();

            scanner = new Instascan.Scanner({
                video: video,
                mirror: false,
                scanPeriod: 5,
                refractoryPeriod: 3000,
                continuous: true
            });

            scanner.addListener('scan', handleQRScan);

            Instascan.Camera.getCameras().then(camList => {
                cameras = camList;
                if (cameras.length === 0) {
                    showError("Kamera tidak ditemukan");
                    document.getElementById('cameraOff').style.display = 'flex';
                    return;
                }

                activeCameraIndex = cameras.length > 1 ? 0 : 0;
                scanner.start(cameras[activeCameraIndex]).then(() => {
                    document.getElementById('cameraOff').style.display = 'none';
                }).catch(err => {
                    console.error(err);
                    showError("Gagal memulai kamera");
                    document.getElementById('cameraOff').style.display = 'flex';
                });
            }).catch(err => {
                console.error(err);
                showError("Gagal mengakses kamera");
                document.getElementById('cameraOff').style.display = 'flex';
            });
        }

        function stopCamera() {
            if (scanner) scanner.stop();
            const video = document.getElementById('preview');
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        }

        // =========================
        // QR Handling
        // =========================
        function handleQRScan(content) {
            stopCamera()
            $.ajax({
                url: "<?= base_url('scanner/input') ?>", // Controller & method CI
                method: "POST",
                data: {
                    qrhasil: content
                },
                dataType: "json",
                success: function(res) {
                    if (res.status == 'success') {
                        showScanResult(res.nama, res.ket == 'Masuk' ? true : false)
                        initScanner()
                    } else {
                        showError(res.message || 'Gagal menyimpan absensi');
                        initScanner()
                    }
                },
                error: function(err) {
                    console.error(err);
                    showError('Terjadi kesalahan server');
                    initScanner()
                }
            });
        }



        function showScanResult(nama, isCheckIn) {
            const now = new Date();
            const currentTime = formatTime(now);
            const attendanceType = isCheckIn ? 'Masuk' : 'Pulang';

            // Status
            document.getElementById('attendanceStatus').classList.remove('hidden');
            const statusIcon = document.getElementById('statusIcon');
            statusIcon.className = 'w-12 h-12 lg:w-16 lg:h-16 rounded-full flex items-center justify-center mr-4 success-pulse';
            statusIcon.style.backgroundColor = isCheckIn ? '#2e7d32' : '#1565c0';
            statusIcon.innerHTML = `<i class="fas ${isCheckIn ? 'fa-sign-in-alt' : 'fa-sign-out-alt'} text-white text-xl lg:text-2xl"></i>`;

            document.getElementById('statusTitle').textContent = nama;
            document.getElementById('statusMessage').textContent = `Selamat ${isCheckIn ? 'bekerja' : 'pulang'}!`;
            document.getElementById('scanTime').textContent = currentTime;
            document.getElementById('attendanceType').textContent = attendanceType;

            renderAttendanceHistory();

            // Modal sukses
            document.getElementById('modalEmployeeName').textContent = nama;
            document.getElementById('modalAttendanceTime').textContent = `${attendanceType} - ${currentTime}`;
            document.getElementById('successModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('successModal').classList.add('hidden');
            }, 2000);

            playBeepSound()
        }

        function showError(message) {
            const statusIcon = document.getElementById('statusIcon');
            statusIcon.className = 'w-12 h-12 lg:w-16 lg:h-16 bg-red-600 rounded-full flex items-center justify-center mr-4';
            statusIcon.innerHTML = `<i class="fas fa-times text-white text-xl lg:text-2xl"></i>`;
            statusIcon.style.backgroundColor = '#ff2929ff';

            document.getElementById('statusTitle').textContent = 'Gagal';
            document.getElementById('statusMessage').textContent = message;
            document.getElementById('scanTime').textContent = formatTime(new Date());
            document.getElementById('attendanceType').textContent = 'Error';
        }

        function playBeepSound() {
            if (!audioCtx) return; // jika belum ada interaksi
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.frequency.value = 800;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);

            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.5);
        }


        // =========================
        // Event Listener
        // =========================
        document.addEventListener('DOMContentLoaded', () => {
            renderAttendanceHistory();
            if (!audioCtx) {
                audioCtx = new(window.AudioContext || window.webkitAudioContext)();
            }
            document.getElementById('startCamera').addEventListener('click', initScanner);
            document.getElementById('switchCamera').addEventListener('click', () => {
                if (cameras.length <= 1) return;
                activeCameraIndex = (activeCameraIndex + 1) % cameras.length;
                scanner.start(cameras[activeCameraIndex]);
            });
            document.getElementById('closeModal').addEventListener('click', () => {
                document.getElementById('successModal').classList.add('hidden');
            });

            // Mulai kamera otomatis
            initScanner();
        });

        window.addEventListener('beforeunload', stopCamera);
    </script>

</body>

</html>