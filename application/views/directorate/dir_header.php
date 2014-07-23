<?php 
	if($directorate == 'CB'){$title = 'Corporate Banking';}
	elseif($directorate == 'IB'){$title = 'Institutional Banking';}
	elseif($directorate == 'CBB'){$title = 'Commercial and Bussines Banking';}
	elseif($directorate == 'CB1'){$title = 'CORPORATE BANKING I';}
	elseif($directorate == 'CB2'){$title = 'CORPORATE BANKING II';}
	elseif($directorate == 'CB3'){$title = 'CORPORATE BANKING III';}
	elseif($directorate == 'AGB'){$title = 'CORPORATE BANKING AGRO BASED';}
	elseif($directorate == 'SOG'){$title = 'SYNDICATION, OIL & GAS';}
	elseif($directorate == 'IB1'){$title = 'INSTITUTIONAL BANKING I';}
	elseif($directorate == 'IB2'){$title = 'INSTITUTIONAL BANKING II';}
	elseif($directorate == 'JCS'){$title = 'JAKARTA COMMERCIAL SALES';}
	elseif($directorate == 'RCS1'){$title = 'REGIONAL COMMERCIAL SALES I';}
	elseif($directorate == 'RCS2'){$title = 'REGIONAL COMMERCIAL SALES II';}
?>
<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
	<h2><?php echo $title?></h2>
	<h4></h4>
	<ul class="nav nav-pills" style="float:right; margin-top:5px;">
		<li><a href="<?php echo base_url()?>realization/show/directorate/<?php echo $directorate?>">Realization</a></li>
		<li><a href="<?php echo base_url()?>directorate/pendapatan/<?php echo $directorate?>">Income</a></li>
		<li><a href="<?php echo base_url()?>directorate/wallet/<?php echo $directorate?>">Wallet</a></li>
	</ul><div style="clear:both"></div>
</div>