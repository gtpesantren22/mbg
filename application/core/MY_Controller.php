<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function checkLogin()
    {
        $user = $this->session->userdata('user');
        if (!$user || empty($user['logged_in'])) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu');
            redirect('auth/login');
            exit;
        }
        return $user;
    }

    protected function requireRole($roles = [])
    {
        $user = $this->checkLogin();
        if (!in_array($user['role'], (array)$roles)) {
            show_error('Akses ditolak', 403, 'Forbidden');
            exit;
        }
        return $user;
    }
}
