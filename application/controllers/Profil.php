<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_user');
        $this->load->model('Mod_profil');
        $this->load->model('Mod_program_studi');
        $this->load->model('Mod_tahun_angkatan');
    }

    public function index()
    {
        $data['judul'] = 'Profil';
        $data['role'] = $this->session->userdata('role');
        $data['mahasiswa'] = $this->Mod_profil->getMahasiswa($this->session->userdata('id_user'));

        if ($data['mahasiswa']->pass_foto == NULL) {
            $data['mahasiswa']->pass_foto = 'default.png';
        }

        if ($data['mahasiswa']->lokasi == 'M') {
            $data['mahasiswa']->lokasi = 'Medan';
        } else {
            $data['mahasiswa']->lokasi = 'Lubuk Pakam';
        }

        $tahun_angkatan = $this->Mod_tahun_angkatan->get_angkatan_by_id($data['mahasiswa']->id_angkatan);
        $data['mahasiswa']->tahun_angkatan = $tahun_angkatan->tahun_angkatan;

        $data['mahasiswa']->prodi = $this->session->userdata('prodi');
        // echo '<pre>';
        // echo $data['mahasiswa'];

        $js = $this->load->view('profil/profil-js', null, true);
        $this->template->views('profil/home', $data, $js);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id');

        $post = $this->input->post();
        $nim = $this->session->userdata['username'];
        $format = "%d-%M-%Y--%H-%i";
        if (!empty($_FILES['imagefile']['name'])) {
            $config['upload_path']   = './assets/foto/user';
            $config['allowed_types'] = 'gif|jpg|jpeg|png'; //mencegah upload backdor
            $config['max_size']      = '10240';
            $config['max_width']     = '10240';
            $config['max_height']    = '10240';
            $config['file_name']     = mdate($format) . "_{$nim}";

            $this->upload->initialize($config);
            if ($this->upload->do_upload('imagefile')) {

                $gambar = $this->upload->data();

                $this->email = $post['email'];
                $this->no_hp = $post['no_hp'];
                $this->no_hp_ortu = $post['no_hp_ortu'];
                $this->pass_foto = $gambar['file_name'];

                $temp = $this->Mod_profil->get_pass_foto($id)->row_array();

                if ($temp['pass_foto'] != null) {
                    //hapus gambar yg ada diserver
                    unlink('./assets/foto/user/' . $temp['pass_foto']);
                }

                $this->Mod_profil->update($id, $this);
                echo json_encode(array("status" => TRUE));
            }
        } else {

            $this->email = $post['email'];
            $this->no_hp = $post['no_hp'];
            $this->no_hp_ortu = $post['no_hp_ortu'];

            $this->Mod_profil->update($id, $this);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function update_pass()
    {
        $this->_validate_pass();
        $id = $this->input->post('id');
        $db = $this->Mod_profil->getMahasiswa($this->input->post('id'));

        if ($this->input->post('password_lama') != null) {
            if (hash_verified(anti_injection($this->input->post('password_lama')), $db->password)) {
                $this->password = get_hash($this->input->post('password_baru'));

                $this->Mod_profil->update($id, $this);
                echo json_encode(array("status" => TRUE));
            } else {
                $data['inputerror'][] = 'password_lama';
                $data['error_string'][] = 'Password Lama Anda Salah';
                $data['status'] = FALSE;
                echo json_encode($data);
                exit();
            }
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama') == '') {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('email') == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_hp') == '') {
            $data['inputerror'][] = 'no_hp';
            $data['error_string'][] = 'No. HP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_hp_ortu') == '') {
            $data['inputerror'][] = 'no_hp_ortu';
            $data['error_string'][] = 'No. HP Orang Tua Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_pass()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('password_lama') == '') {
            $data['inputerror'][] = 'password_lama';
            $data['error_string'][] = 'Password Lama Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password_baru') == '') {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password Baru Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verify_pass') == '') {
            $data['inputerror'][] = 'verify_pass';
            $data['error_string'][] = 'Verifikasi Password Baru Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password_baru') != $this->input->post('verify_pass')) {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password Baru Tidak Cocok Dengan Verifikasi Password Baru';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verify_pass') != $this->input->post('password_baru')) {
            $data['inputerror'][] = 'verify_pass';
            $data['error_string'][] = 'Verifikasi Password Baru Tidak Cocok Dengan Password Baru';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Profil.php */