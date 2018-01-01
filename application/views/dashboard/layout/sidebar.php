<aside class="main-sidebar">
	<section class="sidebar">
		<?php
			$data_user=$this->simple_login->user_login();
		?>
		<?php foreach($data_user as $row):?>
			<?php $role=$row->role;?>
			<div class="user-panel">
				<?php
					$this->load->helper("initialsimage");
					$name = $row->first_name;
					if(isset($_POST['submit'])){
						$name = (strip_tags($name));
					}
					$avatar_url = generate_first_letter_avtar_url($name);
				?>
				<div class="pull-left image">
					<img src="<?php echo $avatar_url;?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><?php echo $row->first_name;?> <?php echo $row->last_name;?></p>
				</div>
			</div>
		<?php endforeach;?>
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li>
				<a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
			</li>
			<li class="treeview">
				<a href="#"><i class="fa fa-money"></i> <span>Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url();?>dashboard/trx"><i class="ion-android-list"></i> Daftar</a></li>
					<li><a href="<?php echo base_url("dashboard");?>/trx?view=add"><i class="ion-android-add-circle"></i> Tambah Baru</a></li>
				</ul>
			</li>
			<li>
				<a href="<?php echo base_url("dashboard");?>/invoice"><i class="fa fa-file-text"></i> <span>Faktur</span></a>
			</li>
			<li class="treeview">
				<a href="#"><i class="fa fa-cogs"></i> <span>Setting</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url("dashboard/setting/account");?>"><i class="ion-android-list"></i> Akun</a></li>
					<li><a href="<?php echo base_url("dashboard/setting/account?view=two-step-verification");?>"><i class="fa fa-shield"></i> Verifikasi 2 langkah</a></li>
				</ul>
			</li>
			<?php if($role==1):?>
				<li class="header">ADMINISTRATOR</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-users"></i> <span>Pengguna</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url();?>dashboard/admin/users"><i class="ion-android-list"></i> Daftar</a></li>
						<li><a href="<?php echo base_url("dashboard");?>/admin/users?view=add"><i class="ion-android-add-circle"></i> Tambah Baru</a></li>
					</ul>
				</li>
			<?php endif;?>
		</ul>
	</section>
</aside>