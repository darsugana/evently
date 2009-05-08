<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
	<title><?php echo $pageTitle ?></title>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" charset="utf-8">
	<?php
	include 'google_analytics.php';
	?>
	<script type="text/javascript" src="/js/jquery-1.3.2.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="/js/global.js" charset="utf-8"></script>
</head>

<body class="<?php echo $controllerName ?>_controller <?php echo $controllerName ?>-<?php echo $actionName ?> <?php echo $layoutName ?>_layout">