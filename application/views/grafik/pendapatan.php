<?php
	
	$nii_income_ws = $rlzn->WCL_nii +  $rlzn->IL_nii +  $rlzn->SL_nii + $rlzn->CASA_nii + $rlzn->TR_nii + $rlzn->OW_nii + $rlzn->TD_nii;
	$fbi_income_ws = $rlzn->CASA_fbi + $rlzn->FX_fbi + $rlzn->SCF_fbi + $rlzn->Trade_fbi + $rlzn->PWE_fbi + $rlzn->BG_fbi + $rlzn->OIR_fbi + $rlzn->OW_fbi + $rlzn->IL_fbi + $rlzn->SL_fbi + $rlzn->WCL_fbi;
	
	$loan_income = $rlzn->WCL_nii +  $rlzn->IL_nii +  $rlzn->SL_nii + $rlzn->TR_nii;
	$trx_income = $rlzn->CASA_nii + $rlzn->FX_fbi + $rlzn->SCF_fbi + $rlzn->Trade_fbi + $rlzn->PWE_fbi + $rlzn->BG_fbi + $rlzn->OIR_fbi;
	
	
	$ws_income = $nii_income_ws + $fbi_income_ws;
	$al_income = $ali->WM_nii + $ali->DPLK_fbi + $ali->PCD_nii + $ali->VCCD_nii + $ali->VCCD_fbi + $ali->VCL_nii + $ali->VCL_fbi+ $ali->VCLnDF_nii + $ali->VCLnDF_fbi + $ali->Micro_Loan_nii + $ali->Micro_Loan_fbi + 
					$ali->MKM_nii + $ali->KPR_nii + $ali->Auto_nii + $ali->CC_nii + $ali->EDC_fbi + $ali->ATM_fbi + $ali->AXA_fbi + $ali->MAGI_fbi + $ali->retail_fbi + $ali->cicil_Emas_fbi;
	$tot_income = $ws_income + $al_income;
	
	$trx_wallet = $wlt->CASA_nii + $wlt->FX_fbi + $wlt->SCF_fbi + $wlt->Trade_fbi + $wlt->PWE_fbi + $wlt->BG_fbi + $wlt->OIR_fbi;
	$loan_wallet = $wlt->WCL_nii +  $wlt->IL_nii +  $wlt->SL_nii + $wlt->TR_nii;
	
	$trx_sow = $trx_income/$month*12/$trx_wallet/pow(10,9);
	$loan_sow = $loan_income/$month*12/$loan_wallet/pow(10,9);
	
	$al_ytd = $al_income/$month*12;
	$ws_ytd = $nii_income_ws/$month*12+(($rlzn->CASA_fbi + $rlzn->FX_fbi + $rlzn->SCF_fbi + $rlzn->Trade_fbi + $rlzn->PWE_fbi + $rlzn->BG_fbi + $rlzn->OIR_fbi + $rlzn->OW_fbi)/$month*12) + ($rlzn->IL_fbi + $rlzn->SL_fbi + $rlzn->WCL_fbi);
	
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
						<?php if($rlzn->CASA_nii){?> ['CASA', <?php echo $rlzn->CASA_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->TD_nii){?>['Time Deposit', <?php echo $rlzn->TD_nii/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->WCL_nii){?>['Working Capital Loan', <?php echo $rlzn->WCL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->IL_nii){?>['Investment Loan', <?php echo $rlzn->IL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->SL_nii){?>['Structured Loan', <?php echo $rlzn->SL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->TR_nii){?>['Trust Receipt', <?php echo $rlzn->TR_nii/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->OW_nii){?>['NII Others', <?php echo $rlzn->OW_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->FX_fbi){?>['FX & Derivatives', <?php echo $rlzn->FX_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->SCF_fbi){?> ['Supply Chain Financing', <?php echo $rlzn->SCF_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->Trade_fbi){?>['Trade Services', <?php echo $rlzn->Trade_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->BG_fbi){?>['Bank Guarantee',  <?php echo $rlzn->BG_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->OIR_fbi){?>['Outgoing Intl Remittance', <?php echo $rlzn->OIR_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->PWE_fbi){?> ['PWE non L/C',       <?php echo $rlzn->PWE_fbi/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->WCL_fbi + $rlzn->IL_fbi){?>['Loan Maintainance FEE', <?php echo (($rlzn->WCL_fbi + $rlzn->IL_fbi));?>],<?php }?>
						<?php if($rlzn->SL_fbi){?>['Syndication FEE', <?php echo ($rlzn->SL_fbi);?>],<?php }?>
						<?php if($rlzn->OW_fbi){?>['FBI Others', <?php echo (($rlzn->OW_fbi + $rlzn->CASA_fbi)/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->ECM_fbi){?>['ECM', <?php echo ($rlzn->ECM_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->DCM_fbi){?>['DCM', <?php echo ($rlzn->DCM_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->MA_fbi){?>['M&A', <?php echo ($rlzn->MA_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->WM_nii){?> ['Wealth Management', <?php echo ($ali->WM_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->DPLK_fbi){?> ['DPLK', <?php echo ($ali->DPLK_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->PCD_nii){?> ['Payroll Casa Deposit', <?php echo ($ali->PCD_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->VCCD_nii + $ali->VCCD_fbi){?> ['Value Chain Casa Deposit', <?php echo ($ali->VCCD_nii + $ali->VCCD_fbi)/$rlzn->month*12;?>],<?php }?>
						<?php if($ali->VCL_nii + $ali->VCL_fbi + $ali->VCLnDF_nii + $ali->VCLnDF_fbi){?> ['Value Chain Lending', <?php echo ($ali->VCLnDF_nii + $ali->VCLnDF_fbi)/$rlzn->month*12;?>],<?php }?>
						<?php if($ali->Micro_Loan_nii + $ali->Micro_Loan_fbi){?> ['Micro Loan', <?php echo ($ali->Micro_Loan_nii + $ali->Micro_Loan_fbi)/$rlzn->month*12;?>],<?php }?>
						<?php if($ali->MKM_nii){?> ['MKM & KTA', <?php echo ($ali->MKM_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->KPR_nii){?> ['KPR & MGM', <?php echo ($ali->KPR_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->Auto_nii){?> ['AUTO & 2W Loan', <?php echo ($ali->Auto_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->CC_nii){?> ['Credit Cards', <?php echo ($ali->CC_nii/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->EDC_fbi){?> ['EDC', <?php echo ($ali->EDC_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->ATM_fbi){?> ['ATM', <?php echo ($ali->ATM_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->AXA_fbi){?> ['Life Insurance - AXA', <?php echo ($ali->AXA_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->MAGI_fbi){?> ['General Insurance - MAGI', <?php echo ($ali->MAGI_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->retail_fbi){?> ['Retail Trading - MANSEK', <?php echo ($ali->retail_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($ali->cicil_Emas_fbi){?> ['Cicil Emas - BSM', <?php echo ($ali->cicil_Emas_fbi/$rlzn->month*12);?>],<?php }?>
						
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
						<?php if($rlzn->CASA_nii){?> ['CASA', <?php echo $rlzn->CASA_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->TD_nii){?>['Time Deposit', <?php echo $rlzn->TD_nii/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->WCL_nii){?>['Working Capital Loan', <?php echo $rlzn->WCL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->IL_nii){?>['Investment Loan', <?php echo $rlzn->IL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->SL_nii){?>['Structured Loan', <?php echo $rlzn->SL_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->TR_nii){?>['Trust Receipt', <?php echo $rlzn->TR_nii/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->OW_nii){?>['NII Others', <?php echo $rlzn->OW_nii/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->FX_fbi){?>['FX & Derivatives', <?php echo $rlzn->FX_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->SCF_fbi){?> ['Supply Chain Financing', <?php echo $rlzn->SCF_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->Trade_fbi){?>['Trade Services', <?php echo $rlzn->Trade_fbi/$rlzn->month*12?>],<?php }?>
						<?php if($rlzn->BG_fbi){?>{
							name: 'Bank Guarantee',       
							y: <?php echo $rlzn->BG_fbi/$rlzn->month*12?>,
							color: 'red'
						},<?php }?>
						<?php if($rlzn->OIR_fbi){?>{
							name: 'Outgoing Intl Remittance',       
							y: <?php echo $rlzn->OIR_fbi/$rlzn->month*12?>,
							color: 'green'
						},<?php }?>
						<?php if($rlzn->PWE_fbi){?> ['PWE non L/C',       <?php echo $rlzn->PWE_fbi/$rlzn->month*12;?>],<?php }?>
						<?php if($rlzn->WCL_fbi + $rlzn->IL_fbi){?>['Loan Maintainance FEE', <?php echo (($rlzn->WCL_fbi + $rlzn->IL_fbi));?>],<?php }?>
						<?php if($rlzn->SL_fbi){?>['Syndication FEE', <?php echo ($rlzn->SL_fbi);?>],<?php }?>
						<?php if($rlzn->OW_fbi){?>['FBI Others', <?php echo (($rlzn->OW_fbi + $rlzn->CASA_fbi)/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->ECM_fbi){?>['ECM', <?php echo ($rlzn->ECM_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->DCM_fbi){?>['DCM', <?php echo ($rlzn->DCM_fbi/$rlzn->month*12);?>],<?php }?>
						<?php if($rlzn->MA_fbi){?>['M&A', <?php echo ($rlzn->MA_fbi/$rlzn->month*12);?>],<?php }?>
						//['Loan Maintenance Fee',       0],
						//['Syndication Fee',       0],
						//['FBI Other',       0]
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
						<?php if($ali->WM_nii){?> ['Wealth Management', <?php echo ($ali->WM_nii);?>],<?php }?>
						<?php if($ali->DPLK_fbi){?> ['DPLK', <?php echo ($ali->DPLK_fbi);?>],<?php }?>
						<?php if($ali->PCD_nii){?> ['Payroll Casa Deposit', <?php echo ($ali->PCD_nii);?>],<?php }?>
						<?php if($ali->VCCD_nii + $ali->VCCD_fbi){?> ['Value Chain Casa Deposit', <?php echo ($ali->VCCD_nii + $ali->VCCD_fbi);?>],<?php }?>
						<?php if($ali->VCL_nii + $ali->VCL_fbi + $ali->VCLnDF_nii + $ali->VCLnDF_fbi){?> ['Value Chain Lending', <?php echo ($ali->VCLnDF_nii + $ali->VCLnDF_fbi);?>],<?php }?>
						<?php if($ali->Micro_Loan_nii + $ali->Micro_Loan_fbi){?> ['Micro Loan', <?php echo ($ali->Micro_Loan_nii + $ali->Micro_Loan_fbi);?>],<?php }?>
						<?php if($ali->MKM_nii){?> ['MKM & KTA', <?php echo ($ali->MKM_nii);?>],<?php }?>
						<?php if($ali->KPR_nii){?> ['KPR & MGM', <?php echo ($ali->KPR_nii);?>],<?php }?>
						<?php if($ali->Auto_nii){?> ['AUTO & 2W Loan', <?php echo ($ali->Auto_nii);?>],<?php }?>
						<?php if($ali->CC_nii){?> ['Credit Cards', <?php echo ($ali->CC_nii);?>],<?php }?>
						<?php if($ali->EDC_fbi){?> ['EDC', <?php echo ($ali->EDC_fbi);?>],<?php }?>
						<?php if($ali->ATM_fbi){?> ['ATM', <?php echo ($ali->ATM_fbi);?>],<?php }?>
						<?php if($ali->AXA_fbi){?> ['Life Insurance - AXA', <?php echo ($ali->AXA_fbi);?>],<?php }?>
						<?php if($ali->MAGI_fbi){?> ['General Insurance - MAGI', <?php echo ($ali->MAGI_fbi);?>],<?php }?>
						<?php if($ali->retail_fbi){?> ['Retail Trading - MANSEK', <?php echo ($ali->retail_fbi);?>],<?php }?>
						<?php if($ali->cicil_Emas_fbi){?> ['Cicil Emas - BSM', <?php echo ($ali->cicil_Emas_fbi);?>],<?php }?>
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
					text: 'Komposisi Wholesale vs Alliance'
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
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Wholesale',   <?php echo $ws_income?>],
						['Alliance',      <?php echo $al_income?>],
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
			$('#container_nii').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi NII vs FBI'
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
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['FBI',   <?php echo $fbi_income_ws?>],
						['NII',   <?php echo $nii_income_ws?>]
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
					text: 'Komposisi Loan vs TRX + CASA'
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
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Loan',   <?php echo $loan_income?>],
						['CASA + TRX',   <?php echo $trx_income?>]
					]
				}]
			});
		});
	
	});
</script>


<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<div>
			<div id="container_wsa" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left; margin-bottom:50px;"></div>
			<div id="" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left; margin-bottom:50px; padding-left:100px;">
				<span style="font-size:25px">Total Relationship Income : <?php echo number_format($tot_income/pow(10,9),1,'.',',')?></span><br>
				<div>
					<span style="font-size:16px">Total Wholesale : <?php echo number_format($ws_income/pow(10,9),1,'.',',')?></span><br>
					<span style="font-size:16px">Total Alliance : <?php echo number_format($al_income/pow(10,9),1,'.',',')?></span>
				</div><hr>
				<table>
					<tr><td style="width:200px">TRX X-SELL</td><td><?php echo number_format($trx_sow/$loan_sow,2,'.',',');?></td></tr>
					<tr><td style="width:200px">ALL X-SELL</td><td><?php echo number_format($al_ytd/$ws_ytd*100,0,'.',',')?>%</td></tr>
				</table>
			</div>
			<div id="container_nii" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left; margin-bottom:50px;"></div>
			<div id="container_lnl" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left; margin-bottom:50px;"></div>
		</div><div style="clear:both"></div><hr>
		<div id="container_all" style="min-width: 310px; width: 100%; height: 500px; margin: 0; float:left"></div><div style="clear:both"></div><hr>
		<div id="container_ws" style="min-width: 310px; width: 100%; height: 500px; margin: 0; float:left"></div><div style="clear:both"></div><hr>
		<div id="container_al" style="min-width: 310px; width: 100%; height: 500px; margin: 0; float:left"></div><div style="clear:both"></div><hr>
	</div><div style="clear:both"></div><br><br>
</div>