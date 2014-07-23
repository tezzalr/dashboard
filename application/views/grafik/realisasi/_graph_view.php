<?php
	$arrprod = array(); $arrinc_hj = array(); $arrinc_mr = array();
	for($i=1;$i<=15;$i++){
		$prd_name = $prod[$i]."_vol";
		if($rlzn[$prd_name] || $tgt->$prd_name){
			$arrprod[$i]=$arr_name[$i].' <br>('.number_format($rlzn[$prd_name],0,'.',',').'%)';
			if($rlzn[$prd_name] < 100){$arrinc_mr[$i]=$rlzn[$prd_name]; $arrinc_hj[$i]=0;}
			else{$arrinc_hj[$i]=$rlzn[$prd_name]; $arrinc_mr[$i]=0;}
		}
	}
	
	$arrprod_inc = array(); $arrinc_inc = array(); $arrwlt_inc = array();
	for($i=1;$i<=19;$i++){
		$prd_name_arr = $prod[$i]."_inc";
		$nii_arr = array(1,2,3,4,5,6);
		if(in_array($i,$nii_arr)){$prd_name = $prod[$i]."_nii";}elseif(in_array($i, array(18,19))){$prd_name = $prod[$i];}
		else{$prd_name = $prod[$i]."_fbi";}
		if($i == 16){$target = $tgt->WCL_fbi + $tgt->IL_fbi;}elseif($i == 17){$target = $tgt->SL_fbi;}
		else{$target = $tgt->$prd_name;}
		if($rlzn[$prd_name_arr] || $target){
			$arrprod_inc[$i]=$arr_name[$i].' <br>('.number_format($rlzn[$prd_name_arr],0,'.',',').'%)';
			$arrinc_inc[$i]=$rlzn[$prd_name_arr];
			if($rlzn[$prd_name_arr] < 100){$arrinc_mr_arr[$i]=$rlzn[$prd_name_arr]; $arrinc_hj_arr[$i]=0;}
			else{$arrinc_hj_arr[$i]=$rlzn[$prd_name_arr]; $arrinc_mr_arr[$i]=0;}
		}
	}
?>

<script type="text/javascript">
	$(function () {
        $('#container_volume').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Target vs Pencapaian Volume'
            },
            xAxis: {
                categories: [<?php foreach ($arrprod as $prod){echo "'".$prod."', ";}?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percentage %'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.0f}%</b><br/>',
                shared: false,
                enabled: false
                
            },
            plotOptions: {
                column: {
                    stacking: true,
                    dataLabels: {
                        enabled: false,
                        format: '<span style="color:white">{this.total:.0f}%</span>'
                    }
                }
            },
                series: [
            {
                name: 'Tercapai',
                //data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>],
            	data: [<?php foreach($arrinc_hj as $inc){echo $inc.", ";}?>],
            	color: 'green'
            },{
                name: 'Belum Tercapai',
                //data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>],
            	data: [<?php foreach($arrinc_mr as $inc){echo $inc.", ";}?>],
            	color: 'red'
            }]
        });
    });
</script>

<script type="text/javascript">
	$(function () {
        $('#container_income').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Target vs Pencapaian Income'
            },
            xAxis: {
                categories: [<?php foreach ($arrprod_inc as $prod){echo "'".$prod."', ";}?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Percentage %'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.0f}%</b><br/>',
                shared: true,
                enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'true',
                    dataLabels: {
                        enabled: false,
                        format: '{point.y:.0f}%'
                    }
                }
            },
                series: [
            {
                name: 'Tercapai',
                //data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>],
            	data: [<?php foreach($arrinc_hj_arr as $inc){echo $inc.", ";}?>],
            	color: 'green'
            },{
                name: 'Belum Tercapai',
                //data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>],
            	data: [<?php foreach($arrinc_mr_arr as $inc){echo $inc.", ";}?>],
            	color: 'red'
            }]
        });
    });
    

</script>

<div id="container_volume" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
<div id="container_income" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>