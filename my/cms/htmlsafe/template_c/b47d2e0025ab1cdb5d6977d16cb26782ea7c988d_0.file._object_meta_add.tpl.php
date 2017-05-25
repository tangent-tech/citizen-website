<?php
/* Smarty version 3.1.30, created on 2017-04-13 04:42:34
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/_object_meta_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ef01ba339e78_27495231',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b47d2e0025ab1cdb5d6977d16cb26782ea7c988d' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/_object_meta_add.tpl',
      1 => 1491504949,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ef01ba339e78_27495231 (Smarty_Internal_Template $_smarty_tpl) {
?>
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
							<tr>
								<th> Friendly URL </th>
								<td> <input type="text" name="object_friendly_url" value="" size="60" maxlength="255" /> </td>
							</tr>
						<?php }?>
						<tr>
							<th> Meta Title </th>
							<td> <input type="text" name="object_meta_title" value="" size="60" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Meta Description </th>
							<td> <textarea name="object_meta_description" cols="57" rows="4"></textarea> </td>
						</tr>
						<tr>
							<th> Meta Keywords </th>
							<td> <textarea name="object_meta_keywords" cols="57" rows="4"></textarea> </td>
						</tr>
					</table>
				</div>
<?php }
}
