<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:04
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/_object_meta_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc606cf218_20430913',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '946b21d60a2a7b0e5906754ebf9d7a65410c9589' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/_object_meta_add.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7bc606cf218_20430913 (Smarty_Internal_Template $_smarty_tpl) {
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
