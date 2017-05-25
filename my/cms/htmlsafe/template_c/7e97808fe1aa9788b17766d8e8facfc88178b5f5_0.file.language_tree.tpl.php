<?php
/* Smarty version 3.1.30, created on 2017-04-07 05:18:20
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/language_tree.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e7211cb2a0d9_02534577',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7e97808fe1aa9788b17766d8e8facfc88178b5f5' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/language_tree.tpl',
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
function content_58e7211cb2a0d9_02534577 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<div id="DialogSelectAlbum">
		<p>Select album to add:</p>
		<select name="SelectAlbum">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Albums']->value, 'A');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['A']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['A']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['A']->value['object_name'];?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
	</div>
	<div id="DialogSelectProductRoot">
		<p>Select product tree to add:</p>
		<select name="SelectProductRoot">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ProductRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['R']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['R']->value['object_name'];?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
	</div>
	<div id="DialogSelectNewsRoot">
		<p>Select news tree to add:</p>
		<select name="SelectNewsRoot">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['NewsRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['R']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['R']->value['news_root_name'];?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
	</div>
	<div id="DialogSelectLayoutNewsRoot">
		<p>Select layout news tree to add:</p>
		<select name="SelectLayoutNewsRoot">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['R']->value['object_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_root_name'];?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
	</div>
	<div class="InnerContainer ui-widget ui-corner-all">
<!--
		<a class="ui-state-default ui-corner-all MyButton" href="#" id="BtnCloseAllNode">
			<span class="ui-icon ui-icon-minusthick"></span> Close All
		</a>
		<a class="ui-state-default ui-corner-all MyButton" href="#" id="BtnOpenAllNode">
			<span class="ui-icon ui-icon-plusthick"></span> Open All
		</a>
		<br />
		<br />
-->
		<div id="SITE_ROOT">
			<ul>
				<li rel="SITE_ROOT" id="OL_0" data-object_type="SITE_ROOT" data-object_link_id="0" data-object_id="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_root_id'];?>
" data-object_system_flag="system"><a href="#"><ins>&nbsp;</ins>Site</a>
					<ul>
						<li rel="<?php if ($_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_link_is_enable'] == 'Y') {?>ENABLE_<?php } else { ?>DISABLE_<?php }
echo $_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_type'];?>
" id="OL_<?php echo $_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_link_id'];?>
" data-object_type="LANGUAGE_ROOT" data-object_link_id="<?php echo $_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_link_id'];?>
" data-object_id="<?php echo $_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_id'];?>
" data-object_system_flag="<?php echo $_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_system_flag'];?>
"><a href="#"><ins>&nbsp;</ins><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['SiteLanguageRoot']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
							<?php echo $_smarty_tpl->tpl_vars['LanguageRootHTML']->value;?>


						</li>

						</li>
					</ul>
				</li>
			</ul>
		</div>
		<br class="clearfloat" />
	</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
