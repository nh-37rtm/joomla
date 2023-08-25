<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
	$inc = 1;
	foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $inc; ?>
                </td>
                <!--td>
                        <?php //echo JHtml::_('grid.id', $i, $item->id); ?>
                        <?php //echo JHtml::_('grid.id', $i, $i); ?>
                </td-->
                <td>
                        <?php echo $item->url; ?>
                </td>
        </tr>
		<?php $inc++ ?>
<?php endforeach; ?>