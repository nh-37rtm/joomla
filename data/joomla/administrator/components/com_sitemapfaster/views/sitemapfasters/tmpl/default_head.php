<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JToolBarHelper::title(JText::_('COM_SITEMAPFASTER'));
JToolBarHelper::custom('download', 'new.png', 'new.png',JText::_('COM_SITEMAPFASTER_DOWNLOAD_SITEMAP'), false);
?>

<tr>                 
    <th>
        <h3><?php echo JText::_('COM_SITEMAPFASTER_URL'); ?><h3>
    </th>
</tr>