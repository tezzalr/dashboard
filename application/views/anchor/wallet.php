<?php
	$arrprod = array(); $arrinc = array(); $arrwlt = array();
	if($rlz_ws['CASA_vol'] || $wlt_ws->CASA_vol){$arrprod[1]='CASA'; $arrinc[1]=$rlz_ws['CASA_vol']; $arrwlt[1]=$wlt_ws->CASA_vol;}
	if($rlz_ws['TD_vol'] || $wlt_ws->TD_vol){$arrprod[2]='Time Deposit'; $arrinc[2]=$rlz_ws['TD_vol']; $arrwlt[2]=$wlt_ws->TD_vol;}
	if($rlz_ws['WCL_vol'] || $wlt_ws->WCL_vol){$arrprod[3]='Working Capital Loan'; $arrinc[3]=$rlz_ws['WCL_vol']; $arrwlt[3]=$wlt_ws->WCL_vol;}
	if($rlz_ws['IL_vol'] || $wlt_ws->IL_vol){$arrprod[4]='Investment Loan'; $arrinc[4]=$rlz_ws['IL_vol']; $arrwlt[4]=$wlt_ws->IL_vol;}
	if($rlz_ws['SL_vol'] || $wlt_ws->SL_vol){$arrprod[5]='Structured Loan'; $arrinc[5]=$rlz_ws['SL_vol']; $arrwlt[5]=$wlt_ws->SL_vol;}
	if($rlz_ws['TR_vol'] || $wlt_ws->TR_vol){$arrprod[6]='Trust Receipt'; $arrinc[6]=$rlz_ws['TR_vol']; $arrwlt[6]=$wlt_ws->TR_vol;}
	if($rlz_ws['FX_vol'] || $wlt_ws->FX_vol){$arrprod[7]='FX & Derivatives'; $arrinc[7]=$rlz_ws['FX_vol']; $arrwlt[7]=$wlt_ws->FX_vol;}
	if($rlz_ws['SCF_vol'] || $wlt_ws->SCF_vol){$arrprod[8]='Supply Chain Financing'; $arrinc[8]=$rlz_ws['SCF_vol']; $arrwlt[8]=$wlt_ws->SCF_vol;}
	if($rlz_ws['Trade_vol'] || $wlt_ws->Trade_vol){$arrprod[9]='Trade Services'; $arrinc[9]=$rlz_ws['Trade_vol']; $arrwlt[9]=$wlt_ws->Trade_vol;}
	if($rlz_ws['BG_vol'] || $wlt_ws->BG_vol){$arrprod[10]='Bank Guarantee'; $arrinc[10]=$rlz_ws['BG_vol']; $arrwlt[10]=$wlt_ws->BG_vol;}
	if($rlz_ws['OIR_vol'] || $wlt_ws->OIR_vol){$arrprod[11]='Outgoing Intl Remittance'; $arrinc[11]=$rlz_ws['OIR_vol']; $arrwlt[11]=$wlt_ws->OIR_vol;}
	if($rlz_ws['PWE_vol'] || $wlt_ws->PWE_vol){$arrprod[12]='PWE non L/C'; $arrinc[12]=$rlz_ws['PWE_vol']; $arrwlt[12]=$wlt_ws->PWE_vol;}
	if($rlz_ws['ECM_vol'] || $wlt_ws->ECM_vol){$arrprod[13]='ECM'; $arrinc[13]=$rlz_ws['ECM_vol']; $arrwlt[13]=$wlt_ws->ECM_vol;}
	if($rlz_ws['DCM_vol'] || $wlt_ws->DCM_vol){$arrprod[14]='DCM'; $arrinc[14]=$rlz_ws['DCM_vol']; $arrwlt[14]=$wlt_ws->DCM_vol;}
	if($rlz_ws['MA_vol'] || $wlt_ws->MA_vol){$arrprod[15]='M&A'; $arrinc[15]=$rlz_ws['MA_vol']; $arrwlt[15]=$wlt_ws->MA_vol;}
	
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
                data: [<?php foreach($arrinc as $inc){echo $inc.", ";}?>],
                color: 'yellow',
                id: 'inc'
            }, {
                name: 'Wallet Size',
                //data: [<?php echo $wlt_ws->CASA_vol?>, <?php echo $wlt_ws->TD_vol?>, <?php echo $wlt_ws->WCL_vol?>, <?php echo $wlt_ws->IL_vol?>, <?php echo $wlt_ws->SL_vol?>, <?php echo $wlt_ws->TR_vol?>, <?php echo $wlt_ws->FX_vol?>, <?php echo $wlt_ws->SCF_vol?>, <?php echo $wlt_ws->Trade_vol?>, <?php echo $wlt_ws->BG_vol?>, <?php echo $wlt_ws->OIR_vol?>, <?php echo $wlt_ws->PWE_vol?>, <?php echo $wlt_ws->ECM_vol?>, <?php echo $wlt_ws->DCM_vol?>, <?php echo $wlt_ws->MA_vol?>],
                data: [<?php foreach($arrwlt as $wlt){echo $wlt.", ";}?>],
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
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2><?php echo $anchor->name?></h2>
		<h4><?php echo $anchor->group?></h4>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
			<li><a href="<?php echo base_url()?>anchor/realisasi/<?php echo $anchor->id;?>">Realization</a></li>
			<li><a href="<?php echo base_url()?>anchor/pendapatan/<?php echo $anchor->id;?>">Income</a></li>
		  	<li><a href="<?php echo base_url()?>anchor/wallet/<?php echo $anchor->id;?>">Wallet</a></li>
		  	<li><a href="<?php echo base_url()?>anchor/product">Product</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div>
		<div id="container_volume" style="min-width: 310px; height: 500px; margin: 0 auto"></div><hr>
		<div id="container_income" style="min-width: 310px; height: 500px; margin: 0 auto"></div><hr>
		<!--<div>
			<div id="container2" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
			<div id="container3" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		</div>--><div style="clear:both"></div><br>
	</div>
</div>