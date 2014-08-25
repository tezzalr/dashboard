<?php
	$arrprodal = array('WM','DPLK','PCD','VCCD','VCL','Micro_Loan','MKM','KPR','Auto','CC','EDC','ATM','AXA','MAGI','retail','cicil_Emas');
	$arrprodname = array('Wealth Management','DPLK','Payroll Casa Deposit','Value Chain Casa Deposit','Value Chain Lending','Micro Loan','MKM & KTA','KPR & MGM','AUTO & 2W Loan','Credit Cards','EDC','ATM','Life Insurance - AXA','General Insurance - MAGI','Retail Trading - MANSEK','Cicil Emas - BSM');
	
	function get_inc($prod){
		$arrfbial = array('DPLK','EDC','ATM','AXA','MAGI','retail','cicil_Emas');
		$arrniial = array('WM','PCD','VCCD','VCL','Micro_Loan','MKM','KPR','Auto','CC');
	
		if(in_array($prod,$arrfbial)){return "fbi";}
		elseif(in_array($prod,$arrniial)){return "nii";}
	}
	
	function get_inc_val($prod, $al_inc, $kind){
		$arrfbial = array('DPLK','EDC','ATM','AXA','MAGI','retail','cicil_Emas');
		$arrniial = array('WM','PCD','MKM','KPR','Auto','CC');
		$arrbothal = array('VCCD','VCL','VCLnDF','OA','Micro_Loan');
		
		if($prod == "VCL"){
			return $al_inc[$kind]->VCL_nii + $al_inc[$kind]->VCL_fbi + $al_inc[$kind]->VCLnDF_nii + $al_inc[$kind]->VCLnDF_fbi;
		}
		else{
			if(in_array($prod,$arrniial)){
				$prods = $prod."_nii";
				return $al_inc[$kind]->$prods;
			}
			elseif(in_array($prod,$arrfbial)){
				$prods = $prod."_fbi";
				return $al_inc[$kind]->$prods;
			}
			else{
				$fbi = $prod."_fbi"; $nii = $prod."_nii";
				return $al_inc[$kind]->$fbi + $al_inc['ty']->$nii;
			}
		}
	}
	
	$tot = 0;
	$i = 0;
	$has_al = array();
	foreach($arrprodal as $alprod){ 
		$has_al [$i]['name'] = $arrprodname[$i];
		$has_al [$i]['val_ty'] = get_inc_val($alprod,$al_inc, 'ty');
		$has_al [$i]['val_ly'] = get_inc_val($alprod,$al_inc, 'ly');
		$tot = $tot + get_inc_val($alprod,$al_inc, 'ty');
		$i++;				
	}
	
	usort($has_al, function($a, $b) {
		return $b['val_ty'] - $a['val_ty'];
	});
	//$tot = $tot + (($al_inc['ty']->VCL_fbi + $al_inc['ty']->VCCD_fbi + $al_inc['ty']->VCLnDF_nii + $al_inc['ty']->VCLnDF_fbi)/pow(10,9));
