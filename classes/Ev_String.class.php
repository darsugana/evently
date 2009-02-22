<?php

class Ev_String
{
	
	public static function wordTrim($string, $length = 255)
	{
		$words = explode(' ' , $string);
		$retval = '';
		$curLength = 0;
		foreach ($words as $word)
		{
			if ($curLength + 1 + strlen($word) <= $length)
			{
				$retval .= ' ' . $word;
				$curLength += 1 + strlen($word);
			}
			else
			{
				break;
			}
		}
		return $retval;
	}
	
}