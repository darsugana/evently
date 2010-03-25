<h2>Lost Password:</h2>
<div class="errors">
	<?php
	foreach ($errors as $error)
	{
		echo '<p>' . htmlentities($error) . '</p>';
	}
	?>
</div>
<form method="post" action="<?php echo Ev_Link::getLinkPath('/account/lost_password') ?>">
	<table class="account">
		<tr>
			<th>
				Email
			</th>
			<td>
				<input type="text" name="login[email]" />
			</td>
		</tr>
	</table>
	<input type="submit" name="login[submit]" value="Login" />
</form>
