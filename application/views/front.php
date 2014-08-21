<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title><?php echo ucwords($title)."";?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/shared.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet"/>
        
        <script>
			var config = {
				 base: "<?php echo base_url(); ?>"
			 };
		 </script>
    
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.formatCurrency-1.4.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/application.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tokeninput.js"></script>
        
        <!-- Highchart -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/highchart/highcharts.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/highchart/modules/exporting.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/grafik.js"></script>
        
        <link href="<?php echo base_url();?>assets/css/shared.css" rel="stylesheet"/>
    </head>
    
    <body>
    	
    	<?php echo $header; ?>
        <?php echo $content; ?>
        <?php echo $footer; ?>
            
    </body>
</html>