<div class="errors">
	<?php
	foreach ($errors as $error)
	{
		echo '<p>' . htmlentities($error) . '</p>';
	}
	?>
</div>
<form method="post" action="<?php echo Ev_Link::getLinkPath('/account/') ?>">
	<table class="login">
		<tr>
			<th>
				Email
			</th>
			<td>
				<?php echo htmlentities($user->getEmail()) ?>
			</td>
		</tr>
		<tr>
			<th>
				Old Password
			</th>
			<td>
				<input type="password" name="login[old_password]" />
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
