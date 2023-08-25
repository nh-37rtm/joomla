<?php
/**
 * @package mod_tribucontentslideshow for Joomla! 3
 * @author Tribu And Co
 * @copyright (C) 2014 - Tribu And Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
 
class modTribuSlideshowHelper
{
	
	/**
	* get list of articles follow conditions user selected
	*/ 
	public static function getList(&$params)
	{
		$imgHeight				= (int)$params->get( 'img_height', 300 );
		$imgWidth				= (int)$params->get( 'img_width', 650 );
		$ordering				= $params->get('ordering', 'publish_up-desc');
		$display_introimg 		= (int)$params->get('display_introimg', 1);
		$resize_introimg		= (int)$params->get('resize_introimg', 1 );
		$cropped 				= (int)$params->get('cropped_introimg', 1 );
		$intro_plaintext 		= (int)$params->get('intro_plaintext', 1 );
		$intro_plaintext_lenght = (int)$params->get('intro_plaintext_lenght', 100 );
		$title_lenght = (int)$params->get('title_lenght', 50 );
		
		// Include resize image file
		if ($resize_introimg) {
			$includeOK = true;
			if (!class_exists('TribuHelper')) {
				$app = JFactory::getApplication();
				$fileTribuHelper = JPATH_THEMES . '/' . $app->getTemplate() . '/helpers/tribu.php' ;
				if(file_exists($fileTribuHelper))	
					include $fileTribuHelper;
				else
					$includeOK = false;
				if(!$includeOK) $includeOK = include JPATH_SITE. '/media/mod_tribucontentslideshow/tribu.php' ;
			}
		}
		
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
	   
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('limit_items', 5));
		$model->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
	   
		// Category filter
		$model->setState('filter.category_id', $params->get('category', array()));

		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());

		// Set ordering
		$ordering = explode( '-', $ordering );

		if( trim($ordering[0]) == 'rand' ){
			$model->setState('list.ordering', ' RAND() '); 
		}
		else {
			$model->setState('list.ordering', 'a.'.$ordering[0]);
			$model->setState('list.direction', $ordering[1]);
		} 
		
		$items = $model->getItems();
		
		foreach($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;
		   
			$item->urls = json_decode( $item->urls );
		  
			if (!empty($item->urls->urla))
			{
				$item->link = JRoute::_($item->urls->urla);
			}
			elseif ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			}
			else {
				$item->link = JRoute::_('index.php?option=com_user&view=login');
			}
			
			// title
			$item->title = JHTML::_('string.truncate', $item->title, $title_lenght);
			
			// introtext
			if($intro_plaintext) {
				$item->introtext = strip_tags($item->introtext);
				$item->introtext = JHTML::_('string.truncate', $item->introtext, $intro_plaintext_lenght);
			}
			
			// Get image
			if($display_introimg) {
				$item->images = json_decode( $item->images );
				if(!is_null($item->images)) {
					$item->image = htmlspecialchars($item->images->image_intro);
					if ( !empty($item->image) ) {
						$item->altImage = htmlspecialchars($item->images->image_intro_alt);
						$item->titleImage = htmlspecialchars($item->images->image_intro_caption);
						
						// Resize and cropped image
						if ($resize_introimg) {
							if($includeOK){
								$cropped = ($cropped == 1) ? true : false;
								$thumb = TribuHelper::getThumb($item->image,$imgWidth,$imgHeight,$cropped);
								if ($thumb) $item->image = $thumb;
							}
						}
					 }
				} else {
					$item->image = $item->altImage = $item->titleImage = null;
				}
			}

		}
		
		return $items;
	}
	
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public static function loadMediaFiles( $params, $module, $list ){
		$document = &JFactory::getDocument();
		//$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
		$document->addScript( JURI::root(true). '/media/'.$module->module.'/js/tribuslider.js' );
		$document->addStyleSheet( JURI::root(true). '/media/'.$module->module.'/css/tribuslider.css' );
		
		$container = '#tcslider_'.$module->id;
		$js = "
		jQuery(document).ready(function(){
			
			jQuery('".$container."').tribuSlider({
				content : '.content',		// The panel selector. Can be a list also. eg:li
				width : ".(int)$params->get( 'module_width', 600 ).",			// Width of the slider
				height : ".(int)$params->get( 'module_height', 300 ).",			// Height of the slider
				autoplay : ".$params->get( 'auto_play', true ).",				// Autoplay the slider. Values, true & false
				delay : ".$params->get( 'interval', 5 ).",						// Transition Delay. Default 5s
				playText : '".JText::_('mod_tribucontentslideshow_PLAY')."',
				pauseText : '".JText::_('mod_tribucontentslideshow_PAUSE')."',
				direction : '".$params->get( 'direction', 'horizontal' )."',	// Direction of the slider.
				mouseoverButtons : ".$params->get( 'buttons_mouseover', 0 )."   // Display buttons only when mouseover
			});
		});
		";
		$document->addScriptDeclaration( $js );
	}
}
?>