<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
	<h2><?php echo $anchor->name?></h2>
	<h4><?php echo $anchor->group?></h4>
	<ul class="nav nav-pills" style="float:right; margin-top:5px;">
		<li><a href="<?php echo base_url()?>anchor/realisasi/<?php echo $anchor->id;?>">Realization</a></li>
		<li><a href="<?php echo base_url()?>anchor/pendapatan/<?php echo $anchor->id;?>">Income</a></li>
		<li><a href="<?php echo base_url()?>anchor/wallet/<?php echo $anchor->id;?>">Wallet</a></li>
		<li><a href="<?php echo base_url()?>anchor/product/<?php echo $anchor->id;?>/CASA/income">Product</a></li>
	</ul><div style="clear:both"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#unit-token").
        tokenInput("<?php echo base_url('profile/get_unit_token');?>", {
                   tokenLimit: 1
                   });
        $('#unit-token').live('change', function(){
            window.location.replace("http://stackoverflow.com");
        });
    });
</script>

<form id="newunitform" method="post" action="<?php echo base_url();?>profile/add_new_unit">
    <dl class="info_standard" id="edit_profile">
        <dt>Tambah Unit</dt><dd><input type="text" id="unit-token" name="new-unit" /></dd>
    </dl>
</form>
<div id="data-unit">
</div>
