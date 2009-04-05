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
		}
		else
		{
			$eventsByDate = array();
		}
		$this->setLayoutVar('query', trim($this->get['q']));
		$this->setVar('eventsByDate', $eventsByDate);
		$this->setVar('numEvents', count($events));
	}
	
	public function actionPull()
	{
		$this->setLayout('blank');
		
		// Parse it
		$feed = new SimplePie();
		$feed->set_feed_url('http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1');
		$feed->enable_cache(false);
		$feed->init();
		
		$items = $feed->get_items();
		
		foreach ($items as $item)
		{
			var_dump($item->get_title());
		}
		
		var_dump($feed->get_item_quantity());
	}
}
