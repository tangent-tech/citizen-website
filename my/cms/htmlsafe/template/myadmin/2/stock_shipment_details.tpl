{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">發貨詳情 &nbsp;
	<a onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="stock_shipment_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
	{if $Site.site_dn_enable == 'Y'}
		<a href="stock_shipment_dn.php?id={$StockTransaction.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton" target="invoice_window">
			<span class="ui-icon ui-icon-print"></span> 送貨單
		</a>
	{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$StockTransaction.myorder_id}#MyOrderTabsPanel-Shipment">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 訂單
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">發貨 (編號: {$StockTransaction.stock_transaction_id})</h2>
	<div class="InnerContent ui-widget-content">
		<table class="LeftHeaderTable" id="StockInOutCartDetailsTable">
			<tr>
				<th> 名字 </th>
				<td>{$StockTransaction.shipment_first_name|escape:'html'}</td>
			</tr>
			<tr>
				<th> 姓 </th>
				<td>{$StockTransaction.shipment_last_name|escape:'html'}</td>
			</tr>
			<tr>
				<th> 公司/機構名稱 </th>
				<td>{$StockTransaction.shipment_company_name|escape:'html'}</td>
			</tr>
			<tr>
				<th>城市</th>
				<td>{$StockTransaction.shipment_city_name|escape:'html'}</td>
			</tr>
			<tr>
				<th>區域</th>
				<td>{$StockTransaction.shipment_region|escape:'html'}</td>
			</tr>
			<tr>
				<th>郵編</th>
				<td>{$StockTransaction.shipment_postcode|escape:'html'}</td>
			</tr>
			<tr>
				<th>送貨地址1</th>
				<td>{$StockTransaction.shipment_shipping_address_1|escape:'html'}</td>
			</tr>
			<tr>
				<th>送貨地址2</th>
				<td>{$StockTransaction.shipment_shipping_address_2|escape:'html'}</td>
			</tr>
			{if $ShipmentCountry.country_id == 133}
				<tr>
					<th>香港區域</th>
					<td>{$HongKongDistrict.hk_district_name_en|escape:'html'} {$HongKongDistrict.hk_district_name_tc|escape:'html'}</td>
				</tr>
			{/if}
			<tr>
				<th>國家</th>
				<td>{$ShipmentCountry.country_name_en|escape:'html'}</td>
			</tr>
			<tr>
				<th>電話</th>
				<td>
					{if $StockTransaction.shipment_tel_country_code != null}{$StockTransaction.shipment_tel_country_code|escape:'html'} - {/if}
					{if $StockTransaction.shipment_tel_area_code != null}{$StockTransaction.shipment_tel_area_code|escape:'html'} - {/if}
					{$StockTransaction.shipment_phone_no|escape:'html'}
				</td>
			</tr>
			<tr>
				<th>傳真</th>
				<td>
					{if $StockTransaction.shipment_fax_country_code != null}{$StockTransaction.shipment_fax_country_code|escape:'html'} - {/if}
					{if $StockTransaction.shipment_fax_area_code != null}{$StockTransaction.shipment_fax_area_code|escape:'html'} - {/if}
					{$StockTransaction.shipment_fax_no|escape:'html'}
				</td>
			</tr>
			<tr>
				<th>電郵</th>
				<td>{$StockTransaction.shipment_email|escape:'html'}</td>
			</tr>
			<tr>
				<th> 筆記 </th>
				<td>{$StockTransaction.shipment_user_reference|escape:'html'|nl2br}</td>
			</tr>			
			<tr>
				<th>發貨經手人</th>
				<td>{$StockTransaction.stock_shipment_confirm_by|escape:'html'} ({$StockTransaction.stock_shipment_confirm_date|escape:'html'})</td>
			</tr>
		</table>
		<hr />
		<table class="TopHeaderTable">
			<tr class="ui-state-highlight">
				<th>系統編號</th>
				<th>產品編號</th>
				<th>產品</th>
				<th>數量</th>
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
