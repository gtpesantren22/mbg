<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    protected $maxAttempts = 5;
    protected $lockMinutes = 15; // kunci setelah melebihi max attempts

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        // jika sudah login, redirect sesuai role
        if ($this->session->userdata('user')) {
            $role = $this->session->userdata('user')['role'];
            redirect($role === 'admin' ? 'admin' : 'karyawan');
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->findByUsername($username);

        // jangan beritahu apakah username salah atau password salah (generic error)
        if (!$user) {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth/login');
            return;
        }

        // Cek locked_until
        if (!empty($user['locked_until'])) {
            $locked_until = new DateTime($user['locked_until']);
            $now = new DateTime();
            if ($now < $locked_until) {
                $remaining = $now->diff($locked_until);
                $minutes = $remaining->i + ($remaining->h * 60);
                $this->session->set_flashdata('error', "Akun terkunci. Coba lagi dalam {$minutes} menit.");
                redirect('auth/login');
                return;
            } else {
                // unlock expired
                $this->User_model->resetAttempts($user['id']);
                $user['login_attempts'] = 0;
                $user['locked_until'] = null;
            }
        }

        // Verify password (password stored with password_hash)
        if (password_verify($password, $user['password'])) {
            // sukses
            $this->User_model->resetAttempts($user['id']);
            // update last_login dan regenerate session id untuk mencegah fixation
            $this->User_model->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            $this->session->sess_regenerate(TRUE);

            // set minimal user data ke session (tidak menyimpan password)
            $sess = [
                'id' => $user['id'],
                'uuid' => $user['uuid'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $user['role'],
                'logged_in' => TRUE
            ];
            $this->session->set_userdata('user', $sess);

            // redirect sesuai role
            if ($user['role'] === 'admin') {
                redirect('admin');
            } else {
                redirect('karyawan');
            }
            return;
        } else {
            // gagal verifikasi password -> increment attempts
            // $this->User_model->incrementAttempts($user['id']);
            // ambil ulang untuk mendapatkan hits terbaru
            // $user = $this->User_model->findById($user['id']);
            // if ($user['login_attempts'] >= $this->maxAttempts) {
            //     $locked_until = (new DateTime())->modify("+{$this->lockMinutes} minutes")->format('Y-m-d H:i:s');
            //     $this->User_model->update($user['id'], ['locked_until' => $locked_until]);
            //     $this->session->set_flashdata('error', "Terlalu banyak percobaan. Akun dikunci {$this->lockMinutes} menit.");
            // } else {
            //     $remaining = $this->maxAttempts - $user['login_attempts'];
            //     $this->session->set_flashdata('error', "Username atau password salah. Sisa percobaan: {$remaining}");
            // }
            $this->session->set_flashdata('error', "Username atau password salah.");
            redirect('auth/login');
            return;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->sess_regenerate(TRUE);
        $this->session->set_flashdata('success', 'Anda berhasil logout');
        redirect('auth/login');
    }
}
