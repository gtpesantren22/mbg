<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
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
        html,
        body {
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            background: #f8fafc;
            color: #111827;
        }

        /* Scanner */
        #preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .scanner-container {
            position: relative;
            width: 100%;
            min-height: 60vh;
            overflow: hidden;
            border-radius: 20px;
            background: #000;
        }

        .scanner-overlay {
            position: absolute;
            inset: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            border: 3px solid #43a047;
            border-radius: 20px;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, .45);
            z-index: 10;
        }

        @keyframes scan {
            from {
                top: 0;
            }

            to {
                top: 100%;
            }
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, transparent, #22c55e, transparent);
            animation: scan 2s linear infinite;
        }

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
        }

        .corner-tr {
            top: -4px;
            right: -4px;
            border-left: none;
            border-bottom: none;
        }

        .corner-bl {
            bottom: -4px;
            left: -4px;
            border-right: none;
            border-top: none;
        }

        .corner-br {
            bottom: -4px;
            right: -4px;
            border-left: none;
            border-top: none;
        }

        /* Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #e5e7eb;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #43a047;
        }

        /* Mobile */
        @media (max-width:768px) {
            .split-layout {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100% !important;
            }

            .scanner-overlay {
                width: 80%;
                height: 80%;
            }
        }
    </style>

</head>

<body class="bg-slate-50 text-gray-900 min-h-screen flex flex-col">

    <!-- HEADER -->
    <div class="w-full flex items-center justify-between px-4 py-2 
            bg-gradient-to-r from-primary-600 to-primary-700 text-white">

        <!-- Title -->
        <h1 class="text-sm sm:text-lg font-bold tracking-wide text-center flex-1">
            ABSENSI APP – Dapur MBG Sidomukti Kraksaan
        </h1>

        <!-- Fullscreen Button -->
        <button id="btnFullscreen"
            class="ml-2 w-6 h-6 rounded-full flex items-center justify-center
               bg-white/20 hover:bg-white/30 transition
               focus:outline-none focus:ring-2 focus:ring-white/50"
            title="Mode Layar Penuh">

            <!-- Icon Expand -->
            <svg id="iconExpand" xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4" />
            </svg>

            <!-- Icon Compress (hidden) -->
            <svg id="iconCompress" xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 4H4v5M15 4h5v5M9 20H4v-5M15 20h5v-5" />
            </svg>
        </button>
    </div>


    <main class="flex-1 overflow-y-auto">
        <div class="px-4 lg:px-8 py-4">
            <div class="flex split-layout gap-6">

                <!-- LEFT -->
                <div class="left-panel flex-1">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 flex flex-col">

                        <h2 class="text-xl font-semibold text-center mb-2">Arahkan Kamera ke QR Code</h2>
                        <p class="text-gray-600 text-center mb-4">Pastikan QR Code berada di dalam kotak</p>

                        <div class="scanner-container mb-4">
                            <div class="scanner-overlay">
                                <div class="corner corner-tl"></div>
                                <div class="corner corner-tr"></div>
                                <div class="corner corner-bl"></div>
                                <div class="corner corner-br"></div>
                                <div class="scan-line"></div>
                            </div>
                            <video id="preview" playsinline></video>

                            <div id="cameraOff" class="absolute inset-0 bg-white/90 flex items-center justify-center">
                                <button id="startCamera" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl">
                                    Aktifkan Kamera
                                </button>
                            </div>
                        </div>

                        <button id="switchCamera" class="mx-auto bg-gray-100 hover:bg-gray-200 px-6 py-3 rounded-xl">
                            Ganti Kamera
                        </button>

                    </div>
                </div>

                <!-- RIGHT -->
                <div class="right-panel w-1/2 flex flex-col gap-6">

                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h3 class="text-xl font-bold mb-2" id="statusTitle"></h3>
                        <p class="text-gray-600 mb-4" id="statusMessage"></p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-100 p-4 rounded-xl">
                                <div class="text-sm text-gray-500">Waktu Scan</div>
                                <div id="scanTime" class="font-bold"></div>
                            </div>
                            <div class="bg-slate-100 p-4 rounded-xl">
                                <div class="text-sm text-gray-500">Status</div>
                                <div id="attendanceType" class="font-bold"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 flex-1 flex flex-col">
                        <div class="flex justify-between mb-4">
                            <h3 class="text-xl font-semibold">Riwayat Hari Ini</h3>
                            <div class="text-primary-600 font-bold text-2xl" id="totalAttendance">0</div>
                        </div>
                        <div id="attendanceHistory" class="flex-1 overflow-y-auto custom-scrollbar space-y-3 pr-2"></div>
                    </div>

                </div>
            </div>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let attendanceHistory = [];
        let scanner = null;
        let cameras = [];
        let activeCameraIndex = 0;
        let audioCtx;
        const btnFullscreen = document.getElementById('btnFullscreen');
        const iconExpand = document.getElementById('iconExpand');
        const iconCompress = document.getElementById('iconCompress');

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

        btnFullscreen.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    iconExpand.classList.add('hidden');
                    iconCompress.classList.remove('hidden');
                });
            } else {
                document.exitFullscreen().then(() => {
                    iconCompress.classList.add('hidden');
                    iconExpand.classList.remove('hidden');
                });
            }
        });

        // Handle ESC / gesture exit fullscreen
        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                iconCompress.classList.add('hidden');
                iconExpand.classList.remove('hidden');
            }
        });


        function updateStats() {
            $.ajax({
                url: "<?= base_url('scanner/getHistoryAll') ?>",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    document.getElementById('totalAttendance').textContent = data;
                }
            })
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
                                    <i class="fas ${record.type === 'Masuk' ? 'fa-sign-in-alt' : 'fa-sign-out-alt'} text-gray-900 text-sm lg:text-base"></i>
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
            statusIcon.innerHTML = `<i class="fas ${isCheckIn ? 'fa-sign-in-alt' : 'fa-sign-out-alt'} text-gray-900 text-xl lg:text-2xl"></i>`;

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
            statusIcon.innerHTML = `<i class="fas fa-times text-gray-900 text-xl lg:text-2xl"></i>`;
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