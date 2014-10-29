<?php
	$bagi = get_produk_pow($this->uri->segment(5));
?>
<script type="text/javascript">
	$(function () {
        $('#container4').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Pertumbuhan <?php echo $this->uri->segment(6)?> <?php echo $product_name?> <?php $date = date("Y"); echo $date-1?> & <?php echo $date?>'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '2014',
                data: [<?php for($i=1;$i<=$last_month_data;$i++){$mth = 'mth_'.$i; echo round($this_year->$mth/pow(10,$bagi),1).', ';}?>],
            }, {
            	name: '2013',
                data: [<?php for($i=1;$i<=12;$i++){$mth = 'mth_'.$i; echo round($ly_year->$mth/pow(10,$bagi),1).', ';}?>],
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<div>
			<div style="margin-bottom: 20px; float:left;">
					<form method="post" action="<?php echo base_url()?>tren/refresh_product/<?php echo $level?>/<?php echo $id?>">
					<label style="margin-right:20px;">Produk:</label> 
					<select name="product">
						<?php foreach($arr_prod as $prod){?>
						<option value="<?php echo $prod['id']?>" <?php if($this->uri->segment(5)==$prod['id']){echo "selected";}?>><?php echo $prod['name']?></option>
						<?php }?>
					</select><br>
					<label style="margin-right:37px;">Data:</label> 
					<select name="kind">
						<option value="volume" <?php if($this->uri->segment(6)=="volume"){echo "selected";}?>>Volume</option>
						<option value="income" <?php if($this->uri->segment(6)=="income"){echo "selected";}?>>Income</option>
					</select><hr>
					<button type="submit" class="btn btn-default btn-md">Cari</button>
					</form>
			</div>
			<!--<div style="float: right"><h3>YTD (%Target) : <span style="color: red">90%</span></h3></div>--><div style="clear:both"></div>
		</div>
		<div id="container4" style="min-width: 310px; height: 380px; margin: 0 auto"></div>
	</div>
</div>