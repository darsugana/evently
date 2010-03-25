<h2>Create Account</h2>
<div class="errors">
	<?php
	foreach ($errors as $error)
	{
		echo '<p>' . htmlentities($error) . '</p>';
	}
	?>
</div>
<form method="post" action="<?php echo Ev_Link::getLinkPath('/account/create') ?>">
	<table class="account">
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
				New Password
			</th>
			<td>
				<input type="password" name="login[password]" />
			</td>
		</tr>
		<tr>
			<th>
				Confirm New Password
			</th>
			<td>
				<input type="password" name="login[password_confirm]" />
			</td>
		</tr>
		
	</table>
	<input type="submit" name="login[submit]" value="Login" />
</form>
