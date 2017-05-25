<cart_details>
	<cart_details_id>{$Object.cart_details_id}</cart_details_id>
	<cart_content_type>{$Object.cart_content_type}</cart_content_type>
	<user_id>{$Object.user_id}</user_id>
	<self_take>{$Object.self_take}</self_take>
	<bonus_point_item_id>{$Object.bonus_point_item_id}</bonus_point_item_id>
	<use_bonus_point>{$Object.use_bonus_point}</use_bonus_point>
	<deliver_to_different_address>{$Object.deliver_to_different_address}</deliver_to_different_address>
	<update_user_address>{$Object.update_user_address}</update_user_address>
	<email_order_confirm>{$Object.email_order_confirm}</email_order_confirm>
	<join_mailing_list>{$Object.join_mailing_list}</join_mailing_list>
	<invoice_country_id>{$Object.invoice_country_id}</invoice_country_id>
	<invoice_hk_district_id>{$Object.invoice_hk_district_id}</invoice_hk_district_id>
	<invoice_first_name>{$Object.invoice_first_name|myxml}</invoice_first_name>
	<invoice_last_name>{$Object.invoice_last_name|myxml}</invoice_last_name>
	<invoice_company_name>{$Object.invoice_company_name|myxml}</invoice_company_name>
	<invoice_city_name>{$Object.invoice_city_name|myxml}</invoice_city_name>
	<invoice_region>{$Object.invoice_region|myxml}</invoice_region>
	<invoice_postcode>{$Object.invoice_postcode|myxml}</invoice_postcode>
	<invoice_phone_no>{$Object.invoice_phone_no|myxml}</invoice_phone_no>
	<invoice_tel_country_code>{$Object.invoice_tel_country_code|myxml}</invoice_tel_country_code>
	<invoice_tel_area_code>{$Object.invoice_tel_area_code|myxml}</invoice_tel_area_code>
	<invoice_fax_no>{$Object.invoice_fax_no|myxml}</invoice_fax_no>
	<invoice_fax_country_code>{$Object.invoice_fax_country_code|myxml}</invoice_fax_country_code>
	<invoice_fax_area_code>{$Object.invoice_fax_area_code|myxml}</invoice_fax_area_code>
	<invoice_shipping_address_1>{$Object.invoice_shipping_address_1|myxml}</invoice_shipping_address_1>
	<invoice_shipping_address_2>{$Object.invoice_shipping_address_2|myxml}</invoice_shipping_address_2>
	<invoice_email>{$Object.invoice_email|myxml}</invoice_email>
	<delivery_country_id>{$Object.delivery_country_id}</delivery_country_id>
	<delivery_hk_district_id>{$Object.delivery_hk_district_id}</delivery_hk_district_id>
	<delivery_first_name>{$Object.delivery_first_name|myxml}</delivery_first_name>
	<delivery_last_name>{$Object.delivery_last_name|myxml}</delivery_last_name>
	<delivery_company_name>{$Object.delivery_company_name|myxml}</delivery_company_name>
	<delivery_city_name>{$Object.delivery_city_name|myxml}</delivery_city_name>
	<delivery_region>{$Object.delivery_region|myxml}</delivery_region>
	<delivery_postcode>{$Object.delivery_postcode|myxml}</delivery_postcode>
	<delivery_phone_no>{$Object.delivery_phone_no|myxml}</delivery_phone_no>
	<delivery_tel_country_code>{$Object.delivery_tel_country_code|myxml}</delivery_tel_country_code>
	<delivery_tel_area_code>{$Object.delivery_tel_area_code|myxml}</delivery_tel_area_code>
	<delivery_fax_no>{$Object.delivery_fax_no|myxml}</delivery_fax_no>
	<delivery_fax_country_code>{$Object.delivery_fax_country_code|myxml}</delivery_fax_country_code>
	<delivery_fax_area_code>{$Object.delivery_fax_area_code|myxml}</delivery_fax_area_code>
	<delivery_shipping_address_1>{$Object.delivery_shipping_address_1|myxml}</delivery_shipping_address_1>
	<delivery_shipping_address_2>{$Object.delivery_shipping_address_2|myxml}</delivery_shipping_address_2>
	<delivery_email>{$Object.delivery_email|myxml}</delivery_email>
	<user_message>{$Object.user_message|myxml}</user_message>
	<create_date>{$Object.create_date|myxml}</create_date>
	<total_quantity>{$TotalCartQuantity}</total_quantity>
	<total_price>{$TotalPrice}</total_price>
	<total_price_ca>{$TotalPriceCA}</total_price_ca>
	<total_bonus_point>{$TotalBonusPoint}</total_bonus_point>
	<pay_amount_ca>{$PayAmountCA}</pay_amount_ca>
	<total_bonus_point_required>{$TotalBonusPointRequired}</total_bonus_point_required>
	<total_cash_value>{$TotalCashValue}</total_cash_value>
	<total_cash_value_ca>{$TotalCashValueCA}</total_cash_value_ca>
	<cart_item_list>{$CartItemListXML}</cart_item_list>
	<cart_bonus_point_item_list>{$CartBonusPointItemListXML}</cart_bonus_point_item_list>
	<cart_freight_cost_ca>{$FreightCostCA}</cart_freight_cost_ca>
	<discount_code>{$Object.discount_code}</discount_code>
	<postprocess_rule_discount_amount>{$PostprocessDiscount}</postprocess_rule_discount_amount>
	<postprocess_rule_discount_amount_ca>{$PostprocessDiscountCA}</postprocess_rule_discount_amount_ca>
	<effective_discount_postprocess_rule_id>{$PostprocessDiscountRuleID}</effective_discount_postprocess_rule_id>
	<effective_discount_postprocess_rule_discount_code>{$EffectivePostprocessDiscountCode}</effective_discount_postprocess_rule_discount_code>
	{assign var='object_type' value='myorder'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
</cart_details>