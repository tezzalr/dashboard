<?php 
	$user = $this->session->userdata('userdb');
?>
<style>
	.header_top a{
		color:#0B0A51;
	}
	.header_top a:hover{
		color:white;
	}
</style>
<div style="width:100%; background-color:#D4D5D9; padding-left:60px; height:30px; padding-top:5px;">
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>anchor">Anchor</a></div>
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>product/top_transaksi/CASA">Produk</a></div>
	<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>monthly/share_anchor">Monthly Report</a></div>
	<!--<div class="header_top" style="float:left; margin-right:20px;"><a href="<?php echo base_url()?>update/activity_wall">Activity Update</a></div>-->
	<div class="header_top" style="float:right; margin-right:20px;"><a href="<?php echo base_url()?>user/logout">Logout</a></div>
	
	<?php if($user){?>
		<div class="header_top" style="float:right; margin-right:20px;"><a href="<?php echo base_url()?>user/input_user"><?php echo $user['name']?></a></div>
	<?php }?>
	<?php if($user['role']=="admin"){?>
		<div class="header_top" style="float:right; margin-right:20px;"><a href="<?php echo base_url()?>user/input_user">User</a></div>
	<?php }?>
	
	<div style="clear:both"></div>
</div>
<div style="float:right; padding:5px 25px 5px 5px;">
<form method="post" action="<?php echo base_url()?>anchor/change_report_month">
	<?php $rptmth = $this->session->userdata('rptmth'); $lstmth = $this->session->userdata('lstmth');?>
	<label style="margin-right:20px">Bulan laporan:</label>
	<input type="hidden" name="last_url" value="<?php echo uri_string();?>">
	<select id="mth" name="report_month" style="width:150px">
		<?php for($i=1;$i<=$lstmth;$i++){?>
				<option value="<?php echo $i?>" <?php if($rptmth == $i){echo "selected";}?>><?php echo get_month_full_name($i)?></option>
		<?php }?>
	</select>
	<input type="submit" class="btn btn-xs btn-default" value="Ubah" style="background-color:#0B0A51; border-color:#0B0B61; color:white;">
</form>

</div><div style="clear:both"></div>
<hr style="margin: 0">
