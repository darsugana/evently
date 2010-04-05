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
		return ($this->getPasswordHash() == self::hashPassword($password, $this->getEmail()) || $this->getPasswordHash() == $password);
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
	
	public static function constructByEmail($email)
	{
		return self::constructByKey(array('email' => $email, 'is_deleted' => 0));
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
	
	public static function userExists($email)
	{
		return !User::isEmailUnique($email);
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
	
	public static function generatePassword($length = 10)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789;,./[]`~!@#$%^&*(){}|:?-=_+';
		$len = strlen($chars);
		$retval = '';
		for ($i = 0; $i< $length; $i++)
		{
			$retval .= $chars[rand(0,$len)];
		}
		return $retval;
	}


	public function makeRsvp($event)
	{
		$eventId = $event->getEventId();
		$db = self::getDb();
		
		$sql = '
			SELECT
				*
			FROM
				rsvp
			WHERE
				is_deleted = 0
				AND event_id = '. $db->quote($eventId) .'
				AND user_id = ' . $db->quote($this->getUserId()) . '
		';
		
		$result = $db->query($sql);
		while ($row = $result->getRow())
		{
			return;
		}
		
		$rsvp = new Rsvp();
		$rsvp->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		$rsvp->setEventId($eventId);
		$rsvp->setUserId($this->getUserId());
		$rsvp->save();
		
	}
	
	public function removeRsvp($event)
	{
		$eventId = $event->getEventId();
		$db = self::getDb();
		
		$sql = '
			UPDATE
				rsvp
			SET
				is_deleted = 1
			WHERE
				is_deleted = 0
				AND event_id = '. $db->quote($eventId) .'
				AND user_id = ' . $db->quote($this->getUserId()) . '
		';
		
		$result = $db->query($sql);
		
	}
	
	public function removeVote($event)
	{
		$eventId = $event->getEventId();
		$db = self::getDb();
		
		$sql = '
			UPDATE
				event_vote
			SET
				is_deleted = 1
			WHERE
				is_deleted = 0
				AND event_id = '. $db->quote($eventId) .'
				AND user_id = ' . $db->quote($this->getUserId()) . '
		';
		
		$result = $db->query($sql);
		
	}
	
	
}







