{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">Make Shipment &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="order_details.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Order Details
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="stock_shipment_add_act.php">
		<div class="AdminEditDetailsBlock">
			<h2>Delivery Details</h2>
			<br />
			<table id="StockInOutCartDetailsTable" class="LeftHeaderTable">
				{if $MyOrder.deliver_to_different_address == 'N'}
					<tr>
						<th> First Name </th>
						<td> <input type="text" name="shipment_first_name" value="{$MyOrder.invoice_first_name|escape:'html'}" size="80" /> </td>
					</tr>
					<tr>
						<th> Last Name </th>
						<td> <input type="text" name="shipment_last_name" value="{$MyOrder.invoice_last_name|escape:'html'}" size="80" /> </td>
					</tr>
					<tr>
						<th> Company / Organisation Name </th>
						<td> <input type="text" name="shipment_company_name" value="{$MyOrder.invoice_company_name|escape:'html'}" size="80" /> </td>
					</tr>
					<tr>
						<th>City Name</th>
						<td><input type="text" name="shipment_city_name" value="{$MyOrder.invoice_city_name|escape:'html'}" size="80" /></td>
					</tr>
					<tr>
						<th>Region</th>
						<td><input type="text" name="shipment_region" value="{$MyOrder.invoice_region|escape:'html'}" size="80" /></td>
					</tr>
					<tr>
						<th>Postcode</th>
						<td><input type="text" name="shipment_postcode" value="{$MyOrder.invoice_postcode|escape:'html'}" size="80" /></td>
					</tr>
					<tr>
						<th>Shipping Address 1</th>
						<td><input type="text" name="shipment_shipping_address_1" value="{$MyOrder.invoice_shipping_address_1|escape:'html'}" size="80" /></td>
					</tr>
					<tr>
						<th>Shipping Address 2</th>
						<td><input type="text" name="shipment_shipping_address_2" value="{$MyOrder.invoice_shipping_address_2|escape:'html'}" size="80" /></td>
					</tr>
					<tr>
						<th>Hong Kong District</th>
						<td>
							<select name="shipment_hk_district_id">
								<option value="0" {if $MyOrder.invoice_hk_district_id == 0}selected="selected"{/if}> - </option>
								{foreach from=$HKDistrictList item=D}
								    <option value="{$D.hk_district_id}"
										{if $D.hk_district_id == $MyOrder.invoice_hk_district_id}selected="selected"{/if}
								    >{$D.hk_district_name_en|escape:'html'} {$D.hk_district_name_tc|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Country</th>
						<td>
							<select name="shipment_country_id">
								{foreach from=$CountryList item=C}
								    <option value="{$C.country_id}"
										{if $C.country_id == $MyOrder.invoice_country_id}selected="selected"{/if}
								    >{$C.country_name_en|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<th>Tel</th>
						<td>
							<input type="text" name="shipment_tel_country_code" value="{$MyOrder.invoice_tel_country_code|escape:'html'}" size="10" /> -
							<input type="text" name="shipment_tel_area_code" value="{$MyOrder.invoice_tel_area_code|escape:'html'}" size="10" /> -
							<input type="text" name="shipment_phone_no" value="{$MyOrder.invoice_phone_no|escape:'html'}" size="40" />
						</td>
					</tr>
					<tr>
						<th>Fax</th>
						<td>
							<input type="text" name="shipment_fax_country_code" value="{$MyOrder.invoice_fax_country_code|escape:'html'}" size="10" /> -
							<input type="text" name="shipment_fax_area_code" value="{$MyOrder.invoice_fax_area_code|escape:'html'}" size="10" /> -
							<input type="text" name="shipment_fax_no" value="{$MyOrder.invoice_fax_no|escape:'html'}" size="40" />
						</td>
					</tr>
					<tr>
						<th>Email</th>
						<td><input type="text" name="shipment_email" value="{$MyOrder.invoice_email|escape:'html'}" size="80" /></td>
					</tr>
					{else}
						<tr>
							<th> First Name </th>
							<td> <input type="text" name="shipment_first_name" value="{$MyOrder.delivery_first_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr>
							<th> Last Name </th>
							<td> <input type="text" name="shipment_last_name" value="{$MyOrder.delivery_last_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr>
							<th> Company / Organisation Name </th>
							<td> <input type="text" name="shipment_company_name" value="{$MyOrder.delivery_company_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr>
							<th>City Name</th>
							<td><input type="text" name="shipment_city_name" value="{$MyOrder.delivery_city_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Region</th>
							<td><input type="text" name="shipment_region" value="{$MyOrder.delivery_region|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Postcode</th>
							<td><input type="text" name="shipment_postcode" value="{$MyOrder.delivery_postcode|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Shipping Address 1</th>
							<td><input type="text" name="shipment_shipping_address_1" value="{$MyOrder.delivery_shipping_address_1|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Shipping Address 2</th>
							<td><input type="text" name="shipment_shipping_address_2" value="{$MyOrder.delivery_shipping_address_2|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Hong Kong District</th>
							<td>
								<select name="shipment_hk_district_id">
									<option value="0" {if $MyOrder.delivery_hk_district_id == 0}selected="selected"{/if}> - </option>
									{foreach from=$HKDistrictList item=D}
									    <option value="{$D.hk_district_id}"
											{if $D.hk_district_id == $MyOrder.delivery_hk_district_id}selected="selected"{/if}
									    >{$D.hk_district_name_en|escape:'html'} {$D.hk_district_name_tc|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>Country</th>
							<td>
								<select name="shipment_country_id">
									{foreach from=$CountryList item=C}
									    <option value="{$C.country_id}"
											{if $C.country_id == $MyOrder.delivery_country_id}selected="selected"{/if}
									    >{$C.country_name_en|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th>Tel</th>
							<td>
								<input type="text" name="shipment_tel_country_code" value="{$MyOrder.delivery_tel_country_code|escape:'html'}" size="10" /> -
								<input type="text" name="shipment_tel_area_code" value="{$MyOrder.delivery_tel_area_code|escape:'html'}" size="10" /> -
								<input type="text" name="shipment_phone_no" value="{$MyOrder.delivery_phone_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr>
							<th>Fax</th>
							<td>
								<input type="text" name="shipment_fax_country_code" value="{$MyOrder.delivery_fax_country_code|escape:'html'}" size="10" /> -
								<input type="text" name="shipment_fax_area_code" value="{$MyOrder.delivery_fax_area_code|escape:'html'}" size="10" /> -
								<input type="text" name="shipment_fax_no" value="{$MyOrder.delivery_fax_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr>
							<th>Email</th>
							<td><input type="text" name="shipment_email" value="{$MyOrder.delivery_email|escape:'html'}" size="80" /></td>
						</tr>
					{/if}
					<tr>
						<th>Delivery Date</th>
						<td>
							<input type="text" class="DatePicker" name="shipment_delivery_date" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="10" />
						</td>
					</tr>
					<tr>
						<th> Note </th>
						<td>
							<textarea name="shipment_user_reference" cols="50" rows="10"></textarea>
						</td>
					</tr>
				</table>
				<hr />
				<table class="TopHeaderTable AlignCenter">
					<tr class="ui-state-highlight">
						<th class="AlignLeft">Product Code</th>
						<th width="350" class="AlignLeft">Product Reference Name</th>
						<th>Quantity</th>
					</tr>
					{foreach from=$StockTransactionProducts item=P}
						<tr class="MyOrderItem">
							<td class="AlignLeft">{$P.product_code}</td>
							<td class="AlignLeft">
								{$P.object_name}
								{if $P.product_option_data_text != ''}
									({$P.product_option_data_text})
								{/if}
							</td>
							<td>
								<select name="product_quantity_{$P.product_id}_{$P.product_option_id}">
								    {section name=foo start=0 loop=$P.product_quantity|abs step=1}
    									<option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
    								{/section}
    								<option value="{$P.product_quantity|abs}" selected="selected">{$P.product_quantity|abs}</option>
								</select>
							{$P.quantity}
							</td>
						</tr>
					{/foreach}
				</table>				
			</div>
		<input type="hidden" name="id" value="{$smarty.request.id}" />
		<div class="ui-widget-header ui-corner-bottom">
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
