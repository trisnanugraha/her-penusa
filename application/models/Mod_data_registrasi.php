<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_data_registrasi extends CI_Model
{
    var $table = 'tbl_data_registrasi';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query($id)
    {

        if ($id != 'admin') {
            $column_order = array('', 'b.tahun_akademik', 'a.semester', 'a.ipk', 'a.tipe_pembayaran', 'a.tgl_dibuat');
            $column_search = array('b.tahun_akademik', 'a.semester', 'a.ipk', 'a.tipe_pembayaran', 'a.tgl_dibuat');
            $order_by = array('a.id_registrasi' => 'desc'); // default order 

            $this->db->where('a.id_mahasiswa', $id);
        } else {
            $column_order = array('', 'b.tahun_akademik', 'c.nim', 'c.nama_lengkap', 'd.nama_prodi', 'c.lokasi', 'c.no_hp', 'c.email');
            $column_search = array('b.tahun_akademik', 'c.nim', 'c.nama_lengkap', 'd.nama_prodi', 'c.lokasi', 'c.no_hp', 'c.email');
            $order_by = array('a.id_registrasi' => 'desc');
        }

        $this->db->select('a.*,b.tahun_akademik as ta, c.*, d.nama_prodi');
        $this->db->join('tbl_jadwal_registrasi b', 'a.id_jadwal_registrasi=b.id_jadwal_registrasi');
        $this->db->join('tbl_mahasiswa c', 'a.id_mahasiswa=c.id_mahasiswa');
        $this->db->join('tbl_program_studi d', 'c.id_prodi=d.id_prodi');
        $this->db->from("{$this->table} a");
        $this->db->order_by('a.id_registrasi', 'desc');
        $i = 0;

        foreach ($column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order_by)) {
            $order = $order_by;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_data_registrasi_by_id($id)
    {
        $this->db->where('id_registrasi', $id);
        return $this->db->get($this->table)->row();
    }

    function get_data_registrasi_by_jadwal($id)
    {
        $this->db->where('id_jadwal_registrasi', $id);
        return $this->db->get($this->table);
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function update($id, $data)
    {
        $this->db->where('id_jadwal_registrasi', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_jadwal_registrasi', $id);
        $this->db->delete($this->table);
    }

    function validate($id, $data)
    {
        $this->db->where('id_registrasi', $id);
        $this->db->update($this->table, $data);
    }
}

/* End of file Mod_data_registrasi.php */
