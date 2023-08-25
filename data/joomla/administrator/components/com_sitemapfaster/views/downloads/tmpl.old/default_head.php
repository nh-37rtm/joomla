<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JToolBarHelper::title(JText::_('COM_SITEMAPFASTER'));
?>
<!--form action="/administrator/index.php?option=com_sitemapfaster&task=download" method="post" name="adminForm"-->
<tr>
        <th width="5">
                <?php echo JText::_('COM_SITEMAPFASTER_NUM'); ?>
        </th>
        <!--th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php // echo count($this->items); ?>);" />
        </th-->                   
        <th>
                <?php echo JText::_('COM_SITEMAPFASTER_URL'); ?>
        </th>
</tr>