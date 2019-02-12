<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
	}

	function login()
	{
		$this->session->unset_userdata('logged_in');

		$this->load->view('general/header');
		$this->load->view('general/login');
		$this->load->view('general/footer');
	}

	function register()
	{
		$this->session->unset_userdata('logged_in', $sess_array);
		$this->load->view('static/header');
		$this->load->view('account/register');
		$this->load->view('static/footer');
	}

	function submitLogin()
	{
		if ($this->input->post() !== null) {
			$record = $this->model->read('user',array(	
				'username'	=>	$this->input->post('username'),
				'password'	=>	hash("sha256", $this->input->post('password')),
				'verified' 	=>	'sudah'
			));
			if ($record->num_rows() == 1) {
				$record 					= $record->row();
				$session_data = array(
					'id_user'	=>	$record->id,
					'akses'		=>	$record->hak_akses,
					'nama_user'	=>	$record->nama,
					'foto'		=>	$record->foto,
					'sip'		=>	$record->sip,
				);
				alert('alert','success','Berhasil','Selamat datang '.$session_data['nama_user']);
				
				$this->session->set_userdata('logged_in', $session_data);
				
				if ($record->hak_akses == 'admin') {
					redirect('logistik-obat-oral');
				}elseif ($record->hak_akses == 'dokter') {
					redirect('logistik-obat-oral');
				}elseif ($record->hak_akses == 'petugas') {
					redirect('logistik-obat-oral');
				}
			}else{
				alert('alert','danger','Gagal','Login gagal. Anda tidak terdaftar atau akun anda belum diverifikasi oleh admin. Hubungi admin untuk verifikasi akun anda');
				redirect("login");
			}

		}else{
			$data['heading']		=	"Null POST";
			$data['message']		=	"<p>Tidak ada data yang di post</p>";
			$this->load->view('errors/html/error_general',$data);
		}
	}
	
	function logout()
	{
		// delete_cookie('berguru');
		$this->session->unset_userdata('registrasiSession');
		$this->session->unset_userdata('loginSession');
		redirect(base_url());
	}

}
// UNSET THINGS
// $this->session->unset_userdata('sesi');
// var_dump($this->session->userdata('sesi'));