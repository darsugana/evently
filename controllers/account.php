<?php
class AccountController extends AppController
{
	public function actionIndex()
	{
		$this->requireLogin();
		$user = $this->getLoggedInUser();
		
		// FIXME 2010-03-25 RHP this is a mess, move all the validation logic into the User model
		if (isset($this->post['login']))
		{
			if (isset($this->post['login']['old_password'])
			&& isset($this->post['login']['password'])
			&& isset($this->post['login']['password_confirm']))
			{
				$login = $this->post['login'];
				$oldPassword = trim($login['old_password']);
				$password = trim($login['password']);
				$passwordConfirm = trim($login['password_confirm']);
				if ($user->isPasswordCorrect($oldPassword))
				{
					if ($password == $passwordConfirm)
					{
						if ($user->isPasswordValid($password))
						{
							$user->setPassword($password);
							$user->save();
						
							$this->setLoggedInUser($user);
						
							$this->redirect(Ev_Link::getLinkPath('/'));
							exit;
						}
						else
						{
							$this->setVar('errors', $user->getValidationErrors());
						}
					}
					else
					{
						$this->setVar('errors', array('New password and password confirmation do not match.'));
					}
				}
				else
				{
					$this->setVar('errors', array('Old password not correct.'));
				}
			}
			else
			{
				$this->setVar('errors', array('Must set old password, new password and password confirmation.'));
			}
		}
		else
		{
			$this->setVar('errors', array());
		}
		
		$this->setVar('user', $user);
	}
	
	public function actionCreate()
	{
		// FIXME 2010-03-25 RHP this is a mess, move all the validation logic into the User model
		if (isset($this->post['login']))
		{
			if (isset($this->post['login']['email']) 
			&& isset($this->post['login']['password'])
			&& isset($this->post['login']['password_confirm']))
			{
				$login = $this->post['login'];
				$email = trim($login['email']);
				if (User::isEmailUnique($email))
				{
					$password = trim($login['password']);
					$passwordConfirm = trim($login['password_confirm']);
					if ($password == $passwordConfirm)
					{
						$user = new User();
						$user->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
						
						if ($user->isEmailValid($email))
						{
							$user->setEmail($email);
							if ($user->isPasswordValid($password))
							{
								$user->setPassword($password);
								$user->save();
								
								$this->setLoggedInUser($user);
								Ev_Email::mailNewAccount($user);
								$this->redirect(Ev_Link::getLinkPath('/'));
								exit;
							}
							else
							{
								$this->setVar('errors', $user->getValidationErrors());
							}
						}
						else
						{
							$this->setVar('errors', $user->getValidationErrors());
						}
					}
					else
					{
						$this->setVar('errors', array('Passwords do not match'));
					}
				}
				else
				{
					$this->setVar('errors', array('Email address in use.'));
				}
			}
			else
			{
				$this->setVar('errors', array('Must set email, password and password confirmation.'));
			}
		}
		else
		{
			$this->setVar('errors', array());
		}
	}
	
	public function actionLogin()
	{
		if (isset($this->post['login']) && isset($this->post['login']['email']) && isset($this->post['login']['password']))
		{
			$login = $this->post['login'];
			$user = User::constructByEmailAndPassword($login['email'], $login['password']);
			if (is_object($user))
			{
				$this->setLoggedInUser($user);

				$redirectUrl = Ev_Link::getLinkPath('/');
				// FIXME 2010-03-25 RHP save old url before going to login page
				if ($this->hasLoginRedirectUrl())
				{
					$redirectUrl = $this->getAndClearLoginRedirectUrl();
				}
				$this->redirect($redirectUrl);
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
	
	public function actionLostPassword()
	{
		if (isset($this->post['login']) && isset($this->post['login']['email']))
		{
			$login = $this->post['login'];
			$email = trim($login['email']);
			if (User::userExists($email))
			{
				$user = User::constructByEmail($email);
				if (!is_object($user))
				{
					$this->redirect('/');
					error_log('lost password crisis for:' . $email);
					exit;
				}
				// FIXME 2010-03-25 RHP: don't set new passord, generate a token, let user create new password on inputting token to website
				$newPassword = User::generatePassword();
				$user->setPassword($newPassword);
				if (Ev_Email::mailNewPassword($user, $newPassword))
				{
					$user->save();
					$this->redirect('/account/lost_password_confirm');
					exit;
				}
				else
				{
					$this->setVar('errors', array());
				}
			}
			else
			{
				$this->setVar('errors', array('User account not found'));
			}
		}
		else
		{
			$this->setVar('errors', array());
		}
		
	}
	
	public function actionLostPasswordConfirm()
	{
		
	}
}
?>