?>
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
							enabled: false,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						},
						showInLegend: true
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
							<?php foreach($has_al as $al){ if($al['val_ty']){?>
								[<?php echo "'".$al['name']."'";?>,<?php echo $al['val_ty']?>],
							<?php }}?>
						/*<?php if($al_inc['ty']->WM_nii){?> ['Wealth Management', <?php echo ($al_inc['ty']->WM_nii);?>],<?php }?>
						<?php if($al_inc['ty']->DPLK_fbi){?> ['DPLK', <?php echo ($al_inc['ty']->DPLK_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->PCD_nii){?> ['Payroll Casa Deposit', <?php echo ($al_inc['ty']->PCD_nii);?>],<?php }?>
						<?php if($al_inc['ty']->VCCD_nii + $al_inc['ty']->VCCD_fbi){?> ['Value Chain Casa Deposit', <?php echo ($al_inc['ty']->VCCD_nii + $al_inc['ty']->VCCD_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->VCL_nii + $al_inc['ty']->VCL_fbi + $al_inc['ty']->VCLnDF_nii + $al_inc['ty']->VCLnDF_fbi){?> ['Value Chain Lending', <?php echo ($al_inc['ty']->VCLnDF_nii + $al_inc['ty']->VCLnDF_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->Micro_Loan_nii + $al_inc['ty']->Micro_Loan_fbi){?> ['Micro Loan', <?php echo ($al_inc['ty']->Micro_Loan_nii + $al_inc['ty']->Micro_Loan_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->MKM_nii){?> ['MKM & KTA', <?php echo ($al_inc['ty']->MKM_nii);?>],<?php }?>
						<?php if($al_inc['ty']->KPR_nii){?> ['KPR & MGM', <?php echo ($al_inc['ty']->KPR_nii);?>],<?php }?>
						<?php if($al_inc['ty']->Auto_nii){?> ['AUTO & 2W Loan', <?php echo ($al_inc['ty']->Auto_nii);?>],<?php }?>
						<?php if($al_inc['ty']->CC_nii){?> ['Credit Cards', <?php echo ($al_inc['ty']->CC_nii);?>],<?php }?>
						<?php if($al_inc['ty']->EDC_fbi){?> ['EDC', <?php echo ($al_inc['ty']->EDC_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->ATM_fbi){?> ['ATM', <?php echo ($al_inc['ty']->ATM_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->AXA_fbi){?> ['Life Insurance - AXA', <?php echo ($al_inc['ty']->AXA_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->MAGI_fbi){?> ['General Insurance - MAGI', <?php echo ($al_inc['ty']->MAGI_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->retail_fbi){?> ['Retail Trading - MANSEK', <?php echo ($al_inc['ty']->retail_fbi);?>],<?php }?>
						<?php if($al_inc['ty']->cicil_Emas_fbi){?> ['Cicil Emas - BSM', <?php echo ($al_inc['ty']->cicil_Emas_fbi);?>],<?php }?>*/
					]
				}]
			});
		});
	
	});
</script>

<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<!--<a href="<?php echo base_url()?>report/trans_xsell/<?php echo $info_page['type'];?>/<?php echo $info_page['id'];?>"><span style="float:right">Transaction Cross Sell </span></a>-->
		<h2>Komposisi Alliance Income</h2>
		<h4 style="color:grey;">Penyumbang Aliansi terbesar : <?php echo $has_al[0]['name']?>, sebesar <?php echo number_format($has_al[0]['val_ty']/pow(10,9),1)?> Miliar atau <?php echo number_format($has_al[0]['val_ty']/$tot*100,1)?>%
		</h4><br><br>
		
		<div style="width: 65%; margin: 0 auto; float:left;">
			<table class="table table-bordered">
				<tr style="background-color:#08088A; color:white;"><th rowspan=2></th><th>2013<th colspan=4>2014</th></tr>
				<tr style="background-color:#08088A; color:white;"><th>Real<th>Real Juni 2014</th><th>Annualized</th><th>Kontributsi</th></tr>
				<?php $i = 0; foreach($arrprodal as $alprod){ $typeinc = get_inc($alprod); $prodinc = $alprod."_".$typeinc;?>
					<tr>
						<td><?php echo $arrprodname[$i]?></td>
						<?php 
							if($alprod == "VCCD"){$incymt_ty = $al_inc['ty']->VCCD_nii + $al_inc['ty']->VCCD_fbi; $incymt_ly = $al_inc['ly']->VCCD_nii + $al_inc['ly']->VCCD_fbi;} 
							elseif($alprod == "VCL"){
								$incymt_ty = $al_inc['ty']->VCL_nii + $al_inc['ty']->VCL_fbi + $al_inc['ty']->VCLnDF_nii + $al_inc['ty']->VCLnDF_fbi; 
								$incymt_ly = $al_inc['ly']->VCL_nii + $al_inc['ly']->VCL_fbi + $al_inc['ly']->VCLnDF_nii + $al_inc['ly']->VCLnDF_fbi;
							}
							else{
								$incymt_ty = $al_inc['ty']->$prodinc;
								$incymt_ly = $al_inc['ly']->$prodinc;
							}
						?>
						<td><?php echo number_format($incymt_ly/pow(10,9),1)?></td>
						<td><?php echo number_format($incymt_ty/pow(10,9),1)?></td>
						<td><?php echo number_format($incymt_ty/pow(10,9)/$month*12,1)?></td>
						<td><?php echo number_format($incymt_ty/$tot*100,1)?> %</td>
					</tr>
				<?php $i++;}?>
			</table>
		</div>
		<div  style="width: 35%; float:left" >
			<div id="container_al" style="width: 100%; height: 500px; margin: 0; float:left;"></div>
		</div><div style="clear:both"></div>
		<br>
	</div>
</div>