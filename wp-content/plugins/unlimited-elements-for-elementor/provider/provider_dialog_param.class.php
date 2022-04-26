<?php
/**
 * @package Unlimited Elements
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');

class UniteCreatorDialogParam extends UniteCreatorDialogParamWork{
	
	
	/**
	 * modify param text, function for override
	 */
	protected function modifyParamText($paramType, $paramText){
		
		
		return($paramText);
	}
	
	
	
	/**
	 * filter main params
	 * function for override
	 */
	protected function filterMainParams($arrParams){
		
		return($arrParams);
	}
	
	
	/**
	 * init main params, add platform related param
	 */
	public function initMainParams(){
		
		parent::initMainParams();
		
		$this->arrParams[] = self::PARAM_POSTS_LIST;
		$this->arrParams[] = self::PARAM_POST_TERMS;
		
		$this->arrParams = $this->filterMainParams($this->arrParams);
		
	}
	
	
}