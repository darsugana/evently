
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
				<a href="<?php echo $event->getLink()?>"><?php echo htmlentities($event->getName()) ?></a> (<?php echo htmlentities($event->getDate()) ?>)
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