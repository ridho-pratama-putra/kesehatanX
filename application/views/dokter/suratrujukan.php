<style type="text/css">
table {
	border-collapse: collapse;
	margin: 0 auto;
}
table td {
	border: 1px solid black; 
}
table tr:first-child td {
	border-top: 0;
}
table tr td:first-child {
	border-left: 0;
}
table tr:last-child td {
	border-bottom: 0;
}
table tr td:last-child {
	border-right: 0;
}
</style>
<br>

<div class="container">
	<div class="row">
		<div class="col">
			<div class="row">
				<div class="col-2 offset-1 "> 
					<img class="img-responsive" src="<?=base_url()?>assets/images/LOGO YAYASAN.png" style="width:150px">
				</div>
				<div class="col-8">
					<div>
						<p class="text-success text-center mb-0 font-weight-bold">YAYASAN DARUL'ULUM AGUNG</p>
					</div>
					<div>
						<p class="text-center mb-3 font-weight-bold">PRAKTIK DOKTER UMUM</p>
					</div>
					<div>
						<p class="text-center mb-0 font-weight-bold">Jl. Mayjen Sungkono No 09 Bumiayu Kedungkandang Malang 65135</p>
					</div>
					<div>
						<p class="text-center mb-0 font-weight-bold">Telp. 0341-752866, Fax. 0341-752</p>
					</div>
					<div>
						<p class="text-center mb-0 font-weight-bold">Akte Notaris : H. Romlan, SH, M.Hum. No. 26 Tanggal 19 November 2015</p>
					</div>
				</div>
			</div>

			<hr class="mt-0 mb-0 ">
			<div class="ml-5">
				<div class="row">
					<div class="col mt-4">
						<div class="row">
							<div class="row col-2 ">
								Perihal
							</div>
							<div class= "offset-1">
								:
							</div>	
							<div class="col-9">
								Rujukan Pasien
							</div>
						</div>
						<div class="row">
							<div class="row col-2 ">
								No. Surat
							</div>
							<div class= "offset-1">
								:
							</div>	
							<div class="col-9">
								<?=$nomor_surat?> / 003 / <?=date('0m / Y')?>
							</div>
						</div>
						<div class="row">
							<div class="row col-2 ">
								Lampiran
							</div>
							<div class= "offset-1">
								:
							</div>	
							<div class="col-9">
								..............................................................
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="row">
							Kepada YTH.
						</div>
						<div class="row"">
							Dr.	________________________________________
						</div>
						<div class="row">
							di RS ______________________________________
						</div>
						<div class="row">
							____________________________________________
						</div>
					</div>	
				</div>
				<div class="row mb-4">
					Assalamu'allaikum Wr. Wb.<br>
					Mohon konsul dan penata laksanaan lebih lanjut pada penderita;
				</div>
				<div class="row">
					<div class="col-2"> 
						Nama
					</div>
					<div class="col-0">
						:
					</div>	
					<div class="col-9">
						<?=ucwords($pasien[0]->nama)?>
					</div>		
				</div>
				<div class="row">
					<div class="col-2"> 
						NIK
					</div>
					<div class="col-0">
						:
					</div>	
					<div class="col-9">
						<?=$pasien[0]->nik?>
					</div>		
				</div>
				<div class="row">
					<div class="col-2"> 
						Tempat / Tgl Lahir
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=ucwords($pasien[0]->tempat_lahir).", ".tgl_indo($pasien[0]->tanggal_lahir)?>
					</div>	
				</div>
				<div class="row">
					<div class="col-2"> 
						Jenis Kelamin		
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=ucwords($pasien[0]->jenis_kelamin)?>
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 	
						Pekerjaan					
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=ucwords($pasien[0]->pekerjaan)?>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-2"> 
						Alamat		
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?php
						echo $pasien[0]->jalan." ";
						if ($pasien[0]->kelurahan !== '013 Lain-lain') {
							echo "Kelurahan ".substr($pasien[0]->kelurahan, 3)." ";
						}else{
							if ($pasien[0]->kelurahan_lain !== null) {
								echo "Kelurahan ".$pasien[0]->kelurahan_lain." ";
							}else{
								echo " ";
							}
						}

						if ($pasien[0]->kecamatan !== 'other') {
							echo "Kecamatan ".$pasien[0]->kecamatan." ";
						}else{
							if ($pasien[0]->kecamatan_lain !== null) {
								echo "Kecamatan ".$pasien[0]->kecamatan_lain." ";
							}else{
								echo " ";
							}
						}
						
						if ($pasien[0]->kota !== 'other') {
							echo $pasien[0]->kota." ";
						}else{
							echo $pasien[0]->kota_lain." ";
						}
						?>
					</div>
				</div>
				<div class="row mb-4">
					Hasil Pemeriksaan
					<div class="col-2">
						:
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 
						Keluhan
					</div>
					<div class="col-0">
						:
					</div>	
					<div class="col-9">
						<?=ucwords($data['subjektif'])?>
					</div>		
				</div>
				<div class="row">
					<div class="col-2"> 
						GCS
					</div>
					<div class="col-0">
						:
					</div>	
					<div class="col-9">
						E <?=(strlen($data['gcs_e']) !== 0 ? $data['gcs_e'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> &nbsp;&nbsp;  V <?=(strlen($data['gcs_v']) !== 0 ? $data['gcs_v'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> &nbsp;&nbsp;  M <?=(strlen($data['gcs_m']) !== 0 ? $data['gcs_m'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> &nbsp;&nbsp; 
						( 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("CM", $data['gcs_opsi']) ? "CM" : "<strike>CM</strike>" ) : 'CM')?>, 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("Apatis", $data['gcs_opsi']) ? "Apatis" : "<strike>Apatis</strike>" ) : 'Apatis')?>, 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("Delirium", $data['gcs_opsi']) ? "Delirium" : "<strike>Delirium</strike>" ) : 'Delirium')?>, 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("Somnolen", $data['gcs_opsi']) ? "Somnolen" : "<strike>Somnolen</strike>" ) : 'Somnolen')?>, 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("Stupor", $data['gcs_opsi']) ? "Stupor" : "<strike>Stupor</strike>" ) : 'Stupor')?>, 
						<?= ($data['gcs_opsi'] !== NULL ? (in_array("Coma", $data['gcs_opsi']) ? "Coma" : "<strike>Coma</strike>" ) : 'Coma')?>).*)
					</div>		
				</div>
				<div class="row">
					<div class="col-2"> 
						TB / BB
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=(strlen($data['tinggi_badan']) !== 0 ? $data['tinggi_badan'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> cm / <?=(strlen($data['berat_badan']) !== 0 ? $data['berat_badan'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> kg
					</div>	
				</div>
				<div class="row">
					<div class="col-2"> 
						Tekanan Darah		
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=(strlen($data['sistol']) !== 0 ? $data['sistol'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=$data['diastol']?> mmHg
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 	
						Nadi					
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						<?=(strlen($data['nadi']) !== 0 ? $data['nadi'] : '&nbsp;&nbsp;&nbsp;&nbsp;')?> rpm.
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 
						Head to Toe		
					</div>
					<div class="col-0">
						:
					</div>
				</div>
				<div class="row">
					<div class="col-1 offset-1"> 
						Kepala		
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-9">
						
						Anemis <?=($data['anemis_kiri'] !== NULL  ? ($data['anemis_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=($data['anemis_kanan'] !== NULL  ? ($data['anemis_kanan'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> 
						Ikterik <?=($data['ikterik_kiri'] !== NULL  ? ($data['ikterik_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=($data['ikterik_kanan'] !== NULL  ? ($data['ikterik_kanan'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> 
						Cianosis <?=($data['cianosis_kiri'] !== NULL  ? ($data['cianosis_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=($data['cianosis_kanan'] !== NULL  ? ($data['cianosis_kanan'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> 
						Deformitas <?=($data['deformitas_kiri'] !== NULL  ? ($data['deformitas_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=($data['deformitas_kiri'] !== NULL  ? ($data['deformitas_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> 
						Refleksi cahaya <?=($data['refchy_kiri'] !== NULL  ? ($data['refchy_kiri'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> / <?=($data['refchy_kanan'] !== NULL  ? ($data['refchy_kanan'] = 1 ? "+" : "-") : '&nbsp;&nbsp;&nbsp;&nbsp;')?> 
						<?=($data['refchy_opsi'] !== NULL  ? ($data['refchy_opsi'] == '1' ? 'Isokor / <strike>Anisokor</strike>' : '<strike>Isokor</strike> / Anisokor') : 'Isokor / Anisokor')?>.*)
					</div>
					<div class="col-5 offset-2">
						Keterangan tambahan :  <?=$data['kepala_ket_tambahan']?>
					</div>
				</div>
				<div class="row">
					<div class="col-1 offset-1"> 
						Thorak		
					</div>
					:
					<div class="col-1">
						Paru
					</div>
					:
					<div class="col-3">
						<?=($data['paru_simetris_asimetris'] !== NULL ? ($data['paru_simetris_asimetris'] == 'Simetris' ? 'Simetris / <strike>Asimetris</strike>' : '<strike>Simetris</strike> / Asimetris') : 'Simetris / Asimetris')?>.*)
					</div>
				</div>
				<div class="row">
					<div class="col offset-3">
						Wheezing <?=($data['wheezing_kiri'] !== NULL ? ($data['wheezing_kiri'] == '1' ? '+' : '-' ) : '&nbsp;')?> / <?=($data['wheezing_kanan'] !== NULL ? ($data['wheezing_kanan'] == '1' ? '+' : '-' ) : '&nbsp;')?> Ronkhi <?=($data['ronkhi_kiri'] !== NULL ? ($data['ronkhi_kiri'] == '1' ? '+' : '-' ) : '&nbsp;')?> / <?=($data['ronkhi_kanan'] !== NULL ? ($data['ronkhi_kanan'] == '1' ? '+' : '-' ) : '&nbsp;')?> Vesikuler <?=($data['vesikuler_kiri'] !== NULL ? ($data['vesikuler_kiri'] == '1' ? '+' : '-' ) : '&nbsp;')?> / <?=($data['vesikuler_kanan'] !== NULL ? ($data['vesikuler_kanan'] == '1' ? '+' : '-' ) : '&nbsp;')?>
					</div>
				</div>
				<div class="row">
					&nbsp;
					<div class="col-1 offset-2">
						Jantung
					</div>
					:
					<div class="col-4">
						Ictus cordis <?=($data['jantung_ictuscordis'] !== NULL ? ($data['jantung_ictuscordis'] == 'Tampak' ? 'Tampak / <strike>Tak Tampak</strike>' : '<strike>Tampak</strike> / Tak Tampak') : "Tampak / Tak Tampak")?> .*)
					</div>
				</div>
				<div class="row">
					<div class="col offset-3">
						S1-S2 <?=($data['jantung_s1_s2'] !== NULL ? ($data['jantung_s1_s2'] == 'Reguler' ? 'Reguler / <strike>Irreguler</strike>' : '<strike>Reguler</strike> / Irreguler') : "Reguler / Irreguler")?> .*), 
						Suara tambahan : <?=$data['jantung_suaratambahan']?>
					</div>
				</div>
				<div class="row">
					<div class="col offset-2">
						Keterangan tambahan :  <?=$data['jantung_ket_tambahan']?>
					</div>
				</div>
				<div class="row">
					<div class="col-1 offset-1"> 
						Abdomen		
					</div>
					:
					<div class="col">
						BU <?php

						if ($data['BU'] !== NULL) {
							if($data['BU'] == 'Normal'){ 
								echo "Normal / "; 
								echo "<strike>Meningkat</strike> / ";
								echo "<strike>Menurun</strike> / ";
								echo "<strike>Negatif</strike>";
							} elseif ($data['BU'] == 'Meningkat') {
								echo "<strike>Normal</strike> / ";
								echo "Meningkat / ";
								echo "<strike>Menurun</strike> / ";
								echo "<strike>Negatif</strike>";
							} elseif ($data['BU'] == 'Menurun') {
								echo "<strike>Normal</strike> / ";
								echo "<strike>Meningkat</strike> / ";
								echo "Menurun / ";
								echo "<strike>Negatif</strike>";
							} elseif ($data['BU'] == 'Negatif') { 
								echo "<strike>Normal</strike> / ";
								echo "<strike>Meningkat</strike> / ";
								echo "<strike>Menurun</strike> / ";
								echo "Negatif";
							}
						}else{
							echo "Normal / ";
							echo "Meningkat / ";
							echo "Menurun / ";
							echo "Negatif";
						}
						?> .*)
					</div>
				</div>
				<div class="row">
					&nbsp;
					<div class="col-2 offset-2">
						Nyeri Tekan
					</div>
					<div class="col-1">
						<table >
							<tr>
								<td width="20" height="20"><?=($data['nyeri_tekan1'] == '1') ?  '✓': ' ' ?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan2'] == '1') ?  '✓': '  '?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan3'] == '1') ?  '✓': '  '?></td>
							</tr>
							<tr>
								<td width="20" height="20"><?=($data['nyeri_tekan4'] == '1') ?  '✓': ' ' ?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan5'] == '1') ?  '✓': ' ' ?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan6'] == '1') ?  '✓': ' ' ?></td>
							</tr>
							<tr>
								<td width="20" height="20"><?=($data['nyeri_tekan7'] == '1') ?  '✓': ' ' ?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan8'] == '1') ?  '✓': ' ' ?></td>
								<td width="20" height="20"><?=($data['nyeri_tekan9'] == '1') ?  '✓': ' ' ?></td>
							</tr>
						</table>
					</div>


					<div class="col-4">
						Hepatomegali(<?=(strlen($data['hepatomegali']) !== 0 ? $data['hepatomegali'] : "............................................................")?>), Spleenomegali(<?=(strlen($data['spleenomegali']) !== 0 ? $data['spleenomegali'] : "............................................................")?>)
					</div>
				</div>
				<div class="row">
					<div class="col-5 offset-2">
						Keterangan tambahan : <?=$data['abdomen_ket_tambahan']?>
					</div>
				</div>
				<div class="row">
					<div class="col-1 offset-1"> 
						Ekstermitas		
					</div>
					<div class="col-2">
						: Akral Hangat
					</div>
					
					<table>
						<tr>
							<td width="20" height="20"><?=($data['akral_hangat1'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['akral_hangat2'] == '1') ?  '✓': ' ' ?></td>
						</tr>
						<tr>
							<td width="20" height="20"><?=($data['akral_hangat3'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['akral_hangat4'] == '1') ?  '✓': ' ' ?></td>
						</tr>
					</table>
					;

					<div class="col-1">
						CRT
					</div>
					<table >
						<tr>
							<td width="20" height="20"><?=($data['crt1'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['crt2'] == '1') ?  '✓': ' ' ?></td>
						</tr>
						<tr>
							<td width="20" height="20"><?=($data['crt3'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['crt4'] == '1') ?  '✓': ' ' ?></td>
						</tr>
					</table>
					2 detik;

					<div class="col-1">
						Edema
					</div>
					<table >
						<tr>
							<td width="20" height="20"><?=($data['edema1'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['edema2'] == '1') ?  '✓': ' ' ?></td>
						</tr>
						<tr>
							<td width="20" height="20"><?=($data['edema3'] == '1') ?  '✓': ' ' ?></td>
							<td width="20" height="20"><?=($data['edema4'] == '1') ?  '✓': ' ' ?></td>
						</tr>
					</table>
					<div class="col-3">
						<?=($data['pitting'] ? 'Non-Pitting' : 'Pitting')?>.*
					</div>
				</div>
				<div class="row">
					<div class="col-1 offset-1"> 
						Lain-lain		
					</div>
					:
					<div class="col-4">
						<?=$data['lain_lain']?>
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 
						Diagnosa		
					</div>:
					<div class="col">
						<?php 
						if ($data['diagnosa_primary'] !== NULL) {
							foreach ($data['diagnosa_primary'] as $key => $value ) {
								echo $value." ; ";
							}
						}
						if ($data['diagnosa_secondary']  !== NULL) {
							foreach ($data['diagnosa_secondary'] as $key => $value) {
								echo $value." ; ";
							}
							
						}
						if ($data['diagnosa_lain']  !== NULL) {
							foreach ($data['diagnosa_lain'] as $key => $value) {
								echo $value;
							}
						}
						echo ", ".$data['diagnosa_pemeriksaan_lab'];
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-2"> 
						Terapi		
					</div>
					<div class="col-0">
						:
					</div>
					<div class="col-7">
						R/ <?=$data['terapi1']?>
					</div>
				</div>
				<div class="row">
					&nbsp;
					<div class="col-7 offset-2">
						R/ <?=$data['terapi2']?>
					</div>
				</div>
				<div class="row">
					&nbsp;
					<div class="col-7 offset-2">
						R/ <?=$data['terapi3']?>
					</div>
				</div>

				<div class="row mt-2">
					Demikian atas perhatiannya, diucapkan banyak terima kasih.
				</div>
				<div class="row">
					Wassalamu'allaikum Wr. Wb.
				</div>
				
				<div class="row">
					<div class="col mt-4">
						<div class="row"  style="margin-top: 100px">
							NB : .*) Coret yang tidak perlu.
						</div>
					</div>
					<div class="col-4">
						<div class="row">
							Malang, <?=tgl_indo(date("Y-m-d"))?>
						</div>
						<div class="row" style="margin-bottom: 55px">
							Pemeriksa,
						</div>
						<div class="row mt-5">
							<?=ucwords($nama_user)?>
						</div>
						<div class="row">
							SIP : <?=$sip?>
						</div>
					</div>	
				</div>
			</div>
		</div>	
	</div>
</div>