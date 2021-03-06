<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller 
{
	/*
	* pas ganti hari, truncate tabel antrian dan proses antrian karna live 
	*/	
	function __construct(){
		parent::__construct();
		$this->load->model('model');
		date_default_timezone_set("Asia/Jakarta");
		if ($this->session->userdata('logged_in')['akses'] != 'petugas' ){
			redirect("Account/logout");
		}

		$now 							=	date("Y-m-d H:i:s");
		$data['last_sync'] 				=	$this->model->read('settingan',array('id'=>1))->result();

		$datetime_now = new DateTime();
		$datetime_database = new DateTime($data['last_sync'][0]->value);
		if ($datetime_now->format('Y-m-d') > $datetime_database->format('Y-m-d')) {
			$this->model->update('settingan',array('id'=>1),array('value'=>$now));
			$this->model->rawQuery('TRUNCATE TABLE antrian');
			$this->model->rawQuery('TRUNCATE TABLE proses_antrian');
			
			$semua_record_pasien = $this->model->readS("pasien")->result();
			
			foreach ($semua_record_pasien as $key => $value) {
				$tgl_lahir  = new DateTime($value->tanggal_lahir);
				$now 		= new DateTime();
				$usia		= $now->diff($tgl_lahir)->y;
				if ($value->usia !== $usia) {
					$kode_usia = NULL;
					$nomor_pasien = explode("-", $value->nomor_pasien);
					$perubahan_nomor_pasien = false;

					if ($usia <= "14"){
						$kode_usia = "01";
					}elseif($usia >= "15" && $usia <= "49"){
						$kode_usia = "02";
					}elseif ($usia >= "50"){
						$kode_usia = "03";
					}

					if ($nomor_pasien[3] !== $kode_usia) {
						$perubahan_nomor_pasien = true;
					}

					if ($perubahan_nomor_pasien) {
						$nomor_pasien_modifed = $nomor_pasien[0]."-".$nomor_pasien[1]."-".$nomor_pasien[2]."-".$nomor_pasien[3]."-".$nomor_pasien[4]."-".$nomor_pasien[5];
						$this->model->update("pasien",array('id'=>$value->id),array('usia'=>$usia,'nomor_pasien'=>$nomor_pasien_modifed));
					}else{
						$this->model->update("pasien",array('id'=>$value->id),array('usia'=>$usia));
					}

				}
			}
		}
	}

	/*
	* function untuk menampilkan halaman pendaftaran pasien
	*/
	function pendaftaran()
	{
		$data 	= array(
			"active"					=>	"pendaftaran",
		);
		$this->load->view('petugas/header');
		$this->load->view('petugas/navbar',$data);
		$this->load->view('petugas/pendaftaran_pasien');
		$this->load->view('petugas/footer');
	}

	/*
	* form handler untuk register pasien
	*/
	function SubmitPendaftaran()
	{
		$nik = NULL;
		if ($this->input->post('nik') !== '' && $this->input->post('nik') !== NULL) {
			$nik = $this->input->post('nik');
		}

		$nik = NULL;
		if ($this->input->post('nik') !== '' && $this->input->post('nik') !== NULL) {
			$nik = $this->input->post('nik');
			$result = $this->model->read('pasien',array('nik'=>$nik));
			if ($result->num_rows() !== 0) {
				alert('alert','warning','Gagal','Duplikasi NIK');
				redirect("Petugas/pendaftaran");
			}
		}

		// ambil id terakhir
		$no_urut 	= $this->model->rawQuery("SELECT AUTO_INCREMENT AS no_urut FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'kesehatan' AND TABLE_NAME = 'pasien'")->result();

		// ambil id untuk dijadikan nomor identitas pasien
		if ($no_urut == array()) {
			$no_urut = "000";
		}else{
			if($no_urut[0]->no_urut <= 9){
				$no_urut = "00".$no_urut[0]->no_urut;
			}elseif ($no_urut[0]->no_urut >=10 && $no_urut[0]->no_urut <=99) {
				$no_urut = "0".$no_urut[0]->no_urut;
			}else{
				$no_urut = $no_urut[0]->no_urut;
			}
		}

		// ambil kode kelurahan
		$kelurahan_lain = NULL;
		$kelurahan = $this->input->post('kelurahan');
		$kd_kelurahan = substr($kelurahan, 0,3);
		if ($kelurahan == "013 Lain-lain" && $this->input->post('kelurahan_lain') !== '') {
			$kelurahan_lain = $this->input->post('kelurahan_lain');
		}

		// manipulasi kecamatan
		$kecamatan_lain = NULL;
		$kecamatan = $this->input->post('kecamatan');
		if ($kecamatan == 'other' && $this->input->post('kecamatan_lain') !== '') {
			$kecamatan_lain = $this->input->post('kecamatan_lain');
		}

		// manipulasi kota
		$kota_lain = NULL;
		$kota = $this->input->post('kota');
		if ($kota == 'other' && $this->input->post('kota_lain') !== '') {
			$kota_lain = $this->input->post('kota_lain');
		}

		// ambil jenis kelamin
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		if ($jenis_kelamin == 'Laki-laki') {
			$kode_jenis_kelamin = '01';
		}else{
			$kode_jenis_kelamin = '02';
		}

		// hitung umur
		$tgl_lahir  = new DateTime($this->input->post('tanggal_lahir'));
		$now 		= new DateTime();
		$usia		= $now->diff($tgl_lahir)->y;

		if ($usia <= "14") {
			$kode_usia = "01";
		}elseif($usia >= "15" && $usia <= "49"){
			$kode_usia = "02";
		}elseif ($usia >= "50") {
			$kode_usia = "03";
		}


		// bulan datang
		$bulan_datang = $now->format('m');

		// tahun datang
		$tahun_datang = $now->format('Y');

		$nama_ayah = NULL;
		if ($this->input->post('nama_ayah') !== NULL && $this->input->post('nama_ayah') !== '') {
			$nama_ayah = ucwords($this->input->post('nama_ayah'));
		}

		$nama_ibu = NULL;
		if ($this->input->post('nama_ibu') !== NULL && $this->input->post('nama_ibu') !== '') {
			$nama_ibu = ucwords($this->input->post('nama_ibu'));
		}

		// jika pembayaran == BPJS tambahkan nomornya
		$pembayaran = $this->input->post('pembayaran');
		$nomor_bpjs = NULL;
		if ($this->input->post('nomor_bpjs') !== '' && $this->input->post('nomor_bpjs') !== NULL) {
			$nomor_bpjs = $this->input->post('nomor_bpjs');
		}

		$dataForm = array(	'nama'			=>ucwords($this->input->post('nama_lengkap')),
			'nik' 			=>$nik,
			'tempat_lahir'	=>ucwords($this->input->post('tempat_lahir')),
			'tanggal_lahir' =>$tgl_lahir->format('Y-m-d'),
			'usia'			=>$usia,
			'jalan'			=>ucwords($this->input->post('jalan')),
			'kelurahan'		=>$kelurahan,
			'kecamatan'		=>$kecamatan,
			'kota'			=>$kota,
			'jenis_kelamin'	=>$this->input->post('jenis_kelamin'),
			'nomor_bpjs'	=>$nomor_bpjs,
			'pekerjaan'		=>ucwords($this->input->post('pekerjaan')),
			'pembayaran'	=>$pembayaran,
			'tanggal_datang'=>date("y-m-d"),
			'nama_ayah'		=>$nama_ayah,
			'nama_ibu'		=>$nama_ibu,
			'nomor_pasien'	=>$no_urut."-".$kd_kelurahan."-".$kode_jenis_kelamin."-".$kode_usia."-".$bulan_datang."-".$tahun_datang
		);

		if ($kelurahan_lain !== NULL) {
			$dataForm['kelurahan_lain'] = ucwords($kelurahan_lain);
		}
		if ($kecamatan_lain !== NULL) {
			$dataForm['kecamatan_lain'] = ucwords($kecamatan_lain);
		}
		if ($kota_lain !== NULL) {
			$dataForm['kota_lain'] = ucwords($kota_lain);
		}

		$result = json_decode($this->model->create('pasien',$dataForm),false);
		if ($result->status) {
			alert('alert','success','Berhasil','Registrasi berhasil');
			// redirect("pendaftaran");
			redirect("pemeriksaan-awal/".$dataForm['nomor_pasien']);
		}else{
			alert('alert','warning','Gagal',$result->error_message->message);
			redirect("pendaftaran");
		}
	}

	/*
	* function untuk menampilkan halaman live antrian.
	*/
	function antrian()
	{
		$data 	= array(
			"active"					=>	"antrian",
		);
		$this->load->view('petugas/header');
		$this->load->view('petugas/navbar',$data);
		$this->load->view('petugas/antrian');
		$this->load->view('petugas/footer');
	}

	/*
	* funtion untuk handle live antrian pada sisi petugas depan
	*/
	function liveAntrian()
	{
		$data['antrian']		=	$this->model->rawQuery('
			SELECT 
			pasien.nama, 
			antrian.id_pasien,
			pasien.id,
			antrian.id_rekam_medis,
			antrian.jam_datang, 
			antrian.nomor_antrian, 
			pasien.pembayaran, 
			pasien.nomor_pasien 
			FROM antrian 
			INNER JOIN pasien on antrian.id_pasien = pasien.id
			WHERE DATE(jam_datang) = DATE(CURRENT_DATE()) ORDER BY nomor_antrian
			')->result();

		$data['proses_antrian']	=	$this->model->rawQuery('
			SELECT 
			proses_antrian.id_pasien,
			pasien.nama, 
			proses_antrian.id_pasien, 
			pasien.id,
			proses_antrian.id_rekam_medis, 
			pasien.pembayaran 
			FROM proses_antrian 
			INNER JOIN pasien on proses_antrian.id_pasien = pasien.id
			')->result();
		echo json_encode($data);
	}

	/*
	* function untuk menampilkan halaman  pemeriksaan awal
	*/
	function pemeriksaanAwal($nomor_pasien ="")
	{
		if ($nomor_pasien != '' ) {
			$data 	= array(
				"active"					=>	"pemeriksaan-awal",
				"pasien"					=>	$this->model->read('pasien',array('nomor_pasien'=>$nomor_pasien))->result(),
			);
			$this->load->view('petugas/header',$data);
			$this->load->view('petugas/navbar',$data);
			$this->load->view('petugas/pemeriksaan_awal',$data);
		}else{
			redirect("cari-pasien-petugas");
		}
	}

	/*
	* function untuk menampilkan halaman cari pasien
	*/
	function cariPasien()
	{
		$data 	= array(
			"active"					=>	"pemeriksaan-awal",
		);
		$this->load->view('petugas/header');
		$this->load->view('petugas/navbar',$data);
		$this->load->view('petugas/cari_pasien');
	}

	/*
	* hadnler cari nama pasien via ajax
	*/
	function cariNama()
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
			redirect('logout');
		}
	}

	/*
	* cari nomor pasien via ajax
	*/
	function redirector()
	{
		if ($this->input->get() != NULL) {
			var_dump($this->input->get());
			redirect("pemeriksaan-awal/".$this->input->get('nama_or_nomor'));
		}else{
			echo "<pre>";
			var_dump($this->input->get());
		}
	}

	/*
	* form handler untuk pemeriksaan awal
	*/
	function submitPemeriksaanAwal()
	{
		$postedData = 	array(
			'tinggi_badan'		=>	$this->input->post('tinggi_badan'),
			'berat_badan'		=>	$this->input->post('berat_badan'),
			'sistol'			=>	$this->input->post('sistol'),
			'diastol'			=>	$this->input->post('diastol'),
			'nadi'				=>	$this->input->post('denyut_nadi'),
			'respiratory_rate'	=>	$this->input->post('frekuensi_pernapasan'),
			'temperature_ax'	=>	$this->input->post('suhu'),
			'id_pasien'		=>	$this->input->post('id_pasien'),
// 'nomor_pasien'		=>	$this->input->post('nomor_pasien'),
			'tanggal_jam'		=>	date("Y-m-d H:i:s")
		);

// echo "<pre>";
// var_dump($postedData);
// die();

// create ke tabel RM dengan isi objektif
		$insert_into_rekam_medis = $this->model->create_id('rekam_medis',$postedData);
		$insert_into_rekam_medis = json_decode($insert_into_rekam_medis);
		$result = json_decode($this->model->create("antrian",array("id_pasien"=>$this->input->post("id_pasien"),"jam_datang"=>date("Y-m-d H:i:s"),"id_rekam_medis"=> $insert_into_rekam_medis->message)),false);

		if ($result->status) {
			alert("alert","success","Berhasil","Data berhasil dimasukkan");
			redirect("antrian-petugas/");
		}else{
			alert("alert","success","Gagal","Kegagalan database".$result->error_message);
			redirect("pemeriksaan-awal/".$this->input->post('nomor_pasien'));
		}
	}

	/*
	* funtion untuk handle form submit proses antrian dan antrian. hapus atau proses sebuah antrian
	*/
	function submitAntrian($aksi,$id_pasien,$id_rekam_medis)
	{
		if ($aksi == 'proses') {
			$this->model->create(
				'proses_antrian',
				array(
					'id_pasien'	=>	$id_pasien,
					'id_rekam_medis'	=>	$id_rekam_medis
				)
			);
		}elseif ($aksi == 'hapus') {
			$this->model->rawQuery("DELETE FROM rekam_medis WHERE id ='".$id_rekam_medis."'");

// record akan selalu ada hingga dokter melakukan submit pemeriksaan. jadi aman jika menggunakan acuan id
			$this->model->delete(
				'proses_antrian',
				array(
					'id_pasien'	=>	$id_pasien
				));
		}
		$this->model->delete(
			'antrian',
			array(
				'id_pasien'	=>	$id_pasien
			));
		redirect("antrian-petugas");
	}
}