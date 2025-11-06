<?php

function shortInitials($name)
{
    $words = explode(" ", trim($name));
    $first = strtoupper(substr($words[0], 0, 1));
    $last  = strtoupper(substr(end($words), 0, 1));

    return $first . $last;
}

function generate_code($table, $column, $prefix = 'MBG',  $length = 3)
{
    $CI = &get_instance(); // Dapatkan instance CI
    $CI->load->database(); // Pastikan DB sudah load

    // Ambil kode terakhir yang sesuai prefix
    $CI->db->select("MAX($column) as last_code");
    $CI->db->like($column, $prefix, 'after'); // LIKE 'MBG%'
    $query = $CI->db->get($table);
    $row = $query->row();

    if ($row && $row->last_code) {
        // Ambil angka terakhir, misal MBG002 → 002
        $num = (int) substr($row->last_code, strlen($prefix));
        $num++;
    } else {
        $num = 1;
    }

    // Format dengan leading zero, misal 002
    $numFormatted = str_pad($num, $length, '0', STR_PAD_LEFT);

    return $prefix . $numFormatted;
}

function generate_username($fullName, $table = 'users', $column = 'username')
{
    $CI = &get_instance();
    $CI->load->database();

    // Bersihkan nama
    $name = strtolower(trim($fullName));
    $parts = explode(' ', $name);

    if (count($parts) >= 2) {
        $usernameBase = substr($parts[0], 0, 1) . $parts[count($parts) - 1]; // inisial depan + nama belakang
    } else {
        $usernameBase = $parts[0]; // kalau cuma satu kata
    }

    $username = $usernameBase;
    $i = 1;

    // Cek database agar unik
    while ($CI->db->where($column, $username)->get($table)->num_rows() > 0) {
        $username = $usernameBase . $i; // Tambahkan angka jika sudah ada
        $i++;
    }

    return $username;
}

function generate_password($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

function tanggal_indo($tanggal, $tampilkan_hari = false)
{
    $hari_array = array(
        0 => 'Minggu',
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu'
    );

    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    // Format input harus YYYY-MM-DD
    $tanggal_obj = strtotime($tanggal);
    $hari = date('w', $tanggal_obj);
    $tgl = date('j', $tanggal_obj);
    $bln = date('n', $tanggal_obj);
    $thn = date('Y', $tanggal_obj);

    $format_indo = $tgl . ' ' . $bulan_array[$bln] . ' ' . $thn;

    if ($tampilkan_hari) {
        $format_indo = $hari_array[$hari] . ', ' . $format_indo;
    }

    return $format_indo;
}
