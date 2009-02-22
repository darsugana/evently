<?php
class Ev_Search
{
	protected $index;
	protected $mode;
	protected $host;
	protected $port;
	protected $cl;

	public function __construct($index, $mode = SPH_MATCH_ALL, $host="localhost", $port=3312)
	{
		$this->index = $index;
		$this->mode = $mode;
		$this->host = $host;
		$this->port = $port;
		$this->cl = new SphinxClient();
	}

	public function escapeString($string)
	{
		return $this->cl->EscapeString($string);
	}

	public function setGroupBy($attribute, $func, $groupsort = "@group desc")
	{
		return $this->cl->SetGroupBy($attribute, $func, $groupsort);
	}

	public function setFilter($attribute, $values, $exclude=false)
	{
		$this->cl->setFilter($attribute, $values, $exclude);
	}

	public function setWeights($weightArray)
	{
		$this->cl->SetWeights($weightArray);
	}

	public function search($searchQuery, $offset=0, $limit=4000, $max=0)
	{
		$this->cl->SetServer($this->host, $this->port);
		$this->cl->SetMatchMode($this->mode);
		$this->cl->SetLimits($offset, $limit, $max);
		$res = $this->cl->Query($searchQuery, $this->index);
		return $res;
	}

  
}

?>

