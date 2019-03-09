<style type="text/css">
.my-error-class {color:#FF0000;}
.my-valid-class {color:#00CC00;}
.linone {display: none;}
.no-bullets {list-style-type: none;}
</style>
<style type="text/css">
.sembunyikan {
	display: none;
	font-size: 
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		// inisialisasi dengan select2
		$('#diagnosaPrimaryId').select2();
		$('#diagnosaSecondaryId').select2();
		$('#diagnosaLainId').select2();

    	// inisialisasi select assessment primary secondary dan lainlain dengan ajax 
    	$('.select-assessment').select2({
    		placeholder: "Pilih Sesuai ICD 10",
    		ajax: {
    			url: '<?=base_url()?>Dokter/cariICD/',
    			dataType: 'json',
    			delay: 1000,
    			data: function (term, page) {
    				return {
						term: term, // search term
						page: 10
					};
				},
				processResults: function (data, page) {
					return {
						results: data
					};
				},
				cache: true
			},
			escapeMarkup: (markup) => { return markup; }, // let our custom formatter work
			minimumInputLength: 1,
		});

		// inisialisasi dan set alert form surat sakit
		// $("#formSuratSakit").validate({
		// 	rules:{
		// 		alasan:{
		// 			required:true,
		// 		},selama:{
		// 			required:true,
		// 		},selama_satuan:{
		// 			required:true,
		// 		}
		// 	},messages:{
		// 		alasan:{
		// 			required:"Mohon isi alasan",
		// 		},selama:{
		// 			required:"Mohon isi data yang dibutuhkan",
		// 		},selama_satuan:{
		// 			required:"Mohon isi data yang dibutuhkan",
		// 		}
		// 	},
		// 	errorClass: "my-error-class",
		// 	validClass: "my-valid-class"
		// });

		// inisialisasi dan set alert form surat sehat
		// $("#formSuratSehat").validate({
		// 	rules:{
		// 		keperluan:{
		// 			required:true,
		// 		}
		// 	},messages:{
		// 		keperluan:{
		// 			required:"Mohon isi data yang dibutuhkan",
		// 		}
		// 	},
		// 	errorClass: "my-error-class",
		// 	validClass: "my-valid-class"
		// });

		// saat obat injeksi terpilih, tampilkan satuan, dan stok maksimal yang bisa dimasukkan via atribut max
		$("#select-obat-injeksi").select2({
			ajax: {
				url: '<?=base_url()?>Dokter/cariLogistik/obat_injeksi',
				dataType: 'json',
				delay: 1000,
				data: (term) => {
					return {
						term: term // search term
					};
				},
				processResults: (data) => {
					// console.log(data);

					return {
						results: data
					};
				}
			},
			escapeMarkup: (markup) => { return markup; },
			minimumInputLength: 1,
			theme : "bootstrap",
			templateResult: (data) => {
				if (data.loading) {
					return data.text;
				}

				var markup = "<div class='clearfix'>";

				markup += "<strong><h5>"+ data.text+" </h5></strong>\n Bentuk: "+data.bentuk+" <br>Sediaan: "+data.sediaan+" <br>Harga: "+convertToRupiah(data.harga)+"<br>Stok sekarang: "+data.stok+
				"</div>";

				return markup;
			},
			templateSelection: (data) => {
				// console.log(data);
				$('#input-harga-obat-injeksi').val(data.harga);
				$('#input-jumlah-obat-injeksi').attr(
				{
					"max" : data.stok
				}
				);

				if (typeof(data.sediaan) !== 'undefined') {
					$('#input-jumlah-obat-injeksi').attr(
					{
						"placeholder" : "contoh : 2 ( maksimal : "+ data.stok+")"
					}
					);
				}
				$('#input-harga-per-item-obat-injeksi').val($('#input-jumlah-obat-injeksi').val() * $('#input-harga-obat-injeksi').val());
				if (typeof data.bentuk !== 'undefined' && typeof data.sediaan !== 'undefined') {
					return data.text + " "+ data.bentuk +" "+data.sediaan
				}else{
					return data.text
				}
			}
		});

		// saat obat oral terpilih, tampilkan satuan, dan stok maksimal yang bisa dimasukkan via atribut max
		$("#select-obat-oral").select2({
			ajax: {
				url: '<?=base_url()?>Dokter/cariLogistik/obat_oral',
				dataType: 'json',
				delay: 1000,
				data: (term) => {
					return {
						term: term // search term
					};
				},
				processResults: (data) => {
					// console.log(data);

					return {
						results: data
					};
				}
			},
			escapeMarkup: (markup) => { return markup; },
			minimumInputLength: 1,
			theme : "bootstrap",
			templateResult: (data) => {
				if (data.loading) {
					return data.text;
				}

				var markup = "<div class='clearfix'>";

				markup += "<strong><h5>"+ data.text+" </h5></strong>\n Bentuk: "+data.bentuk+" <br>Sediaan: "+data.sediaan+" <br>Harga: "+convertToRupiah(data.harga)+"<br>Stok sekarang: "+data.stok+
				"</div>";

				return markup;
			},
			templateSelection: (data) => {
				// console.log(data);
				$('#input-harga-obat-oral').val(data.harga);
				$('#input-jumlah-obat-oral').attr(
				{
					"max" : data.stok
				}
				);

				if (typeof(data.sediaan) !== 'undefined') {
					$('#input-jumlah-obat-oral').attr(
					{
						"placeholder" : "contoh : 2 ( maksimal : "+ data.stok+")"
					}
					);
				}
				$('#input-harga-per-item-obat-oral').val($('#input-jumlah-obat-oral').val() * $('#input-harga-obat-oral').val());
				if (typeof data.bentuk !== 'undefined' && typeof data.sediaan !== 'undefined') {
					return data.text + " "+ data.bentuk +" "+data.sediaan
				}else{
					return data.text
				}
			}
		});

		// saat obat sue terpilih, tampilkan satuan, dan stok maksimal yang bisa dimasukkan via atribut max
		$("#select-obat-sigma-usus-externum").select2({
			ajax: {
				url: '<?=base_url()?>Dokter/cariLogistik/obat_sigma_usus_externum',
				dataType: 'json',
				delay: 1000,
				data: (term) => {
					return {
						term: term // search term
					};
				},
				processResults: (data) => {
					// console.log(data);

					return {
						results: data
					};
				}
			},
			escapeMarkup: (markup) => { return markup; },
			minimumInputLength: 1,
			theme : "bootstrap",
			templateResult: (data) => {
				if (data.loading) {
					return data.text;
				}

				var markup = "<div class='clearfix'>";

				markup += "<strong><h5>"+ data.text+" </h5></strong>\n Bentuk: "+data.bentuk+" <br>Sediaan: "+data.sediaan+" <br>Harga: "+convertToRupiah(data.harga)+"<br>Stok sekarang: "+data.stok+
				
				"</div>";

				return markup;
			},
			templateSelection: (data) => {
				// console.log(data);
				$('#input-harga-obat-sigma-usus-externum').val(data.harga);
				$('#input-jumlah-obat-sigma-usus-externum').attr(
				{
					"max" : data.stok
				}
				);

				if (typeof(data.sediaan) !== 'undefined') {
					$('#input-jumlah-obat-sigma-usus-externum').attr(
					{
						"placeholder" : "contoh : 2 ( maksimal : "+ data.stok+")"
					}
					);
				}
				$('#input-harga-per-item-obat-sigma-usus-externum').val($('#input-jumlah-obat-sigma-usus-externum').val() * $('#input-harga-obat-sigma-usus-externum').val());
				if (typeof data.bentuk !== 'undefined' && typeof data.sediaan !== 'undefined') {
					return data.text + " "+ data.bentuk +" "+data.sediaan
				}else{
					return data.text
				}
			}
		});

		// saat oalat bahan sekali pakai terpilih, tampilkan satuannya, dan stok maksimal yang bisa dimasukkan via atribut max
		$("#select-alat-bahan-sekali-pakai").select2({
			ajax: {
				url: '<?=base_url()?>Dokter/cariLogistik/alat_bahan_sekali_pakai',
				dataType: 'json',
				delay: 1000,
				data: (term) => {
					return {
						term: term // search term
					};
				},
				processResults: (data) => {
					return {
						results: data
					};
				}
			},
			escapeMarkup: (markup) => { return markup; },
			minimumInputLength: 1,
			theme : "bootstrap",
			templateResult: (data) => {
				if (data.loading) {
					return data.text;
				}

				var markup = "<div class='clearfix'>";
				markup += "<strong><h5>"+ data.text+" </h5></strong>\n Provider: "+data.provider+" <br>Harga: "+convertToRupiah(data.harga)+"<br>Stok sekarang: "+data.stok+
				"</div>";

				return markup;
			},
			templateSelection: (data) => {
				$('#input-harga-alat-bahan-sekali-pakai').val(data.harga);
				$('#input-jumlah-alat-bahan-sekali-pakai').attr(
				{
					"max" : data.stok
				}
				);

				if (typeof(data.sediaan) !== 'undefined') {
					$('#input-jumlah-alat-bahan-sekali-pakai').attr(
					{
						"placeholder" : "contoh : 2 ( maksimal : "+ data.stok+")"
					}
					);
				}
				$('#input-harga-per-item-alat-bahan-sekali-pakai').val($('#input-jumlah-alat-bahan-sekali-pakai').val() * $('#input-harga-alat-bahan-sekali-pakai').val());
				if (typeof data.provider !== 'undefined') {
					return data.text+" "+data.provider;
				}else{
					return data.text;
				}
			},
			placeholder: "Pilih logistik"
		});

		hitungTotal()
	});
</script>
<script type="text/javascript">
	function convertToRupiah(angka){
		var rupiah = '';		
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
			return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('')+',00';
	}

	function ubahHargaObatInjeksi() {		$("#input-harga-per-item-obat-injeksi").val($("#input-harga-obat-injeksi").val() * $("#input-jumlah-obat-injeksi").val());	}

	function ubahHargaObatSigmaUsusExternum() {		$("#input-harga-per-item-obat-sigma-usus-externum").val($("#input-harga-obat-sigma-usus-externum").val() * $("#input-jumlah-obat-sigma-usus-externum").val());	}

	function ubahHargaObatOral() {		$("#input-harga-per-item-obat-oral").val($("#input-harga-obat-oral").val() * $("#input-jumlah-obat-oral").val());	}

	function ubahHargaAlatBahanSekaliPakai() {		$("#input-harga-per-item-alat-bahan-sekali-pakai").val($("#input-harga-alat-bahan-sekali-pakai").val() * $("#input-jumlah-alat-bahan-sekali-pakai").val());	}

	function addObatInjeksi() {
		var totalBayarObatInjeksi = 0;

		$.post(
			"<?=base_url()?>Dokter/masukkanTroli",
			{
				jenis_logistik	: "obat_injeksi",
				id_logistik		: $("#select-obat-injeksi").val(),
				jumlah 			: $("#input-jumlah-obat-injeksi").val(),
				harga 			: $("#input-harga-obat-injeksi").val(),
				id_pasien 		: $('#id-pasien').val()
			},function(res){
				var elementToRender = "";
				elementToRender += 
				"<table class='table table-bordered'>"+
				"<thead>"+
				"<tr>"+
				"<th scope='col'>Nama Obat</th>"+
				"<th scope='col'>Bentuk</th>"+
				"<th scope='col'>Sediaan</th>"+
				"<th scope='col'>Jumlah</th>"+
				"<th scope='col'>Subtotal</th>"+
				"</tr>"+
				"</thead>"+
				"<tbody>"
				for (var i = res.length - 1; i >= 0; i--) {
					totalBayarObatInjeksi += res[i].subtotal
					elementToRender +=
					"<tr>"+
					"<th scope='row'>"+res[i].nama+"</th>"+
					"<td>"+res[i].bentuk+"</td>"+
					"<td>"+res[i].sediaan+"</td>"+
					"<td>"+res[i].jumlah+"</td>"+
					"<td>"+res[i].subtotal+"</td>"+
					"</tr>"
				}
				elementToRender += 
				"</tbody>"+
				"</table>"

				$("#tabel-obat-injeksi-yang-sudah-diambil").html("")
				$("#tabel-obat-injeksi-yang-sudah-diambil").html(elementToRender)

				var obat_injeksi_yang_terpilih = $('#select-obat-injeksi').select2('data')[0]
				
				// tambahkan titik jika di teksarea sudah ada isinya.
				var tambah_separator_titik = '';
				if ($.trim($("#textarea-planning-pemeriksaan").val())) {
					tambah_separator_titik = '. ';
				}
				document.getElementById('textarea-planning-pemeriksaan').value += (tambah_separator_titik+$("#input-jumlah-obat-injeksi").val()+' '+obat_injeksi_yang_terpilih.bentuk+' '+obat_injeksi_yang_terpilih.text+' '+obat_injeksi_yang_terpilih.sediaan+' '+convertToRupiah($("#input-harga-per-item-obat-injeksi").val()))

				// reset form add obat injeksi
				$("#select-obat-injeksi").val("").trigger("change")
				$("#input-jumlah-obat-injeksi").val("")
				$("#input-jumlah-obat-injeksi").attr("placeholder","")
				$("#input-harga-obat-injeksi").val("")
				$("#input-harga-per-item-obat-injeksi").val("")

				// tampilkan penjumlahan obat untuk obat injeksi doang
				$("#total-harga-obat-injeksi").html()
				$("#total-harga-obat-injeksi").html(totalBayarObatInjeksi)
				hitungTotal()
				$('#select-obat-injeksi').html(null);
			},"json"
			)
	}

	function addObatOral() {
		var totalBayarObatOral = 0;

		$.post(
			"<?=base_url()?>Dokter/masukkanTroli",
			{
				jenis_logistik	: "obat_oral",
				id_logistik		: $("#select-obat-oral").val(),
				jumlah 			: $("#input-jumlah-obat-oral").val(),
				harga 			: $("#input-harga-obat-oral").val(),
				id_pasien 		: $('#id-pasien').val()
			},function(res){
				var elementToRender = "";
				elementToRender += 
				"<table class='table table-bordered'>"+
				"<thead>"+
				"<tr>"+
				"<th scope='col'>Nama Obat</th>"+
				"<th scope='col'>Bentuk</th>"+
				"<th scope='col'>Sediaan</th>"+
				"<th scope='col'>Jumlah</th>"+
				"<th scope='col'>Subtotal</th>"+
				"</tr>"+
				"</thead>"+
				"<tbody>"
				for (var i = res.length - 1; i >= 0; i--) {
					totalBayarObatOral += res[i].subtotal
					elementToRender +=
					"<tr>"+
					"<th scope='row'>"+res[i].nama+"</th>"+
					"<td>"+res[i].bentuk+"</td>"+
					"<td>"+res[i].sediaan+"</td>"+
					"<td>"+res[i].jumlah+"</td>"+
					"<td>"+res[i].subtotal+"</td>"+
					"</tr>"
				}
				elementToRender += 
				"</tbody>"+
				"</table>"
				$("#tabel-obat-oral-yang-sudah-diambil").html("")
				$("#tabel-obat-oral-yang-sudah-diambil").html(elementToRender)

				var obat_oral_yang_terpilih = $('#select-obat-oral').select2('data')[0]
				// tambahkan titik jika di teksarea sudah ada isinya.
				var tambah_separator_titik = '';
				if ($.trim($("#textarea-planning-pemeriksaan").val())) {
					tambah_separator_titik = '. ';
				}
				document.getElementById('textarea-planning-pemeriksaan').value += (tambah_separator_titik+$("#input-jumlah-obat-oral").val()+' '+obat_oral_yang_terpilih.bentuk+' '+obat_oral_yang_terpilih.text+' '+obat_oral_yang_terpilih.sediaan+' '+convertToRupiah($("#input-harga-per-item-obat-oral").val()))

				// reset form add obat oral
				$("#select-obat-oral").val("").trigger("change")
				$("#input-jumlah-obat-oral").val("")
				$("#input-jumlah-obat-oral").attr("placeholder","")
				$("#input-harga-obat-oral").val("")
				$("#input-harga-per-item-obat-oral").val("")

				// tampilkan penjumlahan obat untuk obat oral doang
				$("#total-harga-obat-oral").html()
				$("#total-harga-obat-oral").html(totalBayarObatOral)
				hitungTotal()
				$('#select-obat-oral').html(null);
			}
			,"json")
	}

	function addObatSigmaUsusExternum() {
		var totalBayarObatSigmaUsusExternum = 0;

		$.post(
			"<?=base_url()?>Dokter/masukkanTroli",
			{
				jenis_logistik	: "obat_sigma_usus_externum",
				id_logistik		: $("#select-obat-sigma-usus-externum").val(),
				jumlah 			: $("#input-jumlah-obat-sigma-usus-externum").val(),
				harga 			: $("#input-harga-obat-sigma-usus-externum").val(),
				id_pasien 		: $('#id-pasien').val()
			},function(res){
				var elementToRender = "";
				elementToRender += 
				"<table class='table table-bordered'>"+
				"<thead>"+
				"<tr>"+
				"<th scope='col'>Nama Obat</th>"+
				"<th scope='col'>Bentuk</th>"+
				"<th scope='col'>Sediaan</th>"+
				"<th scope='col'>Jumlah</th>"+
				"<th scope='col'>Subtotal</th>"+
				"</tr>"+
				"</thead>"+
				"<tbody>"
				for (var i = res.length - 1; i >= 0; i--) {
					totalBayarObatSigmaUsusExternum += res[i].subtotal
					elementToRender +=
					"<tr>"+
					"<th scope='row'>"+res[i].nama+"</th>"+
					"<td>"+res[i].bentuk+"</td>"+
					"<td>"+res[i].sediaan+"</td>"+
					"<td>"+res[i].jumlah+"</td>"+
					"<td>"+res[i].subtotal+"</td>"+
					"</tr>"
				}
				elementToRender += 
				"</tbody>"+
				"</table>"
				$("#tabel-obat-sigma-usus-externum-yang-sudah-diambil").html("")
				$("#tabel-obat-sigma-usus-externum-yang-sudah-diambil").html(elementToRender)

				var obat_sigma_usus_externum_yang_terpilih = $('#select-obat-sigma-usus-externum').select2('data')[0]
				// tambahkan titik jika di teksarea sudah ada isinya.
				var tambah_separator_titik = '';
				if ($.trim($("#textarea-planning-pemeriksaan").val())) {
					tambah_separator_titik = '. ';
				}
				document.getElementById('textarea-planning-pemeriksaan').value += (tambah_separator_titik+$("#input-jumlah-obat-sigma-usus-externum").val()+' '+obat_sigma_usus_externum_yang_terpilih.bentuk+' '+obat_sigma_usus_externum_yang_terpilih.text+' '+obat_sigma_usus_externum_yang_terpilih.sediaan+' '+convertToRupiah($("#input-harga-per-item-obat-sigma-usus-externum").val()))

				// reset form add obat sigma-usus-externum
				$("#obatsigmaususexternum").val("").trigger("change")
				$("#input-jumlah-obat-sigma-usus-externum").val("")
				$("#input-jumlah-obat-sigma-usus-externum").attr("placeholder","")
				$("#input-harga-obat-sigma-usus-externum").val("")
				$("#input-harga-per-item-obat-sigma-usus-externum").val("")

				// tampilkan penjumlahan obat untuk obat sigma-usus-externum doang
				$("#total-harga-obat-sigma-usus-externum").html()
				$("#total-harga-obat-sigma-usus-externum").html(totalBayarObatSigmaUsusExternum)
				hitungTotal()
				$('#select-obat-sigma-usus-externum').html(null);
			},
			"json")
	}

	function addObatAlatBahanSekaliPakai() {
		var totalBayarObatAlatBahanSekaliPakai = 0;

		$.post(
			"<?=base_url()?>Dokter/masukkanTroli",
			{
				jenis_logistik	: "alat_bahan_sekali_pakai",
				id_logistik		: $("#select-alat-bahan-sekali-pakai").val(),
				jumlah 			: $("#input-jumlah-alat-bahan-sekali-pakai").val(),
				harga 			: $("#input-harga-alat-bahan-sekali-pakai").val(),
				id_pasien 		: $('#id-pasien').val()
			},function(res){
				var elementToRender = "";
				elementToRender += 
				"<table class='table table-bordered'>"+
				"<thead>"+
				"<tr>"+
				"<th scope='col'>Nama Obat</th>"+
				"<th scope='col'>Bentuk</th>"+
				"<th scope='col'>Sediaan</th>"+
				"<th scope='col'>Jumlah</th>"+
				"<th scope='col'>Subtotal</th>"+
				"</tr>"+
				"</thead>"+
				"<tbody>"
				for (var i = res.length - 1; i >= 0; i--) {
					totalBayarObatAlatBahanSekaliPakai += res[i].subtotal
					elementToRender +=
					"<tr>"+
					"<th scope='row'>"+res[i].nama+"</th>"+
					"<td>"+res[i].bentuk+"</td>"+
					"<td>"+res[i].sediaan+"</td>"+
					"<td>"+res[i].jumlah+"</td>"+
					"<td>"+res[i].subtotal+"</td>"+
					"</tr>"
				}
				elementToRender += 
				"</tbody>"+
				"</table>"
				$("#tabel-alat-bahan-sekali-pakai-yang-sudah-diambil").html("")
				$("#tabel-alat-bahan-sekali-pakai-yang-sudah-diambil").html(elementToRender)

				// masukkan ke kolom planning
				var alat_bahan_sekali_pakai_yang_terpilih = $('#select-alat-bahan-sekali-pakai').select2('data')[0]
				// tambahkan titik jika di teksarea sudah ada isinya.
				var tambah_separator_titik = '';
				if ($.trim($("#textarea-planning-pemeriksaan").val())) {
					tambah_separator_titik = '. ';
				}
				document.getElementById('textarea-planning-pemeriksaan').value += (tambah_separator_titik+$("#input-jumlah-alat-bahan-sekali-pakai").val()+' '+alat_bahan_sekali_pakai_yang_terpilih.text+' '+alat_bahan_sekali_pakai_yang_terpilih.provider+' '+convertToRupiah($("#input-harga-per-item-alat-bahan-sekali-pakai").val()))

				// reset form add obat sigma-usus-externum
				$("#select-alat-bahan-sekali-pakai").val("").trigger("change")
				$("#input-jumlah-alat-bahan-sekali-pakai").val("")
				$("#input-jumlah-alat-bahan-sekali-pakai").attr("placeholder","")
				$("#input-harga-alat-bahan-sekali-pakai").val("")
				$("#input-harga-per-item-alat-bahan-sekali-pakai").val("")

				// tampilkan penjumlahan obat untuk obat sigma-usus-externum doang
				$("#total-harga-alat-bahan-sekali-pakai").html()
				$("#total-harga-alat-bahan-sekali-pakai").html(totalBayarObatAlatBahanSekaliPakai)
				hitungTotal()
				$('#select-alat-bahan-sekali-pakai').html(null);
			},
			"json")
	}

	function hitungTotal() 
	{
		var total = 0
		if ($("#total-harga-obat-injeksi").html() !== "") {
			total += parseInt($("#total-harga-obat-injeksi").html(),10)
		}
		if ($("#total-harga-obat-oral").html() !== "") {
			total += parseInt($("#total-harga-obat-oral").html(),10)
		}

		if ($("#total-harga-obat-sigma-usus-externum").html() !== "") {
			total += parseInt($("#total-harga-obat-sigma-usus-externum").html(),10)
		}

		if ($("#total-harga-alat-bahan-sekali-pakai").html() !== "") {
			total += parseInt($("#total-harga-alat-bahan-sekali-pakai").html(),10)
		}

		total += parseInt($("#biaya_dokter").val(),10)

		$("#total").val(convertToRupiah(total))
	}

	// setting tampilan live clock
	var serverTime = new Date(<?php print date('Y, m, d, H, i, s, 0'); ?>);
	var clientTime = new Date();
	var Diff = serverTime.getTime() - clientTime.getTime();    

	function displayServerTime(){
		var clientTime = new Date();
		var time = new Date(clientTime.getTime() + Diff);
		var sh = time.getHours().toString();
		var sm = time.getMinutes().toString();
		var ss = time.getSeconds().toString();
		document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
	}

	// set nilai tanggal terakhir setelah pengesetan durasi pada form surat sakit
	function updateTglAkhir() {
		// function untuk update tanggal akhir
		var tanggal_awal 	= document.getElementById("tanggal_awal").value;
		var jumlah			= document.getElementById("selama").value;
		var date 			= new Date(tanggal_awal);
		var newdate			= new Date(date);
		var selama_satuan 	= document.getElementById("selama_satuan").value;
		
		// bagian yang ngeset tanggal terakhir berdsarkan satuan HARI|MINGGU|BULAN yang dipilih
		if (selama_satuan == 'hari') {
			newdate.setDate(newdate.getDate() + parseInt(jumlah));
		}else if (selama_satuan == 'minggu') {
			newdate.setDate(newdate.getDate() + (parseInt(jumlah) * 7));
		}else if (selama_satuan == 'bulan') {
			newdate.setMonth(newdate.getMonth() + parseInt(jumlah));
		}

		// finishing set tanggal terakhir untuk ditampilkan
		var dd 	= newdate.getDate();
		var mm 	= newdate.getMonth() + 1;
		var y 	= newdate.getFullYear();
		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		}
		document.getElementById("tanggal_akhir").value = y+'-'+mm+'-'+dd;
	}

	// setelah cetak surat sakit, tambahkan nomor surat sakit yang telah tercetak ke kolom planning untuk dokumnetasi lebih jelas
	function SuratSakit() {
		var jqxhr = $.get( "<?=base_url()?>get-tabel-surat-sakit/<?=$pasien[0]->id?>", function(data) {
			data = JSON.parse(data);
			if (data[0].nomor_surat < 10 ) {
				data[0].nomor_surat = "00"+data[0].nomor_surat;
			}else if(data[0].nomor_surat < 100){
				data[0].nomor_surat = "0"+data[0].nomor_surat;
			}else{
				data[0].nomor_surat = data[0].nomor_surat;
			}
			if(document.getElementById('textarea-planning-pemeriksaan').value !== ''){
				document.getElementById('textarea-planning-pemeriksaan').value += ",";
			}
			document.getElementById('textarea-planning-pemeriksaan').value += " Surat Sakit : "+ data[0].nomor_surat +" / 002 / 0"+ data[0].tanggal.substring(5, 7) +" / "+ data[0].tanggal.substring(0, 4) +" ";
		})
		.fail(function() {
			alert( "error" );
		})
	}

	// function untuk menyalurkan tinggi badan via submit form surat sehat. executenya nyalip open blank page.
	function formSuratSehat() {
		alert("formsuratsehat")
		document.getElementById('sistol-sehat').value 			= document.getElementById('sistol-pemeriksaan').value;
		document.getElementById('diastol-sehat').value 			= document.getElementById('diastol-pemeriksaan').value;
		if (document.getElementById('tinggi-badan-pemeriksaan').value !== 'undefined' && document.getElementById('berat-badan-pemeriksaan').value !== 'undefined' && document.getElementById('nadi-pemeriksaan').value !== 'undefined' && document.getElementById('respiratory-rate-pemeriksaan').value !== 'undefined' && document.getElementById('temperature-ax-pemeriksaan').value !== 'undefined') {
			document.getElementById('tinggi-badan-sehat').value 	= document.getElementById('tinggi-badan-pemeriksaan').value;
			document.getElementById('berat-badan-sehat').value 		= document.getElementById('berat-badan-pemeriksaan').value;
			document.getElementById('nadi-sehat').value 			= document.getElementById('nadi-pemeriksaan').value;
			document.getElementById('respiratory-rate-sehat').value = document.getElementById('respiratory-rate-pemeriksaan').value;
			document.getElementById('temperature-ax-sehat').value 	= document.getElementById('temperature-ax-pemeriksaan').value;
			return true;
		}else{
			alert('Mohon lengkapi data pemeriksaan objektif kecuali Head To Toe');
			return false;

		}
	}

	// setelah cetak surat sehat, tambahkan nomor surat sakit yang telah tercetak ke kolom planning untuk dokumnetasi lebih jelas
	function SuratSehat() {	
		// alert("message?: DOMString")
		// saat submit cetak surat rujukan, tambahkan nomor surat rujukan yang telah tergenerate ke kolom planning untuk dokumnetasi lebih jelas
		var jqxhr = $.get( "<?=base_url()?>get-tabel-surat-sehat/<?=$pasien[0]->id?>", function(data) {
			data = JSON.parse(data);
			if (data[0].nomor_surat < 10 ) {
				data[0].nomor_surat = "00"+data[0].nomor_surat;
			}else if(data[0].nomor_surat < 100){
				data[0].nomor_surat = "0"+data[0].nomor_surat;
			}else{
				data[0].nomor_surat = data[0].nomor_surat;
			}
			// console.log(document.getElementById('planning').value);
			if(document.getElementById('textarea-planning-pemeriksaan').value !== ''){
				document.getElementById('textarea-planning-pemeriksaan').value += ", ";
			}


			document.getElementById('textarea-planning-pemeriksaan').value += "Surat Sehat : "+ data[0].nomor_surat +" / 001 / 0"+ data[0].tanggal.substring(5, 7) +" / "+ data[0].tanggal.substring(0, 4) +" ";
			
			// if (document.getElementById('kepala-ket-tambahan-pemeriksaan').value !== '') {
			// 	document.getElementById('textarea-planning-pemeriksaan').value += ". ";
			// }

			document.getElementById('kepala-ket-tambahan-pemeriksaan').value += "Tes buta warna : ";
			if (typeof $("input[name='tes_buta_warna']:checked").val() == 'undefined') {
				document.getElementById('kepala-ket-tambahan-pemeriksaan').value += 'Belum diisi ';
			}

			document.getElementById('kepala-ket-tambahan-pemeriksaan').value += ". Untuk keperluan : ";
			if (document.getElementById('keperluan').value == '') {
				document.getElementById('kepala-ket-tambahan-pemeriksaan').value += 'Belum diisi ';
			}
		})
		.fail(function() {
			alert( "error" );
		})
	}

	// saat klik tombol surat rujukan. isi hidden form surat rujukan, karena secara tampilan satu form dengan pemeriksaan tapi secara koding beda tag form
	function formSuratRujukan() {
		// set input type hidden
		$('#nomor-pasien-rujukan').val($('#nomor-pasien').val());
		$('#id-pasien-rujukan').val($('#id-pasien').val());
		
		$('#subjektif-rujukan').val($('#subjektif-pemeriksaan').val());
		$('#gcs-e-rujukan').val($('#gcs-e-pemeriksaan').val());
		$('#gcs-v-rujukan').val($('#gcs-v-pemeriksaan').val());
		$('#gcs-m-rujukan').val($('#gcs-m-pemeriksaan').val());
		
		// set select2 untuk clear all option yang ada di hidden form. (restart). defaultya kosong
		$('#primary-rujukan').val(null).trigger('change');
		$('#secondary-rujukan').val(null).trigger('change');
		$('#lain-rujukan').val(null).trigger('change');
		
		// CREATE DUPLICATE VALUE DARI PRIMARY SELECT ELEMENT PADA FORM PEMERIKSAAN KE FORM RUJUKAN
		var primarySelected = $("#primary_pemeriksaan").select2('data');
		for (i in primarySelected){
			var primaryDescOnly = primarySelected[i].text.split(" / ");
			var newOption = new Option(primaryDescOnly[1], primaryDescOnly[1], true, true);
			$('#primary-rujukan').append(newOption).trigger('change');
		}
		// CREATE DUPLICATE VALUE DARI SECONDARY SELECT ELEMENT PADA FORM PEMERIKSAAN KE FORM RUJUKAN
		var secondarySelected = $("#secondary_pemeriksaan").select2('data');
		for (i in secondarySelected){
			var secondaryDescOnly = secondarySelected[i].text.split(" / ");
			var newOption = new Option(secondaryDescOnly[1], secondaryDescOnly[1], true, true);
			$('#secondary-rujukan').append(newOption).trigger('change');
		}
		// CREATE DUPLICATE VALUE DARI LAINLAIN SELECT ELEMENT PADA FORM PEMERIKSAAN KE FORM RUJUKAN
		var lainlainSelected = $("#lain_pemeriksaan").select2('data');
		for (i in lainlainSelected){
			lainlainDescOnly = lainlainSelected[i].text.split(" / ");
			var newOption = new Option(lainlainDescOnly[1], lainlainDescOnly[1], true, true);
			$('#lain-rujukan').append(newOption).trigger('change');
		}
		// get and set element text area
		var pemeriksaanLab = $("#pemeriksaan_lab_pemeriksaan").val();
		$("#pemeriksaan-lab-rujukan").val(pemeriksaanLab);

		$('#gcs-opsi-cm-rujukan').prop("checked" , $('#gcs-opsi-cm-pemeriksaan').prop("checked"));
		$('#gcs-opsi-apatis-rujukan').prop("checked" , $('#gcs-opsi-apatis-pemeriksaan').prop("checked"))
		$('#gcs-opsi-derilium-rujukan').prop("checked" , $('#gcs-opsi-derilium-pemeriksaan').prop("checked"))
		$('#gcs-opsi-somnolen-rujukan').prop("checked" , $('#gcs-opsi-somnolen-pemeriksaan').prop("checked"))
		$('#gcs-opsi-stupor-rujukan').prop("checked" , $('#gcs-opsi-stupor-pemeriksaan').prop("checked"))
		$('#gcs-opsi-coma-rujukan').prop("checked" , $('#gcs-opsi-coma-pemeriksaan').prop("checked"))

		$('#tinggi-badan-rujukan').val($('#tinggi-badan-pemeriksaan').val());
		$('#berat-badan-rujukan').val($('#berat-badan-pemeriksaan').val());
		$('#sistol-rujukan').val($('#sistol-pemeriksaan').val());
		$('#diastol-rujukan').val($('#diastol-pemeriksaan').val());
		$('#respiratory-rate-rujukan').val($('#respiratory-rate-pemeriksaan').val());
		$('#nadi-rujukan').val($('#nadi-pemeriksaan').val());
		$('#temperature-ax-rujukan').val($('#temperature-ax-pemeriksaan').val());

		$('#anemis-kiri-rujukan').prop("checked" , $('#anemis-kiri-pemeriksaan').prop("checked"))
		$('#anemis-kanan-rujukan').prop("checked" , $('#anemis-kanan-pemeriksaan').prop("checked"))
		$('#ikterik-kiri-rujukan').prop("checked" , $('#ikterik-kiri-pemeriksaan').prop("checked"))
		$('#ikterik-kanan-rujukan').prop("checked" , $('#ikterik-kanan-pemeriksaan').prop("checked"))
		$('#cianosis-kiri-rujukan').prop("checked" , $('#cianosis-kiri-pemeriksaan').prop("checked"))
		$('#cianosis-kanan-rujukan').prop("checked" , $('#cianosis-kanan-pemeriksaan').prop("checked"))
		$('#deformitas-kiri-rujukan').prop("checked" , $('#deformitas-kiri-pemeriksaan').prop("checked"))
		$('#deformitas-kanan-rujukan').prop("checked" , $('#deformitas-kanan-pemeriksaan').prop("checked"))
		$('#refchy-kiri-rujukan').prop("checked" , $('#refchy-kiri-pemeriksaan').prop("checked"))
		$('#refchy-kanan-rujukan').prop("checked" , $('#refchy-kanan-pemeriksaan').prop("checked"))
		$('#kepala-ket-tambahan-rujukan').val($('#kepala-ket-tambahan-pemeriksaan').val());

		$('#wheezing-kiri-rujukan').prop("checked" , $('#wheezing-kiri-pemeriksaan').prop("checked"))
		$('#wheezing-kanan-rujukan').prop("checked" , $('#wheezing-kanan-pemeriksaan').prop("checked"))
		$('#ronkhi-kiri-rujukan').prop("checked" , $('#ronkhi-kiri-pemeriksaan').prop("checked"))
		$('#ronkhi-kanan-rujukan').prop("checked" , $('#ronkhi-kanan-pemeriksaan').prop("checked"))
		$('#vesikuler-kiri-rujukan').prop("checked" , $('#vesikuler-kiri-pemeriksaan').prop("checked"))
		$('#vesikuler-kanan-rujukan').prop("checked" , $('#vesikuler-kanan-pemeriksaan').prop("checked"))
		$('#jantung-suaratambahan-rujukan').val($('#jantung-suaratambahan-pemeriksaan').val());
		$('#jantung-ket-tambahan-rujukan').val($('#jantung-ket-tambahan-pemeriksaan').val());

		$('#nyeri-tekan1-rujukan').prop("checked" , $('#nyeri-tekan1-pemeriksaan').prop("checked"))
		$('#nyeri-tekan2-rujukan').prop("checked" , $('#nyeri-tekan2-pemeriksaan').prop("checked"))
		$('#nyeri-tekan3-rujukan').prop("checked" , $('#nyeri-tekan3-pemeriksaan').prop("checked"))
		$('#nyeri-tekan4-rujukan').prop("checked" , $('#nyeri-tekan4-pemeriksaan').prop("checked"))
		$('#nyeri-tekan5-rujukan').prop("checked" , $('#nyeri-tekan5-pemeriksaan').prop("checked"))
		$('#nyeri-tekan6-rujukan').prop("checked" , $('#nyeri-tekan6-pemeriksaan').prop("checked"))
		$('#nyeri-tekan7-rujukan').prop("checked" , $('#nyeri-tekan7-pemeriksaan').prop("checked"))
		$('#nyeri-tekan8-rujukan').prop("checked" , $('#nyeri-tekan8-pemeriksaan').prop("checked"))
		$('#nyeri-tekan9-rujukan').prop("checked" , $('#nyeri-tekan9-pemeriksaan').prop("checked"))
		$('#hepatomegali-rujukan').val($('#hepatomegali-pemeriksaan').val());
		$('#spleenomegali-rujukan').val($('#spleenomegali-pemeriksaan').val());
		$('#abdomen-ket-tambahan-rujukan').val($('#abdomen-ket-tambahan-pemeriksaan').val());
		$('#akral-hangat1-rujukan').prop("checked" , $('#akral-hangat1-pemeriksaan').prop("checked"))
		$('#akral-hangat2-rujukan').prop("checked" , $('#akral-hangat2-pemeriksaan').prop("checked"))
		$('#akral-hangat3-rujukan').prop("checked" , $('#akral-hangat3-pemeriksaan').prop("checked"))
		$('#akral-hangat4-rujukan').prop("checked" , $('#akral-hangat4-pemeriksaan').prop("checked"))
		$('#crt1-rujukan').prop("checked" , $('#crt1-pemeriksaan').prop("checked"))
		$('#crt2-rujukan').prop("checked" , $('#crt2-pemeriksaan').prop("checked"))
		$('#crt3-rujukan').prop("checked" , $('#crt3-pemeriksaan').prop("checked"))
		$('#crt4-rujukan').prop("checked" , $('#crt4-pemeriksaan').prop("checked"))
		$('#edema1-rujukan').prop("checked" , $('#edema1-pemeriksaan').prop("checked"))
		$('#edema2-rujukan').prop("checked" , $('#edema2-pemeriksaan').prop("checked"))
		$('#edema3-rujukan').prop("checked" , $('#edema3-pemeriksaan').prop("checked"))
		$('#edema4-rujukan').prop("checked" , $('#edema4-pemeriksaan').prop("checked"))
		$('#ekstermitas-kettambahan-rujukan').val($('#ekstermitas-kettambahan-pemeriksaan').val());
		$('#lain-lain-rujukan').val($('#lain-lain-pemeriksaan').val());
		$('#planning-rujukan').val($('#textarea-planning-pemeriksaan').val());
		$('#terapi1-rujukan').val($('#terapi1-pemeriksaan').val());
		$('#terapi2-rujukan').val($('#terapi2-pemeriksaan').val());
		$('#terapi3-rujukan').val($('#terapi3-pemeriksaan').val());

		// untuk bagian opsi checkboxx dll pakai name, nggak mungkin pakai id, karena id itu hatrus unik
		$("input[name='refchy_opsi_rujukan'][value='"+$("input[name=refchy_opsi_pemeriksaan]:checked").val()+"']").prop('checked', true);
		$("input[name='paru_simetris_asimetris_rujukan'][value='"+$("input[name=paru_simetris_asimetris_pemeriksaan]:checked").val()+"']").prop('checked', true);
		$("input[name='jantung_ictuscordis_rujukan'][value='"+$("input[name=jantung_ictuscordis_pemeriksaan]:checked").val()+"']").prop('checked', true);
		$("input[name='jantung_s1_s2_rujukan'][value='"+$("input[name=jantung_s1_s2_pemeriksaan]:checked").val()+"']").prop('checked', true);

		$("input[name='BU_rujukan'][value='"+$("input[name=BU_pemeriksaan]:checked").val()+"']").prop('checked', true);

		$("input[name='pitting_rujukan'][value='"+$("input[name=pitting_pemeriksaan]:checked").val()+"']").prop('checked', true);
		
		$('#headtotoe-rujukan').val($('#headtotoe-pemeriksaan').val());

		$('#suratrujukan')[0].submit();
		setTimeout(function(){
			// saat submit cetak surat rujukan, tambahkan nomor surat rujukan yang telah tergenerate ke kolom planning untuk dokumnetasi lebih jelas
			var jqxhr = $.get( "<?=base_url()?>get-tabel-surat-rujukan/<?=$pasien[0]->id?>", function(data) {
				data = JSON.parse(data);
				if (data[0].nomor_surat < 10 ) {
					data[0].nomor_surat = "00"+data[0].nomor_surat;
				}else if(data[0].nomor_surat < 100){
					data[0].nomor_surat = "0"+data[0].nomor_surat;
				}else{
					data[0].nomor_surat = data[0].nomor_surat;
				}
				// console.log(document.getElementById('planning').value);
				if(document.getElementById('textarea-planning-pemeriksaan').value !== ''){
					document.getElementById('textarea-planning-pemeriksaan').value += ", ";
				}

				document.getElementById('textarea-planning-pemeriksaan').value += "Surat Rujukan : "+ data[0].nomor_surat +" / 003 / 0"+ data[0].tanggal.substring(5, 7) +" / "+ data[0].tanggal.substring(0, 4) +" ";
				
			})
			.fail(function() {
				alert( "error" );
			})
		}, 3000);
	}

