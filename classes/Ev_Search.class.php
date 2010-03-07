<?php
class Ev_Search
{
	protected static $index = null;
	protected static $mode = SPH_MATCH_ALL;
	protected static $host = 'localhost';
	protected static $port = 9312;
	protected static $cl = null;

	public static function setConfig($config)
	{
		self::$index = $config['index'];
		self::$mode = $config['mode'];
		self::$host = $config['host'];
		self::$port = $config['port'];
	}
	
	public function getSphinx()
	{
		if (is_null(self::$cl))
		{
			self::$cl = new SphinxClient();
			self::$cl->SetServer(self::$host, self::$port);
			self::$cl->SetMatchMode(self::$mode);
		}
		
		return self::$cl;
	}
	
	public function escapeString($string)
	{
		return $this->getSphinx()->EscapeString($string);
	}

	public function setGroupBy($attribute, $func, $groupsort = "@group desc")
	{
		return $this->getSphinx()->SetGroupBy($attribute, $func, $groupsort);
	}

	public function setFilter($attribute, $values, $exclude=false)
	{
		$this->getSphinx()->setFilter($attribute, $values, $exclude);
	}

	public function setWeights($weightArray)
	{
		$this->getSphinx()->SetWeights($weightArray);
	}

	public function search($searchQuery, $offset=0, $limit=4000, $max=0)
	{
		$sphinx = $this->getSphinx();
		$sphinx->SetLimits($offset, $limit, $max);
		$res = $sphinx->Query($searchQuery, self::$index);
		return $res;
	}
}

?>

