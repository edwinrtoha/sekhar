<div class="content-wrapper">
	<section class="box box-primary">
		<div class="box-header box-header with-border">
			<h3 class="box-title"><i class="fa fa-file-text-o"></i> Detail Transaksi</h3>
		</div>
		<div class="box-body">
			<div class="col-xs-12 table-responsive">
			<?php foreach($data_trx as $row):?>
				<table class="table table-form">
					<tbody>
						<tr>
							<td width="200"><strong>Nama Transaksi</strong></td>
							<td width="5">:</td>
							<td><?php echo $row->name;?></td>
						</tr>
						<tr>
							<td><strong>Jenis</strong></td>
							<td>:</td>
							<td><?php echo ucfirst($row->type);?></td>
						</tr>
						<tr>
							<td><strong>Nominal</strong></td>
							<td>:</td>
							<td><?php echo concurrency($row->nominal,"Rp");?></td>
						</tr>
						<tr>
							<td><strong>Keterangan</strong></td>
							<td>:</td>
							<td><?php echo $row->description;?></td>
						</tr>
						<tr>
							<td><strong>Tanggal Transaksi</strong></td>
							<td>:</td>
							<td><i class="fa fa-calendar"></i> <?php echo show_date($row->trx_datetime,"d F Y");?></td>
						</tr>
						<tr>
							<td><strong>Tanggal Input</strong></td>
							<td>:</td>
							<td><i class="fa fa-calendar"></i> <?php echo show_date($row->input_datetime,"d F Y H:i:s");?></td>
						</tr>
					</tbody>
				</table>
			<?php endforeach;?>
			</div>
		</div>
		<div class="box-footer">
			<a onclick="window.print()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
			<!-- <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
			</button>
			<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button> -->
		</div>
	</section>
	<!-- /.content -->
	<div class="clearfix"></div>
</div>