</script>
<div class="mt-3 mb-3"><?=$this->session->flashdata('alert')?></div>
<h3 class="text-center mt-3"><strong>Pemeriksaan Dokter</strong></h3>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col text-center">
			<h5><span class="badge <?=($pasien[0]->pembayaran != 'RF') ? 'badge-success' : 'badge-secondary' ?>"><?=$pasien[0]->pembayaran?></span></h5>
		</div>
	</div>
	<div class="row">
		<div class="col" >
			<h5><?php
			$hari 	= array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$bulan 	= array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

			echo $hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y"); ?></h5>	
		</div>
		<div class="col-1">
			<body onload="setInterval('displayServerTime()', 1000);">
				<h5><span id="clock"><?php echo date('H:i:s'); ?></span></h5>
			</body>
		</div>
	</div>
	<div class="row">
		<div class="col-3 border rounded">

			<div class="text-center">
				<h5 class="mt-3 mb-3">Data Pasien</h5>
			</div>

			<div class="row mt-3 text-center">
				<div class="col"><strong><?=$pasien[0]->nomor_pasien?></strong></div>
			</div>

			<div class="row mt-3">
				<div class="col-3">Nama</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->nama?></div>
			</div>

			<div class="row">
				<div class="col-3">NIK</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->nik?></div>
			</div>

			<div class="row">
				<div class="col-3">TTL</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->tempat_lahir?>, <?=tgl_indo($pasien[0]->tanggal_lahir)?></div>
			</div>

			<div class="row mt-3">
				<div class="col-3">Usia</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->usia?> Tahun</div>
			</div>

			<div class="row">
				<div class="col-3">Alamat</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->jalan?></div>
			</div>
			
			<div class="row">
				<div class="col-3">Jenis Kelamin</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->jenis_kelamin?></div>
			</div>

			<div class="row">
				<div class="col-3">Pekerjaan</div>
				<div class="col-1">:</div>
				<div class="col"><?=$pasien[0]->pekerjaan?></div>
			</div>			
		</div>
		<div class="col-9 border rounded">
			<ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="home-tab" href="<?=base_url()?>detail-rekam-medis-pasien/<?=$pasien[0]->id?>" role="tab" target="_blank">Rekam Medis</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" id="pemeriksaan-tab" data-toggle="tab" href="#tab-pemeriksaan" role="tab" aria-controls="pemeriksaan" aria-selected="false">Pemeriksaan</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#surat_sakit" role="tab" aria-controls="surat_sakit" aria-selected="false">Surat Sakit</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#surat_sehat" role="tab" aria-controls="surat_sehat" aria-selected="false">Surat Sehat</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent" >
				
				<!-- TAB PEMERIKSAAN -->
				<div class="tab-pane fade show active" id="tab-pemeriksaan" role="tabpanel" aria-labelledby="tab-pemeriksaan">
					<form method="POST" action="<?=base_url('Dokter/submitPemeriksaan')?>">
						<input type="hidden" name="nomor_pasien" value="<?=$pasien[0]->nomor_pasien?>" id="nomor-pasien">
						<input type="hidden" name="id_pasien" value="<?=$pasien[0]->id?>" id="id-pasien">
						<input type="hidden" name="id_rekam_medis" value="<?=(isset($current_pemeriksaan[0]->id) ? $current_pemeriksaan[0]->id : '')?>" id="id-rekam-medis">
						<div class="container">
							<h5 class="text-center mt-3">Subjektif</h5>
							<textarea class="form-control" aria-label="With textarea" placeholder="Subjektif" name="subjektif" id="subjektif-pemeriksaan"></textarea>
							<hr>

							<h5 class="text-center mt-3">Objektif</h5>
							<!-- START FORM OBJEKTIF -->
							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Tinggi Badan</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control" id="tinggi-badan-pemeriksaan" name="tinggi_badan" value="<?=(isset($current_pemeriksaan[0]->tinggi_badan) ? $current_pemeriksaan[0]->tinggi_badan : '')?>">
												<div class="input-group-append">
													<div class="input-group-text">cm</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Berat Badan</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control" id="berat-badan-pemeriksaan" name="berat_badan" value="<?=(isset($current_pemeriksaan[0]->berat_badan) ? $current_pemeriksaan[0]->berat_badan : '')?>">
												<div class="input-group-append">
													<div class="input-group-text">kg</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-6">
									<div class="row mt-3">
										<div class="col-4">Tekanan Darah</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control mr-1" id="sistol-pemeriksaan" name="sistol" value="<?=(isset($current_pemeriksaan[0]->sistol) ? $current_pemeriksaan[0]->sistol : '')?>" <?=($pasien[0]->pembayaran == 'RF' ? '' : '' )?>>
												/
												<input type="number" class="form-control ml-1" id="diastol-pemeriksaan" name="diastol" value="<?=(isset($current_pemeriksaan[0]->diastol) ? $current_pemeriksaan[0]->diastol : '')?>" <?=($pasien[0]->pembayaran == 'RF' ? '' : '' )?>><div class="input-group-append">
													<div class="input-group-text">mmHg</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row mt-3">
										<div class="col-4">Nadi</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control" id="nadi-pemeriksaan" name="nadi" value="<?=(isset($current_pemeriksaan[0]->nadi) ? $current_pemeriksaan[0]->nadi : '')?>">
												<div class="input-group-append">
													<div class="input-group-text">rpm</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Respiratory R.</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control" id="respiratory-rate-pemeriksaan" name="respiratory_rate" value="<?=(isset($current_pemeriksaan[0]->respiratory_rate) ? $current_pemeriksaan[0]->respiratory_rate : '')?>">
												<div class="input-group-append">
													<div class="input-group-text">rpm</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Temp. Axile</div>
										<div class="col-1">:</div>
										<div class="col">
											<div class="input-group">
												<input type="number" class="form-control" id="temperature-ax-pemeriksaan" name="temperature_ax" value="<?=(isset($current_pemeriksaan[0]->temperature_ax) ? $current_pemeriksaan[0]->temperature_ax : '')?>">
												<div class="input-group-append">
													<div class="input-group-text">&deg;C</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Head To Toe</div>
								<div class="col-1">:</div>
								<div class="col">
									<input type="text" class="form-control" id="headtotoe-pemeriksaan" name="headtotoe">
								</div>
							</div>
							<!-- END FORM OBJEKTIF -->							

							<hr>

							<h5 class="text-center mt-3">Assesment</h5>
							<div class="row mt-3">
								<div class="col-2">Primary</div>
								<div class="col-1">:</div>
								<div class="col-9">
									<select class="select-assessment" id="primary_pemeriksaan" name="assessmentPrimary[]" multiple="multiple" style="width: 99%"></select>
								</div>	
							</div>

							<div class="row mt-3">
								<div class="col-2">Sekunder</div>
								<div class="col-1">:</div>
								<div class="col-9">
									<select class="select-assessment" id="secondary_pemeriksaan" name="assessmentSecondary[]" multiple="multiple" style="width: 99%"></select>
								</div>	
							</div>

							<div class="row mt-3">
								<div class="col-2">Lain-lain</div>
								<div class="col-1">:</div>
								<div class="col-9">
									<select class="select-assessment" id="lain_pemeriksaan" name="assessmentLain[]" multiple="multiple" style="width: 99%"></select>
								</div>	
							</div>

							<div class="row mt-3">
								<div class="col-2">Laboratorium</div>
								<div class="col-1">:</div>
								<div class="col-9">
									<input class="form-control" type="text" name="assessmentPemeriksaanLab" placeholder="Pemeriksaan Laboratorium" id="pemeriksaan_lab_pemeriksaan">
								</div>	
							</div>

							<hr>

							<!-- Start Form GCS -->
							<div class="row mt-3">
								<div class="col-2">GCS</div>
								<div class="col-1">:</div>
								<div class="col"><input type="text" class="form-control" id="gcs-e-pemeriksaan" name="gcs_e" placeholder="E" ></div>
								<div class="col"><input type="text" class="form-control" id="gcs-v-pemeriksaan" name="gcs_v" placeholder="V" ></div>
								<div class="col"><input type="text" class="form-control" id="gcs-m-pemeriksaan" name="gcs_m" placeholder="M" ></div>	
							</div>

							<div class="row mt-3">
								<div class="col-3"></div>
								<div class="col form-check ml-3">
									<input class="form-check-input" type="checkbox" id="gcs-opsi-cm-pemeriksaan" name="gcs_opsi[]" value="CM">
									<label class="form-check-label">CM</label>
								</div>
								<div class="col form-check">
									<input class="form-check-input" type="checkbox" id="gcs-opsi-apatis-pemeriksaan" name="gcs_opsi[]" value="Apatis">
									<label class="form-check-label">Apatis</label>
								</div>
								<div class="col form-check">
									<input class="form-check-input" type="checkbox" id=-gcs_-psi_deri-ium_pemeriksaan" name="gcs_opsi[]" value="Derilium">
									<label class="form-check-label">Derilium</label>
								</div>
							</div>

							<div class="row">
								<div class="col-3"></div>
								<div class="col form-check ml-3">
									<input class="form-check-input" type="checkbox" id="gcs-opsi-somnolen-pemeriksaan" name="gcs_opsi[]" value="Somnolen">
									<label class="form-check-label">Somnolen</label>
								</div>
								<div class="col form-check">
									<input class="form-check-input" type="checkbox" id="gcs-opsi-stupor-pemeriksaan" name="gcs_opsi[]" value="Stupor">
									<label class="form-check-label">Stupor</label>
								</div>
								<div class="col form-check">
									<input class="form-check-input" type="checkbox" id="gcs-opsi-coma-pemeriksaan" name="gcs_opsi[]" value="Coma">
									<label class="form-check-label">Coma</label>
								</div>
							</div>
							<!-- End Form GCS -->
							<hr>
							<!-- KEPALA -->							
							<h5 class="text-center mt-3">Head Toe To</h5>
							<h6 class="text-center">Kepala</h6>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Anemis</div>
										<div class="col-1">:</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="anemis-kiri-pemeriksaan" name="anemis_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="anemis-kanan-pemeriksaan" name="anemis_kanan" value="1">
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Ikterik</div>
										<div class="col-1">:</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="ikterik-kiri-pemeriksaan" name="ikterik_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="ikterik-kanan-pemeriksaan" name="ikterik_kanan" value="1">
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Cianosis</div>
										<div class="col-1">:</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="cianosis-kiri-pemeriksaan" name="cianosis_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="cianosis-kanan-pemeriksaan" name="cianosis_kanan" value="1">
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Deformitas</div>
										<div class="col-1">:</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="deformitas-kiri-pemeriksaan" name="deformitas_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="deformitas-kanan-pemeriksaan" name="deformitas_kanan" value="1">
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Reflek Cahaya</div>
										<div class="col-1">:</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="refchy-kiri-pemeriksaan" name="refchy_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-2 mt-2">
											<input type="checkbox" class="form-control" id="refchy-kanan-pemeriksaan" name="refchy_kanan" value="1">
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col">Isokor</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="refchy-opsi-pemeriksaan" name="refchy_opsi_pemeriksaan" value="Isokor"></div>
										<div class="col ml">Anisokor</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="refchy-opsi-pemeriksaan" name="refchy_opsi_pemeriksaan" value="Anisokor"></div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Ket. Tambahan</div>
								<div class="col-1">:</div>
								<div class="col">
									<input class="form-control" type="text" name="kepala_ket_tambahan" placeholder="Keterangan tambahan kepala" id="kepala-ket-tambahan-pemeriksaan">
								</div>		
							</div>
							<!-- END KEPALA -->							
							<hr>
							<!-- THORAK -->
							<h6 class="text-center mt-3">Thorak</h6>
							<h6 class="text-center">Paru</h6>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col">Simetris</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="paru-simetris-asimetris-pemeriksaan" name="paru_simetris_asimetris_pemeriksaan" value="Simetris"></div>
										<div class="col ml">Asimetris</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="paru-simetris-asimetris-pemeriksaan" name="paru_simetris_asimetris_pemeriksaan" value="Asimetris"></div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Wheezing</div>
										<div class="col-1">:</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="wheezing-kiri-pemeriksaan" name="wheezing_kiri" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="wheezing-kanan-pemeriksaan" name="wheezing_kanan" value="1">
										</div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Ronkhi</div>
										<div class="col-1">:</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="ronkhi-kiri-pemeriksaan" name="ronkhi_kiri" placeholder="" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="ronkhi-kanan-pemeriksaan" name="ronkhi_kanan" placeholder="" value="1">
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Vesikular</div>
										<div class="col-1">:</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="vesikuler-kiri-pemeriksaan" name="vesikuler_kiri" placeholder="" value="1">
										</div>
										<div class="col-1">/</div>
										<div class="col-3 mt-2">
											<input type="checkbox" class="form-control" id="vesikuler-kanan-pemeriksaan" name="vesikuler_kanan" placeholder="" value="1">
										</div>
									</div>
								</div>
							</div>
							<!-- END THORAK -->

							<hr>
							<!-- JANTUNG -->
							<h6 class="text-center mt-3">Jantung</h6>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Tampak</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="" name="jantung_ictuscordis_pemeriksaan" value="Tampak"></div>
										<div class="col-4ml">Tak Tampak</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="" name="jantung_ictuscordis_pemeriksaan" value="Tak Tampak"></div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col">Reguler</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="" name="jantung_s1_s2_pemeriksaan" value="Reguler"></div>
										<div class="col ml">Irreguler</div>
										<div class="col mt-2"><input type="radio" class="form-control" id="" name="jantung_s1_s2_pemeriksaan" value="Irreguler"></div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-6">
									<div class="row">
										<div class="col-4">Suara Tambahan</div>
										<div class="col-1">:</div>
										<div class="col">
											<input type="text" class="form-control" id="jantung-suaratambahan-pemeriksaan" name="jantung_suaratambahan">
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="row">
										<div class="col-4">Keterangan Tambahan</div>
										<div class="col-1">:</div>
										<div class="col">
											<input type="text" class="form-control" id="jantung-ket-tambahan-pemeriksaan" name="thorak_ket_tambahan">
										</div>
									</div>
								</div>
							</div>
							<!-- END JANTUNG -->

							<hr>
							<!-- ABDOMEN -->
							<h6 class="text-center mt-3">Abdomen</h6>

							<div class="row mt-3">
								<div class="col-2">BU</div>
								<div class="col-1">:</div>
								<div class="col-1">Normal</div>
								<div class="col-1 mt-2"><input type="radio" class="form-control" id="" name="BU_pemeriksaan" placeholder="" value="Normal"></div>
								<div class="col-1">Menurun</div>
								<div class="col-1 mt-2"><input type="radio" class="form-control" id="" name="BU_pemeriksaan" placeholder="" value="Menurun"></div>
								<div class="col-1">Meningkat</div>
								<div class="col-1 mt-2"><input type="radio" class="form-control" id="" name="BU_pemeriksaan" placeholder="" value="Meningkat"></div>
								<div class="col-1">Negatif</div>
								<div class="col-1 mt-2"><input type="radio" class="form-control" id="" name="BU_pemeriksaan" placeholder="" value="Negatif"></div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Nyeri Tekan</div>
								<div class="col-1">:</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan1-pemeriksaan" name="nyeri_tekan1" value="1">
									<label class="form-check-label">1</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan2-pemeriksaan" name="nyeri_tekan2" value="1">
									<label class="form-check-label">2</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan3-pemeriksaan" name="nyeri_tekan3" value="1">
									<label class="form-check-label">3</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan4-pemeriksaan" name="nyeri_tekan4" value="1">
									<label class="form-check-label">4</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan5-pemeriksaan" name="nyeri_tekan5" value="1">
									<label class="form-check-label">5</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan6-pemeriksaan" name="nyeri_tekan6" value="1">
									<label class="form-check-label">6</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan7-pemeriksaan" name="nyeri_tekan7" value="1">
									<label class="form-check-label">7</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan8-pemeriksaan" name="nyeri_tekan8" value="1">
									<label class="form-check-label">8</label>
								</div><div class="col-1">
									<input class="form-check-input" type="checkbox" id="nyeri-tekan9-pemeriksaan" name="nyeri_tekan9" value="1">
									<label class="form-check-label">9</label>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Hepatomegali</div>
								<div class="col-1">:</div>
								<div class="col">
									<input type="text" class="form-control" id="hepatomegali-pemeriksaan" name="hepatomegali" placeholder="">
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Spleenomegali</div>
								<div class="col-1">:</div>
								<div class="col-9">
									<input type="text" class="form-control" id="spleenomegali-pemeriksaan" name="spleenomegali" placeholder="">
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-2">Keterangan Tambahan Abdomen</div>
								<div class="col-1">:</div>
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="abdomen-ket-tambahan-pemeriksaan" name="abdomen_ket_tambahan" placeholder="Keterangan Tambahan" ></textarea>
								</div>
							</div>
							<!-- END ABDOMEN -->
							<hr>
							<!-- EKSTERMITAS -->

							<h6 class="text-center mt-3">Ekstermitas</h6>
							<div class="row mt-3">
								<div class="col-2">Akral Hangat</div>
								<div class="col-1">:</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="akral-hangat1-pemeriksaan" name="akral_hangat_1" value="1">
									<label class="form-check-label">1</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="akral-hangat2-pemeriksaan" name="akral_hangat_2" value="1">
									<label class="form-check-label">2</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="akral-hangat3-pemeriksaan" name="akral_hangat_3" value="1">
									<label class="form-check-label">3</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="akral-hangat4-pemeriksaan" name="akral_hangat_4" value="1">
									<label class="form-check-label">4</label>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">CRT</div>
								<div class="col-1">:</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="crt1-pemeriksaan" name="crt_1" value="1">
									<label class="form-check-label">1</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="crt2-pemeriksaan" name="crt_2" value="1">
									<label class="form-check-label">2</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="crt3-pemeriksaan" name="crt_3" value="1">
									<label class="form-check-label">3</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="crt4-pemeriksaan" name="crt_4" value="1">
									<label class="form-check-label">4</label>
								</div>
								<div class="col-1">/</div>
								<div class="col-2">2 Detik</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Edema</div>
								<div class="col-1">:</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="edema1-pemeriksaan" name="edema_1" value="1">
									<label class="form-check-label">1</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="edema2-pemeriksaan" name="edema_2" value="1">
									<label class="form-check-label">2</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="edema3-pemeriksaan" name="edema_3" value="1">
									<label class="form-check-label">3</label>
								</div>
								<div class="col-1">
									<input class="form-check-input" type="checkbox" id="edema4-pemeriksaan" name="edema_4" value="1">
									<label class="form-check-label">4</label>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Ekstermitas</div>
								<div class="col-1">:</div>
								<div class="col">
									<input class="form-check-input" type="radio" name="pitting_pemeriksaan" value="Non-pitting">
									<label class="form-check-label">Non-pitting</label>
								</div>
								<div class="col">
									<input class="form-check-input" type="radio" name="pitting_pemeriksaan" value="Pitting">
									<label class="form-check-label">Pitting</label>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Keterangan Tambahan Ekstermitas</div>
								<div class="col-1">:</div>
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="ekstermitas-kettambahan-pemeriksaan" name="ekstermitas_ket_tambahan" placeholder="Keterangan Tambahan"></textarea>
								</div>
							</div>
							<!-- EKSTERMITAS -->

							<hr>

							<h6 class="text-center mt-3">Lain-lain</h6>

							<div class="row mt-3">
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="lain-lain-pemeriksaan" name="lain_lain" placeholder="Lain-lain"></textarea>
								</div>
							</div>

							<hr>
							<h5 class="text-center mt-3">Planing</h5>
							<textarea class="form-control" aria-label="With textarea" placeholder="Planing" id="textarea-planning-pemeriksaan" name="planning"></textarea>

							<hr>
							<h6 class="text-center mt-3">Terapi</h6>

							<div class="row mt-3">
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="terapi1-pemeriksaan" name="terapi_1" placeholder="Terapi 1"></textarea>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="terapi2-pemeriksaan" name="terapi_2" placeholder="Terapi 2"></textarea>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<textarea class="form-control" aria-label="With textarea" id="terapi3-pemeriksaan" name="terapi_3" placeholder="Terapi 3"></textarea>
								</div>
							</div>
							<hr>

							<div class="card">
								<div class="card-body" >
									<h6 class="text-center mt-3">Logistik alat bahan sekali pakai</h6>
									<div class="mt-3" id="tabel-alat-bahan-sekali-pakai-yang-sudah-diambil">
									</div>
									<div class="mt-3">
										<div class="card card-body mt-3 mb-3">
											<div class="row mt-1">
												<select class="form-control" style="height: 90%" id="select-alat-bahan-sekali-pakai">
													<option></option>
												</select>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-jumlah-alat-bahan-sekali-pakai" min="1" onkeyup="ubahHargaAlatBahanSekaliPakai()"></input>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-harga-alat-bahan-sekali-pakai" readonly=""></input>
											</div>
											<div class="row mt-1">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">Rp. </span>
													</div>
													<input type="number" class="form-control text-right" id="input-harga-per-item-alat-bahan-sekali-pakai" ></input>
												</div>
											</div>
											<div class="row mt-1">
												<button type="button" class="btn btn-primary" onclick="addObatAlatBahanSekaliPakai()">+</button>
											</div>
										</div>
									</div>
									<div class="text-right">Total Alat bahan sekali pakai<div id="total-harga-alat-bahan-sekali-pakai"></div></div>
								</div>
							</div>
							
							<hr>

							<div class="card">
								<div class="card-body" >
									<h6 class="text-center mt-3">Logistik obat injeksi</h6>
									<div class="mt-3" id="tabel-obat-injeksi-yang-sudah-diambil">
									</div>
									<div class="mt-3">
										<div class="card card-body mt-3 mb-3">
											<div class="row mt-1">
												<select class="obat-injeksi form-control" style="height: 90%" id="select-obat-injeksi">
													<option selected="" disabled="">Pilih logistik</option>
												</select>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-jumlah-obat-injeksi" min="1" onkeyup="ubahHargaObatInjeksi()"></input>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-harga-obat-injeksi" readonly=""></input>
											</div>
											<div class="row mt-1">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">Rp. </span>
													</div>
													<input type="number" class="form-control text-right" id="input-harga-per-item-obat-injeksi" ></input>
												</div>
											</div>
											<div class="row mt-1">
												<button type="button" class="btn btn-primary" onclick="addObatInjeksi()">+</button>
											</div>
										</div>
									</div>

									<div class="text-right">Total Obat Injeksi<div id="total-harga-obat-injeksi"></div></div>
								</div>
							</div>

							<hr>

							<div class="card">
								<div class="card-body" >
									<h6 class="text-center mt-3">Logistik obat oral</h6>
									<div class="mt-3" id="tabel-obat-oral-yang-sudah-diambil"> 
									</div>
									<div class="mt-3">
										<div class="card card-body mt-3 mb-3">
											<div class="row mt-1">
												<select class="obat-oral form-control" style="height: 90%" id="select-obat-oral">
													<option selected="" disabled="">Pilih logistik</option>
												</select>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-jumlah-obat-oral" min="1" onkeyup="ubahHargaObatOral()"></input>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-harga-obat-oral" readonly=""></input>
											</div>
											<div class="row mt-1">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">Rp. </span>
													</div>
													<input type="number" class="form-control text-right" id="input-harga-per-item-obat-oral" ></input>
												</div>
											</div>
											<div class="row mt-1">
												<button type="button" class="btn btn-primary" onclick="addObatOral()">+</button>
											</div>
										</div>
									</div>							
									<div class="text-right">Total Obat Oral<div id="total-harga-obat-oral"></div></div>
								</div>
							</div>

							<hr>

							<div class="card">
								<div class="card-body" >
									<h6 class="text-center mt-3">Logistik obat S.UE</h6>
									<div class="mt-3" id="tabel-obat-sigma-usus-externum-yang-sudah-diambil">					
									</div>
									<div class="mt-3">
										<div class="card card-body mt-3 mb-3">
											<div class="row mt-1">
												<select class="obat-sigma-usus-externum form-control" style="height: 90%" id="select-obat-sigma-usus-externum">
													<option selected="" disabled="">Pilih logistik</option>
												</select>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-jumlah-obat-sigma-usus-externum" min="1" onkeyup="ubahHargaObatSigmaUsusExternum()"></input>
											</div>
											<div class="row mt-1">
												<input type="number" class="form-control" id="input-harga-obat-sigma-usus-externum" readonly=""></input>
											</div>
											<div class="row mt-1">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">Rp. </span>
													</div>
													<input type="number" class="form-control text-right" id="input-harga-per-item-obat-sigma-usus-externum" ></input>
												</div>
											</div>
											<div class="row mt-1">
												<button type="button" class="btn btn-primary" onclick="addObatSigmaUsusExternum()">+</button>
											</div>
										</div>
									</div>
									<div class="text-right">Total Obat S.UE<div id="total-harga-obat-sigma-usus-externum"></div></div>
								</div>
							</div>
							<hr>



							<div class="row mt-3">
								<div class="col">
									<h6 class="text-left mt-3">Biaya Dokter</h6>
								</div>
								<div class="col-3 float-right">
									<input type="number" class="form-control" name="biaya_dokter" onkeyup="hitungTotal()" id="biaya_dokter" value="10000">
								</div>
							</div>
							<hr>
							<div class="row mt-3">
								<div class="col">
									<h4 class="text-left mt-3">TOTAL</h4>
								</div>
								<div class="col-3 float-right">
									<input type="text" name="total_harga_logistik" id="total" class="form-control text-right mt-3" readonly="">
								</div>
							</div>

							<div class="row mb-3">
								<div class="col text-right">
									<button type="submit" class="btn btn-primary mt-3">Simpan Rekam Medis</button>
									<a role="button" class="btn btn-primary mt-3 text-white" onclick="formSuratRujukan()">Cetak Rujukan</a>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- TAB PEMERIKSAAN -->
				
				<!-- HIDDEN FORM SURAT RUJUKAN -->
				<form method="POST" action="<?=base_url()?>submit-cetak-surat-rujukan" target="_blank" id="suratrujukan">
					<input type="text" name="nomor_pasien" id="nomor-pasien-rujukan" class="sembunyikan">
					<input type="text" name="id_pasien" id="id-pasien-rujukan" class="sembunyikan">
					<textarea id="subjektif-rujukan" name="subjektif" class="sembunyikan"></textarea>
					<input type="text" name="gcs_e" id="gcs-e-rujukan" class="sembunyikan">
					<input type="text" name="gcs_v" id="gcs-v-rujukan" class="sembunyikan">
					<input type="text" name="gcs_m" id="gcs-m-rujukan" class="sembunyikan">

					<input type="checkbox" id="gcs-opsi-cm-rujukan" name="gcs_opsi[]" value="CM"  class="sembunyikan">
					<input type="checkbox" id="gcs-opsi-apatis-rujukan" name="gcs_opsi[]" value="Apatis"  class="sembunyikan">
					<input type="checkbox" id="gcs-opsi-derilium-rujukan" name="gcs_opsi[]" value="Derilium"  class="sembunyikan">
					<input type="checkbox" id="gcs-opsi-somnolen-rujukan" name="gcs_opsi[]" value="Somnolen"  class="sembunyikan">
					<input type="checkbox" id="gcs-opsi-stupor-rujukan" name="gcs_opsi[]" value="Stupor"  class="sembunyikan">
					<input type="checkbox" id="gcs-opsi-coma-rujukan" name="gcs_opsi[]" value="Coma"  class="sembunyikan">
					<select id="primary-rujukan" name="diagnosaPrimary[]" multiple="multiple" style="width: 100%"  class="sembunyikan"></select>
					<select id="secondary-rujukan" name="diagnosaSecondary[]" multiple="multiple" style="width: 100%"  class="sembunyikan"></select>
					<select id="lain-rujukan" name="diagnosaLain[]" multiple="multiple" style="width: 100%"  class="sembunyikan"></select>
					<textarea id="pemeriksaan-lab-rujukan" name="diagnosaPemeriksaanLab" class="sembunyikan"></textarea>

					<input type="text" name="tinggi_badan" id="tinggi-badan-rujukan" class="sembunyikan">
					<input type="text" name="berat_badan" id="berat-badan-rujukan" class="sembunyikan">
					<input type="text" name="sistol" id="sistol-rujukan" class="sembunyikan">
					<input type="text" name="diastol" id="diastol-rujukan" class="sembunyikan">
					<input type="text" name="respiratory_rate" id="respiratory-rate-rujukan" class="sembunyikan">
					<input type="text" name="nadi" id="nadi-rujukan" class="sembunyikan">
					<input type="text" name="temperature_ax" id="temperature-ax-rujukan" class="sembunyikan">
					<input type="text" name="headtotoe" id="headtotoe-rujukan" class="sembunyikan">

					<input type="checkbox" id="anemis-kiri-rujukan" name="anemis_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="anemis-kanan-rujukan" name="anemis_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="ikterik-kiri-rujukan" name="ikterik_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="ikterik-kanan-rujukan" name="ikterik_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="cianosis-kiri-rujukan" name="cianosis_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="cianosis-kanan-rujukan" name="cianosis_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="deformitas-kiri-rujukan" name="deformitas_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="deformitas-kanan-rujukan" name="deformitas_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="refchy-kiri-rujukan" name="refchy_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="refchy-kanan-rujukan" name="refchy_kanan" value="1" class="sembunyikan">

					<input type="radio" id="refchy-opsi-rujukan" name="refchy_opsi_rujukan" value="Isokor" class="sembunyikan">
					<input type="radio" id="refchy-opsi-rujukan" name="refchy_opsi_rujukan" value="Anisokor" class="sembunyikan">
					<input type="text" id="kepala-ket-tambahan-rujukan" name="kepala_ket_tambahan" class="sembunyikan">

					<input type="radio" id="paru-simetris-asimetris-rujukan" name="paru_simetris_asimetris_rujukan" value="Simetris" class="sembunyikan">
					<input type="radio" id="paru-simetris-asimetris-rujukan" name="paru_simetris_asimetris_rujukan" value="Asimetris" class="sembunyikan">
					<input type="checkbox" id="wheezing-kiri-rujukan" name="wheezing_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="wheezing-kanan-rujukan" name="wheezing_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="ronkhi-kiri-rujukan" name="ronkhi_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="ronkhi-kanan-rujukan" name="ronkhi_kanan" value="1" class="sembunyikan">
					<input type="checkbox" id="vesikuler-kiri-rujukan" name="vesikuler_kiri" value="1" class="sembunyikan">
					<input type="checkbox" id="vesikuler-kanan-rujukan" name="vesikuler_kanan" value="1" class="sembunyikan">

					<input type="radio" id="jantung-ictuscordis-rujukan" name="jantung_ictuscordis_rujukan" value="Tampak" class="sembunyikan">
					<input type="radio" id="jantung-ictuscordis-rujukan" name="jantung_ictuscordis_rujukan" value="Tak Tampak" class="sembunyikan">
					<input type="radio" id="jantung-s1-s2-rujukan" name="jantung_s1_s2_rujukan" value="Reguler" class="sembunyikan">
					<input type="radio" id="jantung-s1-s2-rujukan" name="jantung_s1_s2_rujukan" value="Irreguler" class="sembunyikan">
					<input type="text" name="jantung_suaratambahan" id="jantung-suaratambahan-rujukan" class="sembunyikan">
					<input type="text" name="jantung_ket_tambahan" id="jantung-ket-tambahan-rujukan" class="sembunyikan">

					<input type="radio" id="BU-rujukan" name="BU_rujukan" value="Normal" class="sembunyikan">
					<input type="radio" id="BU-rujukan" name="BU_rujukan" value="Menurun" class="sembunyikan">
					<input type="radio" id="BU-rujukan" name="BU_rujukan" value="Meningkat" class="sembunyikan">
					<input type="radio" id="BU-rujukan" name="BU_rujukan" value="Negatif" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan1-rujukan" name="nyeri_tekan1" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan2-rujukan" name="nyeri_tekan2" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan3-rujukan" name="nyeri_tekan3" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan4-rujukan" name="nyeri_tekan4" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan5-rujukan" name="nyeri_tekan5" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan6-rujukan" name="nyeri_tekan6" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan7-rujukan" name="nyeri_tekan7" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan8-rujukan" name="nyeri_tekan8" value="1" class="sembunyikan">
					<input type="checkbox" id="nyeri-tekan9-rujukan" name="nyeri_tekan9" value="1" class="sembunyikan">
					<input type="text" name="hepatomegali" id="hepatomegali-rujukan" class="sembunyikan">
					<input type="text" name="spleenomegali" id="spleenomegali-rujukan" class="sembunyikan">
					<input type="text" name="abdomen_ket_tambahan" id="abdomen-ket-tambahan-rujukan" class="sembunyikan">

					<input type="checkbox" id="akral-hangat1-rujukan" name="akral_hangat1" value="1" class="sembunyikan">
					<input type="checkbox" id="akral-hangat2-rujukan" name="akral_hangat2" value="1" class="sembunyikan">
					<input type="checkbox" id="akral-hangat3-rujukan" name="akral_hangat3" value="1" class="sembunyikan">
					<input type="checkbox" id="akral-hangat4-rujukan" name="akral_hangat4" value="1" class="sembunyikan">
					<input type="checkbox" id="crt1-rujukan" name="crt1" value="1" class="sembunyikan">
					<input type="checkbox" id="crt2-rujukan" name="crt2" value="1" class="sembunyikan">
					<input type="checkbox" id="crt3-rujukan" name="crt3" value="1" class="sembunyikan">
					<input type="checkbox" id="crt4-rujukan" name="crt4" value="1" class="sembunyikan">
					<input type="checkbox" id="edema1-rujukan" name="edema1" value="1" class="sembunyikan">
					<input type="checkbox" id="edema2-rujukan" name="edema2" value="1" class="sembunyikan">
					<input type="checkbox" id="edema3-rujukan" name="edema3" value="1" class="sembunyikan">
					<input type="checkbox" id="edema4-rujukan" name="edema4" value="1" class="sembunyikan">
					<input type="radio" id="pitting-rujukan" name="pitting_rujukan" value="Non-pitting" class="sembunyikan">
					<input type="radio" id="pitting-rujukan" name="pitting_rujukan" value="Pitting" class="sembunyikan">
					<input type="text" id="ekstermitas-kettambahan-rujukan" name="ekstermitas_ket_tambahan" class="sembunyikan">

					<input type="text" name="lain_lain" id="lain-lain-rujukan" class="sembunyikan">
					<input type="text" name="planning" id="planning-rujukan" class="sembunyikan">
					<input type="text" name="terapi1" id="terapi1-rujukan" class="sembunyikan">
					<input type="text" name="terapi2" id="terapi2-rujukan" class="sembunyikan">
					<input type="text" name="terapi3" id="terapi3-rujukan" class="sembunyikan">
				</form>
				<!-- HIDDEN FORM SURAT RUJUKAN -->
				<!-- END TAB PEMERIKSAAN -->

				<!-- TAB SURAT SAKIT -->
				<div class="tab-pane fade" id="surat_sakit" role="tabpanel" aria-labelledby="home-tab">
					<h5 class="text-center mt-3">Surat Sakit</h5>
					<div class="container">	
						<form id="formSuratSakit" action="<?=base_url()?>submit-cetak-surat-sakit" target="_blank" method="POST">
							<input type="hidden" name="nomor_pasien" value="<?=$pasien[0]->nomor_pasien?>">
							<input type="hidden" name="id_pasien" value="<?=$pasien[0]->id?>">
							<div class="row mt-3">
								<div class="col-2">Alasan</div>
								<div class="col">:</div>
								<div class="col-9">
									<select class="custom-select" id="alasan" name="alasan" required="">
										<option value="1">Istirahat Sakit</option>
										<option value="2">Pelakuan Khusus</option>
									</select>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Tanggal Awal</div>
								<div class="col">:</div>
								<div class="col-9">
									<input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required="" value="<?=date("Y-m-d")?>" readonly="">
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Selama</div>
								<div class="col">:</div>
								<div class="col-9">
									<div class="input-group">
										<input type="number" class="form-control" id="selama" name="selama" placeholder="Angka" min="1" onkeyup="updateTglAkhir()">
										<div class="input-group-append">
											<select class="input-group-text custom-select" name="selama_satuan" id="selama_satuan" onchange="updateTglAkhir()" required="">
												<option value="hari">Hari</option>
												<option value="minggu">Minggu</option>
												<option value="bulan">Bulan</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-2">Tanggal Akhir</div>
								<div class="col">:</div>
								<div class="col-9">
									<input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" required="" readonly="" formart>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col text-right">
									<button type="submit" class="btn btn-primary" onclick="setTimeout(SuratSakit, 1000)">Cetak</button>		
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- TAB SURAT SAKIT -->


				<!-- TAB SURAT SEHAT -->
				<div class="tab-pane fade" id="surat_sehat" role="tabpanel" aria-labelledby="home-tab">
					<div class="container">
						<h5 class="text-center mt-3">Surat Sehat</h5>
						<form action="<?=base_url()?>submit-cetak-surat-sehat" onsubmit="formSuratSehat()" target="_blank" method="POST" id="formSuratSehat">
							<input type="hidden" name="nomor_pasien" value="<?=$pasien[0]->nomor_pasien?>">
							<input type="hidden" name="id_pasien" value="<?=$pasien[0]->id?>">
							<div class="row mt-3">
								<div class="col-3">Tes Buta Warna</div>
								<div class="col">:</div>
								<div class="col">
									<input type="radio" class="form-control" id="tesButaWarna1" name="tes_buta_warna" value="Ya" >
									<label class="" for="tesButaWarna1">Ya</label>
								</div>
								<div class="col">
									<input type="radio" class="form-control" id="tesButaWarna2" name="tes_buta_warna" value="Tidak" >
									<label class="" for="tesButaWarna2">Tidak</label>
								</div>
								<div class="col">
									<input type="radio" class="form-control" id="tesButaWarna3" name="tes_buta_warna" value="Parsial" >
									<label class="" for="tesButaWarna3">Parsial</label>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-3">Keperluan</div>
								<div class="col">:</div>
								<div class="col-8">
									<input type="text" class="form-control" id="keperluan" name="keperluan" >
									<input type="hidden" class="form-control" name="tinggi_badan" id="tinggi-badan-sehat">
									<input type="hidden" class="form-control" name="berat_badan" id="berat-badan-sehat">
									<input type="hidden" class="form-control" name="sistol" id="sistol-sehat">
									<input type="hidden" class="form-control" name="diastol" id="diastol-sehat">
									<input type="hidden" class="form-control" name="nadi" id="nadi-sehat">
									<input type="hidden" class="form-control" name="respiratory_rate" id="respiratory-rate-sehat">
									<input type="hidden" class="form-control" name="temperature_ax" id="temperature-ax-sehat">
								</div>
							</div>

							<div class="row mt-3">
								<div class="col text-right">
									<button type="submit" class="btn btn-primary" onclick="setTimeout(SuratSehat, 1000)" >Cetak</button>		
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- TAB SURAT SEHAT -->
			</div>
		</div>	
	</div>
</div>