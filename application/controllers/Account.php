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
		$this->session->unset_userdata('logged_in');
		$this->load->view('general/header');
		$this->load->view('account/register');
		$this->load->view('general/footer');
	}

	function submitRegister()
	{
		if ($this->input->post() !== null) {
			$password 		= $this->input->post('password');
			$hak_akses 		= $this->input->post('hak_akses');
			if($hak_akses == '1' && substr($password, -5,5) !== 'admin'){
				alert('alert_','warning','Gagal','Pendaftaran sebagai admin gagal');
				redirect('register');
			}else{
				if ($hak_akses != '3') {
					$sip	= $this->input->post('no_sip');
					$nama 	= "dr. ".$this->input->post('nama');
				}else{
					$sip 	= '';
					$nama 	= $this->input->post('nama');
				}
				if ($hak_akses == '1') {
					$verified = "sudah";
				}else{
					$verified = "belum";
				}
				
				$config['upload_path']          = FCPATH."assets/images/users_photo/";
				$config['allowed_types']        = 'jpg|png|jpeg';
				$this->load->library('upload',$config);
				
				if($this->upload->do_upload('foto')){
					$datax = $this->upload->data();

					alert('alert','success','Berhasil','Foto profil telah ditambahkan');

					$data = array(
											'username'		=> $this->input->post('username'),
											'password'		=> hash("sha256", $password),
											'hak_akses'		=> $hak_akses,
											'sip'			=> $sip,
											'jenis_kelamin'	=> $this->input->post('jenis_kelamin'),
											'alamat'		=> $this->input->post('alamat'),
											'nik'			=> $this->input->post('nik'),
											'nama'		 	=> $nama,
											'foto'			=> "assets/images/users_photo/".$datax['file_name'],
											'verified'		=> $verified
									);

					$query = $this->model->create('user',$data);
					$result	=	json_decode($query,true);
					if ($result['status']) {
						if ($hak_akses != 1) {
							alert('alert_','success','Berhasil','Registrasi berhasil. Silahkan hubungi admin untuk verifikasi pendaftaran');
						}else{
							alert('alert_','success','Berhasil','Registrasi admin berhasil.');
						}
					}else{
						alert('alert','warning','Peringatan','Foto profil urung terkirim');
						// alert('alert_','danger','Gagal',"Kegagalan database <br><strong> CODE: </strong>".$result['error_message']['code']." <br><strong>Message: </strong>".$result['error_message']['message']);
						alert('alert_','danger','Gagal',"Kegagalan database ".$result['error_message']['code']." <br><strong>Message: </strong>".substr($result['error_message']['message'], -4,3). " Sudah ada");

						unlink(FCPATH."assets/images/users_photo/".$datax['file_name']);
					}
				}
				else{
				// var_dump($this->upload->display_errors());die();
					alert('alert','warning','Gagal','Upload foto profil gagal. Hanya gambar dengan ekstensi jpg,png, atau jpeg. Harap isi kembali form');
				}

				redirect("register");
			}

		}else{
			$data['heading']		=	"Null POST";
			$data['message']		=	"<p>Tidak ada data yang di post</p>";
			$this->load->view('errors/html/error_general',$data);
		}
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
					redirect('verifikasi-user');
				}elseif ($record->hak_akses == 'dokter') {
					redirect('antrian-dokter');
				}elseif ($record->hak_akses == 'petugas') {
					redirect('antrian-petugas');
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