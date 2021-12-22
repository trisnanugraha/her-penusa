<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_sertifikat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_sertifikat');
        $this->load->model('Mod_validasi_sertifikat');
    }

    public function index()
    {
        $data['judul'] = 'Validasi Sertifikat';
        $data['modal'] = show_my_modal('validasi_sertifikat/modal_validasi_sertifikat', $data);
        $js = $this->load->view('validasi_sertifikat/validasi-sertifikat-js', null, true);
        $this->template->views('validasi_sertifikat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_validasi_sertifikat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sertifikat) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sertifikat->nama_lengkap;
            $row[] = $sertifikat->nama_sertifikat;
            $row[] = $sertifikat->nomor_sertifikat;
            $row[] = tgl_indonesia($sertifikat->tanggal_sertifikat);
            $row[] = $sertifikat->nama_lsp;
            $row[] = $sertifikat->status;
            $row[] = $sertifikat->id_sertifikat;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_validasi_sertifikat->count_all(),
            "recordsFiltered" => $this->Mod_validasi_sertifikat->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_sertifikat($id)
    {
        $data = $this->Mod_validasi_sertifikat->get_sertifikat_by_id($id);
        $data->tanggal_sertifikat = tgl_indonesia($data->tanggal_sertifikat);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id_sertifikat');

        $save  = array(
            'status'            => $this->input->post('status'),
            'komentar'          => $this->input->post('komentar'),
            'updated_by_admin'  => date('Y-m-d H:i:s')
        );

        $this->Mod_sertifikat->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Validasi_sertifikat.php */