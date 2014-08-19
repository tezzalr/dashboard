<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2 style="float:left">Top Anchor Bank Mandiri</h2>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>bankwide/top_volume/<?php echo $product?>">Volume</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_growth/<?php echo $product?>">Growth</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_nominal_growth/<?php echo $product?>">Nominal Growth</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div>
		<div>
			<h3>Volume <?php echo $prd_name?></h3>
			<div style="margin-left:20px">
				<div style="width:50%; float:left; padding-right:20px;">
					<h4>Top Volume (Rp M)</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead><tr>
							<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
						</tr><tr>
							<th>Actual</th><th>Juni</th><th>YTD 2014</th><th>Kontribusi (%)</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_vol as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
								
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
								$trgt_tot = $trgt_tot + $anchor->$trgt;
								$sum_cmpny++;
								if(($temp_tot/$total_prd->$vol) > 0.7  && $sum_cmpny >5){break;}
						 	}?>
						 <tr>
							 <td><b>Sub-total</b></td><td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
							 
							 <td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($temp_tot/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($temp_tot/$total_prd->$vol*100,0,',','.')?> %</td>
						 </tr>
						</tbody>
					</table>
				</div>
				<div style="width:50%;  float:left">
					<h4>Top Nominal Growth (Rp M)</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead><tr>
							<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
						</tr><tr>
							<th>Actual</th><th>Juni</th><th>YTD 2014</th><th>Nominal Growth</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $nomgrowtot=0; $trgt_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_nom_grow as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
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
								$trgt_tot = $trgt_tot + $anchor->$trgt;
								$nomgrowtot = $nomgrowtot+$anchor->nom_grow;
						 	}?>
						 <tr>
							 <td><b>Sub-total</b></td><td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
							 
							 <td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($temp_tot/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($nomgrowtot/pow(10,$bagi),0,',','.')?></td>
						 </tr>
						</tbody>
					</table>
				</div>
				<div style="width:50%;  float:left; padding-right:20px;">
					<h4>Top Growth (%)</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead><tr>
							<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=4><center>2014</center></th>
						</tr><tr>
							<th>Actual</th><th>Target</th><th>Juni</th><th>YTD 2014</th><th>Growth</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_grow as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$trgt,1,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($ytd/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->grow*100,0,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						</tbody>
					</table>
				</div>
				
				<!--<div style="width:50%;  float:left; padding-right:20px;">
					<h4>Top Growth (%) - Sampai Bulan Ini</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead><tr>
							<th><center>Nama Anchor</center></th><th>2013</th><th><center>2014</center></th><th>Growth</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_grow_tm as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->grow*100,0,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						 	<tr><td></td><td></td><td></td><td></td></tr>
						 	<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_grow_tm_min as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->grow*100,2,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						</tbody>
					</table>
				</div>
				
				<div style="width:50%;  float:left; padding-right:20px;">
					<h4>Top Nom Growth  - Sampai Bulan Ini</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead><tr>
							<th><center>Nama Anchor</center></th><th>2013</th><th><center>2014</center></th><th>Growth</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_nom_grow_tm as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->nom_grow/pow(10,$bagi),0,',','.')?></td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						 	<tr><td></td><td></td><td></td><td></td></tr>
						 	<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_nom_grow_tm_min as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),1,',','.')?></td>
								<td><?php echo number_format($anchor->nom_grow/pow(10,$bagi),2,',','.')?></td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						</tbody>
					</table>
				</div>-->
			</div>
			<div>
			</div>
		</div>
	</div>
</div>