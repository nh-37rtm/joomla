<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import joomla controller library
jimport('joomla.application.component.controller'); 

// For compatibility with older versions of Joola 2.5
if (!class_exists('JControllerLegacy')){
    class JControllerLegacy extends JController {

    }
}
// Get an instance of the controller prefixed by sitemapfaster
$controller = JControllerLegacy::getInstance('sitemapfaster'); 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));  
// Redirect if set by the controller
$controller->redirect();