<script type="text/javascript">
$(function () {
        $('#container4').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pertumbuhan Produk Mei 2014'
            },
            xAxis: {
                categories: ['CASA', 'Time Deposit', 'Loan', 'Trade', 'Bank Guarantee', 'NII Others', 'SCF', 'PWE']
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Growth',
                data: [50, 90, 45, 70, 80, -29, 10, 80]
            }]
        });
    });
    

		</script>

<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2 style="float:left">June 2014 Review</h2>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>bankwide">Home</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_anchor">Top Anchor</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div>
		<div id="container4" style="min-width: 310px; height: 380px; margin: 0 auto"></div>
	</div>
	<div style="margin-left:20px">
		<div style="width:50%; float:left; padding-right:20px;">
			<h4>Top Anchor Growth Per Product</h4>
			<table class="table table-striped">
				<thead><tr>
					<th>Product</th><th>Nama Anchor</th><th>Nominal Growth</th><th>Growth</th>
				</tr></thead><tbody>
				<tr>
					<td>CASA</td><td>Pertamina</td><td>14.289</td><td>30%</td>
				</tr>
				<tr>
					<td>Time Deposit</td><td>PLN Group</td><td>14.289</td><td>70%</td>
				</tr>
				<tr>
					<td>Loan</td><td>Wilmar Group</td><td>14.289</td><td>80%</td>
				</tr>
				<tr>
					<td>Trade</td><td>Permata Hijau Sawit Group</td><td>14.289</td><td>34%</td>
				</tr>
				<tr>
					<td>FX & Derivatives</td><td>Sinar Mas Group</td><td>14.289</td><td>10%</td>
				</tr></tbody>
			</table>
		</div>
		<div style="width:50%; float:left; padding-left: 20px;">
			<h4>Top Anchor Negative Growth Per Product</h4>
			<table class="table table-striped">
				<thead><tr>
					<th>Product</th><th>Nama Anchor</th><th>Nominal Growth</th><th>Growth</th>
				</tr></thead><tbody>
				<tr>
					<td>CASA</td><td>Kompas Gramedia Group</td><td style="color:red">(14.289)</td><td style="color:red">-30%</td>
				</tr>
				<tr>
					<td>Time Deposit</td><td>Kementrian Keuangan</td><td style="color:red">(14.289)</td><td style="color:red">-70%</td>
				</tr>
				<tr>
					<td>Loan</td><td>Kementrian Pendidikan</td><td style="color:red">(14.289)</td><td style="color:red">-80%</td>
				</tr>
				<tr>
					<td>Trade</td><td>Tudung Group</td><td style="color:red">(14.289)</td><td style="color:red">-34%</td>
				</tr>
				<tr>
					<td>FX & Derivatives</td><td>Axiata Group</td><td style="color:red">(14.289)</td><td style="color:red">-10%</td>
				</tr></tbody>
			</table>
		</div>
	</div>
</div>