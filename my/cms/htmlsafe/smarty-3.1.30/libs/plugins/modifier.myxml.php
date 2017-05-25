<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     myxml<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.nl2br.php
 *          nl2br (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_myxml($string)
{
	$ascii_table_replace = array();
	
	$ascii_table_replace[chr(1)] = '';  //Start of Heading
	$ascii_table_replace[chr(3)] = '';  //End of Text 
	$ascii_table_replace[chr(8)] = '';  //Backspace
	$ascii_table_replace[chr(11)] = ''; //Vertical Tabulation
	$ascii_table_replace[chr(20)] = ''; //Device Control 4
	$ascii_table_replace[chr(22)] = ''; //Synchronous Idle
	$ascii_table_replace[chr(28)] = ''; //File Separator
	$ascii_table_replace[chr(29)] = ''; //Group Separator
	$ascii_table_replace[chr(30)] = ''; //Record Separator
	$ascii_table_replace[chr(31)] = ''; //Unit Separator
	$ascii_table_replace['&'] = '&amp;';
	$ascii_table_replace['"'] = '&quot;';
	$ascii_table_replace["'"] = '&apos;';
	$ascii_table_replace['<'] = '&lt;';
	$ascii_table_replace['>'] = '&gt;';
	
	
	
	return str_replace (	array_keys($ascii_table_replace), 
							array_values($ascii_table_replace),
							$string );
	/*
   	return str_replace (	array ( chr(28), chr(29), chr(30), chr(31), chr(11), chr(3), chr(8), chr(1), '&', '"', "'", '<', '>' ), 
							array ( '', '', '', '', '', '', '', '', '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), 
							$string );
	 * 
	 */
}

/* vim: set expandtab: */

?>