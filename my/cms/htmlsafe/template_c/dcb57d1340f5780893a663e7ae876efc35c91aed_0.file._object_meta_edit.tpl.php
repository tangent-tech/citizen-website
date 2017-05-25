<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:44
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/_object_meta_edit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc88365685_23728811',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcb57d1340f5780893a663e7ae876efc35c91aed' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/_object_meta_edit.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f7bc88365685_23728811 (Smarty_Internal_Template $_smarty_tpl) {
?>
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y') {?>
							<tr>
								<th> Friendly URL </th>
								<td> <input type="text" name="object_friendly_url" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_friendly_url'], ENT_QUOTES, 'UTF-8', true);?>
" maxlength="255" /> </td>
							</tr>
						<?php }?>
						<tr>
							<th> Meta Title </th>
							<td> <input type="text" name="object_meta_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_meta_title'], ENT_QUOTES, 'UTF-8', true);?>
" size="50" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Meta Description </th>
							<td> <textarea name="object_meta_description" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_meta_description'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
						</tr>
						<tr>
							<th> Meta Keywords </th>
							<td> <textarea name="object_meta_keywords" cols="48" rows="4"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['TheObject']->value['object_meta_keywords'], ENT_QUOTES, 'UTF-8', true);?>
</textarea> </td>
						</tr>
					</table>
				</div>
<?php }
}
