<?php
    // Proteksi halaman
    $this->simple_login->cek_login();
    $login_status=$this->session->flashdata('login_status');
    if($login_status=='1'){
        redirect(base_url('dashboard'));
    }
?>
<div class="login-box-body">
	<p class="login-box-msg">Sign in to start your session</p>
	<?php
		// Cetak session
		if($this->session->flashdata('sukses')) {
			echo '<div class="callout callout-danger"><p>'.$this->session->flashdata('sukses').'</p></div>';
		}
		// Cetak error
		echo validation_errors('<div class="callout callout-danger"><p>','</p></div>');
	?>
	<form action="<?php echo base_url('login') ?>" method="post">
		<div class="form-group has-feedback">
			<input name="username" class="form-control" placeholder="Email">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input name="password" type="password" class="form-control" placeholder="Password">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-8">
				<div class="checkbox icheck">
					<label>
						<input type="checkbox"> Remember Me
					</label>
				</div>
			</div>
			<div class="col-xs-4">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
			</div>
		</div>
	</form>

	<div class="social-auth-links text-center">
		<p>- OR -</p>
		<!-- <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a> -->
		<a href="<?php echo base_url("login/oauth/google");?>" class="btn btn-block btn-social btn-google"><i class="fa fa-google"></i> Sign in with Google</a>
	</div>

	<a href="#">I forgot my password</a><br>
	<a href="register.php" class="text-center">Register a new membership</a>
</div>