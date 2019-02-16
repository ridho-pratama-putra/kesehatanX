<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Account/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*ACCOUNT*/
$route['login'] 										= 'Account/login';
$route['submit-login'] 									= 'Account/submitLogin';
$route['logout'] 										= 'Account/logout';

/*LOGISTIK*/
$route['autocomplete/(:any)/(:any)'] 					= 'Logistik/autocomplete/$1/$2';
$route['golongan-logistik'] 							= 'Logistik/readGolongan';
$route['golongan-logistik-tambah'] 						= 'Logistik/createGolongan';
$route['golongan-logistik-edit/(:num)'] 				= 'Logistik/updateGolongan/$1';
$route['golongan-logistik-hapus/(:num)'] 				= 'Logistik/deleteGolongan/$1';

$route['logistik-alat-bahan-sekali-pakai'] 				= 'Logistik/readLogistik/alat_bahan_sekali_pakai';
$route['logistik-alat-bahan-sekali-pakai-tambah'] 		= 'Logistik/createLogistik/alat_bahan_sekali_pakai/';
$route['logistik-alat-bahan-sekali-pakai-edit/(:num)'] 	= 'Logistik/editLogistik/alat_bahan_sekali_pakai/$1';
$route['logistik-alat-bahan-sekali-pakai-submit-edit'] 	= 'Logistik/submitEditLogistik/alat_bahan_sekali_pakai';
$route['logistik-alat-bahan-sekali-pakai-hapus/(:num)'] = 'Logistik/deleteLogistik/alat_bahan_sekali_pakai/$1';

$route['logistik-obat-injeksi'] 						= 'Logistik/readLogistik/obat_injeksi';
$route['logistik-obat-injeksi-tambah'] 					= 'Logistik/createLogistik/obat_injeksi/';
$route['logistik-obat-injeksi-edit/(:num)'] 			= 'Logistik/editLogistik/obat_injeksi/$1';
$route['logistik-obat-injeksi-submit-edit'] 			= 'Logistik/submitEditLogistik/obat_injeksi';
$route['logistik-obat-injeksi-hapus/(:num)'] 			= 'Logistik/deleteLogistik/obat_injeksi/$1';

$route['logistik-obat-oral'] 							= 'Logistik/readLogistik/obat_oral';
$route['logistik-obat-oral-tambah'] 					= 'Logistik/createLogistik/obat_oral/';
$route['logistik-obat-oral-edit/(:num)'] 				= 'Logistik/editLogistik/obat_oral/$1';
$route['logistik-obat-oral-submit-edit'] 				= 'Logistik/submitEditLogistik/obat_oral';
$route['logistik-obat-oral-hapus/(:num)'] 				= 'Logistik/deleteLogistik/obat_oral/$1';

$route['logistik-obat-sigma-usus-externum'] 			= 'Logistik/readLogistik/obat_sigma_usus_externum';
$route['logistik-obat-sigma-usus-externum-tambah'] 		= 'Logistik/createLogistik/obat_sigma_usus_externum/';
$route['logistik-obat-sigma-usus-externum-edit/(:num)']	= 'Logistik/editLogistik/obat_sigma_usus_externum/$1';
$route['logistik-obat-sigma-usus-externum-submit-edit']	= 'Logistik/submitEditLogistik/obat_sigma_usus_externum';
$route['logistik-obat-sigma-usus-externum-hapus/(:num)']= 'Logistik/deleteLogistik/obat_sigma_usus_externum/$1';




$route['dashboard-admin'] 								= 'Admin/dashboard';
$route['verifikasi-user'] 								= 'Admin/verifikasi';
$route['submit-verifikasi-user'] 						= 'Admin/SubmitVerifikasiUser';
$route['submit-reset-password/(:num)'] 					= 'Admin/SubmitResetPassword/$1';
$route['pendaftaran'] 									= 'Petugas/pendaftaran';
$route['submit-pendaftaran'] 							= 'Petugas/submitPendaftaran';
$route['pemeriksaan-awal'] 								= 'Petugas/pemeriksaanAwal';
$route['pemeriksaan-awal/(:any)'] 						= 'Petugas/pemeriksaanAwal/$1';
$route['submit-pemeriksaan-awal'] 						= 'Petugas/submitPemeriksaanAwal';
$route['antrian-petugas'] 								= 'Petugas/antrian';
$route['cari-pasien-petugas'] 									= 'Petugas/cariPasien';
$route['redirector-petugas'] 							= 'Petugas/redirector';
$route['submit-antrian-proses/(:any)']					= 'Petugas/submitAntrian/proses/$1';
$route['submit-antrian-hapus/(:any)']					= 'Petugas/submitAntrian/hapus/$1';




$route['antrian-dokter']								= 'Dokter/antrian';
$route['pemeriksaan-langsung']							= 'Dokter/pemeriksaanLangsung';
$route['cari-pasien-dokter']							= 'Dokter/cariPasien';
$route['redirector-dokter'] 							= 'Dokter/redirector';
$route['pemeriksaan/(:any)'] 							= 'Dokter/pemeriksaan/$1';
