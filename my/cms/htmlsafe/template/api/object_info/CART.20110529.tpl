include PRODUCT_PROTOTYPE and remove common tag
<product>
	<cart_content_id>{$Object.cart_content_id}</cart_content_id>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	{include file="api/object_info/PRODUCT_OPTION.tpl"}
	<product_id>{$Object.product_id}</product_id>
	<is_special_cat_1>{$Object.is_special_cat_1}</is_special_cat_1>
	<is_special_cat_2>{$Object.is_special_cat_2}</is_special_cat_2>
	<is_special_cat_3>{$Object.is_special_cat_3}</is_special_cat_3>
	<is_special_cat_4>{$Object.is_special_cat_4}</is_special_cat_4>
	<product_price>{$Object.product_price}</product_price>
	<product_price_ca>{$Object.product_price_ca}</product_price_ca>
	<product_bonus_point_amount>{$Object.product_bonus_point_amount}</product_bonus_point_amount>
	<discount_type>{$Object.discount_type}</discount_type>
	<discount1_off_p>{$Object.discount1_off_p}</discount1_off_p>
	<discount2_amount>{$Object.discount2_amount}</discount2_amount>
	<discount2_price>{$Object.discount2_price}</discount2_price>
	<discount2_price_ca>{$Object.discount2_price_ca}</discount2_price_ca>
	<discount3_buy_amount>{$Object.discount3_buy_amount}</discount3_buy_amount>
	<discount3_free_amount>{$Object.discount3_free_amount}</discount3_free_amount>
	<product_color_id>{$Object.product_color_id}</product_color_id>
	<color_name>{$Object.color_name|myxml}</color_name>
	<color_image_url>{$Object.color_image_url|myxml}</color_image_url>
	<factory_code>{$Object.factory_code|myxml}</factory_code>
	<product_code>{$Object.product_code|myxml}</product_code>
	<product_weight>{$Object.product_weight}</product_weight>
	<product_size>{$Object.product_size|myxml}</product_size>
	<product_L>{$Object.product_L}</product_L>
	<product_W>{$Object.product_W}</product_W>
	<product_D>{$Object.product_D}</product_D>
	<product_name>{$Object.product_name|myxml}</product_name>
	<product_color>{$Object.product_color|myxml}</product_color>
	<product_desc>{$Object.product_desc|myxml}</product_desc>
	<product_tag>{$Object.product_tag|mytag|myxml}</product_tag>
	<quantity>{$Object.quantity}</quantity>

	<currency_id>{$Currency.currency_id}</currency_id>
	<actual_unit_price>{$Object.actual_unit_price}</actual_unit_price>
	<actual_unit_price_ca>{$Object.actual_unit_price_ca}</actual_unit_price_ca>
	<actual_subtotal_price>{$Object.actual_subtotal_price}</actual_subtotal_price>
	<actual_subtotal_price_ca>{$Object.actual_subtotal_price_ca}</actual_subtotal_price_ca>
	<effective_discount_type>{$Object.effective_discount_type}</effective_discount_type>
</product>