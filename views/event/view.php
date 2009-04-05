<?php
// var_dump($event);
?>

<h1><?php echo htmlentities($event->getName()) ?></h1>
<h4><?php echo $event->getLink() ?></h4>
<p>
	<?php echo $event->getDescription() ?>
</p>