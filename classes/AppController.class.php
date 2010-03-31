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
		
		if (DEV)
		{
			foreach (CoughDatabaseFactory::getDatabases() as $db)
			{
				$db->startLoggingQueries();
			}
		}
		
		$this->setLayoutVar('user', '');
		if ($this->hasLoggedInUser())
		{
			$user = $this->getLoggedInUser();
			$this->setLayoutVar('user', $user);
			
		}
		$this->setSearchVars();
		
		$this->setVar('city', City::getInstance());
		$this->setLayoutVar('city', City::getInstance());
		
		$shouldShowPastEvents = isset($this->get['p']) ? (bool)$this->get['p'] : false;
		$this->setVar('shouldShowPastEvents', $shouldShowPastEvents);
		$this->setLayoutVar('shouldShowPastEvents', $shouldShowPastEvents);
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
	
	public function getLastSearchQuery()
	{
		if (isset($_SESSION['last_search_query']))
		{
			return $_SESSION['last_search_query'];
		}
		return '';
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
	
	public function setLoggedInUser($user)
	{
		$_SESSION['logged_in_user'] = $user->getFields();
	}
	
	public function hasLoggedInUser()
	{
		return isset($_SESSION['logged_in_user']);
	}
	
	public function getLoggedInUser()
	{
		if (isset($_SESSION['logged_in_user']))
		{
			return User::constructByFields($_SESSION['logged_in_user']);
		}
		return null;
	}
	
	public function logout()
	{
		unset($_SESSION['logged_in_user']);
	}
	
	public function requireLogin()
	{
		if (!$this->hasLoggedInUser())
		{
			$this->setLoginRedirectUrl($_SERVER['REQUEST_URI']);
			$this->redirect('/account/login');
			exit;
		}
	}
	
	public function setLoginRedirectUrl($url)
	{
		$_SESSION['login_redirect_url'] = $url;
	}

	public function getAndClearLoginRedirectUrl()
	{
		if (isset($_SESSION['login_redirect_url']))
		{
			$loginRedirectUrl = $_SESSION['login_redirect_url'];
			unset($_SESSION['login_redirect_url']);
			return $loginRedirectUrl;
		}
		return '';
	}
	
	public function hasLoginRedirectUrl()
	{
		return isset($_SESSION['login_redirect_url']);
	}
	
}
