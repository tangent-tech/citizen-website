{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_sales_report.tpl"}
<h1 class="PageTitle">Sales Report (Payment Method) &nbsp; 
</h1>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">

	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post">
		<input class="DatePicker" name="order_start_date" value="{$smarty.request.order_start_date}" />
		-
		<input class="DatePicker" name="order_end_date" value="{$smarty.request.order_end_date}" /> <br />
		
		Shop: 
		<select name="shop_id">
			<option value="all" {if $smarty.request.shop_id=='all'}selected="selected"{/if}>ALL</option>
			{foreach $ShopList as $S}
				<option value="{$S.shop_id}" {if $smarty.request.shop_id==$S.shop_id}selected="selected"{/if}>{$S.shop_name}</option>			
			{/foreach}
		</select>
		
		Country: 
		<select name="country_id">
			<option value="0" {if $smarty.request.shop_id=='0'}selected="selected"{/if}>ALL</option>
			{foreach $CountryList as $C}
				<option value="{$C.country_id}" {if $smarty.request.country_id==$C.country_id}selected="selected"{/if}>{$C.country_name_en_only}</option>			
			{/foreach}
		</select>
		
		<br />
		<input class="MySubmitButton" type="submit" value="Submit" />
	</form>
	<br />
	<table id="SalesReportTable" class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>Shop</th>
			<th>Country</th>
			<th>Currency</th>
			<th>No Of Orders</th>
			<th>Pay Amount</th>
			<th>Product Price</th>
			<th>Freight</th>
			<th>Post Discount Rule Discount</th>
			<th>Special Discount</th>
			<th>BP Earned</th>
			<th>BP Redeemed</th>
		</tr>
		{foreach $NormalReportTotal as $R}
			<tr class="AlignCenter ui-state-highlight">
				<td></td>
				<td></td>
				<td>{$R.currency_shortname}</td>
				<td>{$R.no_of_orders}</td>
				<td>${$R.sum_pay_amount_ca|number_format:2}</td>
				<td>${$R.sum_total_price_ca|number_format:2}</td>
				<td>${$R.sum_freight_cost_ca|number_format:2}</td>
				<td>${$R.sum_postprocess_rule_discount_amount_ca|number_format:2}</td>
				<td>${$R.sum_discount_amount_ca|number_format:2}</td>
				<td>{$R.sum_bonus_point_earned}</td>
				<td>{$R.sum_bonus_point_redeemed}</td>
			</tr>
		{/foreach}
		{foreach $NormalReport as $R}
			<tr class="AlignCenter">
				<td>{$R.shop_name}</td>
				<td>{$R.country_name_en_only}</td>
				<td>{$R.currency_shortname}</td>
				<td>{$R.no_of_orders}</td>
				<td>${$R.sum_pay_amount_ca|number_format:2}</td>
				<td>${$R.sum_total_price_ca|number_format:2}</td>
				<td>${$R.sum_freight_cost_ca|number_format:2}</td>
				<td>${$R.sum_postprocess_rule_discount_amount_ca|number_format:2}</td>
				<td>${$R.sum_discount_amount_ca|number_format:2}</td>
				<td>{$R.sum_bonus_point_earned}</td>
				<td>{$R.sum_bonus_point_redeemed}</td>
			</tr>
		{/foreach}
		<tr class="ui-state-highlight">
			<th colspan="11">VOID orders</th>
		</tr>
		{if $VoidReport|count > 0}
			{foreach $VoidReportTotal as $R}
				<tr class="AlignCenter ui-state-highlight">
					<td></td>
					<td></td>
					<td>{$R.currency_shortname}</td>
					<td>{$R.no_of_orders}</td>
					<td>${$R.sum_pay_amount_ca|number_format:2}</td>
					<td>${$R.sum_total_price_ca|number_format:2}</td>
					<td>${$R.sum_freight_cost_ca|number_format:2}</td>
					<td>${$R.sum_postprocess_rule_discount_amount_ca|number_format:2}</td>
					<td>${$R.sum_discount_amount_ca|number_format:2}</td>
					<td>{$R.sum_bonus_point_earned}</td>
					<td>{$R.sum_bonus_point_redeemed}</td>
				</tr>
			{/foreach}
			{foreach $VoidReport as $R}
				<tr class="AlignCenter">
					<td>{$R.shop_name}</td>
					<td>{$R.country_name_en_only}</td>
					<td>{$R.currency_shortname}</td>
					<td>{$R.no_of_orders}</td>
					<td>${$R.sum_pay_amount_ca|number_format:2}</td>
					<td>${$R.sum_total_price_ca|number_format:2}</td>
					<td>${$R.sum_freight_cost_ca|number_format:2}</td>
					<td>${$R.sum_postprocess_rule_discount_amount_ca|number_format:2}</td>
					<td>${$R.sum_discount_amount_ca|number_format:2}</td>
					<td>{$R.sum_bonus_point_earned}</td>
					<td>{$R.sum_bonus_point_redeemed}</td>
				</tr>
			{/foreach}
		{else}
			<tr>
				<th colspan="11">no orders</th>
			</tr>			
		{/if}
	</table>
	<br />
	<table id="ProductReportTable" class="TopHeaderTable">
		<tr class="ui-state-highlight">
			<th>Shop</th>
			<th>Product Code</th>
			<th>Product Name</th>
			<th>No Of Orders</th>
			<th>Quantity</th>
			<th>Currency</th>
			<th>Price</th>
			<th>BP Redeemed</th>
		</tr>
		{foreach $ProductReport as $R}
			<tr class="AlignCenter">
				<td>{$R.shop_name}</td>
				<td>{$R.product_code}</td>
				<td>{$R.product_name}</td>
				<td>{$R.no_of_orders}</td>
				<td>{$R.sum_quantity}</td>
				<td>{$R.currency_shortname}</td>
				<td>${$R.sum_actual_subtotal_price_ca|number_format:2}</td>
				<td>{$R.sum_product_bonus_point_required}</td>
			</tr>
		{/foreach}
	</table>
	
</div>
<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}