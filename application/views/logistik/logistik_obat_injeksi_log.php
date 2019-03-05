<div class="container mt-3">
	<input type="month" name="bulan_tahun" id="bulan-tahun" value="<?=date('Y-m')?>">
	<button type="submit" onclick="getLogData()">submit</button>	
	<table id="tabel-log" class="display" style="width:100%">
		<thead>
			<tr>
				<th>tanggal</th>
				<th>nama</th>
				<th>Sediaan</th>
				<th>Bentuk</th>
				<th>Stok masuk</th>
				<th>Stok keluar</th>
				<th>Stok sekarang</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

</div>

<script type="text/javascript" src="<?=base_url()?>assets/datatables/datatables-1.10.18/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/datatables/datatables-1.10.18/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/datatables/datatables-1.10.18/js/buttons.html5.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable();
		getLogData();
	});
	function getLogData() {
		var bulan_tahun = $("#bulan-tahun").val();
		$.get(
			"<?=base_url()?>get-log-logistik-obat-injeksi",
			{
				bulan_tahun : bulan_tahun
			}, ( res ) => {
				res = JSON.parse(res);
				$('#tabel-log').DataTable().destroy();
				$('#tabel-log').DataTable({
					dom : 'Bfrtip',
					data :(res.record),
					columns : 
					[
					{ "data": "datetime_last" },
					{ "data": "nama" },
					{ "data": "sediaan" },
					{ "data": "bentuk" },
					{ "data": "stok_masuk" },
					{ "data": "stok_keluar" },
					{ "data": "stok_sekarang"}
					],
					buttons: [
					{
						extend: 'pdf',
						// orientation: 'landscape',
						text: 'Print all',
						exportOptions: {
							modifier: {
								selected: null
							},
							columns: [0,1,2,3,4,5,6]
						},
						messageTop: bulan_tahun
					}]
				});
		});
	}
</script>