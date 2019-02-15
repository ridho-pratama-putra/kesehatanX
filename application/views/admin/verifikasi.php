<div class="container mt-3">
	<?=$this->session->flashdata('alert')?>
	<?php
	if ($belum_terverifikasi != array()) {
		?>
		<h3 class="text mt-3" style="margin-left: 65px">Verifikasi Akun</h3>
		<div class="row mt-4 mb-5">	
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Nama</th>
						<th scope="col">SIP</th>
						<th scope="col">Proses</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($belum_terverifikasi as $key => $value) {
						echo "<tr>";
						echo "<td>";
						echo $value->nama;
						echo "</td>";
						echo "<td>";
						echo $value->sip;
						echo "</td>";
						echo "<td>";
						echo "<a href=".base_url()."submit-verifikasi-user/$value->id_user class='btn btn-primary btn-block btn-sm'>Validasi</a>";
						echo "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}
	?>

	<?php
	if ($sudah_terverifikasi != array()) {
		?>

		<h3 class="text mt-3">Reset Password</h3>
		<div class="row mt-5">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Nama</th>
						<th scope="col">SIP</th>
						<th scope="col">Password</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($sudah_terverifikasi as $key => $value) {
						echo "<tr>";
						echo "<td>";
						echo $value->nama;
						echo "</td>";
						echo "<td>";
						echo $value->sip;
						echo "</td>";
						echo "<td>";
						echo "<a href='".base_url()."submit-reset-password/$value->id' class='btn btn-danger btn-block btn-sm'>Reset</a>";
						echo "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}
	?>
</div>