<?php

/**
* This is the starter class for Tag_Collection_Generated.
 *
 * @see Tag_Collection_Generated, CoughCollection
 **/
class Tag_Collection extends Tag_Collection_Generated {

	static $tagArray = null;

	public static function loadTagArray()
	{
	
		$tags = new Tag_Collection();
		$tags->load();

		$tagIds = array();

		$tagsByTag = array();

		foreach ($tags as $tag)
		{
			$tagsByTag[$tag->getName()] = $tag;
		}
		
		return $tagsByTag;
		
	}

	public static function getTagArray()
	{
		if (is_null(self::$tagArray))
		{
			self::$tagArray = self::loadTagArray();
		}
		return self::$tagArray;
	}

	public static function addTagToTagArrray($tagName)
	{
		$newTag = new Tag();
		$newTag->setName($tagName);
		$newTag->save();
		
		$tagArray = self::getTagArray();
		
		self::$tagArray[$tagName] = $newTag;
		return $newTag;
	}


	public static function hasTagByName($tagName)
	{
		return array_key_exists($tagName, self::getTagArray());
	}

	public static function getTagByName($tagName, $construct)
	{
		if (self::hasTagByName($tagName))
		{
			$tagArray = self::getTagArray();
			return $tagArray[$tagName];
		}
		else if ($construct)
		{
			return self::addTagToTagArrray($tagName);
		}
		
		
		return false;
	}


}


?>