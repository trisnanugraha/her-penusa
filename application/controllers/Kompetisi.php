<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kompetisi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_kompetisi');
    }

    public function index()
    {
        $data['judul'] = 'Kompetisi dan Prestasi';
        $data['modal'] = show_my_modal('kompetisi/modal_kompetisi', $data);
        $data['modal_detail'] = show_my_modal('kompetisi/modal_detail_kompetisi', $data);

        $js = $this->load->view('kompetisi/kompetisi-js', null, true);
        $this->template->views('kompetisi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_kompetisi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kompetisi) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kompetisi->nama_kompetisi;
            $row[] = $kompetisi->tingkat_prestasi;
            $row[] = tgl_indonesia($kompetisi->tanggal_mulai);
            $row[] = tgl_indonesia($kompetisi->tanggal_akhir);
            $row[] = $kompetisi->status;
            $row[] = $kompetisi->id_kompetisi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_kompetisi->count_all(),
            "recordsFiltered" => $this->Mod_kompetisi->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_kompetisi($id)
    {
        $data = $this->Mod_kompetisi->get_kompetisi_by_id($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $post = $this->input->post();

        $this->id_mahasiswa = $this->session->userdata('id_user');
        $this->nama_kompetisi = $post['nama_kompetisi'];
        $this->tingkat_prestasi = $post['tingkat_prestasi'];
        $this->tanggal_mulai = $post['tanggal_mulai'];
        $this->tanggal_akhir = $post['tanggal_akhir'];

        if (!empty($_FILES['berkas_kompetisi']['name'])) {
            $this->berkas = $this->_upload_Pdf('kompetisi', 'berkas_kompetisi');
        } else {
            $this->berkas = $post['file_kompetisi'];
        }

        $this->Mod_kompetisi->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_kompetisi');

        $post = $this->input->post();

        $this->id_mahasiswa = $this->session->userdata('id_user');
        $this->nama_kompetisi = $post['nama_kompetisi'];
        $this->tingkat_prestasi = $post['tingkat_prestasi'];
        $this->tanggal_mulai = $post['tanggal_mulai'];
        $this->tanggal_akhir = $post['tanggal_akhir'];

        if (!empty($_FILES['berkas_kompetisi']['name'])) {
            $this->berkas = $this->_upload_Pdf('kompetisi', 'berkas_kompetisi');
        } else {
            $this->berkas = $post['file_kompetisi'];
        }

        $this->status = 'P';
        $this->updated_at = date('Y-m-d H:i:s');

        $this->Mod_kompetisi->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id)
    {
        $data = $this->Mod_kompetisi->get_kompetisi_by_id($id);
        $data->tanggal_mulai = tgl_indonesia($data->tanggal_mulai);
        $data->tanggal_akhir = tgl_indonesia($data->tanggal_akhir);

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
        $id = $this->input->post('id_kompetisi');
        $this->Mod_kompetisi->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_kompetisi') == '') {
            $data['inputerror'][] = 'nama_kompetisi';
            $data['error_string'][] = 'Nama Kompetisi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tingkat_prestasi') == '') {
            $data['inputerror'][] = 'tingkat_prestasi';
            $data['error_string'][] = 'Tingkat Prestasi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_mulai') == '') {
            $data['inputerror'][] = 'tanggal_mulai';
            $data['error_string'][] = 'Tanggal Mulai Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_akhir') == '') {
            $data['inputerror'][] = 'tanggal_akhir';
            $data['error_string'][] = 'Tanggal Akhir Tidak Boleh Kosong';
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

/* End of file Kompetisi.php */