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
	if($rlz_ws['CASA_inc'] || $wlt_ws->CASA_nii){$arrprod_inc[1]='CASA'; $arrinc_inc[1]=$rlz_ws['CASA_inc']; $arrwlt_inc[1]=$wlt_ws->CASA_nii;}
	if($rlz_ws['TD_inc'] || $wlt_ws->TD_nii){$arrprod_inc[2]='Time Deposit'; $arrinc_inc[2]=$rlz_ws['TD_inc']; $arrwlt_inc[2]=$wlt_ws->TD_nii;}
	if($rlz_ws['WCL_inc'] || $wlt_ws->WCL_nii){$arrprod_inc[3]='Working Capital Loan'; $arrinc_inc[3]=$rlz_ws['WCL_inc']; $arrwlt_inc[3]=$wlt_ws->WCL_nii;}
	if($rlz_ws['IL_inc'] || $wlt_ws->IL_nii){$arrprod_inc[4]='Investment Loan'; $arrinc_inc[4]=$rlz_ws['IL_inc']; $arrwlt_inc[4]=$wlt_ws->IL_nii;}
	if($rlz_ws['SL_inc'] || $wlt_ws->SL_nii){$arrprod_inc[5]='Structured Loan'; $arrinc_inc[5]=$rlz_ws['SL_inc']; $arrwlt_inc[5]=$wlt_ws->SL_nii;}
	if($rlz_ws['TR_inc'] || $wlt_ws->TR_nii){$arrprod_inc[6]='Trust Receipt'; $arrinc_inc[6]=$rlz_ws['TR_inc']; $arrwlt_inc[6]=$wlt_ws->TR_nii;}
	if($rlz_ws['FX_inc'] || $wlt_ws->FX_fbi){$arrprod_inc[7]='FX & Derivatives'; $arrinc_inc[7]=$rlz_ws['FX_inc']; $arrwlt_inc[7]=$wlt_ws->FX_fbi;}
	if($rlz_ws['SCF_inc'] || $wlt_ws->SCF_fbi){$arrprod_inc[8]='Supply Chain Financing'; $arrinc_inc[8]=$rlz_ws['SCF_inc']; $arrwlt_inc[8]=$wlt_ws->SCF_fbi;}
	if($rlz_ws['Trade_inc'] || $wlt_ws->Trade_fbi){$arrprod_inc[9]='Trade Services'; $arrinc_inc[9]=$rlz_ws['Trade_inc']; $arrwlt_inc[9]=$wlt_ws->Trade_fbi;}
	if($rlz_ws['BG_inc'] || $wlt_ws->BG_fbi){$arrprod_inc[10]='Bank Guarantee'; $arrinc_inc[10]=$rlz_ws['BG_inc']; $arrwlt_inc[10]=$wlt_ws->BG_fbi;}
	if($rlz_ws['OIR_inc'] || $wlt_ws->OIR_fbi){$arrprod_inc[11]='Outgoing Intl Remittance'; $arrinc_inc[11]=$rlz_ws['OIR_inc']; $arrwlt_inc[11]=$wlt_ws->OIR_fbi;}
	if($rlz_ws['PWE_inc'] || $wlt_ws->PWE_fbi){$arrprod_inc[12]='PWE non L/C'; $arrinc_inc[12]=$rlz_ws['PWE_inc']; $arrwlt_inc[12]=$wlt_ws->PWE_fbi;}
	if($rlz_ws['ECM_inc'] || $wlt_ws->ECM_fbi){$arrprod_inc[13]='ECM'; $arrinc_inc[13]=$rlz_ws['ECM_inc']; $arrwlt_inc[13]=$wlt_ws->ECM_fbi;}
	if($rlz_ws['DCM_inc'] || $wlt_ws->DCM_fbi){$arrprod_inc[14]='DCM'; $arrinc_inc[14]=$rlz_ws['DCM_inc']; $arrwlt_inc[14]=$wlt_ws->DCM_fbi;}
	if($rlz_ws['MA_inc'] || $wlt_ws->MA_fbi){$arrprod_inc[15]='M&A'; $arrinc_inc[15]=$rlz_ws['MA_inc']; $arrwlt_inc[15]=$wlt_ws->MA_fbi;}
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
                //data: [<?php echo $rlz_ws['CASA_vol'] ?>, <?php echo $rlz_ws['TD_vol'] ?>, <?php echo $rlz_ws['WCL_vol'] ?>, <?php echo $rlz_ws['IL_vol'] ?>, <?php echo $rlz_ws['SL_vol'] ?>, <?php echo $rlz_ws['TR_vol'] ?>, <?php echo $rlz_ws['FX_vol'] ?>, <?php echo $rlz_ws['SCF_vol'] ?>, <?php echo $rlz_ws['Trade_vol'] ?>, <?php echo $rlz_ws['BG_vol'] ?>, <?php echo $rlz_ws['OIR_vol'] ?>, <?php echo $rlz_ws['PWE_vol'] ?>, <?php echo $rlz_ws['ECM_vol'] ?>, <?php echo $rlz_ws['DCM_vol'] ?>, <?php echo $rlz_ws['MA_vol'] ?>],
                data: [<?php foreach($arrinc as $inc){echo round($inc,1).", ";}?>],
                color: 'yellow',
                id: 'inc'
            }, {
                name: 'Wallet Size',
                //data: [<?php echo $wlt_ws->CASA_vol?>, <?php echo $wlt_ws->TD_vol?>, <?php echo $wlt_ws->WCL_vol?>, <?php echo $wlt_ws->IL_vol?>, <?php echo $wlt_ws->SL_vol?>, <?php echo $wlt_ws->TR_vol?>, <?php echo $wlt_ws->FX_vol?>, <?php echo $wlt_ws->SCF_vol?>, <?php echo $wlt_ws->Trade_vol?>, <?php echo $wlt_ws->BG_vol?>, <?php echo $wlt_ws->OIR_vol?>, <?php echo $wlt_ws->PWE_vol?>, <?php echo $wlt_ws->ECM_vol?>, <?php echo $wlt_ws->DCM_vol?>, <?php echo $wlt_ws->MA_vol?>],
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