<div class="content-wrapper">
	<div class="content-header">
		<h1>Daftar Transaksi</h1>
		<!-- <ol class="breadcrumb">
			<li><a href="<?php base_url('dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Daftar Jurusan</li>
		</ol> -->
		<?php echo $this->breadcrumbs->show();?>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<!-- <div class="box-header with-border">
						<h3 class="box-title">Grafik</h3>
					</div> -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<div class="nav-tabs-custom" style="cursor: move;">
									<!-- Tabs within a box -->
									<ul class="nav nav-tabs pull-left ui-sortable-handle">
										<li class="active"><a href="#revenue-chart" data-toggle="tab" aria-expanded="false">Bulanan</a></li>
										<li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="true">Mingguan</a></li>
									</ul>
									<div class="tab-content no-padding">
										<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
											<div class="chart">
												<canvas id="myChartMonthly" height="127"></canvas>
											</div>
										</div>
										<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
											<div class="chart">
												<canvas id="myChartWeekly" height="127"></canvas>
											</div>
										</div>
										<script>
											<?php
												$date_now=explode("/",date("d/m/Y"));
												$day_now=date("N");
												$uid=$this->session->userdata('id');
												$query_acc=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
												foreach($query_acc->result() as $acc){
													$first_balance=$acc->first_balance;
												}
												$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'masuk'");
												$masuk=0;
												if($query->num_rows()>0){
													foreach ($query->result() as $row) {
														$masuk=$masuk+$row->nominal;
													}
													$masuk=$first_balance+$masuk;
												}

												// Uang keluar
												$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'keluar'");
												$keluar=0;
												if($query->num_rows()>0){
													foreach ($query->result() as $row) {
														$keluar=$keluar+$row->nominal;
													}
												}

												// Uang masuk (bersih)
												$masuk_bersih=$masuk-$keluar;
											?>
											var ctx = document.getElementById("myChartWeekly").getContext('2d');
											var myChartWeekly = new Chart(ctx, {
												type: 'line',
												data: {
													labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
													datasets: [{
														label: '# of Votes',
														data: [20, 19, 3, 5],
														backgroundColor: [
															'rgba(60,141,188,0.9)'
														],
														borderColor: [
															'rgba(60,141,188,0.9)'
														],
														borderWidth: 1
													}, {
														label: '# of Votes',
														data: [12, 19, 3, 5],
														backgroundColor: [
															'rgba(255, 99, 132, 0.9)',
														],
														borderColor: [
															'rgba(255, 99, 132, 0.9)'
														],
														borderWidth: 1
													}]
												},
												options: {
													scales: {
														yAxes: [{
															ticks: {
																beginAtZero:true
															}
														}]
													}
												}
											});
											<?php
												$date_now=explode("/",date("d/m/Y"));
												$uid=$this->session->userdata('id');
												$query_acc=$this->db->query("SELECT * FROM `user` WHERE `id` = '$uid'");
												$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'masuk'");
												$masuk=0;
												if($query->num_rows()>0){
													foreach ($query->result() as $row) {
														$masuk=$masuk+$row->nominal;
													}
													$masuk=$first_balance+$masuk;
												}

												// Uang keluar
												$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'keluar'");
												$keluar=0;
												if($query->num_rows()>0){
													foreach ($query->result() as $row) {
														$keluar=$keluar+$row->nominal;
													}
												}

												// Uang masuk (bersih)
												$masuk_bersih=$masuk-$keluar;
											?>
											var ctx = document.getElementById("myChartMonthly").getContext('2d');
											var myChartMonthly = new Chart(ctx, {
												type: 'line',
												data: {
													labels: ["Jan", "Feb", "Mar", "Apr", "Mey", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Des"],
													datasets: [{
														label: 'Masuk',
														data: [
															<?php
																$uid=$this->session->userdata('id');
																$date_now=explode("-", date("Y-m-d"));
																$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC LIMIT 1");
															?>
															<?php if($query->num_rows()>0):?>
																<?php foreach ($query->result() as $row):?>
																	<?php
																		$date_last=explode(" ", $row->trx_datetime);
																		$date_last=explode("-", $date_last[0]);
																		$year=$date_last[0];
																	?>
																	<?php for($i=1;$i>0 and $i<13;$i++):?>
																		<?php $j=sprintf("%02d", $i);?>
																		<?php
																			$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'masuk' AND `trx_datetime` LIKE '$year-$j-__ __:__:__'");
																			$keluar=0;
																		?>
																		<?php if($query->num_rows()>0):?>
																			<?php foreach($query->result() as $row):?>
																				<?php $keluar=$keluar+$row->nominal;?>
																			<?php endforeach;?>
																			<?php echo $keluar;?>
																			<?php
																				if($i!=12){
																					echo ",";
																				}
																			?>
																		<?php else:?>
																			<?php $keluar=0;?>
																			<?php echo $keluar;?>
																			<?php
																				if($i!=12){
																					echo ",";
																				}
																			?>
																		<?php endif;?>
																	<?php endfor;?>
																<?php endforeach;?>
															<?php endif;?>
														],
														backgroundColor: [
															'rgba(60,141,188,0.9)'
														],
														borderColor: [
															'rgba(60,141,188,0.9)'
														],
														borderWidth: 1
													}, {
														label: 'Keluar',
														data: [
															<?php
																$uid=$this->session->userdata('id');
																$date_now=explode("-", date("Y-m-d"));
																$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC LIMIT 1");
															?>
															<?php if($query->num_rows()>0):?>
																<?php foreach ($query->result() as $row):?>
																	<?php
																		$date_last=explode(" ", $row->trx_datetime);
																		$date_last=explode("-", $date_last[0]);
																		$year=$date_last[0];
																	?>
																	<?php for($i=1;$i>0 and $i<13;$i++):?>
																		<?php $j=sprintf("%02d", $i);?>
																		<?php
																			$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'keluar' AND `trx_datetime` LIKE '$year-$j-__ __:__:__'");
																			$keluar=0;
																		?>
																		<?php if($query->num_rows()>0):?>
																			<?php foreach($query->result() as $row):?>
																				<?php $keluar=$keluar+$row->nominal;?>
																			<?php endforeach;?>
																			<?php echo $keluar;?>
																			<?php
																				if($i!=12){
																					echo ",";
																				}
																			?>
																		<?php else:?>
																			<?php $keluar=0;?>
																			<?php echo $keluar;?>
																			<?php
																				if($i!=12){
																					echo ",";
																				}
																			?>
																		<?php endif;?>
																	<?php endfor;?>
																<?php endforeach;?>
															<?php endif;?>
														],
														backgroundColor: [
															'rgba(255, 99, 132, 0.9)',
														],
														borderColor: [
															'rgba(255, 99, 132, 0.9)'
														],
														borderWidth: 1
													}]
												},
												options: {
													scales: {
														yAxes: [{
															ticks: {
																beginAtZero:true
															}
														}]
													}
												}
											});
										</script>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<td>TOTAL REVENUE</td>
												<td><?php echo concurrency($masuk,"Rp");?></td>
											</tr>
											<tr>
												<td>TOTAL COST</td>
												<td><?php echo concurrency($keluar,"Rp");?></td>
											</tr>
											<tr>
												<td>TOTAL PROFIT</td>
												<td><?php echo concurrency($masuk_bersih,"Rp");?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">5 Transaksi Terakhir</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table no-margin">
								<thead>
									<tr>
										<th>Tanggal</th>
										<th>Transaksi</th>
										<th>Jenis</th>
										<th>Nominal</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC, `input_datetime` DESC LIMIT 5");
									?>
									<?php if($query->num_rows()>0):?>
										<?php foreach($query->result() as $row){?>
											<tr>
												<td><?php echo show_date($row->trx_datetime,"d/m/Y");?></td>
												<td><?php echo $row->name;?></td>
												<td><span class="label label-success"><?php echo $row->type;?></span></td>
												<td><?php echo concurrency($row->nominal,"Rp");?></td>
											</tr>
										<?php }?>
									<?php else:?>
										<tr>
											<td colspan="4" style="text-align:center;">Tidak ada data yang ditemukan</td>
										</tr>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="box-footer clearfix">
						<a href="<?php echo base_url('dashboard/trx');?>?view=add" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-plus"></i> Transaksi</a>
						<a href="<?php echo base_url('dashboard/trx');?>" class="btn btn-sm btn-default btn-flat pull-right">Lihat semua</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>