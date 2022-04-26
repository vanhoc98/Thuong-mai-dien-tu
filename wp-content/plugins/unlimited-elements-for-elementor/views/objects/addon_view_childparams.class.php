<?php
/**
 * @package Unlimited Elements
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');


class UniteCreatorAddonViewChildParams{
	
	
	/**
	 * create child param
	 */
	protected function createChildParam($param, $type = null, $addParams = false){
		
		$arr = array("name"=>$param, "type"=>$type);
		
		switch($type){
			case UniteCreatorDialogParam::PARAM_IMAGE:
				$arr["add_thumb"] = true;
				$arr["add_thumb_large"] = true;
			break;
		}
		
		if(!empty($addParams))
			$arr = array_merge($arr, $addParams);
		
		return($arr);
	}

	
	/**
	 * create child param
	 */
	protected function createChildParam_code($key, $text, $noslashes = false){
		
	    $arguments = array(
		    	"raw_insert_text" => $text, 
		    	"rawvisual"=>true,
	    	);		
		
	    if($noslashes == true)
	    	 $arguments["noslashes"] = true;
	    
	    	
	    $arr = $this->createChildParam($key, null, $arguments);		
		
		return($arr);
	}
	
	/**
	 * get code example php params
	 */
	protected function getCodeExamplesParams_php($arrParams){
		
			$key = "Run PHP Function (pro)";
			$text = "
			
{# This functionality exists only in the PRO version #}
{# run any wp action, and any custom PHP function. Use add_action to create the actions. \n The function support up to 3 custom params #}
\n
{{ do_action('some_action') }}
{{ do_action('some_action','param1','param2','param3') }}
";
		
			$arrParams[] = $this->createChildParam_code($key, $text);
		
			$key = "Data From PHP (pro)";
			$text = "
{# This functionality exists only in the PRO version #}			
{# apply any WordPress filters, and any custom PHP function. Use apply_filters to create the actions. \n The function support up to 2 custom params #}
\n
{% set myValue = apply_filters('my_filter') }}
{% set myValue = apply_filters('my_filter',value, param2, param3) }}

";
			$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		return($arrParams);
	}
	
	/**
	 * get post child params
	 */
	public function getChildParams_codeExamples(){
		
		$arrParams = array();
		
		//----- show data --------
		
		$key = "showData()";
		$text = "
{# This function will show all data in that you can use #} \n 
{{showData()}}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//---- show debug -----
		
		$key = "showDebug()";
		$text = "{# This function show you some debug (with post list for example) #} \n 
					{{showDebug()}}";
		
		//------ if empty ------
		
		$key = "IF Empty";
		$text = "
{% if some_attribute is empty %}
	<!-- put your empty case html -->   
{% else %} 
	<!-- put your not empty html here -->   
{% endif %}	
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- simple if ------
		
		$key = "IF";
		$text = "
{% if some_attribute == \"some_value\" %}
	<!-- put your html here -->   
{% endif %}	
";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//----- if else ------
		
		$key = "IF - Else";
		$text = "
{% if product_stock == 0 %}
	<!-- not available html -->   
{% else %}
	<!-- available html -->
{% endif %}
";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//----- complex if ------
		
		$key = "IF - Else - Elseif";
		$text = "
{% if product_stock == 0 %}
	<!-- put your 0 html here -->   
{% elseif product_stock > 0 and product_stock < 20 %}
	<!-- put your 0-20 html here -->   
{% elseif product_stock >= 20 %}
	<!-- put your >20 html here -->   
{% endif %}	
";

		$arrParams[] = $this->createChildParam_code($key, $text);


		//----- for in (loop) ------
		
		$key = "For In (loop)";
		$text = "
{% for product in woo_products %}
	
	<!-- use attributes inside the product, works if the product is array -->   
	<span> {{ product.title }} </span>
	<span> {{ product.price }} </span>
	
{% endif %}	
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- for in (loop) ------
		
		$key = "HTML Output - |raw";
		$text = "
{# use the raw filter for printing attribute with html tags#}
{{ some_attribute|raw }}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- default value ------
		
		$key = "Default Value";
		$text = "
{# use the default value filter in case that no default value provided (like in acf fields) #}
{{ cf_attribute|default('text in case that not defined') }}
";

		$arrParams[] = $this->createChildParam_code($key, $text);

		
		$arrParams = $this->getCodeExamplesParams_php($arrParams);
		
		
		return($arrParams);
	}
	

	/**
	 * get post child params
	 */
	public function getChildParams_codeExamplesJS(){
		
		$arrParams = array();
		
		//----- show data --------
		
		$key = "jQuery(document).ready()";
		$text = " 
jQuery(document).ready(function(){

	/* put your code here, a must wrapper for every jQuery enabled widget */

});
		";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		return($arrParams);
	}
	
	
	/**
	 * create category child params
	 */
	public function createChildParams_category($arrParams){
		
		$arrParams[] = $this->createChildParam("category_id");
		$arrParams[] = $this->createChildParam("category_name");
		$arrParams[] = $this->createChildParam("category_slug");
		$arrParams[] = $this->createChildParam("category_link");
		
		//create categories array foreach
		
		$strCode = "";
		$strCode .= "{% for cat in [param_prefix].categories %}\n";
										
		$strCode .= "	<span> {{cat.id}} , {{cat.name}} , {{cat.slug}} , {{cat.description}}, {{cat.link}} </span> <br>\n ";
		
		$strCode .= "{% endfor %}\n";


	    $arrParams[] = $this->createChildParam("categories", null, array("raw_insert_text" => $strCode));		
		
		
		return($arrParams);
	}
	
	/**
	 * add custom fields
	 */
	protected function addCustomFieldsParams($arrParams, $postID){
		
		if(empty($postID))
			return($arrParams);
		
		$isAcfExists = UniteCreatorAcfIntegrate::isAcfActive();
		
		$prefix = "cf_";
			
		//take from pods
		$isPodsExists = UniteCreatorPodsIntegrate::isPodsExists();
		
		$takeFromACF = true;
		if($isPodsExists == true){
			$arrMetaKeys = UniteFunctionsWPUC::getPostMetaKeys_PODS($postID);
			if(!empty($arrMetaKeys))
				$takeFromACF = false;
		}
		
		//take from toolset
		$isToolsetExists = UniteCreatorToolsetIntegrate::isToolsetExists();
		if($isToolsetExists == true){
			
			$objToolset = new UniteCreatorToolsetIntegrate();
			$arrMetaKeys = $objToolset->getPostFieldsKeys($postID);
			$takeFromACF = false;
		}
		
		
		//acf custom fields
		if($isAcfExists == true && $takeFromACF == true){
			
			$arrMetaKeys = UniteFunctionsWPUC::getAcfFieldsKeys($postID);
			$title = "acf field";
			
			if(empty($arrMetaKeys))
				return($arrParams);
			
			$firstKey = UniteFunctionsUC::getFirstNotEmptyKey($arrMetaKeys);
			
			foreach($arrMetaKeys as $key=>$type){
				
				//complex code (repeater) 
				
				if(is_array($type)){
					
					$strCode = "";
					$strCode .= "{% for item in [param_prefix].{$key} %}\n";
					
					$typeKeys = array_keys($type);
					
					foreach($typeKeys as $postItemKey){
												
						$strCode .= "<span> {{item.$postItemKey}} </span>\n";
					}
					
					$strCode .= "{% endfor %}\n";
					
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strCode));
					
				    continue;
				}
				
				//array code 
				
				if($type == "array"){
					
					$strCode = "";
					$strCode .= "{% for value in [param_prefix].{$key} %}\n";
					$strCode .= "<span> {{item}} </span>\n";
					$strCode .= "{% endfor %}\n";
					
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strCode));
					
					continue;
				}
				
				if($type == "empty_repeater"){
					
					$strText = "<!-- Please add some values to this field repeater in demo post in order to see the fields here -->";
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strText));
					
					continue;
				}
				
				//simple param
				
				$arrParams[] = $this->createChildParam($key);
			}
			
			
		}else{	//regular custom fields
			
			//should be $arrMetaKeys from pods
			
			if(empty($arrMetaKeys))
				$arrMetaKeys = UniteFunctionsWPUC::getPostMetaKeys($postID, "cf_");
							
			$title = "custom field";
			
			if(empty($arrMetaKeys))
				return($arrParams);
			
			$firstKey = $arrMetaKeys[0];
				
			foreach($arrMetaKeys as $key)
				$arrParams[] = $this->createChildParam($key);
			
		}
		
		
		//add functions
		$arrParams[] = $this->createChildParam("$title example with default",null,array("raw_insert_text"=>"{{ [param_prefix].$firstKey|default('default text') }}"));

		
		return($arrParams);
	}
	
	
	/**
	 * get post child params
	 */
	public function getChildParams_post($postID = null, $arrAdditions = array()){
		
				
		$arrParams = array();
		$arrParams[] = $this->createChildParam("id");
		$arrParams[] = $this->createChildParam("title",UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("alias");
		$arrParams[] = $this->createChildParam("content", UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("intro", UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("link");
		$arrParams[] = $this->createChildParam("image", UniteCreatorDialogParam::PARAM_IMAGE);
		$arrParams[] = $this->createChildParam("date",null,array("raw_insert_text"=>"{{[param_name]|date(\"d F Y, H:i\")}}"));
		$arrParams[] = $this->createChildParam("postdate",null,array("raw_insert_text"=>"{{putPostDate([param_prefix].id,\"d F Y, H:i\")}}"));
		$arrParams[] = $this->createChildParam("tagslist",null,array("raw_insert_text"=>"{{putPostTags([param_prefix].id)}}"));		
		//$arrParams[] = $this->createChildParam("tagslist",null,array("raw_insert_text"=>"{{putPostTags([param_prefix].id)}}"));
		
		
		//add post additions
		if(empty($arrAdditions))
			return($arrParams);
				
		foreach($arrAdditions as $addition){
			
			switch($addition){
				case GlobalsProviderUC::POST_ADDITION_CATEGORY:
					
					$arrParams = $this->createChildParams_category($arrParams);
					
				break;
				case GlobalsProviderUC::POST_ADDITION_CUSTOMFIELDS:
					
					if(!empty($postID))
						$arrParams = $this->addCustomFieldsParams($arrParams, $postID);
					
				break;
			}
		}
			
		
		return($arrParams);
	}
	
	
	/**
	 * get term code
	 */
	private function getTermCode($itemName, $parentName){
		
		$strCode = "";
		$strCode .= "{% for $itemName in $parentName %}\n";
		$strCode .= "\n";
		$strCode .= "	Term ID: {{{$itemName}.id}} <br>\n ";
		$strCode .= "	Name: {{{$itemName}.name|raw}} <br>\n ";
		$strCode .= "	Slug: {{{$itemName}.slug}} <br>\n ";
		$strCode .= "	Description: {{{$itemName}.description}} <br>\n ";
		$strCode .= "	Num posts: {{{$itemName}.num_posts}} <br>\n ";
		$strCode .= "	Is Current: {{{$itemName}.iscurrent}} <br>\n ";
		$strCode .= "	Selected Class: {{{$itemName}.class_selected}} <br>\n ";
		$strCode .= "	<hr>\n";
		$strCode .= "\n";
		
		$strCode .= "{% endfor %}\n";
		
		return($strCode);
	}
	
	/**
	 * get post child params
	 */
	public function getChildParams_terms(){

		$arrParams = array();
		
		$strCode = $this->getTermCode("term", "[parent_name]");
		
		$arrParams[] = $this->createChildParam_code("[parent_name]_output", $strCode);
		
				
		return($arrParams);
	}
	
	/**
	 * get post child params
	 */
	public function getChildParams_link(){

		$arrParams = array();
						
		$arrParams[] = $this->createChildParam(null);
		$arrParams[] = $this->createChildParam("html_attributes|raw");
		
				
		return($arrParams);
	}
	
}

