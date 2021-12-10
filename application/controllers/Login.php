<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_login'));
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in == TRUE) {
            redirect('dashboard');
        } else {
            $aplikasi['aplikasi'] = $this->Mod_login->Aplikasi()->row();
            $this->load->view('login', $aplikasi);
        }
    } //end function index

    function login()
    {
        $this->_validate();
        //cek nim database
        $nim = anti_injection($this->input->post('nim'));
        $status = $this->Mod_login->check_status_mhs($nim);

        if ($this->Mod_login->check_mhs($nim)->num_rows() == 1) {
            if ($status->status != 'N') {
                $db = $this->Mod_login->check_mhs($nim)->row();
                $apl = $this->Mod_login->Aplikasi()->row();
                $prodi = $this->Mod_login->get_prodi_mhs($nim)->row();
                $role = $this->Mod_login->get_role_mhs($nim)->row();

                if (hash_verified(anti_injection($this->input->post('password')), $db->password)) {
                    //cek username dan password yg ada di database
                    $userdata = array(
                        'id_user'     => $db->id_mahasiswa,
                        'full_name'   => ucfirst($db->nama_lengkap),
                        'username'    => $db->nim,
                        'password'    => $db->password,
                        'id_level'    => $db->id_level,
                        'role'        => $role->nama_level,
                        'aplikasi'    => $apl->nama_aplikasi,
                        'title'       => $apl->title,
                        'logo'        => $apl->logo,
                        'nama_owner'  => $apl->nama_owner,
                        'image'       => $db->pass_foto,
                        'prodi'       => $prodi->nama_prodi,
                        'logged_in'   => TRUE
                    );
                    $this->session->set_userdata($userdata);
                    $data['status'] = TRUE;
                    echo json_encode($data);
                } else {
                    $data['pesan'] = "NIM atau Password Salah!";
                    $data['error'] = TRUE;
                    echo json_encode($data);
                }
            } else {
                $data['pesan'] = "Akun Anda belum aktif, silakan hubungi Administrator";
                $data['error'] = TRUE;
                echo json_encode($data);
            }
        } else {
            $data['pesan'] = "Akun Anda belum terdaftar!";
            $data['error'] = TRUE;
            echo json_encode($data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->driver('cache');
        $this->cache->clean();
        ob_clean();
        redirect('login');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nim') == '') {
            $data['inputerror'][] = 'nim';
            $data['error_string'][] = 'NIM Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Login.php */
