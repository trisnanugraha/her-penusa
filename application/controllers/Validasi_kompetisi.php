<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasi_kompetisi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_kompetisi');
        $this->load->model('Mod_validasi_kompetisi');
    }

    public function index()
    {
        $data['judul'] = 'Validasi Kompetisi & Prestasi';
        $data['modal'] = show_my_modal('validasi_kompetisi/modal_validasi_kompetisi', $data);
        $js = $this->load->view('validasi_kompetisi/validasi-kompetisi-js', null, true);
        $this->template->views('validasi_kompetisi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_validasi_kompetisi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kompetisi) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kompetisi->nama_lengkap;
            $row[] = $kompetisi->nama_kompetisi;
            $row[] = $kompetisi->tingkat_kompetisi;
            $row[] = tgl_indonesia($kompetisi->tanggal_mulai);
            $row[] = tgl_indonesia($kompetisi->tanggal_akhir);
            $row[] = $kompetisi->status;
            $row[] = $kompetisi->id_kompetisi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_validasi_kompetisi->count_all(),
            "recordsFiltered" => $this->Mod_validasi_kompetisi->count_filtered(),
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