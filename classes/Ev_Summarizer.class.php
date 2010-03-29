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
				if ($this->isKeywordValid($keyword))
				{
					$retval[$keyword] = $count;
				}
			}
			else
			{
				$unstemmedKeyword = $this->getMostCommonElement($unstemmedWords[$keyword]);
				if ($this->isKeywordValid($unstemmedKeyword))
				{
					$retval[$unstemmedKeyword] = $count;
				}
			}
		}
		return $retval;
	}
	
	private function isKeywordValid($keyword)
	{
	
		$disallowedKeywords = array(
			'jan' => true,
			'january' => true,
			'feb' => true,
			'february' => true,
			'mar' => true,
			'march' => true,
			'apr' => true,
			'april' => true,
			'may' => true,
			'jun' => true,
			'june' => true,
			'jul' => true,
			'july' => true,
			'aug' => true,
			'august' => true,
			'sept' => true,
			'september' => true,
			'oct' => true,
			'october' => true,
			'nov' => true,
			'november' => true,
			'dec' => true,
			'december' => true,
			);
		
		if (strlen($keyword) < 4)
		{
			return false;
		}
		
		if (strpos($keyword, 'http') === 0)
		{
			return false;
		}

		if (strpos($keyword, '.com') !== FALSE)
		{
			return false;
		}
		
		if (isset($disallowedKeywords[$keyword]))
		{
			return false;
		}
		return true;
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