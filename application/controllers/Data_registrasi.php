<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_registrasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_data_registrasi');
        $this->load->model('Mod_mahasiswa');
    }

    public function index()
    {
        $data['judul'] = 'Data Registrasi';
        $data['modal'] = show_my_modal('data_registrasi/modal_data_registrasi', $data);
        $js = $this->load->view('data_registrasi/data-registrasi-js', null, true);
        $this->template->views('data_registrasi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        // if ($this->session->userdata('role') == 'Mahasiswa') {
        //     $list = $this->Mod_data_registrasi->get_datatables_id($this->session->userdata('id_user'));
        // } else {
        //     $list = $this->Mod_data_registrasi->get_datatables();
        // }

        $list = $this->Mod_data_registrasi->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $registrasi) {


            if ($registrasi->tipe_pembayaran == 'A1') {
                $registrasi->tipe_pembayaran = 'A (Non-Beasiswa)';
            } else if($registrasi->tipe_pembayaran == 'A2'){
                $registrasi->tipe_pembayaran = 'A (Beasiswa 25%)';
            } else if($registrasi->tipe_pembayaran == 'A3'){
                $registrasi->tipe_pembayaran = 'A (Beasiswa 40%)';
            } else if($registrasi->tipe_pembayaran == 'A4'){
                $registrasi->tipe_pembayaran = 'A (Beasiswa 50%)';
            } else if($registrasi->tipe_pembayaran == 'A5'){
                $registrasi->tipe_pembayaran = 'A (Beasiswa 75%)';
            } else if($registrasi->tipe_pembayaran == 'A6'){
                $registrasi->tipe_pembayaran = 'A (Beasiswa 100%)';
            } else if($registrasi->tipe_pembayaran == 'B1'){
                $registrasi->tipe_pembayaran = 'B (Non-Beasiswa)';
            };

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $registrasi->semester;
            $row[] = $registrasi->ipk;
            $row[] = $registrasi->tipe_pembayaran;
            $row[] = tgl_indonesia($registrasi->tgl_dibuat);
            $row[] = $registrasi->id_registrasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_data_registrasi->count_all(),
            "recordsFiltered" => $this->Mod_data_registrasi->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();

        $post = $this->input->post();

        $this->id_mahasiswa         = $this->session->userdata('id_user');
        $this->semester             = $post['semester'];
        $this->ipk                  = $post['ip'];
        $this->tipe_pembayaran      = $post['tipe_pembayaran'];

        if (!empty($_FILES['berkas_krs']['name'])) {
            $this->file_krs = $this->_upload_Pdf('krs', 'berkas_krs');
        } else {
            $this->file_krs = $post['file_krs'];
        }

        if (!empty($_FILES['berkas_khs']['name'])) {
            $this->file_khs = $this->_upload_Pdf('khs', 'berkas_khs');
        } else {
            $this->file_khs = $post['file_khs'];
        }

        if (!empty($_FILES['berkas_pembayaran']['name'])) {
            $this->file_slip_pembayaran = $this->_upload_Pdf('bukti pembayaran', 'berkas_pembayaran');
        } else {
            $this->file_slip_pembayaran = $post['file_pembayaran'];
        }

        $this->Mod_data_registrasi->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function get_mhs()
    {
        $data = $this->Mod_mahasiswa->get_mhs_by_id($this->session->userdata['id_user']);
        $data->prodi = $this->session->userdata('prodi');

        if ($data->lokasi == 'M') {
            $data->lokasi = 'Medan';
        } else {
            $data->lokasi = 'Lubuk Pakam';
        }
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_jadwal_registrasi');
        $data  = array(
            'tahun_akademik'  => $this->input->post('thn_akademik'),
            'tanggal_mulai'     => $this->input->post('tgl_mulai'),
            'tanggal_akhir'     => $this->input->post('tgl_akhir'),
            'status'        => $this->input->post('status'),
        );
        $this->Mod_jadwal_registrasi->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_jadwal_registrasi');
        $this->Mod_jadwal_registrasi->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('semester') == '') {
            $data['inputerror'][] = 'semester';
            $data['error_string'][] = 'Semester Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tipe_pembayaran') == '') {
            $data['inputerror'][] = 'tipe_pembayaran';
            $data['error_string'][] = 'Tipe Pembayaran Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        // if (empty($_FILES['berkas_krs']['name'])) {
        //     $data['inputerror'][] = 'krs';
        //     $data['error_string'][] = 'Berkas KRS Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _upload_Pdf($folder, $target)
    {
        $user = $this->session->userdata['full_name'];
        $nim = $this->session->userdata['username'];
        $format = "%d-%M-%Y--%H-%i";
        $config['upload_path']          = './upload/' . $folder . '/';
        $config['allowed_types']        = 'pdf|doc|docx|png|jpeg|jpg';
        $config['overwrite']            = true;
        $config['file_name']            = mdate($format) . "_{$nim}_{$user}";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($target)) {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file Data_registrasi.php */
