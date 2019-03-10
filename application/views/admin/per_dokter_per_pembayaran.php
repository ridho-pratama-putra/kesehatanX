<div class="container">
	<h3><?=strtoupper($jenis_pembayaran) ?></h3>
	<input type="month" id="bulan-per-pembayaran" value="<?=date('Y-m')?>" onchange="getPasienPerPembayaranPerDokter('<?=$id_dokter?>','<?=$jenis_pembayaran?>')">
	<table id="tabel-per-pembayaran" class="display" style="width:100%">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Assessment</th>
				<th>Planning</th>
				<th>Pembayaran</th>
				<th>Tanggal</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		getPasienPerPembayaranPerDokter('<?=$id_dokter?>','<?=$jenis_pembayaran?>')
	});
	function getPasienPerPembayaranPerDokter(id_dokter,jenis_pembayaran) {
		var urlToController = '';
		var bulan_tahun = $("#bulan-per-pembayaran").val();
		$.get(
			"<?=base_url()?>get-per-dokter-per-pembayaran",
			{
				bulan_tahun : bulan_tahun,
				id_dokter : id_dokter,
				jenis_pembayaran : jenis_pembayaran
			}, ( res ) => {
				res = JSON.parse(res);
				$('#tabel-per-pembayaran').DataTable().destroy();
				$('#tabel-per-pembayaran').DataTable({
					dom : 'Bfrtip',
					data :(res.record),
					columns : 
					[
					{ "data": "nama_pasien" },
					{ "data": "assessment"},
					{ "data": "planning"},
					{ "data": "pembayaran"},
					{ "data": "tanggal_jam"}
					],
					buttons: [
					{
						extend: 'print',
						// orientation: 'landscape',
						text: 'Print all',
						exportOptions: {
							modifier: {
								selected: null
							}
						},
						messageTop: "daftar pasien "+jenis_pembayaran+" periode "+bulan_tahun+" oleh  "+"<?=$nama_dokter[0]->nama?>"
					}],
					columnDefs: [
					{ "width": "10%", "targets": [0,3,4] }
					]
				});
			});
	}
</script>
</script>