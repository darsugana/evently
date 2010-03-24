<?php
class Ev_Date
{
	/*
		What formats do I need to support?
		02/10/2009
		10 February
		Next Tuesday
		Feb 10
		2009-02-10
		10/02/2009?
		10 February 2009
		Feb 10th, 2009
		Feb 10th 09 08:30pm
		02-10-2009 20:30
		8:30pm Feb 10th 2009
		02/10@8:30
		Every Weds.
		Any more?

		Seems like (RECURRING/MODIFIER) (YEAR) (MONTH) (DAY) (DAY OF WEEK) (TIME) in any order, with everything optional

		Separators? [/, -]+ maybe

		Recurring: Every/Next/Every Other/Two Weeks From Until? (every|next)
		Year: 2009/09? (20[0-9][0-9])
		Month: Jan/jan/January/01/1?  (([01]?[0-9]?)|((jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)(\.|[a-z]+)?))
		Day of week: Mon/monday/mon/Monday ((mon|tues|wed|thurs|fri|sat|sun)(\.|(day))?)
		Day: 1, 1st, 01 ([0-3]?[0-9](st|nd|rd|th)?)
		Time: 8:30pm, 8:30 at night, 2030 hours, 20:30, noon, midnight, 8:30, 8:30 in the morning  @?(([012]?[0-9](:?[0-5][0-9]).?(pm|am|hours|at.night|in.the.morning))|noon|midnight)
	
	
	
	*/
	
	protected static $testValues = array(
			'02/10/2009',
			'10 February',
			'Next Tuesday',
			'February 10', 
			'Feb 10',
			'2009-02-10',
			'10/02/2009',
			'10 February 2009',
			'Feb 10th, 2009',
			'Feb 10th 09 08:30pm',
			'02-10-2009 20:30',
			'8:30pm Feb 10th 2009',
			'02/10@8:30',
			'Every Weds.',
			'10 Feb \'09;',
			'Monday, March 8 at 6:00 PM',
			'Wednesday, April 14th, 2010, Doors at 6:30 p.m.',
		);
	
	protected static $separators = '[/, @-]+';

	// protected static $recurring = '(every|next)?';
	protected static $year = '((20|\')?[0-9][0-9])\b';
	protected static $month = '(([01]?[0-9])|((jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)(\.|[a-z])*))\b';
	protected static $monthNumber = '([01]?[0-9])\b';
	protected static $monthName = '((jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec|january|february|march|april|may|june|july|august|september|october|november|december)\.?)';
	protected static $dayOfWeek = '((mon|tues|wed|thurs|fri|sat|sun)(\.|(day))?)';
	protected static $day = '([0-3]?[0-9](st|nd|rd|th)?)\b';
	protected static $time = '(([012]?[0-9]:[0-5][0-9].?(p.?m.?|a.?m.?|hours|at.night|in.the.morning))|noon|midnight)\b';
	protected static $modifiers = '(next|every)';
	
	
	public static function isDate($string)
	{
		return false;
	}
	
	public static function containsDate($string)
	{
		return false;
	}
	
	public static function findDate($string)
	{
		return false;
	}
	
	public static function stringToDateTime($string, $verbose = false)
	{
		$date = self::stringToDate($string, $verbose);
		$time = self::stringToTime($string, $date, $verbose);
		if ($time !== false && $time != 0)
		{
			return  $time;
		}
		// FIXME 2010-03-24 RHP: We need to distinguish between times of midnight, and cases where we don't have a time...
		if ($date !== false && $date != 0)
		{
			return $date;
		}
		
		return false;
	}
	
	public static function stringToTime($string, $date = 0, $verbose = true)
	{
		
		$matches = array();

		if ($verbose)
		{
			echo $string . "\n";
		}
	
		if (preg_match_all('~' . self::$time . '~i', $string, $matches))
		{
			if ($verbose)
			{
				echo "matched time\n";
				print_r(getdate(strtotime($matches[0][0], $date)));
				print_r($matches);
			}
			foreach ($matches as $match)
			{
				if (strtotime($match[0]) !== FALSE)
				{
					return strtotime($match[0], $date);
				}
			}
			
		}
		
		if ($verbose)
		{
			echo 'no matches for ' . $string . "\n";
		}
		return false;		
	}
	
