<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>

<script>
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}
});
</script>

<div id="" class="container no_pad">
	<div class="col-xs-12 col-md-5 login-form" style="margin 0 auto">
		<form class="form-signin" action="<?php echo base_url();?>user/userEnter" method="post" role="form">
			<h3 class="form-signin-heading">Mandiri Corplan 2020</h3>
			<p class="desc_login_form">Please login here: </p>
			<input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
			<input type="password" class="form-control" placeholder="Password" name="password" required>
			<button class="btn btn-lg btn-info btn-block" type="submit">Log In</button>
		</form>
		<?php if($params){?>
		<div class="login_alert" style="margin-top:20px;">
			<div id="login_failed" class="alert alert-danger fade in">  
				<a class="close" data-dismiss="alert">×</a>  
				<strong>Login Failed ! </strong> Username and password do not match
			</div>
		</div>
		<?php }?>
	</div>
</div>