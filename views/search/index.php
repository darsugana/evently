<h2>
	<p class="account_controls">
		<a href="/login" class="signup">Signup/Login</a>
	</p>
	<a href="/"><img src="/images/logo_small.gif" /></a>
	<form class="search" action="/search/" method="get">
		<fieldset>
			<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>" />
			<input type="checkbox" name="p" id="p" value="1" <?php echo $shouldShowPastEvents ? 'checked="checked"' : '' ?> /> <label for="p">Show past events?</label>
			<input class="submit" type="submit" value="Find Events" />
		</fieldset>
	</form>
</h2>

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
									<a href="/event/<?php echo $event->getEventId() ?>"><?php echo htmlentities(Ev_String::wordTrim($event->getName(), 75), ENT_COMPAT, 'UTF-8', false) ?></a>
								</h3>
								<p class="description">
									<?php echo htmlentities(Ev_String::wordTrim(html_entity_decode(strip_tags($event->getDescription()), ENT_QUOTES, 'UTF-8'))) ?>
								</p>
								<h4 class="link"><a class="external" href="<?php echo $event->getLink() ?>"><?php echo htmlentities($event->getLink()) ?></a></h4>
								<p class="controls">
									<a class="like" href="/event/like/<?php echo (int)$event->getEventId() ?>">I like this (+1)</a>
									<a class="attend" href="/event/attend/<?php echo (int)$event->getEventId() ?>">I'm going! (+10)</a>
									<a class="comment" href="#" onclick="$('comment')">Comment (+3)</a>
									<script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=463070c7-d402-4580-b4f3-da21897e103b&amp;type=website&amp;embeds=true"></script>
									<a class="report" href="#">X</a>
									<div class="clear"></div>
								</p>
							</li>
							
							<?php
						}
						?>
					</ul>
				</td>
				<td class="sidebar">
					
				</td>
			</tr>
			
			<?php
		}
		?>
	</table>
	
	<?php
}
?>