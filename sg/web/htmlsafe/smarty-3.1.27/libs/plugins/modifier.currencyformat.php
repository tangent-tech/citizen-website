<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */

function smarty_modifier_currencyformat($number) {
	
	return number_format(doubleval($number), 0, ".", ",");
	
}
