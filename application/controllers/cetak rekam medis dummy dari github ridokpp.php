<?php

/*
	* cetak surat sakit,sehat dan rujukan
	*/
	function submitCetak($surat)
	{
		$this->load->view('static/header');
		$this->load->view('static/navbar');
		$data['nomor_pasien']	= $this->input->post('nomor_pasien');
		if ($surat == 'suratsehat') {
			$data['tes_buta_warna']		= $this->input->post('tes_buta_warna');
			$data['keperluan']			= $this->input->post('keperluan');
			$data['tinggi_badan']		= $this->input->post('tinggi_badan');
			$data['berat_badan']		= $this->input->post('berat_badan');
			$data['sistol']				= $this->input->post('sistol');
			$data['diastol']			= $this->input->post('diastol');
			$data['nadi']				= $this->input->post('nadi');
			$data['respiratory_rate']	= $this->input->post('respiratory_rate');
			$data['temperature_ax']		= $this->input->post('temperature_ax');

			// nama dokter yang menangani
			$data['nama_user']		= $this->session->userdata('logged_in')['nama_user'];

			// sip dokter yang menangani
			$data['sip']			= $this->session->userdata('logged_in')['sip'];
			
			// data pasien yang sedang diperiksa
			$data['pasien']			= $this->Kesehatan_M->read('pasien',array('nomor_pasien'=>$data['nomor_pasien']))->result();
			
			// $data['rekam_medis']	= $this->Kesehatan_M->rawQuery("SELECT tinggi_badan,berat_badan,sistol,diastol,nadi,respiratory_rate,temperature_ax FROM rekam_medis WHERE nomor_pasien = ".$data['nomor_pasien']." ORDER BY id DESC LIMIT 1")->result();

			$nomor_surat 			= $this->Kesehatan_M->readCol('suratsehat',array('MONTH(tanggal_terbit)'=>date('m'),'YEAR(tanggal_terbit)'=>date('Y')),array('MAX(nomor_surat) AS nomor_surat'))->result();
			$insertSuratSehat['nomor_pasien']		= $data['nomor_pasien'];
			$insertSuratSehat['keperluan']			= $data['keperluan'];
			$insertSuratSehat['tes_buta_warna']		= $data['tes_buta_warna'];
			$insertSuratSehat['tanggal_terbit']		= date('Y-m-d');
			
			if ($nomor_surat == array()) {
				$insertSuratSehat['nomor_surat']	= 1;
				$data['nomor_surat'] 				= 1;
			}else{
				$insertSuratSehat['nomor_surat'] 	= intval($nomor_surat[0]->nomor_surat) + 1;
				$data['nomor_surat']				= $insertSuratSehat['nomor_surat'];
			}
			$this->Kesehatan_M->create('suratsehat',$insertSuratSehat);
			$kode_surat = "001";
			
			
		}elseif ($surat == 'suratsakit') {
			$data['alasan']		 	= $this->input->post('alasan');
			$data['tanggal_awal'] 	= $this->input->post('tanggal_awal');
			$data['tanggal_akhir'] 	= $this->input->post('tanggal_akhir');
			$data['selama'] 		= $this->input->post('selama');
			$data['selama_satuan'] 	= $this->input->post('selama_satuan');
			$data['nama_user']		= $this->session->userdata('logged_in')['nama_user'];
			$data['sip']			= $this->session->userdata('logged_in')['sip'];
			$data['pasien']			= $this->Kesehatan_M->read('pasien',array('nomor_pasien'=>$data['nomor_pasien']))->result();
			
			$nomor_surat = $this->Kesehatan_M->readCol('suratsakit',array('MONTH(tanggal_awal)'=>date('m'),'YEAR(tanggal_awal)'=>date('Y')),array('MAX(nomor_surat) AS nomor_surat'))->result();
			$insertSuratSakit['nomor_pasien']	= $data['nomor_pasien'];
			$insertSuratSakit['alasan']			= $data['alasan'];
			$insertSuratSakit['tanggal_awal']	= $data['tanggal_awal'];
			$insertSuratSakit['tanggal_akhir'] 	= $data['tanggal_akhir'];
			if ($nomor_surat == array()) {
				$insertSuratSakit['nomor_surat']	= 1;
				$data['nomor_surat'] 				= 1;
			}else{
				$insertSuratSakit['nomor_surat'] 	= intval($nomor_surat[0]->nomor_surat) + 1;
				$data['nomor_surat']				= $insertSuratSakit['nomor_surat'];
			}
			$this->Kesehatan_M->create('suratsakit',$insertSuratSakit);
			$kode_surat = "002";
			

		}elseif ($surat == 'suratrujukan') {

			$nomor_surat = $this->Kesehatan_M->readCol('suratsakit',array('MONTH(tanggal_awal)'=>date('m'),'YEAR(tanggal_awal)'=>date('Y')),array('MAX(nomor_surat) AS nomor_surat'))->result();
			if ($nomor_surat == array()) {
				$data['nomor_surat'] 				= 1;
			}else{				
				$data['nomor_surat']				= intval($nomor_surat[0]->nomor_surat) + 1;
			}
			// $this->Kesehatan_M->create('suratsakit',$insertSuratSakit);
			$kode_surat = "002";


			$data['nama_user']		= $this->session->userdata('logged_in')['nama_user'];
			$data['sip']			= $this->session->userdata('logged_in')['sip'];
			$data['pasien']			= $this->Kesehatan_M->read('pasien',array('nomor_pasien'=>$this->input->post('nomor_pasien')))->result();

			$data['data'] 	= 
			array
			(
				"subjektif" => $this->input->post("subjektif"),

				"gcs_e" => $this->input->post("gcs_e"),
				"gcs_v" => $this->input->post("gcs_v"),
				"gcs_m" => $this->input->post("gcs_m"),
				"gcs_opsi" => $this->input->post("gcs_opsi[]"),
				"diagnosa_primary" => $this->input->post("diagnosaPrimary[]"),
				"diagnosa_secondary" => $this->input->post("diagnosaSecondary[]"),
				"diagnosa_lain" => $this->input->post("diagnosaLain[]"),
				"diagnosa_pemeriksaan_lab" => $this->input->post("diagnosaPemeriksaanLab"),

				"tinggi_badan" => $this->input->post("tinggi_badan"),
				"berat_badan" => $this->input->post("berat_badan"),
				"sistol" => $this->input->post("sistol"),
				"diastol" => $this->input->post("diastol"),
				"respiratory_rate" => $this->input->post("respiratory_rate"),
				"nadi" => $this->input->post("nadi"),
				"temperature_ax" => $this->input->post("temperature_ax"),
				"headtotoe" => $this->input->post("headtotoe"),

				"anemis_kiri" => $this->input->post("anemis_kiri"),
				"anemis_kanan" => $this->input->post("anemis_kanan"),
				"ikterik_kiri" => $this->input->post("ikterik_kiri"),
				"ikterik_kanan" => $this->input->post("ikterik_kanan"),
				"cianosis_kiri" => $this->input->post("cianosis_kiri"),
				"cianosis_kanan" => $this->input->post("cianosis_kanan"),
				"deformitas_kiri" => $this->input->post("deformitas_kiri"),
				"deformitas_kanan" => $this->input->post("deformitas_kanan"),
				"refchy_opsi" => $this->input->post("refchy_opsi"),
				"refchy_kanan" => $this->input->post("refchy_kanan"),
				"refchy_kiri" => $this->input->post("refchy_kiri"),
				"kepala_ket_tambahan" => $this->input->post("kepala_ket_tambahan"),

				"paru_simetris_asimetris" => $this->input->post("paru_simetris_asimetris"),
				"wheezing_kiri" => $this->input->post("wheezing_kiri"),
				"wheezing_kanan" => $this->input->post("wheezing_kanan"),
				"ronkhi_kiri" => $this->input->post("ronkhi_kiri"),
				"ronkhi_kanan" => $this->input->post("ronkhi_kanan"),
				"vesikuler_kiri" => $this->input->post("vesikuler_kiri"),
				"vesikuler_kanan" => $this->input->post("vesikuler_kanan"),

				"jantung_ictuscordis" => $this->input->post("jantung_ictuscordis"),
				"jantung_s1_s2" => $this->input->post("jantung_s1_s2"),
				"jantung_suaratambahan" => $this->input->post("jantung_suaratambahan"),
				"jantung_ket_tambahan" => $this->input->post("jantung_ket_tambahan"),

				"BU" => $this->input->post("BU"),
				"nyeri_tekan1" => $this->input->post("nyeri_tekan1"),
				"nyeri_tekan2" => $this->input->post("nyeri_tekan2"),
				"nyeri_tekan3" => $this->input->post("nyeri_tekan3"),
				"nyeri_tekan4" => $this->input->post("nyeri_tekan4"),
				"nyeri_tekan5" => $this->input->post("nyeri_tekan5"),
				"nyeri_tekan6" => $this->input->post("nyeri_tekan6"),
				"nyeri_tekan7" => $this->input->post("nyeri_tekan7"),
				"nyeri_tekan8" => $this->input->post("nyeri_tekan8"),
				"nyeri_tekan9" => $this->input->post("nyeri_tekan9"),
				"hepatomegali" => $this->input->post("hepatomegali"),
				"spleenomegali" => $this->input->post("spleenomegali"),
				"abdomen_ket_tambahan" => $this->input->post("abdomen_ket_tambahan"),

				"akral_hangat1" => $this->input->post("akral_hangat1"),
				"akral_hangat2" => $this->input->post("akral_hangat2"),
				"akral_hangat3" => $this->input->post("akral_hangat3"),
				"akral_hangat4" => $this->input->post("akral_hangat4"),
				"crt1" => $this->input->post("crt1"),
				"crt2" => $this->input->post("crt2"),
				"crt3" => $this->input->post("crt3"),
				"crt4" => $this->input->post("crt4"),
				"edema1" => $this->input->post("edema1"),
				"edema2" => $this->input->post("edema2"),
				"edema3" => $this->input->post("edema3"),
				"edema4" => $this->input->post("edema4"),
				"pitting" => $this->input->post("pitting"),
				"ekstermitas_ket_tambahan" => $this->input->post("ekstermitas_ket_tambahan"),

				"lain_lain" => $this->input->post("lain_lain"),
				"planning" => $this->input->post("planning"),
				"terapi1" => $this->input->post("terapi1"),
				"terapi2" => $this->input->post("terapi2"),
				"terapi3" => $this->input->post("terapi3")
			);
		}
		$this->load->view('dokter/'.$surat,$data);
		$this->load->view('static/footer');
		$content = '';
		$content .= $this->load->view('static/header','',TRUE);
		$content .= $this->load->view('static/navbar','',TRUE);
		$content .= $this->load->view('dokter/'.$surat,$data,TRUE);
		$content .= $this->load->view('static/footer','',TRUE);

		$folder 	= FCPATH."/surat pasien/".$data['nomor_pasien']."/".$surat."/";
		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}
		$myfolder = fopen($folder."0".$data['nomor_surat']."-".$kode_surat."-0".date('m')."-2018.html", "w");
		fwrite($myfolder, $content);
		fclose($myfolder);
	}