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