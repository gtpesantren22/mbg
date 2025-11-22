<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';

class Absensi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->requireRole('admin');
        $this->load->model('Modeldata', 'model');
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin';
        $data['title2'] = 'Absensi Kehadiran Karwayan';
        $data['menu'] = 'absensi';

        $data['user'] = $user;
        $hariini = date('Y-m-d');
        $data['datas'] = $this->db->query("SELECT a.*, b.full_name as nama FROM absensi a JOIN employees b ON a.employee_id=b.id WHERE a.tanggal = '$hariini' ORDER BY masuk DESC ")->result();
        $data['karyawan'] = $this->model->getAll('employees')->result();

        $this->load->view('admin/absensi', $data);
    }

    public function cek()
    {
        $id = $this->input->post('id', TRUE);
        $cek = $this->model->getBy2('absensi', 'tanggal', date('Y-m-d'), 'employee_id', $id)->row();
        if ($cek) {
            echo json_encode(['status' => 'success', 'dari' => date('H:i', strtotime($cek->masuk)), 'sampai' => date('H:i', strtotime($cek->pulang))]);
        } else {
            echo json_encode(['status' => 'kosong']);
        }
    }

    public function add()
    {
        $isday = date('Y-m-d');
        $id = $this->input->post('karyawan', TRUE);
        $dari = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);

        $cek = $this->model->getBy2('absensi', 'tanggal', $isday, 'employee_id', $id)->row();
        if (!$cek) {
            $data = [
                'employee_id' => $id,
                'tanggal' => $isday,
                'masuk' => $dari
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
            $dave = $this->model->ubah2('absensi', 'tanggal', $isday, 'employee_id', $id, ['pulang' => $sampai]);
            if ($dave) {
                echo json_encode(['status' => 'success', 'message' => 'Absensi pulang berhasil']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Absensi pulang gagal']);
                exit;
            }
        }
    }
    public function delAbsen($id)
    {
        $sql = $this->model->hapus('absensi', 'id', $id);
        if ($sql) {
            $this->session->set_flashdata('success', 'Hapus data berhasil');
            redirect('absensi');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('absensi');
        }
    }

    public function izin()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin';
        $data['title2'] = 'Perizinan Karwayan';
        $data['menu'] = 'izin';

        $data['user'] = $user;
        $hariini = date('Y-m-d');
        $data['datas'] = $this->db->query("SELECT a.*, b.full_name as nama FROM izin a JOIN employees b ON a.employee_id=b.id ORDER BY tanggal DESC ")->result();
        $data['karyawan'] = $this->model->getAll('employees')->result();

        $this->load->view('admin/izin', $data);
    }
    public function addIzin()
    {
        $id = $this->input->post('karyawan', TRUE);
        $tanggal = $this->input->post('tanggal', TRUE);
        $alasan = $this->input->post('alasan', TRUE);

        $cek = $this->model->getBy2('izin', 'tanggal', $tanggal, 'employee_id', $id)->row();
        $dataSave = [
            'employee_id' => $id,
            'tanggal' => $tanggal,
            'alasan' => $alasan
        ];
        if (!$cek) {
            $dave = $this->model->simpan('izin', $dataSave);
            if ($dave) {
                $this->session->set_flashdata('success', 'Tambah data berhasil');
                redirect('absensi/izin');
            } else {
                $this->session->set_flashdata('error', 'Tambah data berhasil');
                redirect('absensi/izin');
            }
        } else {
            $dave = $this->model->ubah2('absensi', 'tanggal', $tanggal, 'employee_id', $id, $dataSave);
            if ($dave) {
                $this->session->set_flashdata('success', 'Tambah data berhasil');
                redirect('absensi/izin');
            } else {
                $this->session->set_flashdata('error', 'Tambah data berhasil');
                redirect('absensi/izin');
            }
        }
    }
    public function delIzin($id)
    {
        $sql = $this->model->hapus('izin', 'id', $id);
        if ($sql) {
            $this->session->set_flashdata('success', 'Hapus data berhasil');
            redirect('absensi/izin');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('absensi/izin');
        }
    }
}
