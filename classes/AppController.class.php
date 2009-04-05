<?php

class AppController extends Lvc_PageController
{
	protected $layout = 'default';
	
	protected function beforeAction()
	{
		$this->requireCss('reset.css');
		$this->requireCss('master.css');
		
		$this->setLayoutVar('pageTitle', 'evently - everyone\'s event search');
		$this->setLayoutVar('controllerName', $this->controllerName);
		$this->setLayoutVar('actionName', $this->actionName);
		$this->setLayoutVar('layoutName', $this->layout);
		
		$this->setSearchVars();
		

		$this->setVar('city', City::getInstance());
		$this->setLayoutVar('city', City::getInstance());
	}
	
	public function requireCss($cssFile)
	{
		$this->layoutVars['requiredCss'][$cssFile] = true;
	}
	
	public function requireJs($jsFile)
	{
		$this->layoutVars['requiredJs'][$jsFile] = true;
	}

	
	public function setSearchVars()
	{
		$this->setLayoutVar('query', '');
		$this->setVar('query', '');
		
		if (isset($_SESSION['last_search_query']))
		{
			$this->setLayoutVar('query', trim($_SESSION['last_search_query']));
			$this->setVar('query', trim($_SESSION['last_search_query']));
			
		}
		
	}
	
	public function setLastSearchQuery($query)
	{
		$_SESSION['last_search_query'] = $query;
	}
	
	public function clearLastSearchQuery()
	{
		unset($_SESSION['last_search_query']);
	}
	
	

	
	public function handleMissingCity()
	{
		if (is_null(City::getInstance()))
		{
			City::loadDefaultInstance();
			$this->redirect('/' . City::getInstance()->getShortName() . '/');
			exit();
		}
	}

}
