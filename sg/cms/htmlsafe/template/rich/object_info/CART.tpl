<product>
	<cart_content_id>{$Object.cart_content_id}</cart_content_id>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_OPTION.tpl"}

	<quantity>{$Object.quantity}</quantity>
	<currency_id>{$Currency.currency_id}</currency_id>
	<product_price_ca>{$Object.product_price_ca}</product_price_ca>
	<actual_unit_price>{$Object.actual_unit_price}</actual_unit_price>
	<actual_unit_price_ca>{$Object.actual_unit_price_ca}</actual_unit_price_ca>
	<actual_subtotal_price>{$Object.actual_subtotal_price}</actual_subtotal_price>
	<actual_subtotal_price_ca>{$Object.actual_subtotal_price_ca}</actual_subtotal_price_ca>
	<effective_discount_type>{$Object.effective_discount_type}</effective_discount_type>
	<effective_discount_preprocess_rule_id>{$Object.effective_discount_preprocess_rule_id}</effective_discount_preprocess_rule_id>
</product>