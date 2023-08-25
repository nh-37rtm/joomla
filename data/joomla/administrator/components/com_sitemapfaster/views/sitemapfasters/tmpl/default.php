<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_sitemapfaster&task=download'); ?>" method="post" name="download">
	<h2><input type="submit" value="<?php echo JText::_('COM_SITEMAPFASTER_DOWNLOAD_SITEMAP'); ?>"><span style="float:right"><?php echo JText::_('COM_SITEMAPFASTER_VISIT_WEBSITE'); ?><a href="http://www.actiaweb.com" TARGET="_blank">www.actiaweb.com</a></span></h2>
	<h3><?php echo JText::_('COM_SITEMAPFASTER_URL_DETECTED'); ?><?php echo  $this->pagination->get('total');?><span style="float:right"><?php echo JText::_('COM_SITEMAPFASTER_CASE_PROBLEM'); ?><a href="http://www.actiaweb.com/activ/contact-pour-creer-un-site-internet.html" TARGET="_blank">contact actiaweb</a></span></h3>
</form>
<form name="adminForm" id="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_sitemapfaster'); ?>">
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
		<input type="hidden" name="extension" value="<?php echo $extension;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="original_order_values" value="<?php echo implode($originalOrders, ','); ?>" />
		<?php echo JHtml::_('form.token'); ?>
</form>