<h1><span>Evently</span></h1>

<form class="search" action="/<?php echo urlencode($city->getShortName()) ?>/search/" method="get">
	<fieldset>
		<input class="q" name="q" type="text" value="<?php echo htmlentities($query) ?>"/>
	</fieldset>
	<fieldset>
		<input class="submit" type="submit" value="Find Events" />
		<span class="examples">
			Not in <?php echo htmlentities($city->getLongName()) ?>?
			<a href="/sfc/">San Francisco</a>,
			<a href="/nyc/">New York</a>,
			<a href="/atx">Austin</a>
		</span>
	</fieldset>
</form>