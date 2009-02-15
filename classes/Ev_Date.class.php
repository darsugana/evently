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
		);
	
	protected static $separators = '[/, @-]+';

	// protected static $recurring = '(every|next)?';
	protected static $year = '((20|\')?[0-9][0-9])\b';
	protected static $month = '(([01]?[0-9])|((jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)(\.|[a-z])*))\b';
	protected static $monthNumber = '([01]?[0-9])\b';
	protected static $monthName = '((jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec|january|february|march\april|may|june|july|august|september|october|november|december)\.?)';
	protected static $dayOfWeek = '((mon|tues|wed|thurs|fri|sat|sun)(\.|(day))?)?';
	protected static $day = '([0-3]?[0-9](st|nd|rd|th)?)\b';
	protected static $time = '(@?(([012]?[0-9](:[0-5][0-9]).?(pm|am|hours|at.night|in.the.morning))|noon|midnight))\b';
	
	
	
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
	
	public static function stringToDate($string)
	{
		// (RECURRING/MODIFIER) (YEAR) (MONTH) (DAY) (DAY OF WEEK) (TIME)
		
	
		
		$ymdt = '~'
			. self::$year .'('	. self::$separators 
			. self::$month . ')?(' . self::$separators 
			. self::$day . ')?(' . self::$separators
			. self::$dayOfWeek . ')?(' . self::$separators
			. self::$time . ')?' . '~i';
		
		$dmyt = '~'
			. self::$day. self::$separators 
			. self::$monthName  . '(' . self::$separators  . ')?('
			. self::$year . ')?(' . self::$separators . ')?('
			. self::$dayOfWeek . ')?(' . self::$separators 
			. self::$time . ')?' . '~i';
		
		$mnadyt = '~'
			. self::$monthName . self::$separators 
			. self::$day . '(' . self::$separators 
			. self::$year . ')?(' . self::$separators 
			. self::$dayOfWeek . ')?(' . self::$separators 
			. self::$time . ')?'. '~iU';

		$mnodyt = '~'
			. self::$monthNumber . self::$separators 
			. self::$day . '(' . self::$separators 
			. self::$year . ')?(' . self::$separators 
			. self::$dayOfWeek . ')?(' . self::$separators 
			. self::$time . ')?'. '~i';

		
		$tmdy = '~' 
			
			. self::$time . self::$separators
			. self::$monthName . self::$separators 
			. self::$day . '(' . self::$separators 
			. self::$year . ')?(' . self::$separators 
			. self::$dayOfWeek . ')?'. '~i';
		$matches = array();
		echo $string . "\n";
		if (0)
		{
			
		}
		
			
		else if (preg_match($mnadyt, $string, $matches))
		{
			echo "matched  month name day year time\n";
			print_r(getdate(strtotime($matches[0])));
			print_r($matches);
		}
		
		else if (preg_match($dmyt, $string, $matches))
		{
			echo "matched day month year time\n";
			print_r(getdate(strtotime($matches[0])));

			print_r($matches);
		}
		else if (preg_match($mnodyt, $string, $matches))
		{
			echo "matched  month number day year time\n";
			print_r(getdate(strtotime($matches[0])));
			print_r($matches);
		}
		
		else if (preg_match($tmdy, $string, $matches))
		{
			echo "matched time month day year\n";
			print_r(getdate(strtotime($matches[0])));
			
			print_r($matches);
		}
		else if (preg_match($ymdt, $string, $matches))
		{
			echo "matched year month day time\n";
			print_r(getdate(strtotime($matches[0])));
			print_r($matches);
		}
		
		
		
		else
		{
			echo 'no matches for ' . $string . "\n";
		}
		return false;
	}
	
	public static function testStringToDate()
	{
		foreach (self::$testValues as $string)
		{
			self::stringToDate($string);
		}
	}
	
	
}


?>