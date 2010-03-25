<?php
class EventController extends AppController
{
	
	public function actionView($eventId = null)
	{
		$eventId = (int)$eventId;
		$event = Event::constructByKey($eventId);
		if (is_object($event)) {
			$user = $this->getLoggedInUser();
			if (is_object($user))
			{
				$recommender = new Ev_Recommendation();
				$recommender->visit($user->getUserId(), $event->getEventId());
			}
			
			$this->setVar('event', $event);
		} else {
			die('404');
		}
	}
	
	public function actionLike($eventId = null)
	{
		$eventId = (int)$eventId;
		$event = Event::constructByKey($eventId);
		if (is_object($event)) {
			$eventVote = new EventVote();
			$user = $this->getLoggedInUser();
			// FIXME 2010-03-23 RHP, require loggedin user
			if (is_object($user))
			{
				$eventVote->setUserId($user->getUserId());
				$recommender = new Ev_Recommendation();
				$recommender->like($user->getUserId(), $event->getEventId());
			}
			$eventVote->setEventId($event->getEventId());
			$eventVote->setValue(10);
			$eventVote->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
			$eventVote->save();
			$event->updateVoteTotal();
			$this->redirect('/' . City::getInstance()->getShortName() . '/search?q='. urlencode($this->getLastSearchQuery()));
			die;
		} else {
			die('404');
		}
	}
	
	public function actionDislike($eventId = null)
	{
		$eventId = (int)$eventId;
		$event = Event::constructByKey($eventId);
		if (is_object($event)) {
			$eventVote = new EventVote();
			$user = $this->getLoggedInUser();
			// FIXME 2010-03-23 RHP, require loggedin user
			if (is_object($user))
			{
				$eventVote->setUserId($user->getUserId());
				$recommender = new Ev_Recommendation();
				$recommender->dislike($user->getUserId(), $event->getEventId());
			}
			$eventVote->setEventId($event->getEventId());
			$eventVote->setValue(-10);
			$eventVote->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
			$eventVote->save();
			$event->updateVoteTotal();
			$this->redirect('/' . City::getInstance()->getShortName() . '/search?q='. urlencode($this->getLastSearchQuery()));
			die;
		} else {
			die('404');
		}
	}
	
	
}
