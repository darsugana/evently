<?php
class Ev_Email
{
	public static function mailNewAccount($user)
	{
		$subject = 'Welcome to Evently!';
		$toAddress = $user->getEmail();
		$body = '
			You have successfully created an account at Evently.net, everyone\'s event search!

			Thank you,
			
			Evently.net

		';
		return self::email($toAddress, $subject, $body);
	}
	
	public static function mailNewPassword($user, $password)
	{
		$subject = 'Evently Account Password Reset';
		$toAddress = $user->getEmail();
		$body = '
			You are receiving this message because you have asked for a password reset.
			You may login at http://evently.net/account/login
			Username: '. htmlentities($user->getEmail()) . '
			Password: ' . $password . '
			
			Thank you,
			
			Evently.net
		';
		return self::email($toAddress, $subject, $body);
		
	}
	
	
	private static function email($toAddress, $subject, $body)
	{
		$headers = 'From: webmaster@evently.net' . "\r\n" .
		    'Reply-To: webmaster@evently.net' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		return mail($toAddress, $subject, $body, $headers);
	}
}