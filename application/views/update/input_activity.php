<div id="" class="container no_pad">
	<div style="margin-bottom:20px">
		<?php if($activity){?><h2>Edit Activity</h2><?php }else{?><h2>New Activity</h2><?php }?><hr>
		<form class="form-horizontal" method="post" id="form_src_rm" action="<?php if($activity){echo base_url()."update/submit_activity/".$activity->mading_id;}else{echo base_url()."update/submit_activity/";}?>">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Group</label>
				<div class="col-sm-4">
					<select id="groupdir" class="form-control" style="width:320px" onchange="change_anchor_by_group();">
						<?php foreach($grups as $grup){?>
						<?php if($grup=="CORPORATE BANKING I"){?><option value='CORPORATE BANKING I' <?php if($activity && $activity->group == "CORPORATE BANKING I"){echo "selected";}?>>CB 1</option><?php }?>
						<?php if($grup=="CORPORATE BANKING II"){?><option value='CORPORATE BANKING II' <?php if($activity && $activity->group == "CORPORATE BANKING II"){echo "selected";}?>>CB 2</option><?php }?>
						<?php if($grup=="CORPORATE BANKING III"){?><option value='CORPORATE BANKING III' <?php if($activity && $activity->group == "CORPORATE BANKING III"){echo "selected";}?>>CB 3</option><?php }?>
						<?php if($grup=="CORPORATE BANKING AGRO BASED"){?><option value='CORPORATE BANKING AGRO BASED' <?php if($activity && $activity->group == "CORPORATE BANKING AGRO BASED"){echo "selected";}?>>AGB</option><?php }?>
						<?php if($grup=="SYNDICATION, OIL & GAS"){?><option value='SYNDICATION, OIL & GAS' <?php if($activity && $activity->group == "SYNDICATION, OIL & GAS"){echo "selected";}?>>SOG</option><?php }?>
						<?php if($grup=="INSTITUTIONAL BANKING I"){?><option value='INSTITUTIONAL BANKING I' <?php if($activity && $activity->group == "INSTITUTIONAL BANKING I"){echo "selected";}?>>IB 1</option><?php }?>
						<?php if($grup=="INSTITUTIONAL BANKING II"){?><option value='INSTITUTIONAL BANKING II' <?php if($activity && $activity->group == "INSTITUTIONAL BANKING II"){echo "selected";}?>>IB 2</option><?php }?>
						<?php if($grup=="JAKARTA COMMERCIAL SALES"){?><option value='JAKARTA COMMERCIAL SALES' <?php if($activity && $activity->group == "JAKARTA COMMERCIAL SALES"){echo "selected";}?>>JCS</option><?php }?>
						<?php if($grup=="REGIONAL COMMERCIAL SALES I"){?><option value='REGIONAL COMMERCIAL SALES I' <?php if($activity && $activity->group == "REGIONAL COMMERCIAL SALES I"){echo "selected";}?>>RCS 1</option><?php }?>
						<?php if($grup=="REGIONAL COMMERCIAL SALES II"){?><option value='REGIONAL COMMERCIAL SALES II' <?php if($activity && $activity->group == "REGIONAL COMMERCIAL SALES II"){echo "selected";}?>>RCS 2</option><?php }?>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="">Anchor</label>
				<div id="member_group" class="col-sm-4">
				<select class="form-control" style="width:320px" name="anchor">
					<?php foreach($anchor as $anc){?>
					<option value="<?php echo $anc->id?>" <?php if($activity && $activity->name == $anc->name){echo "selected";}?>><?php echo $anc->name?></option>
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
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Activity Title</label>
				<div class="col-sm-4">
					<input style="width:420px" type="text" class="form-control" name="title" value="<?php if($activity){echo $activity->title;}?>" placeholder="Title">
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Activity Description</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="activity"><?php if($activity){echo $activity->activity;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Progress</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="progress"><?php if($activity){echo $activity->progress;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Next Step</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="nextstep"><?php if($activity){echo $activity->nextstep;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Issue</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="issue"><?php if($activity){echo $activity->issue;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Support Needed</label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="support"><?php if($activity){echo $activity->support;}?></textarea>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="" class="col-sm-2 control-label">Deadline</label>
				<div class="col-sm-4">
					<?php if($activity){$deadline = date("m/d/Y", strtotime($activity->deadline));}?>
					<input style="width:420px" type="date" class="form-control" id="deadline" name="deadline" value="<?php if($activity){echo $deadline;}?>" placeholder="mm/dd/YYYY">
					<small style="color:grey">*format: mm/dd/YYYY</small>
				</div>
			</div><hr>
			<button type="submit" class="btn btn-info" style="width:200px">Submit</button>
		</form>
	</div>
</div>

<script>
	//CKEDITOR.config.width='100%';
    CKEDITOR.config.height='180px';
    
    CKEDITOR.replace('activity'); CKEDITOR.replace('progress'); 
    CKEDITOR.replace('nextstep'); CKEDITOR.replace('issue');
    CKEDITOR.replace('support');
    
    $('#deadline').datepicker({
		autoclose: true,
		todayHighlight: true
	});
    
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