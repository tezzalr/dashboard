<?php
	$arrprod = array(); $arrinc_hj = array(); $arrinc_mr = array();
	if($rlzn['CASA_vol'] || $tgt->CASA_vol){$arrprod[1]='CASA <br>('.number_format($rlzn['CASA_vol'],0,".",",").'%)'; if($rlzn['CASA_vol']<100){ $arrinc_mr[1]=$rlzn['CASA_vol']; $arrinc_hj[1]=0;}else{$arrinc_hj[1]=$rlzn['CASA_vol']; $arrinc_mr[1]=0;}}
	if($rlzn['TD_vol'] || $tgt->TD_vol){$arrprod[2]='Time Deposit <br>('.number_format($rlzn['TD_vol'],0,".",",").'%)'; if($rlzn['TD_vol']<100){ $arrinc_mr[2]=$rlzn['TD_vol']; $arrinc_hj[2]=0;}else{$arrinc_hj[2]=$rlzn['TD_vol']; $arrinc_mr[2]=0;}}
	if($rlzn['WCL_vol'] || $tgt->WCL_vol){$arrprod[3]='Working Capital Loan <br>('.number_format($rlzn['WCL_vol'],0,".",",").'%)'; if($rlzn['WCL_vol']<100){ $arrinc_mr[3]=$rlzn['WCL_vol']; $arrinc_hj[3]=0;}else{$arrinc_hj[3]=$rlzn['WCL_vol']; $arrinc_mr[3]=0;}}
	if($rlzn['IL_vol'] || $tgt->IL_vol){$arrprod[4]='Investment Loan <br>('.number_format($rlzn['IL_vol'],0,".",",").'%)'; if($rlzn['IL_vol']<100){ $arrinc_mr[4]=$rlzn['IL_vol']; $arrinc_hj[4]=0;}else{$arrinc_hj[4]=$rlzn['IL_vol']; $arrinc_mr[4]=0;}}
	if($rlzn['SL_vol'] || $tgt->SL_vol){$arrprod[5]='Structured Loan <br>('.number_format($rlzn['SL_vol'],0,".",",").'%)'; if($rlzn['SL_vol']<100){ $arrinc_mr[5]=$rlzn['SL_vol']; $arrinc_hj[5]=0;}else{$arrinc_hj[5]=$rlzn['SL_vol']; $arrinc_mr[5]=0;}}
	if($rlzn['TR_vol'] || $tgt->TR_vol){$arrprod[6]='Trust Receipt <br>('.number_format($rlzn['TR_vol'],0,".",",").'%)'; if($rlzn['TR_vol']<100){ $arrinc_mr[6]=$rlzn['TR_vol']; $arrinc_hj[6]=0;}else{$arrinc_hj[6]=$rlzn['TR_vol']; $arrinc_mr[6]=0;}}
	if($rlzn['FX_vol'] || $tgt->FX_vol){$arrprod[7]='FX & Derivatives <br>('.number_format($rlzn['FX_vol'],0,".",",").'%)'; if($rlzn['FX_vol']<100){ $arrinc_mr[7]=$rlzn['FX_vol']; $arrinc_hj[7]=0;}else{$arrinc_hj[7]=$rlzn['FX_vol']; $arrinc_mr[7]=0;}}
	if($rlzn['SCF_vol'] || $tgt->SCF_vol){$arrprod[8]='Supply Chain Financing <br>('.number_format($rlzn['SCF_vol'],0,".",",").'%)'; if($rlzn['SCF_vol']<100){ $arrinc_mr[8]=$rlzn['SCF_vol']; $arrinc_hj[8]=0;}else{$arrinc_hj[8]=$rlzn['SCF_vol']; $arrinc_mr[8]=0;}}
	if($rlzn['Trade_vol'] || $tgt->Trade_vol){$arrprod[9]='Trade Services <br>('.number_format($rlzn['Trade_vol'],0,".",",").'%)'; if($rlzn['Trade_vol']<100){ $arrinc_mr[9]=$rlzn['Trade_vol']; $arrinc_hj[9]=0;}else{$arrinc_hj[9]=$rlzn['Trade_vol']; $arrinc_mr[9]=0;}}
	if($rlzn['BG_vol'] || $tgt->BG_vol){$arrprod[10]='Bank Guarantee <br>('.number_format($rlzn['BG_vol'],0,".",",").'%)'; if($rlzn['BG_vol']<100){ $arrinc_mr[10]=$rlzn['BG_vol']; $arrinc_hj[10]=0;}else{$arrinc_hj[10]=$rlzn['BG_vol']; $arrinc_mr[10]=0;}}
	if($rlzn['OIR_vol'] || $tgt->OIR_vol){$arrprod[11]='Outgoing Intl Remittance <br>('.number_format($rlzn['OIR_vol'],0,".",",").'%)'; if($rlzn['OIR_vol']<100){ $arrinc_mr[11]=$rlzn['OIR_vol']; $arrinc_hj[11]=0;}else{$arrinc_hj[11]=$rlzn['OIR_vol']; $arrinc_mr[11]=0;}}
	if($rlzn['PWE_vol'] || $tgt->PWE_vol){$arrprod[12]='PWE non L/C <br>('.number_format($rlzn['PWE_vol'],0,".",",").'%)'; if($rlzn['PWE_vol']<100){ $arrinc_mr[12]=$rlzn['PWE_vol']; $arrinc_hj[12]=0;}else{$arrinc_hj[12]=$rlzn['PWE_vol']; $arrinc_mr[12]=0;}}
	if($rlzn['ECM_vol'] || $tgt->ECM_vol){$arrprod[13]='ECM <br>('.number_format($rlzn['ECM_vol'],0,".",",").'%)'; if($rlzn['ECM_vol']<100){ $arrinc_mr[13]=$rlzn['ECM_vol']; $arrinc_hj[13]=0;}else{$arrinc_hj[13]=$rlzn['ECM_vol']; $arrinc_mr[13]=0;}}
	if($rlzn['DCM_vol'] || $tgt->DCM_vol){$arrprod[14]='DCM <br>('.number_format($rlzn['DCM_vol'],0,".",",").'%)'; if($rlzn['DCM_vol']<100){ $arrinc_mr[14]=$rlzn['DCM_vol']; $arrinc_hj[14]=0;}else{$arrinc_hj[14]=$rlzn['DCM_vol']; $arrinc_mr[14]=0;}}
	if($rlzn['MA_vol'] || $tgt->MA_vol){$arrprod[15]='M&A <br>('.number_format($rlzn['MA_vol'],0,".",",").'%)'; if($rlzn['MA_vol']<100){ $arrinc_mr[15]=$rlzn['MA_vol']; $arrinc_hj[15]=0;}else{$arrinc_hj[15]=$rlzn['MA_vol']; $arrinc_mr[15]=0;}}
	
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
                shared: false,
                
            },
            plotOptions: {
                column: {
                    stacking: true,
                    dataLabels: {
                        enabled: false,
                        format: '<span style="color:white">{point.y:.0f}%</span>'
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
	<?php echo $header?>
	<div>
		<div id="container" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
		<div id="container_income" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
		<!--<div>
			
			<div id="container2" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
			<div id="container3" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		</div>--><div style="clear:both"></div><br>
	</div>
</div>