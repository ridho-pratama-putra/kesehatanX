<div class="container">
	<h2>Jumlah kunjungan pasien</h2>
	<h3 class="text-center">Anak Laki-laki</h3>
	<input type="month" id="bulan-anak-Laki-laki" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('anak','Laki-laki')">
	<table id="tabel-kunjungan-pasien-anak-Laki-laki" class="table">
		<thead>
			<th>nama</th>
			<th>Diagnosa ICD</th>
			<th>Planning</th>
			<th>Tanggal</th>
			<th>Pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<h3 class="text-center">Anak Perempuan</h3>
	<input type="month" id="bulan-anak-Perempuan" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('anak','Perempuan')">
	<table id="tabel-kunjungan-pasien-anak-Perempuan" class="table">
		<thead>
			<th>nama</th>
			<th>Diagnosa ICD</th>
			<th>Planning</th>
			<th>Tanggal</th>
			<th>Pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<hr style="border-bottom: 1px solid red">
	<h3 class="text-center">Dewasa Laki-laki</h3>
	<input type="month" id="bulan-dewasa-Laki-laki" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('dewasa','Laki-laki')">
	<table id="tabel-kunjungan-pasien-dewasa-Laki-laki" class="table">
		<thead>
			<th>Nama</th>
			<th>Diagnosa ICD</th>
			<th>Planning</th>
			<th>Tanggal</th>
			<th>Pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<h3 class="text-center">Dewasa Perempuan</h3>
	<input type="month" id="bulan-dewasa-Perempuan" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('dewasa','Perempuan')">
	<table id="tabel-kunjungan-pasien-dewasa-Perempuan" class="table">
		<thead>
			<th>Nama</th>
			<th>Diagnosa ICD</th>
			<th>Planning</th>
			<th>Tanggal</th>
			<th>Pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<hr style="border-bottom: 1px solid red">
	<h3 class="text-center">Lansia Laki-laki</h3>
	<input type="month" id="bulan-lansia-Laki-laki" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('lansia','Laki-laki')">
	<table id="tabel-kunjungan-pasien-lansia-Laki-laki" class="table">
		<thead>
			<th>Nama</th>
			<th>Diagnosa ICD</th>
			<th>Planning</th>
			<th>tanggal</th>
			<th>pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>
	<h3 class="text-center">Lansia Perempuan</h3>
	<input type="month" id="bulan-lansia-Perempuan" value="<?=date('Y-m')?>" onchange="getPasienPerUsia('lansia','Perempuan')">
	<table id="tabel-kunjungan-pasien-lansia-Perempuan" class="table">
		<thead>
			<th>Nama</th>
			<th>diagnosa</th>
			<th>tanggal</th>
			<th>pembayaran</th>
		</thead>
		<tbody>

		</tbody>
	</table>

	
</div>

<script type="text/javascript">
	$(document).ready(function() {
		getPasienPerUsia('anak','Laki-laki')
		getPasienPerUsia('anak','Perempuan')
		getPasienPerUsia('dewasa','Laki-laki')
		getPasienPerUsia('dewasa','Perempuan')
		getPasienPerUsia('lansia','Laki-laki')
		getPasienPerUsia('lansia','Perempuan')
	});
	function getPasienPerUsia(jenis_usia,jenis_kelamin) {
		var urlToController = '';
		var bulan_tahun = $("#bulan-"+jenis_usia+'-'+jenis_kelamin).val();
		$.get(
			"<?=base_url()?>get-pasien-per-usia-per-bulan",
			{
				bulan_tahun : bulan_tahun,
				jenis_usia : jenis_usia,
				jenis_kelamin : jenis_kelamin
			}, ( res ) => {
				res = JSON.parse(res);
				$('#tabel-kunjungan-pasien-'+jenis_usia+'-'+jenis_kelamin).DataTable().destroy();
				$('#tabel-kunjungan-pasien-'+jenis_usia+'-'+jenis_kelamin).DataTable({
					dom : 'Bfrtip',
					data :(res.record),
					columns : 
					[
					{ "data": "nama" },
					{ "data": "assessment"},
					{ "data": "planning"},
					{ "data": "tanggal_jam"},
					{ "data": "pembayaran"}
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
						messageTop: "daftar pasien "+jenis_usia+" "+jenis_kelamin+" periode "+bulan_tahun
					}],
					columnDefs: [
					{ "width": "10%", "targets": [0,3,4] }
					]
				});
			});
	}
</script>