<cart_details>
	<cart_details_id>{$cart->getCartDetailsObj()->cart_details_id}</cart_details_id>
	<cart_content_type>{$cart->getCartDetailsObj()->cart_content_type}</cart_content_type>
	<user_id>{$cart->getCartDetailsObj()->user_id}</user_id>
	<self_take>{$cart->getCartDetailsObj()->self_take}</self_take>
	<cart_quantity_adjusted>{$cart->getCartDetailsObj()->under_stock_adjustment|ynval}</cart_quantity_adjusted>
	<effective_base_price_id>{$cart->getCartDetailsObj()->effective_base_price_id}</effective_base_price_id>
	<bonus_point_item_id>{$cart->getCartDetailsObj()->bonus_point_item_id}</bonus_point_item_id>
	<use_bonus_point>{$cart->getCartDetailsObj()->use_bonus_point}</use_bonus_point>
	<user_balance_use>{$cart->getCartDetailsObj()->user_balance_use}</user_balance_use>
	<deliver_to_different_address>{$cart->getCartDetailsObj()->deliver_to_different_address}</deliver_to_different_address>
	<update_user_address>{$cart->getCartDetailsObj()->update_user_address}</update_user_address>
	<email_order_confirm>{$cart->getCartDetailsObj()->email_order_confirm}</email_order_confirm>
	<join_mailing_list>{$cart->getCartDetailsObj()->join_mailing_list}</join_mailing_list>
	<invoice_country_id>{$cart->getCartDetailsObj()->invoice_country_id}</invoice_country_id>
	<invoice_country_other>{$cart->getCartDetailsObj()->invoice_country_other|myxml}</invoice_country_other>
	<invoice_hk_district_id>{$cart->getCartDetailsObj()->invoice_hk_district_id}</invoice_hk_district_id>
	<invoice_first_name>{$cart->getCartDetailsObj()->invoice_first_name|myxml}</invoice_first_name>
	<invoice_last_name>{$cart->getCartDetailsObj()->invoice_last_name|myxml}</invoice_last_name>
	<invoice_company_name>{$cart->getCartDetailsObj()->invoice_company_name|myxml}</invoice_company_name>
	<invoice_city_name>{$cart->getCartDetailsObj()->invoice_city_name|myxml}</invoice_city_name>
	<invoice_region>{$cart->getCartDetailsObj()->invoice_region|myxml}</invoice_region>
	<invoice_postcode>{$cart->getCartDetailsObj()->invoice_postcode|myxml}</invoice_postcode>
	<invoice_phone_no>{$cart->getCartDetailsObj()->invoice_phone_no|myxml}</invoice_phone_no>
	<invoice_tel_country_code>{$cart->getCartDetailsObj()->invoice_tel_country_code|myxml}</invoice_tel_country_code>
	<invoice_tel_area_code>{$cart->getCartDetailsObj()->invoice_tel_area_code|myxml}</invoice_tel_area_code>
	<invoice_fax_no>{$cart->getCartDetailsObj()->invoice_fax_no|myxml}</invoice_fax_no>
	<invoice_fax_country_code>{$cart->getCartDetailsObj()->invoice_fax_country_code|myxml}</invoice_fax_country_code>
	<invoice_fax_area_code>{$cart->getCartDetailsObj()->invoice_fax_area_code|myxml}</invoice_fax_area_code>
	<invoice_shipping_address_1>{$cart->getCartDetailsObj()->invoice_shipping_address_1|myxml}</invoice_shipping_address_1>
	<invoice_shipping_address_2>{$cart->getCartDetailsObj()->invoice_shipping_address_2|myxml}</invoice_shipping_address_2>
	<invoice_email>{$cart->getCartDetailsObj()->invoice_email|myxml}</invoice_email>
	<delivery_country_id>{$cart->getCartDetailsObj()->delivery_country_id}</delivery_country_id>
	<delivery_country_other>{$cart->getCartDetailsObj()->delivery_country_other|myxml}</delivery_country_other>
	<delivery_hk_district_id>{$cart->getCartDetailsObj()->delivery_hk_district_id}</delivery_hk_district_id>
	<delivery_first_name>{$cart->getCartDetailsObj()->delivery_first_name|myxml}</delivery_first_name>
	<delivery_last_name>{$cart->getCartDetailsObj()->delivery_last_name|myxml}</delivery_last_name>
	<delivery_company_name>{$cart->getCartDetailsObj()->delivery_company_name|myxml}</delivery_company_name>
	<delivery_city_name>{$cart->getCartDetailsObj()->delivery_city_name|myxml}</delivery_city_name>
	<delivery_region>{$cart->getCartDetailsObj()->delivery_region|myxml}</delivery_region>
	<delivery_postcode>{$cart->getCartDetailsObj()->delivery_postcode|myxml}</delivery_postcode>
	<delivery_phone_no>{$cart->getCartDetailsObj()->delivery_phone_no|myxml}</delivery_phone_no>
	<delivery_tel_country_code>{$cart->getCartDetailsObj()->delivery_tel_country_code|myxml}</delivery_tel_country_code>
	<delivery_tel_area_code>{$cart->getCartDetailsObj()->delivery_tel_area_code|myxml}</delivery_tel_area_code>
	<delivery_fax_no>{$cart->getCartDetailsObj()->delivery_fax_no|myxml}</delivery_fax_no>
	<delivery_fax_country_code>{$cart->getCartDetailsObj()->delivery_fax_country_code|myxml}</delivery_fax_country_code>
	<delivery_fax_area_code>{$cart->getCartDetailsObj()->delivery_fax_area_code|myxml}</delivery_fax_area_code>
	<delivery_shipping_address_1>{$cart->getCartDetailsObj()->delivery_shipping_address_1|myxml}</delivery_shipping_address_1>
	<delivery_shipping_address_2>{$cart->getCartDetailsObj()->delivery_shipping_address_2|myxml}</delivery_shipping_address_2>
	<delivery_email>{$cart->getCartDetailsObj()->delivery_email|myxml}</delivery_email>
	<user_message>{$cart->getCartDetailsObj()->user_message|myxml}</user_message>
	<create_date>{$cart->getCartDetailsObj()->create_date|myxml}</create_date>
	<total_quantity>{$cart->total_quantity}</total_quantity>
	<total_price>{$cart->total_price}</total_price>
	<total_price_ca>{$cart->total_price_ca}</total_price_ca>
	<total_bonus_point>{$cart->total_bonus_point}</total_bonus_point>
	<pay_amount_ca>{$cart->pay_amount_ca}</pay_amount_ca>
	<cash_paid_ca>{$cart->cash_paid_ca}</cash_paid_ca>
	<cash_change_ca>{$cart->cash_change_ca}</cash_change_ca>
	<cash_paid>{$cart->getCartDetailsObj()->cash_paid}</cash_paid>
	<cash_paid_currency_id>{$cart->getCartDetailsObj()->cash_paid_currency_id}</cash_paid_currency_id>	
	<total_bonus_point_required>{$cart->total_bonus_point_required}</total_bonus_point_required>
	<total_cash_value>{$cart->total_cash_value}</total_cash_value>
	<total_cash_value_ca>{$cart->total_cash_value_ca}</total_cash_value_ca>
	<cart_item_list>{$CartItemListXML}</cart_item_list>
	<cart_bonus_point_item_list>{$CartBonusPointItemListXML}</cart_bonus_point_item_list>
	<cart_freight_cost_ca>{$cart->calculated_freight_cost_ca}</cart_freight_cost_ca>
	<discount_code>{$cart->getCartDetailsObj()->discount_code}</discount_code>
	<postprocess_rule_discount_amount>{$cart->postprocess_rule_discount_amount}</postprocess_rule_discount_amount>
	<postprocess_rule_discount_amount_ca>{$cart->postprocess_rule_discount_amount_ca}</postprocess_rule_discount_amount_ca>
	<effective_discount_postprocess_rule_id>{$cart->effective_discount_postprocess_rule_id}</effective_discount_postprocess_rule_id>
	<effective_discount_postprocess_rule_discount_code>{$cart->effective_discount_postprocess_rule_discount_code}</effective_discount_postprocess_rule_discount_code>
	<total_possible_discount_rule_no_by_discount_code>{$cart->total_possible_discount_rule_no_by_discount_code}</total_possible_discount_rule_no_by_discount_code>
	<total_applied_discount_rule_no_by_discount_code>{$cart->total_applied_discount_rule_no_by_discount_code}</total_applied_discount_rule_no_by_discount_code>
	{assign var='object_type' value='myorder'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$cart->getCartDetailsObj()->$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$cart->getCartDetailsObj()->$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$cart->getCartDetailsObj()->$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $MyorderCustomFieldsDef.$myfield != ''}<{$myfield}>{$cart->getCartDetailsObj()->$myfield|myxml}</{$myfield}>{/if}
	{/section}
	<cart_quantity_adjusted_cart_content_id_list>{$QuantityAdjustedCartContentIDXML}</cart_quantity_adjusted_cart_content_id_list>
</cart_details>