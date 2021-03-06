<?php
include APP_PATH . 'views/elements/header.php';
?>

<h2>
	<p class="account_controls">
		<?php
			$this->renderElement('account_controls', array('user'=> $user));
		?>
	</p>
	<a href="<?php echo Ev_Link::getLinkPath('') ?>"><img src="/images/logo_small.gif" /></a>
	<form class="search" action="<?php echo Ev_Link::getLinkPath('/search/') ?>" method="get">
		<fieldset>
			<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>" />
			<input type="checkbox" name="p" id="p" value="1" <?php echo $shouldShowPastEvents ? 'checked="checked"' : '' ?> /> <label for="p">Show past events?</label>
			<input class="submit" type="submit" value="Find Events" />
		</fieldset>
	</form>
</h2>

<div class="outer_container">
	<?php echo $layoutContent ?>
</div>

<?php
include APP_PATH . 'views/elements/footer.php';
?>