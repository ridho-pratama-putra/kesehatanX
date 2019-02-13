<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logistik extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->helper(array('Cookie', 'String'));
	}

	function redirectUrl($jenis_logistik)
	{
		if ($jenis_logistik == "obat_oral") {
			$url = "logistik-obat-oral";
			return $url;
		}elseif ($jenis_logistik == "obat_injeksi") {
			$url = "logistik-obat-injeksi";
			return $url;
		}elseif ($jenis_logistik == "alat_bahan_sekali_pakai") {
			$url = "logistik-alat-bahan-sekali-pakai";
			return $url;
		}elseif ($jenis_logistik == "obat_sigma_usus_externum") {
			$url = "logistik-obat-sigma-usus-externum";
			return $url;
		}
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
			alert('alert','success','Berhasil','Golongan Logistik telah di tambahkan');
		}else{
			alert('alert','danger','Gagal','Golongan Logistik gagal di tambahkan '.$exec->error_message->message);
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
			alert('alert','success','Berhasil','Golongan Logistik telah di update');
		}else{
			alert('alert','danger','Gagal','Golongan Logistik gagal di update '.$exec->error_message->message);
		}
		redirect("golongan-logistik");
	}

	function deleteGolongan($id)
	{
		$exec = $this->model->delete("golongan_logistik",array("id"=>$id));
		if ($exec) {
			alert('alert','success','Berhasil','Golongan Logistik telah di hapus');
		}else{
			alert('alert','warning','Gagal','Golongan Logistik gagal dihapus '.$exec->message);
		}
		redirect("golongan-logistik");
	}

	/*
	* get semua data ibat yang ada di database
	* $jenis obat isinya = oral|injeksi|
	*/
	function readLogistik($jenis_logistik){
		$active = array(
			"alat_bahan_sekali_pakai" 	=>	"logistik-alat-bahan-sekali-pakai",
			"obat_injeksi"				=>	"logistik-obat-injeksi",
			"obat_oral"					=>	"logistik-obat-oral",
			"obat_sigma_usus_externum"	=>	"logistik-obat-sigma-usus-externum"
		);

		$data 	= array(
			"active"					=>	$active[$jenis_logistik],
			"record"					=>	$this->model->rawQuery("SELECT golongan_logistik.nama_golongan, logistik_".$jenis_logistik.".* FROM logistik_".$jenis_logistik." INNER JOIN golongan_logistik ON golongan_logistik.id = logistik_".$jenis_logistik.".golongan")->result(),
			"golongan_logistik"			=>	$this->model->readS("golongan_logistik")->result()
		);

		$this->load->view($this->session->userdata('logged_in')['akses']."/header");
		$this->load->view($this->session->userdata('logged_in')['akses']."/navbar",$data);
		$this->load->view("logistik/logistik_".$jenis_logistik,$data);
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
		redirect($this->redirectUrl($jenis_logistik));
	}

	// create logistik berdsarkan parameter
	// $jenis_obat hanya bisa bernilai
	// - bahan_sekali_pakai
	// - obat_injeksi
	// - obat_oral
	// - sigma_usus_externum
	function editLogistik($jenis_logistik,$id)
	{
		$active = array(
			"alat_bahan_sekali_pakai" 	=>	"logistik-alat-bahan-sekali-pakai",
			"obat_injeksi"				=>	"logistik-obat-injeksi",
			"obat_oral"					=>	"logistik-obat-oral",
			"obat_sigma_usus_externum"		=>	"logistik-obat-sigma-usus-externum"
		);

		$data 	= array(
			"active"					=>	$active[$jenis_logistik],
			"record"					=>	$this->model->read("logistik_".$jenis_logistik,array("id"=>$id))->result(),
			"golongan_logistik"			=>	$this->model->readS("golongan_logistik")->result()
		);

		$this->load->view($this->session->userdata('logged_in')['akses']."/header");
		$this->load->view($this->session->userdata('logged_in')['akses']."/navbar",$data);
		$this->load->view("logistik/logistik_".$jenis_logistik."_edit",$data);
		$this->load->view($this->session->userdata('logged_in')['akses']."/footer");
	}

	function submitEditLogistik($jenis_logistik)
	{
		$data = $this->input->post();
		$id = $data['id'];
		unset($data['id']);

		$exec = $this->model->update("logistik_".$jenis_logistik,array("id"=>$id),$data);
		$exec = json_decode($exec);

		if ($exec->status) {
			alert('alert','success','Berhasil','Logistik telah di update');
		}else{
			alert('alert','danger','Gagal','Logistik gagal di update '.$exec->error_message->message);
		}
		redirect($this->redirectUrl($jenis_logistik)."-edit/".$id);
	}

	function deleteLogistik($jenis_logistik,$id)
	{
		$exec = $this->model->delete("logistik_".$jenis_logistik,array("id"=>$id));
		if ($exec) {
			alert('alert','success','Berhasil','Logistik telah di hapus');
		}else{
			alert('alert','warning','Gagal','Logistik gagal dihapus '.$exec->message);
		}
		redirect($this->redirectUrl($jenis_logistik));
	}
}
// UNSET THINGS
// $this->session->unset_userdata('sesi');
// var_dump($this->session->userdata('sesi'));