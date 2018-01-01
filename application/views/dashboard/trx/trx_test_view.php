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
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Mailbox <small>13 new messages</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php base_url('dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Daftar Jurusan</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<?php
					$uid=$this->session->userdata('id');
					$limit=5;
					$offset=0;
					$data_from=1;
					$data_end=$limit;
					$query_all=$this->db->query("SELECT COUNT(*) FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC, `input_datetime` DESC");
					$trx_count=$query_all->row_array();
					$trx_count=$trx_count['COUNT(*)'];
					$prev=0;
					$next=0;
					if(isset($_GET["page"])){
						$page=$_GET["page"];
						unset($_GET["page"]);
						if($page>=0){
							$next=$page+1;
						}
						if($page>1){
							$prev=$page-1;
							$page=$page-1;
							$offset=$page*$limit;
						}
					}
					else{
						$page=1;
						$prev=0;
						$next=$page+1;
					}
					$data_from=$offset+1;
					$data_end=$data_from+$limit-1;
					$prev_url=base_url()."dashboard/trx?view=test&page=".$prev;
					$next_url=base_url()."dashboard/trx?view=test&page=".$next;
					$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC, `input_datetime` DESC LIMIT $offset,$limit");
				?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Daftar Transaksi</h3>
						<div class="box-tools pull-right">
							<div class="has-feedback">
								<form method="post">
									<input name="s" type="text" class="form-control input-sm" placeholder="Search Mail">
									<span class="glyphicon glyphicon-search form-control-feedback"></span>
								</form>
							</div>
						</div><!-- /.box-tools -->
					</div><!-- /.box-header -->
					<div class="box-body no-padding">
						<div class="mailbox-controls">
							<!-- Check all button -->
							<button type="button" id="toggle" class="btn btn-default btn-sm checkbox-toggle" value="Pilih Semua" onClick="checkall()"><i id="labelselect" class="fa fa-square-o"></i></button>
							<div class="btn-group">
								<button class="btn btn-default btn-sm" onClick="parent.location='?view=add'"><i class="ion ion-plus-round"></i></button>
								<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
								<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
							</div><!-- /.btn-group -->
							<button class="btn btn-default btn-sm" onClick="window.location.reload()"><i class="fa fa-refresh"></i></button>
							<div class="pull-right">
								<?php echo $data_from;?>-<?php echo $data_end;?>/<?php echo $trx_count;?>
								<div class="btn-group">
									<?php if($prev>0):?>
										<a href="<?php echo $prev_url;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
									<?php else:?>
										<button class="btn btn-default btn-sm" disabled><i class="fa fa-chevron-left"></i></button>
									<?php endif;?>
									<?php if($data_end<$trx_count):?>
										<a href="<?php echo $next_url;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
									<?php else:?>
										<button class="btn btn-default btn-sm" disabled><i class="fa fa-chevron-right"></i></button>
									<?php endif;?>
								</div><!-- /.btn-group -->
							</div><!-- /.pull-right -->
						</div>
						<div class="table-responsive mailbox-messages">
							<table class="table table-hover table-striped table-responsive">
								<thead>
								</thead>
									<tr>
										<th></th>
										<th>Tanggal</th>
										<th>Transaksi</th>
										<th>Jenis</th>
										<th>Nominal</th>
										<th>Aksi</th>
									</tr>
								<tbody>
									<?php
										$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC, `input_datetime` DESC LIMIT $offset,$limit");
									?>
									<?php if($query->num_rows()>0):?>
										<?php foreach ($query->result() as $row){ ?>
											<tr>
												<td><input name="checkbox" type="checkbox" value="" class="flat-blue"></td>
												<td><?php echo show_date($row->trx_datetime,"d/m/Y");?></td>
												<td style="max-width:650px;"><?php echo $row->name;?></td>
												<td style="text-transform:capitalize;"><?php echo $row->type;?></td>
												<td style="min-width:125px;"><?php echo concurrency($row->nominal,"Rp");?></td>
												<td style="min-width:188px;">
													<a href="?view=detail&id=<?php echo $row->id;?>" class="btn btn-xs btn-success"><i class="ion ion-edit"></i> Detail</a>
													<a href="?view=edit&id=<?php echo $row->id;?>" class="btn btn-xs btn-warning"><i class="ion ion-edit"></i> Edit</a>
													<a href="?act=del&id=<?php echo $row->id;?>" class="btn btn-xs btn-danger"><i class="ion ion-trash-a"></i> Hapus</a>
												</td>
											</tr>
										<?php }?>
									<?php else:?>
										<tr>
											<td colspan="6" style="text-align:center;">Tidak ada data yang ditemukan</td>
										</tr>
									<?php endif;?>
								</tbody>
							</table><!-- /.table -->
						</div><!-- /.mail-box-messages -->
					</div><!-- /.box-body -->
					<div class="box-footer no-padding">
					<div class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" id="toggle" class="btn btn-default btn-sm checkbox-toggle" value="Pilih Semua" onClick="checkall()"><i id="labelselect" class="fa fa-square-o"></i></button>
					<div class="btn-group">
					<button class="btn btn-default btn-sm" onClick="parent.location='?view=add'"><i class="ion ion-plus-round"></i></button>
					<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
					<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
					</div><!-- /.btn-group -->
					<button class="btn btn-default btn-sm" onClick="window.location.reload()"><i class="fa fa-refresh"></i></button>
					<div class="pull-right">
					<?php echo $data_from;?>-<?php echo $data_end;?>/<?php echo $trx_count;?>
					<div class="btn-group">
					<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
					<button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					</div><!-- /.btn-group -->
					</div><!-- /.pull-right -->
					</div>
					</div>
				</div><!-- /. box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->