
<form method="POST" action="<?=base_url()?>submit-edit-identitas-pasien">
	<div class="container mt-3">
		<div class="mt-3 mb-3">
			<?=$this->session->flashdata("alert");?>
		</div>
	</div>
	<div class="container mt-3">
		<div class="form-group">
			<label for="id-pasien">
				ID Pasien
			</label>
			<input type="text" class="form-control" id="id-pasien" name="id_pasien" value="<?=$pasien[0]->id?>"  readonly="">
		</div>
		<div class="form-group">
			<label>
				Nama Pasien
			</label>
			<input type="text" class="form-control" placeholder="<?='data sekarang : '.$pasien[0]->nama?>" name="nama" value="<?=$pasien[0]->nama?>">
		</div>
		<div class="form-group">
			<label for="nik">
				NIK
			</label>
			<input type="text" class="form-control" id="nik" placeholder="<?=($pasien[0]->nik !== NULL ? 'data sekarang : '.$pasien[0]->nik : 'data masih belum diisi' )?>" name="nik" value="<?=($pasien[0]->nik !== NULL ? $pasien[0]->nik : '')?>">
		</div>
		<div class="form-group">
			<label for="tempat-lahir">
				Tempat lahir
			</label>
			<input type="text" class="form-control" id="tempat-lahir" placeholder="<?=($pasien[0]->tempat_lahir !== NULL ? 'data sekarang : '.$pasien[0]->tempat_lahir : 'data masih belum diisi' )?>" name="tempat_lahir" value="<?=($pasien[0]->tempat_lahir !== NULL ? $pasien[0]->tempat_lahir : '')?>">
		</div>
		<div class="form-group">
			<label for="tanggal-lahir">
				Tanggal lahir
			</label>
			<input type="date" min="0" class="form-control" id="tanggal-lahir" placeholder="<?=($pasien[0]->tanggal_lahir !== NULL ? 'data sekarang : '.$pasien[0]->tanggal_lahir : 'data masih belum diisi' )?>"
			value="<?=($pasien[0]->tanggal_lahir !== NULL ? $pasien[0]->tanggal_lahir : '')?>" name="tanggal_lahir" >
		</div>
		<div class="form-group">
			<label for="usia">
				Tanggal lahir
			</label>
			<input type="text" min="0" class="form-control" id="usia" placeholder="<?=($pasien[0]->usia !== NULL ? 'data sekarang : '.$pasien[0]->usia : 'data masih belum diisi' )?>"
			value="<?=($pasien[0]->usia !== NULL ? $pasien[0]->usia : '')?>" name="usia" >
		</div>
		<div class="form-group">
			<label for="jalan">
				Jalan
			</label>
			<input type="text" min="0" class="form-control" id="jalan" placeholder="<?=($pasien[0]->jalan !== NULL ? 'data sekarang : '.$pasien[0]->jalan : 'data masih belum diisi' )?>"
			value="<?=($pasien[0]->jalan !== NULL ? $pasien[0]->jalan : '')?>" name="jalan" >
		</div>
		<div class="form-group">
			<label for="tanggal-lahir">
				Tanggal lahir
			</label>
			<input type="date" min="0" class="form-control" id="tanggal-lahir" placeholder="<?=($pasien[0]->tanggal_lahir !== NULL ? 'data sekarang : '.$pasien[0]->tanggal_lahir : 'data masih belum diisi' )?>"
			value="<?=($pasien[0]->tanggal_lahir !== NULL ? $pasien[0]->tanggal_lahir : '')?>" name="tanggal_lahir" >
		</div>
		
		<div class="form-group row">
			<div class="col">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Kota</label>
					<div class="input-group-prepend col-sm-9">
						<select class="form-control" id="kota" name="kota" onchange="kotaORkabupatenLain()">
							<option value="" disabled="" >Kota / Kabupaten</option>
							<option value="Malang" >Kota Malang</option>
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
						<select class="form-control" id="kecamatan" name="kecamatan" onchange="kecamatanLain()">
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
						<select class="form-control" id="kelurahan" name="kelurahan" onchange="kelurahanLain()">
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
	</div>
	<div class="container">
		<a href="<?=base_url()?>logistik-alat-bahan-sekali-pakai" class="btn btn-secondary">Kembali</a>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</div>
</form>

