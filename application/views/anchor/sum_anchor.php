<div id="" class="container no_pad">
	
	<div>
		<div>
			<div style="margin-left:0px">
				<div style="width:100%; float:left; padding-right:20px;">
					
					<h4>CASA XSELL < 1</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead class="headertab"><tr>
							<th style="width:30px">No</th><th>Name</th><th>Gas</th><th>Wholesale</th><th>Relationship</th>
							<th>Wallet</th><th>SoW</th><th>Trx X-Sell</th>
							<th>CASA X-Sell</th><th>CASA</th><th>Loan</th>
						</tr></thead><tbody>
						<?php $i=1; $wlttot = 0; $castot = 0; $casa_tbtot = 0; $min_casatot = 0; $wltloantot = 0; $loantot = 0;
							foreach($anchors as $anchor){ ?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $anchor['anchor']->name?></td>
								<td><?php echo $anchor['anchor']->gas?></td>
								<td><?php echo number_format($anchor['inc']['ws'],0)?></td>
								<td><?php echo number_format($anchor['inc']['tot'],0)?></td>
								<td><?php echo number_format($anchor['wal']['tot'],0)?></td>
								<td><?php echo number_format($anchor['sow']*100,0)?> %</td>
								<td><?php echo number_format($anchor['trx'],1)?></td>
								<td><?php echo number_format($anchor['casx'],1)?></td>
								<td><?php echo number_format($anchor['rlz']['CASA_vol'],1)?></td>
								<td><?php echo number_format($anchor['rlz']['WCL_vol']+$anchor['rlz']['IL_vol'],1)?></td>
							</tr>
						<?php $i++; }?>
						</tbody>
					</table>
				</div>
			</div>
			<div>
			</div>
		</div>
	</div>
</div>