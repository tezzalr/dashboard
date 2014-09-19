<?php 
	$m_now = date('m');
	if($m_now < 7){$iter = 1;}
	else{$iter = 7;}
?>
<div id="" class="container no_pad">
	<?php echo $header?>
	<!--<div style="margin-top:-65px; margin-bottom:30px;">
		<a href="<?php echo base_url()?>update/input_product_analysis" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Analysis</a>
	</div>-->
	<div style="margin-bottom:20px">
		<h3>List of Anchor Analysis</h3>
		<select id="groupdir" class="form-control" style="width:320px" onchange="change_anchor_by_group();">
			<option value='CB1' >CB 1</option>
			<option value='CB2' >CB 2</option>
			<option value='CB3' >CB 3</option>
			<option value='AGB' >AGB</option>
			<option value='SOG' >SOG</option>
			<option value='IB1' >IB 1</option>
			<option value='IB2' >IB 2</option>
			<option value='JCS' >JCS</option>
			<option value='RCS1' >RCS 1</option>
			<option value='RCS2' >RCS 2</option>
		</select><br>
		
		<table class="table table-bordered" style="font-size:13px">
			<thead>
				<tr class="headertab"><th>Anchor</th><th style="width:120px">Update</th><th>Aktivitas</th><th>Progress</th>
				<th>Next Step</th><th>Issue</th><th style="width:80px">Deadline</th>
				</tr>
			</thead>
			<tbody id="tableanal">
				<?php echo $tableanal;?>
			</tbody>
		</table>
	</div>
</div>

<script>
    function change_anchor_by_group(){
    	var group = $("#groupdir").val();
    	$.ajax({
			type: "GET",
			url: config.base+"update/change_anchor_anal",
			data: {group: group},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#tableanal").html(resp.html);
				}else{}
			}
		});
    }
</script>