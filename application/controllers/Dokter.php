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
	* function untuk lihat antrian secara live di halaman antrian
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
			pasien.nomor_pasien,
			pasien.pembayaran 
			FROM proses_antrian 
			INNER JOIN pasien on proses_antrian.id_pasien = pasien.id
			')->result();
		// var_dump($data);
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
				$data[$key]['id'] = $value->id;
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
	function pemeriksaan($id_pasien,$id_rekam_medis = null)
	{
		$data 	= array(
			"active"					=>	"pemeriksaan-langsung",
			"pasien"					=>	$this->model->read('pasien',array('id'=>$id_pasien))->result(),
			"rekam_medis"			=>  $this->model->read('rekam_medis',array('id_pasien'=>$id_pasien))->result()
		);
		
		if ($data['pasien'] != array()) {

			// if -> jika pemeriksaan langsung
			// else -> jika dari antrian pasien
			if ($id_rekam_medis == null) {
				$data['current_pemeriksaan'] = array();
			}else{
				$data['current_pemeriksaan'] = $this->model->read('rekam_medis',
					array(
						'id'=> $id_rekam_medis
					))->result();
			}
			$this->load->view('dokter/header');
			$this->load->view('dokter/navbar',$data);
			$this->load->view('dokter/pemeriksaan',$data);
			$this->load->view('dokter/footer');
		}else{
			$this->load->view('dokter/header');
			$this->load->view('dokter/navbar',$data);
			$data['heading']	= "Antrian pasien yang dimaksud tidak ditemukan";
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
				$data[$key]['id'] = $value->id;
				$data[$key]['text'] = $value->nama;
				$data[$key]['sediaan'] = $value->sediaan;
				$data[$key]['bentuk'] = $value->bentuk;
				$data[$key]['stok'] = $value->stok;
				$data[$key]['harga'] = $value->harga_jual_satuan;
				if ($jenis_logistik == "alat_bahan_sekali_pakai") {
					$data[$key]['provider'] = $value->provider;
				}

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

	/*
	* bakal dipanggil saat penmbahan suatu obat ke troli
	*/
	function masukkanTroli()
	{
		// baca stok, kalau masih bisa dikurangi, ya kurangi, kalau tidak bisa dikurangi beri alert

		// kurangi stoknya
		$kurangi = $this->model->rawQuery("UPDATE logistik_".$this->input->post("jenis_logistik")." SET stok = stok - ".$this->input->post("jumlah")." WHERE id = ".$this->input->post("id_logistik"));
		
		if ($kurangi) {
			// masukkan ke troli
			$create = $this->model->create(
				"logistik_troli",
				array(
					"jenis_logistik" 	=> $this->input->post("jenis_logistik"),
					"id_logistik" 		=> $this->input->post("id_logistik"),
					"id_dokter" 		=> $this->session->userdata('logged_in')['id_user'],
					"id_pasien" 		=> $this->input->post("id_pasien"),
					"jumlah"			=> $this->input->post("jumlah")
				)
			);

			// baca id obat yang bersangkutan untuk mendapatkan data lengkap obat dan masukkan ke log logistik untuk keperluan tracking stok obat (ada laporannya). baca dulu data current stok lalu masukkan logistik_log
			$new_stok = $this->model->read("logistik_".$this->input->post("jenis_logistik"),array("id"=>$this->input->post("id_logistik")))->result();

			// baca di log_logsitik apakah sudah ada pencatatan pengurangan stok obat tersebut hari ini?
			// jika belum ada pencatatan stok keluar pada hari itu, maka create, else update
			$cek_tercatat_di_log_logistik = $this->model->read(
				"log_logistik",
				array(
					"jenis_logistik" => $this->input->post("jenis_logistik"),
					"id_obat" => $this->input->post("id"), 
					"tipe" => "keluar", 
					"DAY(datetime_init)" => date('d'), 
					"MONTH(datetime_init)" => date('m'), 
					"YEAR(datetime_init)" => date('Y')
				)
			)->num_rows();
			if ($cek_tercatat_di_log_logistik == 0) {
				$bool = $this->model->create(
					"log_logistik",
					array(
						'jenis_logistik' => $this->input->post("jenis_logistik"), 
						"id_obat" => $this->input->post("id_logistik"),
						"stok_sekarang" => $new_stok[0]->stok, 
						"stok_keluar "=> $this->input->post("jumlah"), 
						"datetime_init" => date("Y-m-d H:i:s"), 
						"datetime_last" => date("Y-m-d H:i:s"), 
						"tipe" => "keluar"
					)
				);
			}elseif ($cek_tercatat_di_log_logistik == 1) {
				$bool = $this->model->rawQuery(
					"UPDATE 
					log_logistik 
					SET 
					stok_keluar = ".$this->input->post("jumlah")." ,
					stok_sekarang = ".$new_stok[0]->stok." , 
					datetime_last = '".date("Y-m-d H:i:s")."' 
					WHERE 
					id_obat = ".$this->input->post("id_logistik")."
					AND 
					jenis_logistik = '".$this->input->post("jenis_logistik")."' 
					AND 
					DAY(datetime_init) = '".date('d')."' 
					AND 
					MONTH(datetime_init) = '".date('m')."' 
					AND 
					YEAR(datetime_init) = '".date('Y')."' 
					AND 
					tipe = 'keluar'"
				);
			}

			$create = json_decode($create);
			if ($create->status) {
				// read obat yang berkaitan unuk dirender di cliien
				$read = $this->model->rawQuery("
					SELECT 
					logistik_".$this->input->post("jenis_logistik").".nama,
					logistik_".$this->input->post("jenis_logistik").".sediaan,
					logistik_".$this->input->post("jenis_logistik").".bentuk,
					logistik_".$this->input->post("jenis_logistik").".harga_jual_satuan,
					logistik_troli.jumlah
					FROM
					logistik_troli
					INNER JOIN logistik_".$this->input->post("jenis_logistik")." ON logistik_troli.id_logistik = logistik_".$this->input->post("jenis_logistik").".id
					WHERE 
					logistik_troli.id_dokter = ".$this->session->userdata('logged_in')['id_user']." 
					AND 
					logistik_troli.id_pasien = ".$this->input->post("id_pasien")." AND logistik_troli.jenis_logistik = '".$this->input->post("jenis_logistik")."'")->result();

				foreach ($read as $key => $value) {
					$read[$key]->subtotal = ($read[$key]->jumlah * $read[$key]->harga_jual_satuan);
				}
				echo json_encode($read);
			}else{
				echo json_encode(array("status"=>"gagal create di logistik_troli","message"=>$create->error_message->message));
			}
		}else{
			echo json_encode(array("status"=>"gagal","message"=>"gagal update stok di tabel logistik_".$this->input->post("jenis_logistik")));
		}
	}

	/*
	* funtion untuk update rekam_medis (submit pemeriksaan)
	*/
	function submitPemeriksaan()
	{
		if ($this->input->post() !== array()) {

			$gcs = NULL;
			if ($this->input->post('gcs_e') !== '') {
				$gcs .= "E: ".$this->input->post('gcs_e');
			}
			if ($this->input->post('gcs_v') !== '') {
				$gcs .= " V: ".$this->input->post('gcs_v');
			}
			if ($this->input->post('gcs_m') !== '') {
				$gcs .= " M: ".$this->input->post('gcs_m');
			}

			if ($this->input->post('$gcs_opsi[]') !== NULL) {
				foreach ($this->input->post('$gcs_opsi[]') as $key => $value) {
					$gcs .= $value.",";
				}
				$gcs = rtrim($gcs,", ");
			}

			/*NOTE : jantung nggk perlu di manipulasi string karena setiap input field korelasi 1-1 dengan kolom*/

			/*kepala*/
			$kepala = NULL;
			if ($this->input->post('anemis_kiri') !== NULL OR $this->input->post('anemis_kanan') !== NULL) {
				$kepala .= " Anemis ";
				if ($this->input->post('anemis_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
				$kepala .= "/";
				if ($this->input->post('anemis_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
			}

			if ($this->input->post('ikterik_kiri') !== NULL OR $this->input->post('ikterik_kanan') !== NULL) {
				$kepala .= " Ikterik ";
				if ($this->input->post('ikterik_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
				$kepala .= "/";
				if ($this->input->post('ikterik_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
			}

			if ($this->input->post('cianosis_kiri') !== NULL OR $this->input->post('cianosis_kanan') !== NULL) {
				$kepala .= " Cianosis ";
				if ($this->input->post('cianosis_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
				$kepala .= "/";
				if ($this->input->post('cianosis_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
			}

			if ($this->input->post('deformitas_kiri') !== NULL OR $this->input->post('deformitas_kanan') !== NULL) {
				$kepala .= " Deformitas ";
				if ($this->input->post('deformitas_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
				$kepala .= "/";
				if ($this->input->post('deformitas_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
			}

			if ($this->input->post('refchy_kiri') !== NULL OR $this->input->post('refchy_kanan') !== NULL) {
				$kepala .= " Refleks cahaya ";
				if ($this->input->post('refchy_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
				$kepala .= "/";
				if ($this->input->post('refchy_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= "-";
				}
			}

			$kepala_ket_tambahan = NULL;
			if ($this->input->post('kepala_ket_tambahan') !== '') {
				$kepala_ket_tambahan = $this->input->post('kepala_ket_tambahan');
			}
			/*end kepala*/

			/*paru*/
			$paru = NULL;
			if ($this->input->post('wheezing_kiri') !== NULL OR $this->input->post('wheezing_kanan') !== NULL) {
				$paru .= "Wheezing ";
				if ($this->input->post('wheezing_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
				$paru .= "/";
				if ($this->input->post('wheezing_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
			}

			if ($this->input->post('Ronkhi_kiri') !== NULL OR $this->input->post('Ronkhi_kanan') !== NULL) {
				$paru .= " Ronkhi ";
				if ($this->input->post('ronkhi_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
				$paru .= "/";
				if ($this->input->post('ronkhi_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
			}

			if ($this->input->post('vesikuler_kiri') !== NULL OR $this->input->post('vesikuler_kanan') !== NULL) {
				$paru .= " Vesikuler ";
				if ($this->input->post('vesikuler_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
				$paru .= "/";
				if ($this->input->post('vesikuler_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= "-";
				}
			}
			/*end paru*/

			$record = array(
				'id_pasien'					=>	$this->input->post('id_pasien'),
				'tanggal_jam'				=>	date('Y-m-d H:i:s'),
				'subjektif'					=>	($this->input->post('subjektif') !== '' ? $this->input->post('subjektif') : NULL),
				'gcs_evm_opsi'				=>	$gcs,
				'tinggi_badan'				=>	($this->input->post('tinggi_badan') !== '' ? $this->input->post('tinggi_badan') : NULL),
				'berat_badan'				=>	($this->input->post('berat_badan') !== '' ? $this->input->post('berat_badan') : NULL),
				'sistol'					=>	($this->input->post('sistol') !== '' ? $this->input->post('sistol') : NULL),
				'diastol'					=>	($this->input->post('diastol') !== '' ? $this->input->post('diastol') : NULL),
				'nadi'						=>	($this->input->post('nadi') !== '' ? $this->input->post('nadi') : NULL),
				'respiratory_rate'			=>	($this->input->post('respiratory_rate') !== '' ? $this->input->post('respiratory_rate') : NULL),
				'temperature_ax'			=>	($this->input->post('temperature_ax') !== '' ? $this->input->post('temperature_ax') : NULL),
				'headtotoe'					=>	($this->input->post('headtotoe') !== '' ? $this->input->post('headtotoe') : NULL),
				'kepala'					=>	$kepala,
				'kepala_isokor_anisokor'	=>	$this->input->post('refchy_opsi_pemeriksaan'),
				'kepala_ket_tambahan'		=>	$kepala_ket_tambahan,
				'paru_simetris_asimetris'	=>	$this->input->post('paru_simetris_asimetris_pemeriksaan'),
				'paru'						=>	$paru,
				'jantung_ictuscordis'		=>	$this->input->post('jantung_ictuscordis'),
				'jantung_s1_s2'				=>	$this->input->post('jantung_s1_s2'),
				'jantung_suaratambahan'		=>	($this->input->post('jantung_suaratambahan') !== '' ? $this->input->post('jantung_suaratambahan') : NULL),
				'thorak_ket_tambahan'		=>	$this->input->post('thorak_ket_tambahan'),
				'abdomen_BU'				=>	$this->input->post('BU'),
				'nyeri_tekan1'				=>	$this->input->post('nyeri_tekan1'),
				'nyeri_tekan2'				=>	$this->input->post('nyeri_tekan2'),
				'nyeri_tekan3'				=>	$this->input->post('nyeri_tekan3'),
				'nyeri_tekan4'				=>	$this->input->post('nyeri_tekan4'),
				'nyeri_tekan5'				=>	$this->input->post('nyeri_tekan5'),
				'nyeri_tekan6'				=>	$this->input->post('nyeri_tekan6'),
				'nyeri_tekan7'				=>	$this->input->post('nyeri_tekan7'),
				'nyeri_tekan8'				=>	$this->input->post('nyeri_tekan8'),
				'nyeri_tekan9'				=>	$this->input->post('nyeri_tekan9'),
				'hepatomegali'				=>	($this->input->post('hepatomegali') !== '' ? $this->input->post('hepatomegali') : NULL),
				'spleenomegali'				=>	($this->input->post('spleenomegali') !== '' ? $this->input->post('spleenomegali') : NULL),
				'abdomen_ket_tambahan'		=>	($this->input->post('abdomen_ket_tambahan') !== '' ? $this->input->post('abdomen_ket_tambahan') : NULL),
				'akral_hangat1'				=>	$this->input->post('akral_hangat1'),
				'akral_hangat2'				=>	$this->input->post('akral_hangat2'),
				'akral_hangat3'				=>	$this->input->post('akral_hangat3'),
				'akral_hangat4'				=>	$this->input->post('akral_hangat4'),
				'crt_1'						=>	$this->input->post('crt_1'),
				'crt_2'						=>	$this->input->post('crt_2'),
				'crt_3'						=>	$this->input->post('crt_3'),
				'crt_4'						=>	$this->input->post('crt_4'),
				'edema_1'					=>	$this->input->post('edema_1'),
				'edema_2'					=>	$this->input->post('edema_2'),
				'edema_3'					=>	$this->input->post('edema_3'),
				'edema_4'					=>	$this->input->post('edema_4'),
				'pitting_nonpitting'		=>	$this->input->post('pitting_nonpitting'),
				'ekstermitas_ket_tambahan'	=>	($this->input->post('ekstermitas_ket_tambahan') !== '' ? $this->input->post('ekstermitas_ket_tambahan') : NULL),
				'lain_lain'					=>	($this->input->post('lain_lain') !== '' ? $this->input->post('lain_lain') : NULL),
				'terapi_1'					=>	($this->input->post('terapi_3') !== '' ? $this->input->post('terapi_3') : NULL),
				'terapi_2'					=>	($this->input->post('terapi_1') !== '' ? $this->input->post('terapi_1') : NULL),
				'terapi_3'					=>	($this->input->post('terapi_2') !== '' ? $this->input->post('terapi_2') : NULL),
				'dokter_pemeriksa'			=>	$this->session->userdata('logged_in')['id_user'],
				'planning'					=>	($this->input->post('planning') !== '' ? $this->input->post('planning').". " : '')." Biaya dokter: ".$this->input->post('biaya_dokter').". Total biaya: ".$this->input->post('total_harga_logistik')
			);

			/*run query ke rekam medis, update atau create. kemudian get id nya untuk keperluan insert assessment ke tabel yang berelasi (tabel assesssment)
			if -> pemeriksaan dari antrian (update)
			else -> pemeriksaan dari pemeriksaan langsung (create)
			*/
			if ($this->input->post('id_rekam_medis') !== '') {
				$queryToRekamMedis = $this->model->update('rekam_medis',array("id"=>$this->input->post('id_rekam_medis')),$record);
				$queryToRekamMedis = json_decode($queryToRekamMedis);
				$id_rekam_medis = $this->input->post('id_rekam_medis');
			}else{
				$queryToRekamMedis = $this->model->create_id('rekam_medis',$record);
				$queryToRekamMedis = json_decode($queryToRekamMedis);
				$id_rekam_medis = $queryToRekamMedis->message;
			}

			/*insert ke tabel assesmet*/
			if ($this->input->post('assessmentPrimary') !== NULL OR $this->input->post('assessmentSecondary') !== NULL OR $this->input->post('assessmentLain') !== NULL OR $this->input->post('assessmentPemeriksaanLab') !== '') {

													// 1. baca created_id (jika itu dari pemeriksaan langsung) atau current_id_rekam_medis (jika dari antrian pasien yang ditulis oleh petugas)

													// 2. masukkan assessment inputan ke tabel assessment disertai id rekam medis yang berkaitan
				$stringDiagnosa 			= "INSERT INTO assessment VALUES ";
				if ($this->input->post('assessmentPrimary') != array()) {
					foreach ($this->input->post('assessmentPrimary') as $key => $value) {
						$stringDiagnosa		 	.= "(NULL,'$id_rekam_medis','primer','$value'),";
					}
				}

													// manipulasi string untuk masuk ke assessment. tipenya sekunder
				if ($this->input->post('assessmentSecondary') != array()) {
					foreach ($this->input->post('assessmentSecondary') as $key => $value) {
						$stringDiagnosa 		.= "(NULL,'$id_rekam_medis','sekunder','$value'),";
					}
				}

													// manipulasi string untuk masuk ke assessment. tipenya lainlain
				if ($this->input->post('assessmentLain') != array()) {
					foreach ($this->input->post('assessmentLain') as $key => $value) {
						$stringDiagnosa 	 	.= "(NULL,'$id_rekam_medis','lainlain','$value'),";
					}
				}

													// manipulasi string untuk masuk ke assessment. tipenya adalah pemeriksaan lab
				if ($this->input->post('assessmentPemeriksaanLab') != '') {
					$stringDiagnosa				.= "(NULL,'$id_rekam_medis','pemeriksaanLab','".$this->input->post('assessmentPemeriksaanLab')."'),";
				}
				$stringDiagnosa				= rtrim($stringDiagnosa,",");

													// masukkan kd_assessment beserta data pemeriksaan primer sekunder lainlain pememeriksaan lab ke tabel assessment
				$this->model->rawQuery($stringDiagnosa);
			}
			/*end insert ke tabel assesmet*/

			if ($queryToRekamMedis->status) {
				$this->model->delete('proses_antrian',array('id_pasien'=>$this->input->post('id_pasien')));
				$this->model->delete(
					'logistik_troli',
					array(
						'id_dokter' => $this->session->userdata('logged_in')['id_user'],
						'id_pasien' => $this->input->post('id_pasien')
					)
				);
				if ($this->input->post('id_rekam_medis') !== '') {
					alert('alert','success','Berhasil','Data berhasil diupdate');
				}else{
					alert('alert','success','Berhasil','Data berhasil dimasukkan');
				}
				redirect("antrian-dokter");
			}else{
				alert('alert','danger','Gagal','Kegagalan database : '.$insertIntoRekamMedis->error_message->message);
				redirect("pemeriksaan/".$this->input->post('nomor_pasien'));
			}
		}else{
			$data['heading']	= "Halaman tidak ditemukan";
			$data['message']	= "<p> Tidak ada data yang di post</p>";
			$this->load->view('errors/html/error_404',$data);
		}
	}

	/*
	* funtion untuk handle form submit proses antrian dan antrian. hapus atau proses sebuah antrian
	*/
	function submitAntrian($aksi,$id_pasien,$id_rekam_medis)
	{
		$this->model->delete(
			'antrian',
			array(
				'id_pasien'	=>	$id_pasien
			));
		if ($aksi == 'proses') {
			$this->model->create(
				'proses_antrian',
				array(
					'id_pasien'	=>	$id_pasien,
					'id_rekam_medis'	=>	$id_rekam_medis
				)
			);
			redirect("pemeriksaan/$id_pasien/$id_rekam_medis");
		}elseif ($aksi == 'hapus') {
			$this->model->rawQuery("DELETE FROM rekam_medis WHERE id ='".$id_rekam_medis."'");

			// record akan selalu ada hingga dokter melakukan submit pemeriksaan. jadi aman jika menggunakan acuan id
			$this->model->delete(
				'proses_antrian',
				array(
					'id_pasien'	=>	$id_pasien
				));
		}

		redirect("antrian-dokter");
	}

	/*
	* function untuk menampilkan halam pasien yang telah terdafta dalam bentuk tabel
	*/
	function listPasien()
	{
		$data 	= array(
			"active"					=>	"list-pasien",
			"pasien"					=>	$this->model->readS("pasien")->result()
		);
		$this->load->view('dokter/header');
		$this->load->view('dokter/navbar',$data);
		$this->load->view('dokter/list_pasien',$data);
		$this->load->view('dokter/footer');
	}

	/*
	* function untuk edit data pasien
	*/
	function editIdentitasPasien($id){
		$data 	= array(
			"active"					=>	"list-pasien",
			"pasien"					=>	$this->model->read("pasien",array("id"=>$id))->result()
		);
		$this->load->view('dokter/header');
		$this->load->view('dokter/navbar',$data);
		$this->load->view('dokter/edit_pasien',$data);
		$this->load->view('dokter/footer');
	}

	/*
	* function untuk lihat detail identitas dan rekam medis pasien. berdsarkan id
	*/
	function detailRekamMedisPasien($id)
	{
		$data 	= array(
			"active"					=>	"list-pasien",
			"pasien"					=>	$this->model->read("pasien",array("id"=>$id))->result(),
			"rekam_medis"				=>	$this->model->rawQuery("
				SELECT 
				rekam_medis.*,
				user.nama,
				(SELECT GROUP_CONCAT(assessment.tipe,' ',assessment.detil SEPARATOR ' ; ') FROM assessment WHERE assessment.id_assessment_for_rekam_medis = rekam_medis.id) AS kelompok 
				FROM 
				rekam_medis 
				LEFT JOIN user ON rekam_medis.dokter_pemeriksa = user.id 
				WHERE rekam_medis.id_pasien = $id
				AND MONTH(tanggal_jam) = '".date('m')."'
				AND YEAR(tanggal_jam) = '".date('Y')."'
				")->result()
		);
		$this->load->view('dokter/header');
		$this->load->view('dokter/navbar',$data);
		$this->load->view('dokter/detail_pasien',$data);
		$this->load->view('dokter/footer');
	}

	/*
	* function untuk hapus data pasien yang terdaftar. hapus data dan rekam medisnya
	*/
	function deletePasien($id)
	{
		$bool = $this->model->delete('pasine',array('id'=>$id));
		if (!$bool) {
			alert('alert','success','Berhasil','Data berhasil dihapus');
		}else{
			alert('alert','danger','Gagal','Data gagal dihapus');
		}
		redirect("list-pasien");
	}

	/*
	*
	*/
	function submitEditIdentitasPasien()
	{
		echo "<pre>";
		var_dump($this->input->post());

		if($this->input->post('id_pasien') <= 9){
			$no_urut = "00".$this->input->post('id_pasien');
		}elseif ($this->input->post('id_pasien') >=10 && $this->input->post('id_pasien') <=99) {
			$no_urut = "0".$this->input->post('id_pasien');
		}else{
			$no_urut = $this->input->post('id_pasien');
		}

		$nik = NULL;
		if ($this->input->post('nik') !== '' && $this->input->post('nik') !== NULL) {
			$nik = $this->input->post('nik');
			$result = $this->model->read('pasien',array('nik'=>$nik));
			if ($result->num_rows() !== 0) {

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
		preg_match('#^(\d{4})-(\d{2})-(\d{2})$#', $this->input->post('tanggal_datang'), $results);
		var_dump($results);
		$bulan_datang = $results[2];

		// tahun datang
		$tahun_datang = $results[1];

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

		$dataForm = array(	
			'nama'			=>ucwords($this->input->post('nama')),
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
			'tanggal_datang'=>$this->input->post('tanggal_datang'),
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

		$bool = $this->model->update("pasien",array("id"=>$this->input->post("id_pasien")),$dataForm);
		$bool = json_decode($bool);

		if ($bool->status) {
			alert('alert','success','Berhasil','Data berhasil diupdate');
			redirect("edit-identitas-pasien/".$this->input->post("id_pasien"));
		}else{
			var_dump($bool);
		}
	}
}