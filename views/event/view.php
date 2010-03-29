<?php
// var_dump($event);
?>

<h1><?php echo htmlentities($event->getName()) ?></h1>
<h4><?php echo $event->getLink() ?></h4>
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
