<div id="" class="container no_pad">
	<?php echo $header?>
	<div>
		<div>
			<button type="button" class="btn btn-success btn-md" onclick="change_graph_view(<?php echo $anchor->id?>);">
				<span class="glyphicon glyphicon-signal"></span> Graph
			</button>
			<button type="button" class="btn btn-warning btn-md" onclick="change_table_view(<?php echo $anchor->id?>);">
				<span class="glyphicon glyphicon-list"></span> Table
			</button>
		</div>
		<div id="content_realisasi">
			<?php echo $graphview;?>
		</div>
		<div style="clear:both"></div><br>
	</div>
</div>