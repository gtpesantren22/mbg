<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByUsername($username)
    {
        return $this->db->where('username', $username)->get($this->table)->row_array();
    }

    public function findById($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function create(array $data)
    {
        // $data harus berisi username,password(name,role)
        $data['uuid'] = $this->generate_uuid();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function update($id, array $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function incrementAttempts($id)
    {
        $this->db->set('login_attempts', 'login_attempts+1', FALSE)
            ->where('id', $id)
            ->update($this->table);
    }

    public function resetAttempts($id)
    {
        $this->db->where('id', $id)->update($this->table, [
            'login_attempts' => 0,
            'locked_until' => null
        ]);
    }

    protected function generate_uuid()
    {
        // simple uuid v4
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        }
        // fallback
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
