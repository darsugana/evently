<?php
class Ev_Recommendation
{

	const EVENT = 1;

	protected static $engine = null;
	protected static $itemEngine = null;
	protected static $userEngine = null;

	private function getEngine()
	{
		return self::$engine;
	}

	private function getItemEngine()
	{
		return self::$itemEngine;
	}

	private function getUserEngine()
	{
		return self::$userEngine;
	}


	public static function setEngines($engine, $itemEngine, $userEngine)
	{
		self::$engine = $engine;
		self::$itemEngine = $itemEngine;
		self::$userEngine = $userEngine;
		
	}

	public function like($userId, $eventId)
	{
		$engine = self::getEngine();
		$engine->set_rating($userId, $eventId, 1, self::EVENT);
	}

	public function dislike($userId, $eventId)
	{
		$engine = self::getEngine();
		$engine->set_rating($userId, $eventId, 0, self::EVENT);
	}

	public function visit($userId, $eventId)
	{
		$engine = self::getEngine();
		$engine->automatic_rating($userId, $eventId, false, self::EVENT);
	}

	public function attend($userId, $eventId)
	{
		$engine = self::getEngine();
		$engine->automatic_rating($userId, $eventId, true, self::EVENT);
	}

	public function clear($userId, $eventId)
	{
		$engine = self::getEngine();
		$engine->delete_rating($userId, $eventId, self::EVENT);
	}
	

	public function getRecommendedEvents($userId)
	{
		$engine = self::getEngine();
		$itemEngine = self::getItemEngine();
		
		$recommendedEvents = $itemEngine->member_get_recommended_items($userId, self::EVENT);
		
		return $recommendedEvents;		
	}

	public function getRecommendedUsers($userId)
	{
		$engine = self::getEngine();
		$userEngine = self::getUserEngine();
		
		$recommendedUsers = array();
		
		$userEngine->member_k_similarities($userId, $recommendedUsers, $recommendedUsers, self::EVENT);
		
		return $recommendedUsers;		
	}



}
