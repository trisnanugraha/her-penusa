<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_registrasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_jadwal_registrasi');
    }

    public function index()
    {
        $data['judul'] = 'Jadwal Registrasi';
        $data['modal'] = show_my_modal('jadwal_registrasi/modal_jadwal_registrasi', $data);
        $js = $this->load->view('jadwal_registrasi/jadwal-registrasi-js', null, true);
        $this->template->views('jadwal_registrasi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_jadwal_registrasi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal->tahun_akademik;
            $row[] = $this->fungsi->tanggalindo($jadwal->tanggal_mulai);
            $row[] = $this->fungsi->tanggalindo($jadwal->tanggal_akhir);
            $row[] = $jadwal->status;
            $row[] = $jadwal->id_jadwal_registrasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_jadwal_registrasi->count_all(),
            "recordsFiltered" => $this->Mod_jadwal_registrasi->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'tahun_akademik'  => $this->input->post('thn_akademik'),
            'tanggal_mulai'     => $this->input->post('tgl_mulai'),
            'tanggal_akhir'     => $this->input->post('tgl_akhir'),
            'status'        => $this->input->post('status'),
        );
        $this->Mod_jadwal_registrasi->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function get_jadwal_registrasi($id)
    {
        $data = $this->Mod_jadwal_registrasi->get_jadwal_registrasi_by_id($id);
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

        if ($this->input->post('thn_akademik') == '') {
            $data['inputerror'][] = 'thn_akademik';
            $data['error_string'][] = 'Tahun Akademik Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tgl_mulai') == '') {
            $data['inputerror'][] = 'tgl_mulai';
            $data['error_string'][] = 'Tanggal Mulai Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tgl_akhir') == '') {
            $data['inputerror'][] = 'tgl_akhir';
            $data['error_string'][] = 'Tanggal Akhir Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('status') == '') {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Jadwal_registrasi.php */
