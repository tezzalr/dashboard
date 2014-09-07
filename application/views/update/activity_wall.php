<div id="" class="container no_pad">
	<?php echo $header?>
	<div style="margin-top:-65px; margin-bottom:30px;">
		<a href="<?php echo base_url()?>update/input_activity" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Activity</a>
	</div>
	<div>
		<?php foreach ($acts as $act){?>
			<div id="actdiv_<?php echo $act->mading_id?>">
				<div style="font-size:11px; float:left;">
					<?php echo $act->cmt;?>
					<span style="color:gray; margin-left:10px">
						<?php echo date("d M y, H:i", strtotime($act->date));?>
					</span>
					
				</div>
				<div style="float:right;">
					<a href="<?php echo base_url()?>update/edit_activity/<?php echo $act->mading_id?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
					<button class="btn btn-danger btn-xs" onclick="delete_activity(<?php echo $act->mading_id?>)"><span class="glyphicon glyphicon-trash"></span></button>
				</div><div style="clear:both;"></div>
				<h5 style="font-size:19px"><?php echo $act->name?></h5>
				<div style="margin-top:10px">
					<div style="float:left; width:60%; padding-right:10px">
						<span class="sub_judul">Activity</span>
						<?php echo $act->activity?>
					</div><vr>
					<div style="float:left; width:40%;">
						<div>
							<span class="sub_judul">Issue</span>
							<?php echo $act->issue?>
						</div><hr style="border-top: dashed 1px gray;">
						<div>
							<span class="sub_judul">Support</span>
							<?php echo $act->support?>
						</div>
					</div><div style="clear:both"></div>
				</div>
				<hr>
			</div>
		<?php  }?>
	</div>
</div>

<style>
	.sub_judul{
		color:gray;
		font-size:12px;
	}
</style>
<script>
	function delete_activity(id, event){
		bootbox.confirm("Apa anda yakin?", function(confirmed) {
			if(confirmed===true){
				$.ajax({
					url: config.base+"update/delete_activity",
					data: {id: id},
					dataType: 'json',
					type: "POST",
					success: function (resp) {
						if(resp.status == 1){
							$('#actdiv_'+id).animate({'opacity':'toggle'});
							succeedMessage('Aktivitas berhasil dihapus');
						}
					}
				});
			}
		});
	}
</script>