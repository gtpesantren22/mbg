<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';

class Karyawan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->requireRole('karyawan');
        $this->load->model('Modeldata', 'model');
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Karyawan';
        $data['user'] = $user;
        $userId = $user['emid'];
        $isday = date('Y-m-d');
        $data['izin'] = $this->model->getBy2('izin', 'employee_id', $userId, 'tanggal', $isday)->row();
        $data['data'] = $this->model->getBy2('absensi', 'employee_id', $userId, 'tanggal', $isday)->row();
        $data['hasil'] = $this->db->query("SELECT * FROM absensi WHERE employee_id = $userId ORDER BY tanggal DESC ")->result();
        $data['all'] = $this->db->query("SELECT COUNT(*) AS jumlah FROM absensi WHERE employee_id = $userId ")->row();

        $this->load->view('karyawan/index', $data);
    }

    public function input()
    {
        $user = $this->session->userdata('user');
        $isday = date('Y-m-d');
        $userId = $user['emid'];
        $qrhasil = $this->input->post('qrhasil', TRUE);
        $lat = $this->input->post('latitude', true);
        $lon = $this->input->post('longitude', true);

        // $office_lat = -7.769238281790367;
        // $office_lon = 113.46372569518277;

        // FIXXX
        $office_lat = -7.756565336549751;
        $office_lon = 113.42277536544765;
        $radius_limit = 20; // meter 

        $distance = $this->haversine_distance($office_lat, $office_lon, $lat, $lon);
        if ($distance > $radius_limit) {
            echo json_encode(['status' => 'error', 'message' => '❌ Anda di luar radius kantor (' . round($distance, 1) . ' m)']);
            exit;
        }

        $proxy_ip = $this->input->get_request_header('X-Forwarded-For', TRUE);
        if ($proxy_ip) {
            $proxy_ip = explode(',', $proxy_ip)[0];
        } else {
            $proxy_ip = null;
        }

        $ip = $this->input->ip_address();
        $ua = $this->input->server('HTTP_USER_AGENT', TRUE);

        $browser = $this->agent->browser();
        $version = $this->agent->version();
        $platform = $this->agent->platform();
        $device = $this->agent->is_mobile() ? $this->agent->mobile() : 'Desktop';

        $cek = $this->model->getBy2('absensi', 'tanggal', $isday, 'employee_id', $userId)->row();
        $qrScret = $this->model->getBy('settings', 'setting_key', 'secret_qr')->row('setting_value');

        if ($qrScret != $qrhasil) {
            echo json_encode(['status' => 'error', 'message' => 'QR tidak valid']);
            exit;
        }

        if (!$cek) {
            $data = [
                'employee_id' => $userId,
                'tanggal' => $isday,
                'masuk' => date('H:i:s'),
                'ip_address' => $ip,
                'proxy_ip' => $proxy_ip,
                'user_agent' => $ua,
                'browser' => $browser,
                'browser_version' => $version,
                'platform' => $platform,
                'device' => $device,
            ];
            $dave = $this->model->simpan('absensi', $data);
            if ($dave) {
                echo json_encode(['status' => 'success', 'message' => 'Absensi masuk berhasil']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Absensi masuk gagal']);
                exit;
            }
        } else {
            $dtluser = $this->db->query("SELECT divisions.sampai as batas FROM employees JOIN divisions ON employees.division_id=divisions.id WHERE employees.id = $userId ")->row();
            if (date('H:i:s') < $dtluser->batas) {
                echo json_encode(['status' => 'error', 'message' => 'Belum waktunya absensi pulang. Jam Pulang ' . date('H:i', strtotime($dtluser->batas))]);
                exit;
            }
            $dave = $this->model->ubah2('absensi', 'tanggal', $isday, 'employee_id', $userId, ['pulang' => date('H:i:s')]);
            if ($dave) {
                echo json_encode(['status' => 'success', 'message' => 'Absensi pulang berhasil']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Absensi pulang gagal']);
                exit;
            }
        }
    }

    private function haversine_distance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371000; // meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c;
    }

    public function riwayat()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Riwayat Kehadiran';
        $data['user'] = $user;
        $userId = $user['emid'];
        $data['hasil'] = $this->db->query("SELECT * FROM absensi WHERE employee_id = $userId ORDER BY tanggal DESC ")->result();

        $this->load->view('karyawan/riwayat', $data);
    }

    public function profil()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Riwayat Kehadiran';
        $data['user'] = $user;
        $uID = $user['emid'];
        $data['info'] = $this->db->query("SELECT a.*, b.division_name as jabatan FROM employees a LEFT JOIN divisions b ON a.division_id=b.id WHERE a.id = $uID ")->row();

        $this->load->view('karyawan/profil', $data);
    }
}
