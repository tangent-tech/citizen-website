{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">折扣規則測試</h1>

<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="discount_rule_test_act.php">
	折扣碼: <input type="text" name="cart_content_rule_test_discount_code" value="{$CartInfo.discount_code}" /> <br />
	用戶安全等級: <input type="text" name="user_security_level" value="{$smarty.request.user_security_level|intval}" /> <br />
	貨幣: 
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
			<th>產品</th>
			<th>數量</th>
			<th>價格</th>
			<th>自訂鍵</th>
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
		<span class="ui-icon ui-icon-circle-plus"></span> 確定
	</a>
</form>

<hr />

<h2>模擬結果</h2>
<p>
	{$Cart->total_applied_discount_rule_no_by_discount_code} / {$Cart->total_possible_discount_rule_no_by_discount_code}
</p>
<table class="TopHeaderTable AlignCenter">
	<tr class="ui-state-highlight">
		<th class="AlignLeft">id</th>
		<th class="AlignLeft">產品編號</th>
		<th width="350" class="AlignLeft">產品參考名稱</th>
		<th>數量</th>
		<th>原價</th>
		<th>單價</th>
		<th>總價格</th>
		<th>所需積分</th>
		<th>積分獎賞</th>
		<th>自訂鍵</th>
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
    				(*{$M->discount1_off_p}% 扣減)
    			{elseif $M->effective_discount_type == 2}
    				{if $M->actual_subtotal_price_ca == 0}
    					-
    				{else}
						{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision} <br />
						(*{$M->currency_shortname} {$M->discount2_price_ca|number_format:$Currency.currency_precision} {$M->discount2_amount})件
    				{/if}
    			{elseif $M->effective_discount_type == 3}
					(*買 {$M->discount3_buy_amount} 送 {$M->discount3_free_amount} )
    			{elseif $M->effective_discount_type == 4}
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}
				{elseif $M->effective_discount_type == 5}
					前處理折扣規則 #{$M->effective_discount_preprocess_rule_id} <br />
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}
				{elseif $M->effective_discount_type == 6}
					捆綁折扣規則 #{$M->effective_discount_bundle_rule_id} <br />
					{$M->currency_shortname} {$M->actual_subtotal_price_ca|number_format:$Currency.currency_precision}					
    			{/if}
    		</td>
			<td class="AlignCenter">{$M->product_bonus_point_required}</td>
			<td class="AlignCenter">{$M->product_bonus_point_amount}</td>
			<td class="AlignCenter">{$M->cart_content_custom_key}</td>
		</tr>
	{/foreach}
	<tr>
		<th colspan="6" class="AlignRight">小計</th>
		<th>{$Currency.currency_shortname} {$Cart->total_price_ca|number_format:$Currency.currency_precision}</th>
		<th>{$Cart->total_bonus_point_required}</th>
		<th>{$Cart->total_bonus_point}</th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">折扣</th>
		<th>
			{if $Cart->effective_discount_postprocess_rule_id != 0}Postprocess Rule #{$Cart->effective_discount_postprocess_rule_id} <br />{/if}
			{$Currency.currency_shortname} {$Cart->postprocess_rule_discount_amount_ca|number_format:$Currency.currency_precision}
		</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">運費</th>
		<th>
			{$Currency.currency_shortname} {$Cart->calculated_freight_cost_ca|number_format:$Currency.currency_precision}
		</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<th colspan="6" class="AlignRight">實際付款價錢</th>
		<th>{$Cart->pay_amount_ca|number_format:$Currency.currency_precision}</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
</table>


{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}