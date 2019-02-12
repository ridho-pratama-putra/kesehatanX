<?php
if (!isset($title) AND !isset($pasien)) {
	$title = "KLINIK DU'A";
}else{
	$title = "Pasien : ".$pasien[0]->nama;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<title><?=$title?></title>
	<link rel="icon" href="<?=base_url()?>assets/images/LOGO YAYASAN.png">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/jQuery-Autocomplete-master/content/styles.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css"/>
	
	<link rel="stylesheet" href="<?php echo base_url()?>assets/select2/dist/css/select2.min.css"/>
	<link rel="stylesheet" href="<?php echo base_url()?>assets/select2-bootstrap/select2-bootstrap.min.css"></link>

	<link rel="stylesheet" href="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/css/buttons.dataTables.min.css"></link> <!-- Lama iclude Logistik -->
	<link rel="stylesheet" href="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css"></link> <!-- Lama iclude Logistik -->

	<link rel="stylesheet" href="<?php echo base_url()?>assets/datatables-logistik/css/select.dataTables.min.css"></link> <!-- Baru Logistik -->
	<link rel="stylesheet" href="<?php echo base_url()?>assets/datatables-logistik/css/editor.dataTables.min.css"></link> <!-- Baru Logistik -->

	<link rel="stylesheet" href="<?php echo base_url()?>assets/klinikstyle/css/klinik.css"></link>

	<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.css"/> -->
	<script src="<?php echo base_url()?>assets/bootstrap/js/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/popper.min.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- <script src="<?php echo base_url()?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
	<script src="<?php echo base_url()?>assets/select2/dist/js/select2.min.js"></script>
	<script src="<?php echo base_url()?>assets/jquery-validation-1.17.0/dist/jquery.validate.min.js"></script>
	<script src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>


	
	<script src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url()?>assets/datatables-logistik/js/jquery.dataTables.min.js"></script> <!-- Baru Logistik -->
	<script src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/js/dataTables.buttons.min.js"></script> <!-- Lama iclude Logistik -->
	<script src="<?php echo base_url()?>assets/datatables-logistik/js/dataTables.select.min.js"></script> <!-- Baru Logistik -->

	<!-- Baru Logistik -->
	<!-- <script src="<?php echo base_url()?>assets/datatables-logistik/js/dataTables.editor.min.js"></script>  -->



	<script src="<?php echo base_url()?>assets/DataTables/DataTables-1.10.18/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/DataTables/DataTables-1.10.18/js/dataTables.select.js"></script>


	<style>
	body{padding: 20px}
</style>
</head>
<body>