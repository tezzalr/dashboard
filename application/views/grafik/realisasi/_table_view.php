<?php
	$arrprod = array();
	for($i=1;$i<=15;$i++){
		$prd_name = $prod[$i]."_vol";
		if($prod[$i]=="FX" || $prod[$i]=="Trade"){$unit_mes = "Mn USD";}elseif($prod[$i]=="OIR"){$unit_mes="# Trx";}else{$unit_mes="Bn IDR";}
		if($pct[$prd_name] || $tgt->$prd_name){
			$arrprod[$i]['name'] = $arr_name[$i];
			$arrprod[$i]['tgt'] = $tgt->$prd_name;  
			$arrprod[$i]['pct'] = $pct[$prd_name]; 
			$arrprod[$i]['ytd'] = $ytd[$prd_name];
			$arrprod[$i]['unt'] = $unit_mes;
			//if($prod[$i] == "FX" || $prod[$i] == "Trade"){$bagi=6;}elseif($prod[$i] == "OIR"){$bagi=0;}else{$bagi=9;}
			$arrprod[$i]['rlzn'] = $rlzn[$prd_name]/pow(10,9);
		}
	}
	
	usort($arrprod, function($a, $b) {
		return $b['pct'] - $a['pct'];
	});
	
	$arrprod_inc = array();
	for($i=1;$i<=19;$i++){
		$prd_name_arr = $prod[$i]."_inc";
		$nii_arr = array(1,2,3,4,5,6);
		if(in_array($i,$nii_arr)){$prd_name = $prod[$i]."_nii";}elseif(in_array($i, array(18,19))){$prd_name = $prod[$i];}
		else{$prd_name = $prod[$i]."_fbi";}
		if($i == 16){$target = $tgt->WCL_fbi + $tgt->IL_fbi;}elseif($i == 17){$target = $tgt->SL_fbi;}
		else{$target = $tgt->$prd_name;}
		
		if($pct[$prd_name_arr] || $target){
			$arrprod_inc[$i]['name'] = $arr_name[$i];
			$arrprod_inc[$i]['ytd'] = $ytd[$prd_name_arr];
			$arrprod_inc[$i]['tgt'] = $target;
			$arrprod_inc[$i]['pct'] = $pct[$prd_name_arr];
			$arrprod_inc[$i]['rlzn'] = $rlzn[$prd_name_arr]/pow(10,9);
		}
	}
	
	usort($arrprod_inc, function($a, $b) {
		return $b['pct'] - $a['pct'];
	});
?>
<div style="margin-top:20px;">
<h3>Volume Realization</h3>
<table class="table table-striped">
	<thead><tr><th>Product</th><th>Unit</th><th  style="text-align:right">Mei 2014</th><th  style="text-align:right">Target 2014</th><th  style="text-align:right">YTD 2014</th><th  style="text-align:right">% Target</th></tr></thead>
	<tbody>
		<?php foreach($arrprod as $prod){
			echo "<tr><td>".$prod['name']."</td>
				<td>".$prod['unt']."</td>
				<td style=\"text-align:right\">".number_format($prod['rlzn'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['tgt'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['ytd'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['pct'],0,'.',',')." %</td>
				</tr>";
		}?>
	</tbody>
</table>
</div>
<hr>
<div style="margin-top:20px;">
<h3>Income Realization</h3>
<h5 style="color:grey; margin-top:-10px;">(in Billion Rupiah)</h5>
<table class="table table-striped">
	<thead><tr>
		<th>Product</th>
		<th  style="text-align:right">Mei 2014</th><th  style="text-align:right">Target 2014</th><th  style="text-align:right">YTD 2014</th><th  style="text-align:right">% Target</th>
	</tr></thead>
	<tbody>
		<?php foreach($arrprod_inc as $prod){
			echo "<tr><td>".$prod['name']."</td>
				<td style=\"text-align:right\">".number_format($prod['rlzn'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['tgt'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['ytd'],1,'.',',')."</td>
				<td style=\"text-align:right\">".number_format($prod['pct'],0,'.',',')." %</td>
				</tr>";
		}?>
	</tbody>
</table>
</div>