#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');


// 2010-03-23 RHP FIXME: Probably should keep this info uptodate via triggers?

$db = Event::getDb();
$db->selectDb('evently');

$sql = '
	UPDATE
		event
		INNER JOIN (
				SELECT 
					event_id, 
					SUM(value) AS total
				FROM
					event_vote
				WHERE
					is_deleted = 0
				GROUP BY
					event_id
					) AS event_sum ON event.event_id = event_sum.event_id
	SET
		event.vote_total = event_sum.total
	
	WHERE
		event.is_deleted = 0
';

$db->query($sql);