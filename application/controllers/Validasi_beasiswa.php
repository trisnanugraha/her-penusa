<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_beasiswa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_beasiswa');
        $this->load->model('Mod_validasi_beasiswa');
    }

    public function index()
    {
        $data['judul'] = 'Validasi Beasiswa';
        $data['modal'] = show_my_modal('validasi_beasiswa/modal_validasi_beasiswa', $data);
        $js = $this->load->view('validasi_beasiswa/validasi-beasiswa-js', null, true);
        $this->template->views('validasi_beasiswa/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_validasi_beasiswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $beasiswa) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $beasiswa->nama_lengkap;
            $row[] = $beasiswa->nama_beasiswa;
            $row[] = $beasiswa->sumber_beasiswa;
            $row[] = $beasiswa->periode;
            $row[] = $beasiswa->status;
            $row[] = $beasiswa->id_beasiswa;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_validasi_beasiswa->count_all(),
            "recordsFiltered" => $this->Mod_validasi_beasiswa->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_beasiswa($id)
    {
        $data = $this->Mod_validasi_beasiswa->get_beasiswa_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id_beasiswa');

        $save  = array(
            'status'            => $this->input->post('status'),
            'komentar'          => $this->input->post('komentar'),
            'updated_by_admin'  => date('Y-m-d H:i:s')
        );

        $this->Mod_beasiswa->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Validasi_beasiswa.php */