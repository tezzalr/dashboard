<?php 
	$year = date('Y');
	$loan_ty = ($ws_inc['ty']->WCL_nii +  $ws_inc['ty']->IL_nii +  $ws_inc['ty']->SL_nii + $ws_inc['ty']->TR_nii)/$month*12/pow(10,9);
	$trx_ty = ((($ws_inc['ty']->FX_fbi + $ws_inc['ty']->Trade_fbi + $ws_inc['ty']->PWE_fbi + $ws_inc['ty']->BG_fbi + $ws_inc['ty']->OIR_fbi + $ws_inc['ty']->OW_fbi + $ws_inc['ty']->CASA_fbi)/$month*12) + $ws_inc['ty']->IL_fbi + $ws_inc['ty']->WCL_fbi + $ws_inc['ty']->SL_fbi)/pow(10,9);
	$casa_ty = ($ws_inc['ty']->CASA_nii/$month*12/pow(10,9));
	$other_ty = ($ws_inc['ty']->TD_nii +  $ws_inc['ty']->OW_nii +  $ws_inc['ty']->SCF_fbi + $ws_inc['ty']->ECM_fbi + $ws_inc['ty']->DCM_fbi + $ws_inc['ty']->MA_fbi)/$month*12/pow(10,9);
	$nonloan_ty = $trx_ty + $casa_ty + $other_ty;
	$loan_pct_ty = $loan_ty/($loan_ty+$nonloan_ty)*100;
	$nonloan_pct_ty = $nonloan_ty/($loan_ty+$nonloan_ty)*100;
	
	$loan_ly = ($ws_inc['ly']->WCL_nii +  $ws_inc['ly']->IL_nii +  $ws_inc['ly']->SL_nii + $ws_inc['ly']->TR_nii)/pow(10,9);
	$trx_ly = ($ws_inc['ly']->FX_fbi + $ws_inc['ly']->Trade_fbi + $ws_inc['ly']->PWE_fbi + $ws_inc['ly']->BG_fbi + $ws_inc['ly']->OIR_fbi + $ws_inc['ly']->OW_fbi + $ws_inc['ty']->CASA_fbi + $ws_inc['ly']->IL_fbi + $ws_inc['ly']->WCL_fbi + $ws_inc['ly']->SL_fbi)/pow(10,9);
	$casa_ly = ($ws_inc['ly']->CASA_nii/pow(10,9));
	$other_ly = ($ws_inc['ly']->TD_nii +  $ws_inc['ly']->OW_nii +  $ws_inc['ly']->SCF_fbi + $ws_inc['ly']->ECM_fbi + $ws_inc['ly']->DCM_fbi + $ws_inc['ly']->MA_fbi)/pow(10,9);
	$nonloan_ly = $trx_ly + $casa_ly + $other_ly;
	$loan_pct_ly = $loan_ly/($loan_ly+$nonloan_ly)*100;
	$nonloan_pct_ly = $nonloan_ly/($loan_ly+$nonloan_ly)*100;
?>


<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_ly').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Income 2013'
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
							format: '<b>{point.name}</b>:<br> {point.percentage:.1f} %',
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Non Loan',   <?php echo $nonloan_ly?>],
						['Loan',   <?php echo $loan_ly?>]
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
			$('#container_ty').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Income 2014 (Ann.)'
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
							format: '<b>{point.name}</b>:<br> {point.percentage:.1f} %',
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Non Loan',   <?php echo $nonloan_ty?>],
						['Loan',   <?php echo $loan_ty?>]
					]
				}]
			});
		});
	
	});
</script>

