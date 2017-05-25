<myorder_product>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_OPTION.tpl"}
	<myorder_id>{$Object.myorder_id}</myorder_id>
	<currency_id>{$Object.currency_id}</currency_id>
	<product_base_price>{$Object.product_base_price}</product_base_price>
	<product_base_price_ca>{$Object.product_base_price_ca}</product_base_price_ca>
	<product_price_ca>{$Object.product_price_ca}</product_price_ca>
	<product_price2_ca>{$Object.product_price2_ca}</product_price2_ca>
	<product_price3_ca>{$Object.product_price3_ca}</product_price3_ca>
	<product_bonus_point_amount>{$Object.product_bonus_point_amount}</product_bonus_point_amount>
	<actual_subtotal_price>{$Object.actual_subtotal_price}</actual_subtotal_price>
	<actual_subtotal_price_ca>{$Object.actual_subtotal_price_ca}</actual_subtotal_price_ca>
	<actual_unit_price>{$Object.actual_unit_price}</actual_unit_price>
	<actual_unit_price_ca>{$Object.actual_unit_price_ca}</actual_unit_price_ca>
	<quantity>{$Object.quantity}</quantity>	
	<effective_discount_type>{$Object.effective_discount_type}</effective_discount_type>
	<effective_discount_preprocess_rule_id>{$Object.effective_discount_preprocess_rule_id}</effective_discount_preprocess_rule_id>
	<effective_discount_preprocess_rule_name>{$Object.effective_discount_preprocess_rule_name}</effective_discount_preprocess_rule_name>
	<effective_discount_bundle_rule_id>{$Object.effective_discount_bundle_rule_id}</effective_discount_bundle_rule_id>	
	<effective_discount_bundle_rule_name>{$Object.effective_discount_bundle_rule_name}</effective_discount_bundle_rule_name>	
	<effective_discount_postprocess_rule_id>{$Object.effective_discount_postprocess_rule_id}</effective_discount_postprocess_rule_id>
	<discount1_off_p>{$Object.discount1_off_p}</discount1_off_p>
	<discount2_amount>{$Object.discount2_amount}</discount2_amount>
	<discount2_price>{$Object.discount2_price}</discount2_price>
	<discount2_price_ca>{$Object.discount2_price_ca}</discount2_price_ca>
	<discount3_buy_amount>{$Object.discount3_buy_amount}</discount3_buy_amount>
	<discount3_free_amount>{$Object.discount3_free_amount}</discount3_free_amount>
	<product_price_id>{$Object.product_price_id}</product_price_id>
	<cart_content_custom_key>{$Object.cart_content_custom_key|myxml}</cart_content_custom_key>
	<cart_content_custom_desc>{$Object.cart_content_custom_desc|myxml}</cart_content_custom_desc>
	<product_bonus_point_required>{$Object.product_bonus_point_required}</product_bonus_point_required>	
</myorder_product>