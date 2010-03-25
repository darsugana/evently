<?php
class LoginController extends AppController
{
	public function actionIndex()
	{
		if (isset($this->post['login']) && isset($this->post['login']['email']) && isset($this->post['login']['password']))
		{
			$login = $this->post['login'];
			$user = User::constructByEmailAndPassword($login['email'], $login['password']);
			if (is_object($user))
			{
				$this->setLoggedInUser($user);
				// FIXME 2010-03-25 RHP save old url before going to login page
				$this->redirect(Ev_Link::getLinkPath('/'));
				exit;
			}
			else
			{
				$this->setVar('errors', array('Username/Password incorrect'));
			}
		}
		else
		{
			$this->setVar('errors', array());
		}
		
	}
	
	public function actionLogout()
	{
		if ($this->hasLoggedInUser())
		{
			$this->logout();
		}
		
		$this->redirect(Ev_Link::getLinkPath('/'));
		exit;
	}
}
