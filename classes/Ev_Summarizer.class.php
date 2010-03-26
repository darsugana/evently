<?php
class Ev_Summarizer
{
	private $summarizer;

	public function __construct()
	{
		$this->summarizer = new Summarizer();
	}
	
	public function summarize($text)
	{
		$this->summarizer->reset_keywords();
		return $this->summarizer->summary($text);
	}
	
	public function getKeywords()
	{
		return $this->summarizer->get_keywords();
	}
	
	public function getUnstemmedKeywords()
	{
		$unstemmedWords = $this->summarizer->get_unstemmed_words();
		$keywords = $this->getKeywords();
		
		$retval = array();
		
		foreach ($keywords as $keyword => $count)
		{
			if (!isset($unstemmedWords[$keyword]))
			{
				$retval[$keyword] = $count;
			}
			else
			{
				$unstemmedKeyword = $this->getMostCommonElement($unstemmedWords[$keyword]);
				$retval[$unstemmedKeyword] = $count;
			}
		}
		return $retval;
	}
	
	private function getMostCommonElement($wordArray)
	{
		$wordFreqs = array();
		
		foreach ($wordArray as $word)
		{
			$wordFreqs[$word] = 0;
		}
		
		foreach ($wordArray as $word)
		{
			$wordFreqs[$word]++;
		}
		
		if (count($wordArray))
		{
			arsort($wordFreqs);
			foreach ($wordFreqs as $word => $count)
			{
				return $word;
			}
		}
		
	}
	
}