<script type="text/javascript">

	function kotaORkabupatenLain(){
		var lain = document.getElementById("kota");
		var kotaORkabupatenLain = document.getElementById("kotaORkabupatenLain");
		if (lain.value == 'other') {
			kotaORkabupatenLain.className 	= "input-group-prepend col-sm-9 offset-sm-3";
			var input_element 				= document.createElement("input");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kota_lain");
			input_element.setAttribute("id", "kota-lain");
			input_element.setAttribute("placeholder", "Contoh : kabupaten mojokerto / Kota surabaya");
			// input_element.setAttribute("required", "");
			kotaORkabupatenLain.appendChild(input_element);

			document.getElementById("kecamatan").value ="other";kecamatanLain();
			document.getElementById("kelurahan").value ="013 Lain-lain";kelurahanLain();
		}else{
			kotaORkabupatenLain.className = "";
			document.getElementById("kecamatan").value ="";kecamatanLain();
			document.getElementById("kelurahan").value ="";kelurahanLain();
			while (kotaORkabupatenLain.hasChildNodes()) { 
				kotaORkabupatenLain.removeChild(kotaORkabupatenLain.firstChild);
			}
		}
	}

	function kecamatanLain(){
		var lain = document.getElementById("kecamatan");
		var kecamatanLain = document.getElementById("kecamatanLain");
		while (kecamatanLain.hasChildNodes()) { 
			kecamatanLain.removeChild(kecamatanLain.firstChild);
		}
		if (lain.value == 'other') {
			kecamatanLain.className 	= "input-group-prepend col-sm-8 offset-sm-4";
			var input_element 				= document.createElement("input");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kecamatan_lain");
			input_element.setAttribute("id", "kecamatan-lain");
			input_element.setAttribute("placeholder", "Contoh: lowokwaru");
			// input_element.setAttribute("required", "");
			kecamatanLain.appendChild(input_element);
			document.getElementById("kelurahan").value ="013 Lain-lain";kelurahanLain();
		}else{
			kecamatanLain.className = "";
			document.getElementById("kelurahan").value ="";kelurahanLain();
			while (kecamatanLain.hasChildNodes()) { 
				kecamatanLain.removeChild(kecamatanLain.firstChild);
			}
		}
	}
	
	function kelurahanLain(){
		var lain = document.getElementById("kelurahan");
		var kelurahanLain = document.getElementById("kelurahanLain");
		while (kelurahanLain.hasChildNodes()) { 
			kelurahanLain.removeChild(kelurahanLain.firstChild);
		}
		if (lain.value == '013 Lain-lain') {
			kelurahanLain.className 		= "input-group-prepend col-sm-8 offset-sm-4";
			var input_element 				= document.createElement("input");
			input_element.className 		= ("form-control");
			input_element.setAttribute("type", "text");
			input_element.setAttribute("name", "kelurahan_lain");
			input_element.setAttribute("id", "kelurahan-lain");
			input_element.setAttribute("placeholder", "Contoh: dinoyo");
			// input_element.setAttribute("required", "");
			kelurahanLain.appendChild(input_element);
		}else{
			kelurahanLain.className = "";
			while (kelurahanLain.hasChildNodes()) { 
				kelurahanLain.removeChild(kelurahanLain.firstChild);
			}
		}
	}
</script>
<script type="text/javascript">
	$( document ).ready(function() {
		$("#kota").val("<?=$pasien[0]->kota?>");
		kotaORkabupatenLain()
		<?=($pasien[0]->kota == 'other' ? ($pasien[0]->kota_lain !== NULL ? '$("#kota-lain").val("'.$pasien[0]->kota_lain.'")' : '$("#kota-lain").attr("placeholder","data masih belum diisi")') : '')?>

		$("#kecamatan").val("<?=$pasien[0]->kecamatan?>");
		kecamatanLain()
		<?=($pasien[0]->kecamatan == 'other' ? ($pasien[0]->kecamatan_lain !== NULL ? '$("#kecamatan-lain").val("'.$pasien[0]->kecamatan_lain.'")' : '$("#kecamatan-lain").attr("placeholder","data masih belum diisi")') : '')?>

		$("#kelurahan").val("<?=$pasien[0]->kelurahan?>");
		kelurahanLain()
		<?=($pasien[0]->kelurahan == '013 Lain-lain' ? ($pasien[0]->kelurahan_lain !== NULL ? '$("#kelurahan-lain").val("'.$pasien[0]->kelurahan_lain.'")' : '$("#kelurahan-lain").attr("placeholder","data masih belum diisi")') : '')?>
	});
</script>