<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* controller untuk bagian petugas depan
*/
class Admin extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model');
		date_default_timezone_set("Asia/Jakarta");
		// if ($this->session->userdata('logged_in')['akses'] != 'admin' ){
		// 	redirect(base_url()."Account/logout");
		// }
	}

	/*
	* funtion untuk menampilkan halaman dashboard
	*/
	function dashboard()
	{
		$data = array("active"=>"dashboard");
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
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
			"belum_terverifikasi"		=>	$this->model->rawQuery("SELECT * FROM user WHERE verified = 'belum' AND id != ".$this->session->userdata('logged_in')['id_user'])->result(),
			"sudah_terverifikasi"		=>	$this->model->rawQuery("SELECT * FROM user WHERE verified = 'sudah' AND id != ".$this->session->userdata('logged_in')['id_user'])->result(),
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
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/daftar_dokter');
		$this->load->view('admin/footer');
	}

	/*
	* funtion untukmenampilkan halaman rekam  medis
	*/
	function rekamPasien()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/rekam_medis',$data);
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
	// function detail_pasien($id)
	// {
	// 	$record['pasien'] = $this->model->read('pasien',array('id'=>$id))->result();
	// 	$this->load->view('admin/header');
	// 	$this->load->view('admin/navbar');
	// 	$this->load->view('admin/detail_pasien',$record);
	// 	$this->load->view('admin/footer');
	// }

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

	/*
	* function untuk menampilkan halaman data perdokter dan perpembayaran
	*/
	function perDokterPerPembayaran($id_dokter,$jenis_pembayaran){
		$data = array(
			"active"	=>	"daftar-dokter",
			"id_dokter"	=>	$id_dokter,
			"nama_dokter"=>	$this->model->readCol("user",array('id' => $id_dokter),array('nama'))->result(),
			"jenis_pembayaran" => $jenis_pembayaran
		);
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/per_dokter_per_pembayaran');
		$this->load->view('admin/footer');

	}
	/*
	* untuk get data pasien umum atau bpjs setiap dokter dalam jangka bulanan
	* dipanggil di perdokter
	*/
	function getPasienPerDokterPerPembayaran()
	{
		$id_dokter = $this->input->get("id_dokter");
		$jenis_pembayaran = $this->input->get("jenis_pembayaran");
		$bulan_tahun = $this->input->get("bulan_tahun");
		$bulan_tahun = explode("-", $bulan_tahun);
		$data = array(
			"record" => $this->model->rawQuery("
				SELECT 
				pasien.nama AS nama_pasien,
				pasien.pembayaran,
				(SELECT GROUP_CONCAT(assessment.tipe,' ',assessment.detil SEPARATOR ' ||| ') FROM assessment WHERE assessment.id_assessment_for_rekam_medis = rekam_medis.id) AS assessment,
				rekam_medis.planning,
				rekam_medis.tanggal_jam
				FROM rekam_medis
				INNER JOIN user ON user.id = rekam_medis.dokter_pemeriksa
				INNER JOIN pasien ON pasien.id = rekam_medis.id_pasien
				WHERE rekam_medis.dokter_pemeriksa = $id_dokter
				AND pasien.pembayaran = '".$jenis_pembayaran."'
				AND MONTH(rekam_medis.tanggal_jam) = $bulan_tahun[1]
				AND YEAR(rekam_medis.tanggal_jam) = $bulan_tahun[0]
				")->result()
		);
		echo json_encode($data);
	}

	/*
	* get data jumlah kunjungan pasien dibedakan anak dewasa dan lansia dalam jangka bulanan
	* variabel jenis usia hanya bisa berisi anak dewasa atau lansia
	* dipanggil di dashboard
	*/
	function getPasienPerUsiaPerBulan()
	{
		$jenis_usia = $this->input->get("jenis_usia");
		$jenis_kelamin = $this->input->get("jenis_kelamin");
		$bulan_tahun = $this->input->get("bulan_tahun");

		if ($jenis_usia == 'anak') {
			$down = 0;
			$top = 14;
		}elseif ($jenis_usia == 'dewasa') {
			$down = 15;
			$top = 60;
		}elseif ($jenis_usia == 'lansia') {
			$down = 60;
			$top = 999;
		}
		$bulan_tahun = explode("-", $bulan_tahun);
		$query = $this->model->rawQuery("SELECT
			pasien.nama,
			rekam_medis.tanggal_jam,
			pasien.pembayaran,
			rekam_medis.planning,
			(SELECT GROUP_CONCAT(assessment.tipe,' ',assessment.detil SEPARATOR ' ||| ') FROM assessment WHERE assessment.id_assessment_for_rekam_medis = rekam_medis.id) AS assessment
			FROM rekam_medis
			INNER JOIN pasien ON pasien.id = rekam_medis.id_pasien
			WHERE MONTH(rekam_medis.tanggal_jam) = $bulan_tahun[1]
			AND YEAR(rekam_medis.tanggal_jam) = $bulan_tahun[0]
			AND jenis_kelamin = '$jenis_kelamin'
			AND pasien.usia >= $down
			AND pasien.usia <= $top");
		$data = array(
			"record" => $query->result(),
			"num_rows" => $query->num_rows()
		);
		echo json_encode($data);
	}

	// /*
	// * get data per ICD 10 per jangka waktu
	// * dipanggil di dashboard
	// */
	// function getPasienPerIcdPerBulan($bulan_tahun)
	// {
	// 	$bulan_tahun = explode("-", $bulan_tahun);
	// 	$data = array(
	// 		"record" => $this->model->rawQuery("
	// 			SELECT DISTINCT
	// 			assessment.detil AS ICD_detil,
	// 			(SELECT GROUP_CONCAT(assessment.id_assessment_for_rekam_medis) FROM assessment WHERE assessment.detil = ICD_detil )AS id_rekam_medis,
	// 			(SELECT COUNT(assessment.id_assessment_for_rekam_medis) FROM assessment WHERE assessment.detil = ICD_detil )AS jumlah_rekam_medis
	// 			FROM assessment
	// 			INNER JOIN rekam_medis ON rekam_medis.id = assessment.id_assessment_for_rekam_medis
	// 			WHERE tipe != 'pemeriksaanLab'
	// 			AND MONTH(rekam_medis.tanggal_jam) = $bulan_tahun[1]
	// 			AND YEAR(rekam_medis.tanggal_jam) = $bulan_tahun[0]
	// 			ORDER BY assessment.detil
	// 			")->result()
	// 	);
	// 	echo "<pre>";
	// 	var_dump($data);
	// 	// echo json_encode($data);
	// }
}