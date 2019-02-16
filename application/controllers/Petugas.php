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
		// if ($this->session->userdata('logged_in')['akses'] != 'petugas' ){
		// 	redirect("Account/logout");
		// }

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
		// echo "<pre>";
		// var_dump($this->input->post());
		// die();
		$nik = $this->input->post('nik');

		// cek apakah nik tidak ada isinya? jika tidak ada maka langsung skip pembacaan nik duplikat di database dan langsung insert. jika ada maka cek dulu di db adakah duplikasi
		if ($nik !== '') {
			// var_dump($nik);
			// var_dump($this->input->post());die();
			$result = $this->model->read('pasien',array('nik'=>$nik));
			if ($result->num_rows() !== 0) {
				alert('alert','warning','Gagal','Duplikasi NIK');
				redirect("Petugas/pendaftaran");
			}
		}
		// echo "string";
		// die();

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
		$kelurahan = $this->input->post('kelurahan');
		$kd_kelurahan = substr($kelurahan, 0,3);
		$kelurahan_lain = '';
		if ($kelurahan == "013 Lain-lain") {
			$kelurahan_lain = $this->input->post('kelurahan_lain');
		}

		// manipulasi kecamatan
		$kecamatan_lain = '';
		$kecamatan = $this->input->post('kecamatan');
		if ($kecamatan == 'other') {
			$kecamatan_lain = $this->input->post('kecamatan_lain');
		}

		// manipulasi kota
		$kota = $this->input->post('kota');
		if ($kota == 'other') {
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

		// ambil pembayaran
		$pembayaran = $this->input->post('pembayaran');

		// bulan datang
		$bulan_datang = $now->format('m');

		// tahun datang
		$tahun_datang = $now->format('Y');
		
		// jika pembayaran == BPJS tambahkan nomornya
		$pembayaran = $this->input->post('pembayaran');
		// echo "$pembayaran";die()
		if ($pembayaran=='BPJS') {
			$pembayaran .= ' : '.$this->input->post('nomor_bpjs');
		}

		if ($this->input->post('nama_ayah') !== '' OR $this->input->post('nama_ayah') !== NULL) {
			$nama_ayah = $this->input->post('nama_ayah');
		}else{
			$nama_ayah = NULL;
		}

		if ($this->input->post('nama_ibu') !== '' OR $this->input->post('nama_ibu') !== NULL) {
			$nama_ibu = $this->input->post('nama_ibu');
		}else{
			$nama_ibu = NULL;
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
			'nomor_bpjs'	=>$this->input->post('nomor_bpjs'),
			'pekerjaan'		=>ucwords($this->input->post('pekerjaan')),
			'pembayaran'	=>$pembayaran,
			'tanggal_datang'=>date("y-m-d"),
			'nama_ayah'		=>ucwords($nama_ayah),
			'nama_ibu'		=>ucwords($nama_ibu),
			'nomor_pasien'	=>$no_urut."-".$kd_kelurahan."-".$kode_jenis_kelamin."-".$kode_usia."-".$bulan_datang."-".$tahun_datang
		);

		if ($kelurahan_lain !== '') {
			$dataForm['kelurahan_lain'] = ucwords($kelurahan_lain);
		}
		if ($kecamatan_lain !== '') {
			$dataForm['kecamatan_lain'] = ucwords($kecamatan_lain);
		}
		if ($kota_lain !== '') {
			$dataForm['kota_lain'] = ucwords($kota_lain);
		}

		// var_dump($dataForm);
		// die();
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
			antrian.jam_datang, 
			antrian.nomor_antrian, 
			pasien.pembayaran, 
			pasien.nomor_pasien 
			FROM antrian 
			INNER JOIN pasien on antrian.nomor_pasien=pasien.nomor_pasien
			WHERE DATE(jam_datang) = DATE(CURRENT_DATE()) ORDER BY nomor_antrian
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
			redirect("cari-pasien");
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
		$this->model->create('rekam_medis',$postedData);
		$result = json_decode($this->model->create("antrian",array("nomor_pasien"=>$this->input->post("nomor_pasien"),"jam_datang"=>date("Y-m-d H:i:s"))),false);

		if ($result->status) {
			alert("alert","success","Berhasil","Data berhasil dimasukkan");
			redirect("antrian/");
		}else{
			alert("alert","success","Gagal","Kegagalan database".$result->error_message);
			redirect("pemeriksaan-awal/".$this->input->post('nomor_pasien'));
		}
	}

		/*
	* funtion untuk handle form submit proses antrian dan antrian. hapus atau proses sebuah antrian
	*/
	function SubmitAntrian($aksi,$nomor_pasien)
	{
		if ($aksi == 'proses') {
			$this->model->create(
				'proses_antrian',
				array(
					'nomor_pasien'	=>	$nomor_pasien
				)
			);
		}elseif ($aksi == 'hapus') {
			$recordPasien = $this->model->read('pasien',array('nomor_pasien'=>$nomor_pasien))->result();
			$this->model->rawQuery("DELETE FROM rekam_medis WHERE id_pasien ='".$recordPasien[0]->id."' AND YEAR(tanggal_jam)='".date('Y')."' AND MONTH(tanggal_jam)='".date('m')."' AND DAY(tanggal_jam)='".date('d')."' ORDER BY id DESC LIMIT 1");

			$this->model->delete(
				'proses_antrian',
				array(
					'nomor_pasien'	=>	$nomor_pasien
				));
		}
		$this->model->delete(
			'antrian',
			array(
				'nomor_pasien'	=>	$nomor_pasien
			));
		redirect("antrian");
	}




}