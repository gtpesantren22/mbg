<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Rekap extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->requireRole('admin');
        $this->load->model('Modeldata', 'model');
    }
    public function absensi()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin';
        $data['title2'] = 'Rekap Kehadiran Karwayan';
        $data['menu'] = 'rekap';

        $data['user'] = $user;
        $hariini = date('Y-m-d');
        $data['datas'] = $this->db->query("SELECT a.*, b.full_name as nama FROM absensi a JOIN employees b ON a.employee_id=b.id WHERE a.tanggal = '$hariini' ORDER BY masuk DESC ")->result();
        $data['karyawan'] = $this->model->getAll('employees')->result();

        $this->load->view('admin/rekap', $data);
    }

    public function getEmployees()
    {
        $employees = $this->model->getAll('employees')->result();
        $data = [];
        foreach ($employees as $e) {
            $div = $this->model->getBy('divisions', 'id', $e->division_id)->row();
            $data[] = [
                'id' => $e->id,
                'name' => $e->full_name,
                'division' => $div->division_name,
                'employeeId' => $e->employee_id
            ];
        }

        echo json_encode($data);
    }
    public function getAttendance()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');

        $data = $this->getRawAttendance($start, $end);
        echo json_encode($data);
    }

    private function getRawAttendance($start, $end)
    {
        $hadir = $this->db->query("
        SELECT 
            employee_id,
            DATE(tanggal) AS date,
            'hadir' AS status
        FROM absensi
        WHERE tanggal BETWEEN '$start' AND '$end'
    ")->result();

        $izin = $this->db->query("
        SELECT 
            employee_id,
            DATE(tanggal) AS date,
            'izin' AS status
        FROM izin
        WHERE tanggal BETWEEN '$start' AND '$end'
    ")->result();

        return array_merge($hadir, $izin);
    }

    private function buildAttendanceData($start, $end)
    {
        // 1. Ambil semua karyawan
        $employees = $this->db->get("employees")->result();

        // 2. Ambil absensi hadir & izin
        $records = $this->getRawAttendance($start, $end);

        // 3. Siapkan hasil kosong
        $result = [];
        foreach ($employees as $e) {

            // Ambil nama divisi
            $div = $this->db->get_where("divisions", ["id" => $e->division_id])->row();

            $result[$e->id] = [
                "employee_id" => $e->employee_id,
                "name"        => $e->full_name,
                "division"    => $div ? $div->division_name : "-",
                "records"     => [] // ← tanggal akan diisi nanti
            ];
        }

        // 4. Isi data berdasarkan records dari DB
        foreach ($records as $r) {
            $result[$r->employee_id]["records"][$r->date] =
                ($r->status == "hadir" ? "Hadir" : "Izin");
        }

        // 5. Isi tanggal kosong
        $period = new DatePeriod(
            new DateTime($start),
            new DateInterval('P1D'),
            (new DateTime($end))->modify('+1 day')
        );

        foreach ($result as $empId => $row) {
            foreach ($period as $dt) {
                $d = $dt->format("Y-m-d");

                if (!isset($result[$empId]["records"][$d])) {
                    $result[$empId]["records"][$d] = "Kosong";
                }
            }
        }

        return $result;
    }


    public function export_excel()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $start = $this->input->post('start', TRUE);
        $end   = $this->input->post('end', TRUE);

        $data = $this->buildAttendanceData($start, $end);

        // Kumpulkan tanggal
        $allDates = [];
        foreach ($data as $row) {
            foreach ($row['records'] as $date => $status) {
                $allDates[$date] = $date;
            }
        }
        sort($allDates);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->freezePane('A2');

        // Header utama
        $headers = ['No', 'ID', 'Nama', 'Divisi'];
        $colIndex = 1;

        foreach ($headers as $h) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . '1', $h);
            $colIndex++;
        }

        // Header tanggal
        foreach ($allDates as $date) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . '1', date("d M Y", strtotime($date)));
            $colIndex++;
        }

        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($colLetter . '1', 'Total Hadir');
        $colIndex++;
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($colLetter . '1', 'Total Izin');
        $colIndex++;
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($colLetter . '1', 'Total Hari');
        $colIndex++;


        // Kolom terakhir
        $lastCol = Coordinate::stringFromColumnIndex($colIndex - 1);

        // Style header
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'DCE6F1']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);

        // Isi data
        $rowNum = 2;
        $no = 1;

        foreach ($data as $rowData) {

            // Kolom default
            $default = [
                1 => $no++,
                2 => $rowData['employee_id'],
                3 => $rowData['name'],
                4 => $rowData['division'],
            ];

            foreach ($default as $c => $v) {
                $colLetter = Coordinate::stringFromColumnIndex($c);
                $sheet->setCellValue($colLetter . $rowNum, $v);
            }

            // Kolom tanggal mulai dari index 5
            $colIndex = 5;

            $totalHadir = 0;
            $totalIzin  = 0;
            $totalHari  = count($allDates);

            foreach ($allDates as $date) {
                $status = $rowData['records'][$date] ?? '-';
                if ($status === 'Kosong') $status = '-';

                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($colLetter . $rowNum, $status);

                if ($status == 'Hadir') $totalHadir++;
                if ($status == 'Izin')  $totalIzin++;

                // Warna cell
                if ($status == 'Hadir') {
                    $color = 'C6EFCE';
                } elseif ($status == 'Izin') {
                    $color = 'FFF2CC';
                } elseif ($status == 'Kosong') {
                    $color = 'F4CCCC';
                } else {
                    $color = 'FFFFFF';
                }

                $sheet->getStyle("{$colLetter}{$rowNum}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => $color]
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);

                $colIndex++;
            }
            // Total Hadir
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . $rowNum, $totalHadir);
            $colIndex++;
            // Total Izin
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . $rowNum, $totalIzin);
            $colIndex++;
            // Total Hari
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . $rowNum, $totalHari);
            $colIndex++;

            $rowNum++;
        }

        // Autosize
        for ($i = 1; $i <= ($colIndex - 1); $i++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
        }

        // Output Excel
        $filename = "Rekap_Absensi_" . date("Ymd_His") . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
        exit;
    }
}
