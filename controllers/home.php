<?php
class HomeController extends AppController
{
	protected function actionIndex()
	{
		$currentUser = $this->getSignedInUser();
		$tweets = new Tweet_Collection();
		$tweets->loadRecentByUser($currentUser);
		
		$this->setVar('tweets', $tweets);
	}
	
	protected function actionEveryone()
	{
		$tweets = new Tweet_Collection();
		$tweets->loadRecentByEveryone();
		
		$this->setVar('tweets', $tweets);
	}
	
	protected function actionArchive()
	{
		$currentUser = $this->getSignedInUser();
		$tweets = new Tweet_Collection();
		$tweets->loadByUser($currentUser);
		
		$this->setVar('tweets', $tweets);
	}
}
?>