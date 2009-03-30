<h2>
	<a href="/"><img src="/images/logo_small.gif" /></a>
</h2>

<form class="search" action="/search/" method="get">
	<fieldset>
		<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>" />
	</fieldset>
	<fieldset>
		<span class="examples">found <?php echo $numEvents ?> events!</span>
		<input class="submit" type="submit" value="Find Events" />
	</fieldset>
</form>

<?php
if (count($eventsByDate))
{
	?>
	
	<table class="results">
		<?php
		foreach ($eventsByDate as $date => $events)
		{
			?>
			
			<tr>
				<td class="dates">
					<?php
					$displayDate = date('F j', strtotime($date));
					if (date('Y-m-d') == $date) {
						$displayDate = 'Today';
					} else if (date('Y-m-d', strtotime('tomorrow')) == $date) {
						$displayDate = 'Tomorrow';
					}
					?>
					<?php echo htmlentities($displayDate) ?>
				</td>
				<td class="events">
					<ul>
						<?php
						foreach ($events as $event)
						{
							?>
							
							<li class="event">
								<h3 class="title">
									<span class="time"><?php echo htmlentities(date('g:ia', strtotime($event->getDate()))) ?></span>
									<a href="<?php echo $event->getLink() ?>"><?php echo htmlentities(Ev_String::wordTrim($event->getName(), 75), ENT_COMPAT, 'UTF-8', false) ?></a>
								</h3>
								<h4 class="link"><a href="<?php echo $event->getLink() ?>"><?php echo htmlentities($event->getLink()) ?></a></h4>
								<p class="description">
									<?php echo htmlentities(Ev_String::wordTrim($event->getDescription())) ?>
								</p>
							</li>
							
							<?php
						}
						?>
					</ul>
				</td>
			</tr>
			
			<?php
		}
		?>
	</table>
	
	<?php
}
?>