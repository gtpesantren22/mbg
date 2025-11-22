<?php include 'head.php' ?>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6">

    <!-- Riwayat Absensi -->
    <div class="bg-white rounded-2xl shadow-sm p-5 mb-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Kehadiran Saya</h2>
            <a href="<?= base_url('karyawan') ?>" class="text-secondary-600 text-sm font-medium flex items-center">
                <i class="fas fa-chevron-left ml-1 text-xs"></i> Kembali
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
</main>

<?php include 'btnav.php' ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    })
</script>
</body>

</html>