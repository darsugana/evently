<?php
class SearchController extends AppController
{
	protected function beforeAction()
	{
		// $this->handleMissingCity();
		parent::beforeAction();
	}
	
	public function actionIndex()
	{
		if (isset($this->get['q']))
		{
			$shouldShowPastEvents = isset($this->get['p']) ? (bool)$this->get['p'] : false;
			$this->setVar('shouldShowPastEvents', $shouldShowPastEvents);
			$events = new Event_Collection();
			$events->loadBySearchString(trim($this->get['q']), $shouldShowPastEvents);
			$eventsByDate = $events->getEventsChunkedByDate();


			
			$this->setLayoutVar('query', trim($this->get['q']));
			$this->setVar('query', trim($this->get['q']));
			$this->setLastSearchQuery(trim($this->get['q']));
		}
		else
		{
			$eventsByDate = array();

		}

		$this->setVar('eventsByDate', $eventsByDate);
		$this->setVar('numEvents', count($events));
	}
	
}
