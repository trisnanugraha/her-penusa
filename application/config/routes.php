<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['panel_admin'] = 'Login_admin/index';
$route['jadwal-registrasi'] = 'Jadwal_registrasi/index';
$route['tahun-angkatan'] = 'Tahun_angkatan/index';
$route['program-studi'] = 'Program_studi/index';

