<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* controller untuk bagian petugas depan
*/
class Admin extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('model');
		date_default_timezone_set("Asia/Jakarta");
		if ($this->session->userdata('logged_in')['akses'] != 'admin' ){
			redirect(base_url()."Account/logout");
		}
	}

	/*
	* funtion untuk menampilkan halaman dashboard
	*/
	function dashboard(){
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
		$this->load->view('admin/footer');
	}

	/*
	* function untuk menampilkan halaman verifikasi pengguna
	*/
	function verifikasi()
	{
		$data 	= array(
			"active"					=>	"verifikasi-user",
			"belum_terverifikasi"		=>	$this->model->read('user',array('verified'=>'belum'))->result(),
			"sudah_terverifikasi"		=>	$this->model->read('user',array('verified'=>'sudah'))->result()
		);
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/verifikasi',$data);
		$this->load->view('admin/footer');
	}

	/*
	* funtion untuk menampilkan halaman pasien
	*/
	function daftarPasien()
	{
		$data 	= array(
			"active"					=>	"daftar-pasien",
			"pasien"					=>	$this->model->readS('pasien')->result(),
		);
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/daftar_pasien',$data);
		$this->load->view('admin/footer');
	}

	/*
	* funtion unntuk menampilkan halaman dokter yang terdaftar
	*/
	function daftarDokter()
	{
		$data 	= array(
			"active"					=>	"daftar-dokter",
			"dokter"					=>	$this->model->read('user',array('hak_akses'=>'dokter'))->result()
		);
		
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/daftar_dokter',$data);
		$this->load->view('admin/footer');
	}

	/*
	* funtion untukmenampilkan halaman rekam  medis
	*/
	function rekamPasien(){
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/rekam_medis',$data);
		$this->load->view('admin/footer');
	}

	/*
	* funtion untuk menampilkan halaman rekam dokter
	*/
	function rekamDokter(){
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/rekam_dokter');
		$this->load->view('admin/footer');
	}

	/*
	* function handler untuk verifikasi seorang pengguna
	*/
	function submitVerifikasi($id_user){
		$this->model->update('user',array('id'=>$id_user),array('verified'=>'sudah'));
		redirect("Admin/verifikasi");
	}

	/*
	* get data detail pasien
	*/
	function detail_pasien($id)
	{
		$record['pasien'] = $this->model->read('pasien',array('id'=>$id))->result();
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/detail_pasien',$record);
		$this->load->view('admin/footer');
	}

	/*update data user*/
	function submitUpdateUser()
	{
		
	}

	/*
	* function untuk submit validasi user
	*/
	function submitVerifikasiUser($id_user){
		$this->model->update('user',array('id'=>$id_user),array('verified'=>'sudah'));
		redirect(base_url()."verifikasi-user");
	}

	/*
	* function untuk reset password
	*/
	function submitResetPassword($id_user)
	{
		$read_record = $this->model->read("user",array("id"=>$id_user))->result();
		if ($read_record[0]->hak_akses == "admin") {
			$bool = $this->model->update("user",array("id"=>$id_user),array("password"=>hash("sha256", $read_record[0]->username."x")));
		}else{
			$bool = $this->model->update("user",array("id"=>$id_user),array("password"=>hash("sha256", "kesehatan123")));
		}
		$bool = json_decode($bool);
		if ($bool->status) {
			alert('alert','success','Berhasil!','password telah direset');
		}else{
			alert('alert','danger','Gagal!','password gagal direset Error: '.$bool->error_message->message);
		}
		redirect(base_url()."verifikasi-user");
	}
}