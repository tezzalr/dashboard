<?php
	
	$loan_income = $rlzn->WCL_nii + $rlzn->WCL_fbi + $rlzn->IL_nii + $rlzn->IL_fbi + $rlzn->SL_nii + $rlzn->SL_fbi;
	$nonloan_income = $rlzn->TR_nii + $rlzn->FX_fbi + $rlzn->SCF_fbi + $rlzn->Trade_fbi + $rlzn->PWE_fbi + $rlzn->BG_fbi + $rlzn->OIR_fbi;

?>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_all').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Keseluruhan'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['CASA',   12.0],
						['Time Deposit',       26.8],
						{
							name: 'Loan',
							y: 45.8,
							sliced: true,
							selected: true
						},
						['Trade',    8.5],
						['Bank Guarantee',     6.2],
						['NII Others',   0.7]
					]
				}]
			});
		});
	
	});
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_ws').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Wholesale'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['CASA',   <?php echo ($rlzn->CASA_nii + $rlzn->CASA_fbi);?>],
						['Time Deposit',       <?php echo $rlzn->TD_nii?>],
						['Working Capital Loan',       <?php echo ($rlzn->WCL_nii + $rlzn->WCL_fbi);?>],
						['Investment Loan',       <?php echo ($rlzn->IL_nii + $rlzn->IL_fbi);?>],
						['Structured Loan',       <?php echo ($rlzn->SL_nii + $rlzn->SL_fbi);?>],
						['Trust Receipt',       <?php echo $rlzn->TR_nii?>],
						['NII Others',       0],
						['FX & Derivatives',       <?php echo $rlzn->FX_fbi?>],
						['Supply Chain Financing',       <?php echo $rlzn->SCF_fbi?>],
						['Trade Services',       <?php echo $rlzn->Trade_fbi?>],
						{
							name: 'Bank Guarantee',       
							y: <?php echo $rlzn->BG_fbi?>,
							color: 'yellow'
						},
						{
							name: 'Outgoing Intl Remittance',       
							y: <?php echo $rlzn->OIR_fbi?>,
							color: 'green'
						},
						['PWE non L/C',       <?php echo $rlzn->PWE_fbi?>],
						['Loan Maintenance Fee',       0],
						['Syndication Fee',       0],
						['FBI Other',       0]
					]
				}]
			});
		});
	
	});
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_al').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Alliance'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['CASA',   12.0],
						['Time Deposit',       26.8],
						{
							name: 'Loan',
							y: 45.8,
							sliced: true,
							selected: true
						},
						['Trade',    8.5],
						['Bank Guarantee',     6.2],
						['NII Others',   0.7]
					]
				}]
			});
		});
	
	});
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_lnl').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Loan vs Non Loan'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Non Loan',   <?php echo $nonloan_income?>],
						{
							name: 'Loan',
							y: <?php echo $loan_income?>,
							sliced: true,
							selected: true
						}
					]
				}]
			});
		});
	
	});
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_wsa').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Wholesale vs Alliance'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['CASA',   12.0],
						['Time Deposit',       26.8],
						{
							name: 'Loan',
							y: 45.8,
							sliced: true,
							selected: true
						},
						['Trade',    8.5],
						['Bank Guarantee',     6.2],
						['NII Others',   0.7]
					]
				}]
			});
		});
	
	});
</script>


<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2><?php echo $anchor->name?></h2>
		<h4><?php echo $anchor->group?></h4>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
			<li><a href="<?php echo base_url()?>anchor/pendapatan/<?php echo $anchor->id;?>">Income</a></li>
		  <li><a href="<?php echo base_url()?>anchor/profile">Profile</a></li>
		  <li><a href="<?php echo base_url()?>anchor/product">Product</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div id="container_all" style="min-width: 310px; width: 100%; height: 700px; margin: 0;"></div><br><br>
	<div>
		<div id="container_ws" style="min-width: 310px; width: 100%; height: 700px; margin: 0; float:left"></div>
		<div id="container_al" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
	</div><div style="clear:both"></div><br><br>
	<div>
		<div id="container_lnl" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		<div id="container_wsa" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
	</div><div style="clear:both"></div><br><br>
</div>