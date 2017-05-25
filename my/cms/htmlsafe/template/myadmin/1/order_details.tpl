{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_order.tpl"}
<h1 class="PageTitle">Order Details &nbsp;
	{if $IsSiteAdmin}
		<a href="order_delete.php?id={$smarty.request.id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to delete this order?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
			<span class="ui-icon ui-icon-trash"></span> delete
		</a>
	{/if}
	{if $MyOrder.order_can_void == 'Y'}
		<a href="order_void.php?id={$smarty.request.id}" onclick="return DoubleConfirm('WARNING!\n Are you sure you want to void this order?', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton">
			<span class="ui-icon ui-icon-trash"></span> void
		</a>
	{/if}
	{if $Site.site_invoice_enable == 'Y'}
		<a href="order_invoice.php?id={$MyOrder.myorder_id}" class="ui-state-default ui-corner-all MyButton" target="invoice_window">
			<span class="ui-icon ui-icon-print"></span> Invoice
		</a>
	{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="order_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Order List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="order_details_act.php">
		<div id="MyOrderTabs">
			<ul>
				<li><a href="#MyOrderTabsPanel-OrderStatus">Order Status</a></li>
				<li><a href="#MyOrderTabsPanel-UserDetails">User Details</a></li>
				<li><a href="#MyOrderTabsPanel-InvoiceDetails">Invoice Details</a></li>
				{if $MyorderFieldsShow.show_deliver_address_tab != 'N'}
					<li><a href="#MyOrderTabsPanel-DeliveryDetails">Delivery Details</a></li>
				{/if}
				{if $Site.site_module_bonus_point_enable == 'Y' && $MyorderFieldsShow.show_bonus_point_tab != 'N'}
					<li><a href="#MyOrderTabsPanel-BonusPointDetails">Bonus Point Details</a></li>
				{/if}
				{if $MyorderFieldsShow.user_balance_tab != 'N'}
					<li><a href="#MyOrderTabsPanel-UserBalance">User Balance</a></li>
				{/if}
				<li><a href="#MyOrderTabsPanel-Pricing">Pricing</a></li>
				{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
					{if $MyOrder.payment_confirmed == 'Y'}
						<li><a href="#MyOrderTabsPanel-Shipment">Shipment</a></li>
					{/if}
				{/if}
			</ul>
			<div id="MyOrderTabsPanel-OrderStatus">
				<br />
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> Order Date </th>
							<td width="70%"> {$MyOrder.create_date} </td>
						</tr>
						<tr>
							<th> Order No </th>
							<td> {$MyOrder.order_no} </td>
						</tr>
						<tr>
							<th>Order Status</th>
							<td>
								{if $MyOrder.order_status == 'awaiting_freight_quote'}
									Awaiting Freight Quote
									<a onclick="return DoubleConfirm('Are you sure you want to confirm the freight cost? This process cannot be undone.', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="order_confirm_freight.php?id={$smarty.request.id}">
										<span class="ui-icon ui-icon-suitcase"></span> Confirm Freight
									</a>
								{elseif $MyOrder.order_status == 'awaiting_order_confirmation'}
									Awaiting Order Confirmation
								{elseif $MyOrder.order_status == 'order_cancelled'}
									Order Cancelled
								{elseif $MyOrder.order_status == 'payment_pending'}
									Payment Pending
								{elseif $MyOrder.order_status == 'payment_confirmed'}
									Payment Confirmed
									{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}

									{else}
										<a onclick="return DoubleConfirm('Are you sure you want to mark this order as shipped? This process cannot be undone.', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="order_confirm_shipment.php?id={$smarty.request.id}">
											<span class="ui-icon ui-icon-suitcase"></span> Confirm Shipment
										</a>
									{/if}
								{elseif $MyOrder.order_status == 'partial_shipped'}
									Partial Shipped
								{elseif $MyOrder.order_status == 'shipped'}
									Shipped
								{elseif $MyOrder.order_status == 'void'}
									Void
								{/if}
							</td>
						</tr>
						<tr>
							<th>Order Handled</th>
							<td>
								<input type="radio" name="is_handled" value="Y" {if $MyOrder.is_handled == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="is_handled" value="N" {if $MyOrder.is_handled == 'N'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr>
							<th> Pay Amount </th>
							<td>
								{$MyOrder.currency_shortname|escape:'html'} {$MyOrder.pay_amount_ca|number_format:$MyOrder.currency_precision}
							</td>
						</tr>
						<tr>
							<th> Payment Confirmed? </th>
							<td> {if $MyOrder.payment_confirmed == 'Y'}Yes{else}No{/if}
								{if $MyOrder.payment_confirmed == 'N' && $MyOrder.order_status == 'payment_pending'}
									<a onclick="return DoubleConfirm('Are you sure you have received the payment? This process cannot be undone.', 'WARNING!\nAre you 100% sure?')" class="ui-state-default ui-corner-all MyButton" href="order_confirm_payment.php?id={$smarty.request.id}">
										<span class="ui-icon ui-icon-suitcase"></span> Confirm Payment Receive
									</a>
								{/if}
							</td>
						</tr>
						<tr>
							<th> Payment Confirmed By </th>
							<td> {$MyOrder.payment_confirm_by|escape:'html'} </td>
						</tr>
						<tr>
							<th> Payment Confirm Date </th>
							<td> {$MyOrder.payment_confirm_date} </td>
						</tr>
						<tr>
							<th> Last Shipment Confirmed By </th>
							<td> {$MyOrder.shipment_confirm_by|escape:'html'} </td>
						</tr>
						<tr>
							<th> Last Shipment Confirm Date </th>
							<td> {$MyOrder.shipment_confirm_date} </td>
						</tr>
						<tr>
							<th> Last Delivery Date </th>
							<td>
								{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
									{$MyOrder.delivery_date}
								{else}
									<input type="text" class="DatePicker" name="delivery_date" value="{$MyOrder.delivery_date}" size="10" />
								{/if}
							</td>
						</tr>
						<tr>
							<th> Payment Gateway Reference 1</th>
							<td>{$MyOrder.reference_1|wordwrap:60:"<br />\n":true}</td>
						</tr>
						<tr>
							<th> Payment Gateway Reference 2</th>
							<td> {$MyOrder.reference_2|wordwrap:60:"<br />\n":true} </td>
						</tr>
						<tr>
							<th> Payment Gateway Reference 3</th>
							<td> {$MyOrder.reference_3|wordwrap:60:"<br />\n":true} </td>
						</tr>
						<tr>
							<th> User Message </th>
							<td> {$MyOrder.user_message|escape:'html'|nl2br} </td>
						</tr>
						<tr>
							<th> Note </th>
							<td>
								<textarea name="user_reference" cols="50" rows="10">{$MyOrder.user_reference}</textarea>
							</td>
						</tr>
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_int_`$smarty.section.foo.iteration`"}
							{if $MyorderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MyorderCustomFieldsDef.$myfield}</th>
									<td>{$MyOrder.$myfield|escape:'html'}</td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_double_`$smarty.section.foo.iteration`"}
							{if $MyorderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MyorderCustomFieldsDef.$myfield}</th>
									<td>{$MyOrder.$myfield|escape:'html'}</td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_date_`$smarty.section.foo.iteration`"}
							{if $MyorderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MyorderCustomFieldsDef.$myfield}</th>
									<td>{$MyOrder.$myfield|escape:'html'}</td>
								</tr>
							{/if}
						{/section}
						{section name=foo start=0 loop=20 step=1}
							{assign var='myfield' value="myorder_custom_text_`$smarty.section.foo.iteration`"}
							{if $MyorderCustomFieldsDef.$myfield != ''}
								<tr>
									<th>{$MyorderCustomFieldsDef.$myfield}</th>
									<td>{$MyOrder.$myfield|escape:'html'}</td>
								</tr>
							{/if}
						{/section}
					</table>
				</div>
			</div>
			<div id="MyOrderTabsPanel-UserDetails">
				<br />
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th>Status</th>
							<td width="70%">
								{if $User.user_is_enable == 'Y'}
									Enable
								{else}
									Disable
								{/if}
							</td>
						</tr>
						<tr>
							<th>Username</th>
							<td><a href="member_edit.php?id={$User.user_id}">{$User.user_username|escape:'html'}</a></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><a href="member_edit.php?id={$User.user_id}">{$User.user_email|escape:'html'}</a></td>
						</tr>
						<tr {if $UserFieldsShow.user_security_level == 'N'}class="Hidden"{/if}>
							<th>Security Level</th>
							<td>{$User.user_security_level}</td>
						</tr>
						<tr {if $UserFieldsShow.user_language_id == 'N'}class="Hidden"{/if}>
							<th>Language</th>
							<td>{$UserLanguage.language_native|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_title == 'N'}class="Hidden"{/if}>
							<th>Title</th>
							<td>{$User.user_title|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_first_name == 'N'}class="Hidden"{/if}>
							<th>First Name</th>
							<td>{$User.user_first_name|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_last_name == 'N'}class="Hidden"{/if}>
							<th>Last Name</th>
							<td>{$User.user_last_name|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_company_name == 'N'}class="Hidden"{/if}>
							<th>Company / Organisation</th>
							<td>{$User.user_company_name|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_city_name == 'N'}class="Hidden"{/if}>
							<th>City Name</th>
							<td>{$User.user_city_name|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_region == 'N'}class="Hidden"{/if}>
							<th>Region</th>
							<td>{$User.user_region|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_postcode == 'N'}class="Hidden"{/if}>
							<th>Postcode</th>
							<td>{$User.user_postcode|escape:'html'}</td>
						</tr>
						<tr>
							<th>Address 1</th>
							<td>{$User.user_address_1|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_address_2 == 'N'}class="Hidden"{/if}>
							<th>Address 2</th>
							<td>{$User.user_address_2|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_country_id == 'N'}class="Hidden"{/if}>
							<th>Country</th>
							<td> {$User.country_name_en|escape:'html'} </td>
						</tr>
						{if $User.user_country_id == $smarty.const.COUNTRY_ID_OTHER}
							<tr {if $UserFieldsShow.user_country_id == 'N'}class="Hidden"{/if}>
								<th>Country (Other)</th>
								<td> {$User.user_country_other|escape:'html'} </td>
							</tr>
						{/if}
						{if $User.user_country_id == 133}
							<tr {if $UserFieldsShow.user_hk_district_id == 'N'}class="Hidden"{/if}>
								<th>Hong Kong District</th>
								<td> {$User.hk_district_name_en|escape:'html'} </td>
							</tr>
						{/if}						
						
						<tr {if $UserFieldsShow.user_tel_country_code == 'N' && $UserFieldsShow.user_tel_area_code == 'N' && $UserFieldsShow.user_tel_no == 'N'}class="Hidden"{/if}>
							<th>Tel</th>
							<td>
								{if $User.user_tel_country_code != '' && $UserFieldsShow.user_tel_country_code != 'N'}
									{$User.user_tel_country_code|escape:'html'} -
								{/if}
								{if $User.user_tel_area_code != '' && $UserFieldsShow.user_tel_area_code != 'N'}
									{$User.user_tel_area_code|escape:'html'} -
								{/if}
								{$User.user_tel_no|escape:'html'}
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_fax_country_code == 'N' && $UserFieldsShow.user_fax_area_code == 'N' && $UserFieldsShow.user_fax_no == 'N'}class="Hidden"{/if}>
							<th>Fax</th>
							<td>
								{if $User.user_fax_country_code != '' && $UserFieldsShow.user_fax_country_code != 'N'}
									{$User.user_fax_country_code|escape:'html'} -
								{/if}
								{if $User.user_fax_area_code != '' && $UserFieldsShow.user_fax_area_code != 'N'}
									{$User.user_fax_area_code|escape:'html'} -
								{/if}
								{$User.user_fax_no|escape:'html'}
							</td>
						</tr>
						<tr {if $UserFieldsShow.user_balance == 'N'}class="Hidden"{/if}>
							<th>Balance</th>
							<td>{$Site.currency_shortname} {$User.user_balance|escape:'html'}</td>
						</tr>
						<tr {if $UserFieldsShow.user_join_mailinglist == 'N'}class="Hidden"{/if}>
							<th>Join Mailing List</th>
							<td>
								{if $User.user_join_mailinglist == 'Y'}Yes{else}No{/if}
							</td>
						</tr>
						<tr>
							<th>Email Verified</th>
							<td>
								{if $User.user_is_email_verify == 'Y'}Yes{else}No{/if}
							</td>
						</tr>
						<tr>
							<th>Note</th>
							<td>{$User.user_note|nl2br}</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="MyOrderTabsPanel-InvoiceDetails">
				<br />
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr {if $MyorderFieldsShow.show_deliver_address_tab == 'N'}class="Hidden"{/if}>
							<th>Deliver to different address?</th>
							<td>
								<input type="radio" name="deliver_to_different_address" value="Y" {if $MyOrder.deliver_to_different_address == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="deliver_to_different_address" value="N" {if $MyOrder.deliver_to_different_address != 'Y'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr {if $MyorderFieldsShow.self_take == 'N'}class="Hidden"{/if}>
							<th>Self take?</th>
							<td>
								<input type="radio" name="self_take" value="Y" {if $MyOrder.self_take == 'Y'}checked="checked"{/if}/> Yes
								<input type="radio" name="self_take" value="N" {if $MyOrder.self_take != 'Y'}checked="checked"{/if}/> No
							</td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_first_name == 'N'}class="Hidden"{/if}>
							<th> First Name </th>
							<td> <input type="text" name="invoice_first_name" value="{$MyOrder.invoice_first_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_last_name == 'N'}class="Hidden"{/if}>
							<th> Last Name </th>
							<td> <input type="text" name="invoice_last_name" value="{$MyOrder.invoice_last_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_company_name == 'N'}class="Hidden"{/if}>
							<th> Company / Organisation Name </th>
							<td> <input type="text" name="invoice_company_name" value="{$MyOrder.invoice_company_name|escape:'html'}" size="80" /> </td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_city_name == 'N'}class="Hidden"{/if}>
							<th>City Name</th>
							<td><input type="text" name="invoice_city_name" value="{$MyOrder.invoice_city_name|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_region == 'N'}class="Hidden"{/if}>
							<th>Region</th>
							<td><input type="text" name="invoice_region" value="{$MyOrder.invoice_region|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_postcode == 'N'}class="Hidden"{/if}>
							<th>Postcode</th>
							<td><input type="text" name="invoice_postcode" value="{$MyOrder.invoice_postcode|escape:'html'}" size="80" /></td>
						</tr>
						<tr>
							<th>Shipping Address 1</th>
							<td><input type="text" name="invoice_shipping_address_1" value="{$MyOrder.invoice_shipping_address_1|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_shipping_address_2 == 'N'}class="Hidden"{/if}>
							<th>Shipping Address 2</th>
							<td><input type="text" name="invoice_shipping_address_2" value="{$MyOrder.invoice_shipping_address_2|escape:'html'}" size="80" /></td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_country_id == 'N'}class="Hidden"{/if}>
							<th>Country</th>
							<td>
								<select name="invoice_country_id">
									{foreach from=$CountryList item=C}
									    <option value="{$C.country_id}"
											{if $C.country_id == $MyOrder.invoice_country_id}selected="selected"{/if}
									    >{$C.country_name_en|escape:'html'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_country_id == 'N'}class="Hidden"{/if}>
							<th>Country (Other)</th>
							<td><input type="text" name="invoice_country_other" value="{$MyOrder.invoice_country_other|escape:'html'}" size="80" /></td>
						</tr>
						{if $MyOrder.invoice_country_id == 133}
							<tr {if $MyorderFieldsShow.invoice_hk_district_id == 'N'}class="Hidden"{/if}>
								<th>Hong Kong District</th>
								<td>
									<select name="invoice_hk_district_id">
										<option value="0" {if $MyOrder.invoice_hk_district_id == 0}selected="selected"{/if}> - </option>
										{foreach from=$HKDistrictList item=D}
											<option value="{$D.hk_district_id}"
												{if $D.hk_district_id == $MyOrder.invoice_hk_district_id}selected="selected"{/if}
											>{$D.hk_district_name_en|escape:'html'} {$D.hk_district_name_tc|escape:'html'}</option>
										{/foreach}
									</select>
								</td>
							</tr>
						{/if}
						<tr {if $MyorderFieldsShow.invoice_tel_country_code == 'N' && $MyorderFieldsShow.invoice_tel_area_code == 'N' && $MyorderFieldsShow.invoice_tel_no == 'N'}class="Hidden"{/if}>
							<th>Tel</th>
							<td>
								<span {if $MyorderFieldsShow.invoice_tel_country_code == 'N'}class="Hidden"{/if}><input type="text" name="invoice_tel_country_code" value="{$MyOrder.invoice_tel_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $MyorderFieldsShow.invoice_tel_area_code == 'N'}class="Hidden"{/if}><input type="text" name="invoice_tel_area_code" value="{$MyOrder.invoice_tel_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="invoice_phone_no" value="{$MyOrder.invoice_phone_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr {if $MyorderFieldsShow.invoice_fax_country_code == 'N' && $MyorderFieldsShow.invoice_fax_area_code == 'N' && $MyorderFieldsShow.invoice_fax_no == 'N'}class="Hidden"{/if}>
							<th>Fax</th>
							<td>
								<span {if $MyorderFieldsShow.invoice_fax_country_code == 'N'}class="Hidden"{/if}><input type="text" name="invoice_fax_country_code" value="{$MyOrder.invoice_fax_country_code|escape:'html'}" size="10" /> -</span>
								<span {if $MyorderFieldsShow.invoice_fax_area_code == 'N'}class="Hidden"{/if}><input type="text" name="invoice_fax_area_code" value="{$MyOrder.invoice_fax_area_code|escape:'html'}" size="10" /> -</span>
								<input type="text" name="invoice_fax_no" value="{$MyOrder.invoice_fax_no|escape:'html'}" size="40" />
							</td>
						</tr>
						<tr>
							<th>Email</th>
							<td><input type="text" name="invoice_email" value="{$MyOrder.invoice_email|escape:'html'}" size="80" /></td>
						</tr>
					</table>
				</div>
			</div>
			{if $MyorderFieldsShow.show_deliver_address_tab != 'N'}
				<div id="MyOrderTabsPanel-DeliveryDetails">
					<br />
					<div class="AdminEditDetailsBlock">
						{if $MyOrder.deliver_to_different_address == 'Y'}
							<table class="LeftHeaderTable">
								<tr {if $MyorderFieldsShow.delivery_first_name == 'N'}class="Hidden"{/if}>
									<th> First Name </th>
									<td> <input type="text" name="delivery_first_name" value="{$MyOrder.delivery_first_name|escape:'html'}" size="80" /> </td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_last_name == 'N'}class="Hidden"{/if}>
									<th> Last Name </th>
									<td> <input type="text" name="delivery_last_name" value="{$MyOrder.delivery_last_name|escape:'html'}" size="80" /> </td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_company_name == 'N'}class="Hidden"{/if}>
									<th> Company / Organisation Name </th>
									<td> <input type="text" name="delivery_company_name" value="{$MyOrder.delivery_company_name|escape:'html'}" size="80" /> </td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_city_name == 'N'}class="Hidden"{/if}>
									<th>City Name</th>
									<td><input type="text" name="delivery_city_name" value="{$MyOrder.delivery_city_name|escape:'html'}" size="80" /></td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_region == 'N'}class="Hidden"{/if}>
									<th>Region</th>
									<td><input type="text" name="delivery_region" value="{$MyOrder.delivery_region|escape:'html'}" size="80" /></td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_postcode == 'N'}class="Hidden"{/if}>
									<th>Postcode</th>
									<td><input type="text" name="delivery_postcode" value="{$MyOrder.delivery_postcode|escape:'html'}" size="80" /></td>
								</tr>
								<tr>
									<th>Shipping Address 1</th>
									<td><input type="text" name="delivery_shipping_address_1" value="{$MyOrder.delivery_shipping_address_1|escape:'html'}" size="80" /></td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_shipping_address_2 == 'N'}class="Hidden"{/if}>
									<th>Shipping Address 2</th>
									<td><input type="text" name="delivery_shipping_address_2" value="{$MyOrder.delivery_shipping_address_2|escape:'html'}" size="80" /></td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_country_id == 'N'}class="Hidden"{/if}>
									<th>Country</th>
									<td>
										<select name="delivery_country_id">
											{foreach from=$CountryList item=C}
												<option value="{$C.country_id}"
													{if $C.country_id == $MyOrder.delivery_country_id}selected="selected"{/if}
												>{$C.country_name_en|escape:'html'}</option>
											{/foreach}
										</select>
									</td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_country_id == 'N'}class="Hidden"{/if}>
									<th>Country (Other)</th>
									<td><input type="text" name="delivery_country_other" value="{$MyOrder.delivery_country_other|escape:'html'}" size="80" /></td>
								</tr>								
								{if $MyOrder.delivery_country_id == 133}
									<tr {if $MyorderFieldsShow.delivery_hk_district_id == 'N'}class="Hidden"{/if}>
										<th>Hong Kong District</th>
										<td>
											<select name="delivery_hk_district_id">
												<option value="0" {if $MyOrder.delivery_hk_district_id == 0}selected="selected"{/if}> - </option>
												{foreach from=$HKDistrictList item=D}
													<option value="{$D.hk_district_id}"
														{if $D.hk_district_id == $MyOrder.delivery_hk_district_id}selected="selected"{/if}
													>{$D.hk_district_name_en|escape:'html'} {$D.hk_district_name_tc|escape:'html'}</option>
												{/foreach}
											</select>
										</td>
									</tr>
								{/if}
								<tr {if $MyorderFieldsShow.delivery_tel_country_code == 'N' && $MyorderFieldsShow.delivery_tel_area_code == 'N' && $MyorderFieldsShow.delivery_phone_no == 'N'}class="Hidden"{/if}>
									<th>Tel</th>
									<td>
										<span {if $MyorderFieldsShow.delivery_tel_country_code == 'N'}class="Hidden"{/if}><input type="text" name="delivery_tel_country_code" value="{$MyOrder.delivery_tel_country_code|escape:'html'}" size="10" /> -</span>
										<span {if $MyorderFieldsShow.delivery_tel_country_code == 'N'}class="Hidden"{/if}><input type="text" name="delivery_tel_area_code" value="{$MyOrder.delivery_tel_area_code|escape:'html'}" size="10" /> -</span>
										<input type="text" name="delivery_phone_no" value="{$MyOrder.delivery_phone_no|escape:'html'}" size="40" />
									</td>
								</tr>
								<tr {if $MyorderFieldsShow.delivery_fax_country_code == 'N' && $MyorderFieldsShow.delivery_fax_area_code == 'N' && $MyorderFieldsShow.delivery_fax_no == 'N'}class="Hidden"{/if}>
									<th>Fax</th>
									<td>
										<span {if $MyorderFieldsShow.delivery_fax_country_code == 'N'}class="Hidden"{/if}><input type="text" name="delivery_fax_country_code" value="{$MyOrder.delivery_fax_country_code|escape:'html'}" size="10" /> -</span>
										<span {if $MyorderFieldsShow.delivery_fax_area_code == 'N'}class="Hidden"{/if}><input type="text" name="delivery_fax_area_code" value="{$MyOrder.delivery_fax_area_code|escape:'html'}" size="10" /> -</span>
										<input type="text" name="delivery_fax_no" value="{$MyOrder.delivery_fax_no|escape:'html'}" size="40" />
									</td>
								</tr>
								<tr>
									<th>Email</th>
									<td><input type="text" name="delivery_email" value="{$MyOrder.delivery_email|escape:'html'}" size="80" /></td>
								</tr>
							</table>
						{else}
							<p>Same as Invoice Details.</p>
							<br />
						{/if}
					</div>
				</div>
			{/if}
			{if $Site.site_module_bonus_point_enable == 'Y' && $MyorderFieldsShow.show_bonus_point_tab != 'N'}
				<div id="MyOrderTabsPanel-BonusPointDetails">
					<br />
					<div class="AdminEditDetailsBlock">
						{if $MyOrder.payment_confirmed == 'N'}
							<p>
								<a href="order_edit_bonus_point_item_list.php?id={$MyOrder.myorder_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> Edit Redeem Bonus Point Item List
								</a>
							</p>
						{/if}
						<br />

						<table class="TopHeaderTable">
							<tr class="ui-state-highlight">
								<th>Redeemed Bonus Point Item</th>
								<th>Quantity</th>
								<th>Cash Value</th>
								<th>Required Bonus Point</th>
							</tr>
							{if $MyOrderBonusPointItemList|@count == 0}
								<tr>
									<td colspan="4">No bonus point item redeemed.</td>
								</tr>
							{/if}
							{foreach from=$MyOrderBonusPointItemList item=B}
								<tr>
									<td>{$B.bonus_point_item_name}</td>
									<td>{$B.quantity}</td>
									<td>
										{if $B.subtotal_cash > 0}
											{$Site.currency_shortname} {$B.subtotal_cash} {if $Site.currency_id != $MyOrder.currency_id}({$MyOrder.currency_shortname} {$B.subtotal_cash_ca}){/if}
										{else}
											-
										{/if}
									</td>
									<td>{$B.subtotal_bonus_point_required}</td>
								</tr>
							{/foreach}
						</table>
						<br />
						<table class="LeftHeaderTable LeftAlignTable">
						{*
							<tr>
								<th> Redeemed Bonus Point Item </th>
								<td>
									{if $MyOrder.payment_confirmed == 'N'}
										<select name="bonus_point_item_id">
											<option value="0"{if $MyOrder.bonus_point_item_id == 0}selected="selected"{/if}>None</option>
											{foreach from=$BonusPointItemList item=B}
											    <option value="{$B.bonus_point_item_id}"
													{if $B.bonus_point_item_id == $MyOrder.bonus_point_item_id}selected="selected"{/if}
											    >{$B.bonus_point_item_name|escape:'html'}</option>
											{/foreach}
										</select>
									{else}
										{foreach from=$BonusPointItemList item=B}
											{if $B.bonus_point_item_id == $MyOrder.bonus_point_item_id}
												{$B.bonus_point_item_name|escape:'html'}
											{/if}
										{/foreach}
									{/if}
								</td>
							</tr>
						*}
							<tr>
								<th> Previous Balance </th>
								<td> {$MyOrder.bonus_point_previous} </td>
							</tr>
							<tr>
								<th> Bonus Point Earned </th>
								<td> {$MyOrder.bonus_point_earned} </td>
							</tr>
							<tr>
								<th> Bonus Point Can Be Used </th>
								<td> {$MyOrder.bonus_point_canbeused} </td>
							</tr>
							<tr>
								<th> Bonus Point Redeemed </th>
								<td> {$MyOrder.bonus_point_redeemed} </td>
							</tr>
							<tr>
								<th> Bonus Point Balance </th>
								<td> {$MyOrder.bonus_point_balance} </td>
							</tr>
						</table>
					</div>
				</div>
			{/if}
			{if $MyorderFieldsShow.user_balance_tab != 'N'}
				<div id="MyOrderTabsPanel-UserBalance">
					<br />
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th> Previous Balance </th>
								<td> {$Site.currency_shortname} {$MyOrder.user_balance_previous} </td>
							</tr>
							<tr>
								<th> Balance Used </th>
								<td>
									{if $MyOrder.payment_confirmed == 'N'}
										{$Site.currency_shortname} <input type="text" name="user_balance_used" value="{$MyOrder.user_balance_used}" /> {if $Site.currency_id != $MyOrder.currency_id}({$MyOrder.currency_shortname} {$MyOrder.user_balance_used_ca}){/if}
									{else}
										{$Site.currency_shortname} {$MyOrder.user_balance_used} {if $Site.currency_id != $MyOrder.currency_id}({$MyOrder.currency_shortname} {$MyOrder.user_balance_used_ca}){/if}
									{/if}
								</td>
							</tr>
							<tr>
								<th> Balance After </th>
								<td> {$Site.currency_shortname} {$MyOrder.user_balance_after} </td>
							</tr>
						</table>
					</div>
				</div>
			{/if}
			<div id="MyOrderTabsPanel-Pricing">
				<br />
				<div class="AdminEditDetailsBlock">
					{if $MyOrder.payment_confirmed == 'N'}
						<p>
							<a href="order_edit_product_list.php?id={$MyOrder.myorder_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-pencil"></span> Edit Product List
							</a>
						</p>
					{/if}
					<br />
					{if $MyOrder.currency_site_rate_atm != 1}
						{if $MyOrder.payment_confirmed == 'N'}
							<p>Currency Rate: <input type="text" name="currency_site_rate_atm" value="{$MyOrder.currency_site_rate_atm|number_format:$MyOrder.currency_precision}" size="6" /></p>
						{else}
							<p>Currency Rate: {$MyOrder.currency_site_rate_atm|number_format:$MyOrder.currency_precision}</p>
							<input type="hidden" name="currency_site_rate_atm" value="{$MyOrder.currency_site_rate_atm|number_format:$MyOrder.currency_precision}" />
						{/if}
					{else}
						<input type="hidden" name="currency_site_rate_atm" value="{$MyOrder.currency_site_rate_atm|number_format:$MyOrder.currency_precision}" />
					{/if}
					<table class="TopHeaderTable AlignCenter">
						<tr class="ui-state-highlight">
							<th class="AlignLeft">Product Code</th>
							<th width="350" class="AlignLeft">Product Reference Name</th>
							<th>Quantity</th>
							<th>Unit Price</th>
							<th>Total Price</th>
							<th>Bonus Point</th>
						</tr>
						{foreach from=$MyOrderItemList item=M}
							<tr class="MyOrderItem" data-object_link_id="{$M.object_link_id}">
								<td class="AlignLeft">{$M.product_code}</td>
								<td class="AlignLeft">
									{$M.object_name}
									{if $M.product_option_id != 0}
										(
										{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
											{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
											{$M.$myfield}
										{/section}
										)
									{/if}
								</td>
								<td>{$M.quantity}</td>
								<td>
									{if $M.actual_unit_price_ca == 0}
										-
									{else}
										{$M.currency_shortname} {$M.actual_unit_price_ca|number_format:$M.currency_precision}
									{/if}
								</td>
								<td>
									{if $M.effective_discount_type == 0}
										{$M.currency_shortname} {$M.actual_subtotal_price_ca|number_format:$M.currency_precision}
									{/if}
					    			{if $M.effective_discount_type == 1}
						    			{$M.currency_shortname} {$M.actual_subtotal_price_ca|number_format:$M.currency_precision} <br />
					    				(*{$M.discount1_off_p}% Off)
					    			{elseif $M.effective_discount_type == 2}
					    				{if $M.actual_subtotal_price_ca == 0}
					    					-
					    				{else}
											{$M.currency_shortname} {$M.actual_subtotal_price_ca|number_format:$M.currency_precision} <br />
											(*{$M.currency_shortname} {$M.discount2_price_ca|number_format:$M.currency_precision} for {$M.discount2_amount})
					    				{/if}
					    			{elseif $M.effective_discount_type == 3}
										(*Buy {$M.discount3_buy_amount} Get {$M.discount3_free_amount} Free)
					    			{elseif $M.effective_discount_type == 4}
										{$M.currency_shortname} {$M.actual_subtotal_price_ca|number_format:$M.currency_precision}
									{elseif $M.effective_discount_type == 5}
										Preprocess Rule #{$M.effective_discount_preprocess_rule_id} <br />
										{$M.currency_shortname} {$M.actual_subtotal_price_ca|number_format:$Currency.currency_precision}
					    			{/if}
					    		</td>
								<td class="AlignCenter">{$M.product_bonus_point_amount}</td>
							</tr>
						{/foreach}
						<tr>
							<th colspan="4" class="AlignRight">Sub-Total</th>
							<th>{$MyOrder.currency_shortname} {$TotalPriceCA|number_format:$MyOrder.currency_precision}</th>
							<th>{$TotalBonusPoint}</th>
						</tr>
						<tr>
							<th colspan="4" class="AlignRight">Freight Cost</th>
							<th>
								{if $MyOrder.payment_confirmed == 'N'}
									{$MyOrder.currency_shortname} <input type="text" name="freight_cost_ca" value="{$MyOrder.freight_cost_ca|number_format:$MyOrder.currency_precision}" size="6" />
								{else}
									{$MyOrder.currency_shortname} {$MyOrder.freight_cost_ca|number_format:$MyOrder.currency_precision}
								{/if}
							</th>
							<td></td>
						</tr>
						<tr>
							<th colspan="4" class="AlignRight">Discount</th>
							<th>
								{if $MyOrder.payment_confirmed == 'N'}
									{$MyOrder.currency_shortname} <input type="text" name="discount_amount_ca" value="{$MyOrder.discount_amount_ca|number_format:$MyOrder.currency_precision}" size="6" />
								{else}
									{$MyOrder.currency_shortname} {$MyOrder.discount_amount_ca|number_format:$MyOrder.currency_precision}
								{/if}
							</th>
							<td></td>
						</tr>
						{if $MyOrder.bonus_point_redeemed_cash_ca > 0}
							<tr>
								<th colspan="4" class="AlignRight">Redeemed Cash</th>
								<th>{$MyOrder.currency_shortname} {$MyOrder.bonus_point_redeemed_cash_ca|number_format:$MyOrder.currency_precision}</th>
								<td></td>
							</tr>
						{/if}
						{if $MyOrder.effective_discount_postprocess_rule_id|intval != 0}
							<tr>
								<th colspan="4" class="AlignRight">Postprocess Rule #{$MyOrder.effective_discount_postprocess_rule_id} Discount</th>
								<th>
									{$MyOrder.currency_shortname} {$MyOrder.postprocess_rule_discount_amount_ca|number_format:$MyOrder.currency_precision}
								</th>
								<th></th>
							</tr>
						{/if}
						{if $MyOrder.user_balance_used_ca > 0}
							<tr>
								<th colspan="4" class="AlignRight">User Balance Used</th>
								<th>{$MyOrder.currency_shortname} {$MyOrder.user_balance_used_ca|number_format:$MyOrder.currency_precision}</th>
								<td></td>
							</tr>
						{/if}
						<tr>
							<th colspan="4" class="AlignRight">TOTAL</th>
							<th>{$MyOrder.currency_shortname} {$MyOrder.pay_amount_ca|number_format:$MyOrder.currency_precision}</th>
							<td></td>
						</tr>
					</table>
					<br />
				</div>
			</div>
			{if $Site.site_module_inventory_enable == 'Y' || $Site.site_module_inventory_partial_shipment == 'Y'}
				{if $MyOrder.payment_confirmed == 'Y'}
					<div id="MyOrderTabsPanel-Shipment">
						<br />
						<div class="AdminEditDetailsBlock">
							{if $StockTransactionProducts|@count > 0}
								<h2>Outstanding Shipment List &nbsp;
									<a href="stock_shipment_add.php?id={$MyOrder.myorder_id}" class="ui-state-default ui-corner-all MyButton">
										<span class="ui-icon ui-icon-pencil"></span> Make Shipment
									</a>
								</h2>
								<br />
								<table class="TopHeaderTable">
									<tr>
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
								<hr />
							{/if}
							<br />
							{if $ShipmentList|@count > 0}
								<h2>Shipment List</h2>
								<br />
								<table class="TopHeaderTable">
									<tr>
										<th>Shipment ID</th>
										<th>Delivery Date</th>
										<th>Confirm by</th>
										<th>Details</th>
									</tr>
									{foreach from=$ShipmentList item=S}
										<tr>
											<td class="AlignCenter">{$S.stock_transaction_id}</td>
											<td class="AlignCenter">
												{$S.shipment_delivery_date|date_format:'%Y-%m-%d'}
											</td>
											<td>{$S.stock_shipment_confirm_by} ({$S.stock_shipment_confirm_date}) </td>
											<td class="AlignCenter">
												<a href="stock_shipment_details.php?id={$S.stock_transaction_id}" class="ui-state-default ui-corner-all MyButton">
													<span class="ui-icon ui-icon-pencil"></span> Details
												</a>
											</td>
										</tr>
									{/foreach}
								</table>
							{else}
								No shipment has been made yet.
							{/if}
						</div>
					</div>
				{/if}
			{/if}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> Submit
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> Reset
				</a>
			</div>
		</div>
	</form>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
