<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_registrasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_data_registrasi');
        $this->load->model('Mod_jadwal_registrasi');
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_program_studi');
        $this->load->model('Mod_tahun_angkatan');
    }

    public function index()
    {
        $data['judul'] = 'Data Registrasi';

        $data['jadwal'] = $this->Mod_jadwal_registrasi->get_last_jadwal_registrasi();
        $data['isInput'] = $this->Mod_data_registrasi->get_data_registrasi_by_jadwal($data['jadwal']->id_jadwal_registrasi)->num_rows(1);
        $data['role'] = $this->session->userdata('role');
        $data['isUpload'] = $this->Mod_mahasiswa->get_foto_mhs($this->session->userdata('id_user'))->row(1);

        // $data['input'] = $isInput;
        $data['modal'] = show_my_modal('data_registrasi/modal_data_registrasi', $data);
        $data['modal_detail'] = show_my_modal('data_registrasi/modal_data_registrasi_detail', $data);

        if ($this->session->userdata('role') == 'Admin') {
            $data['modal_tolak'] = show_my_modal('data_registrasi/modal_data_registrasi_tolak', $data);
            $js = $this->load->view('data_registrasi/data-registrasi-admin-js', null, true);
            $this->template->views('data_registrasi/home_admin', $data, $js);
        } else {
            $js = $this->load->view('data_registrasi/data-registrasi-js', null, true);
            $this->template->views('data_registrasi/home', $data, $js);
        }
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);

        if ($this->session->userdata('role') != 'Mahasiswa') {
            $id = 'admin';
        } else {
            $id = $this->session->userdata('id_user');
        }

        $list = $this->Mod_data_registrasi->get_datatables($id);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $registrasi) {

            if ($registrasi->tipe_pembayaran == 'A1') {
                $registrasi->tipe_pembayaran = 'A (Non-Beasiswa)';
            } else if ($registrasi->tipe_pembayaran == 'A2') {
                $registrasi->tipe_pembayaran = 'A (Beasiswa 25%)';
            } else if ($registrasi->tipe_pembayaran == 'A3') {
                $registrasi->tipe_pembayaran = 'A (Beasiswa 40%)';
            } else if ($registrasi->tipe_pembayaran == 'A4') {
                $registrasi->tipe_pembayaran = 'A (Beasiswa 50%)';
            } else if ($registrasi->tipe_pembayaran == 'A5') {
                $registrasi->tipe_pembayaran = 'A (Beasiswa 75%)';
            } else if ($registrasi->tipe_pembayaran == 'A6') {
                $registrasi->tipe_pembayaran = 'A (Beasiswa 100%)';
            } else if ($registrasi->tipe_pembayaran == 'B1') {
                $registrasi->tipe_pembayaran = 'B (Non-Beasiswa)';
            };

            $no++;
            $row = array();

            if ($this->session->userdata('role') != 'Mahasiswa') {

                if ($registrasi->lokasi == 'M') {
                    $registrasi->lokasi = 'Medan';
                } else {
                    $registrasi->lokasi = 'Lubuk Pakam';
                }

                $row[] = $no;
                $row[] = $registrasi->ta;
                $row[] = $registrasi->nim;
                $row[] = $registrasi->nama_lengkap;
                $row[] = $registrasi->nama_prodi;
                $row[] = $registrasi->lokasi;
                // $row[] = $registrasi->no_hp;
                // $row[] = $registrasi->email;
                $row[] = $registrasi->status_verifikasi;
                $row[] = $registrasi->id_registrasi;
            } else {
                $row[] = $no;
                $row[] = $registrasi->ta;
                $row[] = $registrasi->semester;
                $row[] = $registrasi->ipk;
                $row[] = $registrasi->tipe_pembayaran;
                $row[] = tgl_indonesia($registrasi->tgl_dibuat);
                $row[] = $registrasi->status_verifikasi;
                $row[] = $registrasi->id_registrasi;
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_data_registrasi->count_all($id),
            "recordsFiltered" => $this->Mod_data_registrasi->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();

        $post = $this->input->post();

        $jadwal = $this->Mod_jadwal_registrasi->get_last_jadwal_registrasi();

        $this->id_mahasiswa         = $this->session->userdata('id_user');
        $this->id_jadwal_registrasi = $jadwal->id_jadwal_registrasi;
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

    public function detail($id)
    {
        $data['registrasi'] = $this->Mod_data_registrasi->get_data_registrasi_by_id($id);
        $data['mahasiswa'] = $this->Mod_mahasiswa->get_mhs_by_id($data['registrasi']->id_mahasiswa);
        $data['prodi'] = $this->Mod_program_studi->get_prodi($data['mahasiswa']->id_prodi);
        $data['ta'] = $this->Mod_tahun_angkatan->get_angkatan_by_id($data['mahasiswa']->id_angkatan);
        // $data->prodi = $this->session->userdata('prodi');

        // if ($data->lokasi == 'M') {
        //     $data->lokasi = 'Medan';
        // } else {
        //     $data->lokasi = 'Lubuk Pakam';
        // }
        echo json_encode($data);
    }

    public function validate()
    {
        $id = $this->input->post('id_registrasi');

        if ($this->input->post('status') == '1') {
            $status = 'Terverifikasi';
            $komentar = '';
        } else {
            $status = 'Ditolak';
            $komentar = $this->input->post('komentar');
        }

        $data  = array(
            'status_verifikasi'  => $status,
            'komentar'  => $komentar,
        );
        $this->Mod_data_registrasi->validate($id, $data);
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
