<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mahasiswa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_program_studi');
        $this->load->model('Mod_tahun_angkatan');
    }

    public function index()
    {
        $data['judul'] = 'Data Mahasiswa';
        $data['prodi'] = $this->Mod_program_studi->get_all();
        $data['angkatan'] = $this->Mod_tahun_angkatan->get_all();
        $data['modal'] = show_my_modal('mahasiswa/modal_mahasiswa', $data);
        $js = $this->load->view('mahasiswa/mahasiswa-js', null, true);
        $this->template->views('mahasiswa/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_mahasiswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mhs) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mhs->nim;
            $row[] = $mhs->nama_lengkap;
            $row[] = $mhs->nama_prodi;
            $row[] = $mhs->status;
            $row[] = $mhs->id_mahasiswa;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_mahasiswa->count_all(),
            "recordsFiltered" => $this->Mod_mahasiswa->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_mhs($id)
    {
        $data = $this->Mod_mahasiswa->get_mhs_by_id($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate('insert');

        $nama = slug($this->input->post('nim'));
        $config['upload_path']   = './assets/foto/mahasiswa/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png'; //mencegah upload backdor
        $config['max_size']      = '1000';
        $config['max_width']     = '2000';
        $config['max_height']    = '1024';
        $config['file_name']     = $nama;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('imagefile')) {
            $gambar = $this->upload->data();

            $save  = array(
                'id_prodi' => $this->input->post('prodi'),
                'id_angkatan' => $this->input->post('angkatan'),
                'nim' => $this->input->post('nim'),
                'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                'password'  => get_hash($this->input->post('password')),
                'email' => $this->input->post('mail'),
                'no_hp' => $this->input->post('telepon'),
                'lokasi'  => $this->input->post('lokasi'),
                'status' => $this->input->post('status'),
                'pass_foto' => $gambar['file_name']
            );

            $this->Mod_mahasiswa->insert($save);
            echo json_encode(array("status" => TRUE));
        } else { //Apabila tidak ada gambar yang di upload
            $save  = array(
                'id_prodi' => $this->input->post('prodi'),
                'id_angkatan' => $this->input->post('angkatan'),
                'nim' => $this->input->post('nim'),
                'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                'password'  => get_hash($this->input->post('password')),
                'email' => $this->input->post('mail'),
                'no_hp' => $this->input->post('telepon'),
                'lokasi'  => $this->input->post('lokasi'),
                'status' => $this->input->post('status'),
            );

            $this->Mod_mahasiswa->insert($save);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function update()
    {
        if (!empty($_FILES['imagefile']['name'])) {
            $this->_validate('update');
            $id = $this->input->post('id_mhs');

            $nama = time() . "-" . slug($this->input->post('nim'));
            $config['upload_path']   = './upload/foto/mahasiswa/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png'; //mencegah upload backdor
            $config['max_size']      = '2048';
            $config['max_width']     = '2000';
            $config['max_height']    = '1024';
            $config['overwrite']     = true;
            $config['file_name']     = $nama;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagefile')) {
                $gambar = $this->upload->data();
                //Jika Password tidak kosong
                if ($this->input->post('password')) {
                    $save  = array(
                        'id_prodi' => $this->input->post('prodi'),
                        'id_angkatan' => $this->input->post('angkatan'),
                        // 'nim' => $this->input->post('nim'),
                        'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                        'password'  => get_hash($this->input->post('password')),
                        'email' => $this->input->post('mail'),
                        'no_hp' => $this->input->post('telepon'),
                        'lokasi'  => $this->input->post('lokasi'),
                        'status' => $this->input->post('status'),
                        'pass_foto' => $gambar['file_name']
                    );
                } else { //Jika password kosong
                    $save  = array(
                        'id_prodi' => $this->input->post('prodi'),
                        'id_angkatan' => $this->input->post('angkatan'),
                        // 'nim' => $this->input->post('nim'),
                        'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                        'email' => $this->input->post('mail'),
                        'no_hp' => $this->input->post('telepon'),
                        'lokasi'  => $this->input->post('lokasi'),
                        'status' => $this->input->post('status'),
                        'pass_foto' => $gambar['file_name']
                    );
                }


                $g = $this->Mod_mahasiswa->get_foto_mhs($id)->row_array();

                if ($g != null) {
                    //hapus gambar yg ada diserver
                    unlink('upload/foto/mahasiswa/' . $g['pass_foto']);
                }

                $this->Mod_mahasiswa->update($id, $save);
                echo json_encode(array("status" => TRUE));
            } else { //Apabila tidak ada gambar yang di upload

                //Jika Password tidak kosong
                if ($this->input->post('password')) {
                    $save  = array(
                        'id_prodi' => $this->input->post('prodi'),
                        'id_angkatan' => $this->input->post('angkatan'),
                        // 'nim' => $this->input->post('nim'),
                        'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                        'password'  => get_hash($this->input->post('password')),
                        'email' => $this->input->post('mail'),
                        'no_hp' => $this->input->post('telepon'),
                        'lokasi'  => $this->input->post('lokasi'),
                        'status' => $this->input->post('status')
                    );
                } else { //Jika password kosong
                    $save  = array(
                        'id_prodi' => $this->input->post('prodi'),
                        'id_angkatan' => $this->input->post('angkatan'),
                        // 'nim' => $this->input->post('nim'),
                        'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                        'email' => $this->input->post('mail'),
                        'no_hp' => $this->input->post('telepon'),
                        'lokasi'  => $this->input->post('lokasi'),
                        'status' => $this->input->post('status')
                    );
                }

                $this->Mod_mahasiswa->update($id, $save);
                echo json_encode(array("status" => TRUE));
            }
        } else {
            $this->_validate('update');
            $id_mhs = $this->input->post('id_mhs');
            if ($this->input->post('password')) {
                $save  = array(
                    'id_prodi' => $this->input->post('prodi'),
                    'id_angkatan' => $this->input->post('angkatan'),
                    // 'nim' => $this->input->post('nim'),
                    'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                    'password'  => get_hash($this->input->post('password')),
                    'email' => $this->input->post('mail'),
                    'no_hp' => $this->input->post('telepon'),
                    'lokasi'  => $this->input->post('lokasi'),
                    'status' => $this->input->post('status')
                );
            } else {
                $save  = array(
                    'id_prodi' => $this->input->post('prodi'),
                    'id_angkatan' => $this->input->post('angkatan'),
                    // 'nim' => $this->input->post('nim'),
                    'nama_lengkap' => ucwords(strtolower($this->input->post('nama'))),
                    'email' => $this->input->post('mail'),
                    'no_hp' => $this->input->post('telepon'),
                    'lokasi'  => $this->input->post('lokasi'),
                    'status' => $this->input->post('status')
                );
            }

            $this->Mod_mahasiswa->update($id_mhs, $save);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete()
    {
        $id = $this->input->post('id_mahasiswa');
        $this->Mod_mahasiswa->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function reset_pass()
    {
        $id = $this->input->post('id');
        $data = array(
            'password'  => get_hash('password123')
        );
        $this->Mod_mahasiswa->reset_pass($id, $data);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function download()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'bold'  =>  true,
                'size'  =>  10,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $styleData = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $sheet->getColumnDimension('A')->setWidth(10);
        foreach (range('A', 'J') as $col) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('center');
            if ($col != 'A') {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $sheet->getDefaultRowDimension($col)->setRowHeight(25);
        }

        $sheet->getStyle('A1:J1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('bfb8b8');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'No. Telepon');
        $sheet->setCellValue('F1', 'Program Studi');
        $sheet->setCellValue('G1', 'Angkatan');
        $sheet->setCellValue('H1', 'Lokasi Gedung');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Pass Foto');

        $mhs = $this->Mod_mahasiswa->get_all()->result();
        $no = 1;
        $x = 2;
        foreach ($mhs as $row) {
            $sheet->getStyle("A{$x}:J{$x}")->applyFromArray($styleData);
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->nim);
            $sheet->setCellValue('C' . $x, $row->nama_lengkap);
            $sheet->setCellValue('D' . $x, $row->email);
            $sheet->setCellValue('E' . $x, $row->no_hp);
            $sheet->setCellValue('F' . $x, $row->nama_prodi);
            $sheet->setCellValue('G' . $x, $row->tahun_angkatan);
            if ($row->lokasi == 'LP') {
                $sheet->setCellValue('H' . $x, 'Lubuk Pakam');
            } else if ($row->lokasi == 'M') {
                $sheet->setCellValue('H' . $x, 'Medan');
            }
            if ($row->status == 'Y') {
                $sheet->setCellValue('I' . $x, 'Aktif');
            } else if ($row->status == 'N') {
                $sheet->setCellValue('I' . $x, 'Non-Aktif');
            }
            if ($row->pass_foto != null) {
                $sheet->setCellValue('J' . $x, base_url('upload/foto/mahasiswa/') . $row->pass_foto);
                $sheet->getCell('J' . $x)->getHyperlink()->setUrl(base_url('upload/foto/mahasiswa/') . $row->pass_foto);
            }
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $format = "%d-%M-%Y--%H-%i";
        $filename = 'Data-mahasiswa-' . mdate($format);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    private function _validate($action)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $nim = $this->input->post('nim');
        $cek = $this->Mod_mahasiswa->cek_nim($nim);

        if ($action == 'insert') {
            if ($cek->num_rows() > 0) {
                $data['inputerror'][] = 'nim';
                $data['error_string'][] = 'NIM Sudah Digunakan';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('nim') == '') {
            $data['inputerror'][] = 'nim';
            $data['error_string'][] = 'NIM Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nama') == '') {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('mail') == '') {
            $data['inputerror'][] = 'mail';
            $data['error_string'][] = 'E-Mail Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('telepon') == '') {
            $data['inputerror'][] = 'telepon';
            $data['error_string'][] = 'No. Hp Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('prodi') == '') {
            $data['inputerror'][] = 'prodi';
            $data['error_string'][] = 'Program Studi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('angkatan') == '') {
            $data['inputerror'][] = 'angkatan';
            $data['error_string'][] = 'Tahun Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('lokasi') == '') {
            $data['inputerror'][] = 'lokasi';
            $data['error_string'][] = 'Lokasi Gedung Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($action == 'insert') {
            if ($this->input->post('password') == '') {
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Password Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
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

/* End of file Mahasiswa.php */