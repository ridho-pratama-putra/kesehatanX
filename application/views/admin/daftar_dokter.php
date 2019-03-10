<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			columnDefs: [ 
			{ 
				orderable: false, 
				targets: [1,3] 
			},
			{
				width: "20px",
				targets: [0]
			},
			{
				width: "200px",
				targets: [1]
			},
			{
				width: "600px",
				targets: [2]
			}
			]
		});
	} );
</script>

<style type="text/css">
.linone {
	display: none;
}
.no-bullets {
	list-style-type: none;
}
</style>

<h3 class="text-center mt-4">Daftar Dokter</h3>

<div class="container">
	<div class=" row mt-5">	
		<div class="col">
			<table id="example" class="display">
				<thead>
					<tr>
						<th><div class="text-center">No.</div></th>
						<th><div class="text-center">Foto</div></th>
						<th><div class="text-center">Biodata</div></th>							
						<th><div class="text-center">Pelayanan</div></th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; foreach ($dokter as $key => $value) { ?>
						<tr>
							<td>	
								<div class="text-center"><?=$i?></div>
							</td>
							<td>
								<div class="text-center">
									<img src="<?php echo base_url($value->foto)?>" class="rounded img-responsive" style="width: 50px">
								</div>
							</td>
							<td>
								<div class="row">
									<div class="col-2">No. SIP</div>
									<div class="col-0">:</div>
									<div class="col-9"><?=ucwords($value->sip)?></div>
								</div>
								<div class="row">
									<div class="col-2">Nama</div>
									<div class="col-0">:</div>
									<div class="col-9"><?=ucwords($value->nama)?></div>
								</div>
								<td>
									<div class="btn-group" role="group" aria-label="Basic example">
										<a href="<?=base_url()?>per-dokter-per-pembayaran/<?=$value->id?>/Umum" class="btn btn-success">Umum</a>
										<a href="<?=base_url()?>per-dokter-per-pembayaran/<?=$value->id?>/BPJS" class="btn btn-primary">BPJS</a>
									</div>
								</td>
							</td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>