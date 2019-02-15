<script type="text/javascript">
	function kotaORkabupatenLain(){
		var lain = document.getElementById("kotaID");
		var kotaORkabupatenLain = document.getElementById("kotaORkabupatenLain");
		if (lain.value == 'other') {
			kotaORkabupatenLain.className 	= "input-group-prepend col-sm-9 offset-sm-3";
			var input_element 				= document.createElement("INPUT");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kota_lain");
			input_element.setAttribute("placeholder", "Contoh : kabupaten mojokerto / Kota surabaya");
			input_element.setAttribute("required", "");
			kotaORkabupatenLain.appendChild(input_element);

			document.getElementById("kecamatanID").value ="other";kecamatanLain();
			document.getElementById("kelurahanID").value ="013 Lain-lain";kelurahanLain();
		}else{
			kotaORkabupatenLain.className = "";
			document.getElementById("kecamatanID").value ="";kecamatanLain();
			document.getElementById("kelurahanID").value ="";kelurahanLain();
			while (kotaORkabupatenLain.hasChildNodes()) { 
				kotaORkabupatenLain.removeChild(kotaORkabupatenLain.firstChild);
			}
		}
	}

	function kecamatanLain(){
		var lain = document.getElementById("kecamatanID");
		var kecamatanLain = document.getElementById("kecamatanLain");
		while (kecamatanLain.hasChildNodes()) { 
			kecamatanLain.removeChild(kecamatanLain.firstChild);
		}
		if (lain.value == 'other') {
			kecamatanLain.className 	= "input-group-prepend col-sm-8 offset-sm-4";
			var input_element 				= document.createElement("INPUT");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kecamatan_lain");
			input_element.setAttribute("placeholder", "Contoh: lowokwaru");
			input_element.setAttribute("required", "");
			kecamatanLain.appendChild(input_element);
			document.getElementById("kelurahanID").value ="013 Lain-lain";kelurahanLain();
		}else{
			kecamatanLain.className = "";
			document.getElementById("kelurahanID").value ="";kelurahanLain();
			while (kecamatanLain.hasChildNodes()) { 
				kecamatanLain.removeChild(kecamatanLain.firstChild);
			}
		}
	}
	
	function kelurahanLain(){
		var lain = document.getElementById("kelurahanID");
		var kelurahanLain = document.getElementById("kelurahanLain");
		while (kelurahanLain.hasChildNodes()) { 
			kelurahanLain.removeChild(kelurahanLain.firstChild);
		}
		if (lain.value == '013 Lain-lain') {
			kelurahanLain.className 		= "input-group-prepend col-sm-8 offset-sm-4";
			var input_element 				= document.createElement("INPUT");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kelurahan_lain");
			input_element.setAttribute("placeholder", "Contoh: dinoyo");
			input_element.setAttribute("required", "");
			kelurahanLain.appendChild(input_element);
		}else{
			kelurahanLain.className = "";
			while (kelurahanLain.hasChildNodes()) { 
				kelurahanLain.removeChild(kelurahanLain.firstChild);
			}
		}
	}

	function cekPembayaran(){
		var pembayaran = $('#jenis_pembayaran').val();
		if (pembayaran != 'BPJS') {
			$('#nomor_bpjs').css('display','none');
		}else{
			$('#nomor_bpjs').css('display','');
		}
	}

	function cekUmur(){
		var dateinputan = new Date($('#tanggal_lahir').val());
		tahun_lahir = dateinputan.getFullYear();
		
		var datenow = new Date();
		tahun_sekarang = datenow.getFullYear();
		var umur = tahun_sekarang - tahun_lahir;
		
		if (umur <= 14) {
			elemToRender = "<div class='row'>"+
			"<div class='col'>"+
			"<div class='form-group row'>"+
			"<label class='col-sm-3 col-form-label'>Nama Ayah</label>"+
			"<div class='input-group-prepend col-sm-9'>"+
			"<input type='text' class='form-control' name='nama_ayah'>"+
			"</div>"+
			"</div>"+
			"</div>"+
			"<div class='col'>"+
			"<div class='form-group row'>"+
			"<label class='col-sm-3 col-form-label'>Nama Ibu</label>"+
			"<div class='input-group-prepend col-sm-9'>"+
			"<input type='text' class='form-control' name='nama_ibu'>"+
			"</div>"+
			"</div>"+
			"</div>"+
			"<div>";
			$('#nama_orang_tua').html(elemToRender);
		}else{
			$('#nama_orang_tua').html("");
		}
	}

