<?php
class HomeController extends AppController
{
	protected function beforeAction()
	{
		$this->setLayout('splash');
		parent::beforeAction();
	}
	
	protected function actionIndex()
	{
		
	}
}
