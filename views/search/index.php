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
									<a href="<?php echo Ev_Link::getLinkPath('/event/' . (int) $event->getEventId()) ?>"><?php echo htmlentities(Ev_String::wordTrim($event->getName(), 75), ENT_COMPAT, 'UTF-8', false) ?></a>
								</h3>
								<p class="description">
									<?php echo htmlentities(Ev_String::wordTrim(html_entity_decode(strip_tags($event->getDescription()), ENT_QUOTES))) ?>
								</p>
								<h4 class="link"><a class="external" href="<?php echo $event->getLink() ?>"><?php echo htmlentities($event->getLink()) ?></a></h4>
								<p class="controls">
									<a class="like" href="<?php echo Ev_Link::getLinkPath('/event/like/' . (int)$event->getEventId()) ?>">I like this</a>
									<a class="attend" href="<?php echo Ev_Link::getLinkPath('/event/attend/' . (int)$event->getEventId()) ?>">I'm going!</a>
									<a class="comment" href="#" onclick="$('comment')">Comment</a>
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