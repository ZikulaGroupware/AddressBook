<?php

/**
 * @copyright (c) 2011, Fabian Wuertz
 * @author Fabian Wuertz
 * @link http://fabian.wuertz.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package ISHAsections
 */

/**
 * Smarty function to show a remove link in admin tables
 *
 * Example
 *
 *   {remove module='MyModule' func='remove' id='1'}
 *
 * @since        18 February 2011
 * @return       string the atom ID
 */
function smarty_function_remove($params, &$smarty)
{
	$smarty->assign($params);
	return $smarty->fetch('plugins/remove.tpl');
}