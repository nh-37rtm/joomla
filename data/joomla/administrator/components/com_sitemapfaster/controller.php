<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import Joomla controller library
jimport('joomla.application.component.controller');
/** 
* Sitemap Faster Component Controller 
*/
class SitemapFasterController extends JControllerLegacy
{        
	/**         
	* display task         
	*         
	* @return void         
	*/        
	function display($cachable = false, $urlparams = false)         
	{                
		// set default view if not set                
		$input = JFactory::getApplication()->input;                
		$input->set('view', $input->getCmd('view', 'SitemapFasters'));                
		// call parent behavior                
		parent::display($cachable);        
	}   		

	function download($cachable = false, $urlparams = false)
	{                
		$input = JFactory::getApplication()->input;                
		$input->set('view', $input->getCmd('view', 'Downloads'));				
		// call parent behavior                
		parent::display($cachable);		
	}
}