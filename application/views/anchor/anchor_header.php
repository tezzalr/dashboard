<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
	<h2><?php echo $anchor->name?></h2>
	<h4><?php echo $anchor->group?></h4>
	<ul class="nav nav-pills" style="float:right; margin-top:5px;">
		<li><a href="<?php echo base_url()?>report/relation_income/anchor/<?php echo $anchor->id;?>">Report</a></li>
		<li><a href="<?php echo base_url()?>realization/show/anchor/<?php echo $anchor->id;?>">Realization</a></li>
		<li><a href="<?php echo base_url()?>anchor/pendapatan/<?php echo $anchor->id;?>">Income</a></li>
		<li><a href="<?php echo base_url()?>anchor/wallet/<?php echo $anchor->id;?>">Wallet</a></li>
		<li><a href="<?php echo base_url()?>anchor/product/<?php echo $anchor->id;?>/CASA/income">Tren Product</a></li>
	</ul><div style="clear:both"></div>
</div>