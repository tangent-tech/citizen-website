{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{* include file='myadmin/header_site_setting_general.tpl' *}
<h1 class="PageTitle">Site Setting &nbsp; </h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Site Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="site_setting_general_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> Bonus Point Valid Days </th>
						<td> <input type="text" name="site_bonus_point_valid_days" value="{$Site.site_bonus_point_valid_days|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> Site Default Language </th>
						<td>
							<select name="site_default_language_id">
								{foreach from=$SiteLanguage item=L}
									<option value="{$L.language_id}" {if $L.language_id == $Site.site_default_language_id}selected="selected"{/if}>{$L.language_native|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th> Site Default Currency </th>
						<td>
							<select name="site_default_currency_id">
								{foreach from=$SiteCurrency item=C}
									<option value="{$C.currency_id}" {if $C.currency_id == $Site.site_default_currency_id}selected="selected"{/if}>{$C.currency_shortname|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					{if $Site.site_module_order_enable == 'Y'}
						<tr>
							<th width='50%'>Cart price calculation <br /> <br /> (Will affect discount and final pay amount. Typically process cheaper products first will get a higher pay amount because discount will be applied to cheaper products first.)</th>
							<td>
								<select name="site_product_price_process_order">
									<option value="ASC" {if $Site.site_product_price_process_order=='ASC'}selected="selected"{/if}>Process Cheaper Products First</option>
									<option value="DESC" {if $Site.site_product_price_process_order=='DESC'}selected="selected"{/if}>Process More Expensive Products First</option>
								</select>								
							</td>
						</tr>
					{/if}
					{foreach $SiteFreightList as $F}
						{if $Site.site_freight_cost_calculation_id == 1}
							<tr>
								<th> Freight Cost Calculation ({$F->currency_shortname}) </th>
								<td>
									<select name="site_freight_1_free_min_total_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_1_free_min_total_price_def==0}selected="selected"{/if}>Total Price before cash coupon (After discount) </option>
										<option value="1" {if $F->site_freight_1_free_min_total_price_def==1}selected="selected"{/if}>Total Price after cash coupon (After discount) </option>
										<option value="2" {if $F->site_freight_1_free_min_total_price_def==2}selected="selected"{/if}>Total Product Price (Listed Price) </option>
									</select>
									Less than $<input size="4" type="text" name="site_freight_1_free_min_total_price[{$F->currency_id}]" value="{$F->site_freight_1_free_min_total_price|escape:'html'}" />, charge $<input  size="4" type="text" name="site_freight_1_cost[{$F->currency_id}]" value="{$F->site_freight_1_cost|escape:'html'}" />
								</td>
							</tr>
						{else if $Site.site_freight_cost_calculation_id == 2}
							<tr>
								<th> Freight Cost Calculation </th>
								<td>
									Less than $-1 means the freight cost will always be applied. <br />

									<select name="site_freight_2_free_min_total_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_2_free_min_total_price_def==0}selected="selected"{/if}>Total Price before cash coupon (After discount) </option>
										<option value="1" {if $F->site_freight_2_free_min_total_price_def==1}selected="selected"{/if}>Total Price after cash coupon (After discount) </option>
										<option value="2" {if $F->site_freight_2_free_min_total_price_def==2}selected="selected"{/if}>Total Product Price (Listed Price) </option>
									</select>
									Less than $<input size="4" type="text" name="site_freight_2_free_min_total_price[{$F->currency_id}]" value="{$Site.site_freight_2_free_min_total_price|escape:'html'}" />,
									charge <input  size="4" type="text" name="site_freight_2_cost_percent[{$F->currency_id}]" value="{$Site.site_freight_2_cost_percent|escape:'html'}" />% of
									<select name="site_freight_2_total_base_price_def[{$F->currency_id}]">
										<option value="0" {if $F->site_freight_2_total_base_price_def==0}selected="selected"{/if}>Total Price before cash coupon (After discount) </option>
										<option value="1" {if $F->site_freight_2_total_base_price_def==1}selected="selected"{/if}>Total Price after cash coupon (After discount) </option>
										<option value="2" {if $F->site_freight_2_total_base_price_def==2}selected="selected"{/if}>Total Product Price (Listed Price) </option>
									</select>
								</td>
							</tr>
						{/if}						
					{/foreach}					
					{if $Site.site_module_inventory_enable == 'Y'}
						<tr>
							<th> Inventory Stock Threshold Quantity </th>
							<td> <input type="text" name="site_product_stock_threshold_quantity" value="{$Site.site_product_stock_threshold_quantity|escape:'html'}" /> </td>
						</tr>
					{/if}
					{if $Site.site_module_order_enable == 'Y' && $Site.site_invoice_enable == 'Y'}
						<tr>
							<th> Invoice Show Product Image? </th>
							<td>
								<input type="radio" name="site_invoice_show_product_image" value="Y" {if $Site.site_invoice_show_product_image != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_invoice_show_product_image" value="N" {if $Site.site_invoice_show_product_image == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Invoice Show Product Code? </th>
							<td>
								<input type="radio" name="site_invoice_show_product_code" value="Y" {if $Site.site_invoice_show_product_code != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_invoice_show_product_code" value="N" {if $Site.site_invoice_show_product_code == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
						<tr>
							<th> Invoice Show Bonus Point? </th>
							<td>
								<input type="radio" name="site_invoice_show_bonus_point" value="Y" {if $Site.site_invoice_show_bonus_point != 'N'}checked=checked{/if} /> Yes
								<input type="radio" name="site_invoice_show_bonus_point" value="N" {if $Site.site_invoice_show_bonus_point == 'N'}checked=checked{/if} /> No
							</td>
						</tr>
					{/if}
					{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
						{if $Site.site_dn_enable == 'Y'}
							<tr>
								<th> Delivery Note Show Product Image? </th>
								<td>
									<input type="radio" name="site_dn_show_product_image" value="Y" {if $Site.site_dn_show_product_image != 'N'}checked=checked{/if} /> Yes
									<input type="radio" name="site_dn_show_product_image" value="N" {if $Site.site_dn_show_product_image == 'N'}checked=checked{/if} /> No
								</td>
							</tr>
							<tr>
								<th> Delivery Note Show Product Code? </th>
								<td>
									<input type="radio" name="site_dn_show_product_code" value="Y" {if $Site.site_dn_show_product_code != 'N'}checked=checked{/if} /> Yes
									<input type="radio" name="site_dn_show_product_code" value="N" {if $Site.site_dn_show_product_code == 'N'}checked=checked{/if} /> No
								</td>
							</tr>
						{/if}
					{/if}
				</table>
				{if $Site.site_module_order_enable == 'Y' && $Site.site_invoice_enable == 'Y'}
					<table class="LeftHeaderTable">
						<tr>
							<th>Invoice Header</th>
							<td>{$EditorInvoiceHeaderHTML}</td>
						</tr>
						<tr>
							<th>Invoice Footer</th>
							<td>{$EditorInvoiceFooterHTML}</td>
						</tr>
						<tr>
							<th>Invoice Terms And Conditions</th>
							<td>{$EditorInvoiceTNCHTML}</td>
						</tr>
					</table>
				{/if}
				{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
					{if $Site.site_dn_enable == 'Y'}
						<table class="LeftHeaderTable">
							<tr>
								<th>Delivery Note Header</th>
								<td>{$EditorDnHeaderHTML}</td>
							</tr>
							<tr>
								<th>Delivery Note Footer</th>
								<td>{$EditorDnFooterHTML}</td>
							</tr>
							<tr>
								<th>Delivery Note Terms And Conditions</th>
								<td>{$EditorDnTNCHTML}</td>
							</tr>
						</table>
					{/if}
				{/if}
			</div>
			<input type="hidden" name="site_id" value="{$Site.site_id}" />
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
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
