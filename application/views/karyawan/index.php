<?php include 'head.php' ?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6">
    <!-- Status Absensi Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm p-5 mb-6 border border-gray-100">
        <h2 class="text-gray-500 text-sm font-medium mb-2">Status Absensi Hari Ini</h2>

        <?php if ($izin) { ?>
            <div class="flex items-center justify-between">
                <div id="" class="text-2xl font-bold text-amber-600">Izin</div>
                <div id="" class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-warning text-amber-400 text-xl"></i>
                </div>
            </div>
            <div id="statusTime" class="text-amber-500 text-sm mt-2">
                Hari ini anda izin <?= $izin->alasan ?>
            </div>
        <?php } elseif (!$data) { ?>
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
        if ($izin) {
            $inbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
            $outbtn = 'bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-2xl p-5 shadow-lg transform flex flex-col items-center justify-center opacity-70 cursor-not-allowed';
            $indsbld = 'disabled';
            $outdsbld = 'disabled';
        } else if (!$data) {
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
            <a href="<?= base_url('karyawan/riwayat') ?>" class="text-secondary-600 text-sm font-medium flex items-center">
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
                        <span class="font-semibold text-green">Hadir</span>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-primary-700"><?= $all->jumlah ?></div>
            <div class="text-xs text-gray-500 mt-1">Hadir Bulan Ini</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-amber-600">0</div>
            <div class="text-xs text-gray-500 mt-1">Izin</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-secondary-600">0%</div>
            <div class="text-xs text-gray-500 mt-1">Kehadiran</div>
        </div>
    </div>
</main>

<?php include 'btnav.php' ?>

<!-- Modal Absen dengan QR Scanner -->
<div id="attendanceModal"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 mx-4 max-w-sm w-full">
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-2" id="modalTitle">Scan QR untuk Absen</h3>
            <p class="text-gray-600 mb-4" id="modalMessage">Arahkan kamera ke QR code absensi.</p>

            <p class="text-gray-600 mb-2" id="infoProses"></p>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.onload = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    console.log("✅ Izin lokasi diberikan");
                },
                function(error) {
                    console.warn("❌ Gagal mendapatkan lokasi:", error.message);
                }, {
                    enableHighAccuracy: true
                }
            );
        } else {
            alert("Browser Anda tidak mendukung fitur lokasi (GPS).");
        }
    };

    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type) {
        if (type === 'success') {
            Swal.fire({
                title: "Berhasil!",
                text: message,
                icon: "success"
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Gagal...!",
                text: message,
            });
        }
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
            $('#infoProses').text('')
            html5QrCode.start(
                cameraId,
                config,
                qrCodeMessage => {
                    console.log("✅ QR Terdeteksi:", qrCodeMessage);
                    stopCamera();
                    $('#infoProses').text('Absensi sedang diproses....')
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
                    // console.log("Scanning...", errorMessage);
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
                console.log("Detected cameras:", devices); // DEBUG

                if (devices && devices.length) {
                    cameras = devices;

                    // Pilih kamera belakang jika ada
                    const backCamera = devices.find(d =>
                        /back|rear|environment/i.test(d.label)
                    );

                    const selected = backCamera || devices[0];

                    currentCameraIndex = devices.indexOf(selected);

                    startCamera(selected.id);
                } else {
                    alert("Tidak ada kamera terdeteksi!");
                }
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