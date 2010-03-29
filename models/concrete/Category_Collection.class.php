<?php

/**
* This is the starter class for Category_Collection_Generated.
 *
 * @see Category_Collection_Generated, CoughCollection
 **/
class Category_Collection extends Category_Collection_Generated {
	
	static $categoryArray = null;

	public static function loadCategoryArray()
	{
	
		$categories = new Category_Collection();
		$categories->load();

		$categoriesById = array();

		foreach ($categories as $category)
		{
			$categoriesById[$category->getCategoryId()] = $category;
		}
		
		return $categoriesById;
		
	}

	public static function getCategoryArray()
	{
		if (is_null(self::$categoryArray))
		{
			self::$categoryArray = self::loadCategoryArray();
		}
		return self::$categoryArray;
	}

	
}

?>