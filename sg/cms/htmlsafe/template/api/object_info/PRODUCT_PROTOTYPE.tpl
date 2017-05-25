	<product_id>{$Object.product_id}</product_id>
	<is_special_cat_1>{$Object.is_special_cat_1}</is_special_cat_1>
	<is_special_cat_2>{$Object.is_special_cat_2}</is_special_cat_2>
	<is_special_cat_3>{$Object.is_special_cat_3}</is_special_cat_3>
	<is_special_cat_4>{$Object.is_special_cat_4}</is_special_cat_4>
	<is_special_cat_5>{$Object.is_special_cat_5}</is_special_cat_5>
	<is_special_cat_6>{$Object.is_special_cat_6}</is_special_cat_6>
	<is_special_cat_7>{$Object.is_special_cat_7}</is_special_cat_7>
	<is_special_cat_8>{$Object.is_special_cat_8}</is_special_cat_8>
	<is_special_cat_9>{$Object.is_special_cat_9}</is_special_cat_9>
	<is_special_cat_10>{$Object.is_special_cat_10}</is_special_cat_10>
	<is_special_cat_11>{$Object.is_special_cat_11}</is_special_cat_11>
	<is_special_cat_12>{$Object.is_special_cat_12}</is_special_cat_12>
	<is_special_cat_13>{$Object.is_special_cat_13}</is_special_cat_13>
	<is_special_cat_14>{$Object.is_special_cat_14}</is_special_cat_14>
	<is_special_cat_15>{$Object.is_special_cat_15}</is_special_cat_15>
	<is_special_cat_16>{$Object.is_special_cat_16}</is_special_cat_16>
	<is_special_cat_17>{$Object.is_special_cat_17}</is_special_cat_17>
	<is_special_cat_18>{$Object.is_special_cat_18}</is_special_cat_18>
	<is_special_cat_19>{$Object.is_special_cat_19}</is_special_cat_19>
	<is_special_cat_20>{$Object.is_special_cat_20}</is_special_cat_20>
	<product_quantity_sold>{$Object.product_quantity_sold}</product_quantity_sold>
	<product_price>{$Object.product_price}</product_price>
	<product_price2>{$Object.product_price2}</product_price2>
	<product_price3>{$Object.product_price3}</product_price3>
	<product_bonus_point_amount>{$Object.product_bonus_point_amount}</product_bonus_point_amount>
	<discount_type>{$Object.discount_type}</discount_type>
	<discount1_off_p>{$Object.discount1_off_p}</discount1_off_p>
	<discount2_amount>{$Object.discount2_amount}</discount2_amount>
	<discount2_price>{$Object.discount2_price}</discount2_price>
	<discount3_buy_amount>{$Object.discount3_buy_amount}</discount3_buy_amount>
	<discount3_free_amount>{$Object.discount3_free_amount}</discount3_free_amount>
	<product_price_level_list>{$ProductPriceLevelListXML}</product_price_level_list>
	<product_price_list>{$ProductPriceListXML}</product_price_list>
	<product_brand_id>{$Object.product_brand_id}</product_brand_id>
	{$ProductBrandXML}
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
	<product_rgb>#{$Object.product_rgb_r|string_format:"%02x"}{$Object.product_rgb_g|string_format:"%02x"}{$Object.product_rgb_b|string_format:"%02x"}</product_rgb>
	<product_packaging>{$Object.product_packaging|myxml}</product_packaging>
	<product_desc>{$Object.product_desc|myxml}</product_desc>
	<product_tag>{$Object.product_tag|mytag|myxml}</product_tag>
	<product_option_list>{$ProductOptionListXML}</product_option_list>
	<product_stock_level>{$Object.product_stock_level}</product_stock_level>
	<page_no>{$MediaPageNo}</page_no>
	<media_page_no>{$MediaPageNo}</media_page_no>
	<total_no_of_media>{$TotalNoOfMedia}</total_no_of_media>
	<media_list>{$MediaListXML}</media_list>
	<datafile_page_no>{$DatafilePageNo}</datafile_page_no>
	<total_no_of_datafile>{$TotalNoOfDatafile}</total_no_of_datafile>
	<datafile_list>{$DatafileListXML}</datafile_list>
	{assign var='object_type' value='product'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $ProductCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $ProductCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $ProductCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $ProductCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	<bundle_rule_list>{$BundleRuleListXML}</bundle_rule_list>