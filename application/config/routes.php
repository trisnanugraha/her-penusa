<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['panel-admin'] = 'Login_admin/index';
$route['jadwal-registrasi'] = 'Jadwal_registrasi/index';
$route['tahun-angkatan'] = 'Tahun_angkatan/index';
$route['program-studi'] = 'Program_studi/index';
$route['hak-akses'] = 'Hak_akses/index';
$route['aktivasi-user'] = 'Aktivasi_user/index';
$route['data-registrasi'] = 'Data_registrasi/index';
$route['validasi-sertifikat'] = 'Validasi_sertifikat/index';
$route['validasi-beasiswa'] = 'Validasi_beasiswa/index';
$route['validasi-kompetisi'] = 'Validasi_kompetisi/index';
