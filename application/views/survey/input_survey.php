<div id="" class="container no_pad">
	<div>
		<h2>Input Survey</h2><hr>
		<form method="post" id="form_src_rm" action="<?php echo base_url()?>datarm/search_rm/">
			<div class="form-group">
				<label for="">1. Anchor Client</label>
				<select class="form-control" style="width:220px">
					<option>Corporate Banking</option>
					<option>Institutional Banking</option>
					<option>Commercial Banking</option>
				</select>
			</div><hr>
			<div class="form-group">
				<label for="">2. Aktifitas apa yang telah Saudara lakukan ke nasabah selaman bulan laporan, dan produk yang ditawarkan ?</label>
				<textarea type="text" class="form-control" name="univ" id="activity"></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">3. Apa hasil yang anda harapkan atau progress dari aktifitas pada pertanyaan no.2 ?</label>
				<textarea type="text" class="form-control" name="univ" id="result"></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">4. Apa issue yang Saudara hadapi dari aktifitas pada pertanyaan no.2 ?</label>
				<textarea type="text" class="form-control" name="univ" id="issue"></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">5. Apa support yang saudara harapkan untuk mengatasi issue yang dihadapi ?</label>
				<textarea type="text" class="form-control" name="univ" id="support"></textarea>
			</div><hr>
			<div class="form-group">
				<label for="">6. Apa Action Plan yang akan Saudara lakukan di bulan ini untuk meningkatkan bisnis dengan nasabah ?</label>
				<textarea type="text" class="form-control" name="univ" id="plan"></textarea>
			</div>
		</form>
	</div>
</div>

<script>
	CKEDITOR.config.width='100%';
    CKEDITOR.config.height='160px';
    
    CKEDITOR.replace('activity'); CKEDITOR.replace('result'); CKEDITOR.replace('issue');
    CKEDITOR.replace('support'); CKEDITOR.replace('plan');
</script>