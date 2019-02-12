<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistik extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->helper(array('Cookie', 'String'));
	}

	function readGolongan()
	{
		$data 	= array(
			"active"					=>	"golongan-logistik",
			"record"					=>	$this->model->readS("golongan_logistik")->result()
		);
		$this->load->view($this->session->userdata('logged_in')['akses']."/header");
		$this->load->view($this->session->userdata('logged_in')['akses']."/navbar",$data);
		$this->load->view("logistik/golongan_logistik",$data);
		$this->load->view($this->session->userdata('logged_in')['akses']."/footer");
	}

	function createGolongan()
	{
		$exec = $this->model->create("golongan_logistik",array("nama_golongan"=>$this->input->post('nama_golongan')));
		$exec = json_decode($exec);
		if ($exec->status) {
			alert('alert','success','Berhasil','Golongan Obat telah di tambahkan');
		}else{
			alert('alert','danger','Gagal','Golongan Obat gagal di tambahkan '.$exec->error_message->message);
		}
		redirect("golongan-logistik");
	}

	function updateGolongan($id)
	{
		$exec = $this->model->update(
			"golongan_logistik",
			array(
				"id"	=>	$id
			),
			array(
				"nama_golongan"=>$this->input->post('nama_golongan')
			)
		);
		$exec = json_decode($exec);
		if ($exec->status) {
			alert('alert','success','Berhasil','Golongan Obat telah di update');
		}else{
			alert('alert','danger','Gagal','Golongan Obat gagal di update '.$exec->error_message->message);
		}
		redirect("golongan-logistik");
	}

	function deleteGolongan($id)
	{
		$exec = $this->model->delete("golongan_logistik",array("id"=>$id));
		if ($exec) {
			alert('alert','success','Berhasil','Golongan Obat telah di hapus');
		}else{
			alert('alert','warning','Gagal','Golongan Obat gagal dihapus '.$exec->message);
		}
		redirect("golongan-logistik");
	}

	/*
	* get semua data ibat yang ada di database
	* $jenis obat isinya = oral|injeksi|
	*/
	function readLogistik($jenis_obat){
		$active = array(
			"alat_bahan_sekali_pakai" 	=>	"logistik-bahan-sekali-pakai",
			"obat_injeksi"				=>	"logistik-obat-injeksi",
			"obat_oral"					=>	"logistik-obat-oral",
			"sigma_usus_externum"		=>	"logistik-sigma_usus_externum"
		);

		$data 	= array(
			"active"					=>	$active[$jenis_obat],
			"record"					=>	$this->model->readS("logistik_".$jenis_obat)->result(),
			"golongan_logistik"			=>	$this->model->readS("golongan_logistik")->result()
		);

		$this->load->view($this->session->userdata('logged_in')['akses']."/header");
		$this->load->view($this->session->userdata('logged_in')['akses']."/navbar",$data);
		$this->load->view("logistik/logistik_".$jenis_obat,$data);
		$this->load->view($this->session->userdata('logged_in')['akses']."/footer");
	}

	// get data untuk dijadikan autocomplte
	function autocomplete($table,$col){
		$data['data'] = $this->model->readSCol($table,$col)->result();
		echo json_encode($data);
	}

	// create logistik berdsarkan parameter
	// $jenis_obat hanya bisa bernilai
	// - bahan_sekali_pakai
	// - obat_injeksi
	// - obat_oral
	// - sigma_usus_externum
	function createLogistik($jenis_logistik)
	{
		$cek_duplikasi_logistik = "SELECT COUNT(id) as jumlah FROM logistik_$jenis_logistik WHERE ";
		$cek_duplikasi_logistik .= " nama = '".$this->input->post("nama")."' AND sediaan = '".$this->input->post("sediaan")."' AND bentuk = '".$this->input->post("bentuk")."'";
		$bool = $this->model->rawQuery($cek_duplikasi_logistik)->result();
		if (intval($bool[0]->jumlah) == 1) {
			alert('alert','warning','Peringatan','Logistik telah ada sebelumnya ');
		}else{
			$exec_query = $this->model->create("logistik_".$jenis_logistik,$this->input->post());
			$exec_query = json_decode($exec_query);
			if ($exec_query->status) {
				alert('alert','success','Berhasil','Logistik telah di tambahkan');
			}else{
				alert('alert','warning','Gagal','Logistik gagal di tambahkan Error : '.$exec_query->error_message->message);
			}
		}
		if ($jenis_logistik == "obat_oral") {
			redirect("logistik-obat-oral");
		}elseif ($jenis_logistik == "obat_injeksi") {
			redirect("logistik-obat-injeksi");
		}elseif ($jenis_logistik == "alat_bahan_sekali_pakai") {
			redirect("logistik-alat-bahan-sekali-pakai");
		}
	}
}
// UNSET THINGS
// $this->session->unset_userdata('sesi');
// var_dump($this->session->userdata('sesi'));