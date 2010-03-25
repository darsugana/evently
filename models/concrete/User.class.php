<?php

/**
 * This is the starter class for User_Generated.
 *
 * @see User_Generated, CoughObject
 **/
class User extends User_Generated implements CoughObjectStaticInterface {
	
	const PASSWORD_SALT = '2fy5SV"cx';
	
	private static function hashPassword($password, $email)
	{
		return hash('sha256', $password . $email . self::PASSWORD_SALT);
	}
	
	public function setPassword($password)
	{
		$this->setPasswordHash(self::hashPassword($password, $this->getEmail()));
	}
	
	public function isPasswordCorrect($password)
	{
		return $this->getPasswordHash() == self::hashPassword($password, $this->getEmail());
	}
	
	public static function constructByEmailAndPassword($email, $password)
	{
		$db = self::getDb();
		
		$sql = '
			SELECT
				*
			FROM
				user
			WHERE
				email = '. $db->quote($email) .'
				AND (password_hash = ' . $db->quote($password) . '
					OR password_hash = ' . $db->quote(self::hashPassword($password, $email)) . ')
				AND is_deleted = 0
		';
		
		return self::constructBySql($sql);
		
	}
	
	public function isPasswordValid($password)
	{
		// require 6 characters
		if (strlen($password) < 6)
		{
			$this->validationErrors['password'] = 'Password must be at least 6 characters';
			return false;
		}
		// email and password cannot match;
		if ($password == $this->getEmail())
		{
			$this->validationErrors['password'] = 'Email and password cannot match';
			return false;
		}
		
		return true;
	}
	
	public function isEmailValid($email)
	{
		if ($email == '')
		{
			$this->validationErrors['email'] = 'Email address must not be blank';
			return false;
		}
		
		if (strpos($email, '@') === false)
		{
			$this->validationErrors['email'] = 'Email Address does not appear to be valid (no @)';
			return false;
		}
		
		return true;
	}
	
	public static function isEmailUnique($email)
	{
		$db = self::getDb();
		$sql = '
			SELECT
				count(*) AS count
			FROM
				user
			WHERE
				is_deleted = 0
				AND email = ' . $db->quote($email) . '
		';
		
		
		$result = $db->query($sql);
		$count = 0;
		while ($row = $result->getRow())
		{
			$count = $row['count'];
		}
		return ($count == 0);
	}
	
}







