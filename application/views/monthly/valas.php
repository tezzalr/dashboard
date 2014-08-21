<script type="text/javascript">
	$(function () {
        $('#container_casa').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Komposisi CASA'
            },
            xAxis: {
                categories: ['Des 2013','Juni 2014']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp Miliar'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{white}">{series.name}</span>: <b>{point.y:.0f}</b><br/>',
                shared: false,
                enabled: true
                
            },
            plotOptions: {
                column: {
                    stacking: true,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
                series: [
            {
                name: 'IDR',
            	data: [<?php echo round($total['ly']['idr']->CASA_idr/pow(10,9),0)?>,<?php echo round($total['tm']['idr']->CASA_idr/pow(10,9),0)?>],
            },{
                name: 'Valas',
            	data: [<?php echo round($total['tm']['val']->CASA_val/pow(10,9),0)?>,<?php echo round($total['tm']['val']->CASA_val/pow(10,9),0)?>],
            	color:'yellow',
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<?php echo $header?>
	<a href="<?php echo base_url()?>monthly/top_fbi"><span style="float:right">Next --></span></a><br>
	<div id="container_casa" style="height:400px; width:50%"></div>
	<div style="width:80%;">
		<div style="padding-right:20px; padding-top:20px;">
			<table class="table table-bordered" style="font-size:10px;">
				<thead class="headertab"><tr>
					<th rowspan=2 valign="middle" align="center">Nama Anchor</th><th colspan=2><center>Des 2013</center></th><th colspan=2><center>Juni 2014</center></th>
				</tr><tr>
					<th>Nom. IDR (%)</th><th>Nom. Valas (%)</th><th>Nom. IDR (%)</th><th>Nom. Valas (%)</th>
				</tr></thead><tbody>
				<?php 
					$vol = "CASA_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
					$bagi=9; $i=0;
					foreach($pareto as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
					<tr>
						<td><?php echo $anchor->name?></td>
						<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
						<td><?php echo number_format($anchor->idr_ly/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->val_ly/pow(10,$bagi),0,',','.')?></td>
						<!--<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>-->
						<td><?php echo number_format($anchor->idr_tm/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->val_tm/pow(10,$bagi),0,',','.')?></td>
						<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>-->
					</tr>
				<?php
					
						$temp_tot = $temp_tot + $anchor->$vol;
						$ly_tot = $ly_tot + $anchor->$ly;
						$sum_cmpny++; $i++;
						if($i==6){break;}
					}?>
				 <!--<tr>
					 <td><b>Sub-total</b></td><td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
					 <td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
					 <td><?php echo number_format($temp_tot/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
					 <td><?php echo number_format($temp_tot/$total['tm']->$vol*100,0,',','.')?> %</td>
				 </tr>
				 <tr>
					 <td><b>Total</b></td><td><?php echo number_format($total['ly']->$vol/pow(10,$bagi),0,',','.')?></td>
				 
					 <td><?php echo number_format($total['tm']->$vol/pow(10,$bagi),0,',','.')?></td>
					 <td><?php echo number_format($total['tm']->$vol/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
					 <td><?php echo number_format(100,0,',','.')?> %</td>
				 </tr>-->
				</tbody>
			</table>
		</div>
		<div style="clear:both"></div>
		<br>
	</div>
</div>