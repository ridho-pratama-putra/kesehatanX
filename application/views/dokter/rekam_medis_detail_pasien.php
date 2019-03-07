<div class="mt-3" style="width: 90%; margin-left: 5% ">
	<input type="hidden" class="form-control" name="id_pasien" id="id-pasien" value="<?=$pasien[0]->id?>" readonly="">
	<input type="month" class="form-control" name="bulan_tahun" id="bulan-tahun" value="<?=date('Y-m')?>">
	<button type="submit" onclick="getRekamMedisByMonth()">submit</button>	
	<table id="tabel-rekam-medis" class="display" style="width:100%">
		<thead>
			<tr> 
				<th>Tanggal Periksa</th>
				<th>Dokter pemeriksa</th>
				<th>Subjektif</th>
				<th>Objektif</th>
				<th>Assessment</th>
				<th>Planning</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		getRekamMedisByMonth();
	});
	function getRekamMedisByMonth() {
		var bulan_tahun = $("#bulan-tahun").val();
		var id_pasien = $("#id-pasien").val();
		$.get(
			"<?=base_url()?>get-detail-rekam-medis-pasien-by-month-year/",
			{
				bulan_tahun : bulan_tahun,
				id_pasien : id_pasien
			}, ( res ) => {
				res = JSON.parse(res);
				$('#tabel-rekam-medis').DataTable().destroy();
				$("#tabel-rekam-medis").DataTable({
					stateSave: true,
					dom: 'Bfrtip',
					data :(res.record),
					columns : 
					[
					{ "data": "tanggal" },
					{ "data": "oleh_dokter" },
					{ "data": "subjektif" },
					{ "data": "objektif" },
					{ "data": "assessment" },
					{ "data": "planning" },
					],
					buttons: [
					{
						extend: 'pdf',
						orientation: 'landscape',
						text: 'Print',
						exportOptions: {
							modifier: {
								selected: null
							},
							columns: [0,1,2,3,4]
						},
						messageTop: 
						"Rekam medis bulan \t\t: <?=date('F')?>\nNama \t\t\t\t\t\t\t\t: <?=$pasien[0]->nama?> \n Nomor pasien \t\t\t\t  : <?=$pasien[0]->nomor_pasien?> \n Alamat \t\t\t\t\t\t\t  : <?=$pasien[0]->jalan?> \nNIK \t\t\t\t\t\t\t\t\t : <?=$pasien[0]->nik?> \n Jenis kelamin \t\t\t\t  : <?=$pasien[0]->jenis_kelamin?> \nTempat tanggal lahir \t  : <?=$pasien[0]->tempat_lahir?>, <?=tgl_indo($pasien[0]->tanggal_lahir)?> \n Nama Ibu/Ayah \t\t\t   : <?=($pasien[0]->nama_ibu !== NULL ? $pasien[0]->nama_ibu : '...')?> / <?=($pasien[0]->nama_ayah !== NULL ? $pasien[0]->nama_ayah : '...')?>",
					}
					],
					columnDefs: [ 
					{ 
						orderable: false, 
						targets: [1,2,3,4] 
					} 
					],
					select: true
				});
			} );
	}
</script>