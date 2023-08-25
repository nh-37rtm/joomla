<?php
/**
 * @package mod_tribucontentslideshow for Joomla! 3
 * @author Tribu And Co
 * @copyright (C) 2014 - Tribu And Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
 
$list = modTribuSlideshowHelper::getList( $params );
modTribuSlideshowHelper::loadMediaFiles( $params, $module, $list );

$item_heading = $params->get('item_heading');
$title_display = $params->get('display_title', 1);
$display_intro = $params->get('display_intro', 1);
$intro_plaintext = (int)$params->get('intro_plaintext', 1 );
$display_introimg = $params->get('display_introimg', 1);
$display_btnall = $params->get('display_btnall', 0);
$link_btnall = $params->get('link_btnall');
$display_btnreadmore = $params->get('display_btnreadmore', 1);
$display_nav = $params->get('display_nav', 1);
$display_arrow = $params->get('display_arrow', 0);
$template = $params->get('template', 1);
$auto_play = $params->get('auto_play', 1);

if($template != 1)
	require( JModuleHelper::getLayoutPath( $module->module, 'default'.$template ) );
else
	require( JModuleHelper::getLayoutPath( $module->module ) );
?>
