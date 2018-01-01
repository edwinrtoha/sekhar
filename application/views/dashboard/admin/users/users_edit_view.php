<?php $this->load->helper('phpgangsta');?>
<div class="content-wrapper">
		<?php
			// Cetak session
			if($this->session->flashdata('alert')) {
				$alert=array(
					'type'=>$this->session->flashdata('alert_type'),
					'icon'=>$this->session->flashdata('alert_icon'),
					'title'=>$this->session->flashdata('alert_title'),
					'dismiss'=>$this->session->flashdata('alert_dismiss'),
					'value'=>$this->session->flashdata('alert_value')
					);
				alert($alert['type'],$alert['dismiss'],$alert['icon'],$alert['title'],$alert['value']);
			}
		?>
		<section class="content-header">
			<h1>Tambah Baru<small>Preview</small></h1>
			<?php echo $this->breadcrumbs->show();?>
		</section>
		<section class="content">
			<?php
				$query=$this->db->query("SELECT * FROM `user` WHERE `id` = '$data_uid'");
			?>
			<?php foreach($query->result() as $row){?>
				<form role="form" enctype="multipart/form-data" action="?act=edit&id=<?php echo $data_uid;?>" method="post">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h6 class="box-title">Informasi Pribadi</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-6">
												<label>Nama Depan</label>
												<input name="first_name" type="text" class="form-control" value="<?php echo $row->first_name;?>" placeholder="nama">
											</div>
											<div class="col-xs-6">
												<label>Nama Belakang</label>
												<input name="last_name" type="text" class="form-control" value="<?php echo $row->last_name;?>" placeholder="nama">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Tempat/Tanggal Lahir</label>
										<div class="row">
											<div class="col-md-3">
												<select name="birth_place" class="form-control select2" style="width:100%;">
													<option></option>
													<?php
														$query=$this->db->query("SELECT * FROM `inf_lokasi` WHERE `kabupatenkota` = 0 AND `kecamatan` = 0 AND `kelurahan` = 0")
													?>
													<?php foreach($query->result() as $prov){?>
														<optgroup label="<?php echo $prov->nama?>">
															<?php
																$kotas=$this->db->query("SELECT * FROM `inf_lokasi` WHERE `provinsi` = '$prov->provinsi' AND `kecamatan` = 0 AND `kelurahan` = 0 AND `id` != '$prov->id'");
															?>
															<?php foreach($kotas->result() as $kota){?>
																<?php
																	if($row->birth_place == $kota->id){
																		$selected=" selected";
																	}
																	else{
																		$selected="";
																	}
																?>
																<option value="<?php echo $kota->id;?>"<?php echo $selected;?>><?php echo ucwords(strtolower($kota->nama));?></option>
															<?php }?>
														</optgroup>
													<?php }?>
												</select>
											</div>
											<div class="col-md-9">
												<div class="input-group date">
													<input type="text" name="birth_date" class="form-control" value="<?php echo show_date($row->birth_date,'d/m/Y')?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
												</div>
												<script type="text/javascript">
													$('select').select2({
														placeholder: "Silahkan pilih"
													});
													$('.input-group.date').datepicker({
														format: "dd/mm/yyyy",
														orientation: "bottom auto",
														toggleActive: true
													});
												</script>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Alamat</label>
										<textarea name="address" class="form-control"><?php echo $row->address;?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h6 class="box-title">Informasi Akun</h6>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Email</label>
										<input type="text" name="email" class="form-control" value="<?php echo $row->email;?>" placeholder="example@domain.com">
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Username</label>
												<input type="text" name="username" class="form-control" value="<?php echo $row->username;?>" placeholder="Username">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Peran</label>
												<select name="role" class="form-control select2" style="width:100%;">
													<?php $roles=$this->db->query("SELECT * FROM `role` ORDER BY `id` ASC");?>
													<?php foreach($roles->result() as $role):?>
														<?php
															if($role->id==$row->role){
																$selected=" selected";
															}
															else{
																$selected="";
															}
														?>
														<option value="<?php echo $role->id;?>"<?php echo $selected;?>><?php echo $role->name;?></option>
													<?php endforeach;?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Password <small>(Biarkan kosong jika tak ingin mengubah)</small></label>
												<input type="password" name="password" class="form-control" placeholder="Password">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Ketik ulang Password</label>
												<input type="password" name="repassword" class="form-control" placeholder="Ketik ulang password">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Saldo Awal</label>
										<input type="text" name="first_balance" class="form-control" value="<?php echo $row->first_balance;?>" placeholder="Saldo Awal">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-body" style="text-align:center;">
							<div class="g-recaptcha" data-sitekey="6LcuSBITAAAAAP8S4vp62u7WyJVeTxri2Kky3L7m"></div>
							<button class="btn btn-primary">KIRIM</button>
						</div>
					</div>
				</form>
			<?php }?>
		</section>
	</div>
	<script src="<?php echo base_url('assets');?>/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url('assets');?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="<?php echo base_url('assets');?>/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>
      <!-- /.content-wrapper -->