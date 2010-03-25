<?php
if (is_object($user))
{
	?>
	<span class="logged_in_user">
		<a href="/account">Logged In as <?php echo htmlentities($user->getEmail()) ?></a> <a href="/account/logout" class="logout">(Logout)</a>
	</span>
	<?php
}
else
{
	?>
	<a href="/account/login" class="button orange large signup">Signup/Login</a>
	<?php
}

?>