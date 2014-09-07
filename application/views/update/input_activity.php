<div id="" class="container no_pad">
	<div style="margin-bottom:20px">
		<?php if($activity){?><h2>Edit Activity</h2><?php }else{?><h2>New Activity</h2><?php }?><hr>
		<form method="post" id="form_src_rm" action="<?php if($activity){echo base_url()."update/submit_activity/".$activity->mading_id;}else{echo base_url()."update/submit_activity/";}?>">
			<div class="form-group">
				<label for="">Group</label><br>
				<select id="groupdir" class="form-control" style="width:320px" onchange="change_anchor_by_group();">
					<option value='CORPORATE BANKING I' <?php if($activity && $activity->group == "CORPORATE BANKING I"){echo "selected";}?>>CB 1</option>
					<option value='CORPORATE BANKING II' <?php if($activity && $activity->group == "CORPORATE BANKING II"){echo "selected";}?>>CB 2</option>
					<option value='CORPORATE BANKING III' <?php if($activity && $activity->group == "CORPORATE BANKING III"){echo "selected";}?>>CB 3</option>
					<option value='CORPORATE BANKING AGRO BASED' <?php if($activity && $activity->group == "CORPORATE BANKING AGRO BASED"){echo "selected";}?>>AGB</option>
					<option value='SYNDICATION, OIL & GAS' <?php if($activity && $activity->group == "SYNDICATION, OIL & GAS"){echo "selected";}?>>SOG</option>
					<option value='INSTITUTIONAL BANKING I' <?php if($activity && $activity->group == "INSTITUTIONAL BANKING I"){echo "selected";}?>>IB 1</option>
					<option value='INSTITUTIONAL BANKING II' <?php if($activity && $activity->group == "INSTITUTIONAL BANKING II"){echo "selected";}?>>IB 2</option>
					<option value='JAKARTA COMMERCIAL SALES' <?php if($activity && $activity->group == "JAKARTA COMMERCIAL SALES"){echo "selected";}?>>JCS</option>
					<option value='REGIONAL COMMERCIAL SALES I' <?php if($activity && $activity->group == "REGIONAL COMMERCIAL SALES I"){echo "selected";}?>>RCS 1</option>
					<option value='REGIONAL COMMERCIAL SALES II' <?php if($activity && $activity->group == "REGIONAL COMMERCIAL SALES II"){echo "selected";}?>>RCS 2</option>
				</select>
			</div>
			<div class="form-group">
				<label for="">Anchor</label><br>
				<div id="member_group">
				<select class="form-control" style="width:320px" name="anchor">
					<?php foreach($anchor as $anc){?>
					<option value="<?php echo $anc->id?>" <?php if($activity && $activity->name == $anc->name){echo "selected";}?>><?php echo $anc->name?></option>
					<?php }?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label for="">Partner</label><br>
				<div id="member_group">
				<select id="groupdir" class="form-control" style="width:320px" name="cmt">
					<option value='Pranowo Dewantoro' <?php if($activity && $activity->cmt == "Pranowo Dewantoro"){echo "selected";}?>>Pranowo Dewantoro</option>
					<option value='Claudio Suhalim' <?php if($activity && $activity->cmt == "Claudio Suhalim"){echo "selected";}?>>Claudio Suhalim</option>
					<option value='Ferry Adrian' <?php if($activity && $activity->cmt == "Ferry Adrian"){echo "selected";}?>>Ferry Adrian</option>
				</select>
				</div>
			</div><hr>
			<div class="form-group">
				<label for="">Activity</label>
				<textarea type="text" class="form-control" name="activity"><?php if($activity){echo $activity->activity;}?></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">Issue</label>
				<textarea type="text" class="form-control" name="issue"><?php if($activity){echo $activity->issue;}?></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">Support</label>
				<textarea type="text" class="form-control" name="support"><?php if($activity){echo $activity->support;}?></textarea>
			</div><hr>
			<button type="submit" class="btn btn-info" style="width:200px">Submit</button>
		</form>
	</div>
</div>

<script>
	CKEDITOR.config.width='64%';
    CKEDITOR.config.height='180px';
    
    CKEDITOR.replace('activity'); CKEDITOR.replace('issue');
    CKEDITOR.replace('support');
    
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