<?php
/* Smarty version 3.1.30, created on 2017-04-07 05:19:07
  from "/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/site_setting_general.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58e7214b193615_51786421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8098f6e134e8f89f6af399364d164c2ba6d1d21' => 
    array (
      0 => '/var/www/apps/citizen/cms_citizen/htmlsafe/template/myadmin/1/site_setting_general.tpl',
      1 => 1491504958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/header_inner.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_2ndlevel.tpl' => 1,
    'file:myadmin/".((string)$_smarty_tpl->tpl_vars[\'CurrentLang\']->value[\'language_id\'])."/footer_inner.tpl' => 1,
  ),
),false)) {
function content_58e7214b193615_51786421 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/header_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<h1 class="PageTitle">Site Setting &nbsp; </h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Site Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_setting_general_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> Bonus Point Valid Days </th>
						<td> <input type="text" name="site_bonus_point_valid_days" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Site']->value['site_bonus_point_valid_days'], ENT_QUOTES, 'UTF-8', true);?>
" /> </td>
					</tr>
					<tr>
						<th> Site Default Language </th>
						<td>
							<select name="site_default_language_id">
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteLanguage']->value, 'L');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['L']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['L']->value['language_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['L']->value['language_id'] == $_smarty_tpl->tpl_vars['Site']->value['site_default_language_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['L']->value['language_native'], ENT_QUOTES, 'UTF-8', true);?>
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
						<th> Site Default Currency </th>
						<td>
							<select name="site_default_currency_id">
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteCurrency']->value, 'C');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['C']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['C']->value['currency_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['C']->value['currency_id'] == $_smarty_tpl->tpl_vars['Site']->value['site_default_currency_id']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['C']->value['currency_shortname'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

							</select>
						</td>
					</tr>
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y') {?>
						<tr>
							<th width='50%'>Cart price calculation <br /> <br /> (Will affect discount and final pay amount. Typically process cheaper products first will get a higher pay amount because discount will be applied to cheaper products first.)</th>
							<td>
								<select name="site_product_price_process_order">
									<option value="ASC" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_price_process_order'] == 'ASC') {?>selected="selected"<?php }?>>Process Cheaper Products First</option>
									<option value="DESC" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_product_price_process_order'] == 'DESC') {?>selected="selected"<?php }?>>Process More Expensive Products First</option>
								</select>								
							</td>
						</tr>
					<?php }?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['SiteFreightList']->value, 'F');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['F']->value) {
?>
						<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_freight_cost_calculation_id'] == 1) {?>
							<tr>
								<th> Freight Cost Calculation (<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_shortname;?>
) </th>
								<td>
									<select name="site_freight_1_free_min_total_price_def[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]">
										<option value="0" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_1_free_min_total_price_def == 0) {?>selected="selected"<?php }?>>Total Price before cash coupon (After discount) </option>
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_1_free_min_total_price_def == 1) {?>selected="selected"<?php }?>>Total Price after cash coupon (After discount) </option>
										<option value="2" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_1_free_min_total_price_def == 2) {?>selected="selected"<?php }?>>Total Product Price (Listed Price) </option>
									</select>
									Less than $<input size="4" type="text" name="site_freight_1_free_min_total_price[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['F']->value->site_freight_1_free_min_total_price, ENT_QUOTES, 'UTF-8', true);?>
" />, charge $<input  size="4" type="text" name="site_freight_1_cost[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['F']->value->site_freight_1_cost, ENT_QUOTES, 'UTF-8', true);?>
" />
								</td>
							</tr>
						<?php } elseif ($_smarty_tpl->tpl_vars['Site']->value['site_freight_cost_calculation_id'] == 2) {?>
							<tr>
								<th> Freight Cost Calculation </th>
								<td>
									Less than $-1 means the freight cost will always be applied. <br />

									<select name="site_freight_2_free_min_total_price_def[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]">
										<option value="0" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_free_min_total_price_def == 0) {?>selected="selected"<?php }?>>Total Price before cash coupon (After discount) </option>
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_free_min_total_price_def == 1) {?>selected="selected"<?php }?>>Total Price after cash coupon (After discount) </option>
										<option value="2" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_free_min_total_price_def == 2) {?>selected="selected"<?php }?>>Total Product Price (Listed Price) </option>
									</select>
									Less than $<input size="4" type="text" name="site_freight_2_free_min_total_price[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Site']->value['site_freight_2_free_min_total_price'], ENT_QUOTES, 'UTF-8', true);?>
" />,
									charge <input  size="4" type="text" name="site_freight_2_cost_percent[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Site']->value['site_freight_2_cost_percent'], ENT_QUOTES, 'UTF-8', true);?>
" />% of
									<select name="site_freight_2_total_base_price_def[<?php echo $_smarty_tpl->tpl_vars['F']->value->currency_id;?>
]">
										<option value="0" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_total_base_price_def == 0) {?>selected="selected"<?php }?>>Total Price before cash coupon (After discount) </option>
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_total_base_price_def == 1) {?>selected="selected"<?php }?>>Total Price after cash coupon (After discount) </option>
										<option value="2" <?php if ($_smarty_tpl->tpl_vars['F']->value->site_freight_2_total_base_price_def == 2) {?>selected="selected"<?php }?>>Total Product Price (Listed Price) </option>
									</select>
								</td>
							</tr>
						<?php }?>						
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
					
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_enable'] == 'Y') {?>
						<tr>
							<th> Inventory Stock Threshold Quantity </th>
							<td> <input type="text" name="site_product_stock_threshold_quantity" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Site']->value['site_product_stock_threshold_quantity'], ENT_QUOTES, 'UTF-8', true);?>
" /> </td>
						</tr>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y' && $_smarty_tpl->tpl_vars['Site']->value['site_invoice_enable'] == 'Y') {?>
						<tr>
							<th> Invoice Show Product Image? </th>
							<td>
								<input type="radio" name="site_invoice_show_product_image" value="Y" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_product_image'] != 'N') {?>checked=checked<?php }?> /> Yes
								<input type="radio" name="site_invoice_show_product_image" value="N" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_product_image'] == 'N') {?>checked=checked<?php }?> /> No
							</td>
						</tr>
						<tr>
							<th> Invoice Show Product Code? </th>
							<td>
								<input type="radio" name="site_invoice_show_product_code" value="Y" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_product_code'] != 'N') {?>checked=checked<?php }?> /> Yes
								<input type="radio" name="site_invoice_show_product_code" value="N" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_product_code'] == 'N') {?>checked=checked<?php }?> /> No
							</td>
						</tr>
						<tr>
							<th> Invoice Show Bonus Point? </th>
							<td>
								<input type="radio" name="site_invoice_show_bonus_point" value="Y" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_bonus_point'] != 'N') {?>checked=checked<?php }?> /> Yes
								<input type="radio" name="site_invoice_show_bonus_point" value="N" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_invoice_show_bonus_point'] == 'N') {?>checked=checked<?php }?> /> No
							</td>
						</tr>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_enable'] == 'Y' || $_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_partial_shipment'] == 'Y') {?>
						<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_enable'] == 'Y') {?>
							<tr>
								<th> Delivery Note Show Product Image? </th>
								<td>
									<input type="radio" name="site_dn_show_product_image" value="Y" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_show_product_image'] != 'N') {?>checked=checked<?php }?> /> Yes
									<input type="radio" name="site_dn_show_product_image" value="N" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_show_product_image'] == 'N') {?>checked=checked<?php }?> /> No
								</td>
							</tr>
							<tr>
								<th> Delivery Note Show Product Code? </th>
								<td>
									<input type="radio" name="site_dn_show_product_code" value="Y" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_show_product_code'] != 'N') {?>checked=checked<?php }?> /> Yes
									<input type="radio" name="site_dn_show_product_code" value="N" <?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_show_product_code'] == 'N') {?>checked=checked<?php }?> /> No
								</td>
							</tr>
						<?php }?>
					<?php }?>
				</table>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_order_enable'] == 'Y' && $_smarty_tpl->tpl_vars['Site']->value['site_invoice_enable'] == 'Y') {?>
					<table class="LeftHeaderTable">
						<tr>
							<th>Invoice Header</th>
							<td><?php echo $_smarty_tpl->tpl_vars['EditorInvoiceHeaderHTML']->value;?>
</td>
						</tr>
						<tr>
							<th>Invoice Footer</th>
							<td><?php echo $_smarty_tpl->tpl_vars['EditorInvoiceFooterHTML']->value;?>
</td>
						</tr>
						<tr>
							<th>Invoice Terms And Conditions</th>
							<td><?php echo $_smarty_tpl->tpl_vars['EditorInvoiceTNCHTML']->value;?>
</td>
						</tr>
					</table>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_enable'] == 'Y' || $_smarty_tpl->tpl_vars['Site']->value['site_module_inventory_partial_shipment'] == 'Y') {?>
					<?php if ($_smarty_tpl->tpl_vars['Site']->value['site_dn_enable'] == 'Y') {?>
						<table class="LeftHeaderTable">
							<tr>
								<th>Delivery Note Header</th>
								<td><?php echo $_smarty_tpl->tpl_vars['EditorDnHeaderHTML']->value;?>
</td>
							</tr>
							<tr>
								<th>Delivery Note Footer</th>
								<td><?php echo $_smarty_tpl->tpl_vars['EditorDnFooterHTML']->value;?>
</td>
							</tr>
							<tr>
								<th>Delivery Note Terms And Conditions</th>
								<td><?php echo $_smarty_tpl->tpl_vars['EditorDnTNCHTML']->value;?>
</td>
							</tr>
						</table>
					<?php }?>
				<?php }?>
			</div>
			<input type="hidden" name="site_id" value="<?php echo $_smarty_tpl->tpl_vars['Site']->value['site_id'];?>
" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_2ndlevel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php $_smarty_tpl->_subTemplateRender("file:myadmin/".((string)$_smarty_tpl->tpl_vars['CurrentLang']->value['language_id'])."/footer_inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
