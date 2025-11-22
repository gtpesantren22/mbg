<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';

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
}
