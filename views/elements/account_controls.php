<?php
if (is_object($user))
{
	?>
	<span class="logged_in_user">
		Logged In as <?php echo htmlentities($user->getEmail()) ?> <a href="/login/logout" class="logout">(Logout)</a>
	</span>
	<?php
}
else
{
	?>
	<a href="/login" class="button orange large signup">Signup/Login</a>
	<?php
}

?>