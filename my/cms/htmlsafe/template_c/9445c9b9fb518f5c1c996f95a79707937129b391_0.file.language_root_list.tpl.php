<?php
/* Smarty version 3.1.30, created on 2017-04-06 19:23:55
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/language_root_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e695cbd78082_86914064',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9445c9b9fb518f5c1c996f95a79707937129b391' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/language_root_list.tpl',
      1 => 1491504953,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58e695cbd78082_86914064 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<?php if (!in_array("acl_module_sitemap_show",$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
		<p>Sorry, there is not sitemap defined.</p>
	<?php } else { ?>
		<?php if (count($_smarty_tpl->tpl_vars['LanguageRootList']->value) == 0) {?>
			<p>No langauge is in use now.</p>
		<?php } else { ?>
			<table class="TopHeaderTable ui-helper-reset">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LanguageRootList']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
					<tr>
						<td class="AlignCenter" width="100"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['language_native'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						<td>
							<a href="language_tree.php?id=<?php echo $_smarty_tpl->tpl_vars['L']->value['language_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-gear"></span> Manage
							</a>
						</td>
					</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</table>
			
			<br />
			
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_enable'] == 'Y' && $_smarty_tpl->tpl_vars['Site']->value['site_friendly_link_version'] == 'structured') {?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_structure_seo_link_update_status'] == 'job_done') {?>
					<a href="site_update_structure_seo_link.php" class="ui-state-default ui-corner-all MyButton" onclick="confirm('Are you sure?')">
						<span class="ui-icon ui-icon-gear"></span> Update SEO Links
					</a>					
				<?php } else { ?>
					<p>Updating SEO Links... Please wait...</p>
				<?php }?>
			<?php }?>			
		<?php }?>
	<?php }?>


<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
