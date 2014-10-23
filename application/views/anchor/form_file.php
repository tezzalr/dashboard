<div id="" class="container no_pad">
	<div class="no_pad" style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
		<h2>Input File</h2>
	</div>
	<div style="margin-bottom:40px">
		<form class="form-inline" action="<?php echo base_url();?>anchor/submit_file_input" method ="post" role="form">			
			<h4>Form Input</h4>
			<div class="form-group">			
				<select class="form-control" name="filetype">
					<option value="wallet_size">Wallet Size</option>
					<option value="target">Target</option>
					<option value="realization">Realisasi</option>
					<option value="detail">Detail</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="month" placeholder="Month">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="year" placeholder="Year">
			</div>
			<div class="form-group">
				<input type="submit" class="form-control btn-success">
			</div>
		</form>
	</div>
</div>