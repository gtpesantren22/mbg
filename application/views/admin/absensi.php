<?php $this->load->view('admin/head'); ?>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px;
        padding: 6px 12px;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        /* gray-300 */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
        right: 10px;
    }

    .select2-selection__rendered {
        margin-top: 4px;
    }
</style>

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
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-8">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center md:px-6 md:py-4">
                            <h3 class="text-base font-medium text-gray-900 md:text-lg">
                                Daftar Kehadiran Karyawan Hari Ini
                            </h3>
                        </div>

                        <div class="p-4 md:p-6">
                            <div class="overflow-x-auto">
                                <!-- isi tabel -->
                                <table class="md:table min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pulang</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="">
                                        <!-- Employee data will be populated by JavaScript -->
                                        <?php $no = 1;
                                        foreach ($datas as $data): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"><?= $no++ ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"><?= $data->nama ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                        <i class="fas ${statusIcon} mr-1"></i><?= date('H:i', strtotime($data->masuk)) ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                        <i class="fas ${statusIcon} mr-1"></i><?= date('H:i', strtotime($data->pulang)) ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <!-- <button class="text-primary-600 hover:text-primary-900 mr-3 btn-edit" data-id="<?= $data->id ?>" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'editEmployee' }))">
                                                <i class="fas fa-edit"></i>
                                            </button> -->
                                                    <a href="<?= base_url('absensi/delAbsen/' . $data->id) ?>" onclick="return confirm('Yakin akan dihapus ?')" class="text-red-600 hover:text-red-900">
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
                <div class="md:col-span-4">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Input Absensi</h3>

                        <div class="space-y-3">
                            <div id="info-input"></div>
                            <form action="" id="form-absensi" class="space-y-5">

                                <div>
                                    <label for="karyawan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Karyawan *</label>
                                    <select id="karyawan" name="karyawan"
                                        class="select2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                        required>
                                        <option value="">-- Pilih --</option>
                                        <?php foreach ($karyawan as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->full_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="dari" class="block text-sm font-medium text-gray-700 mb-1">Masuk *</label>
                                    <input type="time" name="dari" id="dari"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                        required>
                                </div>
                                <div>
                                    <label for="sampai" class="block text-sm font-medium text-gray-700 mb-1">Pulang *</label>
                                    <input type="time" name="sampai" id="sampai"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                </div>

                                <!-- Tombol -->
                                <div class="flex items-center gap-3 pt-2">
                                    <button type="submit"
                                        class="px-5 py-3 bg-primary-600 text-white font-medium rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition">
                                        Simpan
                                    </button>

                                    <button type="reset"
                                        class="px-5 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition">
                                        Reset
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
    </main>
</div>
<!-- Modal Tambah Karyawan -->

<?php $this->load->view('admin/foot'); ?>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            theme: 'default'
        });
    });

    $('#karyawan').on('select2:select', function(e) {
        let data = e.params.data;
        console.log('Dipilih:', data.id);
        $.ajax({
            url: "<?= base_url('absensi/cek') ?>",
            type: 'post',
            data: {
                id: data.id
            },
            dataType: 'json',
            success: function(res) {
                if (res.status == 'success') {
                    $('#dari').val(res.dari)
                    $('#sampai').val(res.sampai)
                } else {
                    $('#dari').val('')
                    $('#sampai').val('')
                }

            },
            error: function(xhr) {
                console.log(xhr);
            }
        })
    })
    $('#form-absensi').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            url: "<?= base_url('absensi/add') ?>",
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status == 'success') {
                    $('<div>', {
                        class: 'mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3',
                        role: 'alert',
                        text: res.message // otomatis escape HTML
                    }).appendTo('#info-input');
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500);
                } else {
                    $('<div>', {
                        class: 'mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3',
                        role: 'alert',
                        text: res.message // otomatis escape HTML
                    }).appendTo('#info-input');
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500);
                }
            },
            error: function(xhr) {
                console.log(xhr);
            }
        })
    })
</script>