<div class="container mt-3">
	<div class="mt-3 mb-3">
		<?=$this->session->flashdata("alert");?>
	</div>
	<table class="table-bordered mb-3">
		<thead>
			<th>nama</th>
			<th>golongan</th>
			<th>bentuk</th>
			<th>sediaan</th>
			<th>harga beli satuan</th>
			<th>harga jual satuan</th>
			<th>stok sekarang</th>
		</thead>
		<tbody>
			<tr>
				<td><?=$record[0]->nama?></td>
				<td><?=$record[0]->nama_golongan?></td>
				<td><?=$record[0]->bentuk?></td>
				<td><?=$record[0]->sediaan?></td>
				<td><?=$record[0]->harga_beli_satuan?></td>
				<td><?=$record[0]->harga_jual_satuan?></td>
				<td><?=$record[0]->stok?></td>
			</tr>
		</tbody>
	</table>
	<form action="<?=base_url()?>submit-restok" method="POST">
		<fieldset class="form-group">
			<label for="">Stok yang masuk sejumlah</label>
			<input type="hidden" class="form-control" name="jenis_logistik" value="<?=$jenis_logistik?>" readonly="">
			<input type="hidden" class="form-control" name="id" value="<?=$record[0]->id?>" readonly="">
			<input type="number" class="form-control" name="stok_masuk">
		</fieldset>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>