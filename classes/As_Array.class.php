<?php
class As_Array
{
	/**
	 * Merge two arrays recursively in the way you might have thought
	 * array_merge_recursive would have worked (the same way array_merge works, only
	 * recursively).  Actually it behaves more like adding two arrays as it preserves
	 * numeric indexes also.
	 * 
	 * Given $arr1:
	 * 
	 *     Array
	 *     (
	 *         [customer] => Array
	 *             (
	 *                 [contact_fullname] => Anthony Bush
	 *                 [email_address] => anthony_bush@academicsuperstore.com
	 *             )
	 *     
	 *         [another_key] => non_array_value_in_array1
	 *     )
	 * 
	 * And Given $arr2:
	 * 
	 *     Array
	 *     (
	 *         [customer] => Array
	 *             (
	 *                 [contact_fullname] => 
	 *                 [email_address] => 
	 *                 [ensure_this_key_exists] => default value
	 *             )
	 *     
	 *         [another_key] => non_array_value
	 *     )
	 * 
	 * The resulting array will look like:
	 * 
	 *     Array
	 *     (
	 *         [customer] => Array
	 *             (
	 *                 [contact_fullname] => Anthony Bush
	 *                 [email_address] => anthony_bush@academicsuperstore.com
	 *                 [ensure_this_key_exists] => default value
	 *             )
	 *     
	 *         [another_key] => non_array_value_in_array1
	 *     )
	 * 
	 * Whereas, array_merge_recursive($arr1, $arr2) will look like:
	 * 
	 *     Array
	 *     (
	 *         [customer] => Array
	 *             (
	 *                 [contact_fullname] => Array
	 *                     (
	 *                         [0] => Anthony Bush
	 *                         [1] => 
	 *                     )
	 *     
	 *                 [email_address] => Array
	 *                     (
	 *                         [0] => anthony_bush@academicsuperstore.com
	 *                         [1] => 
	 *                     )
	 *     
	 *                 [ensure_this_key_exists] => default value
	 *             )
	 *     
	 *         [another_key] => Array
	 *             (
	 *                 [0] => non_array_value_in_array1
	 *                 [1] => non_array_value
	 *             )
	 *     
	 *     )
	 * 
	 * @param array $arr1
	 * @param array $arr2
	 * @return array
	 * @author Anthony Bush
	 * @since 2008-06-06
	 **/
	public static function merge($arr1, $arr2)
	{
		foreach ($arr2 as $key => $value)
		{
			if (isset($arr1[$key]))
			{
				if (is_array($value) && is_array($arr1[$key]))
				{
					$arr1[$key] = self::merge($arr1[$key], $value);
				}
				else
				{
					$arr1[$key] = $arr1[$key];
				}
			}
			else
			{
				$arr1[$key] = $value;
			}
		}
		return $arr1;
	}
	
	/**
	 * @deprecated use {@link merge()} instead
	 **/
	public static function mergeData($arr1, $arr2)
	{
		return self::merge($arr1, $arr2);
	}
	
	/**
	 * Recursively iterates through the given array and trims all non-array values.
	 *
	 * @return void
	 * @author Anthony Bush
	 * @since 2008-07-29
	 **/
	public static function trim(&$data)
	{
		foreach ($data as $key => $value)
		{
			if (is_array($value))
			{
				self::trim($data[$key]);
			}
			else
			{
				$data[$key] = trim($value);
			}
		}
	}
	
	/**
	 * Returns an array of elements whose values match the supplied regular expression pattern.
	 *
	 * @param string $pattern
	 * @param array $data
	 */
	public static function pregMatch($pattern, $data)
	{
		$returnArray = array();
		
		foreach($data as $key => $value)
		{
			if (preg_match($pattern, $value))
			{
				$returnArray[$key] = $data[$key];
			}
		}
		
		return $returnArray;
	}
	
	/**
	 * Returns an array of elements whose with matching values replaced
	 * according to the supplied regular expression pattern.
	 *
	 * @param string $pattern
	 * @param string $replacement
	 * @param array $data
	 */
	public static function pregReplace($pattern, $replacement, $data)
	{
		$returnArray = array();
		
		foreach($data as $key => $value)
		{
			$returnArray[$key] = preg_replace($pattern, $replacement, $data[$key]);
		}
		
		return $returnArray;
	}
	
	/**
	 * Compares the new/old fields and returns whether or not they are different
	 *
	 * @return bool
	 * @author Lewis Zhang
	 **/
	public static function hasModifiedFields(&$data)
	{
		foreach ($data as $key => $value)
		{
			if (isset($value['old']) && isset($value['old'] ) && $value['old'] != $value['new'])
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Compares the new/old fields and returns all fields that have changed.
	 *
	 * @return array
	 * @author Anthony Bush
	 * @since 2008-12-12, as of 2009-01-04 it supports recursion
	 **/
	public static function getModifiedFields(&$data)
	{
		$modifiedData = array();
		foreach ($data as $key => $value)
		{
			if (is_array($value))
			{
				if (count($value) == 2 && isset($value['old']) && isset($value['new']))
				{
					if ($value['old'] != $value['new'])
					{
						$modifiedData[$key] = $value['new'];
					}
				}
				else
				{
					$recursiveData = self::getModifiedFields($value);
					if (!empty($recursiveData))
					{
						$modifiedData[$key] = $recursiveData;
					}
				}
			}
			else
			{
				// not using old/new format, so treat as modified
				$modifiedData[$key] = $value;
			}
		}
		
		return $modifiedData;
	}
	
	/**
	 * Robust array sorting method.
	 * 
	 * @param array $arr array to sort
	 * @param mixed $sortArgs array of sort params, either a key to sort by, direction (SORT_ASC or SORT_DESC), or type (SORT_REGULAR, SORT_STRING, or SORT_NUMERIC)
	 * @return bool true on successful sort, false on failure
	 * @author Anthony Bush
	 * @since 2009-01-26
	 * @see http://www.php.net/manual/en/function.array-multisort.php
	 **/
	public static function sort(&$arr, $sortArgs = array())
	{
		if (count($arr) == 0 || empty($sortArgs))
		{
			return true;
		}
		
		if (!is_array($sortArgs))
		{
			$sortArgs = array($sortArgs);
		}
		
		// Build multisortArgs with references to the key value pair arrays to do the sorting on.
		$multisortArgs = array();
		foreach ($sortArgs as $arg)
		{
			if (is_int($arg))
			{
				$multisortArgs[] = $arg;
			}
			else if (array_key_exists($arg, $arr[0]))
			{
				$keyValueArrays = array();
				foreach ($arr as $key => $element)
				{
					$keyValueArrays[$key] = $element[$arg];
				}
				$multisortArgs[] = $keyValueArrays;
			}
		}
		$multisortArgs[] = &$arr;
		
		// Sort
		return call_user_func_array('array_multisort', $multisortArgs);
	}
}
