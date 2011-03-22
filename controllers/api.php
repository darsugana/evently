<?php
class ApiController extends AppController
{
	public function actionEvents()
	{
		$events = new Event_Collection();
		$events->loadByCriteria($this->get);
		
		Debug::superjam($events);
	}
}
