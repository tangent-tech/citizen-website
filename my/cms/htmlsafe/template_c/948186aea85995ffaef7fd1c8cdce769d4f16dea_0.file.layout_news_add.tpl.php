<?php
/* Smarty version 3.1.30, created on 2017-04-19 19:37:04
  from "/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58f7bc606a06c5_18564557',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '948186aea85995ffaef7fd1c8cdce769d4f16dea' => 
    array (
      0 => '/var/www/apps/citizen/my/cms/htmlsafe/template/myadmin/1/layout_news_add.tpl',
      1 => 1492617058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_site_content.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/_object_meta_add.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58f7bc606a06c5_18564557 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_select_time')) require_once '/var/www/apps/citizen/my/cms/htmlsafe/smarty-3.1.30/libs/plugins/function.html_select_time.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle">Add <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['layout_news_root_name'], ENT_QUOTES, 'UTF-8', true);?>
 &nbsp;
	<a href="layout_news_list.php?id=<?php echo $_REQUEST['id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['layout_news_root_name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_news_add_act.php">
		<div id="LayoutNewsTabs">
			<ul>
				<li><a href="#LayoutNewsTabsPanel-News">Details</a></li>
				<li><a href="#LayoutNewsTabsPanel-SEO">SEO</a></li>
			</ul>
			<div id="LayoutNewsTabsPanel-News">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Security Level </th>
							<td> <input type="text" name="object_security_level" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_default_security_level'];?>
" size="6" /> </td>
						</tr>
						<tr>
							<th>Date</th>
							<td><input type="text" name="layout_news_date" class="DatePicker" value="<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
" size="10" /> <?php echo smarty_function_html_select_time(array('use_24_hours'=>true,'display_seconds'=>false),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<th>Category</th>
							<td>
								<select name="layout_news_category_id">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsCategories']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
									    <option value="<?php echo $_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['layout_news_category_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
						<tr>
							<th>Title</th>
							<td><input type="text" name="layout_news_title" value="Untitled News" size="80" /></td>
						</tr>
						<tr>
							<th>Tag</th>
							<td><input type="text" name="layout_news_tag" value="" size="80" /></td>
						</tr>
						<tr>
							<th>Layout </th>
							<td>
								<select name="layout_id">
									<option value="0" selected="selected"> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Layouts']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['L']->value['layout_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['layout_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
						<tr>
							<th> Album </th>
							<td>
								<select name="album_id">
									<option value="0" selected="selected"> - </option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['Albums']->value, 'A');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['A']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['A']->value['album_id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['A']->value['object_name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="LayoutNewsTabsPanel-SEO">
				<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/_object_meta_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

			</div>
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
			<div class="ui-widget-header ui-corner-bottom InnerHeader">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="SummaryEditor ContentEditor">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>
<br class="clearfloat" />
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
