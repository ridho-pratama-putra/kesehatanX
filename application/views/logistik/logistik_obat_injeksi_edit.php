


<form method="POST" action="<?=base_url()?>logistik-obat-injeksi-submit-edit">
	<div class="container mt-3">
		<div class="mt-3 mb-3">
			<?=$this->session->flashdata("alert");?>
		</div>
	</div>
	<div class="container mt-3">
		<div class="form-group">
			<label for="idLogistik">
				<p class="text-warning">
					**Mohon gunakan format capital first letter.
				</p>
				ID Bahan
			</label>
			<input type="text" class="form-control" id="idLogistik" name="id" value="<?=$record[0]->id?>" readonly="">
		</div>
		<div class="form-group">
			<label>
				Nama Bahan
			</label>
			<input type="text" class="form-control" placeholder="Contoh : Silk 2/0 + Jarum" name="nama" value="<?=$record[0]->nama?>" required="">
		</div>
		<div class="form-group">
			<label for="select-golongan">
				Golongan logistik
			</label>
			<select class="form-control" id="select-golongan" name="golongan" required="" style="width: 100% !important;">
				<option> -- pilih golongan logistik -- </option>
				<?php
				foreach ($golongan_logistik as $key => $value) { ?>
					<option value="<?=$value->id?>" <?=($record[0]->golongan == $value->id) ? "selected" : ""?> ><?=$value->nama_golongan?></option>
				<?php }
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="sediaan">
				Sediaan
			</label>
			<input type="text" class="form-control" id="sediaan" placeholder="Contoh : 125mg/5ml" name="sediaan" value="<?=$record[0]->sediaan?>" required="">
		</div>
		<div class="form-group">
			<label for="bentuk">
				Bentuk
			</label>
			<input type="text" class="form-control" id="bentuk" placeholder="Contoh : Infus 500ml" name="bentuk" value="<?=$record[0]->bentuk?>" required="">
		</div>
		<div class="form-group">
			<label for="hargaBeliSatuan">
				Harga Beli Satuan
			</label>
			<input type="number" min="0" class="form-control" id="hargaBeliSatuan" placeholder="Contoh : 7500 atau 0 (Negative)" name="harga_beli_satuan" value="<?=$record[0]->harga_beli_satuan?>" required="">
		</div>
		<div class="form-group">
			<label for="hargaJualSatuan">
				Harga Jual Satuan
			</label>
			<input type="number" min="0" class="form-control" id="hargaJualSatuan" placeholder="Contoh : 11000 atau 0 (Negative)" name="harga_jual_satuan" value="<?=$record[0]->harga_jual_satuan?>" required="">
		</div>
		<!-- <div class="form-group">
			<label for="stok">
				Stok
			</label>
			<input type="number" min="0" class="form-control" id="stok" placeholder="Contoh : 75 atau 0 (Negative)" name="stok" value="<?=$record[0]->stok?>" required="">
		</div> -->
	</div>
	<div class="container">
		<a href="<?=base_url()?>logistik-alat-bahan-sekali-pakai" class="btn btn-secondary">Kembali</a>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
</form>