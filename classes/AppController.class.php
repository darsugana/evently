<?php

class AppController extends Lvc_PageController
{
	protected $layout = 'default';
	
	protected function beforeAction()
	{
		// set signed in user
		if (isset($_SESSION['user_fields']))
		{
			$this->setSignedInUser(User::constructByFields($_SESSION['user_fields']));
		}
		
		$this->requireSignIn();
		
		$this->requireCss('reset.css');
		$this->requireCss('master.css');
		
		$this->setLayoutVar('pageTitle', 'Event Search');
		$this->setLayoutVar('controllerName', $this->controllerName);
		$this->setLayoutVar('actionName', $this->actionName);
	}
	
	public function requireCss($cssFile)
	{
		$this->layoutVars['requiredCss'][$cssFile] = true;
	}
	
	public function requireJs($jsFile)
	{
		$this->layoutVars['requiredJs'][$jsFile] = true;
	}
}

?>