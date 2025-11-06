<?php $this->load->view('admin/head'); ?>

<!-- Main Content -->
<div class="md:pl-64 flex flex-col flex-1">
    <!-- Desktop Header -->
    <div class="hidden md:block bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900"><?= $title ?></h1>
                        <p class="text-gray-600"><?= $title2 ?></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900"><?= $user['name'] ?></p>
                            <p class="text-xs text-gray-500">Super Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1 p-4 md:p-6">
        <!-- Mobile Page Title -->
        <div class="md:hidden mb-6">
            <h1 class="text-xl font-bold text-gray-900"><?= $title ?></h1>
            <p class="text-gray-600 text-sm"><?= $title2 ?></p>
        </div>

        <!-- Charts & Tables Section -->
        <div class="space-y-6">
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

            <!-- Tabel Karyawan -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center md:px-6 md:py-4">
                    <h3 class="text-base font-medium text-gray-900 md:text-lg">Daftar Karyawan</h3>
                    <button class="bg-primary-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-primary-700 flex items-center md:px-4 md:text-sm" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'addEmployee' }))">
                        <i class="fas fa-plus mr-1 md:mr-2"></i>
                        <span @click="open = true" class="hidden md:inline">Tambah Karyawan</span>
                        <span @click="open = true" class="md:hidden">Tambah</span>
                    </button>
                </div>
                <div class="p-4 md:p-6">
                    <div class="overflow-x-auto">
                        <!-- Mobile Card View -->
                        <!-- <div class="md:hidden space-y-3" id="employeeCards"> -->
                        <!-- Employee cards for mobile -->
                        <!-- </div> -->

                        <!-- Desktop Table View -->
                        <table class="md:table min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Divisi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.HP</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="">
                                <!-- Employee data will be populated by JavaScript -->
                                <?php foreach ($datas as $data): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                    <span class="text-primary-800 font-medium"><?= shortInitials($data->full_name) ?></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= $data->full_name ?></div>
                                                    <div class="text-sm text-gray-500">ID: <?= $data->employee_id ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900"><?= $data->division_name ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                <i class="fas ${statusIcon} mr-1"></i><?= $data->status ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $data->email ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $data->phone_number ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-primary-600 hover:text-primary-900 mr-3 btn-edit" data-id="<?= $data->id ?>" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'editEmployee' }))">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= base_url('admin/delKaryawan/' . $data->id) ?>" onclick="return confirm('Yakin akan dihapus ?')" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Modal Tambah Karyawan -->

<!-- Modal Add -->
<div x-data="{ open: false }"
    x-on:open-modal.window="if($event.detail==='addEmployee') open = true"
    x-show="open"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
        x-show="open"
        x-transition
        @click.outside="open = false">

        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Form Karyawan Baru</h3>
                        <p class="text-primary-100 text-sm">Isi form berikut untuk menambah karyawan</p>
                    </div>
                </div>
                <button @click="open = false" class="text-white hover:text-gray-200 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Form Modal -->
        <form id="modal-form" class="p-6 space-y-6" method="post" action="<?= base_url('admin/karyawanAdd') ?>">
            <!-- Informasi Pribadi -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-primary-600 mr-2"></i>
                    Informasi Pribadi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="fullName"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="email@perusahaan.com">
                    </div>
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp *</label>
                        <input type="tel" name="phoneNumber"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="081234567890" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Pekerjaan -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-primary-600 mr-2"></i>
                    Informasi Pekerjaan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 mb-1">Divisi *</label>
                        <select name="division"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                            <option value="">Pilih Divisi</option>
                            <?php foreach ($divs as $dv): ?>
                                <option value="<?= $dv->id ?>"><?= $dv->division_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Karyawan *</label>
                        <select name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-key text-primary-600 mr-2"></i>
                    Login Akun
                </h4>
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="" name="createAccount"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="createAccount" class="ml-2 block ttext-sm text-gray-700 font-medium">
                        Buat akun login untuk karyawan ini
                    </label>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-200 space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Field dengan tanda * wajib diisi
                </div>
                <div class="flex space-x-3 w-full sm:w-auto">
                    <button type="button" @click="open = false"
                        class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div x-data="{ open: false }"
    x-on:open-modal.window="if($event.detail==='editEmployee') open = true"
    x-show="open"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
        x-show="open"
        x-transition
        @click.outside="open = false">

        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Form Karyawan Baru</h3>
                        <p class="text-primary-100 text-sm">Isi form berikut untuk edit karyawan</p>
                    </div>
                </div>
                <button @click="open = false" class="text-white hover:text-gray-200 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Form Modal -->
        <form id="modal-form" class="p-6 space-y-6" method="post" action="<?= base_url('admin/updatePegawai') ?>">
            <input type="hidden" name="id" id="idPgw">
            <!-- Informasi Pribadi -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-primary-600 mr-2"></i>
                    Informasi Pribadi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="fullName" name="fullName"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="email@perusahaan.com">
                    </div>
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp *</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            placeholder="081234567890" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Pekerjaan -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-primary-600 mr-2"></i>
                    Informasi Pekerjaan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 mb-1">Divisi *</label>
                        <select id="division" name="division"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                            <option value="">Pilih Divisi</option>
                            <?php foreach ($divs as $dv): ?>
                                <option value="<?= $dv->id ?>"><?= $dv->division_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Karyawan *</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                            required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-key text-primary-600 mr-2"></i>
                    Login Akun
                </h4>
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="" name="createAccount"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="createAccount" class="ml-2 block ttext-sm text-gray-700 font-medium">
                        Buat akun login untuk karyawan ini
                    </label>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-200 space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Field dengan tanda * wajib diisi
                </div>
                <div class="flex space-x-3 w-full sm:w-auto">
                    <button type="button" @click="open = false"
                        class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<?php $this->load->view('admin/foot'); ?>
<script>
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/dtlKaryawan') ?>', // Controller CI3
            type: 'GET',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                if (res) {
                    $('#idPgw').val(res.id);
                    $('#fullName').val(res.full_name);
                    $('#email').val(res.email);
                    $('#phoneNumber').val(res.phone_number);
                    $('#division').val(res.division_id).change();
                    $('#status').val(res.status).change();

                    // Trigger event AlpineJS untuk buka modal
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'editEmployee'
                    }));
                }
            }
        });
    });
</script>