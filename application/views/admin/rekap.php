<?php $this->load->view('admin/head'); ?>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom scrollbar untuk tabel */
    .table-container {
        overflow-x: auto;
    }

    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Status badges */
    .status-present {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .status-late {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .status-absent {
        background-color: #ffebee;
        color: #d32f2f;
    }

    .status-leave {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .status-holiday {
        background-color: #f3e5f5;
        color: #7b1fa2;
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

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-filter text-primary-600 mr-2"></i>
                Filter Periode
            </h3>

            <form id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input
                        type="date"
                        id="startDate"
                        name="startDate"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                </div>

                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input
                        type="date"
                        id="endDate"
                        name="endDate"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                        required>
                </div>

                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-xl font-medium transition flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Tampilkan Rekap
                    </button>
                </div>
            </form>

            <!-- Info Periode -->
            <div id="periodInfo" class="mt-4 p-4 bg-blue-50 rounded-xl hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        <span class="text-blue-800 font-medium" id="periodText"></span>
                    </div>
                    <button id="clearFilter" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <i class="fas fa-times mr-1"></i> Hapus Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-primary-600" id="totalEmployees">0</div>
                <div class="text-xs text-gray-600">Total Karyawan</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-green-600" id="avgAttendance">0%</div>
                <div class="text-xs text-gray-600">Rata-rata Kehadiran</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-amber-600" id="totalLate">0</div>
                <div class="text-xs text-gray-600">Keterlambatan</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-blue-600" id="totalLeave">0</div>
                <div class="text-xs text-gray-600">Total Izin</div>
            </div>
        </div>

        <!-- Tabel Rekap -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Data Rekap Absensi</h3>
                    <p class="text-gray-600 text-sm" id="tableInfo">Pilih periode untuk melihat data</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="<?= base_url('rekap/export_excel') ?>" method="post">
                        <input type="hidden" name="start" id="fstart">
                        <input type="hidden" name="end" id="fend">
                        <button id="" type="submit" data-start="" data-end="" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-xl font-medium transition flex items-center justify-center">
                            <i class="fas fa-file-excel mr-2"></i> Download to Excel
                        </button>
                    </form>
                </div>
            </div>

            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200" id="attendanceTable">
                    <thead class="bg-gray-50">
                        <tr id="tableHeader">
                            <!-- Header akan diisi oleh JavaScript -->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden p-8 text-center">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-spinner fa-spin text-3xl text-primary-600 mb-3"></i>
                    <p class="text-gray-600">Memuat data rekap...</p>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden p-8 text-center">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600 mb-2">Belum ada data rekap</p>
                    <p class="text-gray-500 text-sm">Pilih periode tanggal untuk melihat rekap absensi</p>
                </div>
            </div>
        </div>
    </main>
</div>

<?php $this->load->view('admin/foot'); ?>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let employees = [];

    // Ambil data karyawan dari server
    $.ajax({
        url: "<?= base_url('rekap/getEmployees') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            employees = res; // data karyawan masuk ke JS
        }
    });

    // Ambil data absensi dari server
    function generateAttendanceData(startDate, endDate) {
        return new Promise((resolve) => {
            $.ajax({
                url: "<?= base_url('rekap/getAttendance') ?>",
                type: "GET",
                data: {
                    start: startDate.toISOString().split('T')[0],
                    end: endDate.toISOString().split('T')[0]
                },
                dataType: "json",
                success: function(records) {
                    const attendanceData = {};

                    // Siapkan array kosong untuk setiap karyawan
                    employees.forEach(emp => {
                        attendanceData[emp.id] = [];
                    });

                    // Insert data hadir & izin
                    records.forEach(item => {
                        if (!attendanceData[item.employee_id]) {
                            attendanceData[item.employee_id] = [];
                        }

                        attendanceData[item.employee_id].push({
                            date: new Date(item.date),
                            status: item.status // hadir / izin
                        });
                    });

                    resolve(attendanceData);
                }
            });
        });
    }

    // Format tanggal full
    function formatDate(date) {
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Format tanggal pendek (untuk header)
    function formatShortDate(date) {
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit'
        });
    }

    // Hitung hari kerja (weekday)
    function getWorkingDays(startDate, endDate) {
        let count = 0;
        const current = new Date(startDate);

        while (current <= endDate) {
            if (current.getDay() !== 0 && current.getDay() !== 6) count++;
            current.setDate(current.getDate() + 1);
        }

        return count;
    }

    // Render header tabel
    function renderTableHeader(startDate, endDate) {
        const headerRow = document.getElementById('tableHeader');
        headerRow.innerHTML = '';

        const columns = [{
                text: 'No',
                class: 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'
            },
            {
                text: 'Nama Karyawan',
                class: 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10'
            },
            {
                text: 'Divisi',
                class: 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'
            }
        ];

        columns.forEach(col => {
            const th = document.createElement('th');
            th.className = col.class;
            th.textContent = col.text;
            headerRow.appendChild(th);
        });

        // Tanggal
        const currentDate = new Date(startDate);
        while (currentDate <= endDate) {
            const th = document.createElement('th');
            th.className = 'px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-16';

            const dayDiv = document.createElement('div');
            dayDiv.className = 'text-xs text-gray-400';
            dayDiv.textContent = currentDate.toLocaleDateString('id-ID', {
                weekday: 'short'
            });

            const dateDiv = document.createElement('div');
            dateDiv.className = 'font-medium';
            dateDiv.textContent = formatShortDate(currentDate);

            th.appendChild(dayDiv);
            th.appendChild(dateDiv);
            headerRow.appendChild(th);

            currentDate.setDate(currentDate.getDate() + 1);
        }

        // Total columns
        const totals = [{
                text: 'Total Hadir',
                bg: 'bg-green-50'
            },
            {
                text: 'Total Izin',
                bg: 'bg-blue-50'
            },
            {
                text: 'Total Hari',
                bg: 'bg-gray-50'
            }
        ];

        totals.forEach(t => {
            const th = document.createElement('th');
            th.className = `px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ${t.bg}`;
            th.textContent = t.text;
            headerRow.appendChild(th);
        });
    }

    // Render body tabel
    function renderTableBody(attendanceData, startDate, endDate) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';

        const totalWorkingDays = getWorkingDays(startDate, endDate);

        employees.forEach((emp, idx) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';

            // No
            const noTd = document.createElement('td');
            noTd.className = 'px-4 py-3 text-sm text-gray-900';
            noTd.textContent = idx + 1;
            row.appendChild(noTd);

            // Nama
            const nameTd = document.createElement('td');
            nameTd.className = 'px-4 py-3 text-sm font-medium text-gray-900 sticky left-0 bg-white z-10';
            nameTd.innerHTML = `<div>${emp.name}</div><div class="text-xs text-gray-500">${emp.employeeId}</div>`;
            row.appendChild(nameTd);

            // Divisi
            const divTd = document.createElement('td');
            divTd.className = 'px-4 py-3 text-sm text-gray-900';
            divTd.textContent = emp.division;
            row.appendChild(divTd);

            // Tanggal
            let presentCount = 0,
                leaveCount = 0;
            const currentDate = new Date(startDate);

            while (currentDate <= endDate) {
                const td = document.createElement('td');
                td.className = 'px-2 py-2 text-center';

                let statusClass = '',
                    statusText = '';

                const attendance = attendanceData[emp.id]?.find(a => a.date.toDateString() === currentDate.toDateString());

                if (attendance) {
                    if (attendance.status === 'hadir') {
                        statusClass = 'status-present';
                        statusText = 'H';
                        presentCount++;
                    } else if (attendance.status === 'izin') {
                        statusClass = 'status-leave';
                        statusText = 'I';
                        leaveCount++;
                    }
                } else {
                    if (currentDate.getDay() === 0 || currentDate.getDay() === 6) {
                        statusClass = 'status-holiday';
                        statusText = 'L';
                    } else {
                        statusClass = 'status-absent';
                        statusText = '';
                    }
                }

                const span = document.createElement('span');
                span.className = `inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-medium ${statusClass}`;
                span.textContent = statusText;
                span.title = `${formatDate(currentDate)}: ${attendance ? attendance.status : 'kosong'}`;

                td.appendChild(span);
                row.appendChild(td);
                currentDate.setDate(currentDate.getDate() + 1);
            }

            // Total hadir
            const totalPresentTd = document.createElement('td');
            totalPresentTd.className = 'px-4 py-3 text-sm text-center font-medium text-green-600 bg-green-50';
            totalPresentTd.textContent = presentCount;
            row.appendChild(totalPresentTd);

            // Total izin
            const totalLeaveTd = document.createElement('td');
            totalLeaveTd.className = 'px-4 py-3 text-sm text-center font-medium text-blue-600 bg-blue-50';
            totalLeaveTd.textContent = leaveCount;
            row.appendChild(totalLeaveTd);

            // Total hari
            const totalDaysTd = document.createElement('td');
            totalDaysTd.className = 'px-4 py-3 text-sm text-center font-medium text-gray-600 bg-gray-50';
            totalDaysTd.textContent = totalWorkingDays;
            row.appendChild(totalDaysTd);

            tableBody.appendChild(row);
        });

        // Update summary
        document.getElementById('totalEmployees').textContent = employees.length;
        document.getElementById('avgAttendance').textContent = Math.round((employees.reduce((sum, emp) => {
            return sum + (attendanceData[emp.id]?.filter(a => a.status === 'hadir' || a.status === 'izin').length || 0);
        }, 0) / (employees.length * totalWorkingDays)) * 100) + '%';
        document.getElementById('totalLeave').textContent = employees.reduce((sum, emp) => {
            return sum + (attendanceData[emp.id]?.filter(a => a.status === 'izin').length || 0);
        }, 0);
    }

    // Tampilkan rekap
    function showAttendanceReport(startDate, endDate) {
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('attendanceTable').classList.add('hidden');

        generateAttendanceData(startDate, endDate).then(attendanceData => {
            renderTableHeader(startDate, endDate);
            renderTableBody(attendanceData, startDate, endDate);

            document.getElementById('periodText').textContent =
                `Periode: ${formatDate(startDate)} - ${formatDate(endDate)}`;

            document.getElementById('periodInfo').classList.remove('hidden');
            document.getElementById('tableInfo').textContent =
                `Menampilkan data dari ${formatDate(startDate)} hingga ${formatDate(endDate)}`;

            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('attendanceTable').classList.remove('hidden');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        document.getElementById('startDate').valueAsDate = firstDay;
        document.getElementById('endDate').valueAsDate = lastDay;

        document.getElementById('emptyState').classList.remove('hidden');

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            $('#fstart').val(startDate.toISOString().split('T')[0]);
            $('#fend').val(endDate.toISOString().split('T')[0]);

            if (startDate > endDate) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
                return;
            }
            showAttendanceReport(startDate, endDate);
        });

        document.getElementById('clearFilter').addEventListener('click', function() {
            document.getElementById('periodInfo').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('attendanceTable').classList.add('hidden');
        });

    });

    $('#export').on('click', function() {
        const start = $(this).data('start');
        const end = $(this).data('end');

        if (!start || !end) {
            alert('Pilih periode terlebih dahulu!');
            return;
        }

        const $btn = $(this);
        const originalText = $btn.html();
        // Disable button & ubah text
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Downloading...');

        $.ajax({
            url: "<?= base_url('rekap/export_excel')  ?>",
            type: 'post',
            data: {
                start: start,
                end: end
            },
            xhrFields: {
                responseType: 'blob' // untuk menerima file
            },
            success: function(data, status, xhr) {
                // Dapatkan nama file dari header jika ada
                const disposition = xhr.getResponseHeader('Content-Disposition');
                let filename = 'rekap_absensi' + start + ' - ' + end + '.xlsx';
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                // Buat blob & download
                const blob = new Blob([data], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Kembalikan button
                $btn.prop('disabled', false).html(originalText);
            },
            error: function() {
                alert('Gagal download file. Silakan coba lagi.');
                $btn.prop('disabled', false).html(originalText);
            }
        })
    });
</script>