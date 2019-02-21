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
				$data[$key]['id'] = $value->id;
				$data[$key]['text'] = $value->nama;
				$data[$key]['sediaan'] = $value->sediaan;
				$data[$key]['bentuk'] = $value->bentuk;
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

			$readLogistik = $this->model->read("logistik_".$this->input->post("jenis_logistik"),array("id"=>$this->input->post("id_logistik")))->result();

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
					WHERE logistik_troli.id_dokter = ".$this->session->userdata('logged_in')['id_user']." AND logistik_troli.id_pasien =".$this->input->post("id_pasien"))->result();

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

			$gcs = '';
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

			/*insert ke tabel assesmet*/
			$available_id_assessment = NULL;
			if ($this->input->post('assessmentPrimer') !== NULL OR $this->input->post('assessmentSekunder') !== NULL OR $this->input->post('assessmentLain') !== NULL OR $this->input->post('assessmentPemeriksaanLab') !== '') {
				
				// 1. baca available available_id_assessment di tabel available_id_assessment
				$available_id_assessment = $this->model->readS('available_id_assessment')->result();
				$available_id_assessment = $available_id_assessment[0]->available_id_assessment;

				// 2. segera update available_id_assessment di tabel available_id_assessment. agar saat digunakan oleh dokter lain tidak crash
				$this->model->rawQuery("UPDATE available_id_assessment SET available_id_assessment = available_id_assessment + 1 WHERE available_id_assessment ='$available_id_assessment'");

				// 3. masukkan assessment inputan ke tabel assessment disertai available id yang sudah diambil
				$stringDiagnosa 			= "INSERT INTO assessment VALUES ";
				if ($this->input->post('assessmentPrimer') != array()) {
					foreach ($this->input->post('assessmentPrimer') as $key => $value) {
						$stringDiagnosa		 	.= "(NULL,'$available_id_assessment','primer','$value'),";
					}
				}

				// manipulasi string untuk masuk ke assessment. tipenya sekunder
				if ($this->input->post('assessmentSekunder') != array()) {
					foreach ($this->input->post('assessmentSekunder') as $key => $value) {
						$stringDiagnosa 		.= "(NULL,'$available_id_assessment','sekunder','$value'),";
					}
				}

				// manipulasi string untuk masuk ke assessment. tipenya lainlain
				if ($this->input->post('assessmentLain') != array()) {
					foreach ($this->input->post('assessmentLain') as $key => $value) {
						$stringDiagnosa 	 	.= "(NULL,'$available_id_assessment','lainlain','$value'),";
					}
				}

				// manipulasi string untuk masuk ke assessment. tipenya adalah pemeriksaan lab
				if ($this->input->post('assessmentPemeriksaanLab') != '') {
					$stringDiagnosa				.= "(NULL,'$available_id_assessment','pemeriksaanLab','".$this->input->post('assessmentPemeriksaanLab')."'),";
				}
				$stringDiagnosa				= rtrim($stringDiagnosa,",");

				// masukkan kd_assessment beserta data pemeriksaan primer sekunder lainlain pememeriksaan lab ke tabel assessment
				$this->model->rawQuery($stringDiagnosa);
			}
			/*end insert ke tabel assesmet*/

			/*kepala*/
			$kepala = NULL;
			if ($this->input->post('anemis_kiri') !== NULL OR $this->input->post('anemis_kanan') !== NULL) {
				$kepala .= " Anemis ";
				if ($this->input->post('anemis_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
				$kepala .= "/";
				if ($this->input->post('anemis_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
			}

			if ($this->input->post('ikterik_kiri') !== NULL OR $this->input->post('ikterik_kanan') !== NULL) {
				$kepala .= " Ikterik ";
				if ($this->input->post('ikterik_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
				$kepala .= "/";
				if ($this->input->post('ikterik_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
			}

			if ($this->input->post('cianosis_kiri') !== NULL OR $this->input->post('cianosis_kanan') !== NULL) {
				$kepala .= " Cianosis ";
				if ($this->input->post('cianosis_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
				$kepala .= "/";
				if ($this->input->post('cianosis_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
			}

			if ($this->input->post('deformitas_kiri') !== NULL OR $this->input->post('deformitas_kanan') !== NULL) {
				$kepala .= " Deformitas ";
				if ($this->input->post('deformitas_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
				$kepala .= "/";
				if ($this->input->post('deformitas_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
			}

			if ($this->input->post('refchy_kiri') !== NULL OR $this->input->post('refchy_kanan') !== NULL) {
				$kepala .= " Refleks cahaya ";
				if ($this->input->post('refchy_kiri') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
				$kepala .= "/";
				if ($this->input->post('refchy_kanan') == '1') {
					$kepala .= "+";
				}else{
					$kepala .= " ";
				}
			}
			/*end kepala*/

			/*paru*/
			$paru = NULL;
			if ($this->input->post('wheezing_kiri') !== NULL OR $this->input->post('wheezing_kanan') !== NULL) {
				$paru .= "Wheezing ";
				if ($this->input->post('wheezing_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
				$paru .= "/";
				if ($this->input->post('wheezing_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
			}

			if ($this->input->post('Ronkhi_kiri') !== NULL OR $this->input->post('Ronkhi_kanan') !== NULL) {
				$paru .= " Ronkhi ";
				if ($this->input->post('ronkhi_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
				$paru .= "/";
				if ($this->input->post('ronkhi_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
			}

			if ($this->input->post('vesikuler_kiri') !== NULL OR $this->input->post('vesikuler_kanan') !== NULL) {
				$paru .= " Vesikuler ";
				if ($this->input->post('vesikuler_kiri') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
				$paru .= "/";
				if ($this->input->post('vesikuler_kanan') == '1') {
					$paru .= "+";
				}else{
					$paru .= " ";
				}
			}
			/*end paru*/

			/* manipulasi string untuk kolom planning */
			$planning = NULL;
			if ($this->input->post('planning') !== '') {
				$planning .= $this->input->post('planning').". ";
			}
			/* manipulasi string untuk kolom planning */
			
			/*ekstrak value dari select2, pisahkan id beserta nama obatnya agar tidak baca lagi di database. nama obat disertakan untuk keperluan penambahan kolom planning*/
			$id_obat = array();
			$nama_obat = array();
			if ($this->input->post('obat') !==NULL) {
				foreach ($this->input->post('obat') as $key => $value) {
					$temp = explode("|", $value);
					array_push($id_obat, $temp[0]);
					array_push($nama_obat, $temp[1]);
				}
			}
			/*end ekstrak value dari select2, pisahkan id beserta nama obatnya agar tidak baca lagi di database. nama obat disertakan untuk keperluan penambahan kolom planning*/
			

			/*untuk setiap obat, lakukan penggabungan string ke $planning, nggk usah update stok logistik karena sudah otomatis dikurangi saat masukkan logsitik e troli*/
			foreach ($id_obat as $key => $value) {
				$planning .= $nama_obat[$key]." ".$this->input->post('jumlah_obat')[$key]." ".$this->input->post('satuan')[$key].". ";
				// $this->model->rawQuery("UPDATE logistik SET stok = stok - ".$this->input->post('jumlah_obat')[$key]." WHERE id = $value");
			}
			/*end untuk setiap obat, lakukan pengurangan stok pada tabel logistik*/
			$record = array(
				'id_pasien'					=>	$this->input->post('id_pasien'),
				'tanggal_jam'				=>	date('Y-m-d H:i:s'),
				'subjektif'					=>	$this->input->post('subjektif'),
				'gcs_evm_opsi'				=>	$gcs,
				'tinggi_badan'				=>	$this->input->post('tinggi_badan'),
				'berat_badan'				=>	$this->input->post('berat_badan'),
				'sistol'					=>	$this->input->post('sistol'),
				'diastol'					=>	$this->input->post('diastol'),
				'nadi'						=>	$this->input->post('nadi'),
				'respiratory_rate'			=>	$this->input->post('respiratory_rate'),
				'temperature_ax'			=>	$this->input->post('temperature_ax'),
				'headtotoe'					=>	$this->input->post('headtotoe'),
				'kepala'					=>	$kepala,
				'kepala_isokor_anisokor'	=>	$this->input->post('refchy_opsi'),
				'kepala_ket_tambahan'		=>	$this->input->post('kepala_ket_tambahan'),
				'paru_simetris_asimetris'	=>	$this->input->post('paru_simetris_asimetris'),
				'paru'						=>	$paru,
				'jantung_ictuscordis'		=>	$this->input->post('jantung_ictuscordis'),
				'jantung_s1_s2'				=>	$this->input->post('jantung_s1_s2'),
				'jantung_suaratambahan'		=>	$this->input->post('jantung_suaratambahan'),
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
				'hepatomegali'				=>	$this->input->post('hepatomegali'),
				'spleenomegali'				=>	$this->input->post('spleenomegali'),
				'abdomen_ket_tambahan'		=>	$this->input->post('abdomen_ket_tambahan'),
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
				'ekstermitas_ket_tambahan'	=>	$this->input->post('ekstermitas_ket_tambahan'),
				'lain_lain'					=>	$this->input->post('lain_lain'),
				'id_assessment'				=>	$available_id_assessment,
				'terapi_1'					=>	$this->input->post('terapi_1'),
				'terapi_2'					=>	$this->input->post('terapi_2'),
				'terapi_3'					=>	$this->input->post('terapi_3'),
				'dokter_pemeriksa'			=>	$this->session->userdata('logged_in')['id_user'],
				'planning'					=>	$planning
			);

			// echo "<pre>";
			// var_dump($record);
			// die();



			// insert ke tabel assessment
			$insertIntoRekamMedis = $this->model->create('rekam_medis',$record);
			$insertIntoRekamMedis = json_decode($insertIntoRekamMedis);

			if ($insertIntoRekamMedis->status) {
				$this->model->delete('proses_antrian',array('nomor_pasien'=>$this->input->post('nomor_pasien')));
				alert('alert','success','Berhasil','Data berhasil dimasukkan');
				redirect("antrian-dokter");
			}else{
				alert('alert','danger','Gagal','Kegagalan database'.$insertIntoRekamMedis->error_message->message);
				// echo "<pre>";
				// var_dump($this->input->post('nomor_pasien'));
				// die();
				redirect("pemeriksaan/".$this->input->post('nomor_pasien'));
			}

		}else{
			$data['heading']	= "Halaman tidak ditemukan";
			$data['message']	= "<p> Tidak ada data yang di post</p>";
			$this->load->view('errors/html/error_404',$data);
		}
	}

}                                                                  