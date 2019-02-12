<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class ProjectModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	/*
	* query : select * from table
	* select semua kolom pada tabel
	* $table (string) nama tabel
	*/
	public function readS($table){
		$query = $this->db->get($table);
		return $query;
	}
	
	/*
	* query : select from table where
	* select semua kolom pada tabel dengan kriteria tertentu(dataCondition)
	* $table (string) nama tabel
	* $dataCondition (sosiatif array/string) parameter where
	*/
	public function read($table,$dataCondition){
		$this->db->where($dataCondition);
		$query = $this->db->get($table);
		return $query;
	}

	/*
	* query : select kolom1, kolom2 from table
	* select beberapa kolom pada tabel
	* $table (string) nama tabel
	* $cols (asosiatif array) kolom-kolom yang ingin di select
	*/
	public function readSCol($table,$cols)
	{
		$this->db->select($cols);
		$query = $this->db->get($table);
		return $query;
	}

	/*
	* query : select kolom1,kolom2 from table where
	* select ebeberapa kolom pada tabel dengan kriteria where
	* $table (string) nama tabel
	* $dataCondition (asosiatif array) kriteria where
	* $cols (asosiatif array) kolom-kolom yang ingin di select
	*/
	public function readCol($table,$dataCondition,$cols)
	{
		$this->db->select($cols);
		$this->db->where($dataCondition);
		$query = $this->db->get($table);
		return $query;
	}

	/*
	* query : insert into table values('','','')
	* $tabel (string) nama tabel
	* $data (asosiatif array) record yang akan masuk.
	* json_decode() pada controller untuk membuka(bungkus) return.
	* kebutuhan encode karena ada kemungkinan dihandle ajax dan lebih enak transaksi melalui json
	*/
	public function create($table,$data){
		$query = $this->db->insert($table, $data);
		if (!$query) {
			return json_encode(array(
				'status' => false,
				'error_message' => $this->db->error()
			));
		}
		else{
			return json_encode(array(
				'status' => true,
				'error_message' =>""
			));
		}
	}

	/*
	* insert yang return id dari last inserted
	* gunakan json_decode() pada controller
	*/
	public function create_id($table,$data)
	{
		$query = $this->db->insert($table, $data);
		if (!$query) {
			return json_encode(array(
				'status' => false,
				'error_message' => $this->db->error()
			));
		}
		else{
			return json_encode(array(
				'status' => true,
				'message' => $this->db->insert_id()
			));
		}
	}

	/*
	* insert batch
	* gunakan json_decode()
	*/
	public function createS($table,$data){
		$query = $this->db->insert_batch($table,$data);
		if (!$query) {
			return json_encode(array(
				'status' => false,
				'error_message' => $this->db->error()
			));
		}
		else{
			return json_encode(array(
				'status' => true,
				'error_message' =>""
			));
		}
	}
	
	/*
	* untuk delete record dengan kondisi tertentu
	* return boolean
	*/
	public function delete($table,$dataCondition){
		$this->db->where($dataCondition);
		$result = $this->db->delete($table);
		if (!$result) {
			$error = $this->db->error();
			return $error;
		}
		else{
			return $result;
		}
	}

	/*
	* update from table set$dataupdate where $datacondition
	*/
	public function update($table,$dataCondition,$dataUpdate){
		$this->db->where($dataCondition);
		$result = $this->db->update($table,$dataUpdate);
		if ($result) {
			return json_encode(array(
				"status"=>true,
				"error_message"=>""
			));
		}else{
			return json_encode(array(
				"status"=>false,
				"error_message"=>$this->db->error()
			));
		}
	}
	
	public function andLike($table,$like){
		$this->db->like($like);
		$query = $this->db->get($table);
		return $query;
	}

	public function orLike($table,$like){
		$this->db->or_like($like);
		$query = $this->db->get($table);
		return $query;
	}

	/*raw query. query as strings*/
	public function rawQuery($query){
		$result = $this->db->query($query);
		if ($result) {
			return $result;
		}else{
			return $this->db->error();
		}
	}

	public function truncateTable($tabel)
	{
		$this->db->query('TRUNCATE TABLE'.$tabel);
	}	

}
?>