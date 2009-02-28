<h2>
	<span class="logo">evently</span>
	<form class="search" action="/search/" method="get">
		<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>" />
		<input class="submit" type="submit" value="search" />
	</form>
</h2>

<?php
if (count($events))
{
	?>
	<ul>
		<h5>We found <?php echo count($events) ?> results for <?php echo htmlentities($query) ?></h5>
		<?php
		foreach ($events as $event)
		{
			?>
			<li>
				<!--<span class="when"><?php echo htmlentities(date('F j, Y, g:i a', strtotime($event->getDate()))) ?></span>-->
				<a href="<?php echo $event->getLink()?>"><?php echo htmlentities($event->getName(), ENT_COMPAT, 'UTF-8', false) ?></a> (<?php echo htmlentities($event->getDate()) ?>)
			</li>
			<?php
		}
		?>
	</ul>
	<?php
}
else
{
	?>
	Your search returned no results, please change your search terms and try again to find more exciting events.
	<?php
}


?>
