<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Controller.php';

class Admin extends MY_Controller
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
        $data['title2'] = 'Dashboard';
        $data['menu'] = 'dashboard';
        $data['user'] = $user;
        $this->load->view('admin/dashboard', $data);
    }
    public function karyawan()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin | Karyawan';
        $data['title2'] = 'List data karyawan';
        $data['menu'] = 'karyawan';
        $data['user'] = $user;
        $data['divs'] = $this->model->getAll('divisions')->result();
        $data['datas'] = $this->db->query("SELECT a.*, b.division_name FROM employees a LEFT JOIN divisions b ON a.division_id=b.id ")->result();

        $this->load->view('admin/karyawan', $data);
    }

    public function karyawanAdd()
    {
        $nama = $this->input->post('fullName', TRUE);
        $email = $this->input->post('email', TRUE);
        $hp = $this->input->post('phoneNumber', TRUE);
        $division = $this->input->post('division', TRUE);
        $status = $this->input->post('status', TRUE);
        $createAccount = $this->input->post('createAccount', TRUE);

        $simpanData = [
            'employee_id' => generate_code('employees', 'employee_id', 'MBG', 3),
            'full_name' => $nama,
            'email' => $email,
            'phone_number' => $hp,
            'division_id' => $division,
            'hire_date' => date('Y-m-d'),
            'status' => $status,
        ];


        $simpan = $this->model->simpan('employees', $simpanData);
        if ($simpan) {
            if ($createAccount) {
                $cekHasil = $this->db->query("SELECT * FROM employees WHERE full_name = '$nama' AND email = '$email' AND phone_number = '$hp' ")->row();
                $pss = generate_password(8);
                $acountData = [
                    'uuid' => $this->uuid->v4(),
                    'username' => generate_username($nama, 'users', 'username'),
                    'password' => password_hash($pss, PASSWORD_BCRYPT),
                    'v_password' => $pss,
                    'name' => $nama,
                    'role' => 'karyawan',
                    'employee_id' => $cekHasil->id
                ];
                $this->model->simpan('users', $acountData);
            }
            $this->session->set_flashdata('success', 'Simpan data berhasil');
            redirect('admin/karyawan');
        } else {
            $this->session->set_flashdata('error', 'Simpan data gagal');
            redirect('admin/karyawan');
        }
    }
    public function updatePegawai()
    {
        $id = $this->input->post('id', TRUE);
        $nama = $this->input->post('fullName', TRUE);
        $email = $this->input->post('email', TRUE);
        $hp = $this->input->post('phoneNumber', TRUE);
        $division = $this->input->post('division', TRUE);
        $status = $this->input->post('status', TRUE);
        $createAccount = $this->input->post('createAccount', TRUE);

        $cek_akun = $this->model->getBy('users', 'employee_id', $id)->row();
        $simpanData = [
            'employee_id' => generate_code('employees', 'employee_id', 'MBG', 3),
            'full_name' => $nama,
            'email' => $email,
            'phone_number' => $hp,
            'division_id' => $division,
            'hire_date' => date('Y-m-d'),
            'status' => $status,
        ];

        if ($createAccount && !$cek_akun) {
            $pss = generate_password(8);
            $acountData = [
                'uuid' => $this->uuid->v4(),
                'username' => generate_username($nama, 'users', 'username'),
                'password' => password_hash($pss, PASSWORD_BCRYPT),
                'v_password' => $pss,
                'name' => $nama,
                'role' => 'karyawan',
                'employee_id' => $id
            ];
            $this->model->simpan('users', $acountData);
        }

        $simpan = $this->model->ubah('employees', 'id', $id, $simpanData);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Update data berhasil');
            redirect('admin/karyawan');
        } else {
            $this->session->set_flashdata('error', 'Update data gagal');
            redirect('admin/karyawan');
        }
    }

    public function delKaryawan($id)
    {
        $sql = $this->model->hapus('employees', 'id', $id);
        if ($sql) {
            $this->session->set_flashdata('success', 'Hapus data berhasil');
            redirect('admin/karyawan');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('admin/karyawan');
        }
    }
    public function dtlKaryawan()
    {
        $id = $this->input->get('id');
        $sql = $this->model->getBy('employees', 'id', $id)->row();
        echo json_encode($sql);
    }

    public function divisi()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin | Divisions';
        $data['title2'] = 'List divisi pekerjaan';
        $data['menu'] = 'divisi';
        $data['user'] = $user;
        $data['datas'] = $this->model->getAll('divisions')->result();

        $this->load->view('admin/divisi', $data);
    }
    public function divisionAdd()
    {
        $nama = $this->input->post('nama', TRUE);
        $description = $this->input->post('description', TRUE);

        $simpanData = [
            'division_code' => shortInitials($nama),
            'division_name' => $nama,
            'description' => $description,
        ];


        $simpan = $this->model->simpan('divisions', $simpanData);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Simpan data berhasil');
            redirect('admin/divisi');
        } else {
            $this->session->set_flashdata('error', 'Simpan data gagal');
            redirect('admin/divisi');
        }
    }
    public function dtlDivisi()
    {
        $id = $this->input->get('id');
        $sql = $this->model->getBy('divisions', 'id', $id)->row();
        echo json_encode($sql);
    }
    public function divisionEdit()
    {
        $id = $this->input->post('id', TRUE);
        $nama = $this->input->post('nama', TRUE);
        $description = $this->input->post('description', TRUE);

        $simpanData = [
            'division_code' => shortInitials($nama),
            'division_name' => $nama,
            'description' => $description,
        ];


        $simpan = $this->model->ubah('divisions', 'id', $id, $simpanData);
        if ($simpan) {
            $this->session->set_flashdata('success', 'Update data berhasil');
            redirect('admin/divisi');
        } else {
            $this->session->set_flashdata('error', 'Update data gagal');
            redirect('admin/divisi');
        }
    }
    public function delDivisi($id)
    {
        $sql = $this->model->hapus('divisions', 'id', $id);
        if ($sql) {
            $this->session->set_flashdata('success', 'Hapus data berhasil');
            redirect('admin/divisi');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('admin/divisi');
        }
    }

    public function users()
    {
        $user = $this->session->userdata('user');
        $data['title'] = 'Dashboard Admin | Users Akun';
        $data['title2'] = 'List akun pengguna';
        $data['menu'] = 'user';
        $data['user'] = $user;
        $data['datas'] = $this->db->query("SELECT a.*, b.full_name, b.email FROM users a  LEFT JOIN employees b ON a.employee_id=b.id WHERE role != 'admin'")->result();

        $this->load->view('admin/user', $data);
    }
}
