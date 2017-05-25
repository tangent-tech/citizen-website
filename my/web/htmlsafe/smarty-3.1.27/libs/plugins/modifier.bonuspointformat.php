<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifierCompiler
 */

function smarty_modifier_bonuspointformat($number) {
	
	return number_format(doubleval($number), 0, ".", ",");
	
}
