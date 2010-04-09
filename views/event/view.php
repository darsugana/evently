<?php
// var_dump($event);
?>

<h1><?php echo htmlentities($event->getName()) ?></h1>
<h3>
	<?php 
	$date = $event->getDate();
	$displayDate = date('F j', strtotime($date));
	if (date('Y-m-d') == $date) {
		$displayDate = 'Today';
	} else if (date('Y-m-d', strtotime('tomorrow')) == $date) {
		$displayDate = 'Tomorrow';
	}
	?>
	<?php echo htmlentities($displayDate) ?>, <?php echo htmlentities(date('g:ia', strtotime($event->getDate()))) ?>
</h3>
<h3>
	<?php
	if (is_object($event->getVenue_Object()))
	{
		$venue = $event->getVenue_Object();
		?>
		At <a href="#"><?php echo htmlentities($venue->getName()); ?></a>
		<?php
		if (false && $venue->getStreet1() !== null )
		{
			$venueAddress = $venue->getStreet1() . ' ' . $venue->getStreet2() . ' ' . $venue->getCity() . ', ' . $venue->getState() . ' ' . $venue->getZipCode() ; 
			?>
			<img src="http://maps.google.com/maps/api/staticmap?markers=color:blue|<?php echo urlencode($venueAddress) ?>&zoom=14&size=400x400&sensor=false"/>
			<?php
		}
	}
	?>
</h3>
<?php
foreach ($tags as $tag)
{
	?>
	<a href="<?php echo Ev_Link::getLinkPath('/search/by_tag/' . urlencode($tag->getName()) ) ?>"><?php echo htmlentities($tag->getName()) ?></a> 
	<?php
}
?>
<p>
	<?php echo $event->getDescription() ?>
</p>
<h4><a href="<?php echo $event->getLink() ?>">More Info</a></h4>
