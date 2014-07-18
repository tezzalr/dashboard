<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2>Anchor Client Bank Mandiri</h2>
		<span style="font-size:20px"><?php echo count($anchor['cor'])+count($anchor['ib'])+count($anchor['com']);?> Anchor <div style="clear:both"></span></div>
	</div>
	<!--<div id="container_all" style="min-width: 310px; width: 100%; height: 500px; margin: 0;"></div><br><br>-->
	<div>
		<div style="width: 33%; height: 100%; float:left; margin-right:20px; padding-right:5px;"><h4><a href="<?php echo base_url()?>directorate/realisasi/CB">Corporate Banking</a></h4><?php echo count($anchor['cor']);?> Anchor Di Corporate Banking<br><br>
			<div style="font-size:11px;">
			<?php $grup=''; foreach ($anchor['cor'] as $anchr) {?>
				<?php if($grup!=$anchr->group){?>
				<h5 style="color:orange"><?php echo $anchr->group; $grup = $anchr->group; }?></h5>
				
				<a href="<?php echo base_url()?>anchor/realisasi/<?php echo $anchr->id?>"><span><?php echo $anchr->name?></span><br></a>
			<?php }?>
			</div>
		</div>
		<div style="width: 30%; margin-right:5px; float:left;"><h4><a href="<?php echo base_url()?>directorate/realisasi/CB">Institutional Banking</a></h4><?php echo count($anchor['ib']);?> Anchor Di Institutional Banking<br><br>
			<div style="font-size:11px;">
			<?php $grup=''; foreach ($anchor['ib'] as $anchr) {?>
				<?php if($grup!=$anchr->group){?>
				<h5 style="color:orange"><?php echo $anchr->group; $grup = $anchr->group; }?></h5>
				
				<a href ="<?php echo base_url()?>anchor/realisasi/<?php echo $anchr->id?>"><span><?php echo $anchr->name?></span><br></a>
			<?php }?>
			</div>
		</div>
		<div style="width: 33%; float:left; padding-left:10px;"><h4><a href="<?php echo base_url()?>directorate/realisasi/CB">Commercial and Business Banking</a></h4><?php echo count($anchor['com']);?> Anchor Di Commercial and Business Banking<br><br>
			<div style="font-size:11px;">
			<?php $grup=''; foreach ($anchor['com'] as $anchr) {?>
				<?php if($grup!=$anchr->group){?>
				<h5 style="color:orange"><?php echo $anchr->group; $grup = $anchr->group; }?></h5>
				
				<a href ="<?php echo base_url()?>anchor/realisasi/<?php echo $anchr->id?>"><span><?php echo $anchr->name?></span><br></a>
			<?php }?>
			</div>
		</div>
		<div style="clear:both"></div>
	</div><br><br>
</div>
