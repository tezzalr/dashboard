<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2 style="float:left">Top Anchor Bank Mandiri</h2>
		<ul class="nav nav-pills" style="float:right; margin-top:30px;">
		  <li><a href="<?php echo base_url()?>bankwide/top_volume/<?php echo $product?>">Volume</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_growth/<?php echo $product?>">Growth</a></li>
		  <li><a href="<?php echo base_url()?>bankwide/top_nominal_growth/<?php echo $product?>">Nominal Growth</a></li>
		</ul><div style="clear:both"></div>
	</div>
	<div>
		<div>
			<h3>Top Volume Transaksi <?php echo $prd_name?></h3><br>
			<div style="margin-bottom: 20px;">
					<form method="post" action="<?php echo base_url()?>product/refresh_top/">
					<label style="margin-right:20px;">Produk:</label> 
					<select name="product">
						<?php foreach($arr_prod as $prod){?>
						<option value="<?php echo $prod['id']?>" <?php if($this->uri->segment(3)==$prod['id']){echo "selected";}?>><?php echo $prod['name']?></option>
						<?php }?>
					</select><br>
					<button type="submit" class="btn btn-default btn-sm" style="margin-left:195px; margin-top:5px;">Pilih</button>
					</form>
			</div><hr>
			<div style="margin-left:0px">
				<div style="width:50%; float:left; padding-right:20px;">
					<div>
						<div style="margin-right:40px; float:left;">
						<a href="#" class="btn btn-link disabled">Annualized</a></div>
						<div style="clear:both"></div>
					</div>
					<h4>Top Volume (Rp M)</h4>
					<table class="table table-bordered" style="font-size:10px;">
						<thead class="headertab"><tr>
							<th rowspan=2><center>Nama Anchor</center></th><th>2013</th><th colspan=3><center>2014</center></th>
						</tr><tr>
							<th>Actual</th><th><?php echo get_month_name($month)?></th><th>YTD 2014</th><th>Kontribusi (%)</th>
						</tr></thead><tbody>
						<?php 
							$vol = $product."_vol"; $temp_tot=0; $ly = $vol.'_ly'; $ly_tot=0; $sum_cmpny=1; $trgt = $vol."_target"; $trgt_tot=0;
							$bagi=9; if($product == 'FX' || $product == 'Trade'){$bagi=6;}elseif($product == 'OIR'){$bagi=0;}
							foreach($top_anchor_vol as $anchor){ $ytd = $anchor->$vol/$anchor->month*12;?>
							<tr>
								<td><?php echo $anchor->name?></td>
								<!--<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>-->
								<td><?php echo number_format($anchor->$ly/pow(10,$bagi),0,',','.')?></td>
								
								<td><?php echo number_format($anchor->$vol/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($ytd/pow(10,$bagi),0,',','.')?></td>
								<td><?php echo number_format($anchor->$vol/$total_prd->$vol*100,1,',','.')?> %</td>
							</tr>
						<?php
								
								$temp_tot = $temp_tot + $anchor->$vol;
								$ly_tot = $ly_tot + $anchor->$ly;
								$trgt_tot = $trgt_tot + $anchor->$trgt;
								$sum_cmpny++;
								if(($temp_tot/$total_prd->$vol) > 0.7  && $sum_cmpny >5){break;}
						 	}?>
						 <tr>
							 <td><b>Sub-total</b></td><td><?php echo number_format($ly_tot/pow(10,$bagi),0,',','.')?></td>
							 
							 <td><?php echo number_format($temp_tot/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($temp_tot/$anchor->month*12/pow(10,$bagi),0,',','.')?></td>
							 <td><?php echo number_format($temp_tot/$total_prd->$vol*100,0,',','.')?> %</td>
						 </tr>
						</tbody>
					</table>
				</div>
				<div style="width:50%;  float:right">
					<div id="type-sign">
						<div style="margin-right:40px; float:left;">
							<a href="#" class="btn btn-link disabled" id="ytd" onclick="change_growth('<?php echo $this->uri->segment(3)?>','ytd');">Annualized</a>
						</div>
						<div  style="float:left;">
							<a href="#" class="btn btn-link" id="tm" onclick="change_growth('<?php echo $this->uri->segment(3)?>','tm');">Sampai Bulan Ini</a>
						</div>
						<div style="clear:both"></div>
					</div>
					<div id="growth"><?php echo $growth_tab?></div>
				</div>
			</div>
			<div>
			</div>
		</div>
	</div>
</div>
<script>
	function change_growth(prod,type){
		$.ajax({
			type: "GET",
			url: config.base+"product/change_growth_table",
			data: {prod: prod, type: type},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#growth").html(resp.html);
					$("#"+resp.type).addClass('disabled');
					$("#"+resp.rev).removeClass('disabled');
				}else{}
			}
		});
	}
</script>
<style>
	.disabled{
		color:grey;
	}
</style>