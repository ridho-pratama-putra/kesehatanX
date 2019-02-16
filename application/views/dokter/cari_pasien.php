<script type="text/javascript">
	$(document).ready(function() {
		$('select').select2();
		$("#nama_or_nomor").select2({
			ajax: {
				url: '<?=base_url()?>cari-pasien-dokter/',
				dataType: 'json',
				delay: 1000,
				data: function (term, page) {
					return {
					term: term, // search term
					page: 10
				};
			},
			processResults: function (data, page) {
				// console.log(data);
				return {
					results: data
				};
			},
			cache: true
		},
		escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		minimumInputLength: 1
	});
		$('#nama_or_nomor').select2('open');
	});
</script>
<div class="container mt-5">
	<?=$this->session->flashdata("alert");?>
	<div class="col-8 offset-2">
		<div class="card" >
			<div class="card-header">
				<h3 class="text-center">Cari berdasarkan nama pasien atau nomor pasien</h3>
			</div>
			<div class="card-body">
				<form action="<?=base_url().'redirector-dokter'?>" method="GET">
					<div class="row">
						<div class="col">
							<div class="form-group row">
								<div class="input-group col-8 offset-2">
									<select autofocus="autofocus" class="js-data-example-ajax form-control" name="nama_or_nomor" id="nama_or_nomor">
										<option value="" selected="selected"></option>
									</select>
								</div>
							</div>
						</div>   
					</div>
					<div class="row">
						<div class="col-8 offset-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block" autofocus="autofocus">Submit</button>
							</div>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>