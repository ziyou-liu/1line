<?php
/**
* @package   yoo_katana
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get application
$app = JFactory::getApplication();

// get item id
$itemid = intval($params->get('set_itemid', 0));

?>

<form id="search-<?php echo $module->id; ?>" class="uk-search" action="<?php echo JRoute::_('index.php'); ?>" method="post" role="search">
	<input class="uk-search-field" type="search" name="searchword" placeholder="<?php echo JText::_('TPL_WARP_SEARCH'); ?>" autocomplete="off">
	<input type="hidden" name="task"   value="search">
	<input type="hidden" name="option" value="com_search">
	<input type="hidden" name="Itemid" value="<?php echo $itemid > 0 ? $itemid : $app->input->getInt('Itemid'); ?>">
</form>