</script>
<h3 class="text-center mt-3">Pendafataran Awal Pasien</h3>
<form action="<?= base_url().'submit-pendaftaran'?>" method="POST">
	<div class="container">
		<?=$this->session->flashdata("alert");?>
		<div class="row">
			<div class="col">

				<div class="form-group row">
					<label class="col-sm-1 col-form-label">Nama</label>
					<div class="input-group-prepend col-sm-11">
						<input type="text" class="form-control" id="" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-1 col-form-label">Pekerjaan</label>
					<div class="input-group-prepend col-sm-11">
						<input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Contoh: pelajar" required="">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-1 col-form-label">NIK</label>
					<div class="input-group-prepend col-sm-11">
						<input type="text" class="form-control" id="nik" name="nik" placeholder="Contoh : 9801239801982388">
					</div>
				</div>

				<div class="form-group row">
					<div class="col">	
						<label class="control-label"><strong>Tempat, Tanggal Lahir</strong></label> 
					</div>
				</div>

				<div class="row">
					<div class="col">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Tempat</label>
							<div class="input-group-prepend col-sm-9">
								<input type="text" class="form-control" id="" name="tempat_lahir" placeholder="Contoh : malang" required="">
							</div>
						</div>
					</div>
					<div class="col">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Tanggal</label>
							<div class="input-group-prepend col-sm-8">
								<input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required="" onchange="cekUmur()">
							</div>
						</div>
					</div>
					<!-- <div class="col">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label"></label>
							<div class="input-group-prepend col-sm-10">
							</div>
						</div>
					</div> -->
				</div>

				<div id="nama_orang_tua"></div><!-- jika anak2 maka tambahkan kolom inputan nama orang tua. -->

				<div class="form-group row">
					<div class="col">	
						<label class="control-label"><strong>Alamat</strong></label> 
					</div>
				</div>

				<!-- KOTA KECAMATAN KELURAHAN -->
				<div class="form-group row">
					<div class="col">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Kota</label>
							<div class="input-group-prepend col-sm-9">
								<select class="form-control" id="kotaID" name="kota" required="" onchange="kotaORkabupatenLain()">
									<option value="" disabled="" selected="">Kota / Kabupaten</option>
									<option value="Malang">Kota Malang</option>
									<option value="other" >Lain-lain</option>
								</select>
							</div>
							<div id="kotaORkabupatenLain">

							</div>
						</div>
					</div>

					<div class="col">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kecamatan</label>
							<div class="input-group-prepend col-sm-8">
								<select class="form-control" id="kecamatanID" name="kecamatan" required="" onchange="kecamatanLain()">
									<option value="" disabled="" selected="">Kecamatan</option>
									<option value="Kedungkandang">Kedungkandang</option>
									<option value="other">Lain-lain</option>
								</select>
							</div>
							<div id="kecamatanLain">
							</div>
						</div>	
					</div>

					<div class="col">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kelurahan</label>
							<div class="input-group-prepend col-sm-8">
								<select class="form-control" id="kelurahanID" name="kelurahan" required="" onchange="kelurahanLain()">
									<option value="" disabled="" selected="">Kelurahan</option>
									<option value="001 Arjowinangun">001 Arjowinangun</option>
									<option value="002 Bumiayu">002 Bumiayu</option>
									<option value="003 Buring">003 Buring</option>
									<option value="004 Cemoro Kandang">004 Cemoro Kandang</option>
									<option value="005 Kedung Kandang">005 Kedung Kandang</option>
									<option value="006 Kota Lama">006 Kota Lama</option>
									<option value="007 Lesanpuro">007 Lesanpuro</option>
									<option value="008 Madyopuro">008 Madyopuro</option>
									<option value="009 Mergosono">009 Mergosono</option>
									<option value="010 Sawojajar">010 Sawojajar</option>
									<option value="011 Tlogowaru">011 Tlogowaru</option>
									<option value="012 Wonokoyo">012 Wonokoyo</option>
									<option value="013 Lain-lain">013 Lain-Lain</option>
								</select>
							</div>
							<div id="kelurahanLain">

							</div>
						</div>	
					</div>
				</div>	

				<div class="form-group row">
					<div class="col">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Jalan</label>
							<div class="input-group-prepend col-sm-9">
								<input type="text" class="form-control" id="" name="jalan" placeholder="Contoh : mayjen sungkono no 123" required="">
							</div>
						</div>	
					</div>
					<div class="col">
						<div class="form-group row">
							<label class="col-sm-1 col-form-label">RT</label>
							<div class="input-group-prepend col-sm-5">
								<input type="number" class="form-control" id="" name="RT" placeholder="Contoh: 02" required="" min="0">
							</div>
							<label class="col-sm-1 col-form-label">RW</label>
							<div class="input-group-prepend col-sm-5">
								<input type="number" class="form-control" id="" name="RW" placeholder="Contoh: 02" required="" min="0">
							</div>
						</div>
					</div>
					<div class="col">
						<div class="form-group row">
						</div>
					</div>
				</div>

				<!-- JENIS KELAMIN -->
				<div class="form-group row">
					<label class="col-sm-1 col-form-label">Gender</label>
					<div class="input-group-prepend col-sm-7">
						<select class="form-control" name="jenis_kelamin" required="">
							<option value="Laki-laki">Laki - Laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>	
					</div>
				</div>
				
				<!-- JENIS PEMBAYARAN -->
				<div class="form-group row">
					<label class="col-sm-1 col-form-label">Pembayaran</label>
					<div class="input-group-prepend col-sm-7">
						<select class="form-control" id="jenis_pembayaran" name="pembayaran" required="" onchange="cekPembayaran()">
							<option value="Umum">Umum</option>
							<option value="BPJS">BPJS</option>
							<option value="RF">Royale Family</option>
						</select>	
					</div>
				</div>

				<!-- JIKA BPJS MAKA TAMPILKAN KOLOM TAMBAHAN UNTUK PENGSIAN NOMOR BPJS -->
				<div class="form-group row" id="nomor_bpjs" style="display: none;">
					<label class="col-1 col-form-label">Nomor BPJS</label>
					<div class="input-group-prepend col-7">
						<input class="form-control " type="text" placeholder="Masukkan Nomor BPJS" name="nomor_bpjs">
					</div>
				</div>				
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>  
			</div>   
		</div>
	</div>
</form>			


