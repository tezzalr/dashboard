<select class="form-control" style="width:320px" name="anchor">
	<?php foreach($members as $anc){?>
	<option value="<?php echo $anc->id?>"><?php echo $anc->name?></option>
	<?php }?>
</select>