<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<a href="<?php echo base_url()?>report/trans_xsell/<?php echo $info_page['type'];?>/<?php echo $info_page['id'];?>"><span style="float:right">Transaction Cross Sell --></span></a>
		<h2>Komposisi Wholesale Income</h2>
		<h4 style="color:grey;">Komposisi Income Loan : Non Loan adalah <?php echo number_format($loan_pct_ly,1)." % : ".number_format($nonloan_pct_ly,1)." % (2013)";?> menjadi <?php echo number_format($loan_pct_ty,1)." % : ".number_format($nonloan_pct_ty,1)." % (2014)";?>
		</h4><br><br>
		
		<div style="width: 50%; margin: 0 auto; float:left;">
			<table class="table table-bordered" style="font-size:11px">
				<tr style="background-color:#08088A; color:white;"><th></th><th>2013<br>Real</th><th>2014<br>Annualized</th></tr>
				<tr style="background-color:#BDBDBD;"><td>Loan :</td><td><?php echo number_format($loan_ly,1)?></td><td><?php echo number_format($loan_ty,1)?></td></tr>
				<tr><td>Working Capital Loan</td><td><?php echo number_format($ws_inc['ly']->WCL_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->WCL_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Investment Loan</td><td><?php echo number_format($ws_inc['ly']->IL_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->IL_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Structured Loan</td><td><?php echo number_format($ws_inc['ly']->SL_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->SL_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Trust Receipt</td><td><?php echo number_format($ws_inc['ly']->TR_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->TR_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr style="background-color:#BDBDBD;"><td>Non Loan :</td><td><?php echo number_format($nonloan_ly,1)?></td><td><?php echo number_format($nonloan_ty,1)?></td></tr>
				<tr style="background-color:#A9D0F5;"><td>CASA</td><td><?php echo number_format($casa_ly,1)?></td><td><?php echo number_format($casa_ty,1)?></td></tr>
				<tr style="background-color:#A9D0F5;"><td>Transaction</td><td><?php echo number_format($trx_ly,1)?></td><td><?php echo number_format($trx_ty,1)?></td></tr>
				<tr><td>FX & Derivatives</td><td><?php echo number_format($ws_inc['ly']->FX_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->FX_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Trade Services</td><td><?php echo number_format($ws_inc['ly']->Trade_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->Trade_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Bank Guarantee</td><td><?php echo number_format($ws_inc['ly']->BG_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->BG_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Outgoing Int'l Remittance</td><td><?php echo number_format($ws_inc['ly']->OIR_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->OIR_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>PWE Non L/C</td><td><?php echo number_format($ws_inc['ly']->PWE_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->PWE_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Loan Maintenance Fee</td><td><?php echo number_format(($ws_inc['ly']->WCL_fbi+$ws_inc['ly']->IL_fbi)/pow(10,9),2)?></td><td><?php echo number_format(($ws_inc['ty']->WCL_fbi+$ws_inc['ty']->IL_fbi)/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Syndication Fee</td><td><?php echo number_format($ws_inc['ly']->SL_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->SL_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>FBI Others</td><td><?php echo number_format(($ws_inc['ly']->OW_fbi + $ws_inc['ly']->CASA_fbi)/pow(10,9),2)?></td><td><?php echo number_format(($ws_inc['ty']->OW_fbi + $ws_inc['ty']->CASA_fbi)/pow(10,9)/$month*12,2)?></td></tr>
				<tr style="background-color:#A9D0F5;"><td>Others</td><td><?php echo number_format($other_ly,1)?></td><td><?php echo number_format($other_ty,1)?></td></tr>
				<tr><td>Time Deposit</td><td><?php echo number_format($ws_inc['ly']->TD_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->TD_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>NII Others</td><td><?php echo number_format($ws_inc['ly']->OW_nii/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->OW_nii/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>Supply Chain Financing</td><td><?php echo number_format($ws_inc['ly']->SCF_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->SCF_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>ECM</td><td><?php echo number_format($ws_inc['ly']->ECM_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->ECM_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>DCM</td><td><?php echo number_format($ws_inc['ly']->DCM_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->DCM_fbi/pow(10,9)/$month*12,2)?></td></tr>
				<tr><td>M&A</td><td><?php echo number_format($ws_inc['ly']->MA_fbi/pow(10,9),2)?></td><td><?php echo number_format($ws_inc['ty']->MA_fbi/pow(10,9)/$month*12,2)?></td></tr>
			</table>
		</div>
		<div  style="width: 50%; float:left" >
			<div id="container_ly" style="width: 100%; height: 280px; margin: 0; float:left;"></div>
			<div id="container_ty" style="width: 100%; height: 280px; margin: 0; float:left;"></div>
			<div id="" style="width: 100%; height: 170px; margin: 0 auto; padding:10px; float:left; margin-top:54px;">
				<span style="float:right; font-size:11px;">(Rp Miliar)</span>
				<table class="table table-bordered">
					<tr style="background-color:#08088A; color:white;"><th></th><th>2013</th><th>2014 (Ann.)</th></tr>
					<tr><td>Loan</td><td><?php echo number_format($loan_ly,1)?></td><td><?php echo number_format($loan_ty,1)?></td></tr>
					<tr><td>Non Loan</td><td><?php echo number_format($nonloan_ly,1)?></td><td><?php echo number_format($nonloan_ty,1)?></td></tr>
					<tr><td>Total</td><td><?php echo number_format($loan_ly+$nonloan_ly,1)?></td><td><?php echo number_format($loan_ty+$nonloan_ty,1)?></td></tr>
				</table>
			</div>
		</div><div style="clear:both"></div>
		<br>
	</div>
</div>