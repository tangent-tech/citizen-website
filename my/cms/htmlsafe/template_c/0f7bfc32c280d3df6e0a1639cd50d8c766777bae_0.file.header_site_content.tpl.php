<?php
/* Smarty version 3.1.30, created on 2017-04-19 16:40:25
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/header_site_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f792f96c8864_77909893',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f7bfc32c280d3df6e0a1639cd50d8c766777bae' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/header_site_content.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58f792f96c8864_77909893 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<div class="ui-tabs ui-widget ui-corner-all ContentContainer">
		<ul id="Menu2ndLevel" class="menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_article_enable'] == 'Y' && in_array('acl_module_sitemap_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'language_root') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="language_root_list.php">Sitemap</a></li>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'siteblock') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="siteblock.php">Site Block</a></li>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_album_enable'] == 'Y' && in_array('acl_module_album_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'album') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="album_list.php">Album</a></li>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_news_enable'] == 'Y' && in_array('acl_module_news_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>

				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['AllNewsRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
					<li class="ui-state-default ui-corner-top 
						<?php if ($_smarty_tpl->tpl_vars['CurrentNewsRootID']->value == $_smarty_tpl->tpl_vars['R']->value['news_root_id'] || $_smarty_tpl->tpl_vars['CurrentTab2']->value == 'news') {?>ui-tabs-selected ui-state-active<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'news_category' && $_smarty_tpl->tpl_vars['R']->value['language_id'] == $_REQUEST['language_id']) {?>ui-tabs-selected ui-state-active<?php }?>
						"
					>
						<a href="news_list.php?id=<?php echo $_smarty_tpl->tpl_vars['R']->value['news_root_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['R']->value['news_root_name'];?>
</a>
					</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_layout_news_enable'] == 'Y' && in_array('acl_module_layout_news_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>

				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['AllLayoutNewsRoots']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
					<li class="ui-state-default ui-corner-top 
						<?php if ($_smarty_tpl->tpl_vars['CurrentLayoutNewsRootID']->value == $_smarty_tpl->tpl_vars['R']->value['layout_news_root_id'] || $_smarty_tpl->tpl_vars['CurrentTab2']->value == 'news') {?>ui-tabs-selected ui-state-active<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'layout_news_category' && $_smarty_tpl->tpl_vars['R']->value['language_id'] == $_REQUEST['language_id']) {?>ui-tabs-selected ui-state-active<?php }?>
						"
					>
						<a href="layout_news_list.php?id=<?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_root_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_root_name'];?>
</a>
					</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_product_enable'] == 'Y' && in_array('acl_module_product_show',$_smarty_tpl->tpl_vars['EffectiveACL']->value)) {?>
				<li class="ui-state-default ui-corner-top <?php if ($_smarty_tpl->tpl_vars['CurrentTab2']->value == 'product') {?>ui-tabs-selected ui-state-active<?php }?>"><a href="product_tree.php"><?php echo ucwords($_smarty_tpl->tpl_vars['Site']->value['site_label_product']);?>
</a></li>
			<?php }?>
		</ul>
		<div class="ui-tabs-panel ui-widget-content ui-corner-bottom Content">
<?php }
}
