<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<div style="padding-right:20px; padding-top:20px; width:50%; float:left;">
			<h3>CASA</h3>
			<table class="table table-bordered" style="font-size:10px;">
				<thead><tr class="headertab">
					<th><center>Nama Anchor</center></th><th>Des 2013</th><th>%-se</th><th><center>Jul 2014</center></th><th>%-se</th>
				</tr></thead><tbody>
				<?php 
					$vol = "CASA_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
					$bagi=9; $i=0;
					foreach($pareto['casa'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
					<tr>
						<td><?php echo $anchor->name?></td>
						<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
						<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$ly/$total['casa']['ly']->$vol*100,1,',','.')?> %</td>
						<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total['casa']['tm']->$vol*100,1,',','.')?> %</td>
					</tr>
				<?php
					
						$temp_tot = $temp_tot + $anchor->$vol;
						$ly_tot = $ly_tot + $anchor->$ly;
						$trgt_tot = $trgt_tot + $anchor->$trgt;
						$sum_cmpny++; $i++;
						if($i==6){break;}
					}?>
				<tr class="headertab">
					<td style="font-size:12px"><b>Sub-total</b></td>
					<td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
				 	<td><?php echo number_format($ly_tot/$total['casa']['ly']->$vol*100,0,',','.')?> %</td>
					<td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format($temp_tot/$total['casa']['tm']->$vol*100,0,',','.')?> %</td>
				 </tr>
				 <tr class="headertab">
					<td  style="font-size:12px"><b>Total</b></td>
					<td><?php echo number_format($total['casa']['ly']->$vol/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format(100,0,',','.')?> %</td>
					<td><?php echo number_format($total['casa']['tm']->$vol/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format(100,0,',','.')?> %</td>
				 </tr>
				</tbody>
			</table>
		</div>
		
		<div style="padding-right:20px; padding-top:20px; width:50%; float:left;">
			<h3>Kredit</h3>
			<table class="table table-bordered" style="font-size:10px;">
				<thead><tr class="headertab">
					<th><center>Nama Anchor</center></th><th>Des 2013</th><th>%-se</th><th><center>Jul 2014</center></th><th>%-se</th>
				</tr></thead><tbody>
				<?php 
					$vol = "kredit_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt_tot=0;
					$bagi=9; $i=0;
					foreach($pareto['kredit'] as $anchor){ ?>
					<tr>
						<td><?php echo $anchor->name?></td>
						<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
						<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$ly/$total['kredit']['ly']*100,1,',','.')?> %</td>
						<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total['kredit']['tm']*100,1,',','.')?> %</td>
					</tr>
				<?php
					
						$temp_tot = $temp_tot + $anchor->$vol;
						$ly_tot = $ly_tot + $anchor->$ly;
						$sum_cmpny++; $i++;
						if($i==6){break;}
					}?>
				<tr class="headertab">
					<td style="font-size:12px"><b>Sub-total</b></td>
					<td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
				 	<td><?php echo number_format($ly_tot/$total['kredit']['ly']*100,0,',','.')?> %</td>
					<td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format($temp_tot/$total['kredit']['tm']*100,0,',','.')?> %</td>
				 </tr>
				 <tr class="headertab">
					<td  style="font-size:12px"><b>Total</b></td>
					<td><?php echo number_format($total['kredit']['ly']/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format(100,0,',','.')?> %</td>
					<td><?php echo number_format($total['kredit']['tm']/pow(10,$bagi),0,',','.')?></td>
					<td><?php echo number_format(100,0,',','.')?> %</td>
				 </tr>
				</tbody>
			</table>
		</div>
		<div style="clear:both"></div>
		<br>
	</div>
	<div id="container_casa" style="height:400px;"></div>
</div>