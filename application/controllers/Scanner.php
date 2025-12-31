<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scanner extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Modeldata', 'model');
	}

	public function index()
	{
		$this->load->view('check_location');
	}
	public function qrSannerEmployeesByIDQR()
	{
		$scannerTheme = $this->model->getBy('settings', 'setting_key', 'scannertheme')->row('setting_value');
		$this->load->view($scannerTheme);
	}

	public function getHistory()
	{
		$this->db->select('employees.employee_id, employees.full_name, absensi.masuk,absensi.pulang');
		$this->db->from('absensi');
		$this->db->join('employees', 'employees.id=absensi.employee_id');
		$this->db->where('absensi.tanggal', date('Y-m-d'));
		$this->db->order_by('absensi.updated_at', 'DESC');
		$this->db->limit(3);
		$data = $this->db->get()->result();

		echo json_encode($data);
	}
	public function getHistoryAll()
	{
		$this->db->select('employees.employee_id, employees.full_name, absensi.masuk,absensi.pulang');
		$this->db->from('absensi');
		$this->db->join('employees', 'employees.id=absensi.employee_id');
		$this->db->where('absensi.tanggal', date('Y-m-d'));
		$this->db->order_by('absensi.updated_at', 'DESC');
		$data = $this->db->get()->num_rows();

		echo json_encode($data);
	}

	public function cekAlamat()
	{
		$lat = $this->input->post('latitude', true);
		$lon = $this->input->post('longitude', true);

		$office_lat = $this->model->getBy('settings', 'setting_key', 'lat')->row('setting_value');
		$office_lon = $this->model->getBy('settings', 'setting_key', 'lon')->row('setting_value');

		$radius_limit = $this->model->getBy('settings', 'setting_key', 'radius')->row('setting_value'); // meter 

		$distance = $this->haversine_distance($office_lat, $office_lon, $lat, $lon);
		if ($distance > $radius_limit) {
			echo json_encode([
				'status' => 'error',
				'message' => '❌ Anda di luar radius kantor (' . round($distance, 1) . ' m)',
				'jarak' => round($distance, 1),
				'lon' => $lon,
				'lat' => $lat,
			]);
			exit;
		} else {
			echo json_encode([
				'status' => 'success',
			]);
			exit;
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

	public function input()
	{
		$isday = date('Y-m-d');
		$qrhasil = $this->input->post('qrhasil', TRUE);
		$karyawan = $this->model->getBy('employees', 'qrcode', $qrhasil)->row();
		$userId = $karyawan->id;


		$cek = $this->model->getBy2('absensi', 'tanggal', $isday, 'employee_id', $userId)->row();

		if (!$cek) {
			$data = [
				'employee_id' => $userId,
				'tanggal' => $isday,
				'masuk' => date('H:i:s')
			];
			$dave = $this->model->simpan('absensi', $data);
			if ($dave) {
				echo json_encode(['status' => 'success', 'message' => 'Absensi masuk berhasil', 'nama' => $karyawan->full_name, 'ket' => 'Masuk']);
				exit;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Absensi masuk gagal']);
				exit;
			}
		} elseif ($cek && $cek->pulang == '00:00:00') {
			$dtluser = $this->db->query("SELECT divisions.sampai as batas FROM employees JOIN divisions ON employees.division_id=divisions.id WHERE employees.id = $userId ")->row();
			if (date('H:i:s') < $dtluser->batas) {
				echo json_encode(['status' => 'error', 'message' => 'Belum waktunya absensi pulang. Jam Pulang ' . date('H:i', strtotime($dtluser->batas))]);
				exit;
			}
			$dave = $this->model->ubah2('absensi', 'tanggal', $isday, 'employee_id', $userId, ['pulang' => date('H:i:s')]);
			if ($dave) {
				echo json_encode(['status' => 'success', 'message' => 'Absensi pulang berhasil', 'nama' => $karyawan->full_name, 'ket' => 'Pulang']);
				exit;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Absensi pulang gagal']);
				exit;
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Absensi hari ini selesai']);
			exit;
		}
	}

	public function errorJarak()
	{
		$this->load->view('errorJarak');
	}

	public function reverse_geocode()
	{
		$lat = $this->input->get('lat');
		$lon = $this->input->get('lon');

		$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0"); // wajib
		$result = curl_exec($ch);
		curl_close($ch);

		header('Content-Type: application/json');
		echo $result;
	}
}
