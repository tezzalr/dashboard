<?php
	$arrprod = array(); $arrinc = array(); $arrwlt = array();
	if($rlzn['CASA_vol'] || $tgt->CASA_vol){$arrprod[1]='CASA'; $arrinc[1]=$rlzn['CASA_vol']; $arrwlt[1]=$tgt->CASA_vol;}
	if($rlzn['TD_vol'] || $tgt->TD_vol){$arrprod[2]='Time Deposit'; $arrinc[2]=$rlzn['TD_vol']; $arrwlt[2]=$tgt->TD_vol;}
	if($rlzn['WCL_vol'] || $tgt->WCL_vol){$arrprod[3]='Working Capital Loan'; $arrinc[3]=$rlzn['WCL_vol']; $arrwlt[3]=$tgt->WCL_vol;}
	if($rlzn['IL_vol'] || $tgt->IL_vol){$arrprod[4]='Investment Loan'; $arrinc[4]=$rlzn['IL_vol']; $arrwlt[4]=$tgt->IL_vol;}
	if($rlzn['SL_vol'] || $tgt->SL_vol){$arrprod[5]='Structured Loan'; $arrinc[5]=$rlzn['SL_vol']; $arrwlt[5]=$tgt->SL_vol;}
	if($rlzn['TR_vol'] || $tgt->TR_vol){$arrprod[6]='Trust Receipt'; $arrinc[6]=$rlzn['TR_vol']; $arrwlt[6]=$tgt->TR_vol;}
	if($rlzn['FX_vol'] || $tgt->FX_vol){$arrprod[7]='FX & Derivatives'; $arrinc[7]=$rlzn['FX_vol']; $arrwlt[7]=$tgt->FX_vol;}
	if($rlzn['SCF_vol'] || $tgt->SCF_vol){$arrprod[8]='Supply Chain Financing'; $arrinc[8]=$rlzn['SCF_vol']; $arrwlt[8]=$tgt->SCF_vol;}
	if($rlzn['Trade_vol'] || $tgt->Trade_vol){$arrprod[9]='Trade Services'; $arrinc[9]=$rlzn['Trade_vol']; $arrwlt[9]=$tgt->Trade_vol;}
	if($rlzn['BG_vol'] || $tgt->BG_vol){$arrprod[10]='Bank Guarantee'; $arrinc[10]=$rlzn['BG_vol']; $arrwlt[10]=$tgt->BG_vol;}
	if($rlzn['OIR_vol'] || $tgt->OIR_vol){$arrprod[11]='Outgoing Intl Remittance'; $arrinc[11]=$rlzn['OIR_vol']; $arrwlt[11]=$tgt->OIR_vol;}
	if($rlzn['PWE_vol'] || $tgt->PWE_vol){$arrprod[12]='PWE non L/C'; $arrinc[12]=$rlzn['PWE_vol']; $arrwlt[12]=$tgt->PWE_vol;}
	if($rlzn['ECM_vol'] || $tgt->ECM_vol){$arrprod[13]='ECM'; $arrinc[13]=$rlzn['ECM_vol']; $arrwlt[13]=$tgt->ECM_vol;}
	if($rlzn['DCM_vol'] || $tgt->DCM_vol){$arrprod[14]='DCM'; $arrinc[14]=$rlzn['DCM_vol']; $arrwlt[14]=$tgt->DCM_vol;}
	if($rlzn['MA_vol'] || $tgt->MA_vol){$arrprod[15]='M&A'; $arrinc[15]=$rlzn['MA_vol']; $arrwlt[15]=$tgt->MA_vol;}
	
	$arrprod_inc = array(); $arrinc_inc = array(); $arrwlt_inc = array();
	if($rlzn['CASA_inc'] || $tgt->CASA_nii){$arrprod_inc[1]='CASA'; $arrinc_inc[1]=$rlzn['CASA_inc'];}
	if($rlzn['TD_inc'] || $tgt->TD_nii){$arrprod_inc[2]='Time Deposit'; $arrinc_inc[2]=$rlzn['TD_inc'];}
	if($rlzn['WCL_inc'] || $tgt->WCL_nii){$arrprod_inc[3]='Working Capital Loan'; $arrinc_inc[3]=$rlzn['WCL_inc'];}
	if($rlzn['IL_inc'] || $tgt->IL_nii){$arrprod_inc[4]='Investment Loan'; $arrinc_inc[4]=$rlzn['IL_inc'];}
	if($rlzn['SL_inc'] || $tgt->SL_nii){$arrprod_inc[5]='Structured Loan'; $arrinc_inc[5]=$rlzn['SL_inc'];}
	if($rlzn['TR_inc'] || $tgt->TR_nii){$arrprod_inc[6]='Trust Receipt'; $arrinc_inc[6]=$rlzn['TR_inc'];}
	if($rlzn['OW_nii'] || $tgt->OW_nii){$arrprod_inc[7]='NII Others'; $arrinc_inc[7]=$rlzn['OW_nii'];}
	if($rlzn['FX_inc'] || $tgt->FX_fbi){$arrprod_inc[8]='FX & Derivatives'; $arrinc_inc[8]=$rlzn['FX_inc'];}
	if($rlzn['SCF_inc'] || $tgt->SCF_fbi){$arrprod_inc[9]='Supply Chain Financing'; $arrinc_inc[9]=$rlzn['SCF_inc'];}
	if($rlzn['Trade_inc'] || $tgt->Trade_fbi){$arrprod_inc[10]='Trade Services'; $arrinc_inc[10]=$rlzn['Trade_inc'];}
	if($rlzn['BG_inc'] || $tgt->BG_fbi){$arrprod_inc[11]='Bank Guarantee'; $arrinc_inc[11]=$rlzn['BG_inc'];}
	if($rlzn['OIR_inc'] || $tgt->OIR_fbi){$arrprod_inc[12]='Outgoing Intl Remittance'; $arrinc_inc[12]=$rlzn['OIR_inc'];}
	if($rlzn['PWE_inc'] || $tgt->PWE_fbi){$arrprod_inc[13]='PWE non L/C'; $arrinc_inc[13]=$rlzn['PWE_inc'];}
	if($rlzn['LMF'] || ($tgt->WCL_fbi + $tgt->IL_fbi)){$arrprod_inc[14]='Loan Maintenance Fee'; $arrinc_inc[14]=$rlzn['LMF'];}
	if($rlzn['SF'] || $tgt->SL_fbi){$arrprod_inc[15]='Syndication Fee'; $arrinc_inc[15]=$rlzn['SF'];}
	if($rlzn['OW_fbi'] || $tgt->OW_fbi+$tgt->CASA_fbi){$arrprod_inc[16]='FBI Others'; $arrinc_inc[16]=$rlzn['OW_fbi'];}
	if($rlzn['ECM_inc'] || $tgt->ECM_fbi){$arrprod_inc[17]='ECM'; $arrinc_inc[17]=$rlzn['ECM_inc'];}
	if($rlzn['DCM_inc'] || $tgt->DCM_fbi){$arrprod_inc[18]='DCM'; $arrinc_inc[18]=$rlzn['DCM_inc'];}
	if($rlzn['MA_inc'] || $tgt->MA_fbi){$arrprod_inc[19]='M&A'; $arrinc_inc[19]=$rlzn['MA_inc'];}
?>

<script type="text/javascript">
	$(function () {
        $('#container').highcharts({
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
                shared: true
            },
            plotOptions: {
                column: {
                    //stacking: 'true'
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}%'
                    }
                }
            },
                series: [
            /*{
                name: 'Target',
                data: [100, 100, 100, 100, 100, 100, 100],
                real_val: [4, 5, 6, 2, 5, 7, 8],
                color: 'red'
            },*/ {
                name: 'Pencapaian',
                //data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>],
            	data: [<?php foreach($arrinc as $inc){echo $inc.", ";}?>],
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
                    text: 'Total'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.0f}%</b> ({real_val})<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    //stacking: 'true'
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}%'
                    }
                }
            },
                series: [
            /*{
                name: 'Target',
                data: [100, 100, 100, 100, 100, 100, 100],
                real_val: [4, 5, 6, 2, 5, 7, 8],
                color: 'red'
            }, */{
                name: 'Pencapaian',
                data: [<?php foreach($arrinc_inc as $inc){echo $inc.", ";}?>]
            }]
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
		<div id="container" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
		<div id="container_income" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
		<!--<div>
			<div id="container2" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
			<div id="container3" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		</div>--><div style="clear:both"></div><br>
	</div>
</div>