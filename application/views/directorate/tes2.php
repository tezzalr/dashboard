<script type="text/javascript">
	$(function () {
        $('#container_sow').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Potensi (Wallet Size) vs SoW'
            },
            xAxis: {
                categories: ['CASA', 'Loan', 'Trade', 'Bank Guarantee', 'FX & Derivatives', 'NII Others'],
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
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
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
                name: 'Wallet Size',
                data: [133, 156, 547, 408, 600, 900],
                color: 'yellow'
            }, {
                name: 'Size of Wallet',
                data: [107, 31, 435, 203, 400, 300],
                color: 'orange'
            }]
        });
    });
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_lnl').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Perbandingan Pendapatan Wholesale vs Alliance'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['Non Loan',   100],
						{
							name: 'Loan',
							y: 300,
							sliced: true,
							selected: true
						}
					]
				}]
			});
		});
	
	});
</script>

<script type="text/javascript">
	$(function () {
		var chart;
	
		$(document).ready(function () {
		
			// Build the chart
			$('#container_wsa').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Komposisi Pendapatan Wholesale'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						},
						showInLegend: false
					}
				},
				series: [{
					type: 'pie',
					name: 'Income share',
					data: [
						['CASA',   12.0],
						['Time Deposit',       26.8],
						{
							name: 'Loan',
							y: 45.8,
							sliced: true,
							selected: true
						},
						['Trade',    8.5],
						['Bank Guarantee',     6.2],
						['NII Others',   0.7]
					]
				}]
			});
		});
	
	});
</script>

<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2>Total Relationship Income</h2>
		<span style="font-size:20px">Potensi dan Komposisi<div style="clear:both"></span></div>
	</div>
	<!--<div id="container_all" style="min-width: 310px; width: 100%; height: 500px; margin: 0;"></div><br><br>-->
	<div>
		<div>
			<div id="" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left"><h3>Potensi (Wallet Size) vs SoW 2013</h3><h4>Wallet Size : Rp 31,9 T</h4><h4>Share of Wallet : Rp 8,1 T</h4></div>
			<div id="container_sow" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left"></div>
		</div>
		<div>
			<div id="container_lnl" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left"></div>
			<div id="container_wsa" style="min-width: 310px; width: 50%; height: 300px; margin: 0; float:left"></div>
		</div>
	</div><div style="clear:both"></div><br><br>
</div>
