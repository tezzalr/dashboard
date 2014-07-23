<?php
	$arrprod = array(); $arrinc = array(); $arrwlt = array();
	for($i=1;$i<=15;$i++){
		$prd_name = $prod[$i]."_vol";
		if($rlz_ws[$prd_name] || $wlt_ws->$prd_name){
			$arrinc[$i]=$rlz_ws[$prd_name]; 
			$arrwlt[$i]=$wlt_ws->$prd_name; 
			$arrprod[$i]=$arr_name[$i].' <br>(SoW : '.number_format($sow_ws[$i],0,'.',',').'%)';
		}
	}
	
	$arrprod_inc = array(); $arrinc_inc = array(); $arrwlt_inc = array();
	for($i=1;$i<=15;$i++){
		$prd_name_arr = $prod[$i]."_inc";
		$nii_arr = array(1,2,3,4,5,6);
		if(in_array($i,$nii_arr)){$prd_name = $prod[$i]."_nii";}
		else{$prd_name = $prod[$i]."_fbi";}
		if($rlz_ws[$prd_name_arr] || $wlt_ws->$prd_name){
			$arrprod_inc[$i]=$arr_name[$i].' <br>(SoW : '.number_format($sow_ws[$i+15],0,'.',',').'%)';
			$arrinc_inc[$i]=$rlz_ws[$prd_name_arr];
			$arrwlt_inc[$i]=$wlt_ws->$prd_name;
		}
	}
?>

<script type="text/javascript">
	$(function () {
        $('#container_volume').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Wallet Size vs SoW Volume Wholesale'
            },
            xAxis: {
                //categories: ['CASA', 'Time Deposit', 'Working Capital Loan', 'Investment Loan', 'Structured Loan', 'Trust Receipt', 'FX & Derivatives', 'Supply Chain Financing', 'Trade Services', 'Bank Guarantee', 'Outgoing Intl Remittance', 'PWE non L/C', 'ECM', 'DCM', 'M&A'],
                categories: [<?php foreach ($arrprod as $prod){echo "'".$prod."', ";}?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '(millions)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -20,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Income',
                data: [<?php foreach($arrinc as $inc){echo round($inc,1).", ";}?>],
                color: 'yellow',
                id: 'inc'
            }, {
                name: 'Wallet Size',
                data: [<?php foreach($arrwlt as $wlt){echo round($wlt,1).", ";}?>],
                color: 'orange',
                id: 'ws'
            }],
            exporting: {
         	   enabled: true
        	}
        });
    });
</script>

<script type="text/javascript">
	$(function () {
        $('#container_income').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Wallet Size vs SoW Income Wholesale'
            },
            xAxis: {
                //categories: ['CASA', 'Time Deposit', 'Working Capital Loan', 'Investment Loan', 'Structured Loan', 'Trust Receipt', 'FX & Derivatives', 'Supply Chain Financing', 'Trade Services', 'Bank Guarantee', 'Outgoing Intl Remittance', 'PWE non L/C', 'ECM', 'DCM', 'M&A'],
                categories: [<?php foreach ($arrprod_inc as $prod){echo "'".$prod."', ";}?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '(millions)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' millions'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.y:.1f}</b>',
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -20,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Income',
                //data: [<?php echo $rlz_ws['CASA_vol'] ?>, <?php echo $rlz_ws['TD_vol'] ?>, <?php echo $rlz_ws['WCL_vol'] ?>, <?php echo $rlz_ws['IL_vol'] ?>, <?php echo $rlz_ws['SL_vol'] ?>, <?php echo $rlz_ws['TR_vol'] ?>, <?php echo $rlz_ws['FX_vol'] ?>, <?php echo $rlz_ws['SCF_vol'] ?>, <?php echo $rlz_ws['Trade_vol'] ?>, <?php echo $rlz_ws['BG_vol'] ?>, <?php echo $rlz_ws['OIR_vol'] ?>, <?php echo $rlz_ws['PWE_vol'] ?>, <?php echo $rlz_ws['ECM_vol'] ?>, <?php echo $rlz_ws['DCM_vol'] ?>, <?php echo $rlz_ws['MA_vol'] ?>],
                data: [<?php foreach($arrinc_inc as $inc){echo $inc.", ";}?>],
                color: 'yellow',
                id: 'inc'
            }, {
                name: 'Wallet Size',
                //data: [<?php echo $wlt_ws->CASA_vol?>, <?php echo $wlt_ws->TD_vol?>, <?php echo $wlt_ws->WCL_vol?>, <?php echo $wlt_ws->IL_vol?>, <?php echo $wlt_ws->SL_vol?>, <?php echo $wlt_ws->TR_vol?>, <?php echo $wlt_ws->FX_vol?>, <?php echo $wlt_ws->SCF_vol?>, <?php echo $wlt_ws->Trade_vol?>, <?php echo $wlt_ws->BG_vol?>, <?php echo $wlt_ws->OIR_vol?>, <?php echo $wlt_ws->PWE_vol?>, <?php echo $wlt_ws->ECM_vol?>, <?php echo $wlt_ws->DCM_vol?>, <?php echo $wlt_ws->MA_vol?>],
                data: [<?php foreach($arrwlt_inc as $wlt){echo $wlt.", ";}?>],
                color: 'orange',
                id: 'ws'
            }],
            exporting: {
         	   enabled: true
        	}
        });
    });
</script>

<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<div id="container_volume" style="min-width: 310px; height: 500px; margin: 0 auto"></div><hr>
		<div id="container_income" style="min-width: 310px; height: 500px; margin: 0 auto"></div><hr>
		<!--<div>
			<div id="container2" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
			<div id="container3" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		</div>--><div style="clear:both"></div><br>
	</div>
</div>