<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beasiswa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_beasiswa');
    }

    public function index()
    {
        $data['judul'] = 'Beasiswa';
        $data['role'] = $this->session->userdata('role');
        $data['modal'] = show_my_modal('beasiswa/modal_beasiswa', $data);
        $data['modal_validasi'] = show_my_modal('beasiswa/modal_validasi_beasiswa', $data);

        $js = $this->load->view('beasiswa/beasiswa-js', null, true);
        $this->template->views('beasiswa/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_beasiswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bea) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bea->nama_beasiswa;
            $row[] = $bea->sumber_beasiswa;
            $row[] = $bea->periode;
            $row[] = $bea->status;
            $row[] = $bea->id_beasiswa;
            $row[] = $this->session->userdata('role');
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_beasiswa->count_all(),
            "recordsFiltered" => $this->Mod_beasiswa->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_beasiswa($id)
    {
        $data = $this->Mod_beasiswa->get_beasiswa_by_id($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $post = $this->input->post();
   
        $this->id_mahasiswa = $this->session->userdata('id_user');
        $this->nama_beasiswa = $post['nama_beasiswa'];
        $this->sumber_beasiswa = $post['sumber'];
        $this->periode = $post['periode'];

        if (!empty($_FILES['berkas_beasiswa']['name'])) {
            $this->berkas = $this->_upload_Pdf('beasiswa', 'berkas_beasiswa');
        } else {
            $this->berkas = $post['file_beasiswa'];
        }

        $this->Mod_beasiswa->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        // $this->_validate();
        $id      = $this->input->post('id_beasiswa');

        $post = $this->input->post();

        $this->nama_beasiswa = $post['nama_beasiswa'];
        $this->sumber_beasiswa = $post['sumber'];
        $this->periode = $post['periode'];

        if (!empty($_FILES['berkas_beasiswa']['name'])) {
            $this->berkas = $this->_upload_Pdf('beasiswa', 'berkas_beasiswa');
        } else {
            $this->berkas = $post['file_beasiswa'];
        }

        $this->status = 'P';

        $this->Mod_beasiswa->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function detail()
    {
        $id = trim($_POST['id_beasiswa']);
        $data['role'] = $this->session->userdata('role');
        $data['beasiswa'] = $this->Mod_beasiswa->get_beasiswa_by_id($id);
        // $list_anggota = array();
        // for ($i = 1; $i <= 5; $i++) {
        //     $get_value = $this->Mod_ajuan_penelitian->get_anggota($id, $i);

        //     if ($get_value == null || $get_value == '') {
        //         $list_anggota["anggota{$i}"] = null;
        //     } else {
        //         $list_anggota["anggota{$i}"] = $get_value->full_name;
        //     }
        // }
        // $data['anggota'] = $list_anggota;

        // if ($data['idReviewer']->id_reviewer == '' || $data['idReviewer']->id_reviewer == null) {
        //     $data['dataPenelitian'] = $this->Mod_ajuan_penelitian->get_new_data($id);
        // } else {
        //     $data['dataPenelitian'] = $this->Mod_ajuan_penelitian->get_data($id);
        // }
        echo show_my_modal('beasiswa/modal_detail_beasiswa', $data);
        json_encode($data);
    }

    public function validate()
    {
        // $this->_validate();
        $id      = $this->input->post('id_beasiswa');
        $post = $this->input->post();

        $this->status = $post['status'];
        $this->komentar = $post['komentar'];
        $this->updated_by_admin = date('Y-m-d H:i:s');

        $this->Mod_beasiswa->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_beasiswa');
        $this->Mod_beasiswa->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_beasiswa') == '') {
            $data['inputerror'][] = 'nama_beasiswa';
            $data['error_string'][] = 'Nama Beasiswa Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('sumber') == '') {
            $data['inputerror'][] = 'sumber';
            $data['error_string'][] = 'Sumber Beasiswa Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('periode') == '') {
            $data['inputerror'][] = 'periode';
            $data['error_string'][] = 'Periode Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _upload_Pdf($folder, $target)
    {
        $user = $this->session->userdata['full_name'];
        $format = "%d-%M-%Y--%H-%i";
        $config['upload_path']          = './upload/skpi/' . $folder . '/';
        $config['allowed_types']        = 'pdf|doc|docx';
        $config['overwrite']            = true;
        $config['file_name']            = mdate($format) . "_{$user}";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($target)) {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file Beasiswa.php */