<?php
/**
 * @package Unlimited Elements
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');


class UniteCreatorCategories extends UniteCreatorCategoriesWork{
	
	
	/**
	 * modify category title before create
	 * function for override
	 */
	protected function modifyCatTitleBeforeCreate($title){
		
		$title = str_replace("Article", "Post", $title);
		
		$title = str_replace("article", "post", $title);
		
		return($title);
	}
	
	
}