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
			$shouldShowPastEvents = isset($this->get['p']) ? (bool)$this->get['p'] : false;
			$this->setVar('shouldShowPastEvents', $shouldShowPastEvents);
			$this->setLayoutVar('shouldShowPastEvents', $shouldShowPastEvents);
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
		
		$events->loadByTag($tagName);
		$eventsByDate = $events->getEventsChunkedByDate();
		
		$this->setVar('eventsByDate', $eventsByDate);
		$this->setVar('numEvents', count($events));
		
		
	}
	
}
