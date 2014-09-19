<?php ?>

<div id="" class="container no_pad">
	<div style="margin-bottom:20px">
		<?php if($activity){?><h2>Edit Activity</h2><?php }else{?><h2>New Product Analysis</h2><?php }?><hr>
		<form class="form-horizontal" method="post" id="form_src_rm" action="<?php if($activity){echo base_url()."update/submit_product_analysis/".$activity->mading_id;}else{echo base_url()."update/submit_product_analysis/";}?>">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Partner</label>
				<div class="col-sm-4">
				<select id="groupdir" class="form-control" style="width:320px" name="cmt">
					<option value='Pranowo Dewantoro' <?php if($activity && $activity->cmt == "Pranowo Dewantoro"){echo "selected";}?>>Pranowo Dewantoro</option>
					<option value='Claudio Suhalim' <?php if($activity && $activity->cmt == "Claudio Suhalim"){echo "selected";}?>>Claudio Suhalim</option>
					<option value='Ferry Adrian' <?php if($activity && $activity->cmt == "Ferry Adrian"){echo "selected";}?>>Ferry Adrian</option>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Product</label>
				<div class="col-sm-4">
					<select id="groupdir" class="form-control" style="width:320px" name="product">
						<?php $prods = get_product_anal_prod(); foreach($prods as $prod){?>
							<option value="<?php echo $prod['ins']?>" <?php if($activity){echo "selected";}?>><?php echo $prod['name']?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Report Month</label>
				<div class="col-sm-4">
					<select id="groupdir" class="form-control" style="width:320px" name="report_month">
						<?php for($i=1;$i<=12;$i++){?>
							<option value="<?php echo $i?>" <?php if(date('m') == $i){echo "selected";}?>><?php echo get_month_full_name($i)?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Report Year</label>
				<div class="col-sm-4">
					<select id="groupdir" class="form-control" style="width:320px" name="report_year">
						<?php for($i=2012;$i<=date('Y');$i++){?>
							<option value="<?php echo $i?>" <?php if(date('Y') == $i){echo "selected";}?>><?php echo $i?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Analysis</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="analysis"><?php if($activity){echo $activity->activity;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Issue</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="issue"><?php if($activity){echo $activity->issue;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Upload File</label>
				<div class="col-sm-4">
					<input type="file" class="form-control">
				</div>
			</div><hr>
			<button type="submit" class="btn btn-info" style="width:200px">Submit</button>
		</form>
	</div>
</div>

<script>
	//CKEDITOR.config.width='100%';
    CKEDITOR.config.height='180px';
    
    CKEDITOR.replace('analysis'); CKEDITOR.replace('issue');
    
    function change_anchor_by_group(){
    	var group = $("#groupdir").val();
    	$.ajax({
			type: "GET",
			url: config.base+"update/change_group_member",
			data: {group: group},
			dataType: 'json',
			cache: false,
			success: function(resp){
				if(resp.status==1){
					$("#member_group").html(resp.html);
				}else{}
			}
		});
    }
</script>