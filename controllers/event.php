<?php
class EventController extends AppController
{
	protected function actionView($eventId = null)
	{
		$eventId = (int)$eventId;
		$event = Event::constructByKey($eventId);
		if (is_object($event)) {
			$this->setVar('event', $event);
		} else {
			die('404');
		}
	}
}
