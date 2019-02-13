


<div class="text-center mt-3"><h5><strong>Daftar Logistik Bahan Sekali Pakai</strong></h5></div>
<div class="container mt-3">
	<div class="mt-3 mb-3">
		<?=$this->session->flashdata("alert");?>
	</div>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#tambahBahan">
		Tambah Bahan Sekali Pakai
	</button>
	<table id="tabelBahanSekaliPakai" class="display" style="width:100%">
		<thead>
			<tr>
				<!-- <th class="text-center" style="width: 5%">No.</th> -->
				<th>Golongan Bahan</th>
				<th>Nama Bahan</th>
				<th>Sediaan Bahan</th>
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
					<td><?=$value->sediaan?></td>
					<td><?=$value->bentuk?></td>
					<td><?=$value->harga_jual_satuan?></td>
					<td><?=$value->harga_beli_satuan * 5?></td>
					<td><?=$value->stok?></td>
					<td><?=
					($value->harga_jual_satuan !== '0') ?

					number_format((float)(
						$value->harga_jual_satuan
						-
						$value->harga_beli_satuan
					)
					/
					(
						(
							$value->harga_beli_satuan
						)
					) * 100, 2, '.', '')
					: '0'
					?> %</td>
					<td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="<?=base_url()?>logistik-alat-bahan-sekali-pakai-edit/<?=$value->id?>" class="btn btn-primary">Edit</a>
							<a href="<?=base_url()?>logistik-alat-bahan-sekali-pakai-hapus/<?=$value->id?>" class="btn btn-secondary">Delete</a>
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
			$('#tabelBahanSekaliPakai').DataTable( {
				columnDefs: [
				{
					orderable: false,
					targets: [4]
				}
				]
			});
		});
	</script>
</div>

<!-- MODAL ADD GOLONGAN OBAT -->
<div class="modal fade" id="tambahBahan" tabindex="-1" role="dialog" aria-labelledby="tambahBahanLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahBahanLabel">Tambah Bahan Sekali Pakai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url()?>logistik-alat-bahan-sekali-pakai-tambah">
				<div class="modal-body">
					<div class="form-group">
						<label for="tambahBahan">
							<p class="text-warning">
								**Mohon gunakan format capital first letter.
							</p>
							Nama Bahan
						</label>
						<input type="text" class="form-control" id="tambahBahan" placeholder="Contoh : Silk 2/0 + Jarum" name="nama" required="">
					</div>
					<div class="form-group">
						<label for="select-golongan">
							Golongan logistik
						</label>
						<select class="form-control" id="select-golongan" name="golongan" required="" style="width: 100% !important;">
							<option> -- pilih golongan logistik -- </option>
							<?php
							foreach ($golongan_logistik as $key => $value) { ?>
								<option value="<?=$value->id?>"><?=$value->nama_golongan?></option>
							<?php }
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="sediaan">
							Sediaan
						</label>
						<input type="text" class="form-control" id="sediaan" placeholder="Contoh : 125mg/5ml" name="sediaan" required="">
					</div>
					<div class="form-group">
						<label for="provider">
							Provider
						</label>
						<input type="text" class="form-control" id="provider" placeholder="Contoh : IHS Medikom" name="provider" required="">
					</div>
					<div class="form-group">
						<label for="bentuk">
							Bentuk
						</label>
						<input type="text" class="form-control" id="bentuk" placeholder="Contoh : Infus 500ml" name="bentuk" required="">
					</div>
					<div class="form-group">
						<label for="hargaBeliSatuan">
							Harga Beli Satuan
						</label>
						<input type="number" min="0" class="form-control" id="hargaBeliSatuan" placeholder="Contoh : 7500 atau 0 (Negative)" name="harga_beli_satuan" required="">
					</div>
					<div class="form-group">
						<label for="hargaJualSatuan">
							Harga Jual Satuan
						</label>
						<input type="number" min="0" class="form-control" id="hargaJualSatuan" placeholder="Contoh : 11000 atau 0 (Negative)" name="harga_jual_satuan" required="">
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

<!-- autocomlete -->

<script type="text/javascript" src="<?=base_url()?>assets/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js"></script>


<!-- inisialisasi autocomplete -->
<script type="text/javascript">
	$( document ).ready(function() {
		$('#tambahBahan').on('shown.bs.modal', function () {
			$('#tambahBahan').trigger('focus')
		})
		$('#select-golongan').select2({
			dropdownParent: $('#tambahBahan')
		});
		$('#select').select2();
		$.get('<?=base_url()?>autocomplete/golongan_logistik/nama_golongan', function(html){
			respon = JSON.parse(html)
			data = new Array()
			for (var i in respon.data) {
				data.push(respon.data[i].nama_golongan)
			}

			console.log(data)

			$('#tambahBahan').autocomplete({
				lookup: data,
				onSelect: function (suggestion) {
					// $('#tambahBahan').attr('value',suggestion.data)
				}
			})
		})
	});
</script>
<!-- END inisialisasi autocomplete -->
