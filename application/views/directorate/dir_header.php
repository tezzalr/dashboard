<?php 
	$title = get_direktorat_full_name($directorate);
?>
<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
	<h2><?php echo $title?></h2>
	<h4></h4>
	<ul class="nav nav-pills" style="float:right; margin-top:5px;">
		<li><a href="<?php echo base_url()?>report/relation_income/directorate/<?php echo $directorate;?>">Report</a></li>
		<li><a href="<?php echo base_url()?>realization/show/directorate/<?php echo $directorate?>">Realization</a></li>
		<li><a href="<?php echo base_url()?>directorate/pendapatan/<?php echo $directorate?>">Income</a></li>
		<li><a href="<?php echo base_url()?>directorate/wallet/<?php echo $directorate?>">Wallet</a></li>
		<li><a href="<?php echo base_url()?>tren/show/directorate/<?php echo $directorate;?>/CASA/volume">Trend Product</a></li>
	</ul><div style="clear:both"></div>
</div>