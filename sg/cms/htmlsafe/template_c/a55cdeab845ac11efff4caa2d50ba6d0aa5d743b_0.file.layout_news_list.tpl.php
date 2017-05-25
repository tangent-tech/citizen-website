<?php
/* Smarty version 3.1.30, created on 2017-03-25 03:41:17
  from "/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/layout_news_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58d5d8cd4e7d72_07173059',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a55cdeab845ac11efff4caa2d50ba6d0aa5d743b' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/template/myadmin/1/layout_news_list.tpl',
      1 => 1441542942,
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
function content_58d5d8cd4e7d72_07173059 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/Applications/XAMPP/xamppfiles/htdocs/citizen_hk/cms_citizen/htmlsafe/smarty-3.1.30/libs/plugins/modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_site_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<h1 class="PageTitle"><?php echo $_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['layout_news_root_name'];?>
 &nbsp;

	<?php if ($_smarty_tpl->tpl_vars['IsContentAdmin']->value && $_smarty_tpl->tpl_vars['Site']->value['site_module_workflow_enable'] == 'Y') {?>
		<a class="ui-state-default ui-corner-all MyButton" href="layout_news_root_permission_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['layout_news_root_id'];?>
">
			<span class="ui-icon ui-icon-locked"></span> Permission
		</a>
	<?php }?>
	<a href="layout_news_category_list.php?language_id=<?php echo $_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['language_id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Category List</a>
	<a href="?id=<?php echo $_REQUEST['id'];?>
" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowrefresh-1-s"></span> Reset Filter
	</a>
	<form name="FrmSetPageID" id="FrmSetPageID" method="post">
		Page:
		<select id="page_id" name="page_id" onchange="submit()">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['PageNoSelection']->value, 'P');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['P']->value) {
?>
			    <option value="<?php echo $_smarty_tpl->tpl_vars['P']->value;?>
"
					<?php if ($_smarty_tpl->tpl_vars['P']->value == $_REQUEST['page_id']) {?>selected="selected"<?php }?>
			    ><?php echo $_smarty_tpl->tpl_vars['P']->value;?>
</option>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</select>
		<input type="hidden" name="layout_news_id" value="<?php echo $_REQUEST['layout_news_id'];?>
" />
		<input type="hidden" name="layout_news_date" value="<?php echo $_REQUEST['layout_news_date'];?>
" />
		<input type="hidden" name="layout_news_title" value="<?php echo $_REQUEST['layout_news_title'];?>
" />
		<input type="hidden" name="layout_news_category_id" value="<?php echo $_REQUEST['layout_news_category_id'];?>
" />
		<input type="hidden" name="layout_news_tag" value="<?php echo $_REQUEST['layout_news_tag'];?>
" />
	</form>
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<table class="TopHeaderTable ui-helper-reset">
		<tr class="ui-state-highlight">
			<th width="50">ID</th>
			<th width="120">Date</th>
			<th>Title</th>
			<th>Category</th>
			<th>Tag</th>
			<th width="150">Action</th>
		</tr>
		<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
			<tr class="AlignCenter">
				<td><input type="text" name="layout_news_id" size="3" value="<?php echo $_REQUEST['layout_news_id'];?>
" /></td>
				<td><input type="text" name="layout_news_date" class="DatePicker" value="<?php echo $_REQUEST['layout_news_date'];?>
" /></td>
				<td><input type="text" name="layout_news_title" value="<?php echo $_REQUEST['layout_news_title'];?>
" /></td>
				<td>
					<select id="layout_news_category_id" name="layout_news_category_id">
						<option value="0" <?php if ($_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'] == 0) {?>selected="selected"<?php }?>>Any</option>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsCategories']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
						    <option value="<?php echo $_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'];?>
"
								<?php if ($_smarty_tpl->tpl_vars['C']->value['layout_news_category_id'] == $_REQUEST['layout_news_category_id']) {?>selected="selected"<?php }?>
						    ><?php echo $_smarty_tpl->tpl_vars['C']->value['layout_news_category_name'];?>
</option>						
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</select>
				</td>
				<td><input type="text" name="layout_news_tag" size="20" value="<?php echo $_REQUEST['layout_news_tag'];?>
" /></td>
				<td>
					<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>
" />
					<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
						<span class="ui-icon ui-icon-search"></span> Filter
					</a>
				</td>
			</tr>
		</form>		
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LayoutNewsList']->value, 'R');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['R']->value) {
?>
			<tr class="<?php if ($_smarty_tpl->tpl_vars['R']->value['object_is_enable'] == 'N') {?>DisabledRow<?php }?>">
				<td class="AlignCenter"><?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_id'];?>
</td>
				<td class="AlignCenter"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['R']->value['layout_news_date'],'%Y-%m-%d %H:%M');?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_title'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_category_name'];?>
</td>
				<td><?php echo substr($_smarty_tpl->tpl_vars['R']->value['layout_news_tag'],2,-2);?>
</td>
				<td class="AlignCenter">
					<a href="layout_news_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_id'];?>
" class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-pencil"></span> edit
					</a>
					<a href="layout_news_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['R']->value['layout_news_id'];?>
" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
						<span class="ui-icon ui-icon-trash"></span> delete
					</a>
				</td>
			</tr>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</table>
	<a href="layout_news_add.php?id=<?php echo $_REQUEST['id'];?>
" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-circle-plus"></span>Add <?php echo $_smarty_tpl->tpl_vars['LayoutNewsRoot']->value['layout_news_root_name'];?>
</a>
</div>
<br class="clearfloat" />
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
