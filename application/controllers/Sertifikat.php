<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sertifikat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_sertifikat');
    }

    public function index()
    {
        $data['judul'] = 'Sertifikat Profesi / Kompetensi';
        $data['modal'] = show_my_modal('sertifikat/modal_sertifikat', $data);
        $data['modal_detail'] = show_my_modal('sertifikat/modal_detail_sertifikat', $data);

        $js = $this->load->view('sertifikat/sertifikat-js', null, true);
        $this->template->views('sertifikat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_sertifikat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sertifikat) {
            $no++;
            $row = array();
            $row[] = $no;
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
            "recordsTotal" => $this->Mod_sertifikat->count_all(),
            "recordsFiltered" => $this->Mod_sertifikat->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_sertifikat($id)
    {
        $data = $this->Mod_sertifikat->get_sertifikat_by_id($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $post = $this->input->post();

        $this->id_mahasiswa = $this->session->userdata('id_user');
        $this->nama_sertifikat = $post['nama_sertifikat'];
        $this->nomor_sertifikat = $post['nomor_sertifikat'];
        $this->tanggal_sertifikat = $post['tanggal_sertifikat'];
        $this->nama_lsp = $post['nama_lsp'];
        $this->masa_berlaku = $post['masa_berlaku'];

        if (!empty($_FILES['berkas_sertifikat']['name'])) {
            $this->berkas = $this->_upload_Pdf('sertifikat', 'berkas_sertifikat');
        } else {
            $this->berkas = $post['file_sertifikat'];
        }

        $this->Mod_sertifikat->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_sertifikat');

        $post = $this->input->post();

        $this->id_mahasiswa = $this->session->userdata('id_user');
        $this->nama_sertifikat = $post['nama_sertifikat'];
        $this->nomor_sertifikat = $post['nomor_sertifikat'];
        $this->tanggal_sertifikat = $post['tanggal_sertifikat'];
        $this->nama_lsp = $post['nama_lsp'];
        $this->masa_berlaku = $post['masa_berlaku'];

        if (!empty($_FILES['berkas_sertifikat']['name'])) {
            $this->berkas = $this->_upload_Pdf('sertifikat', 'berkas_sertifikat');
        } else {
            $this->berkas = $post['file_sertifikat'];
        }

        $this->status = 'P';

        $this->Mod_sertifikat->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id)
    {
        $data = $this->Mod_sertifikat->get_sertifikat_by_id($id);
        $data->tanggal_sertifikat = tgl_indonesia($data->tanggal_sertifikat);

        if ($data->status == 'Y') {
            $data->status = "Disetujui";
        } else if ($data->status == 'N') {
            $data->status = "Ditolak";
        } else if ($data->status == 'P') {
            $data->status = "Diproses";
        }

        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->input->post('id_sertifikat');
        $this->Mod_sertifikat->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_sertifikat') == '') {
            $data['inputerror'][] = 'nama_sertifikat';
            $data['error_string'][] = 'Nama Sertifikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nomor_sertifikat') == '') {
            $data['inputerror'][] = 'nomor_sertifikat';
            $data['error_string'][] = 'Nomor Sertifikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_sertifikat') == '') {
            $data['inputerror'][] = 'tanggal_sertifikat';
            $data['error_string'][] = 'Tanggal Sertifikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nama_lsp') == '') {
            $data['inputerror'][] = 'nama_lsp';
            $data['error_string'][] = 'Nama LSP Tidak Boleh Kosong';
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

/* End of file Sertifikat.php */