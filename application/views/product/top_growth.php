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
			<!--<div style="margin-left:20px">
				<h4>Top 5 Volume</h4>
				<div style="width:50%">
					<table class="table table-striped">
						<thead><tr>
							<th>Nama Anchor</th><th>Real 2013</th><th>Real YTD 2014</th>
						</tr></thead><tbody>
						<tr>
							<td>Pertamina</td><td>14.289</td><td>16.032</td>
						</tr>
						<tr>
							<td>PLN Group</td><td>14.289</td><td>16.032</td>
						</tr>
						<tr>
							<td>Wilmar Group</td><td>14.289</td><td>16.032</td>
						</tr>
						<tr>
							<td>Permata Hijau Sawit Group</td><td>14.289</td><td>16.032</td>
						</tr>
						<tr>
							<td>Sinar Mas Group</td><td>14.289</td><td>16.032</td>
						</tr></tbody>
					</table>
				</div>
			</div><hr>-->
			<div style="margin-left:20px">
				<h4>Top 5 Volume</h4>
				<div style="width:100%">
					<table class="table table-striped">
						<thead><tr>
							<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
						</tr><tr>
							<th>Target</th><th>Mei</th><th>YTD 2014</th><th>Growth</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->grow*100,0,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
						 	}?>
						 <tr>
							 
						 </tr>
						</tbody>
					</table>
				</div>
			</div>
			<div>
			</div>
		</div>
	</div>
</div>