<?php 
	
?>


<script type="text/javascript">
	$(function () {
        $('#container_casa').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Total CASA'
            },
            xAxis: {
                categories: ['']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp Miliar'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.0f}%</b><br/>',
                shared: false,
                enabled: false
                
            },
            plotOptions: {
                column: {
                    stacking: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
                series: [
            {
                name: 'Des 2013',
            	data: [<?php echo round($total['ly']->CASA_vol/pow(10,9),0)?>],
            },{
                name: 'Juni 2014',
            	data: [<?php echo round($total['tm']->CASA_vol/pow(10,9),0)?>],
            },{
                name: 'Target',
            	data: [<?php echo round($total['tgt']->CASA_vol,0)?>],
            },{
                name: 'Wallet',
            	data: [<?php echo round($total['wal']->CASA_vol,0)?>],
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<div>
		<div style="padding-right:20px; padding-top:20px;">
			<table class="table table-bordered" style="font-size:10px;">
				<thead><tr>
					<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
				</tr><tr>
					<th>Actual</th><th>Juni</th><th>YTD 2014</th><th>Kontribusi (%)</th>
				</tr></thead><tbody>
				<?php 
					$vol = "CASA_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
					$bagi=9; $i=0;
					foreach($pareto as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
					<tr>
						<td><?php echo $anchor->name?></td>
						<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
						<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
					
						<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
						<td><?php echo number_format($anchor->$vol/$total['tm']->$vol*100,1,',','.')?> %</td>
					</tr>
				<?php
					
						$temp_tot = $temp_tot + $anchor->$vol;
						$ly_tot = $ly_tot + $anchor->$ly;
						$trgt_tot = $trgt_tot + $anchor->$trgt;
						$sum_cmpny++; $i++;
						if($i==6){break;}
					}?>
				 <tr>
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
				 </tr>
				</tbody>
			</table>
		</div>
		<div style="clear:both"></div>
		<br>
	</div>
	<div id="container_casa" style="height:400px;"></div>
</div>