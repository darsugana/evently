<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>event search</title>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen" charset="utf-8">
	<script type="text/javascript" src="/js/jquery-1.2.6.min.js" charset="utf-8"></script>
</head>

<body class="<?php echo $controllerName ?>_controller <?php echo $controllerName ?>-<?php echo $actionName ?>">
<div class="outer_container">
	<h1>Event Search</h1>
	<form action="/search/" method="get">
		<input name="q" type="text" />
		<input type="submit" value="search" />
	</form>
</div>
</body>
</html>