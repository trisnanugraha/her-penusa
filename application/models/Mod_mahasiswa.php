<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_mahasiswa extends CI_Model
{

    var $table = 'tbl_mahasiswa';
    var $column_order = array('', 'nim', 'nama_lengkap', 'nama_prodi', 'status');
    var $column_search = array('nim', 'nama_lengkap', 'c.nama_prodi', 'status');
    var $order = array('nim' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query()
    {
        $this->db->select('a.*, c.nama_prodi');
        // $this->db->join('tbl_userlevel b', 'a.id_level=b.id_level');
        $this->db->join('tbl_program_studi c', 'a.id_prodi = c.id_prodi');
        $this->db->from("{$this->table} a");

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
        $this->db->select('a.*, b.nama_prodi, c.tahun_angkatan');
        $this->db->join('tbl_program_studi b', 'a.id_prodi = b.id_prodi');
        $this->db->join('tbl_tahun_angkatan c', 'a.id_angkatan = c.id_angkatan');
        $this->db->order_by('a.id_mahasiswa asc');
        return $this->db->get("{$this->table} a");
    }

    function get_mhs_by_id($id)
    {
        $this->db->where('id_mahasiswa', $id);
        return $this->db->get($this->table)->row();
    }

    function get_foto_mhs($id)
    {
        $this->db->select('pass_foto');
        $this->db->from($this->table);
        $this->db->where('id_mahasiswa', $id);
        return $this->db->get();
    }

    function getuser($id_prodi)
    {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->where('is_active', 'Y');
        $this->db->from('tbl_user');
        return $this->db->count_all_results();
    }

    function cek_nim($nim)
    {
        $this->db->where('nim', $nim);
        return $this->db->get($this->table);
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function update($id, $data)
    {
        $this->db->where('id_mahasiswa', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_mahasiswa', $id);
        $this->db->delete($this->table);
    }
}

/* End of file Mod_mahasiswa.php */
