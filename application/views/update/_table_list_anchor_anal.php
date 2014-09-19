<?php foreach($anal_anchor as $anal){?>
	<?php //if($anal['act']){?>
	<tr>
		<td><a href="<?php base_url()?>activity_wall/<?php echo $anal['anchor']->id?>"><?php echo $anal['anchor']->name?></a></td>
		<td><?php if($anal['act'] && $anal['act']->date){echo date("d M y, H:i", strtotime($anal['act']->date));}?></td>
		<td><?php if($anal['act']){echo $anal['act']->title;}?></td>
		<td><?php if($anal['act']){echo $anal['act']->progress;}?></td>
		<td><?php if($anal['act']){echo $anal['act']->nextstep;}?></td>
		<td><?php if($anal['act']){echo $anal['act']->issue;}?></td>
		<td><?php if($anal['act'] && $anal['act']->date){echo date("d M y", strtotime($anal['act']->deadline));}?></td>
	</tr>
	<?php //}?>
<?php }?>
