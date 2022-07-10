<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_validasi_kompetisi extends CI_Model
{

    var $table = 'tbl_kompetisi';
    var $column_order = array('', 'b.nama_lengkap', 'a.nama_kompetisi', 'a.tingkat_prestasi', 'a.tanggal_mulai', 'a.tanggal_akhir', 'a.status');
    var $column_search = array('b.nama_lengkap', 'a.nama_kompetisi', 'a.tingkat_prestasi', 'a.tanggal_mulai', 'a.tanggal_akhir', 'a.status');
    var $order = array('id_kompetisi' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query()
    {
        $this->db->select('a.*,b.nama_lengkap');
        $this->db->join('tbl_mahasiswa b', 'a.id_mahasiswa = b.id_mahasiswa');
        $this->db->from("{$this->table} a");
        // $this->db->where('a.id_ketua', $id);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_all()
    {
        return $this->db->get($this->table)
            ->result();
    }

    function get_sertifikat_by_id($id)
    {
        $this->db->select('a.*,b.nama_lengkap,b.nim');
        $this->db->join('tbl_mahasiswa b', 'a.id_mahasiswa = b.id_mahasiswa');
        $this->db->from("{$this->table} a");
        $this->db->where('a.id_sertifikat', $id);
        return $this->db->get($this->table)->row();
    }
}

/* End of file Mod_validasi_sertifikat.php */