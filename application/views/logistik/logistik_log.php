<div class="container mt-3">
	<table id="example" class="display" style="width:100%">
		<thead>
			<tr>
				<th>tanggal</th>
				<th>nama</th>
				<th>Sediaan</th>
				<th>Bentuk</th>
				<th>Stok masuk</th>
				<th>Stok keluar</th>
				<th>Stok sekarang</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($record as $key => $value) { ?>
				<tr>
					<td><?=$value->datetime_last?></td>
					<td><?=$value->nama?></td>
					<td><?=$value->sediaan?></td>
					<td><?=$value->bentuk?></td>
					<td><?=$value->stok_masuk?></td>
					<td><?=$value->stok_keluar?></td>
					<td><?=$value->stok_sekarang?></td>
				</tr>
			<?php }
			?>
		</tbody>
	</table>

</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable();
	} );
</script>