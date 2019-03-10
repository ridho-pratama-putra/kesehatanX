<div class="container-fluid">
	<div class="row mt-5">
		<div class="col-xs-10 offset-xs-1 col-sm-8 offset-sm-2 col-md-4 offset-md-4">
		<?=$this->session->flashdata("alert")?>
			<div class="card">
				<div class="card-header">Login Pengguna Klinik DU'A</div>
				<div class="card-body">
					<form role="form" method="POST" action="<?=base_url().'submit-login'?>">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password">
							</div>
							<div class="row">
								<div class="col"><button class="btn btn-primary btn-block " type="submit">Login</button></div>
								<div class="col"><a class="btn btn-primary btn-block text-white" id="signup_btn" href="<?= base_url().'register'?>">Register</a></div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
</div>