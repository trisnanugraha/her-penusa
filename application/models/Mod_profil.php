<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_profil extends CI_Model
{
    function getMahasiswa($id)
    {
        $this->db->where('id_mahasiswa', $id);
        return $this->db->get('tbl_mahasiswa')->row();
    }

    function update($id, $data)
    {
        $this->db->where('id_mahasiswa', $id);
        $this->db->update('tbl_mahasiswa', $data);
    }
    function get_pass_foto($id)
    {
        $this->db->select('pass_foto');
        $this->db->from('tbl_mahasiswa');
        $this->db->where('id_mahasiswa', $id);
        return $this->db->get();
    }
}
