{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Discount Rule Test</h1>

<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_rule_test_act.php">
	Discount Code: <input type="text" name="cart_content_rule_test_discount_code" value="{$CartDetailsObj->discount_code}" /> <br />
	User Security Level: <input type="text" name="user_security_level" value="{$smarty.request.user_security_level|intval}" /> <br />
	Currency: 
		<select name="currency_id">
			{foreach $CurrencyList as $C}
				<option value="{$C.currency_id}" {if $smarty.request.currency_id == $C.currency_id}selected='selected'{/if}>
					{$C.currency_shortname}
				</option>
			{/foreach}					
		</select>
	<br />
	<table id="DiscountRuleTestTable" class="TopHeaderTable AlignLeft">
		<tr class="ui-state-highlight">
			<th><a id="AddMoreDiscountRuleProduct" class="ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-plus"></span></a></th>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price Option</th>
			<th>Custom Key</th>
		</tr>
		<tr class="DiscountRuleTestInput Hidden">
			<td class="AlignLeft"><a class="RemoveDiscountRuleTestLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
			<td>
				<select name="product_id_product_option_id[]">
					{foreach $ProductList as $P}
						<option value="{$P.product_id}_{$P.product_option_id|intval}">
							{$P.object_name}
							{if $P.product_option_id|intval != 0}({$P.product_option_id}){/if}
							{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
								{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
								{$P.$myfield}
							{/section}
						</option>
					{/foreach}
				</select>
			</td>
			<td>
				<input type="text" name="quantity[]" size="3" />
			</td>
			<td>
				<select name="product_price_id[]">
					{foreach $ProductPriceOption as $key => $value}
						<option value="{$key}">
							{$value}
						</option>
					{/foreach}
				</select>
			</td>
			<td>
				<input type="text" name="cart_content_custom_key[]" />
			</td>
		</tr>
		{foreach from=$CartItemList item=C}
			<tr class="DiscountRuleTestInput">
				<td class="AlignLeft"><a class="RemoveDiscountRuleTestLink ui-state-default ui-corner-all MyIconButton"><span class="ui-icon ui-icon-minus"></span></a></td>
				<td>
					<select name="product_id_product_option_id[]">
						{foreach $ProductList as $P}
							<option value="{$P.product_id}_{$P.product_option_id|intval}" {if $C.product_id==$P.product_id && $C.product_option_id==$P.product_option_id|intval}selected="selected"{/if}>
								{$P.object_name}
								{if $P.product_option_id|intval != 0}({$P.product_option_id}){/if}
								{section name=foo start=0 loop=$ProductFieldsShow.product_option_show_no|intval}
									{assign var='myfield' value="product_option_data_text_`$smarty.section.foo.iteration`"}
									{$P.$myfield}
								{/section}
							</option>
						{/foreach}
					</select>
				</td>
				<td>
					<input type="text" name="quantity[]" size="3" value="{$C.quantity}" />
				</td>
				<td>
					<select name="product_price_id[]">
						{foreach $ProductPriceOption as $key => $value}
							<option value="{$key}" {if $key==$C.product_price_id}selected{/if}>
								{$value}
							</option>
						{/foreach}
					</select>
				</td>
				<td>
					<input type="text" name="cart_content_custom_key[]" value="{$C.cart_content_custom_key}" />
				</td>
			</tr>
		{/foreach}
	</table>
	<br />
	<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-circle-plus"></span> Submit
	</a>
</form>

<hr />

<h2>Simulated Result</h2>
<p>
	{$Cart->total_applied_discount_rule_no_by_discount_code} / {$Cart->total_possible_discount_rule_no_by_discount_code}
</p>
<table class="TopHeaderTable AlignCenter">
	<tr class="ui-state-highlight">
		<th class="AlignLeft">ID</th>		
		<th class="AlignLeft">Product Code</th>
		<th width="350" class="AlignLeft">Product Reference Name</th>
		<th>Quantity</th>
		<th>Original Price</th>
		<th>Unit Price</th>
		<th>Total Price</th>
		<th>Required Bonus Point</th>
		<th>Bonus Point</th>
		<th>Custom Key</th>
	</tr>
	{foreach $Cart->calculated_product_list as $M}
		<tr>
			<td class="AlignLeft">{$M->product_id}</td>
			<td class="AlignLeft">{$M->product_code}</td>
			<td class="AlignLeft">
				{$M->object_name} 
				{if $M->product_option_id != 0}({$M->product_option_id}){/if}
			</td>
			<td>{$M->quantity}</td>
			<td>{$M->product_base_price_ca|number_format:$Currency.currency_precision}</td>
			<td>
				{if $M->actual_unit_price_ca == 0}
					-
				{else}
					{$M->currency_shortname} {$M->actual_unit_price_ca|number_format:$Currency.currency_precision}
				{/if}
			</td>
			<td>
				{if $M->effective_discount_type == 0}
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}
				{/if}
    			{if $M->effective_discount_type == 1}
	    			{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision} <br />
    				(*{$M->discount1_off_p}% Off)
    			{elseif $M->effective_discount_type == 2}
    				{if $M->actual_subtotal_price_ca == 0}
    					-
    				{else}
						{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision} <br />
						(*{$M->currency_shortname} {$M->discount2_price_ca|number_format:$Currency.currency_precision} for {$M->discount2_amount})
    				{/if}
    			{elseif $M->effective_discount_type == 3}
					(*Buy {$M->discount3_buy_amount} Get {$M->discount3_free_amount} Free)
    			{elseif $M->effective_discount_type == 4}
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}
				{elseif $M->effective_discount_type == 5}
					Preprocess Rule #{$M->effective_discount_preprocess_rule_id} <br />
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}
				{elseif $M->effective_discount_type == 6}
					Bundle Rule #{$M->effective_discount_bundle_rule_id} <br />
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}					
    			{/if}
    		</td>
			<td class="AlignCenter">{$M->product_bonus_point_required}</td>
			<td class="AlignCenter">{$M->product_bonus_point_amount}</td>
			<td class="AlignCenter">{$M->cart_content_custom_key}</td>
		</tr>
	{/foreach}
	<tr>
		<th colspan="6" class="AlignRight">Sub-Total</th>
		<th>{$Currency.currency_shortname} {$Cart->total_price_ca|number_format:$Currency.currency_precision}</th>
		<th>{$Cart->total_bonus_point_required}</th>
		<th>{$Cart->total_bonus_point}</th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">Discount</th>
		<th>
			{if $Cart->effective_discount_postprocess_rule_id != 0}Postprocess Rule #{$Cart->effective_discount_postprocess_rule_id} <br />{/if}
			{$Currency.currency_shortname} {$Cart->postprocess_rule_discount_amount_ca|number_format:$Currency.currency_precision}
		</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">FreightCost</th>
		<th>
			{$Currency.currency_shortname} {$Cart->calculated_freight_cost_ca|number_format:$Currency.currency_precision}
		</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">Price to PAY</th>
		<th>{$Cart->pay_amount_ca|number_format:$Currency.currency_precision}</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
</table>


{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}