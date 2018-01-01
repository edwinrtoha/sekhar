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
				$uid=$this->session->userdata('id');
				$secret=$ga->createSecret();
				$query=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
			?>
			<?php foreach($query->result() as $row){?>
				<form role="form" enctype="multipart/form-data" action="?view=two-step-verification&act=save" method="post">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h6 class="box-title">Informasi Pribadi</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-3">
									<img src="<?php echo $ga->getQRCodeGoogleUrl('Sekhar ('.$row->username.')', $secret);?>" width="100%" style="max-width:244.75px;">
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<label>Secret</label>
										<div class="form-control"><?php echo $secret;?></div>
										<input type="hidden" name="secret" value="<?php echo $secret;?>">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" class="form-control">
									</div>
									<div class="form-group">
										<label>OTP</label>
										<input type="text" name="otp" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-body" style="text-align:center;">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<!-- <label>Ketentuan</label> -->
										<div class="form-control" style="height:inherit;text-align:justify;">Jika anda melakukan perubahan ini anda akan di minta memasukan kode OTP setiap anda login di perangkat yang tidak di kenali dan jika anda telah melakukan perubahan sebelumnya maka kode OTP yang di hasilkan dari perubahan sebelumnya tidak dapat di pakai lagi</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="g-recaptcha" style="margin:0;" data-sitekey="6LcuSBITAAAAAP8S4vp62u7WyJVeTxri2Kky3L7m"></div>
								</div>
							</div>
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