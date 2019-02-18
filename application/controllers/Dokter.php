<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dokter extends CI_Controller {
	/*
	* saat ganti hari, lakukan truncate table antrian dan proses karena live antrian
	*/
	function __construct(){
		parent::__construct();
		$this->load->model('model');
		date_default_timezone_set("Asia/Jakarta");
		if ($this->session->userdata('logged_in')['akses'] != 'dokter' ){
			redirect("Account/logout");
		}
		$data['last_sync'] 		=	$this->model->read('settingan',array('id'=>1))->result();
		$now 					=	date("Y-m-d H:i:s");
		if ($data['last_sync'] == array()) {
			$this->model->create('settingan',array('id'=>1,'value'=>$now));
		}else{
			$datetime_now = new DateTime();
			$datetime_database = new DateTime($data['last_sync'][0]->value);
			if ($datetime_now->format('Y-m-d') > $datetime_database->format('Y-m-d')) {
				$this->model->update('settingan',array('id'=>1),array('value'=>$now));
				$this->model->rawQuery('TRUNCATE TABLE antrian');
				$this->model->rawQuery('TRUNCATE TABLE proses_antrian');
			}
		}
	}

	/*
	* function untuk lihat antrian secara live di halaman antrian
	*/
	function liveAntrian()
	{
		$data['antrian']		=	$this->model->rawQuery('
			SELECT 
			pasien.nama, 
			antrian.jam_datang, 
			antrian.nomor_antrian, 
			pasien.pembayaran, 
			pasien.nomor_pasien 
			FROM antrian 
			INNER JOIN pasien on antrian.nomor_pasien=pasien.nomor_pasien
			WHERE DATE(jam_datang) = DATE(CURRENT_DATE()) ORDER BY jam_datang
			')->result();

		$data['proses_antrian']	=	$this->model->rawQuery('
			SELECT 
			proses_antrian.nomor_pasien,
			pasien.nama, 
			pasien.pembayaran 
			FROM proses_antrian 
			INNER JOIN pasien on proses_antrian.nomor_pasien=pasien.nomor_pasien
			')->result();
		echo json_encode($data);
	}

	/*
	* lihat antrian yang sekarang
	*/
	function antrian(){
		$data 	= array(
			"active"					=>	"antrian",
		);
		// baca antrian yang tersedia, tampilkan nama dan waktu datang
		$this->load->view('dokter/header');
		$this->load->view('dokter/navbar',$data);
		$this->load->view('dokter/antrian');
		$this->load->view('dokter/footer');
	}

	/*
	* funtion untuk menampilkan halaman tambah antrian
	*/
	function pemeriksaanLangsung()
	{
		$data 	= array(
			"active"					=>	"pemeriksaan-langsung",
		);
		$this->load->view('dokter/header');
		$this->load->view('dokter/navbar',$data);
		$this->load->view('dokter/cari_pasien');
		$this->load->view('dokter/footer');
	}

	/*
	* cari nama pasien via ajax
	*/
	function cariPasien()
	{
		if ($this->input->get() != NULL) {
			$dataForm = $this->input->get();
			$dataReturn = $this->model->orLike('pasien',array('nama'=>$dataForm['term']['term'],'nomor_pasien'=>$dataForm['term']['term']))->result();
			$data = array();
			foreach ($dataReturn as $key => $value) {
				$data[$key]['id'] = $value->nomor_pasien;
				$data[$key]['text'] = $value->nama." / ".$value->nomor_pasien;
			}
			echo json_encode($data);
		}else{
			redirect();
		}
	}

	/*
	* handle submit form cari pasien untuk tambah antrian
	*/
	function redirector()
	{
		if ($this->input->get() != NULL) {
			redirect("pemeriksaan/".$this->input->get('nama_or_nomor'));
		}else{
			redirect(base_url());
		}
	}

	/*
	* form pemeriksaan setiap pasien
	*/
	function pemeriksaan($nomor_pasien)
	{
		$data 	= array(
			"active"					=>	"pemeriksaan-langsung",
			"pasien"					=>	$this->model->read('pasien',array('nomor_pasien'=>$nomor_pasien))->result(),
		);
		
		if ($data['pasien'] != array()) {
			$data['rekam_medis'] = $this->model->read('rekam_medis',
				array('id_pasien'		=>	$data['pasien'][0]->id,
					'MONTH(tanggal_jam)'=>	date('m'),
					'YEAR(tanggal_jam)'	=>	date('Y'),
					'DAY(tanggal_jam)'	=>	date('d')
				))->result();
			$this->load->view('dokter/header');
			$this->load->view('dokter/navbar',$data);
			$this->load->view('dokter/pemeriksaan',$data);
			$this->load->view('dokter/footer');
		}else{
			$this->load->view('dokter/header');
			$this->load->view('dokter/navbar',$data);
			$data['heading']	= "Halaman tidak ditemukan";
			$data['message']	= "<p> Klik <a href='".base_url()."'>disini </a>untuk kembali melihat daftar pasien yang sedang antri</p>";
			$this->load->view('errors/html/error_404',$data);
		}
	}

	// Fungsi ini digunakan untuk mencari data pada tabel ICD 10
	function cariICD()
	{
		if ($this->input->get() != NULL) {
			$dataForm = $this->input->get();
			$dataReturn = $this->model->orLike('icd10',array('Diagnosa'=>$dataForm['term']['term'],'Diskripsi'=>$dataForm['term']['term']))->result();
			$data = array();
			foreach ($dataReturn as $key => $value) {
				$data[$key]['id'] = $value->Kode_ICD. " / ".$value->Diskripsi;
				$data[$key]['text'] = $value->Kode_ICD." / ".$value->Diskripsi;
			}
			echo json_encode($data);
		}else{
			redirect(base_url());
		}
	}

	/*
	* funtion untuk menangani ajax request cari logistik  untuk pemeriksaan
	*/
	function cariLogistik($jenis_logistik)
	{
		if ($this->input->get() != NULL) {
			$dataForm = $this->input->get();
			$dataReturn = $this->db->query(" SELECT * FROM logistik_".$jenis_logistik." WHERE nama LIKE '%".$dataForm['term']['term']."%' ESCAPE '!' AND stok > 0")->result();			

			$data = array();
			foreach ($dataReturn as $key => $value) {
				$data[$key]['id'] = $value->id."|".$value->nama;
				$data[$key]['text'] = $value->nama;
				$data[$key]['stok'] = $value->stok;
				$data[$key]['harga'] = $value->harga_jual_satuan;
				// if ($value->kadaluarsa < date("Y-m-d-d")) {
				// 	$data[$key]['expired'] = " :: Sudah kadaluarsa".tgl_indo($value->kadaluarsa);
				// }else{
				// 	$data[$key]['expired'] = " :: Exp ".tgl_indo($value->kadaluarsa);
				// }
				$data[$key]['sediaan'] = $value->sediaan;
			}
			echo json_encode($data);
		}else{
			redirect();
		}		
	}

}