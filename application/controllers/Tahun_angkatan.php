<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun_angkatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_tahun_angkatan');
    }

    public function index()
    {
        $data['judul'] = 'Tahun Angkatan';
        $data['modal'] = show_my_modal('tahun_angkatan/modal_tahun_angkatan', $data);
        $js = $this->load->view('tahun_angkatan/tahun-angkatan-js', null, true);
        $this->template->views('tahun_angkatan/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_tahun_angkatan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $angkatan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $angkatan->tahun_angkatan;
            $row[] = $angkatan->id_angkatan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_tahun_angkatan->count_all(),
            "recordsFiltered" => $this->Mod_tahun_angkatan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'tahun_angkatan'  => $this->input->post('thn_angkatan'),
        );
        $this->Mod_tahun_angkatan->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function get_angkatan($id)
    {
        $data = $this->Mod_tahun_angkatan->get_angkatan_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_angkatan');
        $data  = array(
            'tahun_angkatan'  => $this->input->post('thn_angkatan'),
        );
        $this->Mod_tahun_angkatan->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_angkatan');
        $this->Mod_tahun_angkatan->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('thn_angkatan') == '') {
            $data['inputerror'][] = 'thn_angkatan';
            $data['error_string'][] = 'Tahun Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Tahun_angkatan.php */
