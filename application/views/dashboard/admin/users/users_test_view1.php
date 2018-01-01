<div class="content-wrapper">
	<div class="row">
		<!-- <div class="col-md-6">
			<canvas id="salesChart" style="height: 180px;"></canvas>
		</div> -->
		<div class="col-md-12">
			<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
		</div>
	</div>
	<script type="text/javascript">
		new Morris.Area({
			element: 'revenue-chart',
			// Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2016-01', month: 'Jan', item1: 20, item2:50 },
    { year: '2016-02', month: 'Feb', item1: 10, item2:50 },
    { year: '2016-03', month: 'Mar', item1: 5, item2:50 },
    { year: '2016-04', month: 'Apr', item1: 5, item2:50 },
    { year: '2016-05', month: 'Mei', item1: 20, item2:50 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['item1', 'item2'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  xLabels: 'month',
  labels: ['Value']
		});
	</script>
	<?php
		$uid=$this->session->userdata('id');
		$date_now=explode("-", date("Y-m-d"));
		$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' ORDER BY `trx_datetime` DESC LIMIT 1");
		if($query->num_rows()==1){
			foreach ($query->result() as $row){
				$date_last=explode(" ", $row->trx_datetime);
				$date_last=explode("-", $date_last[0]);
				$year=$date_last[0];
				for($i=$date_last[1];$i>0 and $i<13;$i=$i-1){
					$query=$this->db->query("SELECT * FROM `trx` WHERE `uid` = '$uid' AND `type` = 'masuk' AND `trx_datetime` LIKE '$year-$i-__ __:__:__'");
					$masuk=0;
					echo $i."<br>";
					if($query->num_rows()>0){
						foreach($query->result() as $row){
							// echo $row->nominal."<br>";
							$masuk=$masuk+$row->nominal;
						}
						echo $masuk."<br>";
					}
					else{
						$masuk=0;
						echo $masuk."<br>";
					}
				}
			}
		}
	?>
</div>