<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url("dashboard");?>">Sekhar V2</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="trx.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transaksi <span class="sr-only">(current)</span> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>dashboard/trx">Daftar</a></li>
						<li><a href="<?php echo base_url("dashboard");?>/trx?view=add">Tambah Baru</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrator <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-submenu">
							<a tabindex="-1" href="#">Pengguna</a>
							<ul class="dropdown-menu">
								<li><a tabindex="-1" href="<?php echo base_url();?>dashboard/admin/users">Daftar</a></li>
								<li><a href="<?php echo base_url();?>dashboard/admin/users?view=add">Tambah Baru</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?php
	                  $data_user=$this->simple_login->user_login();
	                ?>
	                <?php foreach($data_user as $row){?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php echo base_url();?>/assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image" width="25px" height="25px">
							<span class="hidden-xs"><?php echo $row->first_name." ".$row->last_name;?></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('dashboard/setting/account');?>">Akun</a></li>
							<li><a href="<?php echo base_url('dashboard/setting/account');?>?view=two-step-verification">Verifikasi 2 Langkah</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo base_url('login/logout');?>">Logout</a></li>
						</ul>
	                <?php }?>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">