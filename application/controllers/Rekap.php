<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
            'hadir' AS status,
            masuk, pulang
        FROM absensi
        WHERE tanggal BETWEEN '$start' AND '$end'
    ")->result();

        $izin = $this->db->query("
        SELECT 
            employee_id,
            DATE(tanggal) AS date,
            'izin' AS status,
            '-' AS masuk,
            '-' AS pulang
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
                ($r->status == "hadir" ? $r->masuk . '|' . $r->pulang : "Izin");
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
        // validasi sederhana
        if (!$start || !$end) {
            show_error('Parameter tanggal tidak lengkap', 400);
            return;
        }
        $data = $this->model->query("SELECT a.*, b.division_name FROM employees a LEFT JOIN divisions b ON a.division_id=b.id ")->result(); // ambil data dari database

        // generate tanggal dinamis (YYYY-mm-dd)
        $dates = [];
        $current = strtotime($start);
        $endDate = strtotime($end);
        if ($current === false || $endDate === false || $current > $endDate) {
            show_error('Range tanggal tidak valid', 400);
            return;
        }
        while ($current <= $endDate) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Kolom awal tetap (A-D)
        $sheet->mergeCells("A1:A2");
        $sheet->setCellValue("A1", "No");
        $sheet->mergeCells("B1:B2");
        $sheet->setCellValue("B1", "ID");
        $sheet->mergeCells("C1:C2");
        $sheet->setCellValue("C1", "Nama");
        $sheet->mergeCells("D1:D2");
        $sheet->setCellValue("D1", "Divisi");
        $sheet->getStyle("A1:D2")->getFont()->setBold(true);

        // Mulai dari kolom ke-5 (E) sebagai index integer
        $colIndex = 5;
        $dateColors = ['E0F7FA', 'FFF3E0']; // warna selang 2 tanggal
        $colorIndex = 0;

        // Loop untuk tanggal
        foreach ($dates as $date) {
            $niceDate = date('j M', strtotime($date)); // ex: '1 Nov'

            // convert index integer ke huruf kolom
            $colLetter1 = Coordinate::stringFromColumnIndex($colIndex);       // ex: 'E'
            $colLetter2 = Coordinate::stringFromColumnIndex($colIndex + 1);   // ex: 'F'

            // Merge header tanggal (baris 1)
            $sheet->mergeCells("{$colLetter1}1:{$colLetter2}1");
            $sheet->setCellValue("{$colLetter1}1", $niceDate);

            // Subheader Masuk / Pulang di baris 2
            $sheet->setCellValue("{$colLetter1}2", "Masuk");
            $sheet->setCellValue("{$colLetter2}2", "Pulang");

            // Styling background untuk tanggal (selang 2 warna)
            $fillColor = $dateColors[$colorIndex % 2];
            $sheet->getStyle("{$colLetter1}1:{$colLetter2}2")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB($fillColor);
            $sheet->getStyle("{$colLetter1}1:{$colLetter2}2")->getFont()->setBold(true);

            // Lompat 2 kolom untuk tanggal berikutnya
            $colIndex += 2;
            $colorIndex++;
        }

        $totals = ['TOTAL MASUK', 'TOTAL IZIN', 'TOTAL HARI'];
        foreach ($totals as $total) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->mergeCells("{$colLetter}1:{$colLetter}2");
            $sheet->setCellValue("{$colLetter}1", $total);

            // Styling header total
            $sheet->getStyle("{$colLetter}1:{$colLetter}2")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('C8E6C9'); // hijau lembut
            $sheet->getStyle("{$colLetter}1:{$colLetter}2")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("{$colLetter}1:{$colLetter}2")->getFont()->setBold(true);

            $colIndex++;
        }
        // last column letter untuk styling nanti
        $lastColLetter = Coordinate::stringFromColumnIndex($colIndex - 1);

        // styling header (baris 1-2)
        $sheet->getStyle("A1:{$lastColLetter}2")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);

        $rowNum = 3;
        $no = 1;

        foreach ($data as $item) {
            // Kolom awal
            $sheet->setCellValue("A{$rowNum}", $no++);
            $sheet->setCellValue("B{$rowNum}", $item->employee_id);
            $sheet->setCellValue("C{$rowNum}", $item->full_name);
            $sheet->setCellValue("D{$rowNum}", $item->division_name);

            $colIndex = 5; // mulai dari kolom E
            $totalMasuk = 0;
            $totalIzin  = 0;
            $totalHari  = count($dates);

            foreach ($dates as $date) {
                // ambil data absensi
                $dayOfWeek = date('N', strtotime($date)); // 1=Mon ... 7=Sun
                $fillColor = $dateColors[$colorIndex % 2];
                // konversi kolom index ke huruf
                $colLetterMasuk  = Coordinate::stringFromColumnIndex($colIndex);
                $colLetterPulang = Coordinate::stringFromColumnIndex($colIndex + 1);

                $absen = $this->model->getBy2('absensi', 'tanggal', $date, 'employee_id', $item->id)->row();
                $izin = $this->model->getBy2('izin', 'tanggal', $date, 'employee_id', $item->id)->row();

                $jamMasuk  = ($absen && !empty($absen->masuk))  ? date('H:i', strtotime($absen->masuk))  : '-';
                $jamPulang = ($absen && !empty($absen->pulang)) ? date('H:i', strtotime($absen->pulang)) : '-';

                $sheet->getStyle("{$colLetterMasuk}{$rowNum}:{$colLetterPulang}{$rowNum}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($fillColor);
                if ($izin) {
                    $sheet->setCellValue("{$colLetterMasuk}{$rowNum}", "Izin");
                    $sheet->setCellValue("{$colLetterPulang}{$rowNum}", "Izin");
                    $sheet->getStyle("{$colLetterMasuk}{$rowNum}:{$colLetterPulang}{$rowNum}")
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFFF00'); // merah muda lembut
                } elseif ($dayOfWeek >= 6 && $jamMasuk == '-' && $jamPulang == '-') {
                    $sheet->setCellValue("{$colLetterMasuk}{$rowNum}", "Libur");
                    $sheet->setCellValue("{$colLetterPulang}{$rowNum}", "Libur");
                    // Text warna merah
                    $sheet->getStyle("{$colLetterMasuk}{$rowNum}:{$colLetterPulang}{$rowNum}")
                        ->getFont()->setBold(true)
                        ->getColor()
                        ->setRGB('FF0000'); // merah cerah
                } else {
                    $sheet->setCellValue("{$colLetterMasuk}{$rowNum}", $jamMasuk);
                    $sheet->setCellValue("{$colLetterPulang}{$rowNum}", $jamPulang);
                }

                if ($jamMasuk != '-') $totalMasuk++;
                if ($izin) $totalIzin++;

                // Styling background & border

                $sheet->getStyle("{$colLetterMasuk}{$rowNum}:{$colLetterPulang}{$rowNum}")
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);


                $colIndex += 2;
                $colorIndex++;
            }
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $rowNum, $totalMasuk);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex + 1) . $rowNum, $totalIzin);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex + 2) . $rowNum, $totalHari);

            // Border total
            $sheet->getStyle(
                Coordinate::stringFromColumnIndex($colIndex) . $rowNum . ':' .
                    Coordinate::stringFromColumnIndex($colIndex + 2) . $rowNum
            )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $rowNum++;
        }

        // Autosize (gunakan numeric loop dari 1 sampai last index)
        $lastColIndex = Coordinate::columnIndexFromString($lastColLetter);
        for ($i = 1; $i <= $lastColIndex; $i++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
        }

        // Output Excel
        $filename = "Absensi_{$start}_sd_{$end}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
