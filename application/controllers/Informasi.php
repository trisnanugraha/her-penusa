<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_informasi');
    }

    public function index()
    {
        $data['judul'] = 'Banner Informasi';
        $data['modal'] = show_my_modal('informasi/modal_edit_informasi', $data);

        $js = $this->load->view('informasi/informasi-js', null, true);
        $this->template->views('informasi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_informasi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $info) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $info->deskripsi;
            $row[] = $info->id_informasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_informasi->count_all(),
            "recordsFiltered" => $this->Mod_informasi->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_informasi($id)
    {
        $data = $this->Mod_informasi->get_informasi_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id      = $this->input->post('id_informasi');

        $post = $this->input->post();

        $this->deskripsi = $post['deskripsi'];

        $this->Mod_informasi->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Informasi.php */