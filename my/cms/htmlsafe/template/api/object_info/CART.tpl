<product>
	{include file="api/object_info/PRODUCT_OPTION.tpl" Object=$ProductOption}
	<cart_content_id>{$CartResultProduct->cart_content_id}</cart_content_id>
	<product_price_id>{$CartResultProduct->product_price_id}</product_price_id>
	<cart_content_custom_key>{$CartResultProduct->cart_content_custom_key|myxml}</cart_content_custom_key>
	<cart_content_custom_desc>{$CartResultProduct->cart_content_custom_desc|myxml}</cart_content_custom_desc>
	<quantity>{$CartResultProduct->quantity}</quantity>
	<currency_id>{$CurrencyObj->currency_id}</currency_id>
	<product_base_price>{$CartResultProduct->product_base_price}</product_base_price>
	<product_base_price_ca>{$CartResultProduct->product_base_price_ca}</product_base_price_ca>
	<product_price_ca>{$CartResultProduct->product_price_ca}</product_price_ca>
	<product_price2_ca>{$CartResultProduct->product_price2_ca}</product_price2_ca>
	<product_price3_ca>{$CartResultProduct->product_price3_ca}</product_price3_ca>
	<actual_unit_price>{$CartResultProduct->actual_unit_price}</actual_unit_price>
	<actual_unit_price_ca>{$CartResultProduct->actual_unit_price_ca}</actual_unit_price_ca>
	<actual_subtotal_price>{$CartResultProduct->actual_subtotal_price}</actual_subtotal_price>
	<actual_subtotal_price_ca>{$CartResultProduct->actual_subtotal_price_ca}</actual_subtotal_price_ca>
	<effective_discount_type>{$CartResultProduct->effective_discount_type}</effective_discount_type>
	<effective_discount_preprocess_rule_id>{$CartResultProduct->effective_discount_preprocess_rule_id}</effective_discount_preprocess_rule_id>
	<effective_discount_preprocess_rule_name>{$CartResultProduct->effective_discount_preprocess_rule_name}</effective_discount_preprocess_rule_name>
	<effective_discount_bundle_rule_id>{$CartResultProduct->effective_discount_bundle_rule_id}</effective_discount_bundle_rule_id>
	<effective_discount_bundle_rule_name>{$CartResultProduct->effective_discount_bundle_rule_name}</effective_discount_bundle_rule_name>
	<product_bonus_point_required>{$CartResultProduct->product_bonus_point_required}</product_bonus_point_required>
	<quantity_adjusted>{$CartResultProduct->quantity_adjusted|ynval}</quantity_adjusted>
	<quantity_original>{$CartResultProduct->quantity_original}</quantity_original>
	{$ProductXML}
</product>