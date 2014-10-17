<link href="<?php echo base_url();?>assets/css/user.css" rel="stylesheet"/>

<script>
$(document).ready(function(){
	if($('#type_login').val()=='failed'){
		$('#login_failed').removeClass('hide');
	}
	if($('#type_login').val()=='not_login'){
		$('#not_login').removeClass('hide');
	}
        
    $("#formsignup").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				required: true,
				minlength: 5
			},
			verify_password: {
				required: true,
				equalTo: "#password"
			},
			name: "required",
		},
		messages: {
			username: {
				required: "Please enter an username"
			},
			password_su: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			verify_password: {
				required: "Please provide a password",
				equalTo: "Please enter the same password as above"
			},
			agree: "Please accept our policy"
		}
	});     
});
</script>

<div id="" class="container no_pad">
	<div class="col-md-7">
		<div class="form-signin">
		<h3 class="form-signin-heading">New User</h3>
		<p class="desc_login_form">Enter new user</p>
		<form class="form-horizontal" action="<?php echo base_url();?>user/register" method ="post" id="formsignup" role="form">
			 <div class="form-group">
				<label class="col-sm-3 control-label">Name</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			</div>
			 <div class="form-group">
				<label class="col-sm-3 control-label">Username</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="username" id="username" placeholder="Username">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Confirm Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Confirm Password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Anchor</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="anchor" id="anchor" placeholder="Anchor">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Product</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="product" id="product" placeholder="Product">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Role</label>
				<div class="col-sm-9">
					<select id="" class="form-control" name="role">
						<option value='admin' >Admin</option>
						<option value='cmt' >CMT</option>
						<option value='rm' >RM</option>
					</select>
				</div>
			</div>
			<hr>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
		</form>
	</div>
</div>
</div>