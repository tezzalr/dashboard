<?php $arrsc = array('platinum','gold','silver');?>
<div id="" class="container no_pad">
	<div>
		<h3>Scorecard Wholesale Income</h3>
		<?php for($a=0;$a<3;$a++){?>
			<div style="margin-bottom:20px">
				<?php for($s=3;$s>=1;$s--){?>
					<div style="width:33%; float:left;">
						<table class="table" style="font-size:9px">
							<tr><th></th><th>gas</th><th>wal</th><th>ytd</th><th>sow</th><th>trx</th><th>casx</th></tr>
						<?php foreach($scs[$arrsc[$a]][$s] as $sc){?>
							<tr>
								<td><?php echo $sc['anchor']->name?></td>
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