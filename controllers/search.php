<?php
class SearchController extends AppController
{
	public function actionIndex()
	{
		if (isset($this->get['q']))
		{
			$events = new Event_Collection();
			$events->loadBySearchString(trim($this->get['q']));
		}
		else
		{
			$events = new Event_Collection();
		}
		$this->setVar('query', trim($this->get['q']));
		$this->setVar('events', $events);
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
?>
