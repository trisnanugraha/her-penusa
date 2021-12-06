<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktivasiuser extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_aktivasi_user');
        $this->load->model('Mod_user');
    }

    public function index()
    {
        // $id = $this->session->userdata['id_user'];
        $data['judul'] = 'Aktivasi User';
        // $data['priode'] = $this->Mod_priode->get_all('Aktif');
        // $data['skema'] = $this->Mod_skema_pkm->get_all();
        // $data['user'] = $this->Mod_user->get_all_mahasiswa_dosen($id);
        // $data['modal_tambah_ajuan_pkm'] = show_my_modal('ajuan_pkm/modal_tambah_ajuan_pkm', $data);

        $js = $this->load->view('aktivasi_user/aktivasi-user-js', null, true);
        $this->template->views('aktivasi_user/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_aktivasi_user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $user->username;
            $row[] = $user->full_name;
            $row[] = $user->nama_level;
            $row[] = tgl_indonesia($user->tgl_dibuat);
            $row[] = $user->id_pending_user;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_aktivasi_user->count_all(),
            "recordsFiltered" => $this->Mod_aktivasi_user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function aktivasi()
    {
        $id = $this->input->post('id_pending_user');
        $user =  $this->Mod_aktivasi_user->get_user($id);
        
        $this->Mod_user->update_status($user->id_user);
        $this->Mod_aktivasi_user->delete($id);
        echo json_encode(array("status" => TRUE));
    }
}
/* End of file Aktivasiuser.php */
