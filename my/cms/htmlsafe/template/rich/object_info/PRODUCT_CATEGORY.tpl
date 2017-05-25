<product_category>
	{include file="api/object_info/OBJECT_PROTOTYPE.tpl"}
	<product_category_id>{$Object.product_category_id}</product_category_id>
	<product_category_name>{$Object.product_category_name|myxml}</product_category_name>
	<product_category_price1_range_min>{$Object.product_category_price1_range_min}</product_category_price1_range_min>
	<product_category_price1_range_max>{$Object.product_category_price1_range_max}</product_category_price1_range_max>
	<product_category_price2_range_min>{$Object.product_category_price2_range_min}</product_category_price2_range_min>
	<product_category_price2_range_max>{$Object.product_category_price2_range_max}</product_category_price2_range_max>
	<product_category_price3_range_min>{$Object.product_category_price3_range_min}</product_category_price3_range_min>
	<product_category_price3_range_max>{$Object.product_category_price3_range_max}</product_category_price3_range_max>	
	<total_no_of_products>{$NoOfProducts}</total_no_of_products>
	<page_no>{$PageNo}</page_no>
	<products_per_page>{$ProductsPerPage}</products_per_page>
	<products>{$ProductsXML}</products>
	<product_categories>{$ProductCategoriesXML}</product_categories>
	<total_no_of_objects>{$NoOfObjects}</total_no_of_objects>
	<objects>{$ObjectsXML}</objects>
	<media_page_no>{$MediaPageNo}</media_page_no>
	<total_no_of_media>{$TotalNoOfMedia}</total_no_of_media>
	<media_list>{$MediaListXML}</media_list>
	{assign var='object_type' value='product_category'}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_text_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_int_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_double_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	{section name=foo start=0 loop=20 step=1}
		{assign var='myfield' value="`$object_type`_custom_date_`$smarty.section.foo.iteration`"}
		{if $ProductCategoryCustomFieldsDef.$myfield != ''}<{$myfield}>{$Object.$myfield|myxml}</{$myfield}>{/if}
	{/section}
	<product_group_fields>
	{section name=foo start=0 loop=9 step=1}
		{assign var='myfield' value="product_category_group_field_name_`$smarty.section.foo.iteration`"}
		{if $Object.$myfield != ''}<product_group_field>{$Object.$myfield|substr:2|myxml}</product_group_field>{/if}
	{/section}
	</product_group_fields>
</product_category>