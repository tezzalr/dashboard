<?php 
	function calculate_array($array, $incknd, $xsell){
		$arrres = array();
		$arrres['wl_ly'] = 0;
		$arrres['in_ly'] =  0;
		$arrres['wl'] = 0;
		$arrres['in'] =  0;
		foreach ($array as $mmber){
			if($mmber == 'CASA'){$incknd = 'nii';}
			$prod = $mmber; $wal = $prod."_".$incknd; $inc = $prod."_inc";
			$arrres['wl_ly'] = $arrres['wl_ly']+$xsell['wal_ly']->$wal;
			$arrres['in_ly'] =  $arrres['in_ly']+$xsell['inc_ly'][$inc];
			$arrres['wl'] = $arrres['wl']+$xsell['wal']->$wal;
			$arrres['in'] =  $arrres['in']+$xsell['inc'][$inc];
		}
		$arrres['sw_ly'] = $arrres['in_ly']/$arrres['wl_ly']*100;
		$arrres['sw'] = $arrres['in']/$arrres['wl']*100;
		
		return $arrres;
	}
	function write_prod($array, $incknd, $xsell){
		foreach ($array as $mmber){
			$prod = $mmber; $wal = $prod."_".$incknd; $inc = $prod."_inc";
			
			if(!$xsell['wal_ly']->$wal){$sow_ly = 100;}
			else{$sow_ly = $xsell['inc_ly'][$inc]/$xsell['wal_ly']->$wal*100;}
			if(!$xsell['wal']->$wal){$sow = 100;}
			else{$sow = $xsell['inc'][$inc]/$xsell['wal']->$wal*100;}
			
			echo "<tr><td>".change_real_name($mmber)."</td>";
			echo "<td>".number_format($xsell['wal_ly']->$wal,1)."</td>";
			echo "<td>".number_format($xsell['inc_ly'][$inc],1)."</td>";
			echo "<td>".number_format($sow_ly,1)." %</td>";
			echo "<td>".number_format($xsell['wal']->$wal,1)."</td>";
			echo "<td>".number_format($xsell['inc'][$inc],1)."</td>";
			echo "<td>".number_format($sow,1)." %</td></tr>";
			
		}
	}
	$loanarr = array('WCL','IL','TR');
	$trxarr = array('FX', 'Trade', 'BG', 'OIR');
	$castrxarr = array('FX', 'Trade', 'BG', 'OIR', 'CASA');
	$loanres = calculate_array($loanarr, 'nii', $xsell);
	$trxres = calculate_array($trxarr, 'fbi', $xsell);
	$castrxres = calculate_array($castrxarr, 'fbi', $xsell);
?>

<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<a href="<?php echo base_url()?>report/alliance_income/<?php echo $info_page['type'];?>/<?php echo $info_page['id'];?>"><span style="float:right">Alliance Income --></span></a>
		<h2>Transaction Cross Sell*</h2>
		<h4 style="color:grey;">Transaction Cross Sell* Tahun <?php echo date('Y')-1?> sebesar <?php echo number_format($castrxres['sw_ly']/$loanres['sw_ly'],1)?>
		dan menjadi <?php echo number_format($castrxres['sw']/$loanres['sw'],1)?> tahun <?php echo date('Y')?>
		</h4>
		<span style="font-size:11px;">*Transaction Cross Sell adalah SOW(CASA + Trx)/SOW Loan</span><br><br>
		
		<div style="width: 100%; margin: 0 auto;">
			<table class="table table-bordered" style="font-size:12px">
				<tr style="background-color:#08088A; color:white;"><th rowspan=2></th><center><th colspan=3>2013</th><th colspan=3>YTD Annualized 2014</th></center></tr>
				<tr style="background-color:#08088A; color:white;"><th>Wallet</th><th>Real</th><th>SOW</th><th>Wallet</th><th>Real</th><th>SOW</th>
				<tr style="background-color:#9FF781;"><td>Loan :</td><td><?php echo number_format($loanres['wl_ly'],1)?></td><td><?php echo number_format($loanres['in_ly'],1)?></td><td><?php echo number_format($loanres['sw_ly'],1)?> %</td><td><?php echo number_format($loanres['wl'],1)?></td><td><?php echo number_format($loanres['in'],1)?></td><td><?php echo number_format($loanres['sw'],1)?> %</td></tr>
				<?php write_prod($loanarr, 'nii', $xsell);?>
				<tr style="background-color:#9FF781;"><td>CASA + Trx :</td><td><?php echo number_format($castrxres['wl_ly'],1)?></td><td><?php echo number_format($castrxres['in_ly'],1)?></td><td><?php echo number_format($castrxres['sw_ly'],1)?> %</td><td><?php echo number_format($castrxres['wl'],1)?></td><td><?php echo number_format($castrxres['in'],1)?></td><td><?php echo number_format($castrxres['sw'],1)?> %</td></tr>
				<tr style="background-color:#BDBDBD;"><td>CASA</td><td><?php echo number_format($xsell['wal_ly']->CASA_nii,1)?></td><td><?php echo number_format($xsell['inc_ly']['CASA_inc'],1)?></td><td><?php echo number_format($xsell['sow_ly'][16],1)?> %</td><td><?php echo number_format($xsell['wal']->CASA_nii,1)?></td><td><?php echo number_format($xsell['inc']['CASA_inc'],1)?></td><td><?php echo number_format($xsell['sow'][16],1)?> %</td></tr>
				<tr style="background-color:#BDBDBD;"><td>Transaction (Trx)</td><td><?php echo number_format($trxres['wl_ly'],1)?></td><td><?php echo number_format($trxres['in_ly'],1)?></td><td><?php echo number_format($trxres['sw_ly'],1)?> %</td><td><?php echo number_format($trxres['wl'],1)?></td><td><?php echo number_format($trxres['in'],1)?></td><td><?php echo number_format($trxres['sw'],1)?> %</td></tr>
				<?php write_prod($trxarr, 'fbi', $xsell);?>
				<tr style="background-color:#08088A; color:white;"><td>Transaction cross sell</td><td></td><td></td><td><?php echo number_format($castrxres['sw_ly']/$loanres['sw_ly'],1)?></td><td></td><td></td><td><?php echo number_format($castrxres['sw']/$loanres['sw'],1)?></td></tr>
				
			</table>
		</div>
		
		<br>
	</div>
</div>