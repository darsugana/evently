<?php
class SearchController extends AppController
{
	protected function beforeAction()
	{
		parent::beforeAction();
	}
	
	public function actionIndex()
	{
		if (isset($this->get['q']))
		{
			$query = isset($this->get['q']) ? trim($this->get['q']) : null;
			$shouldShowPastEvents = isset($this->get['p']) ? (bool)$this->get['p'] : false;
			
			$this->setVar('shouldShowPastEvents', $shouldShowPastEvents);
			$this->setLayoutVar('shouldShowPastEvents', $shouldShowPastEvents);
			$events = new Event_Collection();
			
			$criteria = array(
				'q' => $query,
				'city_id' => City::getInstance()->getCityId(),
				'show_past_events' => $shouldShowPastEvents,
			);
			
			$events->loadByCriteria($criteria);
			
			if ($this->hasLoggedInUser())
			{
				$user = $this->getLoggedInUser();
				$events->loadRsvps($user->getUserId());
				$events->loadVotes($user->getUserId());
			}
			$eventsByDate = $events->getEventsChunkedByDate();
			
			$this->setLayoutVar('query', trim($this->get['q']));
			$this->setVar('query', trim($this->get['q']));
			$this->setLastSearchQuery(trim($this->get['q']));
		}
		else
		{
			$eventsByDate = array();
		}
		
		
		$user = $this->getLoggedInUser();
		$recommendations = new Event_Collection();
		if (is_object($user))
		{
			$recommender = new Ev_Recommendation();
			$idArray = $recommender->getRecommendedEvents($user->getUserId());
			$recommendations->loadByArray($idArray, $shouldShowPastEvents);
		}

		$this->setVar('recommendations', $recommendations->getEventsChunkedByDate());
		$this->setVar('eventsByDate', $eventsByDate);
		$this->setVar('numEvents', count($events));
	}
	
	public function actionByTag($tagName = null)
	{
		if (is_null($tagName))
		{
			$this->redirect(Ev_Link::getLinkPath('/'));
			exit;
		}
		
		$events = new Event_Collection();
		$shouldShowPastEvents = isset($this->get['p']) ? (bool)$this->get['p'] : false;
		$this->setVar('shouldShowPastEvents', $shouldShowPastEvents);
		$this->setLayoutVar('shouldShowPastEvents', $shouldShowPastEvents);
		
		$criteria = array(
			'city_id' => City::getInstance()->getCityId(),
			'tag' => $tagName,
		);
		
		$events->loadByCriteria($criteria);
		if ($this->hasLoggedInUser())
		{
			$user = $this->getLoggedInUser();
			$events->loadRsvps($user->getUserId());
		}
		$eventsByDate = $events->getEventsChunkedByDate();
		
		$this->setVar('eventsByDate', $eventsByDate);
		$this->setVar('numEvents', count($events));
		
		
	}
	
}
