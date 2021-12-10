<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_login extends CI_Model
{
    function Aplikasi()
    {
        return $this->db->get('aplikasi');
    }

    function Auth($username, $password)
    {

        //menggunakan active record . untuk menghindari sql injection
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $this->db->where("is_active", 'Y');
        return $this->db->get("tbl_user");
    }

    function check_db($username)
    {
        return $this->db->get_where('tbl_user', array('username' => $username));
    }

    function check_mhs($nim)
    {
        return $this->db->get_where('tbl_mahasiswa', array('nim' => $nim));
    }

    function get_role($username)
    {
        $this->db->select('b.nama_level');
        $this->db->join('tbl_userlevel b', 'a.id_level = b.id_level');
        $this->db->where('username', $username);
        return $this->db->get('tbl_user a');
    }

    function get_role_mhs($nim)
    {
        $this->db->select('b.nama_level');
        $this->db->join('tbl_userlevel b', 'a.id_level = b.id_level');
        $this->db->where('nim', $nim);
        return $this->db->get('tbl_mahasiswa a');
    }

    function get_prodi($username)
    {
        $this->db->select('b.nama_prodi');
        $this->db->join('tbl_program_studi b', 'b.id_prodi = a.id_prodi');
        $this->db->where('username', $username);
        return $this->db->get('tbl_user a');
    }

    function get_prodi_mhs($nim)
    {
        $this->db->select('b.nama_prodi');
        $this->db->join('tbl_program_studi b', 'a.id_prodi = b.id_prodi');
        $this->db->where('nim', $nim);
        return $this->db->get('tbl_mahasiswa a');
    }

    function check_status($username)
    {
        $this->db->select('is_active');
        $this->db->where('username', $username);
        return $this->db->get('tbl_user')->row();
    }

    function check_status_mhs($nim)
    {
        $this->db->select('status');
        $this->db->where('nim', $nim);
        return $this->db->get('tbl_mahasiswa')->row();
    }
}

/* End of file Mod_login.php */
