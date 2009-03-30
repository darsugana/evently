<h2>
	<a href="/"><img src="/images/logo_small.gif" /></a>
</h2>

<form class="search" action="/search/" method="get">
	<fieldset>
		<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>" />
	</fieldset>
	<fieldset>
		<span class="examples">found <?php echo count($events) ?> events!</span>
		<input class="submit" type="submit" value="Find Events" />
	</fieldset>
</form>

<div class="results">
	<?php
	if (count($events))
	{
		?>
		<ul>
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
	?>
</div>
