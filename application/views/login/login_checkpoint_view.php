<?php
    // Proteksi halaman
    $this->simple_login->cek_login();
    $login_status=$this->session->flashdata('login_status');
    if($login_status=='1'){
        redirect(base_url('dashboard'));
    }
?>
<div class="login-box-body">
	<p class="login-box-msg">Please insert a OTP to start your session</p>
	<?php
		// Cetak session
		if($this->session->flashdata('sukses')) {
			echo '<div class="callout callout-danger"><p>'.$this->session->flashdata('sukses').'</p></div>';
		}
		// Cetak error
		echo validation_errors('<div class="callout callout-danger"><p>','</p></div>');
	?>
	<form action="<?php echo base_url('login/checkpoint') ?>" method="post">
		<div class="form-group has-feedback">
			<input name="otp" class="form-control" placeholder="OTP">
			<span class="ion-lock-combination form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-8" style="line-height:34px;">
			</div>
			<div class="col-xs-4">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
			</div>
		</div>
	</form>

</div>