	public static function stringToDate($string, $verbose = false)
	{
		// (RECURRING/MODIFIER) (YEAR) (MONTH) (DAY) (DAY OF WEEK) (TIME)
		
	
		
		$ymd = '~'
			. self::$year .'('	. self::$separators 
			. self::$month . ')?(' . self::$separators 
			. self::$day . ')?(' . self::$separators
			. self::$dayOfWeek . ')?' . '~i';
		
		$dmy = '~'
			. self::$day. self::$separators 
			. self::$monthName  . '(' . self::$separators  . ')?('
			. self::$year . ')?(' . self::$separators . ')?('
			. self::$dayOfWeek . ')?' . '~i';
		
		$mnady = '~'
			. self::$monthName . self::$separators 
			. self::$day . '(' . self::$separators 
			. self::$year . ')?'. '~iU';

		$mnody = '~'
			. self::$monthNumber . self::$separators 
			. self::$day . '(' . self::$separators 
			. self::$year . ')?(' . self::$separators 
			. self::$dayOfWeek . ')?'. '~i';

		$dwmd = '~'
			. self::$dayOfWeek . self::$separators 
			. self::$monthName . '(' . self::$separators 
			. self::$day . ')?'. '~i';
		
		$modifier = '~'
			. self::$modifiers . self::$separators
			. self::$dayOfWeek . '~i';
		
		$matches = array();

		if ($verbose)
		{
			echo "matching against: " . $string . "\n";
		}
		
		
		if (preg_match($dwmd, $string, $matches))
		{
			if ($verbose)
			{
				echo "matched dayofweek monthname day\n";
				print_r(getdate(strtotime($matches[0])));
				print_r($matches);
			}
			if (strtotime($matches[0]) !== FALSE)
			{
				return strtotime($matches[0]);
			}
			
		}
		
			
		if (preg_match($mnady, $string, $matches))
		{
			if ($verbose)
			{
				echo "matched  month name day year\n";
				print_r(getdate(strtotime($matches[0])));
				print_r($matches);
			}
			if (strtotime($matches[0])  !== FALSE)
			{
				return strtotime($matches[0]);
			}
		}
		
		if (preg_match($dmy, $string, $matches))
		{
			if ($verbose)
			{
				echo "matched day month year time\n";
				print_r(getdate(strtotime($matches[0])));

				print_r($matches);
			}
			if (strtotime($matches[0])  !== FALSE)
			{
				return strtotime($matches[0]);
			}
			
		}
		if (preg_match($mnody, $string, $matches))
		{
			if ($verbose)
			{
				echo "matched  month number day year time\n";
				print_r(getdate(strtotime($matches[0])));
				print_r($matches);
			}
			if (strtotime($matches[0])  !== FALSE)
			{
				return strtotime($matches[0]);
			}
			
		}
		
		if (preg_match($ymd, $string, $matches))
		{
			if ($verbose)
			{
				echo "matched year month day time\n";
				print_r(getdate(strtotime($matches[0])));
				print_r($matches);
			}
			if (strtotime($matches[0]) !== FALSE)
			{
				return strtotime($matches[0]);
			}
			
		}
		
		
		if (preg_match($modifier, $string, $matches))
		{
			// FIXME 2009-03-24 RHP: Add actual recurring events
			if (stripos($matches[0], 'every') !== FALSE)
			{
				$matches[0] = str_ireplace('every', 'next', $matches[0]);
			}
			if ($verbose)
			{
				echo "matched modifier day\n";
				print_r(getdate(strtotime($matches[0])));
				print_r($matches);
			}
			if (strtotime($matches[0]) !== FALSE)
			{
				return strtotime($matches[0]);
			}
			
		}
		
		if ($verbose)
		{
			echo 'no matches for ' . $string . "\n";
		}
		return false;
	}
	
	public static function testStringToDate()
	{
		foreach (self::$testValues as $string)
		{
			echo $string . "\n";
			$date = self::stringToDateTime($string, true);
			echo "'" . $date . "'\n";
			echo 'retval ' . date('Y-M-d H:i:s', $date) . ' for ' . $string . "\n";
		}
	}
	
	
}


?>