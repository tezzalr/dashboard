<?php $arrsc = array('platinum','gold','silver');?>
<div id="" class="container no_pad">
	<div>
		<h3>Scorecard Wholesale Income</h3>
		<?php for($a=0;$a<3;$a++){?>
			<div style="margin-bottom:10px">
				<h4><?php echo $arrsc[$a]?></h4>
				<div style="width:33%; float:left;"><h6>Ring 3 : Less Important Bank</h6><span style="font-size:11px">SoW < 10%, Trx X-Sell < 0.5, CASA X-Sell < 0.05</span></div>
				<div style="width:33%; float:left;"><h6>Ring 2 : Important Bank</h6><span style="font-size:11px">SoW 10% - 30%, Trx X-Sell 0.5 - 1, CASA X-Sell 0.05 - 0.1</span></div>
				<div style="width:33%; float:left;"><h6>Ring 1 : Most Important Bank</h6><span style="font-size:11px">SoW > 30%, Trx X-Sell > 1, CASA X-Sell > 0.1</span></div>
				<div style="clear:both"></div>
				
				<?php for($s=3;$s>=1;$s--){?>
					<div style="width:33%; float:left;">
						<table class="table" style="font-size:9px">
							<tr><th></th><th>gas</th><th>wal</th><th>ytd</th><th>sow</th><th>trx</th><th>casx</th></tr>
						<?php foreach($scs[$arrsc[$a]][$s] as $sc){?>
							<tr>
								<td><?php echo $sc['anchor']->srt_name?></td>
								<td><?php echo number_format($sc['anchor']->gas,0)?></td>
								<td><?php echo number_format($sc['wal']['ws'],0)?></td>
								<td><?php echo number_format($sc['inc']['ws'],0)?></td>
								<td><?php echo number_format($sc['sow']*100,0)?> %</td>
								<td><?php echo number_format($sc['trx'],1)?></td>
								<td><?php echo number_format($sc['casx'],1)?></td>
							</tr>
						<?php }?>
						</table>
					</div>
				<?php }?>
				<div style="clear:both"></div>
			</div>
		<?php }?>
	</div>
</div>