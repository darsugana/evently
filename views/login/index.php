
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<fb:login-button></fb:login-button>
<script type="text/javascript">
    FB.init("94398318771b47012a5c0eb7136d59d5", "/facebook/xd_receiver");
</script>
<h3> -- OR -- </h3>
<div class="errors">
	<?php
	foreach ($errors as $error)
	{
		echo '<p>' . htmlentities($error) . '</p>';
	}
	?>
</div>
<form method="post" action="<?php echo Ev_Link::getLinkPath('/login/') ?>">
	<table class="login">
		<tr>
			<th>
				Email
			</th>
			<td>
				<input type="text" name="login[email]" />
			</td>
		</tr>
		<tr>
			<th>
				Password
			</th>
			<td>
				<input type="password" name="login[password]" />
			</td>
		</tr>
	</table>
	<input type="submit" name="login[submit]" value="Login" />
</form>
<div class="login_opts">
	<a href="#">Forgot Password?</a> -- <a href="#">New User</a>
</div>