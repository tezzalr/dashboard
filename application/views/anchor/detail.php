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
                categories: ['CASA', 'Time Deposit', 'Working Capital Loan', 'Investment Loan', 'Structured Loan', 'Trust Receipt', 'NII Others', 'FX & Derivatives', 'Supply Chain Financing', 'Trade Services', 'Bank Guarantee', 'Outgoing Intl Remittance', 'PWE non L/C', 'Loan Maintenance Fee', 'Syndication Fee', 'FBI Other']
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
                data: [<?php echo $rlzn['CASA_vol']?>, <?php echo $rlzn['TD_vol']?>, <?php echo $rlzn['WCL_vol']?>, <?php echo $rlzn['IL_vol']?>, <?php echo $rlzn['SL_vol']?>, <?php echo $rlzn['TR_vol']?>, 0, <?php echo $rlzn['FX_vol']?>, <?php echo $rlzn['SCF_vol']?>, <?php echo $rlzn['Trade_vol']?>, <?php echo $rlzn['BG_vol']?>, <?php echo $rlzn['OIR_vol']?>, <?php echo $rlzn['PWE_vol']?>, 0, 0, 0],
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
                categories: ['CASA', 'Time Deposit', 'Working Capital Loan', 'Investment Loan', 'Structured Loan', 'Trust Receipt', 'NII Others', 'FX & Derivatives', 'Supply Chain Financing', 'Trade Services', 'Bank Guarantee', 'Outgoing Intl Remittance', 'PWE non L/C', 'Loan Maintenance Fee', 'Syndication Fee', 'FBI Other']
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
                data: [<?php echo $rlzn['CASA_inc']?>, <?php echo $rlzn['TD_inc']?>, <?php echo $rlzn['WCL_inc']?>, <?php echo $rlzn['IL_inc']?>, <?php echo $rlzn['SL_inc']?>, 0, 0, 0, 0, 0, 0, <?php echo $rlzn['OIR_inc']?>, 0, 0, 0, 0]
            }]
        });
    });
    

</script>

<script type="text/javascript">
	$(function () {
        $('#container2').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Potensi Wallet'
            },
            xAxis: {
                categories: ['CASA', 'Time Deposit', 'Loan', 'Trade', 'Bank Guarantee', 'NII Others'],
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
                name: 'Income',
                data: [107, 31, 435, 203, 400, 300],
                color: 'yellow'
            }, {
                name: 'Wallet Size',
                data: [133, 156, 547, 408, 600, 900],
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
			$('#container3').highcharts({
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
							enabled: false
						},
						showInLegend: true
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

<script type="text/javascript">
	$(function () {
        $('#container3').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Potensi Wallet'
            },
            xAxis: {
                categories: ['CASA', 'Time Deposit', 'Loan', 'Trade', 'Bank Guarantee', 'NII Others'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Population (millions)',
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
                name: 'Income',
                data: [107, 31, 435, 203, 400, 300],
                color: 'yellow'
            }, {
                name: 'Wallet Size',
                data: [133, 156, 947, 408, 600, 900],
                color: 'orange'
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2><?php echo $anchor->name?></h2>
		<h4><?php echo $anchor->group?></h4>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>anchor/profile">Profile</a></li>
		  <li><a href="<?php echo base_url()?>anchor/product">Product</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div id="container" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
	<div id="container_income" style="min-width: 310px; height: 350px; margin: 0 auto"></div><hr>
	<div>
		<div id="container2" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
		<div id="container3" style="min-width: 310px; width: 50%; height: 350px; margin: 0; float:left"></div>
	</div><div style="clear:both"></div><br>
</div>