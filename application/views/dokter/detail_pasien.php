<div class="mt-3" style="width: 90%; margin-left: 5% ">
	<table id="tabel-rekam-medis" class="display" style="width:100%">
		<thead>
			<tr> 
				<th>Tanggal Periksa</th>
				<th>Subjektif</th>
				<th>Objektif</th>
				<th>Assessment</th>
				<th>Planning</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($rekam_medis as $key => $value) { ?>
				<tr>
					<td><?=tgl_indo(substr($value->tanggal_jam, 0,10))." ".substr($value->tanggal_jam,11)?></td>
					<td><?=$value->subjektif?></td>
					<td><?php
						// harus dipissahkan titik
					echo "TB/BB : ".($value->tinggi_badan !== NULL ? $value->tinggi_badan : '..')."cm / ".($value->berat_badan !== NULL ? $value->berat_badan : '..')."kg  ";
					echo "Nadi : ".($value->nadi !== NULL ? $value->nadi : '..')."rpm  ";
					echo "RR : ".($value->respiratory_rate !== NULL ? $value->respiratory_rate : '..')."rpm  ";
					echo "T Ax : ".($value->temperature_ax !== NULL ? $value->temperature_ax : '..')."C  ";
					echo "Head to toe : ".($value->headtotoe !== NULL ? $value->headtotoe : '');

					echo ($value->gcs_evm_opsi !== NULL || $value->kepala !== NULL || $value->kepala_isokor_anisokor !== NULL || $value->kepala_ket_tambahan !== NULL ? "<br>Kepala " : '');
					echo ($value->gcs_evm_opsi !== NULL ? "GCS ".$value->gcs_evm_opsi."  " : '');
					echo ($value->kepala !== NULL ? $value->kepala."  " : '');
					echo ($value->kepala_isokor_anisokor !== NULL ? $value->kepala_isokor_anisokor."  " : '');
					echo ($value->kepala_ket_tambahan !== NULL ? "Keterangan tambahan kepala: ".$value->kepala_ket_tambahan."  " : '');

					echo ($value->paru_simetris_asimetris !== NULL || $value->paru !== NULL ? "<br>Paru " : '');
					echo ($value->paru_simetris_asimetris !== NULL ? $value->paru_simetris_asimetris."  " : '');
					echo ($value->paru !== NULL ? $value->paru."  " : '');

					echo ($value->jantung_ictuscordis !== NULL || $value->jantung_s1_s2 !== NULL || $value->jantung_suaratambahan !== NULL? "<br>Thorak " : '');
					echo ($value->jantung_ictuscordis !== NULL ? $value->jantung_ictuscordis."  " : '');
					echo ($value->jantung_s1_s2 !== NULL ? $value->jantung_s1_s2."  " : '');
					echo ($value->jantung_suaratambahan !== NULL ? "Keterangan suara tambahan : ".$value->jantung_suaratambahan."  " : '');
					echo ($value->thorak_ket_tambahan !== NULL ? "Keterangan tambahan thorak : ".$value->thorak_ket_tambahan."  " : '');

					echo ($value->abdomen_BU !== NULL || $value->nyeri_tekan1 !== NULL || $value->nyeri_tekan2 !== NULL || $value->nyeri_tekan3 !== NULL || $value->nyeri_tekan4 !== NULL || $value->nyeri_tekan5 !== NULL || $value->nyeri_tekan6 !== NULL || $value->nyeri_tekan7 !== NULL || $value->nyeri_tekan8 !== NULL || $value->nyeri_tekan9 !== NULL || $value->hepatomegali !== NULL || $value->spleenomegali !== NULL || $value->abdomen_ket_tambahan !== NULL? "<br>Abdomen " : '');
					echo ($value->abdomen_BU !== NULL ? "BU: ".$value->abdomen_BU."  " : '');
					echo ($value->nyeri_tekan1 !== NULL || $value->nyeri_tekan2 !== NULL || $value->nyeri_tekan3 !== NULL || $value->nyeri_tekan4 !== NULL || $value->nyeri_tekan5 !== NULL || $value->nyeri_tekan6 !== NULL || $value->nyeri_tekan7 !== NULL || $value->nyeri_tekan8 !== NULL || $value->nyeri_tekan9 !== NULL ? "Nyeri tekan :" : '');
					echo ($value->nyeri_tekan1 !== NULL ? " 1 " : '');
					echo ($value->nyeri_tekan2 !== NULL ? " 2 " : '');
					echo ($value->nyeri_tekan3 !== NULL ? " 3 " : '');
					echo ($value->nyeri_tekan4 !== NULL ? " 4 " : '');
					echo ($value->nyeri_tekan5 !== NULL ? " 5 " : '');
					echo ($value->nyeri_tekan6 !== NULL ? " 6 " : '');
					echo ($value->nyeri_tekan7 !== NULL ? " 7 " : '');
					echo ($value->nyeri_tekan8 !== NULL ? " 8 " : '');
					echo ($value->nyeri_tekan9 !== NULL ? " 9 " : '');
					echo ($value->hepatomegali !== NULL ? " Hepatomegali : ".$value->hepatomegali : '');
					echo ($value->spleenomegali !== NULL ? " Spleenomegali : ".$value->spleenomegali : '');
					echo ($value->abdomen_ket_tambahan !== NULL ? " Keterangan tambahan abdomen : ".$value->abdomen_ket_tambahan : '');

					echo ($value->akral_hangat1 !== NULL || $value->akral_hangat2 !== NULL || $value->akral_hangat3 !== NULL || $value->akral_hangat4 !== NULL || $value->crt_1 !== NULL || $value->crt_2 !== NULL || $value->crt_2 !== NULL || $value->crt_3 !== NULL || $value->crt_4 !== NULL || $value->edema_1 !== NULL || $value->edema_2 !== NULL || $value->edema_3 !== NULL || $value->edema_4 !== NULL? "<br>Ekstermitas " : '');
					echo ($value->akral_hangat1 !== NULL || $value->akral_hangat2 !== NULL || $value->akral_hangat3 !== NULL || $value->akral_hangat4 !== NULL ? "Akral hangat: " : '');
					echo ($value->akral_hangat1 !== NULL ? " 1 " : '');
					echo ($value->akral_hangat2 !== NULL ? " 2 " : '');
					echo ($value->akral_hangat3 !== NULL ? " 3 " : '');
					echo ($value->akral_hangat4 !== NULL ? " 4 " : '');

					echo ($value->crt_1 !== NULL || $value->crt_2 !== NULL || $value->crt_2 !== NULL || $value->crt_3 !== NULL || $value->crt_4 !== NULL ? "CRT : " : '');
					echo ($value->crt_1 !== NULL ? " 1 " : '');
					echo ($value->crt_2 !== NULL ? " 2 " : '');
					echo ($value->crt_3 !== NULL ? " 3 " : '');
					echo ($value->crt_4 !== NULL ? " 4 " : '');

					echo ($value->edema_1 !== NULL || $value->edema_2 !== NULL || $value->edema_2 !== NULL || $value->edema_3 !== NULL || $value->edema_4 !== NULL ? "Edema : " : '');
					echo ($value->edema_1 !== NULL ? " 1 " : '');
					echo ($value->edema_2 !== NULL ? " 2 " : '');
					echo ($value->edema_3 !== NULL ? " 3 " : '');
					echo ($value->edema_4 !== NULL ? " 4 " : '');
					echo $value->pitting_nonpitting;
					echo ($value->ekstermitas_ket_tambahan !== NULL ? " Keterangan tambahan ekstermitas : ".$value->ekstermitas_ket_tambahan : '');
					echo ($value->lain_lain !== NULL ? " <br>Lain-lain : ".$value->lain_lain : '');

					echo ($value->terapi_1 !== NULL ? "<br>Terapi 1 : ".$value->terapi_1 : '');
					echo ($value->terapi_2 !== NULL ? "<br>Terapi 2 : ".$value->terapi_2 : '');
					echo ($value->terapi_3 !== NULL ? "<br>Terapi 3 : ".$value->terapi_3 : '');

					echo ($value->planning !== NULL ? "<br>Planning : ".$value->planning : '');
					?></td>
					<td><?php
					echo $value->kelompok;
					?></td>
					<td><?=$value->planning?></td>
				</tr>
			<?php }
			?>
		</tbody>
	</table>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// inisialisasi tabel rekam medis pada tab rekam medis
		$("#tabel-rekam-medis").DataTable({
			stateSave: true,
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'pdf',
				orientation: 'landscape',
				text: 'Print all',
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
</script>