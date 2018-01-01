<div class="content-wrapper">
		<section class="content-header">
			<h1>Tambah Baru<small>Preview</small></h1>
			<?php echo $this->breadcrumbs->show();?>
		</section>
		<section class="content">
			<form role="form" enctype="multipart/form-data" action="?act=edit&id=<?php echo $id;?>" method="post">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h6 class="box-title">Edit Transaksi</h3>
					</div>
					<div class="box-body">
						<?php foreach($data_trx as $row){?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Nama</label>
										<input name="name" type="text" class="form-control" value="<?php echo $row->name;?>" placeholder="nama">
									</div>
									<div class="form-group">
										<label>Jenis</label>
										<select name="type" class="form-control select2" style="width:100%;">
											<option></option>
											<?php $types=array("masuk","keluar");?>
											<?php foreach($types as $type):?>
												<?php
													if($row->type==$type){
														$selected=" selected";
													}
													else{
														$selected="";
													}
												?>
												<option value="<?php echo $type;?>"<?php echo $selected;?>><?php echo ucfirst($type);?></option>
											<?php endforeach;?>
										</select>
										<script type="text/javascript">
											$('select').select2({
												placeholder: "Silahkan pilih"
											});
										</script>
									</div>
									<div class="form-group">
										<label>Nominal</label>
									</div>
									<div class="input-group">
										<div class="input-group-addon">
											<label>Rp</label>
										</div>
										<input type="text" name="nominal" class="form-control" value="<?php echo $row->nominal;?>">
									</div>
									<div class="form-group">
										<label>Tanggal</label>
										<!-- <input type="text" name="date" class="form-control"> -->
										<div class="input-group date">
											<input type="text" class="form-control" value="<?php echo show_date($row->trx_datetime,"d/m/Y")?>" name="date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
										<script type="text/javascript">
											$('.input-group.date').datepicker({
												format: "dd/mm/yyyy",
												toggleActive: true
											});
										</script>
									</div>
									<div class="form-group">
										<label>Deskripsi</label>
										<textarea name="desc" class="form-control"><?php echo $row->description;?></textarea>
									</div>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="box box-primary">
					<div class="box-body" style="text-align:center;">
						<script>
							function popUp(){
								var popup = document.createElement('div');
								popup.className = 'popup';
								popup.id = 'popup';
								var cancel = document.createElement('div');
								cancel.className = 'cancel';
								cancel.innerHTML = 'close';
								cancel.onclick = function (e) { popup.parentNode.removeChild(popup) };
								var message = document.createElement('span');
								message.innerHTML = "This is a test message";
								popup.appendChild(message);                                    
								popup.appendChild(cancel);
								document.body.appendChild(popup);
							}
							function openPopup() {
								//document.getElementById('test').style.display = 'block';
								$('#popup').fadeIn(1000);
							}

							function closePopup() {
								//document.getElementById('test').style.display = 'none';
								$('#popup').fadeOut(500);
							}
						</script>
						<a onClick="openPopup();" class="btn btn-primary">KIRIM</a>
						<div id="popup" class="modal popup">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePopup();"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title">Modal Default</h4>
									</div>
									<div class="modal-body">
										<div class="g-recaptcha" data-sitekey="6LcuSBITAAAAAP8S4vp62u7WyJVeTxri2Kky3L7m"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="closePopup();">Close</button>
										<button type="submit" class="btn btn-primary" onclick="closePopup();">Save changes</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
	<script src="<?php echo base_url('assets');?>/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url('assets');?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
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