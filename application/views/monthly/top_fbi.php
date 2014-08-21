<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<?php foreach($pareto as $fbi){?>
			<div style="padding-right:20px; padding-top:5px; width:50%; float:left;">
				<h3><?php echo $fbi['name']?></h3>
				<table class="table table-bordered" style="font-size:10px;">
					<thead><tr class="headertab">
						<th><center>Nama Anchor</center></th><th>Des 2013</th><th>%-se</th><th><center>Jul 2014</center></th><th>%-se</th>
					</tr></thead><tbody>
					<?php 
						$vol = $fbi['name']."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
						if($fbi['name']=='Trade' || $fbi['name']=='FX'){$bagi=6;}
						elseif($fbi['name']=='OIR'){$bagi=0;}
						else{$bagi=9;} $i=0;
						foreach($fbi['prod'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
						<tr>
							<td><?php echo $anchor->name?></td>
							<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
							<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
							<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
							<td><?php echo number_format($anchor->$ly/$fbi['ly']->$vol*100,1,',','.')?> %</td>
							<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
							<td><?php echo number_format($anchor->$vol/$fbi['tm']->$vol*100,1,',','.')?> %</td>
						</tr>
					<?php
					
							$temp_tot = $temp_tot + $anchor->$vol;
							$ly_tot = $ly_tot + $anchor->$ly;
							$trgt_tot = $trgt_tot + $anchor->$trgt;
							$sum_cmpny++; $i++;
							if($i==6){break;}
						}?>
					<tr class="headertab">
						<td style="font-size:11px"><b>Sub-total</b></td>
						<td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($ly_tot/$fbi['ly']->$vol*100,0,',','.')?> %</td>
						<td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($temp_tot/$fbi['tm']->$vol*100,0,',','.')?> %</td>
					 </tr>
					 <tr class="headertab">
						<td  style="font-size:11px"><b>Total</b></td>
						<td><?php echo number_format($fbi['ly']->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format(100,0,',','.')?> %</td>
						<td><?php echo number_format($fbi['tm']->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format(100,0,',','.')?> %</td>
					 </tr>
					</tbody>
				</table>
			</div>
		<?php }?>
		
		<div style="clear:both"></div>
		<br>
	</div>
</div>