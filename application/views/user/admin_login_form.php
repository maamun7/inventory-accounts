<link href="<?php echo base_url(); ?>assets/css/signin.css" media="screen" rel="stylesheet" type="text/css" />
<div class="account-container">
	<div class="content clearfix">		
		<form action="<?php echo base_url(); ?>admin_dashboard/do_login" method="post" id="login">		
			<h1>Member Login</h1>			
			<div class="login-fields">				
				<p>Please provide your details</p>				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" name="username" id="username"  placeholder="Your Email" class="login username-field">
				</div> <!-- /field -->				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password"  placeholder="Your Password" class="login password-field">
				</div> <!-- /password -->				
			</div> <!-- /login-fields -->			
			<div class="login-actions">				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>									
				<button class="button btn btn-primary btn-large">Sign In</button>				
			</div> <!-- .actions -->		
		</form>		
	</div> <!-- /content -->	
</div> <!-- /account-container -->