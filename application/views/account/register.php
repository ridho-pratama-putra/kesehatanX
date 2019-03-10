<style type="text/css">
.my-error-class {color:#FF0000;}
.my-valid-class {color:#00CC00;}
</style>
<script type="text/javascript">
	$(function () {$('[data-toggle="tooltip"]').tooltip()})
	$( document ).ready(function() {
		$("#register").validate({
			rules:{
				nama:{
					required:true,
					minlength:2
				},nik:{
					required:true,
					minlength:16,
					maxlength:16,
					number:true
				},alamat:{
					required:true,
					minlength:10
				},email:{
					required:true,
					email:true
				},password:{
					required:true,
					minlength:6
				},password2:{
					required:true,
					minlength:6,
					equalTo:"#password"
				}
			},messages:{
				nama:{
					required:"Mohon isi nama Anda",
					minlength:"Mohon isi lebih dari 2 karakter"
				},nik:{
					required:"Mohon isi nomor NIK",
					minlength:"NIK anda kurang dari 16 karakter. Mohon isi NIK sebanyak 16 karakter",
					maxlength:"NIK anda lebih dari 16 karakter. Mohon isi NIK sebanyak 16 karakter",
					number:"Harus angka"
				},alamat:{
					required:"Mohon isi alamat anda",
					minlength:"Alamat anda kurang dari 10 karakter"
				},email:{
					required:"Mohon isi alamat email valid anda",
					email:"alamat email tidak valid"
				},password:{
					required:"Mohon isi password untuk akun anda",
					minlength:"Password anda kurang dari 6 karakter. Mohon isi password anda minimal 6 karakter"
				},password2:{
					required:"Mohon isi password verifikasi untuk akun anda",
					minlength:"Password anda kurang dari 6 karakter. Mohon isi password anda minimal 6 karakter",
					equalTo:"Password verifikasi anda tidak sesuai dengan password awal"
				}
			},
			errorClass: "my-error-class",
			validClass: "my-valid-class"
		});
	});
	function deleteSip(){
		var hak_akses = document.getElementById('hak_akses').value;
		if (hak_akses == '3') {
			document.getElementById('sip').innerHTML = '';
		}else{
			document.getElementById('sip').innerHTML = '<div class="form-group">'+
			'<input class="form-control" placeholder="No SIP" name="no_sip" type="text" required="">'+
			'</div>';
		}
	}
</script>
<div class="container-fluid">
	<div class="row mt-1">	
		<div class="col-xs-10 offset-xs-1 col-sm-8 offset-sm-2 col-md-4 offset-md-4">
			<?=$this->session->flashdata("alert");?><?=$this->session->flashdata("alert_");?>
			<div class="card">
				<div class="card-header">Register User</div>
				<div class="card-body">
					<form role="form" method="POST" action="<?=base_url().'submit-register-user'?>" id="register" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">dr.</span>
								</div>
								<input class="form-control" name="nama" type="text" id="nama" placeholder="Nama" required="" minlength="2" autofocus="" data-toggle="tooltip" data-placement="auto" title="Nama Harus lebih dari 2 karakter">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="NIK" type="text" name="nik" id="nik" required="" data-toggle="tooltip" data-placement="auto" title="NIK harus sejumlah 16 karakter">
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<select class="form-control" name="jenis_kelamin" placeholder="Jenis Kelamin" required="">
											<option value="" selected="" disabled="">Pilih jenis kelamin</option>
											<option value="Laki - Laki ">Laki - Laki</option>
											<option value="Perempuan">Perempuan</option>
										</select>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<select class="form-control" name="hak_akses" placeholder="Hak Akses" required="" id="hak_akses" onchange="deleteSip()">
											<option value="" selected="" disabled="">Pilih Hak akses</option>
											<option value="admin">Admin</option>
											<option value="dokter">Dokter</option>
											<option value="petugas">Petugas</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Alamat" name="alamat" type="text" required="">
							</div>
							<div id="sip">
								
							</div>
							<div class="custom-file form-group mb-3">
								<input type="file" class="custom-file-input form-control" id="customFile" required="" name="foto">
								<label class="custom-file-label" for="customFile">Upload Foto ( jpg/jpeg/png )</label>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" required="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="email" type="email" required="" data-toggle="tooltip" data-placement="auto" title="Email harus valid">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" id="password" type="password" required="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Re-type Password" name="password2" id="password2" type="password" required="" >
							</div>
							<div class="row">
								<div class="col"><button class="btn btn-primary btn-block " type="submit">Sign Up</button></div>
								<div class="col"><a class="btn btn-primary btn-block text-white ml-auto" href="<?= base_url()."login"?>">Back to Login</a></div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
</div>