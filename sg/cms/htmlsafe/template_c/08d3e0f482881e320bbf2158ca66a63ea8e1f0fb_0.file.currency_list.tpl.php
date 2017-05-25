<?php
/* Smarty version 3.1.30, created on 2017-04-07 05:19:09
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/currency_list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e7214d745f35_44239727',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '08d3e0f482881e320bbf2158ca66a63ea8e1f0fb' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/currency_list.tpl',
      1 => 1491504950,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_currency.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58e7214d745f35_44239727 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_currency.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Currency In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<p>* Please set the base currency rate to 1 (i.e. The currency you enter for the product price.)</p>

			<?php if (count($_smarty_tpl->tpl_vars['SiteCurrencyList']->value) == 0) {?>
				<p>No currency is in use now.</p>
			<?php } else { ?>
				<table class="TopHeaderTable ui-helper-reset">
					<tr>
						<th>Currency Name</th>
						<th>Rate</th>
						<th></th>
					</tr>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteCurrencyList']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
						<tr>
							<td class="AlignCenter" width="300"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['currency_longname'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['currency_shortname'], ENT_QUOTES, 'UTF-8', true);?>
)</td>
							<td class="AlignCenter" width="100"><?php echo $_smarty_tpl->tpl_vars['C']->value['currency_site_rate'];?>
</td>
							<td>
								<a href="currency_edit.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['currency_id'];?>
" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> Edit
								</a>
								<a href="currency_delete.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['currency_id'];?>
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
			<?php }?>
			<br class="clearfloat" />
		</div>
	</div>
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Currency Not In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteCurrencyListNotEnabled']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
					<tr>
						<td class="AlignCenter" width="300"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['currency_longname'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['currency_shortname'], ENT_QUOTES, 'UTF-8', true);?>
)</td>
						<td>
							<a href="currency_add.php?id=<?php echo $_smarty_tpl->tpl_vars['C']->value['currency_id'];?>
" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> Add
							</a>
						</td>
					</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</table>
			<br class="clearfloat" />
		</div>
	</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
