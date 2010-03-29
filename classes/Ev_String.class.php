<?php
class Ev_String
{
	public static function wordTrim($string, $length = 255)
	{
		$words = explode(' ' , $string);
		$retval = '';
		$curLength = 0;
		$isTrimmed = false;
		foreach ($words as $word)
		{
			if ($curLength + 1 + strlen($word) <= $length)
			{
				$retval .= ' ' . $word;
				$curLength += 1 + strlen($word);
			}
			else
			{
				$isTrimmed = true;
				break;
			}
		}
		if ($isTrimmed) {
			$retval = $retval . ' ...';
		}
		return $retval;
	}
	
	
	// 2010-03-29 FIXME RHP: use something less naive is a multikeyword string matching algorithm. Aho-Corasick?
	public static function getKeywordArrayMatches($string, $keywords)
	{
		$retval = array();
		
		foreach ($keywords as $keyword)
		{
			$pos = stripos($string, $keyword);
			if ($pos !== FALSE)
			{
				$retval[$keyword] = $pos;
			}
		}
		
		return $retval;
	}
	
	
	
}