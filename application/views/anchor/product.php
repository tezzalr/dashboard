<script type="text/javascript">
	$(function () {
        $('#container4').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Pertumbuhan Trade 2013 dan 2014'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Millions'
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
                data: [<?php for($i=1;$i<=5;$i++){$mth = 'mth_'.$i; echo round($this_year->$mth/pow(10,6),2).', ';}?>],
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2 style="float:left">Anchor Name</h2>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>anchor">Home</a></li>
		  <li><a href="#">Profile</a></li>
		  <li><a href="<?php echo base_url()?>anchor/product">Product</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div>
		<div>
			<div style="margin-bottom: 20px; float:left;">
					<label style="margin-right:20px;">Produk:</label> 
					<select>
						<option>Trade</option>
						<option>CASA</option>
						<option>Time Deposit</option>
						<option>Bank Guarantee</option>
						<option>NII Others</option>
					</select><br>
					<label style="margin-right:37px;">Data:</label> 
					<select>
						<option>Volume</option>
						<option>Income</option>
					</select>
			</div>
			<div style="float: right"><h3>YTD (%Target) : <span style="color: red">90%</span></h3></div><div style="clear:both"></div>
		</div>
		<div id="container4" style="min-width: 310px; height: 380px; margin: 0 auto"></div>
	</div>
</div>