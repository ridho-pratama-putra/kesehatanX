


<div class="text-center mt-3"><h5><strong>Daftar Logistik Obat Sigma Usus Externum</strong></h5></div>
<div class="container mt-3">
	<div class="mt-3 mb-3">
		<?=$this->session->flashdata("alert");?>
	</div>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#tambahObat">
		Tambah Obat SUE
	</button>
	<a href="<?=base_url()?>log-logistik/obat_sigma_usus_externum" class="btn btn-primary mt-3 mb-3" >
		Lihat log logistik Obat SUE
	</a>
	<table id="tabel" class="display" style="width:100%">
		<thead>
			<tr>
				<!-- <th class="text-center" style="width: 5%">No.</th> -->
				<th>Golongan</th>
				<th>Nama Obat</th>
				<th>Presentase</th>
				<th>Sediaan Obat</th>
				<th>Bentuk</th>
				<th>Harga Beli satuan</th>
				<th>Harga Jual satuan</th>
				<th>Stok</th>
				<th>Presentase</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// $i = 1;
			foreach($record as $key => $value) {
				?>
				<tr>
					<!-- <td class="text-center"><?=$i?></td> -->
					<td><?=$value->nama_golongan?></td>
					<td><?=$value->nama?></td>
					<td><?=$value->presentase?></td>
					<td><?=$value->sediaan?></td>
					<td><?=$value->bentuk?></td>
					<td><?=$value->harga_beli_satuan?></td>
					<td><?=$value->harga_jual_satuan?></td>
					<td><?=$value->stok?></td>
					<td><?=
					($value->harga_jual_satuan !== '0' && $value->harga_beli_satuan !== '0') ?
					number_format((float)(($value->harga_jual_satuan - $value->harga_beli_satuan)/($value->harga_beli_satuan))*100, 2, '.', '')
					: '0'
					?> %</td>
					<td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="<?=base_url()?>logistik-obat-sigma-usus-externum-edit/<?=$value->id?>" class="btn btn-primary">Edit</a>
							<a href="<?=base_url()?>logistik-obat-sigma-usus-externum-restok/<?=$value->id?>" class="btn btn-info">Restok</a>
							<a href="<?=base_url()?>logistik-obat-sigma-usus-externum-hapus/<?=$value->id?>" class="btn btn-secondary">Delete</a>
						</div>
					</td>
				</tr>
				<?php 
				// $i++; 
			} ?>
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tabel').DataTable( {
				dom: 'Bfrtip',
				columnDefs: [
				{
					orderable: false,
					targets: []
				}
				],
				buttons: [
				{
					extend : 'print',
					exportOptions: {
						columns: [ 0,1,2,3,4,5,6,7 ]
					}
				}
				],
			});
			$('#tambahObat').on('shown.bs.modal', function () {
				$('#tambahNamaObat').trigger('focus')
			})
			$('#select-golongan').select2({
				dropdownParent: $('#tambahObat')
			});
			$('#select').select2();
		});
	</script>
</div>

<!-- MODAL ADD GOLONGAN OBAT -->
<div class="modal fade" id="tambahObat" tabindex="-1" role="dialog" aria-labelledby="tambahObatLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahObatLabel">Tambah Obat Injeksi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url()?>logistik-obat-sigma-usus-externum-tambah">
				<div class="modal-body">
					<div class="form-group">
						<label for="tambahNamaObat">
							<p class="text-warning">
								**Mohon gunakan format capital first letter.
							</p>
							Nama obat
						</label>
						<input type="text" class="form-control" id="tambahNamaObat" placeholder="Contoh : Cefadroxil" name="nama" required="">
					</div>
					<div class="form-group">
						<label for="select-golongan">
							Golongan obat
						</label>
						<select class="form-control" id="select-golongan" name="golongan" required="" style="width: 100%;">
							<option> -- pilih golongan obat -- </option>
							<?php
							foreach ($golongan_logistik as $key => $value) { ?>
								<option value="<?=$value->id?>"><?=$value->nama_golongan?></option>
							<?php }
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="presentaseObat">
							Presentase Obat
						</label>
						<input type="text" class="form-control" id="presentaseObat" placeholder="Contoh : 0,5 %" name="presentase" required="">
					</div>
					<div class="form-group">
						<label for="sediaanObat">
							Sediaan Obat
						</label>
						<input type="text" class="form-control" id="sediaanObat" placeholder="Contoh : 125mg/5ml" name="sediaan" required="">
					</div>
					<div class="form-group">
						<label for="bentukObat">
							Bentuk Obat
						</label>
						<input type="text" class="form-control" id="bentukObat" placeholder="Contoh : Syrup 60ml" name="bentuk" required="">
					</div>
					<div class="form-group">
						<label for="hargaBeliSatuanObat">
							Harga Beli Satuan
						</label>
						<input type="number" min="0" class="form-control" id="hargaBeliSatuanObat" placeholder="Contoh : 11000 atau 0 (Negative)" name="harga_beli_satuan" required="">
					</div>
					<div class="form-group">
						<label for="hargaJualSatuanObat">
							Harga Jual Satuan
						</label>
						<input type="number" min="0" class="form-control" id="hargaJualSatuanObat" placeholder="Contoh : 11000 atau 0 (Negative)" name="harga_jual_satuan" required="">
					</div>
					<div class="form-group">
						<label for="stok">
							Stok
						</label>
						<input type="number" min="0" class="form-control" id="stok" placeholder="Contoh : 75 atau 0 (Negative)" name="stok" required="">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- MODAL ADD GOLONGAN OBAT -->