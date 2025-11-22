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
                    <button id="prevPeriod" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-xl font-medium transition flex items-center justify-center">
                        <i class="fas fa-file-excel mr-2"></i> Download to Excel
                    </button>
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
    // Data contoh untuk rekap absensi
    const employees = [{
            id: 1,
            name: "Ahmad Fauzi",
            division: "IT",
            employeeId: "MBG001"
        },
        {
            id: 2,
            name: "Siti Rahma",
            division: "HRD",
            employeeId: "MBG002"
        },
        {
            id: 3,
            name: "Budi Santoso",
            division: "FIN",
            employeeId: "MBG003"
        },
        {
            id: 4,
            name: "Maya Sari",
            division: "MKT",
            employeeId: "MBG004"
        },
        {
            id: 5,
            name: "Rizki Pratama",
            division: "OPS",
            employeeId: "MBG005"
        },
        {
            id: 6,
            name: "Dewi Anggraini",
            division: "IT",
            employeeId: "MBG006"
        }
    ];

    // Fungsi untuk generate data absensi acak
    function generateAttendanceData(startDate, endDate) {
        const attendanceData = {};
        const statuses = ['present', 'late', 'absent', 'leave', 'holiday'];

        employees.forEach(employee => {
            attendanceData[employee.id] = [];
            const currentDate = new Date(startDate);

            while (currentDate <= endDate) {
                // Weekend = holiday
                if (currentDate.getDay() === 0 || currentDate.getDay() === 6) {
                    attendanceData[employee.id].push({
                        date: new Date(currentDate),
                        status: 'holiday'
                    });
                } else {
                    // Random status untuk weekday
                    const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
                    attendanceData[employee.id].push({
                        date: new Date(currentDate),
                        status: randomStatus
                    });
                }

                currentDate.setDate(currentDate.getDate() + 1);
            }
        });

        return attendanceData;
    }

    // Fungsi untuk format tanggal
    function formatDate(date) {
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Fungsi untuk format tanggal pendek (untuk header tabel)
    function formatShortDate(date) {
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit'
        });
    }

    // Fungsi untuk menghitung hari kerja
    function getWorkingDays(startDate, endDate) {
        let count = 0;
        const current = new Date(startDate);

        while (current <= endDate) {
            if (current.getDay() !== 0 && current.getDay() !== 6) {
                count++;
            }
            current.setDate(current.getDate() + 1);
        }

        return count;
    }

    // Fungsi untuk merender header tabel
    function renderTableHeader(startDate, endDate) {
        const headerRow = document.getElementById('tableHeader');
        headerRow.innerHTML = '';

        // Kolom No
        const noTh = document.createElement('th');
        noTh.className = 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
        noTh.textContent = 'No';
        headerRow.appendChild(noTh);

        // Kolom Nama
        const nameTh = document.createElement('th');
        nameTh.className = 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10';
        nameTh.textContent = 'Nama Karyawan';
        headerRow.appendChild(nameTh);

        // Kolom Divisi
        const divisionTh = document.createElement('th');
        divisionTh.className = 'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
        divisionTh.textContent = 'Divisi';
        headerRow.appendChild(divisionTh);

        // Kolom tanggal
        const currentDate = new Date(startDate);
        while (currentDate <= endDate) {
            const dateTh = document.createElement('th');
            dateTh.className = 'px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-16';

            const dayDiv = document.createElement('div');
            dayDiv.className = 'text-xs text-gray-400';
            dayDiv.textContent = currentDate.toLocaleDateString('id-ID', {
                weekday: 'short'
            });

            const dateDiv = document.createElement('div');
            dateDiv.className = 'font-medium';
            dateDiv.textContent = formatShortDate(currentDate);

            dateTh.appendChild(dayDiv);
            dateTh.appendChild(dateDiv);
            headerRow.appendChild(dateTh);

            currentDate.setDate(currentDate.getDate() + 1);
        }

        // Kolom total
        const totalPresentTh = document.createElement('th');
        totalPresentTh.className = 'px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50';
        totalPresentTh.textContent = 'Total Hadir';
        headerRow.appendChild(totalPresentTh);

        const totalLeaveTh = document.createElement('th');
        totalLeaveTh.className = 'px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50';
        totalLeaveTh.textContent = 'Total Izin';
        headerRow.appendChild(totalLeaveTh);

        const totalDaysTh = document.createElement('th');
        totalDaysTh.className = 'px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50';
        totalDaysTh.textContent = 'Total Hari';
        headerRow.appendChild(totalDaysTh);
    }

    // Fungsi untuk merender body tabel
    function renderTableBody(attendanceData, startDate, endDate) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';

        let totalPresent = 0;
        let totalLeave = 0;
        let totalWorkingDays = getWorkingDays(startDate, endDate);

        employees.forEach((employee, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';

            // Kolom No
            const noTd = document.createElement('td');
            noTd.className = 'px-4 py-3 text-sm text-gray-900';
            noTd.textContent = index + 1;
            row.appendChild(noTd);

            // Kolom Nama (sticky)
            const nameTd = document.createElement('td');
            nameTd.className = 'px-4 py-3 text-sm font-medium text-gray-900 sticky left-0 bg-white z-10';
            nameTd.innerHTML = `
                    <div>${employee.name}</div>
                    <div class="text-xs text-gray-500">${employee.employeeId}</div>
                `;
            row.appendChild(nameTd);

            // Kolom Divisi
            const divisionTd = document.createElement('td');
            divisionTd.className = 'px-4 py-3 text-sm text-gray-900';
            divisionTd.textContent = employee.division;
            row.appendChild(divisionTd);

            // Kolom tanggal
            let employeePresent = 0;
            let employeeLeave = 0;

            const currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                const dateTd = document.createElement('td');
                dateTd.className = 'px-2 py-2 text-center';

                const attendance = attendanceData[employee.id].find(a =>
                    a.date.toDateString() === currentDate.toDateString()
                );

                if (attendance) {
                    let statusClass = '';
                    let statusText = '';

                    switch (attendance.status) {
                        case 'present':
                            statusClass = 'status-present';
                            statusText = 'H';
                            employeePresent++;
                            totalPresent++;
                            break;
                        case 'late':
                            statusClass = 'status-late';
                            statusText = 'T';
                            employeePresent++;
                            totalPresent++;
                            break;
                        case 'leave':
                            statusClass = 'status-leave';
                            statusText = 'I';
                            employeeLeave++;
                            totalLeave++;
                            break;
                        case 'holiday':
                            statusClass = 'status-holiday';
                            statusText = 'L';
                            break;
                        default:
                            statusClass = 'status-absent';
                            statusText = 'A';
                    }

                    const statusSpan = document.createElement('span');
                    statusSpan.className = `inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-medium ${statusClass}`;
                    statusSpan.textContent = statusText;
                    statusSpan.title = `${formatDate(currentDate)}: ${attendance.status}`;
                    dateTd.appendChild(statusSpan);
                }

                row.appendChild(dateTd);
                currentDate.setDate(currentDate.getDate() + 1);
            }

            // Kolom total hadir
            const totalPresentTd = document.createElement('td');
            totalPresentTd.className = 'px-4 py-3 text-sm text-center font-medium text-green-600 bg-green-50';
            totalPresentTd.textContent = employeePresent;
            row.appendChild(totalPresentTd);

            // Kolom total izin
            const totalLeaveTd = document.createElement('td');
            totalLeaveTd.className = 'px-4 py-3 text-sm text-center font-medium text-blue-600 bg-blue-50';
            totalLeaveTd.textContent = employeeLeave;
            row.appendChild(totalLeaveTd);

            // Kolom total hari
            const totalDaysTd = document.createElement('td');
            totalDaysTd.className = 'px-4 py-3 text-sm text-center font-medium text-gray-600 bg-gray-50';
            totalDaysTd.textContent = totalWorkingDays;
            row.appendChild(totalDaysTd);

            tableBody.appendChild(row);
        });

        // Update summary cards
        document.getElementById('totalEmployees').textContent = employees.length;
        document.getElementById('avgAttendance').textContent = Math.round((totalPresent / (employees.length * totalWorkingDays)) * 100) + '%';
        document.getElementById('totalLate').textContent = '0'; // Tidak dihitung dalam contoh ini
        document.getElementById('totalLeave').textContent = totalLeave;
    }

    // Fungsi untuk menampilkan rekap berdasarkan periode
    function showAttendanceReport(startDate, endDate) {
        // Tampilkan loading
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('attendanceTable').classList.add('hidden');

        // Simulasi loading
        setTimeout(() => {
            const attendanceData = generateAttendanceData(startDate, endDate);

            renderTableHeader(startDate, endDate);
            renderTableBody(attendanceData, startDate, endDate);

            // Update info
            document.getElementById('periodText').textContent =
                `Periode: ${formatDate(startDate)} - ${formatDate(endDate)}`;
            document.getElementById('periodInfo').classList.remove('hidden');

            document.getElementById('tableInfo').textContent =
                `Menampilkan data dari ${formatDate(startDate)} hingga ${formatDate(endDate)}`;

            // Sembunyikan loading, tampilkan tabel
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('attendanceTable').classList.remove('hidden');
        }, 1000);
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Set default date (bulan ini)
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        document.getElementById('startDate').valueAsDate = firstDay;
        document.getElementById('endDate').valueAsDate = lastDay;

        // Tampilkan empty state
        document.getElementById('emptyState').classList.remove('hidden');

        // Event listener untuk form filter
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            if (startDate > endDate) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
                return;
            }

            showAttendanceReport(startDate, endDate);
        });

        // Event listener untuk clear filter
        document.getElementById('clearFilter').addEventListener('click', function() {
            document.getElementById('periodInfo').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('attendanceTable').classList.add('hidden');
        });

        // Event listener untuk export
        document.getElementById('exportBtn').addEventListener('click', function() {
            alert('Fitur export akan mengunduh file Excel berisi rekap absensi');
        });

        // Event listener untuk print
        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });

        // Event listener untuk navigasi periode
        document.getElementById('prevPeriod').addEventListener('click', function() {
            alert('Navigasi ke periode sebelumnya');
        });

        document.getElementById('nextPeriod').addEventListener('click', function() {
            alert('Navigasi ke periode berikutnya');
        });
    });
</script>