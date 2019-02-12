<div class="text-center mt-3"><h5><strong>Daftar Golongan</strong></h5></div>

<div class="container mt-3">
	<div class="mt-3 mb-3">
		<?=$this->session->flashdata("alert");?>
	</div>

	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#tambahGolonganLogistikModal">
		Tambah Golongan Logistik
	</button>
	
	<table id="tabel" class="display" style="width:100%">
		<thead>
			<tr>
				<th class="text-center" style="width: 5%">No.</th>
				<th style="width: 85%">Nama Golongan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach($record as $key => $value) {
				?>
				<tr>
					<td class="text-center"><?=$i?></td>
					<td><?=$value->nama_golongan?></td>
					<td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editNamaGolonganLogistikModal" data-nama="<?=$value->nama_golongan?>" data-id="<?=$value->id?>">Edit</button>
							<a href="<?=base_url()?>golongan-logistik-hapus/<?=$value->id?>" class="btn btn-secondary text-white" >Delete</a>
						</div>
					</td>
				</tr>
				<?php 
				$i++; 
			} ?>
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tabel').DataTable( {
				columnDefs: [
				{
					orderable: false,
					targets: [2]
				}
				]
			});
		});
	</script>
</div>

<!-- MODAL ADD GOLONGAN OBAT -->
<div class="modal fade" id="tambahGolonganLogistikModal" tabindex="-1" role="dialog" aria-labelledby="tambahGolonganLogistikModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahGolonganLogistikModalLabel">Tambah Golongan Logistik</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="<?=base_url()?>golongan-logistik-tambah">
				<div class="modal-body">
					<div class="form-group">
						<label for="tambahNamaGolongan">
							<p class="text-warning">
								**Mohon gunakan format capital first letter.
							</p>
							Nama golongan
						</label>
						<input type="text" class="form-control" id="tambahNamaGolongan" placeholder="Contoh : Antibiotik atau Antifungal" name="nama_golongan" required="">
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

<!-- MODAL EDIT GOLONGAN OBAT -->
<div class="modal fade" id="editNamaGolonganLogistikModal" tabindex="-1" role="dialog" aria-labelledby="editNamaGolonganLogistikModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editNamaGolonganLogistikModalLabel">Edit Nama Golongan Logistik</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="formEditNamaGolongan">
				<div class="modal-body">
					<div class="form-group">
						<label for="editNamaGolongan">
							<p class="text-warning">
								**Mohon gunakan format capital first letter.
							</p>
							Nama golongan
						</label>
						<input type="text" class="form-control" id="editNamaGolongan" placeholder="Contoh : Antibiotik atau Antifungal" name="nama_golongan" required="">
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
<!-- MODAL EDIT GOLONGAN OBAT -->

<script type="text/javascript">
	$('#tambahGolonganLogistikModal').on('shown.bs.modal', function () {
		$('#tambahNamaGolongan').trigger('focus')
	})
	$('#editNamaGolonganLogistikModal').on('shown.bs.modal', function (event) {
		$("#editNamaGolongan").trigger("focus")

		var button = $(event.relatedTarget)
		var nama_golongan = button.data('nama')
		var id_golongan = button.data('id')
		
		$("#editNamaGolongan").val(nama_golongan)
		$("#formEditNamaGolongan").attr("action","<?=base_url()?>golongan-logistik-edit/"+id_golongan)
	})

	$('#editNamaGolonganLogistikModal').on('hidden.bs.modal', function (e) {
		$("#editNamaGolongan").val()
		$("#formEditNamaGolongan").attr("action","")
	})
</script>