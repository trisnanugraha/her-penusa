<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hak_akses extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_hak_akses');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['judul'] = 'Hak Akses';
        $data['user_level'] = $this->Mod_hak_akses->getAll();
        $data['modal'] = show_my_modal('hak_akses/modal_hak_akses', $data);
        $js = $this->load->view('hak_akses/hak-akses-js', null, true);
        $this->template->views('hak_akses/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_hak_akses->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $level) {
            $cekuser = $this->Mod_hak_akses->getuser($level->id_level);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $level->nama_level;
            $row[] = $level->id_level;
            $row[] = $cekuser;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_hak_akses->count_all(),
            "recordsFiltered" => $this->Mod_hak_akses->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function view()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data['table'] = $table;
        $data['data_field'] = $this->db->field_data($table);
        $data['data_table'] = $this->Mod_hak_akses->view($id)->result_array();
        $this->load->view('admin/view', $data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_level' => $this->input->post('nama_level')
        );
        $this->Mod_hak_akses->insertlevel("tbl_userlevel", $save);
        echo json_encode(array("status" => TRUE));

        $nama_level = $this->input->post('nama_level');
        $idlevel = $this->Mod_hak_akses->getId($nama_level);
        $id = $idlevel->id_level;
        $menus = $this->Mod_hak_akses->getMenu()->result();

        // Insert Akses Menu
        foreach ($menus as $key) {
            $idmenu = intval($key->id_menu);
            $datamenu = array(
                'id_level' => $id,
                'id_menu' => $idmenu,
                'view_level' => 'N',
            );
            $this->Mod_hak_akses->insert_akses_menu('tbl_akses_menu', $datamenu);
        }

        $submenus = $this->db->get('tbl_submenu')->result();
        foreach ($submenus as $submenu) {
            $datasubmenu = array(
                'id'    => '',
                'id_level'  => $id,
                'id_submenu'   => $submenu->id_submenu,
                'view_level' => 'N',
                'add_level'  => 'N',
                'edit_level' => 'N',
                'delete_level' => 'N',
                'print_level'  => 'N',
                'upload_level' => 'N'
            );
            $this->db->insert('tbl_akses_submenu', $datasubmenu);
        }
    }

    public function edit($id)
    {
        $data = $this->Mod_hak_akses->getUserlevel($id);
        echo json_encode($data);
    }

    public function update()
    {

        $this->_validate();
        $id = $this->input->post('id_level');
        $save  = array(
            'nama_level' => $this->input->post('nama_level')
        );

        $this->Mod_hak_akses->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_hak_akses->delete($id, 'tbl_userlevel');
        $this->Mod_hak_akses->deleteakses($id, 'tbl_akses_menu');
        $this->Mod_hak_akses->deleteaksessubmenu($id, 'tbl_akses_submenu');
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_level') == '') {
            $data['inputerror'][] = 'nama_level';
            $data['error_string'][] = 'Nama Level Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function view_akses_menu()
    {
        $id = $this->input->post('id');
        $data['data_menu'] = $this->Mod_hak_akses->view_akses_menu($id)->result();
        $data['data_submenu'] = $this->Mod_hak_akses->akses_submenu($id)->result();
        $this->load->view('hak_akses/view_akses_menu', $data);
    }

    public function update_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        if ($chek == 'checked') {
            $up = array(
                'view_level' => 'N'
            );
        } else {
            $up = array(
                'view_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_aksesmenu($id, $up);
        echo json_encode(array("status" => TRUE));
    }

    public function view_akses_submenu()
    {
        $id = $this->input->post('id');
        $data['data_submenu'] = $this->Mod_hak_akses->akses_submenu($id)->result();
        $this->load->view('admin/view_akses_submenu', $data);
    }
    public function view_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        if ($chek == 'checked') {
            $data = array(
                'view_level' => 'N'
            );
        } else {
            $data = array(
                'view_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function add_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        var_dump($id);
        if ($chek == 'checked') {
            $data = array(
                'add_level' => 'N'
            );
        } else {
            $data = array(
                'add_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function edit_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        var_dump($id);
        if ($chek == 'checked') {
            $data = array(
                'edit_level' => 'N'
            );
        } else {
            $data = array(
                'edit_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        var_dump($id);
        if ($chek == 'checked') {
            $data = array(
                'delete_level' => 'N'
            );
        } else {
            $data = array(
                'delete_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function print_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        var_dump($id);
        if ($chek == 'checked') {
            $data = array(
                'print_level' => 'N'
            );
        } else {
            $data = array(
                'print_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function upload_akses()
    {
        $chek = $this->input->post('chek');
        $id = $this->input->post('id');
        var_dump($id);
        if ($chek == 'checked') {
            $data = array(
                'upload_level' => 'N'
            );
        } else {
            $data = array(
                'upload_level' => 'Y'
            );
        }
        $this->Mod_hak_akses->update_akses_submenu($id, $data);
        echo json_encode(array("status" => TRUE));
    }
}
