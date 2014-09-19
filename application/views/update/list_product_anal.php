<?php 
	//$m_now = date('m');
	//if($m_now < 7){$iter = 1;}
	//else{$iter = 7;}
?>
<div id="" class="container no_pad">
	<?php echo $header?>
	<div style="margin-top:-65px; margin-bottom:30px;">
		<a href="<?php echo base_url()?>update/input_product_analysis" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Analysis</a>
	</div>
	<div style="margin-bottom:20px">
		<h3>List of Product Analysis</h3>
		<table class="table table-bordered" style="font-size:13px">
			<thead>
				<tr class="headertab"><th>PIC</th><th>Product</th>
				<?php for($i=1;$i<=12;$i++){?>
				<th style="width:70px"><?php echo get_month_name($i);?></th>
				<?php }?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($analysis as $prod){?>
					<tr>
						<td></td><td><?php echo $prod['prod_name']?></td>
						<?php $anal_iter = 0; for($i=1;$i<=12;$i++){?>
							<td style="font-size:11px"><?php 
								if($prod['analysis'] && $prod['analysis'][$anal_iter]->report_month == $i){
									echo date("d/M/y", strtotime($prod['analysis'][$anal_iter]->date)); 
									if($anal_iter < (count($prod['analysis'])-1)){$anal_iter++;}
								}
							?></td>
						<?php }?>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>