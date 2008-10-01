#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__) . '/application.php'));

$rawRss = new RawRss();
$rawRss->setRawRssData(file_get_contents('http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1'));
$rawRss->setSourceId(1);
$rawRss->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
$rawRss->save();
?>