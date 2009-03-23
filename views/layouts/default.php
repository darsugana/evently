<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $pageTitle ?></title>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" charset="utf-8">
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-8038879-1");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	<script type="text/javascript" src="/js/jquery-1.2.6.min.js" charset="utf-8"></script>
</head>

<body class="<?php echo $controllerName ?>_controller <?php echo $controllerName ?>-<?php echo $actionName ?>">
<div class="outer_container">
	<?php echo $layoutContent ?>
</div>
</body>
</html>