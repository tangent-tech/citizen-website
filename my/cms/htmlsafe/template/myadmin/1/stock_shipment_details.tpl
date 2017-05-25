{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">Shipment Details &nbsp;
	<a onclick="return confirm('WARNING! \n Are you sure you want to delete?')" class="ui-state-default ui-corner-all MyButton" href="stock_shipment_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> Delete
	</a>
	{if $Site.site_dn_enable == 'Y'}
		<a href="stock_shipment_dn.php?id={$StockTransaction.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton" target="invoice_window">
			<span class="ui-icon ui-icon-print"></span> Delivery Note
		</a>
	{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$StockTransaction.myorder_id}#MyOrderTabsPanel-Shipment">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Order
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Shipment (id: {$StockTransaction.stock_transaction_id})</h2>
	<div class="InnerContent ui-widget-content">
		<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
			<tr>
				<th> First Name </th>
				<td>{$StockTransaction.shipment_first_name|escape:'html'}</td>
			</tr>
			<tr>
				<th> Last Name </th>
				<td>{$StockTransaction.shipment_last_name|escape:'html'}</td>
			</tr>
			<tr>
				<th> Company / Organisation Name </th>
				<td>{$StockTransaction.shipment_company_name|escape:'html'}</td>
			</tr>
			<tr>
				<th>City Name</th>
				<td>{$StockTransaction.shipment_city_name|escape:'html'}</td>
			</tr>
			<tr>
				<th>Region</th>
				<td>{$StockTransaction.shipment_region|escape:'html'}</td>
			</tr>
			<tr>
				<th>Postcode</th>
				<td>{$StockTransaction.shipment_postcode|escape:'html'}</td>
			</tr>
			<tr>
				<th>Shipping Address 1</th>
				<td>{$StockTransaction.shipment_shipping_address_1|escape:'html'}</td>
			</tr>
			<tr>
				<th>Shipping Address 2</th>
				<td>{$StockTransaction.shipment_shipping_address_2|escape:'html'}</td>
			</tr>
			{if $ShipmentCountry.country_id == 133}
				<tr>
					<th>Hong Kong District</th>
					<td>{$HongKongDistrict.hk_district_name_en|escape:'html'} {$HongKongDistrict.hk_district_name_tc|escape:'html'}</td>
				</tr>
			{/if}
			<tr>
				<th>Country</th>
				<td>{$ShipmentCountry.country_name_en|escape:'html'}</td>
			</tr>
			<tr>
				<th>Tel</th>
				<td>
					{if $StockTransaction.shipment_tel_country_code != null}{$StockTransaction.shipment_tel_country_code|escape:'html'} - {/if}
					{if $StockTransaction.shipment_tel_area_code != null}{$StockTransaction.shipment_tel_area_code|escape:'html'} - {/if}
					{$StockTransaction.shipment_phone_no|escape:'html'}
				</td>
			</tr>
			<tr>
				<th>Fax</th>
				<td>
					{if $StockTransaction.shipment_fax_country_code != null}{$StockTransaction.shipment_fax_country_code|escape:'html'} - {/if}
					{if $StockTransaction.shipment_fax_area_code != null}{$StockTransaction.shipment_fax_area_code|escape:'html'} - {/if}
					{$StockTransaction.shipment_fax_no|escape:'html'}
				</td>
			</tr>
			<tr>
				<th>Email</th>
				<td>{$StockTransaction.shipment_email|escape:'html'}</td>
			</tr>
			<tr>
				<th> Note </th>
				<td>{$StockTransaction.shipment_user_reference|escape:'html'|nl2br}</td>
			</tr>			
			<tr>
				<th>Shipment Confirmed By</th>
				<td>{$StockTransaction.stock_shipment_confirm_by|escape:'html'} ({$StockTransaction.stock_shipment_confirm_date|escape:'html'})</td>
			</tr>
		</table>
		<hr />
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th>Product ID</th>
				<th>Product Code</th>
				<th>Product</th>
				<th>Quantity</th>
			</tr>
			{foreach from=$StockTransactionProducts item=P}
				<tr class="{if $P.object_is_enable == 'N'}DisabledRow{/if}">
					<td class="AlignCenter">{$P.product_id}</td>
					<td class="AlignCenter">{$P.product_code}</td>
					<td>
						{$P.object_name}
						{if $P.product_option_id != 0}
							(
							{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
								{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
								{$P.$myfield} 
							{/section}
							)
						{/if}
					</td>
					<td class="AlignCenter">
						{$P.product_quantity|abs}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
