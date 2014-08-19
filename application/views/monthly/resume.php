<?php 
	$groups = array('CB1','CB2','CB3','AGB','SOG');
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
                categories: ['CB1', 'CB2', 'CB3', 'AGB', 'SOG']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp Triliun'
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
            	data: [<?php foreach($groups as $group){echo round($total['casa'][$group]['ly']->CASA_vol/pow(10,12),1).", ";}?>],
            },{
                name: 'Juni 2014',
            	data: [<?php foreach($groups as $group){echo round($total['casa'][$group]['tm']->CASA_vol/pow(10,12),1).", ";}?>],
            },{
                name: 'Target',
            	data: [<?php foreach($groups as $group){echo round($total['casa'][$group]['tgt']->CASA_vol/pow(10,3),1).", ";}?>],
            },{
                name: 'Wallet',
            	data: [<?php foreach($groups as $group){echo round($total['casa'][$group]['wal']->CASA_vol/pow(10,3),1).", ";}?>],
            }]
        });
    });
</script>

<script type="text/javascript">
	$(function () {
        $('#container_fbi').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'FBI'
            },
            xAxis: {
                categories: ['CB1', 'CB2', 'CB3', 'AGB', 'SOG']
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
            	data: [<?php foreach($groups as $group){echo round($total['fbi'][$group]['ly'],1).", ";}?>],
            },{
                name: 'Juni 2014',
            	data: [<?php foreach($groups as $group){echo round($total['fbi'][$group]['tm'],1).", ";}?>],
            },{
                name: 'Target',
            	data: [<?php foreach($groups as $group){echo round($total['fbi'][$group]['tgt'],1).", ";}?>],
            },{
                name: 'Wallet',
            	data: [<?php foreach($groups as $group){echo round($total['fbi'][$group]['wal'],1).", ";}?>],
            }]
        });
    });
</script>

<script type="text/javascript">
	$(function () {
        $('#container_kredit').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Baki Debit'
            },
            xAxis: {
                categories: ['CB1', 'CB2', 'CB3', 'AGB', 'SOG']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rp Triliun'
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
            	data: [<?php foreach($groups as $group){echo round($total['kredit'][$group]['ly']/pow(10,12),1).", ";}?>],
            },{
                name: 'Juni 2014',
            	data: [<?php foreach($groups as $group){echo round($total['kredit'][$group]['tm']/pow(10,12),1).", ";}?>],
            },{
                name: 'Target',
            	data: [<?php foreach($groups as $group){echo round($total['kredit'][$group]['tgt']/pow(10,3),1).", ";}?>],
            },{
                name: 'Wallet',
            	data: [<?php foreach($groups as $group){echo round($total['kredit'][$group]['wal']/pow(10,3),1).", ";}?>],
            }]
        });
    });
</script>

<div id="" class="container no_pad">
	<br>
	Wallet > Realisasi (Potensi CASA masih besar)
	<div id="container_casa" style="height:300px;"></div><hr>
	Dibanding 2013 Realisasi FBI masih rendah
	<div id="container_fbi" style="height:300px;"></div>
	Potensi Loan Besar
	<div id="container_kredit" style="height:300px;"></div>
</div>