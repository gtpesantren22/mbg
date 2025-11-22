<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around py-3 shadow-lg">
    <a href="<?= base_url('karyawan') ?>" class="flex flex-col items-center text-primary-600">
        <i class="fas fa-home text-lg"></i>
        <span class="text-xs mt-1">Beranda</span>
    </a>
    <a href="<?= base_url('karyawan/riwayat') ?>" class="flex flex-col items-center text-gray-500">
        <i class="fas fa-history text-lg"></i>
        <span class="text-xs mt-1">Riwayat</span>
    </a>
    <a href="<?= base_url('karyawan/profil') ?>" class="flex flex-col items-center text-gray-500">
        <i class="fas fa-user text-lg"></i>
        <span class="text-xs mt-1">Profil</span>
    </a>
</nav>