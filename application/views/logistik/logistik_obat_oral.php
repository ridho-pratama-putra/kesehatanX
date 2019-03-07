


<div class="text-center mt-3"><h5><strong>Daftar Logistik Obat Oral</strong></h5></div>
<div class="container mt-3">
	<div class="mt-3 mb-3">
		<?=$this->session->flashdata("alert");?>
	</div>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#tambahObat">
		Tambah Obat Oral
	</button>

	<a href="<?=base_url()?>log-logistik/obat_oral" class="btn btn-primary mt-3 mb-3" >
		Lihat log logistik Obat Oral
	</a>
	<table id="tabelObatOral" class="display" style="width:100%">
		<thead>
			<tr>
				<!-- <th class="text-center" style="width: 5%">No.</th> -->
				<th>Golongan Obat</th>
				<th>Nama Obat</th>
				<th>Sediaan Obat</th>
				<th>Bentuk</th>
				<th>Harga Beli satuan</th>
				<th>Harga Jual satuan</th>
				<th>Harga Jual per strip (10)</th>
				<th>Harga Jual per 1/2 strip (5)</th>
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
					<td><?=($value->satuan_per_box !== '0') ? $value->harga_beli_per_box/$value->satuan_per_box : '0'?></td>
					<td><?=$value->harga_jual_satuan?></td>
					<td><?=$value->harga_jual_satuan * 10?></td>
					<td><?=$value->harga_jual_satuan * 5?></td>
					<td><?=$value->stok?></td>
					<td><?=
					($value->satuan_per_box !== '0') ?

					number_format((float)(
						$value->harga_jual_satuan
						-
						(
							$value->harga_beli_per_box/$value->satuan_per_box
						)
					)
					/
					(
						(
							$value->harga_beli_per_box/$value->satuan_per_box
						)
					) * 100, 2, '.', '')
					: '0'
					?> %</td>
					<td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="<?=base_url()?>logistik-obat-oral-edit/<?=$value->id?>" class="btn btn-primary">Edit</a>
							<a href="<?=base_url()?>logistik-obat-oral-restok/<?=$value->id?>" class="btn btn-info">Restok</a>
							<a href="<?=base_url()?>logistik-obat-oral-hapus/<?=$value->id?>" class="btn btn-secondary">Delete</a>
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
			$('#tabelObatOral').DataTable( {
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
						columns: [ 0,1,2,3,4,5,6,7,8,9 ]
					}
				}
				]
			});
		});
	</script>
</div>

<!-- MODAL ADD GOLONGAN OBAT -->
<div class="modal fade" id="tambahObat" tabindex="-1" role="dialog" aria-labelledby="tambahObatLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahObatLabel">Tambah Obat Oral</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url()?>logistik-obat-oral-tambah">
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
						<select class="form-control" id="select-golongan" name="golongan" required="" style="width: 100% !important;">
							<option> -- pilih golongan obat -- </option>
							<?php
							foreach ($golongan_logistik as $key => $value) { ?>
								<option value="<?=$value->id?>"><?=$value->nama_golongan?></option>
							<?php }
							?>
						</select>
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
						<label for="satuanPerBoxObat">
							Satuan per Box
						</label>
						<input type="number" min="0" class="form-control" id="satuanPerBoxObat" placeholder="Contoh : 100 atau 0 (Negative)" name="satuan_per_box" required="">
					</div>
					<div class="form-group">
						<label for="hargaBeliPerBoxObat">
							Harga Beli per Box
						</label>
						<input type="number" min="0" class="form-control" id="hargaBeliPerBoxObat" placeholder="Contoh : 7500 atau 0 (Negative)" name="harga_beli_per_box" required="">
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

<!-- autocomlete -->

<script type="text/javascript" src="<?=base_url()?>assets/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js"></script>


<!-- inisialisasi autocomplete -->
<script type="text/javascript">
	$( document ).ready(function() {
		$('#tambahObat').on('shown.bs.modal', function () {
			$('#tambahNamaObat').trigger('focus')
		})
		$('#select-golongan').select2({
			dropdownParent: $('#tambahObat')
		});
		$('#select').select2();
		$.get('<?=base_url()?>autocomplete/golongan_logistik/nama_golongan', function(html){
			respon = JSON.parse(html)
			data = new Array()
			for (var i in respon.data) {
				data.push(respon.data[i].nama_golongan)
			}

			// console.log(data)

			$('#tambahNamaObat').autocomplete({
				lookup: data,
				onSelect: function (suggestion) {
					// $('#tambahNamaObat').attr('value',suggestion.data)
				}
			})
		})
	});
</script>
<!-- END inisialisasi autocomplete -->
