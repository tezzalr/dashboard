<?php 
	if($directorate == 'CB'){$title = 'Corporate Banking';}
	elseif($directorate == 'IB'){$title = 'Institutional Banking';}
	else{$title = 'Commercial and Bussines Banking';}
?>
<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
	<h2><?php echo $title?> Directorate</h2>
	<h4></h4>
	<ul class="nav nav-pills" style="float:right; margin-top:5px;">
		<li><a href="<?php echo base_url()?>directorate/realisasi/<?php echo $directorate?>">Realization</a></li>
		<li><a href="<?php echo base_url()?>directorate/pendapatan/<?php echo $directorate?>">Income</a></li>
		<li><a href="<?php echo base_url()?>directorate/wallet/<?php echo $directorate?>">Wallet</a></li>
	</ul><div style="clear:both"></div>
</div>