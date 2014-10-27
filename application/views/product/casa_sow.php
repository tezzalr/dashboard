<div id="" class="container no_pad">
	<!--<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>bankwide/top_volume/<?php echo $product?>">Volume</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_growth/<?php echo $product?>">Growth</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_nominal_growth/<?php echo $product?>">Nominal Growth</a></li>
		</ul><div style="clear:both"></div>
	</div>-->
	<div>
		<div>
			<div style="margin-left:0px">
				<div style="width:100%; float:left; padding-right:20px;">
					
					<h4>CASA SoW < 30</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead class="headertab"><tr>
							<th style="width:30px">No</th><th>Name</th>
							<th>Wallet CASA</th><th>CASA <?php echo get_month_name($month)." ".date('Y')?></th><th>SoW CASA</th>
							<th>Wallet Loan</th><th>Loan <?php echo get_month_name($month)." ".date('Y')?></th><th>SoW LOAN</th>
							<th>(-) CASA</th><th>CASA to be</th><th>new SoW CASA</th>
						</tr></thead><tbody>
						<?php $i=1; $wlttot = 0; $castot = 0; $casa_tbtot = 0; $min_casatot = 0; $wltloantot = 0; $loantot = 0;
							foreach($anchors as $anchor){ 
								$casa_to_be = 30/100*$anchor['wallet_casa'];
								$min_casa = $casa_to_be-$anchor['rlz_casa'];
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $anchor['anchor']->name?></td>
								<td><?php echo number_format($anchor['wallet_casa'],0,'.',',')?></td>
								<td><?php echo number_format($anchor['rlz_casa'],0,'.',',')?></td>
								<td><?php echo number_format($anchor['sow_casa'],0,'.',',')?> %</td>
								<td><?php echo number_format($anchor['wallet_loan'],0,'.',',')?></td>
								<td><?php echo number_format($anchor['rlz_loan'],0,'.',',')?></td>
								<td><?php echo number_format($anchor['sow_loan'],0,'.',',')?> %</td>
								<!--<td><?php echo number_format($anchor['sow_loan'],0,'.',',')?> %</td>
								<td><?php echo number_format($anchor['casa_xsell'],2,'.',',')?></td>-->
								<td style="background-color:#34aadc"><?php echo number_format($min_casa,0,'.',',')?></td>
								<td style="background-color:#34aadc"><?php echo number_format($casa_to_be,0,'.',',')?></td>
								<td style="background-color:#34aadc"><?php echo number_format(30,0,'.',',')?> %</td>
							</tr>
						<?php
								
								$wlttot = $wlttot + $anchor['wallet_casa'];
								$castot = $castot + $anchor['rlz_casa'];
								$wltloantot = $wltloantot + $anchor['wallet_loan'];
								$loantot = $loantot + $anchor['rlz_loan'];
								$casa_tbtot = $casa_tbtot + $casa_to_be;
								$min_casatot = $min_casatot+$min_casa;
								$i++;
						 	}?>
						 <tr style="background-color:yellow">
							 <td></td>
							 <td><b>Sub-total</b></td>
							 <td><?php echo number_format($wlttot,0,'.',',')?></td>
							 <td><?php echo number_format($castot,0,'.',',')?></td>
							 <td><?php echo number_format($castot/$wlttot*100,0,'.',',')?> %</td>
							 <td><?php echo number_format($wltloantot,0,'.',',')?></td>
							 <td><?php echo number_format($loantot,0,'.',',')?></td>
							 <td><?php echo number_format($loantot/$wltloantot*100,0,'.',',')?> %</td>
							 
							 <td><?php echo number_format($min_casatot,0,'.',',')?></td>
							 <td><?php echo number_format($casa_tbtot,0,'.',',')?></td>
							 <td><?php echo number_format($casa_tbtot/$wlttot*100,0,'.',',')?> %</td>
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