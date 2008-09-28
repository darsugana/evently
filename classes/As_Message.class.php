<?php

/**
 * Usage Examples:
 * 
 * // In controller:
 * As_Message::addMessage('accounting', 'Customer was charged');
 * As_Message::addMessage('accounting', 'Customer was charged because llama ate machine');
 * // In view:
 * As_Message::getMessage('accounting'); // returns array of message(s) or null if no messages AND removes the messages.
 * // To get the messages without removing them pass false for second parameter.
 * 
 * // Redirection example (i.e. storing the message to the session):
 * 
 * // In controller:
 * As_Message::addFlash('accounting', 'Customer was charged');
 * // In view:
 * As_Message::getFlash('accounting'); // returns array of message(s) or null if no messages AND removes the messages.
 * // To get the messages without removing them pass false for second parameter.
 * 
 * @package default
 * @author Anthony Bush
 * @author Lewis Zhang
 * @since 2007-07-26
 **/
class As_Message
{
	protected static $messages = array();
	protected static $sessionKey = 'As_Messages';
	protected static $isSessionStarted = false;
	
	public static function addMessage($key, $msg)
	{
		self::$messages[$key][] = $msg;
	}
	
	public static function addFlash($key, $msg)
	{
		if (!self::isSessionStarted())
		{
			session_start();
			self::setSessionStarted(true);
		}
		
		$_SESSION[self::$sessionKey][$key][] = $msg;
	}
	
	public static function getMessage($key, $unset = true)
	{
		if (isset(self::$messages[$key]))
		{
			$value = self::$messages[$key];
		}
		else
		{
			$value = null;
		}
		
		if ($unset)
		{
			unset(self::$messages[$key]);
		}
		
		return $value;
	}
	
	public static function getFlash($key, $unset = true)
	{
		if (isset($_SESSION[self::$sessionKey][$key]))
		{
			$value = $_SESSION[self::$sessionKey][$key];
		}
		else
		{
			$value = null;
		}
		
		if ($unset)
		{
			unset($_SESSION[self::$sessionKey][$key]);
		}
		
		return $value;
	}
	
	public static function isSessionStarted()
	{
		return self::$isSessionStarted;
	}
	
	public static function setSessionStarted($isSessionStarted)
	{
		self::$isSessionStarted = $isSessionStarted;
	}
	
	public static function hasFlash($key)
	{
		if (!empty($_SESSION[self::$sessionKey][$key]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function hasMessage($key)
	{
		if (!empty(self::$messages[$key]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>