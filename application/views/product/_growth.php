<div>
	<h4>Top Nominal Growth (Rp M)</h4>
	<table class="table table-bordered" style="font-size:10px;">
		<thead class="headertab"><tr>
			<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
		</tr><tr>
			<th><?php if($asu=='ytd'){echo 'Des';}else{echo get_month_name($month);}?></th><th><?php echo get_month_name($month)?></th><th>YTD 2014</th><th>Nominal Growth</th>
		</tr></thead><tbody>
		<?php 
			$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $nomgrowtot=0; $trgt_tot=0;
			$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
			foreach($top_anchor['nom_grow'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
			<tr>
				<td><?php echo $anchor->name?></td>
				<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
		
				<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
				<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
				<td><?php echo number_format($anchor->nom_grow/pow(10,$bagi),0,',','.')?></td>
			</tr>
		<?php
		
				$temp_tot = $temp_tot + $anchor->$vol;
				$ly_tot = $ly_tot + $anchor->$ly;
				$nomgrowtot = $nomgrowtot+$anchor->nom_grow;
			}?>
		 <tr>
			 <td><b>Sub-total</b></td><td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
	 
			 <td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
			 <td><?php echo number_format($temp_tot/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
			 <td><?php echo number_format($nomgrowtot/pow(10,$bagi),0,',','.')?></td>
		 </tr>
		 <tr style="background-color:grey"><td></td><td></td><td></td><td></td><td></td></tr>
			<?php 
			$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
			$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
			foreach($top_anchor['nom_grow_min'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
			<tr>
				<td><?php echo $anchor->name?></td>
				<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
				<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
				<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
				<td><?php echo number_format($anchor->nom_grow/pow(10,$bagi),2,',','.')?></td>
			</tr>
		<?php
		
				$temp_tot = $temp_tot + $anchor->$vol;
				$ly_tot = $ly_tot + $anchor->$ly;
			}?>
		</tbody>
	</table>
</div>
<hr>
<div>
	<h4>Top Growth (%)</h4>
	<table class="table table-bordered" style="font-size:10px;">
		<thead class="headertab"><tr>
			<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
		</tr><tr>
			<th><?php if($asu=='ytd'){echo 'Des';}else{echo get_month_name($month);}?></th><th><?php echo get_month_name($month)?></th><th>YTD 2014</th><th>Growth</th>
		</tr></thead><tbody>
		<?php 
			$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
			$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
			foreach($top_anchor['grow'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
			<tr>
				<td><?php echo $anchor->name?></td>
				<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
				
				<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
				<td><?php echo number_format($ytd/pow(10,$bagi),1,',','.')?></td>
				<td><?php echo number_format($anchor->grow*100,0,',','.')?> %</td>
			</tr>
		<?php
		
				$temp_tot = $temp_tot + $anchor->$vol;
				$ly_tot = $ly_tot + $anchor->$ly;
			}?>
			<tr style="background-color:grey"><td></td><td></td><td></td><td></td><td></td></tr>
			<?php 
				$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
				$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
				foreach($top_anchor['grow_min'] as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
				<tr>
					<td><?php echo $anchor->name?></td>
					<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
					
					<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
					<td><?php echo number_format($ytd/pow(10,$bagi),1,',','.')?></td>
					<td><?php echo number_format($anchor->grow*100,2,',','.')?> %</td>
				</tr>
			<?php
		
					$temp_tot = $temp_tot + $anchor->$vol;
					$ly_tot = $ly_tot + $anchor->$ly;
				}?>
		</tbody>
	</table>
</div>