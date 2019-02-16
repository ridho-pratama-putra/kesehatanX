
<h3 class="text-center mt-3">Pemeriksaan Awal Pasien</h3>

<form action="<?=base_url()."submit-pemeriksaan-awal"?>" method="POST">
	<div class="container">
		<?=$this->session->flashdata("alert");?>
		<div class="row">
			<div class="col-8">
				<div class="form-group row">
					<label class="col-2 col-form-label">ID Pasien</label>
					<div class="input-group col-10">
						<input type="text" class="form-control" id="" name="id_pasien" readonly="" value="<?=$pasien[0]->id?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Nomor Pasien</label>
					<div class="input-group col-10">
						<input type="text" class="form-control" id="" name="nomor_pasien" placeholder="Nomor Pasien" readonly="" value="<?=$pasien[0]->nomor_pasien?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Tinggi Badan</label>
					<div class="input-group col-10">
						<input type="number" class="form-control" id="" name="tinggi_badan" placeholder="Tinggi Badan" autofocus="">
						<div class="input-group-append">
							<div class="input-group-text">cm</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-2 col-form-label">Berat Badan</label>
					<div class="input-group col-10">
						<input type="number" class="form-control" id="" name="berat_badan" placeholder="Berat Badan">
						<div class="input-group-append">
							<div class="input-group-text">Kg</div>
						</div>
					</div>
				</div>
				<?php if ($pasien[0]->pembayaran == 'RF') { ?>
					<div class="row">
						<div class="col">
							<div class="form-group row">
								<label class="col-2 col-form-label">Sistol/Diastol</label>
								<div class="input-group col">
									<input type="number" class="form-control" id="" name="sistol" placeholder="Sistol" >
									<div class="input-group-append">
										<div class="input-group-text">mmHg</div>
									</div>
								</div>
								<div class="input-group col">
									<input type="number" class="form-control" id="" name="diastol" placeholder="Diastol">
									<div class="input-group-append">
										<div class="input-group-text">mmHg</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<div class="form-group row">
					<label class="col-2 col-form-label">Denyut Nadi</label>
					<div class="input-group col-10">
						<input type="number" class="form-control" id="" name="denyut_nadi" placeholder="Denyut Nadi">
						<div class="input-group-append">
							<div class="input-group-text">rpm</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-2 col-form-label">Frekuensi Pernapasan</label>
					<div class="input-group col-10">
						<input type="number" class="form-control" id="" name="frekuensi_pernapasan" placeholder="Respiration Rate">
						<div class="input-group-append">
							<div class="input-group-text">rpm</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-2 col-form-label">Suhu</label>
					<div class="input-group col-10">
						<input type="number" class="form-control" id="" name="suhu" placeholder="Temperature Axilla">
						<div class="input-group-append">
							<div class="input-group-text">°C</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				</div>  
			</div>  
			<div class="col-4 border rounded">
				<div class="row mt-2">
					<div class="col-4">
						Nama 
					</div>
					<div class="col-1">
						:
					</div>
					<div class="col-7">
						<?=$pasien[0]->nama?> 
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-4">
						NIK 
					</div>
					<div class="col-1">
						:
					</div>
					<div class="col-7">
						<?=$pasien[0]->nik?>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-4">
						Pembayaran 
					</div>
					<div class="col-1">
						:
					</div>
					<div class="col-7">
						<?=$pasien[0]->pembayaran?>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-4">
						Pekerjaan  
					</div>
					<div class="col-1">
						:
					</div>
					<div class="col-7">
						<?=$pasien[0]->pekerjaan?>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-4">
						Usia  
					</div>
					<div class="col-1">
						:
					</div>
					<div class="col-7">
						<?=$pasien[0]->usia?> Tahun
					</div>
				</div>
				<?php
				if ($pasien[0]->nama_ayah !== '' OR $pasien[0]->nama_ibu !== '') { ?>
					<div class="row mt-2">
						<div class="col-4">
							Nama Ayah / Ibu
						</div>
						<div class="col-1">
							:
						</div>
						<div class="col-7">
							<?php if ($pasien[0]->nama_ayah !== '') { ?>
								Tn <?=$pasien[0]->nama_ayah?>
								<?php if ($pasien[0]->nama_ibu !== '') { echo " / "; } }
								if ($pasien[0]->nama_ibu !== '') { ?>
									Ny <?=$pasien[0]->nama_ibu?>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="row mt-2">
						<div class="col-4">
							TTL
						</div>
						<div class="col-1">
							:
						</div>
						<div class="col-7">
							<?=$pasien[0]->tempat_lahir?>, <?=tgl_indo($pasien[0]->tanggal_lahir)?>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4">
							Alamat  
						</div>
						<div class="col-1">
							:
						</div>
						<div class="col-7">
							<?=ucwords("Jalan ".$pasien[0]->jalan." ".($pasien[0]->kelurahan == '013 Lain-lain' ? "Kelurahan ".$pasien[0]->kelurahan_lain : ($pasien[0]->kelurahan !== "" ? "Kelurahan ".$pasien[0]->kelurahan."X" : ""))." ".($pasien[0]->kecamatan == 'other' ? "Kecamatan ".$pasien[0]->kecamatan_lain : "Kecamatan ".$pasien[0]->kecamatan)." ".($pasien[0]->kota == 'other' ? $pasien[0]->kota_lain : $pasien[0]->kota))?>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</form>	