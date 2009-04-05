<?php
class HomeController extends AppController
{
	protected function beforeAction()
	{
		$this->handleMissingCity();
		$this->setLayout('splash');
		parent::beforeAction();
	}
	
	protected function actionIndex()
	{
		
	}
}
