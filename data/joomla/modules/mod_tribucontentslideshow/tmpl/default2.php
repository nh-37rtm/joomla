<?php 
/**
 * @package mod_tribucontentslideshow for Joomla! 3
 * @author Tribu And Co
 * @copyright (C) 2014 - Tribu And Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

$navLink = '';
?>


<div id="tcslider_<?php echo $module->id ?>" class="tcslider template2">
	<div class="tcslider_wrapper">
		<?php 
		$count = 0;
		foreach( $list as $key => $row ) { ?>
			<div id="c<?php echo $count+1 ?>" class="content content<?php echo $count+1 ?>">
				<?php if(!empty($row->image) ) { ?>
					<div class="img"><img class="imgIntro" src="<?php echo htmlspecialchars($row->image); ?>" alt="<?php echo htmlspecialchars($row->altImage); ?>" /></div>
				<?php } ?>
				<div class="description">
				<?php if($title_display) { 
				?>
					<<?php echo $item_heading; ?>><?php echo $row->title; ?></<?php echo $item_heading; ?>>
				<?php 
				} ?>
				<?php if( $display_intro ) {
					echo ($intro_plaintext) ? "<p>". $row->introtext."</p>" : $row->introtext; 
				} ?>
				</div>
				<?php if($display_btnreadmore) { ?>
					<div class="readmore"><a href="<?php echo $row->link;?>" class="btn"><?php echo JText::_('mod_tribucontentslideshow_READMORE'); ?></a></div>
				<?php } ?>
			</div>
			
			<?php
			$active = ($key == 0) ? ' active' : '';
			$navLink .= '<a class="buttons'.$active.'" href="#c'.(int)($key + 1).'">'.(int)($key + 1).'</a>';
			
			if($link_btnall!=0) {
				$categoryLink = JRoute::_('&Itemid='.$link_btnall);
			} else {
				$categoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catslug));
			}
			$count ++;
		} ?>
	</div>

	<div class="tc_controls">
		<div class="buttonsWrap">
			<div class="btn_controls">
				<?php if($display_btnall || ($display_btnall && $link_btnall!=0)) { ?>
					<a class="btn categoryLink" href="<?php echo $categoryLink; ?>"><?php echo JText::_('mod_tribucontentslideshow_BTNALL'); ?></a>
				<?php } ?>
				<?php if(( $count > 1 ) && $auto_play) { ?> <span><a class="control" href="#"><?php echo JText::_('mod_tribucontentslideshow_PLAY'); ?></a></span> <?php } ?>
			</div>
			
			<?php if($display_nav) { ?>
				<div class="nav"><?php echo $navLink; ?></div>
			<?php } ?>
		</div>
		<?php if($display_arrow) { ?>
			<div class="arrows"><a class="prev" href="#"><?php echo JText::_('mod_tribucontentslideshow_PREVIOUS'); ?></a><a class="next" href="#"><?php echo JText::_('mod_tribucontentslideshow_NEXT'); ?></a></div>
		<?php } ?>
	</div>
</div>